<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Support\Facades\Storage;

class SellerBookingController extends Controller
{
    // MENAMPILKAN DAFTAR BOOKING
    public function index()
    {
        $bookings = Booking::with(['court', 'user'])
            ->whereHas('court', function ($query) {
                $query->where('seller_id', auth()->id());
            })
            ->latest()
            ->get();

        return view('seller.bookings.index', compact('bookings'));
    }

    // KONFIRMASI BOOKING
    public function confirm($id)
    {
        $updated = Booking::whereHas('court', function ($query) {
                $query->where('seller_id', auth()->id());
            })
            ->where('id', $id)
            ->where('status', 'pending')
            ->update([
                'status' => 'confirmed',
            ]);

        if (!$updated) {
            return back()->with(
                'error',
                'Booking tidak dapat dikonfirmasi.'
            );
        }

        return back()->with(
            'success',
            'Booking berhasil dikonfirmasi!'
        );
    }

    // TOLAK BOOKING
    public function reject($id)
    {
        $updated = Booking::whereHas('court', function ($query) {
                $query->where('seller_id', auth()->id());
            })
            ->where('id', $id)
            ->where('status', 'pending')
            ->update([
                'status' => 'rejected',
            ]);

        if (!$updated) {
            return back()->with(
                'error',
                'Booking tidak dapat ditolak.'
            );
        }

        return back()->with(
            'success',
            'Booking berhasil ditolak!'
        );
    }

    // MELIHAT BUKTI PEMBAYARAN
    public function paymentProof($id)
    {
        $booking = Booking::whereHas('court', function ($query) {
                $query->where('seller_id', auth()->id());
            })
            ->findOrFail($id);

        if (
            !$booking->payment_proof ||
            !Storage::disk('local')->exists($booking->payment_proof)
        ) {
            abort(404, 'Bukti pembayaran tidak ditemukan.');
        }

        return Storage::disk('local')->response(
            $booking->payment_proof,
            null,
            [
                'Cache-Control' => 'private, no-store',
                'X-Content-Type-Options' => 'nosniff',
            ]
        );
    }

    // VERIFIKASI PEMBAYARAN
    public function verifyPayment($id)
    {
        $updated = Booking::whereHas('court', function ($query) {
                $query->where('seller_id', auth()->id());
            })
            ->where('id', $id)
            ->where('status', 'confirmed')
            ->where('payment_status', 'waiting_verification')
            ->whereNotNull('payment_proof')
            ->update([
                'payment_status' => 'paid',
                'paid_at' => now(),
            ]);

        if (!$updated) {
            return back()->with(
                'error',
                'Pembayaran tidak dapat diverifikasi.'
            );
        }

        return back()->with(
            'success',
            'Pembayaran berhasil diverifikasi!'
        );
    }

    // TOLAK PEMBAYARAN
    public function rejectPayment($id)
    {
        $updated = Booking::whereHas('court', function ($query) {
                $query->where('seller_id', auth()->id());
            })
            ->where('id', $id)
            ->where('status', 'confirmed')
            ->where('payment_status', 'waiting_verification')
            ->update([
                'payment_status' => 'rejected',
                'paid_at' => null,
            ]);

        if (!$updated) {
            return back()->with(
                'error',
                'Pembayaran tidak dapat ditolak.'
            );
        }

        return back()->with(
            'success',
            'Pembayaran ditolak. Buyer dapat mengirim ulang bukti pembayaran.'
        );
    }
}