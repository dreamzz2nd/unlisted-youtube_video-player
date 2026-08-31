<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Tampilkan halaman pemutar video e-learning
     */
    public function watch(Request $request, $slug = 'mastering-web-development', $lessonId = 1)
    {
        // Contoh data kurikulum kursus
        $course = [
            'title' => 'Mastering Full-Stack Web Development 2026',
            'slug' => 'mastering-web-development',
            'instructor' => 'Alex Pratama (Senior Software Architect)',
            'progress' => 35,
        ];

        // Daftar materi / video
        $lessons = [
            [
                'id' => 1,
                'title' => '01. Pengenalan Arsitektur E-Learning & Proteksi Video',
                'duration' => '0:58',
                'video_url' => 'https://youtube.com/shorts/gN75MH5Ej4c?feature=share',
                'completed' => true,
                'summary' => 'Pada modul pertama ini, kita mempelajari bagaimana sistem e-learning mengamankan video menggunakan teknik custom masking player dan dynamic watermarking.',
            ],
            [
                'id' => 2,
                'title' => '02. Setup Routing dan Controller di Laravel 11/12',
                'duration' => '12:40',
                'video_url' => 'https://youtube.com/shorts/gN75MH5Ej4c',
                'completed' => false,
                'summary' => 'Membangun controller yang bertugas mem-parsing URL YouTube (reguler maupun Shorts) dan mengirimkan parameter player yang aman.',
            ],
            [
                'id' => 3,
                'title' => '03. Implementasi Custom Plyr Player & Shield Overlay',
                'duration' => '18:15',
                'video_url' => 'https://youtube.com/shorts/gN75MH5Ej4c',
                'completed' => false,
                'summary' => 'Membuat lapisan proteksi transparan untuk mencegah pengguna mengklik judul atau logo bawaan YouTube.',
            ],
            [
                'id' => 4,
                'title' => '04. Anti-Screen Recording dengan Dynamic User Watermark',
                'duration' => '09:50',
                'video_url' => 'https://youtube.com/shorts/gN75MH5Ej4c',
                'completed' => false,
                'summary' => 'Menambahkan watermark bergerak yang memuat identitas (email & ID) siswa yang sedang login.',
            ],
        ];

        // Ambil data materi saat ini
        $currentLesson = collect($lessons)->firstWhere('id', (int) $lessonId) ?? $lessons[0];

        // Ekstraksi Video ID dari URL YouTube (mendukung Shorts, youtu.be, dan watch?v=)
        $youtubeId = $this->extractYoutubeId($currentLesson['video_url']);

        // Data user yang sedang login (untuk dynamic watermark)
        // Di aplikasi nyata bisa menggunakan: auth()->user()
        $currentUser = [
            'id' => 84920,
            'name' => 'Baim Developer',
            'email' => 'baim@elearning.test',
        ];

        return view('course.watch', compact('course', 'lessons', 'currentLesson', 'youtubeId', 'currentUser'));
    }

    /**
     * Helper untuk mengekstrak YouTube Video ID dari berbagai variasi format URL
     * Contoh yang didukung:
     * - https://youtube.com/shorts/gN75MH5Ej4c?feature=share
     * - https://www.youtube.com/watch?v=gN75MH5Ej4c
     * - https://youtu.be/gN75MH5Ej4c
     * - https://www.youtube.com/embed/gN75MH5Ej4c
     */
    private function extractYoutubeId(string $url): ?string
    {
        $patterns = [
            '/youtube\.com\/shorts\/([a-zA-Z0-9_-]{11})/',       // Format Shorts
            '/youtu\.be\/([a-zA-Z0-9_-]{11})/',                 // Format pendek youtu.be
            '/youtube\.com\/watch\?v=([a-zA-Z0-9_-]{11})/',     // Format standar watch?v=
            '/youtube\.com\/embed\/([a-zA-Z0-9_-]{11})/',       // Format embed
            '/youtube\.com\/v\/([a-zA-Z0-9_-]{11})/',           // Format v/
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                return $matches[1];
            }
        }

        // Jika URL hanya berupa ID 11 karakter
        if (preg_match('/^[a-zA-Z0-9_-]{11}$/', $url)) {
            return $url;
        }

        return null;
    }
}
