<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fiesta Recipe Box</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;600;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-fiesta-cream font-sans text-fiesta-brown antialiased">

    @php
        $flags = ['bg-fiesta-red', 'bg-fiesta-gold', 'bg-fiesta-blue', 'bg-fiesta-leaf'];
    @endphp

    <header class="bg-fiesta-blue text-center text-white">
        <div class="px-4 py-6">
            <h1 class="text-4xl font-extrabold tracking-wide text-fiesta-gold sm:text-5xl">Fiesta Recipe Box</h1>
            <p class="mt-1 text-lg font-semibold">Handaan ng Lutong Pinoy</p>
        </div>

        <div class="flex overflow-hidden border-t-4 border-fiesta-gold bg-fiesta-cream" aria-hidden="true">
            @for ($i = 0; $i < 48; $i++)
                <span class="h-8 w-10 shrink-0 {{ $flags[$i % 4] }} [clip-path:polygon(0_0,100%_0,50%_100%)]"></span>
            @endfor
        </div>
    </header>

    <main>
        <livewire:recipe-box />
    </main>

    <footer class="py-6 text-center font-semibold text-fiesta-blue">
        Mabuhay! Salamat sa pagbisita.
    </footer>

</body>
</html>