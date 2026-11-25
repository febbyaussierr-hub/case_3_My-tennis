
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Booking Management | MY TENNIS</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-tennis-cream text-tennis-dark min-h-screen">

    <!-- NAVBAR -->
    <nav class="bg-tennis-olive text-white px-6 py-5 flex flex-wrap justify-between items-center gap-4">
        <a href="/" class="text-2xl font-black">
            MY TENNIS.
        </a>

        <div class="flex items-center gap-5">
            <span class="text-sm">
                Hi, {{ auth()->user()->name }}
            </span>

            <form action="{{ route('seller.logout') }}" method="POST">
                @csrf

                <button type="submit"
                    class="bg-white text-tennis-olive px-5 py-2 rounded-lg font-bold text-sm">
                    LOGOUT
                </button>
            </form>
        </div>
    </nav>

    <div class="flex flex-col md:flex-row min-h-screen">

        <!-- SIDEBAR -->
        <aside class="w-full md:w-64 md:shrink-0 bg-white p-6 border-r border-gray-100">
            <p class="text-xs font-bold text-gray-400 mb-6">
                SELLER DASHBOARD
            </p>

            <div class="space-y-2">
                <a href="{{ route('seller.courts.index') }}"
                    class="block px-4 py-3 rounded-lg hover:bg-[#F1F4ED] transition">
                    Dashboard
                </a>

                <a href="{{ route('seller.courts.index') }}#my-courts"
                    class="block px-4 py-3 rounded-lg hover:bg-[#F1F4ED] transition">
                    My Courts
                </a>

                <a href="{{ route('seller.bookings.index') }}"
                    class="block bg-[#E1E9D9] text-tennis-olive px-4 py-3 rounded-lg font-bold">
                    Bookings
                </a>

                <a href="{{ route('seller.courts.index') }}#trash"
                    class="flex justify-between items-center px-4 py-3 rounded-lg hover:bg-[#F1F4ED] transition">
                    <span>Trash</span>
                </a>

                <a href="/"
                    class="block px-4 py-3 rounded-lg hover:bg-[#F1F4ED] transition">
                    Main Website
                </a>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="flex-1 min-w-0 p-6 md:p-10">

            <p class="text-sm font-bold text-tennis-green tracking-widest">
                SELLER MANAGEMENT
            </p>

            <h1 class="text-3xl font-black mt-2">
                Booking Management
            </h1>

            <p class="text-gray-500 mt-3 mb-8">
                Kelola semua pemesanan dan pembayaran lapangan tenis kamu.
            </p>

            <!-- NOTIFIKASI -->
            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-4 rounded-xl mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-6">
                    {{ session('error') }}
                </div>
            @endif

            <!-- STATISTIK -->
            @php
                $confirmedBookings = $bookings->where('status', 'confirmed');

                $statistics = [
                    ['Total Booking', $bookings->count(), 'text-tennis-dark'],
                    ['Pending', $bookings->where('status', 'pending')->count(), 'text-yellow-600'],
                    ['Confirmed', $confirmedBookings->count(), 'text-tennis-olive'],
                    ['Rejected', $bookings->where('status', 'rejected')->count(), 'text-red-600'],
                    ['Waiting Verification', $confirmedBookings->where('payment_status', 'waiting_verification')->count(), 'text-yellow-600'],
                    ['Paid', $confirmedBookings->where('payment_status', 'paid')->count(), 'text-tennis-olive'],
                ];
            @endphp

            <div class="grid grid-cols-2 lg:grid-cols-3 2xl:grid-cols-6 gap-4 mb-8">
                @foreach($statistics as $stat)
                    <div class="bg-white rounded-2xl p-5 shadow-sm">
                        <p class="text-sm text-gray-500">
                            {{ $stat[0] }}
                        </p>

                        <h2 class="text-3xl font-black mt-3 {{ $stat[2] }}">
                            {{ $stat[1] }}
                        </h2>
                    </div>
                @endforeach
            </div>

            <!-- FILTER BOOKING -->
            @php
                $filters = [
                    'all' => 'All',
                    'pending' => 'Pending',
                    'confirmed' => 'Confirmed',
                    'rejected' => 'Rejected',
                    'waiting_verification' => 'Waiting Verification',
                    'paid' => 'Paid',
                ];
            @endphp

            <div class="flex flex-wrap gap-3 mb-8">
                @foreach($filters as $status => $label)
                    <button
                        type="button"
                        onclick="filterBookings('{{ $status }}', this)"
                        class="filter-button px-5 py-3 rounded-lg font-semibold text-sm {{ $status === 'all' ? 'bg-tennis-olive text-white' : 'bg-white text-tennis-olive' }}">
                        {{ $label }}
                    </button>
                @endforeach
            </div>

            <h2 class="text-xl font-black mb-5">
                Incoming Bookings
            </h2>

            <!-- DAFTAR BOOKING -->
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 items-start">

                @forelse($bookings as $booking)
                    @php
                        $startTime = \Carbon\Carbon::parse(
                            \Carbon\Carbon::parse($booking->booking_date)->format('Y-m-d')
                            . ' ' . $booking->start_time
                        );

                        $endTime = $startTime->copy()
                            ->addHours((int) $booking->duration);

                        $paymentStatus = $booking->payment_status ?? 'unpaid';
                    @endphp

                    <div
                        class="booking-card bg-white rounded-2xl overflow-hidden shadow-sm"
                        data-status="{{ $booking->status }}"
                        data-payment="{{ $paymentStatus }}">

                        <!-- FOTO LAPANGAN -->
                        @if($booking->court->image)
                            <img
                                src="{{ asset('storage/' . $booking->court->image) }}"
                                alt="{{ $booking->court->name }}"
                                class="w-full h-48 object-cover">
                        @else
                            <div class="h-48 bg-tennis-green text-white flex items-center justify-center">
                                <p class="text-sm">
                                    No Court Image
                                </p>
                            </div>
                        @endif

                        <div class="p-6">

                            <!-- ID DAN STATUS -->
                            <div class="flex flex-wrap justify-between items-center gap-3">
                                <p class="text-gray-500 text-sm font-bold">
                                    MT-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}
                                </p>

                                @php
                                    $bookingStatusClass = match ($booking->status) {
                                        'pending' => 'bg-yellow-100 text-yellow-700',
                                        'confirmed' => 'bg-green-100 text-green-700',
                                        'rejected', 'cancelled', 'canceled' => 'bg-red-100 text-red-700',
                                        default => 'bg-gray-100 text-gray-700',
                                    };
                                @endphp

                                <span class="px-4 py-2 rounded-full text-xs font-bold {{ $bookingStatusClass }}">
                                    {{ strtoupper($booking->status) }}
                                </span>
                            </div>

                            <!-- NAMA LAPANGAN -->
                            <h2 class="text-2xl font-black mt-4">
                                {{ $booking->court->name }}
                            </h2>

                            <p class="text-gray-500 text-sm mt-2">
                                {{ $booking->court->venue_name }}
                            </p>

                            <!-- INFORMASI BUYER -->
                            <div class="border-t border-gray-200 mt-5 pt-5 space-y-4">

                                <div>
                                    <p class="text-xs text-gray-500">
                                        Nama Pemesan
                                    </p>

                                    <p class="font-bold mt-1">
                                        {{ $booking->user->name ?? 'Pengguna tidak tersedia' }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-xs text-gray-500">
                                        Email Buyer
                                    </p>

                                    <p class="font-semibold text-sm mt-1 wrap-break-word">
                                        {{ $booking->user->email ?? '-' }}
                                    </p>
                                </div>

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

                            <!-- TOTAL HARGA -->
                            <div class="bg-tennis-cream rounded-xl p-4 mt-6">
                                <p class="text-sm text-gray-500">
                                    Total Harga
                                </p>

                                <h3 class="text-2xl font-black text-tennis-olive mt-2">
                                    Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                </h3>
                            </div>

                            <!-- KONFIRMASI BOOKING -->
                            @if($booking->status === 'pending')

                                <div class="grid grid-cols-2 gap-3 mt-6">

                                    <form
                                        action="{{ route('seller.bookings.confirm', $booking->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Konfirmasi pemesanan ini?')">

                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            class="w-full bg-tennis-olive hover:bg-[#40563E] text-white py-3 rounded-lg font-bold text-sm">
                                            CONFIRM
                                        </button>
                                    </form>

                                    <form
                                        action="{{ route('seller.bookings.reject', $booking->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menolak pemesanan ini?')">

                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            class="w-full bg-red-100 hover:bg-red-200 text-red-700 py-3 rounded-lg font-bold text-sm">
                                            REJECT
                                        </button>
                                    </form>

                                </div>

                            @elseif($booking->status === 'confirmed')

                                <!-- INFORMASI PEMBAYARAN -->
                                <div class="border-t border-gray-200 mt-6 pt-6">

                                    <h3 class="font-black text-lg">
                                        Payment Information
                                    </h3>

                                    <p class="text-xs text-gray-500 mt-1 mb-5">
                                        Kelola pembayaran dari buyer.
                                    </p>

                                    <!-- PAYMENT STATUS -->
                                    <div class="flex flex-wrap justify-between items-center gap-3 mb-4">

                                        <span class="text-sm text-gray-500">
                                            Payment Status
                                        </span>

                                        @if($paymentStatus === 'paid')
                                            <span class="bg-green-100 text-green-700 px-3 py-2 rounded-lg text-xs font-bold">
                                                PAID
                                            </span>
                                        @elseif($paymentStatus === 'waiting_verification')
                                            <span class="bg-yellow-100 text-yellow-800 px-3 py-2 rounded-lg text-xs font-bold">
                                                WAITING VERIFICATION
                                            </span>
                                        @elseif($paymentStatus === 'rejected')
                                            <span class="bg-red-100 text-red-700 px-3 py-2 rounded-lg text-xs font-bold">
                                                PAYMENT REJECTED
                                            </span>
                                        @else
                                            <span class="bg-gray-100 text-gray-700 px-3 py-2 rounded-lg text-xs font-bold">
                                                UNPAID
                                            </span>
                                        @endif

                                    </div>

                                    <!-- PAYMENT METHOD -->
                                    @if($booking->payment_method)
                                        <div class="flex justify-between items-center gap-3 mb-5">

                                            <span class="text-sm text-gray-500">
                                                Payment Method
                                            </span>

                                            <span class="text-sm font-bold">
                                                {{ $booking->payment_method === 'bank_transfer'
                                                    ? 'Bank Transfer'
                                                    : ($booking->payment_method === 'qris' ? 'QRIS' : '-') }}
                                            </span>

                                        </div>
                                    @endif

                                    <!-- BUKTI PEMBAYARAN -->
                                    @if($booking->payment_proof)

                                        <div class="bg-tennis-cream rounded-xl p-4 mt-4">

                                            <p class="text-sm font-bold mb-4">
                                                Payment Proof
                                            </p>

                                            <a
                                                href="{{ route('seller.bookings.payment-proof', $booking->id) }}"
                                                target="_blank"
                                                rel="noopener noreferrer">

                                                <img
                                                    src="{{ route('seller.bookings.payment-proof', $booking->id) }}"
                                                    alt="Bukti pembayaran"
                                                    loading="lazy"
                                                    class="w-full max-h-64 object-contain rounded-lg bg-white border border-gray-200">
                                            </a>

                                            <a
                                                href="{{ route('seller.bookings.payment-proof', $booking->id) }}"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                class="block text-center border border-tennis-olive text-tennis-olive rounded-lg py-3 mt-4 text-sm font-bold hover:bg-white">
                                                VIEW PAYMENT PROOF
                                            </a>

                                        </div>

                                    @endif

                                    <!-- VERIFIKASI PEMBAYARAN -->
                                    @if($paymentStatus === 'waiting_verification')

                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-5">

                                            <form
                                                action="{{ route('seller.bookings.verify-payment', $booking->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Pastikan bukti pembayaran sudah benar. Verifikasi pembayaran ini?')">

                                                @csrf
                                                @method('PATCH')

                                                <button
                                                    type="submit"
                                                    class="w-full bg-tennis-olive hover:bg-[#40563E] text-white py-3 rounded-lg font-bold text-sm">
                                                    VERIFY PAYMENT
                                                </button>
                                            </form>

                                            <form
                                                action="{{ route('seller.bookings.reject-payment', $booking->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin menolak pembayaran ini?')">

                                                @csrf
                                                @method('PATCH')

                                                <button
                                                    type="submit"
                                                    class="w-full bg-red-100 hover:bg-red-200 text-red-700 py-3 rounded-lg font-bold text-sm">
                                                    REJECT PAYMENT
                                                </button>
                                            </form>

                                        </div>

                                    @elseif($paymentStatus === 'paid')

                                        <div class="bg-green-50 text-green-700 rounded-xl p-4 mt-5">

                                            <p class="font-bold text-sm">
                                                Payment Successful
                                            </p>

                                            <p class="text-xs mt-2">
                                                Pembayaran telah berhasil diverifikasi.
                                            </p>

                                            @if($booking->paid_at)
                                                <p class="text-xs mt-2">
                                                    Diverifikasi pada:
                                                    {{ \Carbon\Carbon::parse($booking->paid_at)->format('d M Y, H:i') }}
                                                </p>
                                            @endif

                                        </div>

                                    @elseif($paymentStatus === 'rejected')

                                        <div class="bg-red-50 text-red-700 rounded-xl p-4 mt-5">

                                            <p class="font-bold text-sm">
                                                Payment Rejected
                                            </p>

                                            <p class="text-xs mt-2">
                                                Menunggu buyer mengirim ulang bukti pembayaran.
                                            </p>

                                        </div>

                                    @else

                                        <div class="bg-gray-100 text-gray-600 rounded-xl p-4 mt-5">

                                            <p class="font-bold text-sm">
                                                Waiting for Payment
                                            </p>

                                            <p class="text-xs mt-2">
                                                Booking telah dikonfirmasi.
                                                Menunggu buyer melakukan pembayaran.
                                            </p>

                                        </div>

                                    @endif

                                </div>

                            @elseif($booking->status === 'rejected')

                                <div class="bg-red-50 text-red-700 rounded-lg p-3 mt-6 text-center text-sm font-semibold">
                                    Booking telah ditolak.
                                </div>

                            @endif

                        </div>
                    </div>

                @empty

                    <!-- BELUM ADA BOOKING -->
                    <div class="col-span-full bg-white rounded-2xl p-12 text-center">

                        <h2 class="text-xl font-black">
                            Belum Ada Booking
                        </h2>

                        <p class="text-gray-500 mt-3">
                            Pemesanan dari buyer akan muncul di sini.
                        </p>

                    </div>

                @endforelse

            </div>

            <!-- FILTER KOSONG -->
            <div
                id="noResults"
                style="display: none;"
                class="bg-white rounded-2xl p-10 text-center">

                <h2 class="text-xl font-bold">
                    No Bookings Found
                </h2>

                <p class="text-gray-500 mt-3">
                    Tidak ada booking dengan status tersebut.
                </p>

            </div>

            <!-- FOOTER -->
            <footer class="text-center text-gray-400 text-xs mt-12 py-5">
                &copy; 2026 MY TENNIS.
            </footer>

        </main>
    </div>

    <!-- JAVASCRIPT FILTER -->
    <script>
        function filterBookings(status, button) {

            const cards = document.querySelectorAll('.booking-card');
            const buttons = document.querySelectorAll('.filter-button');

            let found = 0;

            // RESET SEMUA TOMBOL
            buttons.forEach(function(item) {
                item.classList.remove(
                    'bg-tennis-olive',
                    'text-white'
                );

                item.classList.add(
                    'bg-white',
                    'text-tennis-olive'
                );
            });

            // AKTIFKAN TOMBOL YANG DIPILIH
            button.classList.remove(
                'bg-white',
                'text-tennis-olive'
            );

            button.classList.add(
                'bg-tennis-olive',
                'text-white'
            );

            // FILTER KARTU BOOKING
            cards.forEach(function(card) {

                const bookingStatus = card.dataset.status;
                const paymentStatus = card.dataset.payment;

                const isPaymentFilter = [
                    'waiting_verification',
                    'paid'
                ].includes(status);

                const isVisible =
                    status === 'all' ||
                    (
                        isPaymentFilter
                            ? bookingStatus === 'confirmed' &&
                              paymentStatus === status
                            : bookingStatus === status
                    );

                if (isVisible) {
                    card.style.display = '';
                    found++;
                } else {
                    card.style.display = 'none';
                }
            });

            // TAMPILKAN PESAN JIKA FILTER KOSONG
            document.getElementById('noResults').style.display =
                cards.length > 0 && found === 0
                    ? 'block'
                    : 'none';
        }
    </script>

</body>
</html>
