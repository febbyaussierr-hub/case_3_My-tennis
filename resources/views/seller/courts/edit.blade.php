<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Court - MY TENNIS</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#F5F4EC] text-[#344536]">

    <div class="max-w-3xl mx-auto px-6 py-10">

        <a href="{{ route('seller.courts.index') }}"
           class="text-[#536B50] hover:underline">
            ← Back to My Courts
        </a>

        <div class="bg-white rounded-2xl shadow-sm p-8 mt-6">

            <p class="text-sm tracking-widest text-[#87947A]">
                MY TENNIS
            </p>

            <h1 class="text-3xl font-bold mt-2">
                Edit Court
            </h1>

            <p class="text-[#7C8876] mt-2 mb-8">
                Update your tennis court information.
            </p>

            @if($errors->any())
                <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-6">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('seller.courts.update', $court->id) }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="space-y-5">

                @csrf
                @method('PUT')

                <div>
                    <label class="block mb-2 font-medium">Court Name</label>
                    <input type="text" name="name"
                           value="{{ old('name', $court->name) }}"
                           class="w-full border border-gray-200 rounded-xl p-3"
                           required>
                </div>

                <div>
                    <label class="block mb-2 font-medium">Venue Name</label>
                    <input type="text" name="venue_name"
                           value="{{ old('venue_name', $court->venue_name) }}"
                           class="w-full border border-gray-200 rounded-xl p-3"
                           required>
                </div>

                <div>
                    <label class="block mb-2 font-medium">City</label>
                    <input type="text" name="city"
                           value="{{ old('city', $court->city) }}"
                           class="w-full border border-gray-200 rounded-xl p-3"
                           required>
                </div>

                <div>
                    <label class="block mb-2 font-medium">Province</label>
                    <input type="text" name="province"
                           value="{{ old('province', $court->province) }}"
                           class="w-full border border-gray-200 rounded-xl p-3"
                           required>
                </div>

                <div>
                    <label class="block mb-2 font-medium">Full Address</label>
                    <textarea name="address" rows="3"
                              class="w-full border border-gray-200 rounded-xl p-3">{{ old('address', $court->address) }}</textarea>
                </div>

                <div>
                    <label class="block mb-2 font-medium">Price per Hour (Rp)</label>
                    <input type="number" name="price_per_hour"
                           value="{{ old('price_per_hour', $court->price_per_hour) }}"
                           min="1"
                           class="w-full border border-gray-200 rounded-xl p-3"
                           required>
                </div>

                <div>
                    <label class="block mb-2 font-medium">Description</label>
                    <textarea name="description" rows="4"
                              class="w-full border border-gray-200 rounded-xl p-3">{{ old('description', $court->description) }}</textarea>
                </div>

                <!-- FOTO LAPANGAN SAAT INI -->
                <div>

                    <label class="block mb-2 font-medium">
                        Current Court Image
                    </label>

                    @if($court->image)

                        <img src="{{ asset('storage/' . $court->image) }}"
                             alt="{{ $court->name }}"
                             class="w-full h-64 object-cover rounded-xl">

                    @else

                        <div class="bg-[#E8EDE3] rounded-xl h-48 flex flex-col items-center justify-center">

                            <span class="text-5xl mb-3">🎾</span>

                            <p class="text-[#687653] text-sm">
                                No Court Image
                            </p>

                        </div>

                    @endif

                </div>

                <!-- UPLOAD FOTO BARU -->
                <div>

                    <label for="image" class="block mb-2 font-medium">
                        Change Court Image
                    </label>

                    <input type="file"
                           name="image"
                           id="image"
                           accept=".jpg,.jpeg,.png,.webp"
                           onchange="previewImage(event)"
                           class="w-full border border-gray-200 rounded-xl p-3">

                    <p class="text-xs text-gray-500 mt-2">
                        JPG, JPEG, PNG, WEBP. Maximum size 2 MB.
                    </p>

                    <p class="text-xs text-gray-500 mt-1">
                        Leave empty to keep the current image.
                    </p>

                </div>

                <!-- PREVIEW FOTO BARU -->
                <div id="previewContainer" style="display: none;">

                    <label class="block mb-2 font-medium">
                        New Image Preview
                    </label>

                    <img id="imagePreview"
                         alt="New Court Image"
                         class="w-full h-64 object-cover rounded-xl">

                </div>

                <button type="submit"
                        class="w-full bg-[#536B50] text-white py-3 rounded-xl hover:bg-[#40563E]">
                    Update Court
                </button>

            </form>

        </div>

    </div>

    <script>
        function previewImage(event) {

            const file = event.target.files[0];
            const preview = document.getElementById('imagePreview');
            const container = document.getElementById('previewContainer');

            container.style.display = 'none';
            preview.removeAttribute('src');

            if (!file) {
                return;
            }

            if (file.size > 2 * 1024 * 1024) {

                alert('Image size must not exceed 2 MB!');

                event.target.value = '';
                return;

            }

            const reader = new FileReader();

            reader.onload = function(e) {

                preview.src = e.target.result;
                container.style.display = 'block';

            };

            reader.readAsDataURL(file);

        }
    </script>

</body>
</html>