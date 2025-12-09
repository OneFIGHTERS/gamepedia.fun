<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Artikel: {{ $article->title }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('articles.update', $article) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">
                                Judul
                            </label>
                            <input type="text" name="title"
                                   value="{{ old('title', $article->title) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @error('title')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">
                                Game
                            </label>
                            <input type="text" name="game"
                                   value="{{ old('game', $article->game) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @error('game')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">
                                Konten / Pengetahuan
                            </label>
                            <textarea name="content" rows="8"
                                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('content', $article->content) }}</textarea>
                            @error('content')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end gap-2">
                            <a href="{{ route('articles.show', $article) }}"
                               class="px-4 py-2 bg-gray-300 rounded">
                                Batal
                            </a>
                            <button type="submit"
                                    class="px-4 py-2 bg-blue-600 text-white rounded">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
