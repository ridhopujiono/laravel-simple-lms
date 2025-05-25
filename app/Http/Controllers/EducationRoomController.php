<?php

namespace App\Http\Controllers;

use App\Models\EducationRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EducationRoomController extends Controller
{
    public function index()
    {
        $rooms = EducationRoom::with('user')->get();
        return view('pages.education-room', compact('rooms'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'introduction_video_path' => 'nullable|file|mimes:mp4,avi,mkv',
            'purpose' => 'nullable|string',
            'target' => 'nullable|string',
            'material_path' => 'nullable',
            'youtube_link' => 'nullable|url',
            'reference_links' => 'nullable|string',
        ]);


        // Upload video
        if ($request->hasFile('introduction_video_path')) {
            $file = $request->file('introduction_video_path');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $data['introduction_video_path'] = $file->storeAs('videos', $filename, 'public');
        }

        // Upload materi
        if ($request->hasFile('material_path')) {
            $file = $request->file('material_path');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $data['material_path'] = $file->storeAs('materials', $filename, 'public');
        }

        // Convert string reference links jadi JSON array
        if (!empty($data['reference_links'])) {
            $data['reference_links'] = json_encode(array_map('trim', explode(',', $data['reference_links'])));
        }

        EducationRoom::create([...$data, 'created_by' => Auth::id()]);

        return redirect()->back()->with('success', 'Room berhasil ditambahkan.');
    }


    public function show(EducationRoom $education_room)
    {
        return view('pages.education-room-detail', compact('education_room'));
    }
    public function update(Request $request, EducationRoom $education_room)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'introduction_video_path' => 'nullable|file|mimes:mp4,avi,mkv',
            'purpose' => 'nullable|string',
            'target' => 'nullable|string',
            'material_path' => 'nullable|file|mimes:pptx',
            'youtube_link' => 'nullable|url',
            'reference_links' => 'nullable|string',
        ]);

        // Upload ulang video jika ada
        if ($request->hasFile('introduction_video_path')) {
            $file = $request->file('introduction_video_path');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $data['introduction_video_path'] = $file->storeAs('videos', $filename, 'public');
        }

        // Upload ulang materi jika ada
        if ($request->hasFile('material_path')) {
            $file = $request->file('material_path');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $data['material_path'] = $file->storeAs('materials', $filename, 'public');
        }

        // Ubah referensi dari string ke array JSON
        if (!empty($data['reference_links'])) {
            $data['reference_links'] = json_encode(array_map('trim', explode(',', $data['reference_links'])));
        }

        $education_room->update($data);

        return redirect()->back()->with('success', 'Room berhasil diperbarui.');
    }


    public function destroy(EducationRoom $education_room)
    {
        $education_room->delete();
        return redirect()->route('education-rooms.index')->with('success', 'Room berhasil dihapus');
    }
}
