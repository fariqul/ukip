@extends('layouts.admin')

@section('title', 'Edit Berita')

@section('content')
<div class="p-6">
    <div class="mb-6">
        <a href="{{ route('admin.news.index') }}" class="text-blue-600 hover:underline">← Kembali ke Daftar</a>
    </div>

    <h1 class="text-2xl font-bold mb-6">✏️ Edit Berita/Agenda</h1>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.news.update', $news) }}" method="POST" enctype="multipart/form-data" class="bg-white shadow rounded-lg p-6 max-w-4xl">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Judul -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Judul *</label>
                <input type="text" name="title" value="{{ old('title', $news->title) }}" required
                       class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Kategori -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Kategori *</label>
                <select name="category" id="categorySelect" required
                        class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="berita" {{ old('category', $news->category) == 'berita' ? 'selected' : '' }}>Berita</option>
                    <option value="agenda" {{ old('category', $news->category) == 'agenda' ? 'selected' : '' }}>Agenda</option>
                </select>
            </div>

            <!-- Gambar -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Gambar</label>
                @if($news->image)
                    <div class="mb-2">
                        <img src="{{ Storage::url($news->image) }}" alt="{{ $news->title }}" 
                             style="max-width: 200px; border-radius: 4px;">
                        <p class="text-xs text-gray-500 mt-1">Gambar saat ini</p>
                    </div>
                @endif
                <input type="file" name="image" accept="image/*"
                       class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah gambar</p>
            </div>

            <!-- Agenda Fields -->
            <div id="agendaFields" class="md:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-4" style="display: none;">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Event</label>
                    <input type="date" name="event_date" value="{{ old('event_date', $news->event_date?->format('Y-m-d')) }}"
                           class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Waktu Event</label>
                    <input type="time" name="event_time" value="{{ old('event_time', $news->event_time ? \Carbon\Carbon::parse($news->event_time)->format('H:i') : '') }}"
                           class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi Event</label>
                    <input type="text" name="event_location" value="{{ old('event_location', $news->event_location) }}"
                           class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Contoh: Aula Perpustakaan">
                </div>
            </div>

            <!-- Excerpt -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Ringkasan</label>
                <textarea name="excerpt" rows="2"
                          class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                          placeholder="Ringkasan singkat berita (maks 500 karakter)">{{ old('excerpt', $news->excerpt) }}</textarea>
            </div>

            <!-- Content -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Konten *</label>
                <textarea name="content" id="content" rows="10" required
                          class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                          placeholder="Tulis konten berita di sini...">{{ old('content', $news->content) }}</textarea>
            </div>

            <!-- Options -->
            <div class="md:col-span-2 flex gap-6">
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $news->is_featured) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span class="text-sm text-gray-700">Jadikan Berita Utama (Featured)</span>
                </label>
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="is_published" value="1" {{ old('is_published', $news->is_published) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span class="text-sm text-gray-700">Publish</span>
                </label>
            </div>
        </div>

        <div class="mt-6 flex gap-4">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                💾 Simpan Perubahan
            </button>
            <a href="{{ route('admin.news.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition">
                Batal
            </a>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const categorySelect = document.getElementById('categorySelect');
    const agendaFields = document.getElementById('agendaFields');
    
    function toggleAgendaFields() {
        if (categorySelect.value === 'agenda') {
            agendaFields.style.display = 'grid';
        } else {
            agendaFields.style.display = 'none';
        }
    }
    
    categorySelect.addEventListener('change', toggleAgendaFields);
    toggleAgendaFields(); // Initial check
});
</script>
@endsection
