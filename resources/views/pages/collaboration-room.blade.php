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
                        <div class="d-flex gap-1">
                            <!-- Tombol Edit -->
                            <button type="button" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#editRoomModal{{ $room->id }}">
                                <i class="bi bi-pencil-square"></i>
                            </button>

                            <!-- Tombol Hapus -->
                            <form action="{{ route('collaboration-rooms.destroy', $room->id) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus room ini?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm text-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
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

@foreach ($rooms as $room)
<!-- Modal Edit Room -->
<div class="modal fade" id="editRoomModal{{ $room->id }}" tabindex="-1" aria-labelledby="editRoomModalLabel{{ $room->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRoomModalLabel{{ $room->id }}">Edit Room - {{ $room->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('collaboration-rooms.update', $room->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name{{ $room->id }}" class="form-label">Topik</label>
                        <input type="text" class="form-control" id="name{{ $room->id }}" name="name" value="{{ $room->name }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="description{{ $room->id }}" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="description{{ $room->id }}" name="description" rows="3">{{ $room->description }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="instruction{{ $room->id }}" class="form-label">Instruksi</label>
                        <textarea class="form-control instruction-editor" id="instruction{{ $room->id }}" name="instruction" rows="3">{{ $room->instruction }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="file_path{{ $room->id }}" class="form-label">Soal</label>
                        <input type="file" class="form-control" id="file_path{{ $room->id }}" name="file_path" accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.csv">
                        @if ($room->file_path)
                        <small class="text-muted">File saat ini:

                            <a href="{{ '/storage/'. $room->file_path }}" target="_blank">Lihat</a>
                        </small>
                        @endif
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-light-secondary me-2" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach


@push('scripts')
<script>
    let editorInstances = {};

    document.addEventListener('DOMContentLoaded', function () {
        // Tambahkan editor untuk "Tambah Room"
        const modalCreate = document.getElementById('createRoomModal');
        modalCreate.addEventListener('shown.bs.modal', function () {
            if (!editorInstances['create']) {
                ClassicEditor
                    .create(document.querySelector('#instruction'))
                    .then(editor => {
                        editorInstances['create'] = editor;
                    })
                    .catch(error => console.error(error));
            }
        });

        // Tambahkan editor untuk tiap modal edit
        @foreach ($rooms as $room)
        const modalEdit{{ $room->id }} = document.getElementById('editRoomModal{{ $room->id }}');
        modalEdit{{ $room->id }}.addEventListener('shown.bs.modal', function () {
            const textareaId = '#instruction{{ $room->id }}';
            if (!editorInstances['{{ $room->id }}']) {
                ClassicEditor
                    .create(document.querySelector(textareaId))
                    .then(editor => {
                        editorInstances['{{ $room->id }}'] = editor;
                    })
                    .catch(error => console.error(error));
            }
        });
        @endforeach
    });
</script>
@endpush


@endsection