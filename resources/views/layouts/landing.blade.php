<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>@yield('title', "ned’s booth")</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-pink-100 text-center flex flex-col min-h-screen font-sans">

  <!-- Header -->
  <header class="py-4 text-xl font-semibold text-gray-800 bg-white bg-gradient-to-b from-white to-pink-100 shadow">
    ned’s booth
  </header>

  <!-- Main -->
  <main class="flex-grow flex items-center justify-center">
    @yield('content')
  </main>

  @yield('scripts')

  <!-- Footer -->
  <footer class="py-4 text-sm text-gray-600 bg-white bg-gradient-to-t from-white to-pink-100 shadow-inner">
    © 2025 ned’s booth | All Rights Reserved
  </footer>

</body>
</html>
