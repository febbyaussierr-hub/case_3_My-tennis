<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Booking Details | MY TENNIS</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @media print {

            @page {
                size: A4;
                margin: 12mm;
            }

            .no-print {
                display: none !important;
            }

            body {
                background: white !important;
            }

            main {
                padding: 0 !important;
                margin: 0 auto !important;
            }

            #ticket {
                box-shadow: none !important;
                border: 1px solid #cccccc;
                break-inside: avoid;
            }

            * {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>

<body class="min-h-screen bg-[#F5F4EC] text-[#35432F]">

    @php

        $startTime = \Carbon\Carbon::parse(
            \Carbon\Carbon::parse($booking->booking_date)->format('Y-m-d')
            . ' ' . $booking->start_time
        );

        $endTime = $startTime->copy()
            ->addHours((int) $booking->duration);

        $bookingCode = 'MT-' . str_pad(
            $booking->id, 5, '0', STR_PAD_LEFT
        );

        $paymentStatus = $booking->payment_status ?? 'unpaid';

    @endphp

    <!-- NAVBAR -->
    <nav class="no-print flex flex-wrap justify-between items-center gap-4 px-5 md:px-16 py-5 bg-white">

        <a href="/" class="text-2xl font-black text-[#536B50]">
            MY TENNIS<span class="text-black">.</span>
        </a>

        <a href="{{ route('booking.index') }}"
            class="text-sm font-bold hover:text-[#687653]">

            MY BOOKINGS

        </a>

    </nav>

    <!-- MAIN CONTENT -->
    <main class="max-w-xl mx-auto px-5 py-12">

        <!-- STATUS UTAMA -->
        <div class="no-print text-center mb-8">

            @if($isPaid)

                <div class="w-20 h-20 bg-[#DFE9D7] text-[#536B50] rounded-full flex items-center justify-center mx-auto">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-10 h-10"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M5 12l4 4L19 6"/>

                    </svg>

                </div>

                <p class="text-[#687653] font-bold tracking-widest mt-5 text-sm">
                    YOUR BOOKING TICKET
                </p>

                <h1 class="text-3xl font-black mt-3">
                    YOU'RE ALL SET!
                </h1>

                <p class="text-gray-500 text-sm mt-3">
                    Booking dan pembayaran kamu telah dikonfirmasi.
                </p>

            @else

                <p class="text-[#687653] font-bold tracking-widest text-sm">
                    YOUR RESERVATION
                </p>

                <h1 class="text-3xl font-black mt-3">
                    BOOKING DETAILS
                </h1>

                <p class="text-gray-500 text-sm mt-3">
                    Pantau status pemesanan lapanganmu.
                </p>

            @endif

        </div>

        <!-- BOOKING CARD -->
        <div id="{{ $isPaid ? 'ticket' : 'booking-details' }}"
            class="bg-white rounded-3xl shadow-sm overflow-hidden {{ $isPaid ? '' : 'no-print' }}">

            <!-- HEADER -->
            <div class="bg-[#536B50] text-white p-7">

                <div class="flex flex-wrap justify-between items-center gap-4">

                    <div>

                        <h2 class="text-3xl font-black">
                            MY TENNIS.
                        </h2>

                        <p class="text-xs tracking-widest text-gray-200 mt-2">

                            {{ $isPaid ? 'OFFICIAL BOOKING TICKET' : 'RESERVATION DETAILS' }}

                        </p>

                    </div>

                    @if($isPaid)

                        <span class="border border-white rounded-lg px-4 py-2 text-xs font-bold">
                            PAID
                        </span>

                    @endif

                </div>

            </div>

            <!-- CONTENT -->
            <div class="p-6">

                <!-- BOOKING ID -->
                <div class="flex flex-wrap justify-between items-center gap-3 mb-6">

                    <div>

                        <p class="text-sm text-gray-500">
                            Booking ID
                        </p>

                        <h3 class="text-xl font-black mt-1">
                            {{ $bookingCode }}
                        </h3>

                    </div>

                    @if($booking->status === 'pending')

                        <span class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded-full text-xs font-bold">
                            PENDING
                        </span>

                    @elseif($booking->status === 'confirmed')

                        <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-xs font-bold">
                            CONFIRMED
                        </span>

                    @elseif(in_array($booking->status, ['rejected', 'cancelled', 'canceled']))

                        <span class="bg-red-100 text-red-700 px-4 py-2 rounded-full text-xs font-bold">
                            {{ strtoupper($booking->status) }}
                        </span>

                    @else

                        <span class="bg-gray-100 text-gray-700 px-4 py-2 rounded-full text-xs font-bold">
                            {{ strtoupper($booking->status) }}
                        </span>

                    @endif

                </div>

                <!-- FOTO LAPANGAN -->
                @if($booking->court->image)

                    <img src="{{ asset('storage/' . $booking->court->image) }}"
                        alt="{{ $booking->court->name }}"
                        class="w-full h-48 object-cover rounded-xl">

                @else

                    <div class="w-full h-48 bg-[#687653] text-white rounded-xl flex justify-center items-center">

                        <p class="text-sm">
                            No Court Image
                        </p>

                    </div>

                @endif

                <!-- NAMA LAPANGAN -->
                <p class="text-xs font-bold tracking-widest text-[#687653] mt-6">
                    TENNIS COURT
                </p>

                <h2 class="text-2xl font-black mt-2">
                    {{ $booking->court->name }}
                </h2>

                <p class="text-gray-500 mt-2">
                    {{ $booking->court->venue_name }}
                </p>

                <p class="text-gray-500 text-sm mt-2">

                    {{ $booking->court->city }},
                    {{ $booking->court->province }}

                </p>

                <!-- DETAIL BOOKING -->
                <div class="grid grid-cols-2 gap-6 border-t border-gray-200 mt-6 pt-6">

                    <div>

                        <p class="text-xs text-gray-500">
                            Nama Pemesan
                        </p>

                        <p class="font-bold mt-2">
                            {{ $booking->user->name ?? auth()->user()->name }}
                        </p>

                    </div>

                    <div>

                        <p class="text-xs text-gray-500">
                            Tanggal Bermain
                        </p>

                        <p class="font-bold mt-2">
                            {{ $startTime->format('d/m/Y') }}
                        </p>

                    </div>

                    <div>

                        <p class="text-xs text-gray-500">
                            Jam Bermain
                        </p>

                        <p class="font-bold mt-2">

                            {{ $startTime->format('H:i') }}
                            -
                            {{ $endTime->format('H:i') }}

                            @if(!$endTime->isSameDay($startTime))
                                (Besok)
                            @endif

                        </p>

                    </div>

                    <div>

                        <p class="text-xs text-gray-500">
                            Durasi Bermain
                        </p>

                        <p class="font-bold mt-2">
                            {{ $booking->duration }} Jam
                        </p>

                    </div>

                    @if($booking->status === 'confirmed')

                        <div>

                            <p class="text-xs text-gray-500">
                                Payment Method
                            </p>

                            <p class="font-bold mt-2">

                                {{ $booking->payment_method === 'bank_transfer'
                                    ? 'Bank Transfer'
                                    : ($booking->payment_method === 'qris' ? 'QRIS' : '-') }}

                            </p>

                        </div>

                        <div>

                            <p class="text-xs text-gray-500">
                                Payment Status
                            </p>

                            @if($paymentStatus === 'paid')

                                <p class="font-bold text-green-700 mt-2">
                                    Paid
                                </p>

                            @elseif($paymentStatus === 'waiting_verification')

                                <p class="font-bold text-yellow-600 mt-2">
                                    Waiting Verification
                                </p>

                            @elseif($paymentStatus === 'rejected')

                                <p class="font-bold text-red-600 mt-2">
                                    Payment Rejected
                                </p>

                            @else

                                <p class="font-bold text-gray-600 mt-2">
                                    Unpaid
                                </p>

                            @endif

                        </div>

                    @endif

                </div>

            </div>

            <!-- GARIS POTONG TIKET -->
            <div class="relative flex items-center py-3">

                <div class="absolute -left-3 w-6 h-6 bg-[#F5F4EC] rounded-full"></div>

                <div class="w-full mx-5 border-t-2 border-dashed border-gray-300"></div>

                <div class="absolute -right-3 w-6 h-6 bg-[#F5F4EC] rounded-full"></div>

            </div>

            <!-- TOTAL PEMBAYARAN -->
            <div class="p-6">

                <p class="text-xs font-semibold text-gray-500">

                    {{ $isPaid ? 'TOTAL PAID' : 'TOTAL HARGA' }}

                </p>

                <h2 class="text-3xl font-black text-[#536B50] mt-2">

                    Rp {{ number_format($booking->total_price, 0, ',', '.') }}

                </h2>

                @if($isPaid && $booking->paid_at)

                    <p class="text-xs text-gray-500 mt-3">

                        Diverifikasi pada:
                        {{ \Carbon\Carbon::parse($booking->paid_at)->format('d M Y, H:i') }}

                    </p>

                @endif

                <!-- INFORMASI STATUS -->
                @if($isPaid)

                    <div class="bg-[#E8EFE2] text-[#536B50] rounded-xl p-4 mt-6 text-center">

                        <p class="font-bold text-sm">
                            PAYMENT VERIFIED
                        </p>

                        <p class="text-xs mt-2">
                            Tunjukkan tiket ini kepada petugas lapangan saat kedatangan.
                        </p>

                        <p class="text-xs mt-2">
                            Pembayaran simulasi MY TENNIS.
                        </p>

                    </div>

                    <!-- BOOKING REFERENCE -->
                    <div class="border-t border-dashed border-gray-300 mt-6 pt-6 text-center">

                        <p class="text-xs text-gray-500 tracking-widest">
                            BOOKING REFERENCE
                        </p>

                        <p class="text-2xl font-black tracking-widest mt-3">
                            {{ $bookingCode }}
                        </p>

                        <p class="text-xs text-gray-500 mt-3">
                            Please show this ticket upon arrival.
                        </p>

                    </div>

                @elseif($booking->status === 'pending')

                    <div class="bg-yellow-50 text-yellow-800 rounded-xl p-4 mt-6">

                        <p class="font-bold text-sm">
                            Waiting Confirmation
                        </p>

                        <p class="text-xs mt-2">
                            Pemesanan sedang menunggu persetujuan seller.
                        </p>

                    </div>

                @elseif($booking->status === 'confirmed')

                    @if($paymentStatus === 'waiting_verification')

                        <div class="bg-yellow-50 text-yellow-800 rounded-xl p-4 mt-6">

                            <p class="font-bold text-sm">
                                Waiting Verification
                            </p>

                            <p class="text-xs mt-2">
                                Tiket akan tersedia setelah pembayaran diverifikasi.
                            </p>

                        </div>

                    @elseif($paymentStatus === 'rejected')

                        <div class="bg-red-50 text-red-700 rounded-xl p-4 mt-6">

                            <p class="font-bold text-sm">
                                Payment Rejected
                            </p>

                            <p class="text-xs mt-2">
                                Silakan kirim ulang bukti pembayaran.
                            </p>

                        </div>

                    @else

                        <div class="bg-[#F5F4EC] rounded-xl p-4 mt-6">

                            <p class="font-bold text-sm">
                                Waiting for Payment
                            </p>

                            <p class="text-xs text-gray-500 mt-2">
                                Selesaikan pembayaran untuk mendapatkan tiket resmi.
                            </p>

                        </div>

                    @endif

                @elseif(in_array($booking->status, ['rejected', 'cancelled', 'canceled']))

                    <div class="bg-red-50 text-red-700 rounded-xl p-4 mt-6">

                        <p class="font-bold text-sm">
                            Booking Unavailable
                        </p>

                        <p class="text-xs mt-2">
                            Booking telah ditolak atau dibatalkan.
                        </p>

                    </div>

                @endif

            </div>

        </div>

        <!-- ACTION BUTTON -->
        <div class="no-print mt-6">

            @if($isPaid)

                <!-- PRINT HANYA JIKA SUDAH BAYAR -->
                <button type="button"
                    onclick="window.print()"
                    class="w-full flex justify-center items-center gap-3 bg-[#536B50] hover:bg-[#40563E] text-white py-4 rounded-xl font-bold transition">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.5">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6 9V3h12v6M6 18H3V9h18v9h-3M6 14h12v8H6z"/>

                    </svg>

                    PRINT / SAVE TICKET

                </button>

            @elseif($booking->status === 'confirmed')

                <a href="{{ route('payment.show', $booking->id) }}"
                    class="block text-center bg-[#536B50] hover:bg-[#40563E] text-white py-4 rounded-xl font-bold">

                    @if($paymentStatus === 'waiting_verification')

                        VIEW PAYMENT

                    @elseif($paymentStatus === 'rejected')

                        PAY AGAIN

                    @else

                        PAY NOW

                    @endif

                </a>

            @endif

            <div class="grid grid-cols-2 gap-4 mt-4">

                <a href="{{ route('booking.index') }}"
                    class="block text-center border-2 border-[#536B50] text-[#536B50] hover:bg-[#536B50] hover:text-white py-3 rounded-xl font-bold text-sm">

                    MY BOOKINGS

                </a>

                <a href="/"
                    class="block text-center border-2 border-[#536B50] text-[#536B50] hover:bg-[#536B50] hover:text-white py-3 rounded-xl font-bold text-sm">

                    BACK TO HOME

                </a>

            </div>

        </div>

        <!-- FOOTER -->
        <div class="no-print text-center mt-8">

            <p class="font-black text-[#536B50]">
                MY TENNIS.
            </p>

            <p class="text-xs text-gray-400 mt-2">
                BOOK YOUR COURT, PLAY YOUR GAME.
            </p>

            <p class="text-xs text-gray-400 mt-4">
                &copy; 2026 MY TENNIS.
            </p>

        </div>

    </main>

</body>
</html>