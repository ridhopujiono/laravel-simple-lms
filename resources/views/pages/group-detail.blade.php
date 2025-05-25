@extends('layouts.app')

@section('title', 'Detail Kelompok')

@section('content')
    <div class="page-heading mb-3">
        <h4>Detail - {{ $group->name }}</h4>
    </div>

    <section class="section">
        {{-- DAFTAR ANGGOTA --}}
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Daftar Anggota Kelompok</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($group->members as $index => $member)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $member->name }}</td>
                                    <td>{{ $member->email }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Belum ada anggota.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>


    {{-- SUBMISSIONS --}}
<section class="section mt-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="mb-0">Daftar Submission</h6>
            @if (Auth::user()->roles()->first()->name == 'super_admin' ||
                $group->members()->where('user_id', Auth::id())->exists()
            )
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSubmissionModal">
                <i class="bi bi-plus-lg"></i> Tambah Submission
            </button>
            @endif
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>File</th>
                            <th>Deskripsi</th>
                            <th>Dibuat Oleh</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($group->submissions as $index => $submission)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <a href="{{ asset('storage/' . $submission->file_path) }}" target="_blank">
                                        {{ basename($submission->file_path) }}
                                    </a>
                                </td>
                                <td>{{ $submission->description }}</td>
                                <td>{{ $submission->creator->name }}</td>
                                <td>{{ \Date::parse($submission->created_at)->format('d M Y H:i') }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <form action="{{ route('submissions.destroy', $submission) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus submission ini?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada submission.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <x-comments::index :model="$group" />
        </div>
    </div>
</section>

{{-- Modal Tambah Submission --}}
<div class="modal fade" id="addSubmissionModal" tabindex="-1" aria-labelledby="addSubmissionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('submissions.store') }}" method="POST" enctype="multipart/form-data" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="addSubmissionModalLabel">Tambah Submission</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="group_id" value="{{ $group->id }}">
                <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                <div class="mb-3">
                    <label for="file_path" class="form-label">File</label>
                    <input type="file" class="form-control" id="file_path" name="file_path" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>



@endsection
