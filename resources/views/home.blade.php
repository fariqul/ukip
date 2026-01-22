@extends('layouts.app-public')

@section('title', 'Beranda - Perpustakaan Keliling')

@push('styles')
<style>
    /* News Section */
    .news-section {
        max-width: 1400px;
        margin: 0 auto;
        padding: 40px 30px;
    }
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }
    .section-title {
        font-size: 1.8em;
        color: #0693E3;
        margin: 0;
    }
    .section-link {
        color: #0693E3;
        text-decoration: none;
        font-weight: 500;
        font-size: 0.95rem;
    }
    .section-link:hover {
        text-decoration: underline;
    }
    
    /* News Grid */
    .news-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 25px;
    }
    .news-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }
    .news-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    .news-card img {
        width: 100%;
        height: 180px;
        object-fit: cover;
    }
    .news-card-content {
        padding: 20px;
    }
    .news-date {
        color: #0693E3;
        font-size: 0.85rem;
        margin-bottom: 8px;
    }
    .news-card h3 {
        font-size: 1.1em;
        margin-bottom: 10px;
        color: #1f2937;
        line-height: 1.4;
    }
    .news-card h3 a {
        color: inherit;
        text-decoration: none;
    }
    .news-card h3 a:hover {
        color: #0693E3;
    }
    .news-excerpt {
        color: #6b7280;
        font-size: 0.9rem;
        line-height: 1.5;
    }
    
    /* Agenda Cards */
    .agenda-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 25px;
    }
    .agenda-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
    }
    .agenda-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    .agenda-date-badge {
        background: linear-gradient(135deg, #7c3aed 0%, #5b21b6 100%);
        color: white;
        padding: 15px;
        text-align: center;
    }
    .agenda-date-badge .day {
        font-size: 2rem;
        font-weight: 700;
        line-height: 1;
    }
    .agenda-date-badge .month {
        font-size: 0.9rem;
        text-transform: uppercase;
    }
    .agenda-card-content {
        padding: 20px;
        flex: 1;
    }
    .agenda-card h3 {
        font-size: 1.05em;
        margin-bottom: 10px;
        color: #1f2937;
        line-height: 1.4;
    }
    .agenda-card h3 a {
        color: inherit;
        text-decoration: none;
    }
    .agenda-card h3 a:hover {
        color: #7c3aed;
    }
    .agenda-meta {
        color: #6b7280;
        font-size: 0.85rem;
    }
    .agenda-meta span {
        display: block;
        margin-bottom: 5px;
    }
    
    /* Empty News State */
    .empty-news {
        text-align: center;
        padding: 40px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    }
    .empty-news p {
        color: #6b7280;
        margin-top: 10px;
    }
    
    /* Responsive */
    @media (max-width: 1024px) {
        .news-grid, .agenda-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (max-width: 768px) {
        .news-grid, .agenda-grid {
            grid-template-columns: 1fr;
        }
        .section-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }
        .news-section {
            padding: 30px 15px;
        }
    }

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
<!-- Berita Section -->
@if($latestNews->count() > 0 || $upcomingAgenda->count() > 0)
<section class="news-section">
    @if($latestNews->count() > 0)
    <div class="section-header">
        <h2 class="section-title">📰 Berita Terbaru</h2>
        <a href="{{ route('news.index') }}" class="section-link">Lihat Semua →</a>
    </div>
    <div class="news-grid">
        @foreach($latestNews as $news)
        <article class="news-card">
            @if($news->image)
                <img src="{{ Storage::url($news->image) }}" alt="{{ $news->title }}">
            @else
                <div style="height: 180px; background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%); display: flex; align-items: center; justify-content: center;">
                    <span style="font-size: 3rem;">📄</span>
                </div>
            @endif
            <div class="news-card-content">
                <div class="news-date">📅 {{ $news->published_at?->translatedFormat('d F Y') }}</div>
                <h3><a href="{{ route('news.show', $news->slug) }}">{{ $news->title }}</a></h3>
                <p class="news-excerpt">{{ $news->excerpt ?: Str::limit(strip_tags($news->content), 100) }}</p>
            </div>
        </article>
        @endforeach
    </div>
    @endif

    @if($upcomingAgenda->count() > 0)
    <div class="section-header" style="margin-top: 50px;">
        <h2 class="section-title">📅 Agenda Mendatang</h2>
        <a href="{{ route('news.agenda') }}" class="section-link">Lihat Semua →</a>
    </div>
    <div class="agenda-grid">
        @foreach($upcomingAgenda as $agenda)
        <article class="agenda-card">
            <div class="agenda-date-badge">
                <div class="day">{{ $agenda->event_date->format('d') }}</div>
                <div class="month">{{ $agenda->event_date->translatedFormat('M Y') }}</div>
            </div>
            <div class="agenda-card-content">
                <h3><a href="{{ route('news.show', $agenda->slug) }}">{{ $agenda->title }}</a></h3>
                <div class="agenda-meta">
                    @if($agenda->event_time)
                    <span>🕐 {{ \Carbon\Carbon::parse($agenda->event_time)->format('H:i') }} WITA</span>
                    @endif
                    @if($agenda->event_location)
                    <span>📍 {{ $agenda->event_location }}</span>
                    @endif
                </div>
            </div>
        </article>
        @endforeach
    </div>
    @endif
</section>
@endif

<!-- Rekomendasi Buku Section -->
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
