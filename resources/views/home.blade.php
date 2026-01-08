@extends('layouts.app-public')

@section('title', 'Beranda - Perpustakaan Keliling')

@push('styles')
<style>
    .recommendation-title {
        text-align: center;
        font-size: 2em;
        margin-top: 30px;
        color: #0693E3;
    }
    .recommendation-subtitle {
        text-align: center;
        font-size: 1.2em;
        margin-bottom: 30px;
        color: #555;
    }
    .books-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 25px;
        padding: 30px;
        max-width: 1400px;
        margin: 0 auto;
        justify-items: center;
    }
    .book {
        position: relative;
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        overflow: hidden;
        transition: all 0.3s ease;
        width: 220px;
        cursor: pointer;
    }
    .book:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 8px 20px rgba(0,0,0,0.25);
    }
    .book a {
        text-decoration: none;
        color: inherit;
        display: block;
    }
    .book img {
        width: 100%;
        height: 320px;
        object-fit: cover;
        display: block;
    }
    .book-info {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.7) 70%, transparent 100%);
        color: white;
        padding: 15px;
        transition: all 0.3s ease;
    }
    .book:hover .book-info {
        background: linear-gradient(to top, rgba(0,0,0,0.95) 0%, rgba(0,0,0,0.8) 80%, transparent 100%);
        padding: 20px 15px;
    }
    .book-info h3 {
        margin: 0 0 8px 0;
        font-size: 1rem;
        font-weight: 600;
        line-height: 1.3;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
    .book-info p {
        margin: 5px 0;
        font-size: 0.85rem;
        opacity: 0.95;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
</style>
@endpush

@section('content')
<section>
    <div class="overlay-container">
        <h3 class="recommendation-title">Rekomendasi Buku</h3>
        <h4 class="recommendation-subtitle">Tingkatkan literasi membacamu hari ini!</h4>
        
        <div class="books-container">
            @forelse($books as $book)
                <div class="book">
                    <a href="{{ route('books.show', $book->buku_id) }}">
                        @if($book->cover_image && filter_var($book->cover_image, FILTER_VALIDATE_URL))
                            <img src="{{ $book->cover_image }}" 
                                 alt="{{ $book->judul }}"
                                 loading="lazy">
                        @elseif($book->cover_image)
                            <img src="{{ asset('covers/' . $book->cover_image) }}" 
                                 alt="{{ $book->judul }}"
                                 loading="lazy">
                        @else
                            <img src="{{ asset('covers/default.jpg') }}" 
                                 alt="{{ $book->judul }}"
                                 loading="lazy">
                        @endif
                        <div class="book-info">
                            <h3>{{ $book->judul }}</h3>
                            <p><strong>Pengarang:</strong> {{ $book->penulis }}</p>
                            <p><strong>Kategori:</strong> {{ $book->kategori }}</p>
                        </div>
                    </a>
                </div>
            @empty
                <p style="text-align: center; grid-column: 1 / -1;">Belum ada buku tersedia.</p>
            @endforelse
        </div>
        
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ route('books.index') }}" style="
                display: inline-block;
                background-color: #0693E3;
                color: white;
                padding: 12px 30px;
                border-radius: 5px;
                text-decoration: none;
                font-weight: bold;
            ">Lihat Semua Koleksi Buku</a>
        </div>
    </div>
</section>
@endsection
