<?php

namespace App\Jobs;

use App\Models\Booking;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class CheckPendingBookings implements ShouldQueue
{
    use Queueable;

    public function handle(): void
    {
        // Menghitung booking yang belum memiliki pembayaran berhasil
        $pendingCount = Booking::query()
            ->where(function ($query) {
                $query->whereNull('payment_status')
                    ->orWhereNotIn('payment_status', ['paid', 'verified']);
            })
            ->count();

        // Mencatat hasil pemeriksaan tanpa mengubah data booking
        Log::info('MY TENNIS - Pemeriksaan booking selesai', [
            'booking_belum_lunas' => $pendingCount,
            'waktu_pemeriksaan' => now()->toDateTimeString(),
        ]);
    }
}
