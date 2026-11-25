
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Dashboard | MY TENNIS</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-tennis-cream text-tennis-dark">

    <!-- NAVBAR -->
    <nav class="bg-tennis-olive text-white px-6 py-5 flex flex-wrap justify-between items-center gap-4">

        <a href="/" class="text-2xl font-black tracking-tight">
            MY TENNIS.
        </a>

        <div class="flex items-center gap-5">

            <span class="text-sm text-white/90">
                Hi, {{ auth()->user()->name }}
            </span>

            <form action="{{ route('seller.logout') }}" method="POST">
                @csrf

                <button type="submit"
                    class="bg-white text-tennis-olive hover:bg-tennis-cream px-5 py-3 rounded-lg text-sm font-bold transition">
                    LOGOUT
                </button>
            </form>

        </div>
    </nav>

    <div class="md:flex min-h-[calc(100vh-80px)]">

        <!-- SIDEBAR -->
        <aside class="w-full md:w-64 md:shrink-0 bg-white p-6 border-r border-gray-100">

            <p class="text-xs font-bold text-gray-400 mb-6">
                SELLER DASHBOARD
            </p>

            <div class="space-y-2">

                <a href="{{ route('seller.courts.index') }}"
                    class="block bg-[#E1E9D9] text-tennis-olive px-4 py-3 rounded-lg font-bold">
                    Dashboard
                </a>

                <a href="#my-courts"
                    class="block px-4 py-3 rounded-lg hover:bg-[#F1F4ED] transition">
                    My Courts
                </a>

                <a href="{{ route('seller.bookings.index') }}"
                    class="block px-4 py-3 rounded-lg hover:bg-[#F1F4ED] transition">
                    Bookings
                </a>

                <a href="#trash"
                    class="flex justify-between items-center px-4 py-3 rounded-lg hover:bg-[#F1F4ED] transition">

                    <span>Trash</span>

                    <span class="bg-tennis-light text-tennis-olive text-xs font-bold px-2 py-1 rounded-full">
                        {{ $trashedCourts->count() }}
                    </span>

                </a>

                <a href="/"
                    class="block px-4 py-3 rounded-lg hover:bg-[#F1F4ED] transition">
                    Main Website
                </a>

            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="flex-1 min-w-0 p-6 md:p-10">

            <div class="mb-8">

                <p class="text-sm font-bold tracking-widest text-tennis-green">
                    SELLER ACCOUNT
                </p>

                <h1 class="text-3xl font-black mt-2">
                    Seller Dashboard
                </h1>

                <p class="text-gray-500 mt-2">
                    Welcome back, {{ auth()->user()->name }}!
                    Manage your tennis courts here.
                </p>

            </div>

            <!-- NOTIFICATIONS -->
            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-4 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-6">
                    {{ session('error') }}
                </div>
            @endif

            <!-- STATISTICS -->
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-10">

                <!-- TOTAL COURTS -->
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">

                    <p class="text-sm text-gray-500">
                        Total Courts
                    </p>

                    <h2 class="text-3xl font-bold mt-3">
                        {{ $courts->count() }}
                    </h2>

                </div>

                <!-- ACTIVE COURTS -->
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">

                    <p class="text-sm text-gray-500">
                        Active Courts
                    </p>

                    <h2 class="text-3xl font-bold text-green-700 mt-3">
                        {{ $courts->where('status', 'active')->count() }}
                    </h2>

                </div>

                <!-- INACTIVE COURTS -->
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">

                    <p class="text-sm text-gray-500">
                        Inactive Courts
                    </p>

                    <h2 class="text-3xl font-bold text-gray-500 mt-3">
                        {{ $courts->where('status', 'inactive')->count() }}
                    </h2>

                </div>

                <!-- TRASH COUNT -->
                <a href="#trash"
                    class="block bg-white p-5 rounded-2xl shadow-sm border border-gray-100 hover:border-red-300 transition">

                    <p class="text-sm text-gray-500">
                        Trash
                    </p>

                    <h2 class="text-3xl font-bold text-red-600 mt-3">
                        {{ $trashedCourts->count() }}
                    </h2>

                </a>

            </div>

            <!-- MY COURTS -->
            <section id="my-courts">

                <div class="flex flex-wrap justify-between items-center gap-4 mb-6">

                    <div>

                        <h2 class="text-2xl font-black">
                            My Courts
                        </h2>

                        <p class="text-sm text-gray-500 mt-1">
                            Manage your court listings.
                        </p>

                    </div>

                    <a href="{{ route('seller.courts.create') }}"
                        class="bg-tennis-olive hover:bg-[#40563E] text-white px-5 py-3 rounded-lg text-sm font-semibold transition">
                        + Add Court
                    </a>

                </div>

                <!-- COURT LIST -->
                <div class="grid grid-cols-1 lg:grid-cols-2 2xl:grid-cols-3 gap-6">

                    @forelse($courts as $court)

                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

                            <!-- COURT IMAGE -->
                            @if($court->image)

                                <img
                                    src="{{ asset('storage/' . $court->image) }}"
                                    alt="{{ $court->name }}"
                                    class="w-full h-52 object-cover">

                            @else

                                <div class="w-full h-52 bg-tennis-green flex items-center justify-center text-white">

                                    <p class="text-sm">
                                        No Court Image
                                    </p>

                                </div>

                            @endif

                            <!-- COURT INFORMATION -->
                            <div class="p-5">

                                <!-- STATUS -->
                                @if($court->status === 'active')

                                    <span class="text-xs bg-green-100 text-green-700 px-3 py-1 rounded-full">
                                        Active
                                    </span>

                                @else

                                    <span class="text-xs bg-gray-100 text-gray-600 px-3 py-1 rounded-full">
                                        Inactive
                                    </span>

                                @endif

                                <!-- COURT NAME -->
                                <h2 class="text-xl font-bold mt-4 wrap-break-word">
                                    {{ $court->name }}
                                </h2>

                                <!-- VENUE -->
                                <p class="text-sm text-[#7C8876] mt-1">
                                    {{ $court->venue_name }}
                                </p>

                                <!-- LOCATION -->
                                <p class="text-sm text-gray-500 mt-3">
                                    {{ $court->city }},
                                    {{ $court->province }}
                                </p>

                                <!-- PRICE -->
                                <div class="border-t border-gray-100 mt-4 pt-4">

                                    <p class="text-xs text-gray-400">
                                        Price per hour
                                    </p>

                                    <p class="text-xl font-bold text-tennis-olive mt-1">
                                        Rp {{ number_format($court->price_per_hour, 0, ',', '.') }}
                                    </p>

                                </div>

                                <!-- ACTION BUTTONS -->
                                <div class="grid grid-cols-2 gap-3 mt-5">

                                    <!-- EDIT -->
                                    <a href="{{ route('seller.courts.edit', $court->id) }}"
                                        class="text-center border border-tennis-olive text-tennis-olive py-3 rounded-lg text-sm font-semibold hover:bg-tennis-light">
                                        EDIT COURT
                                    </a>

                                    <!-- DELETE TO TRASH -->
                                    <form
                                        action="{{ route('seller.courts.destroy', $court->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Pindahkan lapangan ini ke Trash? Lapangan tidak dapat menerima booking baru, tetapi masih bisa dikembalikan.')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="w-full bg-red-100 text-red-700 py-3 rounded-lg text-sm font-semibold hover:bg-red-200">
                                            DELETE
                                        </button>

                                    </form>

                                </div>

                            </div>

                        </div>

                    @empty

                        <!-- EMPTY COURTS -->
                        <div class="col-span-full bg-white rounded-2xl p-10 text-center border border-gray-100 shadow-sm">

                            <h2 class="text-xl font-semibold">
                                No courts yet
                            </h2>

                            <p class="text-gray-500 mt-2">
                                Add a new court or restore a court from Trash.
                            </p>

                            <a href="{{ route('seller.courts.create') }}"
                                class="inline-block mt-5 bg-tennis-olive text-white px-5 py-3 rounded-lg">
                                + Add Court
                            </a>

                        </div>

                    @endforelse

                </div>

            </section>

            <!-- TRASH SECTION -->
            <section id="trash" class="mt-14 border-t border-gray-200 pt-10">

                <div class="flex flex-wrap justify-between items-center gap-4 mb-6">

                    <div>

                        <p class="text-xs font-bold tracking-widest text-[#87947A] mb-2">
                            COURT MANAGEMENT
                        </p>

                        <h2 class="text-2xl font-black">
                            Trash
                        </h2>

                        <p class="text-sm text-gray-500 mt-2">
                            Restore or permanently delete your removed courts.
                        </p>

                    </div>

                    <span class="bg-red-100 text-red-700 px-4 py-2 rounded-lg text-sm font-semibold">
                        {{ $trashedCourts->count() }} Deleted Courts
                    </span>

                </div>

                <!-- TRASH INFORMATION -->
                <div class="bg-tennis-light border border-[#D4DECE] rounded-xl p-5 mb-6">

                    <h3 class="font-bold text-tennis-olive text-sm">
                        About Trash
                    </h3>

                    <p class="text-sm text-tennis-green mt-2 leading-relaxed">
                        Deleted courts are hidden from the main website.
                        You can restore them at any time.
                        Courts with existing booking history cannot be permanently deleted.
                    </p>

                </div>

                <!-- TRASH LIST -->
                <div class="grid grid-cols-1 lg:grid-cols-2 2xl:grid-cols-3 gap-6">

                    @forelse($trashedCourts as $court)

                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

                            <!-- DELETED COURT IMAGE -->
                            @if($court->image)

                                <img
                                    src="{{ asset('storage/' . $court->image) }}"
                                    alt="{{ $court->name }}"
                                    class="w-full h-48 object-cover opacity-70">

                            @else

                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500">

                                    <p class="text-sm">
                                        No Court Image
                                    </p>

                                </div>

                            @endif

                            <!-- DELETED COURT INFORMATION -->
                            <div class="p-5">

                                <span class="bg-red-100 text-red-700 text-xs font-semibold px-3 py-1 rounded-full">
                                    Deleted
                                </span>

                                <h2 class="text-xl font-bold mt-4 wrap-break-word">
                                    {{ $court->name }}
                                </h2>

                                <p class="text-sm text-gray-500 mt-1">
                                    {{ $court->venue_name }}
                                </p>

                                <p class="text-sm text-gray-500 mt-3">
                                    {{ $court->city }},
                                    {{ $court->province }}
                                </p>

                                <!-- PRICE -->
                                <div class="border-t border-gray-100 mt-4 pt-4">

                                    <p class="text-xs text-gray-400">
                                        Price per hour
                                    </p>

                                    <p class="text-lg font-bold text-tennis-olive mt-1">
                                        Rp {{ number_format($court->price_per_hour, 0, ',', '.') }}
                                    </p>

                                </div>

                                <!-- DELETED DATE -->
                                <div class="bg-tennis-cream rounded-lg p-3 mt-4">

                                    <p class="text-xs text-gray-500">
                                        Deleted at
                                    </p>

                                    <p class="text-sm font-semibold mt-1">
                                        {{ $court->deleted_at->format('d M Y, H:i') }}
                                    </p>

                                </div>

                                <!-- RESTORE AND PERMANENT DELETE -->
                                <div class="space-y-3 mt-5">

                                    <!-- RESTORE -->
                                    <form
                                        action="{{ route('seller.courts.restore', $court->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin mengembalikan lapangan ini?')">

                                        @csrf
                                        @method('PATCH')

                                        <button type="submit"
                                            class="w-full bg-tennis-olive hover:bg-[#40563E] text-white py-3 rounded-lg text-sm font-semibold">
                                            RESTORE COURT
                                        </button>

                                    </form>

                                    <!-- PERMANENT DELETE -->
                                    <form
                                        action="{{ route('seller.courts.force-delete', $court->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('PERINGATAN: Lapangan akan dihapus secara permanen dan tidak dapat dikembalikan. Lanjutkan?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="w-full border border-red-300 text-red-700 hover:bg-red-100 py-3 rounded-lg text-sm font-semibold">
                                            DELETE PERMANENTLY
                                        </button>

                                    </form>

                                </div>

                            </div>

                        </div>

                    @empty

                        <!-- EMPTY TRASH -->
                        <div class="col-span-full bg-white border border-gray-100 rounded-2xl p-10 text-center shadow-sm">

                            <div class="w-16 h-16 bg-tennis-light rounded-full flex items-center justify-center mx-auto mb-5">

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="w-7 h-7 text-tennis-olive"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.5">

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M3 6h18M19 6l-1 14H6L5 6m4 0V3h6v3M10 10v6m4-6v6" />

                                </svg>

                            </div>

                            <h2 class="text-xl font-semibold">
                                Trash is empty
                            </h2>

                            <p class="text-gray-500 text-sm mt-2">
                                Deleted courts will appear here.
                            </p>

                        </div>

                    @endforelse

                </div>

            </section>

            <!-- FOOTER -->
            <footer class="text-center text-xs text-gray-400 mt-12 py-5">
                &copy; 2026 MY TENNIS.
            </footer>

        </main>

    </div>

</body>
</html>
