@extends('layouts.admin')

@section('title', 'Kelola Berita & Agenda')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">📰 Kelola Berita & Agenda</h1>
        <a href="{{ route('admin.news.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            + Tambah Berita Baru
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Filter -->
    <div class="mb-4 flex gap-4 flex-wrap">
        <form action="{{ route('admin.news.index') }}" method="GET" class="flex gap-2 flex-wrap">
            <select name="category" class="border rounded px-3 py-2">
                <option value="">Semua Kategori</option>
                <option value="berita" {{ request('category') == 'berita' ? 'selected' : '' }}>Berita</option>
                <option value="agenda" {{ request('category') == 'agenda' ? 'selected' : '' }}>Agenda</option>
            </select>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berita..." class="border rounded px-3 py-2">
            <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">Cari</button>
        </form>
    </div>

    <div class="overflow-x-auto bg-white shadow rounded">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-3 text-left">GAMBAR</th>
                    <th class="px-4 py-3 text-left">JUDUL</th>
                    <th class="px-4 py-3 text-left">KATEGORI</th>
                    <th class="px-4 py-3 text-left">TANGGAL</th>
                    <th class="px-4 py-3 text-left">STATUS</th>
                    <th class="px-4 py-3 text-left">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($news as $item)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-3">
                            @if($item->image)
                                <img src="{{ Storage::url($item->image) }}" 
                                    alt="{{ $item->title }}" 
                                    style="width: 80px; height: 50px; object-fit: cover; border-radius: 4px;">
                            @else
                                <div style="width: 80px; height: 50px; background: #e5e7eb; border-radius: 4px; display: flex; align-items: center; justify-content: center; color: #9ca3af;">
                                    <span>No Image</span>
                                </div>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="font-medium">{{ Str::limit($item->title, 50) }}</div>
                            @if($item->is_featured)
                                <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded">Featured</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            @if($item->category == 'berita')
                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">Berita</span>
                            @else
                                <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded text-xs">Agenda</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            @if($item->category == 'agenda' && $item->event_date)
                                <div>{{ $item->event_date->format('d M Y') }}</div>
                                @if($item->event_time)
                                    <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($item->event_time)->format('H:i') }} WITA</div>
                                @endif
                            @else
                                {{ $item->published_at ? $item->published_at->format('d M Y H:i') : '-' }}
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            @if($item->is_published)
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Published</span>
                            @else
                                <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-xs">Draft</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex gap-2">
                                <a href="{{ route('news.show', $item->slug) }}" target="_blank" 
                                   class="text-blue-600 hover:text-blue-800" title="Lihat">
                                    👁️
                                </a>
                                <a href="{{ route('admin.news.edit', $item) }}" 
                                   class="text-green-600 hover:text-green-800" title="Edit">
                                    ✏️
                                </a>
                                <form action="{{ route('admin.news.destroy', $item) }}" method="POST" 
                                      style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus berita ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800" title="Hapus">
                                        🗑️
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                            Belum ada berita atau agenda.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $news->links() }}
    </div>
</div>
@endsection
