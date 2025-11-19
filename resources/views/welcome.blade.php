<!-- resources/views/cyberpunk.blade.php -->
<!DOCTYPE html>
<html lang="en" x-data="{ darkMode: true }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cyberpunk Hacker Theme</title>
    <!-- Tailwind CDN for quick styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Neon text effects */
        .neon {
            text-shadow:
                0 0 5px #0ff,
                0 0 10px #0ff,
                0 0 20px #0ff,
                0 0 40px #0ff;
        }

        body {
            background: #0a0a0a;
            color: #0ff;
            font-family: 'Courier New', Courier, monospace;
            overflow-x: hidden;
        }

        .matrix {
            font-family: monospace;
            color: #0f0;
            white-space: pre;
            animation: matrix 10s linear infinite;
        }

        @keyframes matrix {
            0% { transform: translateY(0); }
            100% { transform: translateY(-100%); }
        }

        .card {
            background: rgba(0,0,0,0.6);
            border: 1px solid #0ff;
            box-shadow: 0 0 20px #0ff;
            border-radius: 10px;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col items-center justify-center space-y-10 p-5">

    <!-- Cyberpunk Header -->
    <h1 class="text-5xl neon font-bold">CYBERPUNK HACKER HUB</h1>

    <!-- Hacker Terminal Card -->
    <div class="card p-5 max-w-2xl w-full">
        <pre class="matrix">
Initializing system...
Connecting to server...
Access granted.
Loading modules...
Welcome, hacker.
        </pre>
    </div>

    <!-- Neon Buttons -->
    <div class="flex space-x-5">
        <button class="px-6 py-3 border border-cyan-500 text-cyan-500 hover:bg-cyan-500 hover:text-black transition-all rounded-lg neon">
            Launch
        </button>
        <button class="px-6 py-3 border border-pink-500 text-pink-500 hover:bg-pink-500 hover:text-black transition-all rounded-lg neon">
            Hack
        </button>
    </div>

    <!-- Background Cyberpunk Music -->
    <audio autoplay loop>
        <source src="{{ asset('music/cyberpunk.mp3') }}" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>

    <!-- Optional Floating Neon Particles -->
    <script>
        const body = document.body;
        for (let i = 0; i < 50; i++) {
            let span = document.createElement('span');
            span.textContent = '*';
            span.style.position = 'absolute';
            span.style.left = Math.random() * window.innerWidth + 'px';
            span.style.top = Math.random() * window.innerHeight + 'px';
            span.style.color = ['#0ff','#f0f','#0f0','#ff0'][Math.floor(Math.random()*4)];
            span.style.fontSize = Math.random()*24 + 12 + 'px';
            span.style.opacity = Math.random();
            body.appendChild(span);
        }
    </script>
</body>
</html>



