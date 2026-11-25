<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Payment | MY TENNIS</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#F5F4EC] text-[#35432F]">

    <!-- NAVBAR -->
    <nav class="bg-white flex flex-wrap justify-between items-center gap-4 px-5 md:px-16 py-5">

        <a href="/" class="text-2xl font-black text-[#536B50]">
            MY TENNIS<span class="text-black">.</span>
        </a>

        <a href="{{ route('booking.index') }}"
            class="text-sm font-semibold hover:text-[#687653]">
            MY BOOKINGS
        </a>

    </nav>

    <!-- MAIN CONTENT -->
    <main class="max-w-6xl mx-auto px-5 py-12">

        <p class="text-sm font-bold tracking-widest text-[#687653]">
            COMPLETE YOUR BOOKING
        </p>

        <h1 class="text-3xl md:text-4xl font-black mt-2 mb-3">
            PAYMENT DETAILS
        </h1>

        <p class="text-gray-500 text-sm mb-8">
            Selesaikan pembayaran untuk pemesanan lapanganmu.
        </p>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 rounded-xl p-4 mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 text-red-700 rounded-xl p-4 mb-6">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 text-red-700 rounded-xl p-4 mb-6">
                @foreach($errors->all() as $error)
                    <p class="text-sm">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">

            <!-- BOOKING SUMMARY -->
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

                @if($booking->court->image)

                    <img src="{{ asset('storage/' . $booking->court->image) }}"
                        alt="{{ $booking->court->name }}"
                        class="w-full h-64 object-cover">

                @else

                    <div class="h-64 bg-[#687653] text-white flex items-center justify-center">
                        No Court Image
                    </div>

                @endif

                <div class="p-6">

                    <p class="text-xs font-bold tracking-widest text-[#687653]">
                        BOOKING SUMMARY
                    </p>

                    <h2 class="text-3xl font-black mt-2">
                        {{ $booking->court->name }}
                    </h2>

                    <p class="text-gray-500 text-sm mt-2">
                        {{ $booking->court->venue_name }}
                    </p>

                    <p class="text-gray-500 text-sm mt-1">
                        {{ $booking->court->city }},
                        {{ $booking->court->province }}
                    </p>

                    <div class="border-t border-gray-200 mt-6 pt-5 space-y-4">

                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Booking ID</span>

                            <span class="font-semibold">
                                MT-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}
                            </span>
                        </div>

                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Tanggal Bermain</span>

                            <span class="font-semibold">
                                {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}
                            </span>
                        </div>

                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Jam Bermain</span>

                            <span class="font-semibold">
                                {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }}
                                -
                                {{ \Carbon\Carbon::parse($booking->start_time)->addHours((int) $booking->duration)->format('H:i') }}
                            </span>
                        </div>

                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Durasi</span>

                            <span class="font-semibold">
                                {{ $booking->duration }} Jam
                            </span>
                        </div>

                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-500">Booking Status</span>

                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">
                                Confirmed
                            </span>
                        </div>

                    </div>

                    <div class="bg-[#F5F4EC] rounded-xl p-5 mt-6">

                        <p class="text-sm text-gray-500">
                            Total Payment
                        </p>

                        <h2 class="text-3xl font-black text-[#536B50] mt-2">
                            Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                        </h2>

                    </div>

                </div>

            </div>

            <!-- PAYMENT INFORMATION -->
            <div class="bg-white rounded-2xl shadow-sm p-6 md:p-8">

                <h2 class="text-xl font-black">
                    PAYMENT INFORMATION
                </h2>

                <p class="text-gray-500 text-sm mt-2 mb-6">
                    Informasi dan status pembayaran booking.
                </p>

                <!-- PAYMENT STATUS -->
                @if($booking->payment_status === 'paid')

                    <div class="bg-green-100 text-green-800 rounded-xl p-5 mb-6">

                        <h3 class="font-bold text-lg">
                            Payment Successful
                        </h3>

                        <p class="text-sm mt-2">
                            Pembayaran telah diverifikasi oleh seller.
                        </p>

                        @if($booking->paid_at)
                            <p class="text-xs mt-3">
                                Diverifikasi:
                                {{ $booking->paid_at->format('d M Y, H:i') }}
                            </p>
                        @endif

                    </div>

                @elseif($booking->payment_status === 'waiting_verification')

                    <div class="bg-yellow-100 text-yellow-800 rounded-xl p-5 mb-6">

                        <h3 class="font-bold text-lg">
                            Waiting Verification
                        </h3>

                        <p class="text-sm mt-2">
                            Bukti pembayaran berhasil dikirim.
                            Silakan tunggu seller memverifikasi pembayaranmu.
                        </p>

                    </div>

                @elseif($booking->payment_status === 'rejected')

                    <div class="bg-red-100 text-red-700 rounded-xl p-5 mb-6">

                        <h3 class="font-bold text-lg">
                            Payment Rejected
                        </h3>

                        <p class="text-sm mt-2">
                            Bukti pembayaran ditolak.
                            Silakan upload kembali bukti pembayaran yang benar.
                        </p>

                    </div>

                @else

                    <div class="bg-gray-100 text-gray-700 rounded-xl p-4 mb-6">

                        <p class="font-bold">
                            Unpaid
                        </p>

                        <p class="text-sm mt-1">
                            Booking belum dibayar.
                        </p>

                    </div>

                @endif

                @if(in_array($booking->payment_status, ['unpaid', 'rejected']))

                    <form action="{{ route('payment.store', $booking->id) }}"
                        method="POST"
                        enctype="multipart/form-data">

                        @csrf

                        <!-- PAYMENT METHOD -->
                        <h3 class="font-bold mb-4">
                            Payment Method
                        </h3>

                        <div class="space-y-3">

                            <label class="flex items-center gap-4 border border-gray-300 rounded-xl p-4 cursor-pointer hover:bg-[#F5F4EC]">

                                <input type="radio"
                                    name="payment_method"
                                    value="bank_transfer"
                                    class="accent-[#536B50]"
                                    {{ old('payment_method', 'bank_transfer') === 'bank_transfer' ? 'checked' : '' }}
                                    required>

                                <div>

                                    <p class="font-bold">
                                        Bank Transfer
                                    </p>

                                    <p class="text-xs text-gray-500 mt-1">
                                        Pembayaran melalui transfer bank.
                                    </p>

                                </div>

                            </label>

                            <label class="flex items-center gap-4 border border-gray-300 rounded-xl p-4 cursor-pointer hover:bg-[#F5F4EC]">

                                <input type="radio"
                                    name="payment_method"
                                    value="qris"
                                    class="accent-[#536B50]"
                                    {{ old('payment_method') === 'qris' ? 'checked' : '' }}
                                    required>

                                <div>

                                    <p class="font-bold">
                                        QRIS
                                    </p>

                                    <p class="text-xs text-gray-500 mt-1">
                                        Pembayaran melalui QRIS.
                                    </p>

                                </div>

                            </label>

                        </div>

                        <!-- PAYMENT INSTRUCTIONS -->
                        <div class="bg-[#F5F4EC] rounded-xl p-5 mt-5">

                            <p class="text-xs font-bold tracking-widest text-[#687653]">
                                PAYMENT INSTRUCTIONS
                            </p>

                            <div id="bankInfo" class="mt-3">

                                <p class="font-bold">
                                    Bank Transfer
                                </p>

                                <p class="text-sm text-gray-500 mt-2">
                                    Metode transfer bank masih dalam tahap simulasi.
                                </p>

                            </div>

                            <div id="qrisInfo" class="hidden mt-3">

                                <p class="font-bold">
                                    QRIS Payment
                                </p>

                                <p class="text-sm text-gray-500 mt-2">
                                    Metode pembayaran QRIS masih dalam tahap simulasi.
                                </p>

                            </div>

                            <p class="text-xs text-gray-500 mt-4">
                                Website ini menggunakan simulasi pembayaran.
                                Tidak perlu melakukan transfer uang asli.
                            </p>

                        </div>

                        <!-- UPLOAD PAYMENT PROOF -->
                        <div class="mt-7">

                            <h3 class="font-bold mb-2">
                                Upload Payment Proof
                            </h3>

                            <p class="text-xs text-gray-500 mb-4">
                                Upload gambar bukti pembayaran simulasi.
                            </p>

                            <label for="paymentProof"
                                class="block border-2 border-dashed border-[#B5C1AC] rounded-xl p-7 text-center cursor-pointer hover:bg-[#F5F4EC]">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-9 h-9 mx-auto mb-3 text-[#687653]"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.5">

                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 16V4m-5 5 5-5 5 5M4 16v4h16v-4"/>

                                </svg>

                                <p class="font-bold text-[#536B50]">
                                    Choose File
                                </p>

                                <p class="text-xs text-gray-500 mt-2">
                                    JPG, JPEG, PNG. Maksimal 2 MB.
                                </p>

                                <p id="fileName"
                                    class="text-xs font-semibold mt-3">
                                    Belum ada file dipilih
                                </p>

                            </label>

                            <input type="file"
                                name="payment_proof"
                                id="paymentProof"
                                accept="image/jpeg,image/png"
                                class="sr-only"
                                required>

                            <!-- IMAGE PREVIEW -->
                            <div id="previewContainer"
                                class="hidden mt-4">

                                <img id="imagePreview"
                                    alt="Preview bukti pembayaran"
                                    class="max-h-64 w-full object-contain rounded-xl border border-gray-200 bg-gray-50">

                                <button type="button"
                                    id="removeImage"
                                    class="text-red-600 text-sm font-semibold mt-3">

                                    Remove Image

                                </button>

                            </div>

                            <p id="fileError"
                                class="hidden text-red-600 text-sm mt-3">
                            </p>

                        </div>

                        <!-- SUBMIT BUTTON -->
                        <button type="submit"
                            id="submitPayment"
                            class="w-full bg-[#536B50] hover:bg-[#40563E] text-white font-bold py-4 rounded-xl mt-7 transition disabled:opacity-50">

                            SUBMIT PAYMENT

                        </button>

                    </form>

                @endif

                <a href="{{ route('booking.index') }}"
                    class="block text-center text-sm font-semibold text-[#536B50] border border-[#536B50] rounded-xl py-3 mt-5 hover:bg-[#F5F4EC]">

                    BACK TO MY BOOKINGS

                </a>

            </div>

        </div>

    </main>

    <!-- FOOTER -->
    <footer class="bg-[#35432F] text-white text-center py-8 mt-10">

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

        const methods = document.querySelectorAll(
            'input[name="payment_method"]'
        );

        const bankInfo = document.getElementById('bankInfo');
        const qrisInfo = document.getElementById('qrisInfo');

        function updatePaymentMethod() {

            const selected = document.querySelector(
                'input[name="payment_method"]:checked'
            );

            if (!selected || !bankInfo || !qrisInfo) {
                return;
            }

            bankInfo.classList.toggle(
                'hidden',
                selected.value !== 'bank_transfer'
            );

            qrisInfo.classList.toggle(
                'hidden',
                selected.value !== 'qris'
            );

        }

        methods.forEach(function(method) {

            method.addEventListener(
                'change',
                updatePaymentMethod
            );

        });

        updatePaymentMethod();

        // PREVIEW BUKTI PEMBAYARAN
        const paymentProof = document.getElementById('paymentProof');
        const imagePreview = document.getElementById('imagePreview');
        const previewContainer = document.getElementById('previewContainer');
        const fileName = document.getElementById('fileName');
        const fileError = document.getElementById('fileError');
        const removeImage = document.getElementById('removeImage');
        const submitPayment = document.getElementById('submitPayment');

        let previewUrl = null;

        if (paymentProof) {

            function resetFile() {

                paymentProof.value = '';

                imagePreview.removeAttribute('src');

                previewContainer.classList.add('hidden');

                fileName.textContent = 'Belum ada file dipilih';

                if (previewUrl) {
                    URL.revokeObjectURL(previewUrl);
                    previewUrl = null;
                }

            }

            paymentProof.addEventListener('change', function() {

                fileError.classList.add('hidden');

                const file = paymentProof.files[0];

                if (!file) {
                    resetFile();
                    return;
                }

                const allowedTypes = [
                    'image/jpeg',
                    'image/png'
                ];

                if (!allowedTypes.includes(file.type)) {

                    resetFile();

                    fileError.textContent =
                        'File harus berformat JPG, JPEG atau PNG.';

                    fileError.classList.remove('hidden');

                    return;

                }

                if (file.size > 2 * 1024 * 1024) {

                    resetFile();

                    fileError.textContent =
                        'Ukuran file maksimal 2 MB.';

                    fileError.classList.remove('hidden');

                    return;

                }

                if (previewUrl) {
                    URL.revokeObjectURL(previewUrl);
                }

                previewUrl = URL.createObjectURL(file);

                imagePreview.src = previewUrl;

                fileName.textContent = file.name;

                previewContainer.classList.remove('hidden');

            });

            removeImage.addEventListener('click', function() {

                resetFile();

                fileError.classList.add('hidden');

            });

            paymentProof.form.addEventListener('submit', function(event) {

                if (!paymentProof.files.length) {

                    event.preventDefault();

                    fileError.textContent =
                        'Silakan upload bukti pembayaran terlebih dahulu.';

                    fileError.classList.remove('hidden');

                    return;

                }

                submitPayment.disabled = true;

                submitPayment.textContent = 'PROCESSING...';

            });

        }

    </script>

</body>
</html>