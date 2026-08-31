@extends('layouts.app')

@section('title', $currentLesson['title'] . ' - ' . $course['title'])

@section('content')
<div class="classroom-layout">
    
    <!-- Left Column: Video Theater & Lesson Details -->
    <div class="player-column">
        
        <!-- Video Wrapper with Protection Layers -->
        <div class="video-theater-card">
            <div class="video-security-container" id="videoSecurityContainer">
                
                <!-- Plyr Embedded YouTube Player -->
                <div class="plyr__video-embed" id="player">
                    <iframe
                        src="https://www.youtube.com/embed/{{ $youtubeId }}?origin={{ request()->getSchemeAndHttpHost() }}&amp;iv_load_policy=3&amp;modestbranding=1&amp;playsinline=1&amp;showinfo=0&amp;rel=0&amp;enablejsapi=1&amp;controls=0&amp;disablekb=1"
                        allowfullscreen
                        allow="autoplay; encrypted-media"
                        tabindex="-1"
                        title="{{ $currentLesson['title'] }}"
                    ></iframe>
                </div>

                <!-- 1. Transparent Shield Overlay (Blocks Direct YouTube Header/Logo Clicks) -->
                <div class="player-shield-overlay" id="playerShield" title="Klik untuk Play/Pause">
                    <div class="shield-top-mask"></div>
                    <div class="shield-watermark-mask"></div>
                </div>

                <!-- 2. Dynamic Floating Anti-Recording Watermark -->
                <div class="dynamic-watermark" id="dynamicWatermark">
                    <i class="fa-solid fa-shield"></i>
                    <span>{{ $currentUser['email'] }} &bull; ID: #{{ $currentUser['id'] }}</span>
                </div>

                <!-- 3. Security Badge Status Indicator -->
                <div class="security-floating-pill">
                    <span class="security-dot"></span>
                    <span>Protected E-Learning Stream</span>
                </div>
            </div>

            <!-- Video Header / Lesson Meta Bar -->
            <div class="lesson-meta-bar">
                <div class="lesson-title-area">
                    <div class="lesson-breadcrumbs">
                        <span class="text-indigo-400 font-semibold">{{ $course['title'] }}</span>
                        <span class="divider">/</span>
                        <span class="text-slate-400">Modul {{ $currentLesson['id'] }}</span>
                    </div>
                    <h1 class="lesson-main-title">{{ $currentLesson['title'] }}</h1>
                </div>

                <!-- Navigation Action Buttons -->
                <div class="lesson-nav-actions">
                    @if($currentLesson['id'] > 1)
                        <a href="{{ route('course.watch', ['slug' => $course['slug'], 'lessonId' => $currentLesson['id'] - 1]) }}" class="btn-nav btn-prev">
                            <i class="fa-solid fa-arrow-left"></i>
                            <span>Sebelumnya</span>
                        </a>
                    @endif

                    @if($currentLesson['id'] < count($lessons))
                        <a href="{{ route('course.watch', ['slug' => $course['slug'], 'lessonId' => $currentLesson['id'] + 1]) }}" class="btn-nav btn-next">
                            <span>Materi Selanjutnya</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    @else
                        <button class="btn-nav btn-complete">
                            <i class="fa-solid fa-circle-check"></i>
                            <span>Selesaikan Kursus</span>
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Course Content Tabs & Instructor Card -->
        <div class="lesson-details-card">
            <div class="tabs-header">
                <button class="tab-button active" onclick="switchTab(event, 'tab-overview')">
                    <i class="fa-solid fa-book-open"></i> Ringkasan Materi
                </button>
                <button class="tab-button" onclick="switchTab(event, 'tab-security')">
                    <i class="fa-solid fa-shield-virus"></i> Info Proteksi Video
                </button>
                <button class="tab-button" onclick="switchTab(event, 'tab-resources')">
                    <i class="fa-solid fa-paperclip"></i> Lampiran & File
                </button>
                <button class="tab-button" onclick="switchTab(event, 'tab-discussion')">
                    <i class="fa-solid fa-comments"></i> Tanya Jawab (3)
                </button>
            </div>

            <div class="tabs-body">
                <!-- Tab: Overview -->
                <div id="tab-overview" class="tab-pane active">
                    <div class="instructor-snippet">
                        <div class="instructor-avatar">
                            <i class="fa-solid fa-chalkboard-user"></i>
                        </div>
                        <div class="instructor-info">
                            <h4>{{ $course['instructor'] }}</h4>
                            <p>Instruktur & Course Lead</p>
                        </div>
                    </div>

                    <div class="lesson-description">
                        <h3>Tentang Modul Ini</h3>
                        <p>{{ $currentLesson['summary'] }}</p>
                        <div class="key-points-box">
                            <h4><i class="fa-solid fa-lightbulb text-amber-400"></i> Poin Pembelajaran Utama:</h4>
                            <ul>
                                <li>Penyembunyian kontrol bawaan YouTube menggunakan parameter <code>controls=0</code> dan <code>modestbranding=1</code>.</li>
                                <li>Pemasangan <code>Shield Overlay</code> transparan yang mengintersep klik user pada area judul/logo YouTube.</li>
                                <li>Watermark anti-screen recording dinamis yang bergerak secara periodik.</li>
                                <li>Pencegahan shortcut developer tools (F12, Inspect Element, Ctrl+U).</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Tab: Security Info -->
                <div id="tab-security" class="tab-pane">
                    <div class="security-explanation-grid">
                        <div class="security-card">
                            <div class="icon-wrap text-emerald-400"><i class="fa-solid fa-globe"></i></div>
                            <h4>1. YouTube Unlisted + Zero Direct Link</h4>
                            <p>Video disimpan sebagai Unlisted. Siswa tidak diberikan link langsung ke youtube.com.</p>
                        </div>
                        <div class="security-card">
                            <div class="icon-wrap text-cyan-400"><i class="fa-solid fa-layer-group"></i></div>
                            <h4>2. Plyr UI Masking</h4>
                            <p>Seluruh antarmuka kontrol diganti menggunakan Plyr.js bernuansa gelap dan premium.</p>
                        </div>
                        <div class="security-card">
                            <div class="icon-wrap text-indigo-400"><i class="fa-solid fa-shield-halved"></i></div>
                            <h4>3. Transparent Click Shield</h4>
                            <p>Mencegah klik pada logo YouTube atau tombol "Watch on YouTube".</p>
                        </div>
                        <div class="security-card">
                            <div class="icon-wrap text-amber-400"><i class="fa-solid fa-id-badge"></i></div>
                            <h4>4. Dynamic Watermark</h4>
                            <p>Identitas user (Email: <code>{{ $currentUser['email'] }}</code>) ditempel di video untuk mencegah pembajakan via rekaman layar.</p>
                        </div>
                    </div>
                </div>

                <!-- Tab: Resources -->
                <div id="tab-resources" class="tab-pane">
                    <div class="resource-item">
                        <div class="res-icon"><i class="fa-solid fa-file-code"></i></div>
                        <div class="res-details">
                            <h5>Source Code Modul (GitHub Repository)</h5>
                            <span>File ZIP &bull; 2.4 MB</span>
                        </div>
                        <button class="btn-download"><i class="fa-solid fa-download"></i> Unduh</button>
                    </div>
                    <div class="resource-item">
                        <div class="res-icon"><i class="fa-solid fa-file-pdf"></i></div>
                        <div class="res-details">
                            <h5>Cheatsheet Proteksi Video & Streaming</h5>
                            <span>PDF Document &bull; 850 KB</span>
                        </div>
                        <button class="btn-download"><i class="fa-solid fa-download"></i> Unduh</button>
                    </div>
                </div>

                <!-- Tab: Discussion -->
                <div id="tab-discussion" class="tab-pane">
                    <div class="discussion-container">
                        <div class="comment-box">
                            <input type="text" placeholder="Tulis pertanyaan seputar materi ini..." class="comment-input" />
                            <button class="btn-send-comment"><i class="fa-solid fa-paper-plane"></i> Kirim</button>
                        </div>
                        <div class="comment-list">
                            <div class="single-comment">
                                <div class="c-avatar"><i class="fa-solid fa-user"></i></div>
                                <div class="c-body">
                                    <div class="c-header">
                                        <span class="c-author">Rizky Ramadhan</span>
                                        <span class="c-time">2 jam yang lalu</span>
                                    </div>
                                    <p>Penjelasannya sangat jelas! Shield overlay-nya bekerja sangat baik mencegah klik YouTube.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Right Column: Course Curriculum Sidebar -->
    <aside class="curriculum-column">
        <div class="curriculum-card">
            <div class="curriculum-header">
                <div class="cur-title-row">
                    <h3>Daftar Materi Kursus</h3>
                    <span class="badge-count">{{ count($lessons) }} Modul</span>
                </div>
                <div class="course-progress-box">
                    <div class="progress-info">
                        <span>Progress Belajar</span>
                        <span class="font-bold text-indigo-400">{{ $course['progress'] }}%</span>
                    </div>
                    <div class="progress-bar-bg">
                        <div class="progress-bar-fill" style="width: {{ $course['progress'] }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Lessons List -->
            <div class="curriculum-list">
                @foreach($lessons as $lesson)
                    <a 
                        href="{{ route('course.watch', ['slug' => $course['slug'], 'lessonId' => $lesson['id']]) }}"
                        class="lesson-item {{ $lesson['id'] == $currentLesson['id'] ? 'active-lesson' : '' }} {{ $lesson['completed'] ? 'completed-lesson' : '' }}"
                    >
                        <div class="lesson-status-icon">
                            @if($lesson['completed'])
                                <i class="fa-solid fa-circle-check text-emerald-400"></i>
                            @elseif($lesson['id'] == $currentLesson['id'])
                                <i class="fa-solid fa-circle-play text-indigo-400 animate-pulse"></i>
                            @else
                                <i class="fa-regular fa-circle-play text-slate-500"></i>
                            @endif
                        </div>
                        <div class="lesson-info">
                            <h4 class="lesson-item-title">{{ $lesson['title'] }}</h4>
                            <div class="lesson-item-meta">
                                <span><i class="fa-regular fa-clock"></i> {{ $lesson['duration'] }}</span>
                                @if($lesson['id'] == $currentLesson['id'])
                                    <span class="now-playing-tag">Sedang Diputar</span>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </aside>

</div>

<!-- Right Click & Inspect Notice Modal/Toast -->
<div id="securityNotice" class="security-toast hidden">
    <i class="fa-solid fa-triangle-exclamation text-amber-400"></i>
    <span>Fitur klik kanan & download dinonaktifkan untuk melindungi hak cipta video kursus.</span>
</div>
@endsection
