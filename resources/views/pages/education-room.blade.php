@extends('layouts.app')

@section('title', 'Ruang Edukasi')

@section('content')
    <div class="page-heading">
        <h3>Ruang Edukasi</h3>
    </div>

    <section class="section">
        @if (Auth::user()->roles()->first()->name == 'super_admin' || Auth::user()->roles()->first()->name == 'dosen')
            <div class="mb-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Daftar Room</h5>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createRoomModal">
                    <i class="bi bi-plus-lg"></i> Tambah Room
                </button>
            </div>
        @endif

        <div class="row">
            @foreach ($rooms as $room)
                <div class="col-md-6 col-xl-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h5 class="card-title mb-1"><a
                                            href="{{ route('education-rooms.show', $room->id) }}">{{ $room->name }}</a>
                                    </h5>

                                    <small class="text-muted">{{ $room->user->name }}</small>
                                </div>
                                @if ($room->user->id == Auth::user()->id || Auth::user()->roles()->first()->name == 'super_admin')
                                    <div class="d-flex gap-1">
                                        <button type="button" class="btn btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#editRoomModal{{ $room->id }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <form action="{{ route('education-rooms.destroy', $room->id) }}" method="POST"
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
                    <form action="{{ route('education-rooms.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="introduction_video_path" class="form-label">Video Pengantar (Upload)</label>
                            <input type="file" class="form-control" id="introduction_video_path"
                                name="introduction_video_path" accept="video/*">
                        </div>

                        <div class="mb-3">
                            <label for="purpose" class="form-label">Tujuan Pembelajaran</label>
                            <textarea class="form-control" id="purpose" name="purpose" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="target" class="form-label">Capaian Pembelajaran</label>
                            <textarea class="form-control" id="target" name="target" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="material_path" class="form-label">Materi (Upload PPTX)</label>
                            <input type="file" class="form-control" id="material_path" name="material_path"
                                accept=".pptx">
                        </div>

                        <div class="mb-3">
                            <label for="youtube_link" class="form-label">Link YouTube</label>
                            <input type="url" class="form-control" id="youtube_link" name="youtube_link"
                                placeholder="https://youtube.com/...">
                        </div>

                        <div class="mb-3">
                            <label for="reference_links" class="form-label">Referensi (boleh lebih dari satu, pisahkan
                                dengan koma)</label>
                            <textarea class="form-control" id="reference_links" name="reference_links" rows="2"
                                placeholder="https://link1.com, https://link2.com"></textarea>
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
        <div class="modal fade" id="editRoomModal{{ $room->id }}" tabindex="-1"
            aria-labelledby="editRoomModalLabel{{ $room->id }}" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editRoomModalLabel{{ $room->id }}">Edit Room - {{ $room->name }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('education-rooms.update', $room->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name{{ $room->id }}" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="name{{ $room->id }}" name="name"
                                    value="{{ $room->name }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="description{{ $room->id }}" class="form-label">Deskripsi</label>
                                <textarea class="form-control" id="description{{ $room->id }}" name="description" rows="3">{{ $room->description }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="introduction_video_path{{ $room->id }}" class="form-label">Video
                                    Pengantar (Upload)</label>
                                <input type="file" class="form-control"
                                    id="introduction_video_path{{ $room->id }}" name="introduction_video_path"
                                    accept="video/*">
                                @if ($room->introduction_video_path)
                                    <small class="text-muted">File saat ini:
                                        <a href="{{ asset('storage/' . $room->introduction_video_path) }}" target="_blank"
                                            >Lihat</a>
                                    </small>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="purpose{{ $room->id }}" class="form-label">Tujuan Pembelajaran</label>
                                <textarea class="form-control" id="purpose{{ $room->id }}" name="purpose" rows="3">{{ $room->purpose }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="target{{ $room->id }}" class="form-label">Capaian Pembelajaran</label>
                                <textarea class="form-control" id="target{{ $room->id }}" name="target" rows="3">{{ $room->target }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="material_path{{ $room->id }}" class="form-label">Materi (Upload
                                    PPTX)</label>
                                <input type="file" class="form-control" id="material_path{{ $room->id }}"
                                    name="material_path" accept=".pptx">
                                @if ($room->material_path)
                                    <small class="text-muted">File saat ini:

                                        <a href="{{ asset('storage/' . $room->material_path) }}" target="_blank">Lihat</a>
                                    </small>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="youtube_link{{ $room->id }}" class="form-label">Link YouTube</label>
                                <input type="url" class="form-control" id="youtube_link{{ $room->id }}"
                                    name="youtube_link" value="{{ $room->youtube_link }}">
                            </div>
                            <div class="mb-3">
                                <label for="reference_links{{ $room->id }}" class="form-label">Referensi</label>
                                <textarea class="form-control" id="reference_links{{ $room->id }}" name="reference_links" rows="2">{{ implode(', ', json_decode($room->reference_links)) }}</textarea>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-light-secondary me-2"
                                    data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach


@endsection
