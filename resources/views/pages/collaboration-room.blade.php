@extends('layouts.app')

@section('title', 'Ruang Kolaborasi')

@section('content')
<div class="page-heading">
    <h3>Ruang Kolaborasi</h3>
</div>

<section class="section">
    <div class="mb-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Room</h5>
        @if (Auth::user()->roles()->first()->name == 'super_admin' || Auth::user()->roles()->first()->name == 'dosen')
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createRoomModal">
            <i class="bi bi-plus-lg"></i> Tambah Room
        </button>
        @endif
    </div>

    <div class="row">
        @foreach ($rooms as $room)
        <div class="col-md-6 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h5 class="card-title mb-1"><a
                                    href="{{ route('collaboration-rooms.show', $room->id) }}">{{ $room->name }}</a>
                            </h5>

                            <small class="text-muted">{{ $room->user->name }}</small>
                        </div>
                        @if ($room->user->id == Auth::user()->id || Auth::user()->roles()->first()->name == 'super_admin')
                        <form action="{{ route('collaboration-rooms.destroy', $room->id) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus room ini?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if ($rooms->isEmpty())
    <div class="card">
        <div class="card-body">
            Belum ada room tersedia. Silakan tambahkan room baru.
        </div>
    </div>
    @endif
</section>

<!-- Modal Tambah Room -->
<div class="modal fade" id="createRoomModal" tabindex="-1" aria-labelledby="createRoomModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createRoomModalLabel">Tambah Room</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('collaboration-rooms.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Topik</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="instruction" class="form-label">Instruksi</label>
                        <textarea class="form-control" id="instruction" name="instruction" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="file_path" class="form-label">Soal</label>
                        <input type="file" class="form-control" id="file_path" name="file_path" accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.csv">
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-light-secondary me-2"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let instructionEditor;

    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('createRoomModal');
        modal.addEventListener('shown.bs.modal', function() {
            if (!instructionEditor) {
                ClassicEditor
                    .create(document.querySelector('#instruction'))
                    .then(editor => {
                        instructionEditor = editor;
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }
        });
    });
</script>
@endpush

@endsection