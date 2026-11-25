
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Profile | MY TENNIS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-900">

    
<!-- NAVBAR -->
<nav class="bg-white px-6 md:px-12 py-5 flex justify-between items-center shadow-sm">
    <a href="/" class="text-2xl font-black text-green-800">
        MY TENNIS.
    </a>

    <div class="flex items-center gap-4 md:gap-6 font-bold text-sm">
        <a href="/" class="hover:text-green-700">BOOKING</a>
        <a href="/profile" class="text-green-700">OUR PROFILE</a>

        @auth
            @if (auth()->user()->role === 'buyer')
                <form action="{{ route('buyer.logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded-lg">
                        LOGOUT
                    </button>
                </form>
            @elseif (auth()->user()->role === 'seller')
                <a href="{{ route('seller.courts.index') }}"
                   class="hover:text-green-700">
                    MY COURTS
                </a>

                <form action="{{ route('seller.logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded-lg">
                        LOGOUT
                    </button>
                </form>
            @endif
        @else
            <a href="{{ route('buyer.login') }}" class="hover:text-green-700">
                LOGIN
            </a>

            <a href="{{ route('buyer.register') }}"
               class="bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded-lg">
                REGISTER
            </a>
        @endauth
    </div>
</nav>

    <!-- USER PROFILE -->
    <section class="max-w-6xl mx-auto px-6 py-12">

        <p class="text-green-700 font-bold tracking-widest text-sm mb-3">
            YOUR ACCOUNT
        </p>

        <div class="bg-white rounded-3xl shadow-sm p-6 md:p-10 flex flex-col md:flex-row gap-8 items-center">

            <!-- TENNIS BALL PROFILE -->
            <div class="w-36 h-36 md:w-44 md:h-44 rounded-full bg-green-100 flex items-center justify-center shrink-0">
                <div class="w-28 h-28 md:w-36 md:h-36 rounded-full bg-lime-400 border-4 border-white shadow-lg flex items-center justify-center overflow-hidden">
                    <span class="text-6xl md:text-7xl">🎾</span>
                </div>
            </div>

            <!-- USER INFORMATION -->
            <div class="flex-1 w-full">
                <h1 class="text-3xl md:text-4xl font-black mb-2">
                    YOUR USERNAME
                </h1>

                <p class="text-gray-500 mb-6">
                    MY TENNIS MEMBER
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div>
                        <p class="text-gray-400 text-xs font-bold mb-1">PHONE NUMBER</p>
                        <p class="font-semibold">08xxxxxxxxxx</p>
                    </div>

                    <div>
                        <p class="text-gray-400 text-xs font-bold mb-1">EMAIL ADDRESS</p>
                        <p class="font-semibold">username@email.com</p>
                    </div>

                    <div>
                        <p class="text-gray-400 text-xs font-bold mb-1">DATE OF BIRTH</p>
                        <p class="font-semibold">DD / MM / YYYY</p>
                    </div>

                </div>
            </div>
        </div>
    </section>

    
<!-- ABOUT MY TENNIS -->
<section class="max-w-6xl mx-auto px-6 py-10">
    <div class="bg-[#E9F0E5] rounded-3xl p-8 md:p-12">

        <p class="text-[#71845E] font-bold tracking-widest text-sm mb-3">
            GET TO KNOW US
        </p>

        <h2 class="text-3xl md:text-5xl font-black text-[#344B35] mb-6">
            ABOUT MY TENNIS.
        </h2>

        <p class="text-[#566453] leading-relaxed max-w-3xl">
            MY TENNIS is a platform designed to make finding and
            booking tennis courts easier. We connect tennis players
            with available courts, helping everyone enjoy the game
            without the hassle of complicated reservations.
        </p>

    </div>
</section>


    <!-- MY BOOKINGS -->
    <section class="max-w-6xl mx-auto px-6 py-10 pb-20">

        <p class="text-green-700 font-bold tracking-widest text-sm mb-3">
            YOUR ACTIVITY
        </p>

        <div class="bg-white rounded-3xl shadow-sm p-8 md:p-10">

            <div class="flex flex-col md:flex-row justify-between md:items-center gap-5">

                <div>
                    <h2 class="text-3xl md:text-4xl font-black mb-2">
                        MY BOOKINGS.
                    </h2>

                    <p class="text-gray-500">
                        Keep track of your tennis court reservations.
                    </p>
                </div>

                <a href="{{ route('booking.index') }}"
                   class="bg-green-800 hover:bg-green-900 text-white px-8 py-4 rounded-xl font-bold text-center transition">
                    VIEW BOOKING HISTORY →
                </a>

            </div>

        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-black text-white text-center py-7">
        <p class="font-black tracking-widest">MY TENNIS.</p>
        <p class="text-gray-400 text-sm mt-2">
            YOUR GAME. YOUR COURT. YOUR EXPERIENCE.
        </p>
    </footer>

</body>
</html>
