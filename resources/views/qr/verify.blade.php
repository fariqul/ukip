@extends('layouts.app-public')

@section('title', 'Verifikasi Reservasi')

@push('styles')
<style>
    .verify-container {
        max-width: 700px;
        margin: 40px auto;
        padding: 40px;
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }
    .verify-header {
        text-align: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid #0693E3;
    }
    .verify-header h2 {
        font-size: 28px;
        color: #0693E3;
        margin-bottom: 10px;
    }
    .status-valid {
        background: #28a745;
        color: white;
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        margin: 30px 0;
    }
    .status-invalid {
        background: #dc3545;
        color: white;
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        margin: 30px 0;
    }
    .detail-box {
        background: #f9f9f9;
        padding: 20px;
        border-radius: 10px;
        margin: 20px 0;
    }
    .detail-row {
        display: flex;
        padding: 10px 0;
        border-bottom: 1px solid #e0e0e0;
    }
    .detail-row:last-child {
        border-bottom: none;
    }
    .detail-label {
        font-weight: bold;
        width: 180px;
        color: #555;
    }
    .detail-value {
        flex: 1;
        color: #333;
    }
    .status-badge {
        display: inline-block;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: bold;
    }
    .status-confirmed {
        background: #28a745;
        color: white;
    }
    .status-pending {
        background: #ffc107;
        color: #333;
    }
    .status-rejected {
        background: #dc3545;
        color: white;
    }
</style>
@endpush

@section('content')
<div class="verify-container">
    <div class="verify-header">
        <h2>🔍 Verifikasi Reservasi</h2>
        <p>Hasil verifikasi QR Code reservasi</p>
    </div>

    @if($found)
        <div class="status-valid">
            <h3 style="margin: 0 0 10px 0;">✓ Reservasi Valid</h3>
            <p style="margin: 0;">Data reservasi ditemukan di sistem</p>
        </div>

        <div class="detail-box">
            <h4 style="color: #0693E3; margin-bottom: 15px;">Detail Reservasi:</h4>
            
            <div class="detail-row">
                <div class="detail-label">ID Reservasi:</div>
                <div class="detail-value"><strong>#{{ $reservation->id }}</strong></div>
            </div>
            
            <div class="detail-row">
                <div class="detail-label">Nama Pemohon:</div>
                <div class="detail-value">{{ $reservation->full_name }}</div>
            </div>
            
            <div class="detail-row">
                <div class="detail-label">Email:</div>
                <div class="detail-value">{{ $reservation->email }}</div>
            </div>
            
            <div class="detail-row">
                <div class="detail-label">Telepon:</div>
                <div class="detail-value">{{ $reservation->phone }}</div>
            </div>
            
            <div class="detail-row">
                <div class="detail-label">Instansi:</div>
                <div class="detail-value">{{ $reservation->occupation }}</div>
            </div>
            
            <div class="detail-row">
                <div class="detail-label">Jenis Layanan:</div>
                <div class="detail-value">{{ $reservation->category }}</div>
            </div>
            
            <div class="detail-row">
                <div class="detail-label">Tanggal Kunjungan:</div>
                <div class="detail-value">{{ \Carbon\Carbon::parse($reservation->visit_date)->format('d F Y') }}</div>
            </div>
            
            <div class="detail-row">
                <div class="detail-label">Waktu:</div>
                <div class="detail-value">{{ $reservation->visit_time }}</div>
            </div>
            
            <div class="detail-row">
                <div class="detail-label">Jumlah Pengunjung:</div>
                <div class="detail-value">{{ $reservation->visitor_count }} orang</div>
            </div>
            
            <div class="detail-row">
                <div class="detail-label">Alamat:</div>
                <div class="detail-value">{{ $reservation->address }}</div>
            </div>
            
            <div class="detail-row">
                <div class="detail-label">Status:</div>
                <div class="detail-value">
                    <span class="status-badge status-{{ $reservation->status }}">
                        {{ strtoupper($reservation->status) }}
                    </span>
                </div>
            </div>
            
            <div class="detail-row">
                <div class="detail-label">Tanggal Reservasi:</div>
                <div class="detail-value">{{ \Carbon\Carbon::parse($reservation->reservation_date)->format('d F Y H:i') }}</div>
            </div>
        </div>

        @if($reservation->status === 'confirmed')
            <div style="background: #d4edda; padding: 15px; border-radius: 8px; border-left: 4px solid #28a745; margin-top: 20px;">
                <strong style="color: #155724;">✓ Reservasi telah disetujui</strong>
                <p style="margin: 5px 0 0 0; color: #155724; font-size: 14px;">Silakan melanjutkan dengan kunjungan sesuai jadwal</p>
            </div>
        @elseif($reservation->status === 'pending')
            <div style="background: #fff3cd; padding: 15px; border-radius: 8px; border-left: 4px solid #ffc107; margin-top: 20px;">
                <strong style="color: #856404;">⏳ Reservasi masih menunggu persetujuan</strong>
                <p style="margin: 5px 0 0 0; color: #856404; font-size: 14px;">Harap tunggu konfirmasi dari admin</p>
            </div>
        @elseif($reservation->status === 'rejected')
            <div style="background: #f8d7da; padding: 15px; border-radius: 8px; border-left: 4px solid #dc3545; margin-top: 20px;">
                <strong style="color: #721c24;">✕ Reservasi ditolak</strong>
                <p style="margin: 5px 0 0 0; color: #721c24; font-size: 14px;">Silakan hubungi perpustakaan untuk informasi lebih lanjut</p>
            </div>
        @endif
    @else
        <div class="status-invalid">
            <h3 style="margin: 0 0 10px 0;">✕ Reservasi Tidak Ditemukan</h3>
            <p style="margin: 0;">{{ $message }}</p>
        </div>
        
        <div style="text-align: center; margin-top: 30px;">
            <p>QR Code tidak valid atau reservasi tidak ada dalam sistem.</p>
            <p style="color: #666; font-size: 14px; margin-top: 10px;">Silakan periksa kembali atau hubungi admin perpustakaan.</p>
        </div>
    @endif
    
    <div style="text-align: center; margin-top: 30px;">
        <a href="{{ route('home') }}" style="display: inline-block; background: #0693E3; color: white; padding: 12px 30px; border-radius: 8px; text-decoration: none; font-weight: 600;">
            Kembali ke Beranda
        </a>
    </div>
</div>
@endsection
