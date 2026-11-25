
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>MY TENNIS | Booking</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html {
            scroll-behavior: smooth;
        }

        .tennis-ball {
            transform-origin: center;
            transform-box: fill-box;
            animation: spinBall 4s linear infinite;
        }

        @keyframes spinBall {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .tennis-ball {
                animation: none;
            }
        }
    </style>
</head>

<body class="bg-white text-gray-900 antialiased">

    <!-- NAVBAR -->
    <nav class="flex flex-wrap items-center justify-between gap-5 px-6 md:px-16 py-6">

        <a href="/" class="text-2xl font-black text-green-700">
            MY TENNIS<span class="text-black">.</span>
        </a>

        <div class="flex flex-wrap items-center gap-5 text-sm font-bold">

            <a href="#booking" class="hover:text-green-700">
                BOOKING
            </a>

            <a href="#about" class="hover:text-green-700">
                OUR PROFILE
            </a>

            <a href="{{ url('/buyer/login') }}"
               class="hover:text-green-700">
                LOGIN
            </a>

            <a href="{{ url('/buyer/register') }}"
               class="bg-green-700 hover:bg-green-800 text-white px-5 py-3 rounded-lg">
                REGISTER
            </a>

        </div>

    </nav>

    <!-- HERO SECTION -->
    <section class="px-5 py-12 md:py-16 text-center">

        <h1 class="text-5xl md:text-7xl font-black text-green-950 mb-8">
            MY TENNIS<span class="text-green-600">.</span>
        </h1>

        <!-- TENNIS COURT -->
        <div class="max-w-5xl mx-auto bg-green-700 rounded-2xl p-5 md:p-7 shadow-xl">

            <svg viewBox="0 0 1000 500"
                 xmlns="http://www.w3.org/2000/svg"
                 class="w-full h-auto">

                <!-- COURT BORDER -->
                <rect x="0"
                      y="0"
                      width="1000"
                      height="500"
                      fill="none"
                      stroke="white"
                      stroke-width="5"/>

                <!-- COURT LINES -->
                <g stroke="white" stroke-width="2.5">

                    <line x1="245" y1="0"
                          x2="245" y2="500"/>

                    <line x1="755" y1="0"
                          x2="755" y2="500"/>

                    <line x1="500" y1="0"
                          x2="500" y2="500"/>

                    <line x1="0" y1="250"
                          x2="1000" y2="250"
                          stroke-width="5"/>

                    <line x1="245" y1="125"
                          x2="755" y2="125"/>

                    <line x1="245" y1="375"
                          x2="755" y2="375"/>

                </g>

                <!-- ROTATING TENNIS BALL -->
                <g class="tennis-ball">

                    <circle cx="500"
                            cy="250"
                            r="60"
                            fill="#d9f581"
                            stroke="white"
                            stroke-width="5"/>

                    <circle cx="500"
                            cy="250"
                            r="54"
                            fill="none"
                            stroke="#b7e75e"
                            stroke-width="5"/>

                    <path d="M 476 201 Q 540 250 476 299"
                          fill="none"
                          stroke="white"
                          stroke-width="5"
                          stroke-linecap="round"/>

                    <path d="M 524 201 Q 460 250 524 299"
                          fill="none"
                          stroke="white"
                          stroke-width="5"
                          stroke-linecap="round"/>

                </g>

            </svg>

        </div>

    </section>

    <!-- BOOKING SECTION -->
    <section id="booking"
             class="bg-gray-50 px-6 md:px-16 py-16">

        <div class="max-w-5xl mx-auto">

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

            <!-- SEARCH FORM -->
            <form action="{{ url('/buyer/login') }}"
                  method="GET"
                  class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 grid grid-cols-1 md:grid-cols-4 gap-5 items-end">

                <div>
                    <label class="block font-semibold text-sm mb-2">
                        Lokasi
                    </label>

                    <input type="text"
                           name="location"
                           placeholder="Masukkan lokasi"
                           class="w-full border border-gray-300 rounded-lg p-3">
                </div>

                <div>
                    <label class="block font-semibold text-sm mb-2">
                        Tanggal
                    </label>

                    <input type="date"
                           name="date"
                           class="w-full border border-gray-300 rounded-lg p-3">
                </div>

                <div>
                    <label class="block font-semibold text-sm mb-2">
                        Waktu Bermain
                    </label>

                    <select name="time"
                            class="w-full border border-gray-300 rounded-lg p-3">

                        <option value="">Pilih waktu</option>
                        <option value="08:00">08.00 - 09.00</option>
                        <option value="09:00">09.00 - 10.00</option>
                        <option value="10:00">10.00 - 11.00</option>
                        <option value="15:00">15.00 - 16.00</option>
                        <option value="16:00">16.00 - 17.00</option>
                        <option value="17:00">17.00 - 18.00</option>

                    </select>
                </div>

                <button type="submit"
                        class="bg-green-700 hover:bg-green-800 text-white rounded-lg p-3 font-bold transition">

                    SEARCH COURT

                </button>

            </form>

        </div>

    </section>

    <!-- ABOUT SECTION -->
    <section id="about"
             class="px-6 py-20 text-center max-w-3xl mx-auto">

        <p class="text-green-700 font-bold tracking-widest">
            ABOUT US
        </p>

        <h2 class="text-4xl font-black mt-3">
            YOUR GAME STARTS HERE.
        </h2>

        <p class="text-gray-500 leading-relaxed mt-5">
            MY TENNIS merupakan platform pemesanan lapangan
            tenis yang membantu pengguna menemukan dan
            memesan lapangan dengan mudah dan praktis.
        </p>

        <a href="{{ url('/seller/login') }}"
           class="inline-block mt-7 border-2 border-green-700 text-green-700 hover:bg-green-700 hover:text-white font-bold px-6 py-3 rounded-lg transition">

            JOIN AS SELLER

        </a>

    </section>

    <!-- FOOTER -->
    <footer class="bg-green-950 text-white text-center py-10">

        <h2 class="font-black text-2xl">
            MY TENNIS.
        </h2>

        <p class="text-gray-300 text-sm mt-3">
            BOOK YOUR COURT, PLAY YOUR GAME.
        </p>

        <p class="text-gray-400 text-xs mt-6">
            © 2026 MY TENNIS. All Rights Reserved.
        </p>

    </footer>

</body>
</html>
