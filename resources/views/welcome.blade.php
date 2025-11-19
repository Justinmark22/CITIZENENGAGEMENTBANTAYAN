<!-- resources/views/cyberpunk.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FUCK OFF </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Background Grid */
        body {
            margin: 0;
            padding: 0;
            background: #0a0a0a;
            color: #0ff;
            font-family: 'Courier New', Courier, monospace;
            overflow: hidden;
        }

        .grid-background {
            position: fixed;
            top:0; left:0;
            width:100%;
            height:100%;
            background: repeating-linear-gradient(
                0deg,
                rgba(0,255,255,0.05) 0px,
                rgba(0,255,255,0.05) 1px,
                transparent 1px,
                transparent 20px
            ),
            repeating-linear-gradient(
                90deg,
                rgba(0,255,255,0.05) 0px,
                rgba(0,255,255,0.05) 1px,
                transparent 1px,
                transparent 20px
            );
            z-index: -2;
            animation: gridmove 20s linear infinite;
        }

        @keyframes gridmove {
            0% {background-position: 0 0, 0 0;}
            100% {background-position: 200px 200px, 200px 200px;}
        }

        /* Neon text */
        .neon {
            text-shadow:
                0 0 5px #0ff,
                0 0 10px #0ff,
                0 0 20px #0ff,
                0 0 40px #0ff;
        }

        /* Terminal Card */
        .terminal {
            background: rgba(0,0,0,0.7);
            border: 1px solid #0ff;
            box-shadow: 0 0 20px #0ff;
            border-radius: 10px;
            padding: 20px;
            max-width: 700px;
            width: 90%;
            overflow-y: auto;
            height: 300px;
        }

        /* Animated terminal text */
        .terminal-line {
            display: block;
            opacity: 0;
            animation: fadein 0.5s forwards;
        }

        @keyframes fadein {
            to { opacity: 1; }
        }

        /* Neon Buttons */
        .neon-button {
            border: 1px solid #0ff;
            color: #0ff;
            padding: 12px 24px;
            font-weight: bold;
            border-radius: 8px;
            transition: 0.3s;
        }
        .neon-button:hover {
            background: #0ff;
            color: black;
            box-shadow: 0 0 20px #0ff, 0 0 40px #0ff;
        }
    </style>
</head>
<body>
    <!-- Background Grid -->
    <div class="grid-background"></div>

    <!-- Floating Particles -->
    <canvas id="particles" style="position:fixed; top:0; left:0; width:100%; height:100%; z-index:-1;"></canvas>

    <!-- Page Content -->
    <div class="flex flex-col items-center justify-center min-h-screen space-y-10 p-5">
        <h1 class="text-5xl neon font-bold">FUCK ALL OF YOU </h1>

        <div class="terminal" id="terminal"></div>

        <div class="flex space-x-5">
            <button class="neon-button">Launch Hack</button>
            <button class="neon-button">Access Server</button>
        </div>
    </div>

    <!-- Background Cyberpunk Music -->
    <audio autoplay loop>
        <source src="{{ asset('music/cyberpunk.mp3') }}" type="audio/mpeg">
    </audio>

    <!-- Terminal Animation Script -->
    <script>
        const terminal = document.getElementById('terminal');
        const lines = [
            'Initializing system...',
            'Connecting to secure server...',
            'Access granted.',
            'Loading modules...',
            'Decrypting data...',
            'Hacker mode activated.',
            'Welcome, cyber agent.'
        ];

        let i = 0;
        function typeLine() {
            if(i < lines.length){
                const line = document.createElement('span');
                line.className = 'terminal-line';
                line.textContent = lines[i];
                terminal.appendChild(line);
                terminal.scrollTop = terminal.scrollHeight;
                i++;
                setTimeout(typeLine, 800);
            }
        }
        typeLine();
    </script>

    <!-- Particle Script -->
    <script>
        const canvas = document.getElementById('particles');
        const ctx = canvas.getContext('2d');
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;

        const particles = [];
        for(let i=0; i<100; i++){
            particles.push({
                x: Math.random()*canvas.width,
                y: Math.random()*canvas.height,
                size: Math.random()*3+1,
                speed: Math.random()*1+0.5,
                color: ['#0ff','#f0f','#0f0','#ff0'][Math.floor(Math.random()*4)]
            });
        }

        function animate(){
            ctx.clearRect(0,0,canvas.width,canvas.height);
            particles.forEach(p => {
                ctx.fillStyle = p.color;
                ctx.beginPath();
                ctx.arc(p.x,p.y,p.size,0,Math.PI*2);
                ctx.fill();
                p.y -= p.speed;
                if(p.y < 0) p.y = canvas.height;
            });
            requestAnimationFrame(animate);
        }
        animate();

        window.addEventListener('resize', () => {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        });
    </script>
</body>
</html>




