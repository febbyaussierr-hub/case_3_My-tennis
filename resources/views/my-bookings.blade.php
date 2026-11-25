<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Bookings | MY TENNIS</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#F5F4EC] text-[#35432F]">

    <!-- NAVBAR -->
    <nav class="flex flex-wrap justify-between items-center gap-5 px-5 md:px-16 py-5 bg-white">

        <a href="/" class="text-2xl font-black text-[#536B50]">
            MY TENNIS<span class="text-black">.</span>
        </a>

        <div class="flex flex-wrap items-center gap-5 text-sm font-bold">

            <a href="/" class="hover:text-[#687653]">
                HOME
            </a>

            <a href="{{ route('booking.index') }}"
                class="text-[#536B50]">
                MY BOOKINGS
            </a>

            <form action="{{ route('buyer.logout') }}" method="POST">
                @csrf

                <button type="submit"
                    class="bg-[#536B50] hover:bg-[#40563E] text-white px-5 py-3 rounded-lg">
                    LOGOUT
                </button>

            </form>

        </div>

    </nav>

    <!-- MAIN CONTENT -->
    <main class="max-w-5xl mx-auto px-5 py-12">

        <p class="text-[#687653] font-bold tracking-widest text-sm">
            YOUR ACTIVITY
        </p>

        <h1 class="text-3xl md:text-4xl font-black mt-2">
            MY BOOKINGS.
        </h1>

        <p class="text-gray-500 mt-3 mb-8">
            Manage and track all your tennis court reservations.
        </p>

        <!-- NOTIFIKASI -->
        @if(session('success'))
            <div class="bg-green-100 text-green-700 rounded-xl p-4 mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 text-red-700 rounded-xl p-4 mb-6">
                {{ session('error') }}
            </div>
        @endif

        <!-- STATISTIK BOOKING -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">

            <div class="bg-white rounded-2xl p-6 shadow-sm">

                <p class="text-gray-500 text-sm">
                    Total Booking
                </p>

                <h2 class="text-3xl font-black mt-3">
                    {{ $bookings->count() }}
                </h2>

            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm">

                <p class="text-gray-500 text-sm">
                    Pending
                </p>

                <h2 class="text-3xl font-black text-yellow-600 mt-3">
                    {{ $bookings->where('status', 'pending')->count() }}
                </h2>

            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm">

                <p class="text-gray-500 text-sm">
                    Confirmed
                </p>

                <h2 class="text-3xl font-black text-[#536B50] mt-3">
                    {{ $bookings->where('status', 'confirmed')->count() }}
                </h2>

            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm">

                <p class="text-gray-500 text-sm">
                    Paid
                </p>

                <h2 class="text-3xl font-black text-[#536B50] mt-3">
                    {{ $bookings->where('status', 'confirmed')->where('payment_status', 'paid')->count() }}
                </h2>

            </div>

        </div>

        <!-- FILTER BOOKING -->
        <div class="flex flex-wrap gap-3 mb-7">

            <button type="button"
                onclick="filterBookings('all', this)"
                class="filter-button bg-[#536B50] text-white rounded-lg px-5 py-3 text-sm font-semibold">
                All
            </button>

            <button type="button"
                onclick="filterBookings('pending', this)"
                class="filter-button bg-white text-[#536B50] rounded-lg px-5 py-3 text-sm font-semibold">
                Pending
            </button>

            <button type="button"
                onclick="filterBookings('confirmed', this)"
                class="filter-button bg-white text-[#536B50] rounded-lg px-5 py-3 text-sm font-semibold">
                Confirmed
            </button>

            <button type="button"
                onclick="filterBookings('paid', this)"
                class="filter-button bg-white text-[#536B50] rounded-lg px-5 py-3 text-sm font-semibold">
                Paid
            </button>

            <button type="button"
                onclick="filterBookings('cancelled', this)"
                class="filter-button bg-white text-[#536B50] rounded-lg px-5 py-3 text-sm font-semibold">
                Cancelled
            </button>

        </div>

        <!-- DAFTAR BOOKING -->
        <div class="space-y-5">

            @forelse($bookings as $booking)
                @continue(!$booking->court)

                @php

                    $startTime = \Carbon\Carbon::parse(
                        \Carbon\Carbon::parse($booking->booking_date)->format('Y-m-d')
                        . ' ' .
                        $booking->start_time
                    );

                    $endTime = $startTime->copy()
                        ->addHours((int) $booking->duration);

                    $paymentStatus = $booking->payment_status ?? 'unpaid';

                @endphp

                <div class="booking-card bg-white rounded-2xl shadow-sm overflow-hidden"
                    data-status="{{ $booking->status }}"
                    data-payment="{{ $paymentStatus }}">

                    <div class="flex flex-col md:flex-row gap-5 p-5">

                        <!-- FOTO LAPANGAN -->
                        @if($booking->court?->image)

                            <img src="{{ asset('storage/' . $booking->court->image) }}"
                                alt="{{ $booking->court->name }}"
                                class="w-full md:w-56 h-48 md:h-64 object-cover rounded-xl">

                        @else

                            <div class="w-full md:w-56 h-48 md:h-64 bg-[#687653] text-white rounded-xl flex justify-center items-center">

                                <p class="text-sm">
                                    No Court Image
                                </p>

                            </div>

                        @endif

                        <!-- DETAIL BOOKING -->
                        <div class="flex-1">

                            <div class="flex flex-wrap justify-between items-center gap-3">

                                <p class="text-sm text-gray-500 font-semibold">
                                    MT-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}
                                </p>

                                <!-- STATUS BOOKING -->
                                @if($booking->status === 'pending')

                                    <span class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded-full text-xs font-bold">
                                        PENDING
                                    </span>

                                @elseif($booking->status === 'confirmed')

                                    <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-xs font-bold">
                                        CONFIRMED
                                    </span>

                                @elseif(in_array($booking->status, ['cancelled', 'canceled', 'rejected']))

                                    <span class="bg-red-100 text-red-700 px-4 py-2 rounded-full text-xs font-bold">
                                        {{ strtoupper($booking->status) }}
                                    </span>

                                @else

                                    <span class="bg-gray-100 text-gray-700 px-4 py-2 rounded-full text-xs font-bold">
                                        {{ strtoupper($booking->status) }}
                                    </span>

                                @endif

                            </div>

                            <h2 class="text-2xl font-black mt-3">
                                {{ $booking->court->name }}
                            </h2>

                            <p class="text-gray-500 text-sm mt-2">
                                {{ $booking->court->venue_name }}
                            </p>

                            <p class="text-gray-500 text-sm mt-2">
                                {{ $booking->court->city }},
                                {{ $booking->court->province }}
                            </p>

                            <!-- JADWAL BERMAIN -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-5">

                                <div>

                                    <p class="text-xs text-gray-500">
                                        Tanggal Bermain
                                    </p>

                                    <p class="font-semibold mt-1">
                                        {{ $startTime->format('d/m/Y') }}
                                    </p>

                                </div>

                                <div>

                                    <p class="text-xs text-gray-500">
                                        Jam Bermain
                                    </p>

                                    <p class="font-semibold mt-1">

                                        {{ $startTime->format('H:i') }}
                                        -
                                        {{ $endTime->format('H:i') }}

                                        ({{ $booking->duration }} Jam)

                                        @if(!$endTime->isSameDay($startTime))
                                            (Besok)
                                        @endif

                                    </p>

                                </div>

                            </div>

                            <!-- HARGA DAN STATUS PEMBAYARAN -->
                            <div class="flex flex-wrap justify-between items-end gap-4 mt-5">

                                <div>

                                    <p class="text-xs text-gray-500">
                                        Total Harga
                                    </p>

                                    <h3 class="text-2xl font-black text-[#536B50] mt-1">
                                        Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                    </h3>

                                </div>

                                @if($booking->status === 'confirmed')

                                    <div>

                                        <p class="text-xs text-gray-500 mb-2">
                                            Payment Status
                                        </p>

                                        @if($paymentStatus === 'paid')

                                            <span class="inline-block bg-green-100 text-green-700 px-3 py-2 rounded-lg text-xs font-bold">
                                                PAID
                                            </span>

                                        @elseif($paymentStatus === 'waiting_verification')

                                            <span class="inline-block bg-yellow-100 text-yellow-800 px-3 py-2 rounded-lg text-xs font-bold">
                                                WAITING VERIFICATION
                                            </span>

                                        @elseif($paymentStatus === 'rejected')

                                            <span class="inline-block bg-red-100 text-red-700 px-3 py-2 rounded-lg text-xs font-bold">
                                                PAYMENT REJECTED
                                            </span>

                                        @else

                                            <span class="inline-block bg-gray-100 text-gray-700 px-3 py-2 rounded-lg text-xs font-bold">
                                                UNPAID
                                            </span>

                                        @endif

                                    </div>

                                @endif

                            </div>

                        </div>

                    </div>

                    <!-- INFORMASI DAN TOMBOL -->
                    <div class="flex flex-wrap justify-between items-center gap-4 border-t border-gray-100 px-5 py-4">

                        <div class="text-sm text-gray-500">

                            @if($booking->status === 'pending')

                                Menunggu persetujuan seller.

                            @elseif($booking->status === 'confirmed')

                                @if($paymentStatus === 'paid')

                                    Pembayaran telah terverifikasi.

                                @elseif($paymentStatus === 'waiting_verification')

                                    Menunggu verifikasi pembayaran.

                                @elseif($paymentStatus === 'rejected')

                                    Silakan upload ulang bukti pembayaran.

                                @else

                                    Silakan selesaikan pembayaran.

                                @endif

                            @elseif($booking->status === 'rejected')

                                Booking ditolak oleh seller.

                            @elseif(in_array($booking->status, ['cancelled', 'canceled']))

                                Booking telah dibatalkan.

                            @endif

                        </div>

                        <div class="flex flex-wrap gap-3">

                            <!-- DETAIL BOOKING DAN TIKET -->
                            <a href="{{ route('booking.success', $booking->id) }}"
                                class="border border-[#536B50] text-[#536B50] hover:bg-[#F5F4EC] px-5 py-3 rounded-lg text-sm font-bold">

                                @if($booking->status === 'confirmed' && $paymentStatus === 'paid')

                                    VIEW TICKET

                                @else

                                    VIEW DETAILS

                                @endif

                            </a>

                            <!-- TOMBOL PEMBAYARAN -->
                            @if($booking->status === 'confirmed')

                                @if($paymentStatus === 'unpaid')

                                    <a href="{{ route('payment.show', $booking->id) }}"
                                        class="bg-[#536B50] hover:bg-[#40563E] text-white px-6 py-3 rounded-lg text-sm font-bold">

                                        PAY NOW

                                    </a>

                                @elseif($paymentStatus === 'rejected')

                                    <a href="{{ route('payment.show', $booking->id) }}"
                                        class="bg-[#536B50] hover:bg-[#40563E] text-white px-6 py-3 rounded-lg text-sm font-bold">

                                        PAY AGAIN

                                    </a>

                                @elseif($paymentStatus === 'waiting_verification')

                                    <a href="{{ route('payment.show', $booking->id) }}"
                                        class="bg-[#536B50] hover:bg-[#40563E] text-white px-6 py-3 rounded-lg text-sm font-bold">

                                        VIEW PAYMENT

                                    </a>

                                @elseif($paymentStatus === 'paid')

                                    <a href="{{ route('payment.show', $booking->id) }}"
                                        class="bg-[#536B50] hover:bg-[#40563E] text-white px-6 py-3 rounded-lg text-sm font-bold">

                                        PAYMENT DETAILS

                                    </a>

                                @endif

                            @endif

                        </div>

                    </div>

                </div>

            @empty

                <div class="bg-white rounded-2xl p-12 text-center">

                    <h2 class="text-xl font-bold">
                        Belum Ada Pemesanan
                    </h2>

                    <p class="text-gray-500 mt-3">
                        Pesanan kamu akan muncul di sini.
                    </p>

                    <a href="/#booking"
                        class="inline-block mt-6 bg-[#536B50] text-white px-6 py-3 rounded-xl font-bold">

                        BOOK A COURT

                    </a>

                </div>

            @endforelse

        </div>

        <!-- JIKA FILTER KOSONG -->
        <div id="noResults"
            style="display: none;"
            class="bg-white rounded-2xl p-12 text-center">

            <h2 class="text-xl font-bold">
                No Bookings Found
            </h2>

            <p class="text-gray-500 mt-3">
                Belum ada pemesanan dengan status tersebut.
            </p>

        </div>

        <!-- BOOK ANOTHER COURT -->
        <div class="mt-8">

            <a href="/#booking"
                class="inline-block bg-[#536B50] hover:bg-[#40563E] text-white px-7 py-3 rounded-xl font-bold">

                + BOOK ANOTHER COURT

            </a>

        </div>

    </main>

    <!-- FOOTER -->
    <footer class="bg-[#35432F] text-white text-center py-10 mt-8">

        <h2 class="text-2xl font-black">
            MY TENNIS.
        </h2>

        <p class="text-gray-300 text-sm mt-3">
            BOOK YOUR COURT, PLAY YOUR GAME.
        </p>

        <p class="text-gray-400 text-xs mt-6">
            &copy; 2026 MY TENNIS.
        </p>

    </footer>

    <!-- JAVASCRIPT FILTER -->
    <script>

        function filterBookings(status, button) {

            const cards = document.querySelectorAll('.booking-card');

            const buttons = document.querySelectorAll('.filter-button');

            let found = 0;

            buttons.forEach(function(item) {

                item.classList.remove(
                    'bg-[#536B50]',
                    'text-white'
                );

                item.classList.add(
                    'bg-white',
                    'text-[#536B50]'
                );

            });

            button.classList.remove(
                'bg-white',
                'text-[#536B50]'
            );

            button.classList.add(
                'bg-[#536B50]',
                'text-white'
            );

            cards.forEach(function(card) {

                const bookingStatus = card.dataset.status;
                const paymentStatus = card.dataset.payment;

                const isCancelled = [
                    'cancelled',
                    'canceled',
                    'rejected'
                ].includes(bookingStatus);

                const isPaid =
                    bookingStatus === 'confirmed' &&
                    paymentStatus === 'paid';

                if (
                    status === 'all' ||
                    bookingStatus === status ||
                    (status === 'cancelled' && isCancelled) ||
                    (status === 'paid' && isPaid)
                ) {

                    card.style.display = '';
                    found++;

                } else {

                    card.style.display = 'none';

                }

            });

            document.getElementById('noResults').style.display =
                cards.length > 0 && found === 0
                ? 'block'
                : 'none';

        }

    </script>

</body>
</html>