
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>MY TENNIS | Booking</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
    @fluxAppearance

    <style>
        html {
            scroll-behavior: smooth;
        }

        [x-cloak] {
            display: none !important;
        }

        #tennis-ball-link {
            cursor: pointer;
        }

        .ball-hover {
            transform-box: fill-box;
            transform-origin: center;
            transition: transform 0.3s ease;
        }

        #tennis-ball-link:hover .ball-hover {
            transform: scale(1.12);
        }
    </style>
</head>

<body class="bg-white text-gray-900">

    <!-- NAVBAR -->
    <nav
        x-data="{ menuOpen: false }"
        @keydown.escape.window="menuOpen = false"
        class="px-5 md:px-16 py-5"
    >
        <div class="flex items-center justify-between gap-5">

            <a href="/" class="text-2xl font-black text-green-700">
                MY TENNIS<span class="text-black">.</span>
            </a>

            <!-- MENU DESKTOP -->
            <div class="hidden md:flex items-center gap-9 text-base font-semibold">

                <a href="/" class="text-green-700">
                    BOOKING
                </a>

                <a href="/profile" class="hover:text-green-700">
                    OUR PROFILE
                </a>

                @auth

                    @if(auth()->user()->role === 'buyer')

                        <a href="{{ route('booking.index') }}"
                           class="hover:text-green-700">
                            MY BOOKINGS
                        </a>

                        <form action="{{ route('buyer.logout') }}"
                              method="POST">

                            @csrf

                            <button type="submit"
                                    class="bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded-lg transition">
                                LOGOUT
                            </button>

                        </form>

                    @elseif(auth()->user()->role === 'seller')

                        <a href="{{ route('seller.courts.index') }}"
                           class="hover:text-green-700">
                            MY COURTS
                        </a>

                        <form action="{{ route('seller.logout') }}"
                              method="POST">

                            @csrf

                            <button type="submit"
                                    class="bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded-lg transition">
                                LOGOUT
                            </button>

                        </form>

                    @endif

                @else

                    <a href="{{ route('buyer.login') }}"
                       class="hover:text-green-700">
                        LOGIN
                    </a>

                    <a href="{{ route('buyer.register') }}"
                       class="bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded-lg transition">
                        REGISTER
                    </a>

                @endauth

            </div>

            <!-- TOMBOL HAMBURGER MOBILE -->
            <button
                type="button"
                class="md:hidden inline-flex items-center justify-center p-2 rounded-lg text-green-700 hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-green-700"
                @click="menuOpen = !menuOpen"
                :aria-expanded="menuOpen.toString()"
                aria-controls="mobile-navigation"
                aria-label="Buka atau tutup menu navigasi"
            >
                <!-- IKON TIGA GARIS -->
                <svg
                    x-show="!menuOpen"
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-7 h-7"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M4 6h16M4 12h16M4 18h16"
                    />
                </svg>

                <!-- IKON TUTUP -->
                <svg
                    x-show="menuOpen"
                    x-cloak
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-7 h-7"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M6 6l12 12M18 6L6 18"
                    />
                </svg>
            </button>

        </div>

        <!-- MENU MOBILE MENGGUNAKAN ALPINE.JS -->
        <div
            id="mobile-navigation"
            x-show="menuOpen"
            x-cloak
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            @click.outside="menuOpen = false"
            class="md:hidden mt-4 border-t border-gray-200 pt-4"
        >
            <div class="flex flex-col gap-4 text-sm font-semibold">

                <a href="/"
                   class="text-green-700"
                   @click="menuOpen = false">
                    BOOKING
                </a>

                <a href="/profile"
                   class="hover:text-green-700"
                   @click="menuOpen = false">
                    OUR PROFILE
                </a>

                @auth

                    @if(auth()->user()->role === 'buyer')

                        <a href="{{ route('booking.index') }}"
                           class="hover:text-green-700"
                           @click="menuOpen = false">
                            MY BOOKINGS
                        </a>

                        <form action="{{ route('buyer.logout') }}"
                              method="POST">

                            @csrf

                            <button type="submit"
                                    class="w-full bg-green-700 hover:bg-green-800 text-white px-4 py-3 rounded-lg transition">
                                LOGOUT
                            </button>

                        </form>

                    @elseif(auth()->user()->role === 'seller')

                        <a href="{{ route('seller.courts.index') }}"
                           class="hover:text-green-700"
                           @click="menuOpen = false">
                            MY COURTS
                        </a>

                        <form action="{{ route('seller.logout') }}"
                              method="POST">

                            @csrf

                            <button type="submit"
                                    class="w-full bg-green-700 hover:bg-green-800 text-white px-4 py-3 rounded-lg transition">
                                LOGOUT
                            </button>

                        </form>

                    @endif

                @else

                    <a href="{{ route('buyer.login') }}"
                       class="hover:text-green-700"
                       @click="menuOpen = false">
                        LOGIN
                    </a>

                    <a href="{{ route('buyer.register') }}"
                       class="bg-green-700 hover:bg-green-800 text-white px-4 py-3 rounded-lg text-center transition"
                       @click="menuOpen = false">
                        REGISTER
                    </a>

                @endauth

            </div>
        </div>
    </nav>


    <!-- HERO SECTION -->
    <section class="px-4 md:px-16 pt-8 pb-10">

        <div class="max-w-6xl mx-auto">

            <!-- JUDUL -->
            <h1 class="text-center text-4xl md:text-6xl font-black tracking-tight text-green-950 mb-7">

                MY TENNIS<span class="text-green-600">.</span>

            </h1>


            <!-- LAPANGAN TENIS -->
            <div class="relative mx-auto max-w-5xl rounded-2xl overflow-hidden shadow-xl"
                 style="background-color: #327C39;">

                <svg xmlns="http://www.w3.org/2000/svg"
                     viewBox="0 0 1000 500"
                     class="block w-full h-auto">

                    <!-- GARIS LAPANGAN -->
                    <g fill="none"
                       stroke="white"
                       stroke-width="2.5">

                        <!-- GARIS LUAR DOUBLE -->
                        <rect x="50"
                              y="42.2"
                              width="900"
                              height="415.6"/>

                        <!-- GARIS SINGLE ATAS -->
                        <line x1="50"
                              y1="94.2"
                              x2="950"
                              y2="94.2"/>

                        <!-- GARIS SINGLE BAWAH -->
                        <line x1="50"
                              y1="405.8"
                              x2="950"
                              y2="405.8"/>

                        <!-- GARIS SERVIS KIRI -->
                        <line x1="257.6"
                              y1="94.2"
                              x2="257.6"
                              y2="405.8"/>

                        <!-- GARIS SERVIS KANAN -->
                        <line x1="742.4"
                              y1="94.2"
                              x2="742.4"
                              y2="405.8"/>

                        <!-- GARIS TENGAH SERVIS -->
                        <line x1="257.6"
                              y1="250"
                              x2="742.4"
                              y2="250"/>

                        <!-- CENTER MARK KIRI -->
                        <line x1="50"
                              y1="250"
                              x2="58"
                              y2="250"/>

                        <!-- CENTER MARK KANAN -->
                        <line x1="942"
                              y1="250"
                              x2="950"
                              y2="250"/>

                        <!-- NET -->
                        <line x1="500"
                              y1="25"
                              x2="500"
                              y2="475"
                              stroke-width="4"/>

                    </g>


                    <!-- BOLA TENIS -->
                    <a id="tennis-ball-link"
                       href="#booking"
                       aria-label="Mulai booking lapangan">

                        <g class="ball-hover">

                            <!-- BAYANGAN BOLA -->
                            <circle cx="500"
                                    cy="254"
                                    r="54"
                                    fill="black"
                                    opacity="0.12"/>

                            <!-- WARNA BOLA -->
                            <circle cx="500"
                                    cy="250"
                                    r="53"
                                    fill="#D9F36A"
                                    stroke="white"
                                    stroke-width="4"/>

                            <!-- ANIMASI PUTAR -->
                            <g fill="none"
                               stroke="white"
                               stroke-width="4">

                                <path d="M476 204 C514 229 514 271 476 296"/>

                                <path d="M524 204 C486 229 486 271 524 296"/>

                                <animateTransform
                                    attributeName="transform"
                                    type="rotate"
                                    from="0 500 250"
                                    to="360 500 250"
                                    dur="4s"
                                    repeatCount="indefinite"/>

                            </g>

                        </g>

                    </a>

                </svg>

            </div>

        </div>

    </section>


    <!-- BOOKING SECTION -->
    <section id="booking"
             class="px-5 md:px-16 py-16">

        <div class="text-center mb-10">

            <p class="text-green-700 font-bold tracking-widest">
                LET'S PLAY
            </p>

            <h2 class="text-3xl md:text-4xl font-black mt-3">
                FIND YOUR PERFECT COURT
            </h2>

            <p class="text-gray-500 mt-4">
                Temukan lapangan tenis favoritmu.
            </p>

        </div>


        <!-- LIVEWIRE DAN FLUX UI -->
        <livewire:court-list />

    </section>


    <!-- FOOTER -->
    <footer class="bg-green-950 text-white text-center py-9 px-5">

        <h2 class="font-black text-2xl">
            MY TENNIS.
        </h2>

        <p class="text-gray-300 mt-2 text-sm">
            BOOK YOUR COURT, PLAY YOUR GAME.
        </p>

        <p class="text-gray-400 text-xs mt-5">
            &copy; 2026 MY TENNIS. All Rights Reserved.
        </p>

    </footer>

    @livewireScripts
    @fluxScripts

</body>
</html>
