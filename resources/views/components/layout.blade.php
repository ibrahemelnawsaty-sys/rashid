@props(['title' => 'رشيد — مستشارك المالي'])
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#0E5A4A">
    <title>{{ $title }}</title>
    <script>
        (function () {
            try {
                var s = localStorage.getItem('rashid-theme');
                if (s === 'dark' || (!s && matchMedia('(prefers-color-scheme: dark)').matches)) {
                    document.documentElement.classList.add('dark');
                }
            } catch (e) {}
        })();
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <main class="app-viewport">
        {{ $slot }}
    </main>
</body>
</html>
