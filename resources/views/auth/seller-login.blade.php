
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Seller Login | MY TENNIS</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#F4F5ED] flex items-center justify-center p-5">

    <div class="w-full max-w-lg bg-white rounded-3xl shadow-xl p-8">

        <a href="/" class="text-[#687653] font-bold text-xl">
            MY TENNIS.
        </a>

        <div class="mt-10 mb-8">

            <p class="text-sm font-semibold tracking-widest text-[#87916F]">
                SELLER ACCOUNT
            </p>

            <h1 class="text-3xl font-bold text-[#35432F] mt-2">
                Welcome Back, Partner!
            </h1>

            <p class="text-gray-500 mt-2">
                Login to manage your tennis courts and bookings.
            </p>

        </div>

        @if ($errors->any())

            <div class="bg-red-100 text-red-700 p-3 rounded-xl mb-5 text-sm">

                @foreach ($errors->all() as $error)

                    <p>{{ $error }}</p>

                @endforeach

            </div>

        @endif

        <form action="{{ route('seller.login.store') }}"
              method="POST"
              class="space-y-5">

            @csrf

            <div>

                <label for="seller-email"
                       class="block text-sm font-semibold text-gray-700 mb-2">
                    Email Address
                </label>

                <input type="email"
                       id="seller-email"
                       name="email"
                       value="{{ old('email') }}"
                       placeholder="Enter your email"
                       autocomplete="email"
                       required
                       class="w-full p-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#87916F]">

            </div>

            <div>

                <label for="seller-password"
                       class="block text-sm font-semibold text-gray-700 mb-2">
                    Password
                </label>

                <div class="relative">

                    <input type="password"
                           id="seller-password"
                           name="password"
                           placeholder="Enter your password"
                           autocomplete="current-password"
                           required
                           class="w-full p-3 pr-12 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#87916F]">

                    <button type="button"
                            id="toggle-seller-password"
                            aria-label="Show password"
                            aria-pressed="false"
                            class="absolute inset-y-0 right-0 flex items-center justify-center w-12 text-gray-400 hover:text-[#687653] transition">

                        <!-- Ikon mata: password tersembunyi -->
                        <svg id="seller-eye-icon"
                             xmlns="http://www.w3.org/2000/svg"
                             width="20"
                             height="20"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8"
                             stroke-linecap="round"
                             stroke-linejoin="round"
                             aria-hidden="true">

                            <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"/>
                            <circle cx="12" cy="12" r="3"/>

                        </svg>

                        <!-- Ikon mata dicoret: password terlihat -->
                        <svg id="seller-eye-off-icon"
                             class="hidden"
                             xmlns="http://www.w3.org/2000/svg"
                             width="20"
                             height="20"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8"
                             stroke-linecap="round"
                             stroke-linejoin="round"
                             aria-hidden="true">

                            <path d="M3 3l18 18"/>
                            <path d="M10.6 5.1A11.5 11.5 0 0 1 12 5c6.5 0 10 7 10 7a14 14 0 0 1-3.1 3.8"/>
                            <path d="M6.2 6.2C3.5 8.1 2 12 2 12s3.5 7 10 7c1.7 0 3.2-.5 4.5-1.3"/>
                            <path d="M10 10a3 3 0 0 0 4 4"/>

                        </svg>

                    </button>

                </div>

            </div>

            <button type="submit"
                    class="w-full bg-[#687653] hover:bg-[#536344] text-white font-bold py-3 rounded-xl transition">

                LOGIN AS SELLER

            </button>

        </form>

        <p class="text-center text-sm text-gray-500 mt-7">

            Don't have a seller account?

            <a href="{{ route('seller.register') }}"
               class="text-[#687653] font-bold">

                Register

            </a>

        </p>

        <p class="text-center text-sm text-gray-500 mt-3">

            Want to book a court?

            <a href="{{ route('buyer.login') }}"
               class="text-[#687653] font-bold">

                Buyer Login

            </a>

        </p>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const passwordInput = document.getElementById('seller-password');
            const toggleButton = document.getElementById('toggle-seller-password');
            const eyeIcon = document.getElementById('seller-eye-icon');
            const eyeOffIcon = document.getElementById('seller-eye-off-icon');

            toggleButton.addEventListener('click', function () {

                const isHidden = passwordInput.type === 'password';

                passwordInput.type = isHidden ? 'text' : 'password';

                eyeIcon.classList.toggle('hidden', isHidden);
                eyeOffIcon.classList.toggle('hidden', !isHidden);

                toggleButton.setAttribute(
                    'aria-label',
                    isHidden ? 'Hide password' : 'Show password'
                );

                toggleButton.setAttribute(
                    'aria-pressed',
                    String(isHidden)
                );

            });

        });
    </script>

</body>
</html>
