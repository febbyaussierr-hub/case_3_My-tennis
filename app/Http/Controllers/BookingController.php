<?php

namespace App\Http\Controllers;

use App\Models\Court;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookingController extends Controller
{
    // DETAIL LAPANGAN
    public function show($id)
    {
        $court = Court::where('status', 'active')
            ->findOrFail($id);

        $bookedSchedules = Booking::where('court_id', $court->id)
            ->whereDate('booking_date', '>=', today())
            ->whereNotIn('status', [
                'cancelled', 'canceled', 'rejected'
            ])
            ->get(['booking_date', 'start_time', 'duration'])
            ->map(function ($booking) {
                return [
                    'date' => Carbon::parse($booking->booking_date)
                        ->format('Y-m-d'),
                    'time' => substr($booking->start_time, 0, 5),
                    'duration' => (int) $booking->duration,
                ];
            })
            ->values();

        return view('booking-detail', compact(
            'court', 'bookedSchedules'
        ));
    }

    // SIMPAN BOOKING
    public function store(Request $request, $id)
    {
        $validated = $request->validate([
            'booking_date' => 'required|date_format:Y-m-d|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'duration' => 'required|integer|min:1|max:4',
        ]);

        $start = Carbon::parse(
            $validated['booking_date'] . ' ' .
            $validated['start_time']
        );

        $end = $start->copy()
            ->addHours((int) $validated['duration']);

        if ($start->lessThanOrEqualTo(now())) {
            return back()->withInput()
                ->with('error', 'Tanggal atau jam bermain sudah lewat!');
        }

        // Jam operasional sementara: 06.00 - 22.00
        $opening = $start->copy()->startOfDay()->addHours(6);
        $closing = $start->copy()->startOfDay()->addHours(22);

        if (
            $start->lessThan($opening) ||
            $end->greaterThan($closing) ||
            $start->minute !== 0
        ) {
            return back()->withInput()
                ->with('error', 'Pilih jadwal bermain antara pukul 06.00 - 22.00 dengan jam mulai yang tepat.');
        }

        return DB::transaction(function () use (
            $request, $id, $validated, $start, $end
        ) {

            $court = Court::where('status', 'active')
                ->lockForUpdate()
                ->findOrFail($id);

            $existingBookings = Booking::where('court_id', $court->id)
                ->whereDate('booking_date', $validated['booking_date'])
                ->whereNotIn('status', [
                    'cancelled', 'canceled', 'rejected'
                ])
                ->lockForUpdate()
                ->get();

            foreach ($existingBookings as $existingBooking) {

                $existingStart = Carbon::parse(
                    $validated['booking_date'] . ' ' .
                    $existingBooking->start_time
                );

                $existingEnd = $existingStart->copy()
                    ->addHours((int) $existingBooking->duration);

                if (
                    $start->lessThan($existingEnd) &&
                    $end->greaterThan($existingStart)
                ) {
                    return back()->withInput()
                        ->with(
                            'error',
                            'Lapangan sudah dipesan pada jam tersebut. Silakan pilih jadwal lain.'
                        );
                }
            }

            $totalPrice = $court->price_per_hour *
                $validated['duration'];

            $booking = Booking::create([
                'user_id' => $request->user()->id,
                'court_id' => $court->id,
                'booking_date' => $validated['booking_date'],
                'start_time' => $validated['start_time'],
                'duration' => $validated['duration'],
                'total_price' => $totalPrice,
                'status' => 'pending',
            ]);

            return redirect()
                ->route('booking.success', $booking->id);
        });
    }

    // BUKTI BOOKING
public function success($id)
{
    $booking = Booking::with(['court', 'user'])
        ->where('user_id', auth()->id())
        ->findOrFail($id);

    $isPaid = $booking->status === 'confirmed'
        && $booking->payment_status === 'paid';

    return view('booking-success', compact('booking', 'isPaid'));
}

    // RIWAYAT BOOKING BUYER
    public function index()
    {
        $bookings = Booking::with('court')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('my-bookings', compact('bookings'));
    }
}