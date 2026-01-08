<?php

namespace App\Helpers;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;

class QRCodeHelper
{
    /**
     * Generate QR Code untuk reservasi
     * 
     * @param mixed $reservation
     * @return string Base64 data URI
     */
    public static function generateReservationQR($reservation): string
    {
        $verificationData = [
            'id' => $reservation->id,
            'name' => $reservation->full_name,
            'date' => $reservation->reservation_date,
            'time' => $reservation->visit_time,
            'code' => $reservation->id . '-' . strtoupper(substr(md5($reservation->email ?? 'guest'), 0, 6)),
            'verify_url' => url('/scan/verify/' . $reservation->id)
        ];
        
        $qrData = json_encode($verificationData);
        
        $qr = QrCode::create($qrData)
            ->setEncoding(new Encoding('UTF-8'))
            ->setErrorCorrectionLevel(ErrorCorrectionLevel::High)
            ->setSize(300)
            ->setMargin(10)
            ->setRoundBlockSizeMode(RoundBlockSizeMode::Margin)
            ->setForegroundColor(new Color(6, 147, 227)) // Warna biru tema perpustakaan
            ->setBackgroundColor(new Color(255, 255, 255));

        $writer = new PngWriter();
        $result = $writer->write($qr);
        
        return $result->getDataUri();
    }
    
    /**
     * Generate QR Code dengan custom data
     * 
     * @param string $data
     * @param int $size
     * @return string Base64 data URI
     */
    public static function generate(string $data, int $size = 300): string
    {
        $qr = QrCode::create($data)
            ->setEncoding(new Encoding('UTF-8'))
            ->setErrorCorrectionLevel(ErrorCorrectionLevel::High)
            ->setSize($size)
            ->setMargin(10)
            ->setRoundBlockSizeMode(RoundBlockSizeMode::Margin)
            ->setForegroundColor(new Color(0, 0, 0))
            ->setBackgroundColor(new Color(255, 255, 255));

        $writer = new PngWriter();
        $result = $writer->write($qr);
        
        return $result->getDataUri();
    }
}
