@extends('layouts.app')

@section('title', 'Detail Ruang Kolaborasi')

@section('content')
    <div class="page-heading">
        <h4>Detail Ruang Kolaborasi</h4>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-body">
                <h3 class="text-center mb-2">{{ $collaboration_room->name }}</h3>
                <p class="text-center text-muted">{{ $collaboration_room->description ?? '-' }}</p>

                <hr>

                {{-- Informasi Lainnya --}}
                <div class="row">
                    <h6>Instruksi:</h6>
                    {{-- DISPLAY RICH TEXT --}}
                    <div class="col-md-12">
                        <p>{!! $collaboration_room->instruction !!}</p>
                    </div>
                </div>

                {{-- Materi --}}
                @if ($collaboration_room->file_path)
                    <h6>Soal:</h6>
                    <a href="{{ asset('storage/' . $collaboration_room->file_path) }}" target="_blank"
                        class="btn btn-outline-primary">
                        <i class="bi bi-download"></i> Unduh Soal
                    </a>
                @endif
            </div>
        </div>

    </section>

    <section class="section">
        <div class="d-flex justify-content-between">
            <h6>Grup</h6>
            {{-- Add Groups --}}
            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addGroupModal">
                <i class="bi bi-plus-lg"></i> Tambah Kelompok
            </button>
        </div>
        <div class="row">
            @foreach ($collaboration_room->groups as $group)
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between">
                            <h6><a href="{{ url('collaboration-rooms/groups/' . $group->id) }}">{{ $group->name }}</a></h6>
                            @if ($group->members->contains(Auth::user()->id) || Auth::user()->roles()->first()->name == 'super_admin')
                            <form action="{{ url('collaboration-rooms/groups/' . $group->id) }}" method="POST"
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
            @endforeach
        </div>
    </section>

    {{-- Add Group Modal --}}
    <div class="modal fade" id="addGroupModal" tabindex="-1" aria-labelledby="addGroupModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addGroupModalLabel">Tambah Kelompok</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('collaboration-rooms/store-group/' . $collaboration_room->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Kelompok</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="mb-3">
                            <label for="users" class="form-label">Pilih Anggota Kelompok</label>
                            <select class="form-select" name="user_ids[]" id="users" multiple required>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    @push('scripts')
        <!-- jQuery (harus di atas Select2) -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- Select2 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        <!-- Select2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <!-- Inisialisasi Select2 -->
        <script>
            $(document).ready(function() {
                $('#users').select2({
                    width: '100%'
                });
            });
        </script>
    @endpush
@endsection
