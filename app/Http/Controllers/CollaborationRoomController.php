<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Room as CollaborationRoom;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CollaborationRoomController extends Controller
{
    public function index()
    {
        $rooms = CollaborationRoom::with(['user'])->get();
        return view('pages.collaboration-room', compact('rooms'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'instruction' => 'nullable|string',
            'file_path' => 'nullable',
        ]);

        // Upload materi
        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $data['file_path'] = $file->storeAs('files', $filename, 'public');
        }

        CollaborationRoom::create([...$data, 'created_by' => Auth::id()]);

        return redirect()->back()->with('success', 'Room berhasil ditambahkan.');
    }

    public function update(Request $request, CollaborationRoom $collaboration_room)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'instruction' => 'nullable|string',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,csv',
        ]);

        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $data['file_path'] = $file->storeAs('collaboration-files', $filename, 'public');
        }

        $collaboration_room->update($data);

        return redirect()->back()->with('success', 'Room berhasil diperbarui.');
    }

    public function show(CollaborationRoom $collaboration_room)
    {
        $users = User::all();
        return view('pages.collaboration-room-detail', compact('collaboration_room', 'users'));
    }

    public function destroy(CollaborationRoom $collaboration_room)
    {
        foreach ($collaboration_room->groups as $group) {
            // Hapus pivot relasi ke users
            $group->members()->detach();

            // Hapus submissions
            $group->submissions()->delete();

            DB::table('comments')
                ->where('commentable_type', Group::class)
                ->where('commentable_id', $group->id)->delete();
            // Hapus group
            $group->delete();
        }

        // Hapus room
        $collaboration_room->delete();

        return redirect()->route('collaboration-rooms.index')->with('success', 'Room berhasil dihapus');
    }


    public function storeGroup(Request $request, CollaborationRoom $collaboration_room)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'user_ids' => 'required|array',
        ]);

        // Buat group baru di dalam room yang dimaksud
        $group = $collaboration_room->groups()->create([
            'name' => $data['name'],
        ]);

        // Simpan relasi user ke tabel pivot group_user
        $group->members()->sync($data['user_ids']);

        return redirect()->back()->with('success', 'Kelompok berhasil ditambahkan.');
    }

    public function showGroup(Group $group)
    {
        $group->load('members');
        $group->load('submissions');
        $group->load('submissions.creator');
        $group->load('user');
        return view('pages.group-detail', compact('group'));
    }

    public function destroyGroup(Group $group)
    {
        // Hapus relasi dari tabel pivot
        $group->members()->detach();
        $group->submissions()->delete();

        // Hapus group-nya
        $group->delete();

        return redirect()->back()->with('success', 'Kelompok berhasil dihapus.');
    }
}
