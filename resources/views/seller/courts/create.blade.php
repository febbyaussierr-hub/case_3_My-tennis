<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Court | MY TENNIS</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background: #F4F5ED;
            font-family: Arial, sans-serif;
            padding: 30px 15px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
        }

        .brand {
            color: #687653;
            font-size: 21px;
            font-weight: bold;
            text-decoration: none;
        }

        h1 {
            font-size: 28px;
            font-weight: bold;
            color: #35432F;
            margin-top: 20px;
        }

        .subtitle {
            color: gray;
            margin-bottom: 25px;
        }

        label {
            display: block;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 7px;
        }

        input, textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-sizing: border-box;
            margin-bottom: 18px;
        }

        button {
            width: 100%;
            background: #687653;
            color: white;
            border: none;
            padding: 14px;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background: #536344;
        }

        .back {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #687653;
            text-decoration: none;
        }

        .error {
            background: #fee2e2;
            color: #b91c1c;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .image-info {
            font-size: 12px;
            color: gray;
            margin-top: -10px;
            margin-bottom: 20px;
        }

        #imagePreview {
            display: none;
            width: 100%;
            height: 230px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <div class="container">

        <a href="/" class="brand">MY TENNIS.</a>

        <h1>Add New Court</h1>

        <p class="subtitle">
            Enter your tennis court information.
        </p>

        @if ($errors->any())
            <div class="error">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('seller.courts.store') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <label>Court Name</label>
            <input type="text" name="name"
                value="{{ old('name') }}"
                placeholder="Example: Court A"
                required>

            <label>Venue Name</label>
            <input type="text" name="venue_name"
                value="{{ old('venue_name') }}"
                placeholder="Example: Palembang Tennis Center"
                required>

            <label>City</label>
            <input type="text" name="city"
                value="{{ old('city') }}"
                placeholder="Palembang"
                required>

            <label>Province</label>
            <input type="text" name="province"
                value="{{ old('province') }}"
                placeholder="Sumatera Selatan"
                required>

            <label>Address</label>
            <textarea name="address" rows="3"
                placeholder="Enter full address">{{ old('address') }}</textarea>

            <label>Price per Hour (Rp)</label>
            <input type="number" name="price_per_hour"
                value="{{ old('price_per_hour') }}"
                placeholder="100000"
                min="1"
                required>

            <label>Description</label>
            <textarea name="description" rows="4"
                placeholder="Enter court description">{{ old('description') }}</textarea>

            <!-- UPLOAD FOTO -->
            <label for="image">Court Image</label>

            <input type="file"
                name="image"
                id="image"
                accept=".jpg,.jpeg,.png,.webp"
                onchange="previewImage(event)">

            <p class="image-info">
                JPG, JPEG, PNG, WEBP. Maximum size 2 MB.
            </p>

            <!-- PREVIEW FOTO -->
            <img id="imagePreview" alt="Court Preview">

            <button type="submit">
                SAVE COURT
            </button>

        </form>

        <a href="{{ route('seller.courts.index') }}" class="back">
            &larr; Back to My Courts
        </a>

    </div>

    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('imagePreview');

            preview.style.display = 'none';
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
                preview.style.display = 'block';
            };

            reader.readAsDataURL(file);
        }
    </script>

</body>
</html>