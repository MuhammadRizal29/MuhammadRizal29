<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PONDOK PESANTREN JAMIYYAH ISLAMIYYAH - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Background Image and Gradient */
        body {
            background-image: url('https://source.unsplash.com/random/1920x1080?education');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
            min-height: 100vh;
            margin: 0;
        }
        /* Gradient Overlay */
        .gradient-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(rgba(34, 193, 195, 0.5), rgba(253, 187, 45, 0.5)); /* Green gradient */
            z-index: 1;
        }
        /* Form Container */
        .form-container {
            background-color: #f0fdfa; /* Soft green background */
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            position: relative;
            z-index: 2; /* Ensure form is above gradient overlay */
        }
        .logo {
            max-width: 150px;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">

    <!-- Gradient Overlay -->
    <div class="gradient-overlay"></div>

    <!-- Main Container -->
    <div class="form-container">
        <!-- Logo -->
        <div class="flex justify-center mb-6">
            <img src="{{ asset('images/MA.png') }}" alt="Logo" class="logo">
        </div>

        <!-- Form -->
        <h2 class="text-xl font-bold text-gray-700 mb-1 text-center">PONDOK PESANTREN</h2>
        <h3 class="text-lg font-semibold text-gray-700 mb-4 text-center">JAMIYYAH ISLAMIYYAH</h3>
        <form method="POST" action="{{ route('login.submit') }}">
            @csrf
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-600 mb-2">Username</label>
                <input type="text" name="username" id="username" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-600 mb-2">Password</label>
                <input type="password" name="password" id="password" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">Login</button>
        </form>
    </div>

</body>
</html>