<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 tracking-tight">
                    Tambah Artikel Gamepedia
                </h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Bagikan pengetahuan game-mu dengan komunitas
                </p>
            </div>
            <a href="{{ route('articles.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 font-medium rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors duration-200">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-2xl overflow-hidden border border-gray-200 dark:border-gray-700">
                <div class="p-2 bg-gradient-to-r from-indigo-500 to-purple-600">
                    <div class="p-4 bg-white dark:bg-gray-800 rounded-xl">
                        <form method="POST" action="{{ route('articles.store') }}" class="space-y-6">
                            @csrf

                            {{-- Judul Artikel --}}
                            <div class="space-y-2">
                                <div class="flex items-center gap-2">
                                    <div class="p-2 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg">
                                        <i class="fas fa-heading text-indigo-600 dark:text-indigo-400"></i>
                                    </div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                        Judul Artikel
                                    </label>
                                </div>
                                <input type="text" name="title"
                                       value="{{ old('title') }}"
                                       placeholder="Contoh: Tips Menang di Valorant dengan Strategi Teamwork"
                                       class="mt-1 block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 
                                              rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                                              dark:bg-gray-700 dark:text-gray-200 dark:focus:ring-indigo-400 
                                              transition duration-200"
                                       autofocus>
                                @error('title')
                                    <div class="flex items-center gap-2 text-red-600 dark:text-red-400 text-sm mt-1">
                                        <i class="fas fa-exclamation-circle"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    Buat judul yang menarik dan deskriptif tentang artikel game-mu
                                </p>
                            </div>

                            {{-- Nama Game --}}
                            <div class="space-y-2">
                                <div class="flex items-center gap-2">
                                    <div class="p-2 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg">
                                        <i class="fas fa-gamepad text-emerald-600 dark:text-emerald-400"></i>
                                    </div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                        Nama Game
                                    </label>
                                </div>
                                <input type="text" name="game"
                                       value="{{ old('game') }}"
                                       placeholder="Contoh: Valorant, Mobile Legends, Genshin Impact"
                                       class="mt-1 block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 
                                              rounded-xl shadow-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500
                                              dark:bg-gray-700 dark:text-gray-200 dark:focus:ring-emerald-400 
                                              transition duration-200">
                                @error('game')
                                    <div class="flex items-center gap-2 text-red-600 dark:text-red-400 text-sm mt-1">
                                        <i class="fas fa-exclamation-circle"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    Masukkan nama game yang akan dibahas dalam artikel
                                </p>
                            </div>

                            {{-- Konten Artikel --}}
                            <div class="space-y-2">
                                <div class="flex items-center gap-2">
                                    <div class="p-2 bg-amber-100 dark:bg-amber-900/30 rounded-lg">
                                        <i class="fas fa-edit text-amber-600 dark:text-amber-400"></i>
                                    </div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                        Konten / Pengetahuan
                                    </label>
                                </div>
                                <textarea name="content" rows="12"
                                          placeholder="Tuliskan pengetahuan, tips, trik, atau ulasan tentang game tersebut..."
                                          class="mt-1 block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 
                                                 rounded-xl shadow-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500
                                                 dark:bg-gray-700 dark:text-gray-200 dark:focus:ring-amber-400 
                                                 resize-y transition duration-200">{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="flex items-center gap-2 text-red-600 dark:text-red-400 text-sm mt-1">
                                        <i class="fas fa-exclamation-circle"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                                <div class="flex justify-between items-center text-xs text-gray-500 dark:text-gray-400">
                                    <span>
                                        <i class="fas fa-lightbulb mr-1"></i>
                                        Bagikan pengetahuan game-mu dengan detail
                                    </span>
                                    <span id="charCount">0 karakter</span>
                                </div>
                            </div>

                            {{-- Tips Menulis --}}
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-700 dark:to-gray-800 rounded-xl p-4 border border-blue-100 dark:border-gray-600">
                                <div class="flex items-start gap-3">
                                    <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                                        <i class="fas fa-lightbulb text-blue-600 dark:text-blue-400"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">
                                            Tips Menulis Artikel yang Baik:
                                        </h4>
                                        <ul class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                                            <li class="flex items-start gap-2">
                                                <i class="fas fa-check text-emerald-500 mt-0.5"></i>
                                                <span>Gunakan bahasa yang jelas dan mudah dipahami</span>
                                            </li>
                                            <li class="flex items-start gap-2">
                                                <i class="fas fa-check text-emerald-500 mt-0.5"></i>
                                                <span>Sertakan tips atau strategi yang spesifik</span>
                                            </li>
                                            <li class="flex items-start gap-2">
                                                <i class="fas fa-check text-emerald-500 mt-0.5"></i>
                                                <span>Tambahkan contoh praktis jika memungkinkan</span>
                                            </li>
                                            <li class="flex items-start gap-2">
                                                <i class="fas fa-check text-emerald-500 mt-0.5"></i>
                                                <span>Struktur artikel dengan baik (pendahuluan, isi, penutup)</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="flex flex-col sm:flex-row justify-end gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                                <a href="{{ route('articles.index') }}"
                                   class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gray-100 dark:bg-gray-700 
                                          text-gray-700 dark:text-gray-300 font-medium rounded-xl hover:bg-gray-200 
                                          dark:hover:bg-gray-600 transition-all duration-300 hover:shadow-md">
                                    <i class="fas fa-times"></i>
                                    Batal
                                </a>
                                <button type="submit"
                                        class="inline-flex items-center justify-center gap-2 px-6 py-3 
                                               bg-gradient-to-r from-indigo-600 to-purple-600 text-white 
                                               font-medium rounded-xl hover:shadow-lg transition-all duration-300 
                                               hover:from-indigo-700 hover:to-purple-700 transform hover:-translate-y-0.5">
                                    <i class="fas fa-paper-plane"></i>
                                    Publikasikan Artikel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Progress Indicator --}}
            <div class="mt-6 bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        Progress Penulisan
                    </span>
                    <span class="text-sm font-semibold text-indigo-600 dark:text-indigo-400">
                        <span id="progressPercentage">0%</span>
                    </span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                    <div id="progressBar" class="bg-gradient-to-r from-indigo-500 to-purple-500 h-2 rounded-full transition-all duration-500" style="width: 0%"></div>
                </div>
                <div class="mt-3 text-xs text-gray-500 dark:text-gray-400 flex justify-between">
                    <span>Mulai menulis...</span>
                    <span id="wordCount">0 kata</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Font Awesome Icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Script untuk progress indicator --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const titleInput = document.querySelector('input[name="title"]');
            const gameInput = document.querySelector('input[name="game"]');
            const contentTextarea = document.querySelector('textarea[name="content"]');
            const progressBar = document.getElementById('progressBar');
            const progressPercentage = document.getElementById('progressPercentage');
            const charCount = document.getElementById('charCount');
            const wordCount = document.getElementById('wordCount');

            function calculateProgress() {
                let progress = 0;
                
                // Check title (max 30 points)
                if (titleInput.value.trim().length > 0) {
                    progress += 20;
                    if (titleInput.value.length > 10) progress += 10;
                }
                
                // Check game (max 20 points)
                if (gameInput.value.trim().length > 0) {
                    progress += 20;
                }
                
                // Check content (max 50 points)
                const content = contentTextarea.value.trim();
                const contentLength = content.length;
                const words = content.split(/\s+/).filter(word => word.length > 0).length;
                
                if (contentLength > 0) {
                    progress += 10;
                    if (contentLength > 100) progress += 10;
                    if (contentLength > 300) progress += 10;
                    if (contentLength > 500) progress += 10;
                    if (contentLength > 1000) progress += 10;
                }
                
                // Update progress bar
                progress = Math.min(progress, 100);
                progressBar.style.width = progress + '%';
                progressPercentage.textContent = progress + '%';
                
                // Update character count
                charCount.textContent = contentLength + ' karakter';
                
                // Update word count
                wordCount.textContent = words + ' kata';
            }

            // Add event listeners
            [titleInput, gameInput, contentTextarea].forEach(input => {
                input.addEventListener('input', calculateProgress);
                input.addEventListener('change', calculateProgress);
            });

            // Initial calculation
            calculateProgress();
        });
    </script>
</x-app-layout>