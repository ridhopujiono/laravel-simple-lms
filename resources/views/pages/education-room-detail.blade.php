@extends('layouts.app')

@section('title', 'Detail Ruang Edukasi')

@section('content')
    <div class="page-heading">
        <h4>Detail Ruang Edukasi</h4>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-body">
                <h3 class="text-center mb-2">{{ $education_room->name }}</h3>
                <p class="text-center text-muted">{{ $education_room->description ?? '-' }}</p>

                <hr>

                <div class="row">
                    <div class="col-md-6">
                        {{-- Video Pengantar --}}
                        @if ($education_room->introduction_video_path)
                            <h5>Video Pengantar</h5>
                            <video controls class="w-100 mb-3" style="max-height: 400px;">
                                <source src="{{ asset('storage/' . $education_room->introduction_video_path) }}"
                                    type="video/mp4">
                                Browser Anda tidak mendukung pemutar video.
                            </video>
                        @endif
                    </div>
                    <div class="col-md-6">
                        {{-- YouTube Embed --}}
                        @if ($education_room->youtube_link)
                            <h5>Video YouTube</h5>
                            <div class="ratio ratio-16x9 mb-3">
                                <iframe src="{{ Str::replace('watch?v=', 'embed/', $education_room->youtube_link) }}"
                                    title="YouTube video" allowfullscreen>
                                </iframe>
                            </div>
                        @endif
                    </div>
                </div>




                {{-- Informasi Lainnya --}}
                <div class="row">
                    <div class="col-md-6">
                        <h6>Tujuan Pembelajaran:</h6>
                        <p style="
                            white-space: pre-line;
                        ">
                            {{ $education_room->purpose ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6>Capaian Pembelajaran :</h6>
                        <p style="
    white-space: pre-line;
">{{ $education_room->target ?? '-' }}</p>
                    </div>
                </div>

                {{-- Materi --}}
                @if ($education_room->material_path)
                    <h6>Materi:</h6>
                    <a href="{{ asset('storage/' . $education_room->material_path) }}" target="_blank"
                        class="btn btn-outline-primary">
                        <i class="bi bi-download"></i> Unduh Materi
                    </a>
                @endif

                {{-- Referensi --}}
                @if ($education_room->reference_links)
                    <h6 class="mt-4">Referensi Tambahan:</h6>
                    @foreach (json_decode($education_room->reference_links, true) as $link)
                        <p><a href="{{ $link }}" target="_blank">{{ $link }}</a></p>
                    @endforeach
                @endif
                <x-comments::index :model="$education_room" />
            </div>
        </div>

        <style>
            /* Tombol bubble dengan ekor */
            #chat-toggle-btn {
                position: fixed;
                bottom: 20px;
                right: 20px;
                background-color: #228DD7;
                color: white;
                border: none;
                border-radius: 24px;
                padding: 12px 18px 12px 16px;
                font-size: 16px;
                display: flex;
                align-items: center;
                gap: 8px;
                cursor: pointer;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
                z-index: 9999;
            }

            #chat-toggle-btn::after {
                content: "";
                position: absolute;
                bottom: -10px;
                right: 20px;
                width: 0;
                height: 0;
                border-left: 10px solid transparent;
                border-right: 10px solid transparent;
                border-top: 10px solid #228DD7;
            }

            #chat-toggle-btn img {
                width: 24px;
                height: 24px;
            }

            /* Popup iframe */
            #chat-popup {
                position: fixed;
                bottom: 90px;
                right: 20px;
                width: 400px;
                height: 500px;
                background: white;
                border: 1px solid #ccc;
                border-radius: 12px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
                overflow: hidden;
                display: none;
                z-index: 9998;
                transition: all 0.3s ease-in-out;
            }

            #chat-popup iframe {
                width: 100%;
                height: 100%;
                border: none;
            }
        </style>

        <!-- Tombol -->
        <button id="chat-toggle-btn">
            <img src="https://img.icons8.com/ios/50/FFFFFF/chatgpt.png" alt="chatgpt" />
            Tanya Asisten
        </button>

        <!-- Popup -->
        <div id="chat-popup">
            <iframe id="embed-preview-iframe" loading="eager"
                src="https://embed.pickaxeproject.com/axe?id=Learning_Management_System_Assistant_8396Q&mode=embed_gold&host=beta&theme=light&opacity=100&font_header=Real+Head+Pro&size_header=30&font_body=Real+Head+Pro&size_body=16&font_labels=Real+Head+Pro&size_labels=14&font_button=Real+Head+Pro&size_button=16&c_fb=FFFFFF&c_ff=FFFFFF&c_fbd=888888&c_rb=FFFFFF&c_bb=228DD7&c_bt=FFFFFF&c_t=000000&s_ffo=100&s_rbo=100&s_bbo=100&s_f=minimalist&s_b=filled&s_t=0.5&s_to=1&s_r=2"
                width="100%" height="500px"
                class="transition hover:translate-y-[-2px] hover:shadow-[0_6px_20px_0px_rgba(0,0,0,0.15)]"
                style="border:1px solid rgba(0, 0, 0, 1);transition:.3s;border-radius:4px;max-width:700px"
                frameBorder="0"></iframe>
        </div>

        <script>
            const toggleBtn = document.getElementById('chat-toggle-btn');
            const chatPopup = document.getElementById('chat-popup');

            toggleBtn.addEventListener('click', () => {
                chatPopup.style.display = (chatPopup.style.display === 'none' || chatPopup.style.display === '') ?
                    'block' : 'none';
            });
        </script>

    </section>
@endsection
