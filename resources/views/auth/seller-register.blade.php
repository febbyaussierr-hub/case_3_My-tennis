
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Seller Register | MY TENNIS</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#F4F5ED] flex items-center justify-center p-5">

    <div class="w-full max-w-lg bg-white rounded-3xl shadow-xl p-8">

        <a href="/" class="text-[#687653] font-bold text-xl">
            MY TENNIS.
        </a>

        <div class="mt-8 mb-7">

            <p class="text-sm font-semibold tracking-widest text-[#87916F]">
                SELLER ACCOUNT
            </p>

            <h1 class="text-3xl font-bold text-[#35432F] mt-2">
                Become a Partner
            </h1>

            <p class="text-gray-500 mt-2">
                Register your account and start managing your tennis courts.
            </p>

        </div>

        <!-- VALIDATION ERRORS -->
        @if ($errors->any())

            <div class="bg-red-100 text-red-700 p-3 rounded-xl mb-5 text-sm">

                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach

            </div>

        @endif

        <!-- SELLER REGISTER FORM -->
        <form action="{{ route('seller.register.store') }}"
              method="POST"
              class="space-y-4">

            @csrf

            <!-- OWNER NAME -->
            <div>

                <label for="name"
                    class="block text-sm font-semibold text-gray-700 mb-2">
                    Owner / Full Name
                </label>

                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Enter your name"
                    autocomplete="name"
                    required
                    class="w-full p-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#87916F]">

            </div>

            <!-- EMAIL -->
            <div>

                <label for="email"
                    class="block text-sm font-semibold text-gray-700 mb-2">
                    Email Address
                </label>

                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Enter your email"
                    autocomplete="email"
                    required
                    class="w-full p-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#87916F]">

            </div>

            <!-- PHONE NUMBER -->
            <div>

                <label for="phone"
                    class="block text-sm font-semibold text-gray-700 mb-2">
                    Phone Number
                </label>

                <input
                    id="phone"
                    type="tel"
                    name="phone"
                    value="{{ old('phone') }}"
                    placeholder="Enter your phone number"
                    autocomplete="tel"
                    class="w-full p-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#87916F]">

            </div>

            <!-- DATE OF BIRTH -->
            <div>

                <label for="date_of_birth"
                    class="block text-sm font-semibold text-gray-700 mb-2">
                    Date of Birth
                </label>

                <input
                    id="date_of_birth"
                    type="date"
                    name="date_of_birth"
                    value="{{ old('date_of_birth') }}"
                    class="w-full p-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#87916F]">

            </div>

            <!-- PASSWORD -->
            <div>

                <label for="password"
                    class="block text-sm font-semibold text-gray-700 mb-2">
                    Password
                </label>

                <div class="relative">

                    <input
                        id="password"
                        type="password"
                        name="password"
                        placeholder="Minimum 8 characters"
                        autocomplete="new-password"
                        minlength="8"
                        required
                        class="w-full p-3 pr-12 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#87916F]">

                    <!-- SHOW / HIDE BUTTON -->
                    <button
                        type="button"
                        onclick="togglePassword('password', this)"
                        aria-label="Show password"
                        aria-pressed="false"
                        class="absolute inset-y-0 right-0 px-4 flex items-center justify-center text-gray-400 hover:text-[#687653] transition">

                        <!-- EYE OPEN -->
                        <svg
                            class="eye-open w-5 h-5"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M2.25 12s3.5-6.75 9.75-6.75S21.75 12 21.75 12s-3.5 6.75-9.75 6.75S2.25 12 2.25 12Z" />

                            <circle
                                cx="12"
                                cy="12"
                                r="3" />

                        </svg>

                        <!-- EYE CLOSED -->
                        <svg
                            class="eye-closed w-5 h-5 hidden"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3 3l18 18M10.6 5.4A10.7 10.7 0 0 1 12 5.25c6.25 0 9.75 6.75 9.75 6.75a15.7 15.7 0 0 1-3.4 4.05M6.2 6.2C3.7 8 2.25 12 2.25 12s3.5 6.75 9.75 6.75c1.45 0 2.75-.36 3.9-.94M9.9 9.9a3 3 0 0 0 4.2 4.2" />

                        </svg>

                    </button>

                </div>

            </div>

            <!-- CONFIRM PASSWORD -->
            <div>

                <label for="password_confirmation"
                    class="block text-sm font-semibold text-gray-700 mb-2">
                    Confirm Password
                </label>

                <div class="relative">

                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        placeholder="Re-enter your password"
                        autocomplete="new-password"
                        minlength="8"
                        required
                        class="w-full p-3 pr-12 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#87916F]">

                    <!-- SHOW / HIDE BUTTON -->
                    <button
                        type="button"
                        onclick="togglePassword('password_confirmation', this)"
                        aria-label="Show confirm password"
                        aria-pressed="false"
                        class="absolute inset-y-0 right-0 px-4 flex items-center justify-center text-gray-400 hover:text-[#687653] transition">

                        <!-- EYE OPEN -->
                        <svg
                            class="eye-open w-5 h-5"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M2.25 12s3.5-6.75 9.75-6.75S21.75 12 21.75 12s-3.5 6.75-9.75 6.75S2.25 12 2.25 12Z" />

                            <circle
                                cx="12"
                                cy="12"
                                r="3" />

                        </svg>

                        <!-- EYE CLOSED -->
                        <svg
                            class="eye-closed w-5 h-5 hidden"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3 3l18 18M10.6 5.4A10.7 10.7 0 0 1 12 5.25c6.25 0 9.75 6.75 9.75 6.75a15.7 15.7 0 0 1-3.4 4.05M6.2 6.2C3.7 8 2.25 12 2.25 12s3.5 6.75 9.75 6.75c1.45 0 2.75-.36 3.9-.94M9.9 9.9a3 3 0 0 0 4.2 4.2" />

                        </svg>

                    </button>

                </div>

            </div>

            <!-- SUBMIT BUTTON -->
            <button
                type="submit"
                class="w-full bg-[#687653] hover:bg-[#536344] text-white font-bold py-3 rounded-xl transition">

                CREATE SELLER ACCOUNT

            </button>

        </form>

        <!-- SELLER LOGIN -->
        <p class="text-center text-sm text-gray-500 mt-6">

            Already have a seller account?

            <a href="{{ route('seller.login') }}"
                class="text-[#687653] font-bold hover:underline">
                Login
            </a>

        </p>

        <!-- BUYER REGISTER -->
        <p class="text-center text-sm text-gray-500 mt-3">

            Want to book a court?

            <a href="{{ route('buyer.register') }}"
                class="text-[#687653] font-bold hover:underline">
                Register as Buyer
            </a>

        </p>

    </div>

    <!-- SHOW / HIDE PASSWORD JAVASCRIPT -->
    <script>

        function togglePassword(inputId, button) {

            const input = document.getElementById(inputId);

            const eyeOpen = button.querySelector('.eye-open');
            const eyeClosed = button.querySelector('.eye-closed');

            const isPasswordHidden = input.type === 'password';

            input.type = isPasswordHidden ? 'text' : 'password';

            eyeOpen.classList.toggle('hidden', isPasswordHidden);
            eyeClosed.classList.toggle('hidden', !isPasswordHidden);

            button.setAttribute(
                'aria-pressed',
                isPasswordHidden ? 'true' : 'false'
            );

            button.setAttribute(
                'aria-label',
                isPasswordHidden ? 'Hide password' : 'Show password'
            );

        }

    </script>

</body>
</html>
