<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Submission;
use Illuminate\Support\Facades\Storage;

class SubmissionController extends Controller
{

    public function store(Request $request)
    {
        $data = $request->validate([
            'group_id' => 'required|exists:groups,id',
            'user_id' => 'required|exists:users,id',
            'file_path' => 'required|file|max:2048',
            'description' => 'nullable|string',
        ]);

        $data['user_id'] = $data['user_id'];
        $data['file_path'] = $request->file('file_path')->store('submissions', 'public');

        Submission::create($data);

        return redirect()->back()->with('success', 'Submission berhasil ditambahkan.');
    }

    public function destroy(Submission $submission)
    {
        // Delete file
        Storage::delete($submission->file_path);
        $submission->delete();
        return redirect()->back()->with('success', 'Submission berhasil dihapus.');
    }
}
