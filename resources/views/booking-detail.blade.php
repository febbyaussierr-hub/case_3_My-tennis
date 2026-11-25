<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Detail | MY TENNIS</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .time-slot {
            background: #E8EDE3;
            color: #35432F;
            padding: 12px 5px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
        }

        .time-slot:hover:not(:disabled) {
            background: #C8D5BE;
        }

        .time-slot.booked {
            background: #F5DEDE;
            color: #B65C5C;
            cursor: not-allowed;
        }

        .time-slot.past {
            background: #EEEEEE;
            color: #AAAAAA;
            cursor: not-allowed;
        }

        .time-slot.selected {
            background: #536B50;
            color: white;
        }

        .time-slot.selected:hover {
            background: #40563E;
        }

        button:disabled {
            cursor: not-allowed;
        }
    </style>
</head>

<body class="min-h-screen bg-[#F5F4EC] text-[#35432F]">

    <!-- NAVBAR -->
    <nav class="flex flex-wrap justify-between items-center gap-4 px-5 md:px-16 py-5 bg-white">

        <a href="/" class="text-2xl font-black text-[#536B50]">
            MY TENNIS<span class="text-black">.</span>
        </a>

        <a href="/#booking"
            class="text-sm font-semibold hover:text-[#687653]">
            BACK TO BOOKING
        </a>

    </nav>

    <!-- MAIN CONTENT -->
    <main class="max-w-6xl mx-auto px-5 py-12">

        <p class="text-[#687653] font-bold tracking-widest text-sm">
            YOUR BOOKING
        </p>

        <h1 class="text-3xl md:text-4xl font-black mt-2 mb-8">
            BOOK YOUR COURT
        </h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">

            <!-- DETAIL LAPANGAN -->
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

                @if($court->image)

                    <img src="{{ asset('storage/' . $court->image) }}"
                        alt="{{ $court->name }}"
                        class="w-full h-72 object-cover">

                @else

                    <div class="h-72 bg-[#687653] text-white flex items-center justify-center">
                        No Court Image
                    </div>

                @endif

                <div class="p-6">

                    <p class="text-[#687653] font-bold text-sm">
                        TENNIS COURT
                    </p>

                    <h2 class="text-3xl font-black mt-2">
                        {{ $court->name }}
                    </h2>

                    <p class="text-gray-500 mt-2">
                        {{ $court->venue_name }}
                    </p>

                    <p class="text-gray-500 text-sm mt-3">
                        {{ $court->city }}, {{ $court->province }}
                    </p>

                    @if($court->address)

                        <p class="text-gray-500 text-sm mt-2">
                            {{ $court->address }}
                        </p>

                    @endif

                    <div class="bg-[#F5F4EC] rounded-xl p-4 mt-6">

                        <p class="text-sm text-gray-500">
                            Price per hour
                        </p>

                        <p class="text-[#536B50] font-black text-2xl mt-1">
                            Rp {{ number_format($court->price_per_hour, 0, ',', '.') }}

                            <span class="text-sm font-normal">
                                / jam
                            </span>
                        </p>

                    </div>

                    <div class="border-t border-gray-200 mt-6 pt-5">

                        <h3 class="font-bold mb-3">
                            Description
                        </h3>

                        <p class="text-gray-500 text-sm leading-relaxed">
                            {{ $court->description ?: 'Belum ada deskripsi lapangan.' }}
                        </p>

                    </div>

                    <div class="border-t border-gray-200 mt-6 pt-5">

                        <h3 class="font-bold mb-3">
                            Opening Hours
                        </h3>

                        <p class="text-gray-500 text-sm">
                            Senin - Minggu
                        </p>

                        <p class="font-semibold mt-2">
                            06.00 - 22.00
                        </p>

                    </div>

                </div>

            </div>

            <!-- FORM PEMESANAN -->
            <div class="bg-white rounded-2xl shadow-sm p-6 md:p-8">

                <h2 class="text-xl font-black">
                    BOOKING INFORMATION
                </h2>

                <p class="text-gray-500 text-sm mt-2 mb-6">
                    Pilih tanggal dan jadwal bermain yang tersedia.
                </p>

                @if($errors->any())

                    <div class="bg-red-100 text-red-700 rounded-xl p-4 mb-5">

                        @foreach($errors->all() as $error)

                            <p class="text-sm">{{ $error }}</p>

                        @endforeach

                    </div>

                @endif

                @if(session('error'))

                    <div class="bg-red-100 text-red-700 rounded-xl p-4 mb-5">
                        {{ session('error') }}
                    </div>

                @endif

                <form action="{{ route('booking.store', $court->id) }}"
                    method="POST" id="bookingForm">

                    @csrf

                    <!-- TANGGAL -->
                    <div class="mb-6">

                        <label for="bookingDate"
                            class="block font-semibold mb-2">
                            Tanggal Bermain
                        </label>

                        <input type="date"
                            name="booking_date"
                            id="bookingDate"
                            min="{{ now()->format('Y-m-d') }}"
                            value="{{ old('booking_date', now()->format('Y-m-d')) }}"
                            required
                            class="w-full border border-gray-300 rounded-xl px-4 py-3">

                    </div>

                    <!-- AVAILABLE SCHEDULE -->
                    <div class="mb-6">

                        <h3 class="font-bold mb-2">
                            Available Schedule
                        </h3>

                        <p class="text-xs text-gray-500 mb-4">
                            Pilih jam mulai bermain.
                        </p>

                        <!-- KETERANGAN WARNA -->
                        <div class="flex flex-wrap gap-4 text-xs mb-5">

                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded bg-[#E8EDE3]"></span>
                                Available
                            </div>

                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded bg-[#F5DEDE]"></span>
                                Booked
                            </div>

                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded bg-[#536B50]"></span>
                                Selected
                            </div>

                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded bg-[#EEEEEE]"></span>
                                Unavailable
                            </div>

                        </div>

                        <!-- PILIHAN JAM -->
                        <div id="scheduleGrid"
                            class="grid grid-cols-4 gap-2">
                        </div>

                        <input type="hidden"
                            name="start_time"
                            id="startTime"
                            value="{{ old('start_time') }}">

                    </div>

                    <!-- DURASI -->
                    <div class="mb-5">

                        <label for="duration"
                            class="block font-semibold mb-2">
                            Durasi Bermain
                        </label>

                        <select name="duration"
                            id="duration"
                            required
                            class="w-full border border-gray-300 rounded-xl px-4 py-3">

                            @for($i = 1; $i <= 4; $i++)

                                <option value="{{ $i }}"
                                    {{ old('duration', 1) == $i ? 'selected' : '' }}>
                                    {{ $i }} Jam
                                </option>

                            @endfor

                        </select>

                    </div>

                    <!-- PERINGATAN JADWAL -->
                    <div id="scheduleError"
                        class="hidden bg-red-100 text-red-700 rounded-lg p-3 text-sm mb-5">
                    </div>

                    <!-- BOOKING SUMMARY -->
                    <div class="bg-[#F5F4EC] rounded-xl p-5 mt-6">

                        <h3 class="font-bold mb-5">
                            Booking Summary
                        </h3>

                        <div class="flex justify-between text-sm mb-3">

                            <span class="text-gray-500">
                                Harga per jam
                            </span>

                            <span class="font-semibold">
                                Rp {{ number_format($court->price_per_hour, 0, ',', '.') }}
                            </span>

                        </div>

                        <div class="flex justify-between text-sm mb-3">

                            <span class="text-gray-500">
                                Jam Mulai
                            </span>

                            <span id="startTimeText"
                                class="font-semibold">
                                -
                            </span>

                        </div>

                        <div class="flex justify-between text-sm mb-3">

                            <span class="text-gray-500">
                                Jam Selesai
                            </span>

                            <span id="endTime"
                                class="font-semibold">
                                -
                            </span>

                        </div>

                        <div class="flex justify-between text-sm mb-4">

                            <span class="text-gray-500">
                                Durasi
                            </span>

                            <span id="durationText"
                                class="font-semibold">
                                1 Jam
                            </span>

                        </div>

                        <div class="border-t border-gray-300 pt-4">

                            <p class="text-gray-500 text-sm">
                                Total Harga
                            </p>

                            <h2 id="totalPrice"
                                class="text-3xl font-black text-[#536B50] mt-2">
                                Rp 0
                            </h2>

                        </div>

                    </div>

                    <!-- TOMBOL BOOKING -->
                    @auth

                        @if(auth()->user()->role == 'buyer')

                            <button type="submit"
                                id="confirmButton"
                                disabled
                                class="w-full mt-6 bg-[#536B50] hover:bg-[#40563E] text-white py-4 rounded-xl font-bold transition disabled:opacity-50">

                                CONFIRM BOOKING

                            </button>

                        @else

                            <div class="bg-yellow-100 text-yellow-800 rounded-xl p-4 mt-6 text-center text-sm">
                                Silakan gunakan akun buyer untuk memesan lapangan.
                            </div>

                        @endif

                    @else

                        <a href="{{ route('buyer.login') }}"
                            class="block text-center w-full mt-6 bg-[#536B50] hover:bg-[#40563E] text-white py-4 rounded-xl font-bold">

                            LOGIN TO BOOK

                        </a>

                    @endauth

                </form>

            </div>

        </div>

    </main>

    <!-- FOOTER -->
    <footer class="bg-[#35432F] text-white text-center py-7 mt-8">

        <h2 class="text-xl font-black">
            MY TENNIS.
        </h2>

        <p class="text-gray-300 text-xs mt-3">
            BOOK YOUR COURT, PLAY YOUR GAME.
        </p>

        <p class="text-gray-400 text-xs mt-5">
            &copy; 2026 MY TENNIS.
        </p>

    </footer>

    <!-- JAVASCRIPT -->
    <script>

        const pricePerHour = Number(@json($court->price_per_hour));

        const bookedSchedules = @json($bookedSchedules);

        const bookingDate = document.getElementById('bookingDate');
        const startTime = document.getElementById('startTime');
        const duration = document.getElementById('duration');
        const scheduleGrid = document.getElementById('scheduleGrid');
        const scheduleError = document.getElementById('scheduleError');

        const totalPrice = document.getElementById('totalPrice');
        const durationText = document.getElementById('durationText');
        const startTimeText = document.getElementById('startTimeText');
        const endTime = document.getElementById('endTime');
        const confirmButton = document.getElementById('confirmButton');

        const openingHour = 6;
        const closingHour = 22;

        let selectedTime = startTime.value;

        function formatTime(hour) {
            return String(hour).padStart(2, '0') + ':00';
        }

        function timeToMinutes(time) {
            const parts = time.split(':');

            return Number(parts[0]) * 60 + Number(parts[1]);
        }

        // Mengecek apakah jadwal sudah dipesan
        function isBooked(hour) {

            const slotStart = hour * 60;
            const slotEnd = slotStart + 60;

            return bookedSchedules.some(function(booking) {

                if (booking.date !== bookingDate.value) {
                    return false;
                }

                const bookedStart = timeToMinutes(booking.time);

                const bookedEnd = bookedStart +
                    Number(booking.duration) * 60;

                return slotStart < bookedEnd &&
                    slotEnd > bookedStart;

            });

        }

        // Mengecek waktu yang sudah lewat
        function isPast(hour) {

            const slotDate = new Date(
                bookingDate.value + 'T' + formatTime(hour) + ':00'
            );

            return slotDate <= new Date();

        }

        // Menampilkan peringatan
        function showError(message) {

            scheduleError.textContent = message;
            scheduleError.classList.remove('hidden');

        }

        function hideError() {

            scheduleError.textContent = '';
            scheduleError.classList.add('hidden');

        }

        // Mengecek pilihan jadwal dan durasi
        function validateSchedule() {

            hideError();

            if (!bookingDate.value || !selectedTime) {
                return false;
            }

            const selectedHour = Number(selectedTime.split(':')[0]);
            const hours = Number(duration.value);

            if (
                selectedTime !== formatTime(selectedHour) ||
                selectedHour < openingHour ||
                selectedHour + hours > closingHour
            ) {

                showError('Durasi bermain harus berada dalam jam operasional.');

                return false;

            }

            for (let hour = selectedHour;
                hour < selectedHour + hours;
                hour++) {

                if (isBooked(hour)) {

                    showError('Durasi yang dipilih bertabrakan dengan jadwal lain.');

                    return false;

                }

                if (isPast(hour)) {

                    showError('Jam bermain yang dipilih sudah lewat.');

                    return false;

                }

            }

            return true;

        }

        // Menampilkan kotak jadwal
        function renderSchedule() {

            scheduleGrid.innerHTML = '';

            const valid = validateSchedule();

            const selectedHour = selectedTime
                ? Number(selectedTime.split(':')[0])
                : -1;

            const hours = Number(duration.value);

            for (let hour = openingHour; hour < closingHour; hour++) {

                const button = document.createElement('button');

                button.type = 'button';
                button.className = 'time-slot';
                button.textContent = formatTime(hour);

                if (isBooked(hour)) {

                    button.classList.add('booked');
                    button.disabled = true;

                } else if (!bookingDate.value || isPast(hour)) {

                    button.classList.add('past');
                    button.disabled = true;

                } else {

                    if (
                        valid &&
                        hour >= selectedHour &&
                        hour < selectedHour + hours
                    ) {

                        button.classList.add('selected');

                    }

                    button.addEventListener('click', function() {

                        selectedTime = formatTime(hour);

                        startTime.value = selectedTime;

                        updateBooking();

                    });

                }

                scheduleGrid.appendChild(button);

            }

        }

        // Menghitung total harga
        function updateBooking() {

            const hours = Number(duration.value);

            const total = pricePerHour * hours;

            totalPrice.textContent =
                'Rp ' + total.toLocaleString('id-ID');

            durationText.textContent = hours + ' Jam';

            if (selectedTime) {

                const selectedHour =
                    Number(selectedTime.split(':')[0]);

                startTimeText.textContent = selectedTime;

                endTime.textContent =
                    formatTime(selectedHour + hours);

            } else {

                startTimeText.textContent = '-';
                endTime.textContent = '-';

            }

            const valid = validateSchedule();

            if (confirmButton) {

                confirmButton.disabled = !valid;

            }

            renderSchedule();

        }

        // Ketika tanggal diganti
        bookingDate.addEventListener('change', function() {

            selectedTime = '';
            startTime.value = '';

            updateBooking();

        });

        // Ketika durasi diganti
        duration.addEventListener('change', updateBooking);

        // Mengecek sebelum form dikirim
        document.getElementById('bookingForm')
            .addEventListener('submit', function(event) {

                if (!validateSchedule()) {

                    event.preventDefault();

                    if (!selectedTime) {

                        showError('Silakan pilih jam bermain terlebih dahulu.');

                    }

                }

            });

        updateBooking();

    </script>

</body>
</html>