<!DOCTYPE html>
<html lang="en" class="dark">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{ $title ?? 'Ashenreach' }}</title>
<meta name="description" content="Ashenreach medieval text browser game.">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-obsidian text-bone antialiased flex flex-col justify-between" style="background-color: #0E0E0E; color: #E5E5E5;">

    {{ $slot }}

    <footer class="py-6 border-t border-iron text-center text-xs text-silver" style="border-top: 1px solid #262626;">
        <span>Night 42 · Ashenreach Realm</span>
    </footer>

@livewireScripts
</body>
</html>
