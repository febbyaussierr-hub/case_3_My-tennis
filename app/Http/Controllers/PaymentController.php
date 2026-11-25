<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    // HALAMAN PEMBAYARAN
    public function show($id)
    {
        $booking = Booking::with('court')
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        if ($booking->status !== 'confirmed') {
            return redirect()
                ->route('booking.index')
                ->with('error', 'Booking belum disetujui seller.');
        }

        return view('payment', compact('booking'));
    }

    // UPLOAD BUKTI PEMBAYARAN
    public function store(Request $request, $id)
    {
        $validated = $request->validate([
            'payment_method' => 'required|in:bank_transfer,qris',
            'payment_proof' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        return DB::transaction(function () use (
            $request, $id, $validated
        ) {

            $booking = Booking::where('user_id', auth()->id())
                ->lockForUpdate()
                ->findOrFail($id);

            if ($booking->status !== 'confirmed') {
                return back()->with(
                    'error',
                    'Booking belum disetujui seller.'
                );
            }

            if (!in_array($booking->payment_status, [
                'unpaid', 'rejected'
            ])) {
                return back()->with(
                    'error',
                    'Pembayaran sudah dikirim atau diverifikasi.'
                );
            }

            // Simpan bukti pembayaran secara privat
            $paymentProof = $request->file('payment_proof')
                ->store('payment-proofs', 'local');

            if (!$paymentProof) {
                return back()->with(
                    'error',
                    'Bukti pembayaran gagal disimpan.'
                );
            }

            $oldProof = $booking->payment_proof;

            $booking->update([
                'payment_method' => $validated['payment_method'],
                'payment_proof' => $paymentProof,
                'payment_status' => 'waiting_verification',
                'paid_at' => null,
            ]);

            // Hapus bukti pembayaran lama setelah commit
            if ($oldProof) {
                DB::afterCommit(function () use ($oldProof) {
                    Storage::disk('local')->delete($oldProof);
                });
            }

            return redirect()
                ->route('payment.show', $booking->id)
                ->with(
                    'success',
                    'Bukti pembayaran berhasil dikirim. Menunggu verifikasi seller.'
                );
        });
    }
}