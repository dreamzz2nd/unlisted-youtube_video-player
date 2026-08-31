@extends('layouts.app')

@section('title', $currentLesson['title'] . ' - ' . $course['title'])

@section('content')
<div class="repo-layout">
    
    <!-- Left Column: Video Box & Markdown README Viewer -->
    <div class="main-column">
        
        <!-- Video Box Component -->
        <div class="Box">
            <div class="video-box-header">
                <div class="module-branch-pill">
                    <i class="fa-solid fa-code-branch"></i>
                    <span>module/{{ sprintf('%02d', $currentLesson['id']) }}-{{ Str::slug(Str::limit($currentLesson['title'], 30, '')) }}</span>
                </div>
                <div class="security-status-indicator">
                    <span class="security-dot"></span>
                    <span>Stream Active (DRM / Masked)</span>
                </div>
            </div>

            <!-- Protected Video Container -->
            <div class="video-container-frame" id="videoSecurityContainer">
                
                <!-- Plyr Video Embed -->
                <div class="plyr__video-embed" id="player">
                    <iframe
                        src="https://www.youtube.com/embed/{{ $youtubeId }}?origin={{ request()->getSchemeAndHttpHost() }}&amp;iv_load_policy=3&amp;modestbranding=1&amp;playsinline=1&amp;showinfo=0&amp;rel=0&amp;enablejsapi=1&amp;controls=0&amp;disablekb=1"
                        allowfullscreen
                        allow="autoplay; encrypted-media"
                        tabindex="-1"
                        title="{{ $currentLesson['title'] }}"
                    ></iframe>
                </div>

                <!-- 1. Transparent Shield Overlay (Blocks YouTube Direct Header Clicks) -->
                <div class="player-shield-overlay" id="playerShield" title="Klik untuk Play / Pause">
                    <div class="shield-top-mask"></div>
                </div>

                <!-- 2. Dynamic Floating Watermark (Anti Screen Recording) -->
                <div class="dynamic-watermark" id="dynamicWatermark">
                    <i class="fa-solid fa-shield"></i>
                    <span>{{ $currentUser['email'] }} &bull; #{{ $currentUser['id'] }}</span>
                </div>
            </div>

            <!-- Video Meta & Navigation Bar -->
            <div class="video-meta-footer">
                <div class="lesson-headline">
                    <h1>{{ $currentLesson['title'] }}</h1>
                    <div class="lesson-subtitle">
                        <span><i class="fa-regular fa-clock"></i> {{ $currentLesson['duration'] }} menit</span>
                        <span>&bull;</span>
                        <span>Instruktur: {{ $course['instructor'] }}</span>
                    </div>
                </div>
                <div class="lesson-actions-group">
                    @if($currentLesson['id'] > 1)
                        <a href="{{ route('course.watch', ['slug' => $course['slug'], 'lessonId' => $currentLesson['id'] - 1]) }}" class="btn-gh">
                            <i class="fa-solid fa-chevron-left"></i> Previous
                        </a>
                    @else
                        <button class="btn-gh" disabled style="opacity: 0.5; cursor: not-allowed;">
                            <i class="fa-solid fa-chevron-left"></i> Previous
                        </button>
                    @endif

                    @if($currentLesson['id'] < count($lessons))
                        <a href="{{ route('course.watch', ['slug' => $course['slug'], 'lessonId' => $currentLesson['id'] + 1]) }}" class="btn-gh btn-gh-primary">
                            Next Lesson <i class="fa-solid fa-chevron-right"></i>
                        </a>
                    @else
                        <button class="btn-gh btn-gh-primary" onclick="alert('Selamat! Anda telah menyelesaikan seluruh modul kursus ini.')">
                            <i class="fa-solid fa-check"></i> Complete Course
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Markdown Content / README.md Box -->
        <div class="Box">
            <div class="readme-header">
                <div class="readme-title">
                    <i class="fa-solid fa-book-bookmark"></i>
                    <span>Deskripsi</span>
                </div>
                <div style="font-size: 11px; color: var(--fg-muted);">
                    <span>2.8 KB</span> &bull; <span>Markdown</span>
                </div>
            </div>

            <!-- Tab: Overview (README) -->
            <div id="tab-overview" class="tab-pane active markdown-body">
                <div class="author-card-snippet">
                    <div class="author-avatar">
                        <i class="fa-solid fa-user-tie"></i>
                    </div>
                    <div class="author-info">
                        <h4>{{ $course['instructor'] }}</h4>
                        <p>Lead Architect & Creator of {{ $course['title'] }}</p>
                    </div>
                </div>

                <h2>Tentang Modul {{ sprintf('%02d', $currentLesson['id']) }}</h2>
                <p>{{ $currentLesson['summary'] }}</p>

                <div class="markdown-alert markdown-alert-note">
                    <div class="markdown-alert-title">
                        <i class="fa-solid fa-circle-info"></i> Catatan Arsitektur
                    </div>
                    <p>Video disimpan dengan visibilitas <code>Unlisted</code>. Frontend membungkus video menggunakan Plyr dan transparent shield overlay sehingga siswa tidak pernah melihat atau mengklik link langsung ke youtube.com.</p>
                </div>

                <h3>Poin Pembelajaran Utama</h3>
                <ul>
                    <li><strong>Zero Direct YouTube Link:</strong> Header dan logo YouTube disembunyikan menggunakan parameter <code>controls=0</code>, <code>modestbranding=1</code>, dan layer transparan.</li>
                    <li><strong>Custom Player Interface:</strong> Kontrol volume, seekbar, playback speed, dan full-screen dikelola sepenuhnya oleh Plyr.js.</li>
                    <li><strong>Dynamic Watermark:</strong> Identitas user (<code>{{ $currentUser['email'] }}</code>) berpindah posisi secara periodik di atas video untuk mencegah pembajakan via rekaman layar.</li>
                    <li><strong>Anti-Inspect & Klik Kanan:</strong> Mencegah akses cepat ke URL embed melalui inspect element atau shortcut browser.</li>
                </ul>

                <div class="markdown-alert markdown-alert-tip">
                    <div class="markdown-alert-title">
                        <i class="fa-solid fa-lightbulb"></i> Best Practice Produksi
                    </div>
                    <p>Kombinasikan teknik embedding ini dengan enkripsi HLS / signed URL pada server video untuk proteksi tingkat lanjut di platform berskala besar.</p>
                </div>
            </div>

            <!-- Tab: Security Info -->
            <div id="tab-security" class="tab-pane markdown-body">
                <h2>Spesifikasi Proteksi Video</h2>
                <p>Daftar lapisan keamanan yang diterapkan pada player modul ini:</p>

                <table class="markdown-table">
                    <thead>
                        <tr>
                            <th>Lapisan Keamanan</th>
                            <th>Mekanisme Kerja</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>1. YouTube Unlisted Mode</strong></td>
                            <td>Video tidak terindeks publik di YouTube search / recommendation</td>
                            <td><span style="color: var(--success-fg); font-weight: 600;">✓ Active</span></td>
                        </tr>
                        <tr>
                            <td><strong>2. Plyr UI Masking</strong></td>
                            <td>UI default YouTube dihilangkan dan diganti dengan UI player yang bersih</td>
                            <td><span style="color: var(--success-fg); font-weight: 600;">✓ Active</span></td>
                        </tr>
                        <tr>
                            <td><strong>3. Transparent Click Shield</strong></td>
                            <td>Menghalangi klik user pada area judul, logo, atau tombol share YouTube</td>
                            <td><span style="color: var(--success-fg); font-weight: 600;">✓ Active</span></td>
                        </tr>
                        <tr>
                            <td><strong>4. Dynamic Watermark</strong></td>
                            <td>Watermark email user bergerak periodik untuk mencegah screen recording</td>
                            <td><span style="color: var(--success-fg); font-weight: 600;">✓ Active</span></td>
                        </tr>
                        <tr>
                            <td><strong>5. Anti-Context & Devtools Guard</strong></td>
                            <td>Mencegah klik kanan pada area video dan shortcut F12 / Ctrl+U / Ctrl+Shift+I</td>
                            <td><span style="color: var(--success-fg); font-weight: 600;">✓ Active</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Tab: Resources -->
            <div id="tab-resources" class="tab-pane">
                <div class="resource-row">
                    <div class="resource-left">
                        <i class="fa-solid fa-file-zipper"></i>
                        <div>
                            <div class="resource-title">laravel-elearning-module-{{ $currentLesson['id'] }}.zip</div>
                            <div class="resource-meta">ZIP Archive &bull; 2.4 MB &bull; Source Code Modul {{ $currentLesson['id'] }}</div>
                        </div>
                    </div>
                    <button class="btn-gh" onclick="alert('Mengunduh source code...')">
                        <i class="fa-solid fa-download"></i> Download
                    </button>
                </div>
                <div class="resource-row">
                    <div class="resource-left">
                        <i class="fa-solid fa-file-pdf"></i>
                        <div>
                            <div class="resource-title">video-protection-cheatsheet.pdf</div>
                            <div class="resource-meta">PDF Document &bull; 850 KB &bull; Panduan Parameter YouTube</div>
                        </div>
                    </div>
                    <button class="btn-gh" onclick="alert('Mengunduh PDF...')">
                        <i class="fa-solid fa-download"></i> Download
                    </button>
                </div>
            </div>

            <!-- Tab: Discussion -->
            <div id="tab-discussion" class="tab-pane" style="padding: 16px;">
                <div class="timeline-comment">
                    <div class="timeline-comment-header">
                        <div>
                            <span class="timeline-author">rizky-ramadhan</span> commented 2 hours ago
                        </div>
                        <span class="timeline-badge">Student</span>
                    </div>
                    <div class="timeline-comment-body">
                        Penjelasannya sangat rapi dan mudah dipahami. Tampilan barunya jauh lebih bersih dan profesional seperti GitHub!
                    </div>
                </div>

                <div class="discussion-input-box">
                    <textarea class="discussion-textarea" placeholder="Tinggalkan komentar atau pertanyaan mengenai materi ini..."></textarea>
                    <div class="discussion-actions">
                        <button class="btn-gh btn-gh-primary" onclick="alert('Komentar berhasil dikirim!')">
                            Comment
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Right Column: GitHub Sidebar (About & Curriculum File Tree) -->
    <aside class="sidebar-column">
        
        <!-- About Section -->
        <div class="sidebar-section">
            <h3 class="sidebar-title">About</h3>
            <p class="sidebar-desc">
                Kursus komprehensif full-stack development dengan arsitektur secure video streaming, Laravel controller parsing, dan Plyr masking.
            </p>
            
            <div class="tag-list">
                <a href="#" class="topic-tag">laravel-12</a>
                <a href="#" class="topic-tag">video-protection</a>
                <a href="#" class="topic-tag">plyr-js</a>
                <a href="#" class="topic-tag">fullstack</a>
                <a href="#" class="topic-tag">elearning</a>
            </div>

            <div class="progress-container">
                <div class="progress-header">
                    <span>Learning Progress</span>
                    <span style="font-weight: 600; color: var(--fg-default);">{{ $course['progress'] }}%</span>
                </div>
                <div class="progress-track">
                    <div class="progress-fill" style="width: {{ $course['progress'] }}%;"></div>
                </div>
            </div>

            <ul class="sidebar-meta-list">
                <li><i class="fa-regular fa-circle-play"></i> {{ count($lessons) }} Modul Pembelajaran</li>
                <li><i class="fa-regular fa-clock"></i> Total Durasi: 41m 43s</li>
                <!-- <li><i class="fa-solid fa-scale-balanced"></i> MIT License (Educational)</li> -->
                <li><i class="fa-regular fa-calendar"></i> Updated August 2026</li>
            </ul>
        </div>

        <!-- Curriculum File-Tree Section -->
        <div class="sidebar-section">
            <h3 class="sidebar-title">Course Modules</h3>
            <div class="curriculum-box">
                @foreach($lessons as $lesson)
                    <a 
                        href="{{ route('course.watch', ['slug' => $course['slug'], 'lessonId' => $lesson['id']]) }}"
                        class="curriculum-item {{ $lesson['id'] == $currentLesson['id'] ? 'active' : '' }}"
                    >
                        <div class="curriculum-icon {{ $lesson['completed'] ? 'done' : ($lesson['id'] == $currentLesson['id'] ? 'playing' : 'pending') }}">
                            @if($lesson['completed'])
                                <i class="fa-solid fa-circle-check"></i>
                            @elseif($lesson['id'] == $currentLesson['id'])
                                <i class="fa-solid fa-circle-play"></i>
                            @else
                                <i class="fa-regular fa-circle-play"></i>
                            @endif
                        </div>
                        <div class="curriculum-text">
                            <div class="curriculum-title">{{ $lesson['title'] }}</div>
                            <div class="curriculum-meta">
                                <span>{{ $lesson['duration'] }}</span>
                                @if($lesson['id'] == $currentLesson['id'])
                                    <span class="curriculum-active-badge">Playing</span>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

    </aside>

</div>

<!-- Flash Alert / Toast Keamanan -->
<div id="securityNotice" class="flash-toast hidden">
    <i class="fa-solid fa-triangle-exclamation"></i>
    <span>Fitur klik kanan dinonaktifkan untuk melindungi hak cipta video kursus.</span>
</div>
@endsection
