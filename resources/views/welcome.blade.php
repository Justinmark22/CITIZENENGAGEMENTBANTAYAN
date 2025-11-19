<!-- resources/views/cyberpunk.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FUCK ALL OF YOU</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            background: #0a0a0a;
            color: #0ff;
            font-family: 'Courier New', Courier, monospace;
            overflow: hidden;
        }

        /* Moving Grid Background */
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

        /* Neon Text & Flicker */
        .neon {
            color: #0ff;
            text-shadow: 0 0 5px #0ff, 0 0 10px #0ff, 0 0 20px #0ff, 0 0 40px #0ff;
            animation: flicker 1.5s infinite alternate;
        }
        @keyframes flicker {
            0%, 19%, 21%, 23%, 25%, 54%, 56%, 100% { text-shadow:0 0 5px #0ff,0 0 10px #0ff,0 0 20px #0ff,0 0 40px #0ff; color:#0ff;}
            20%, 24%, 55% { text-shadow:none; color:#088; }
        }

        /* Terminal */
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

        .terminal-line {
            display: block;
            opacity: 0;
            animation: fadein 0.5s forwards;
            color: #0ff;
        }
        .flicker {
            animation: flickerTerminal 2s infinite alternate;
        }
        @keyframes fadein { to { opacity: 1; } }
        @keyframes flickerTerminal {
            0%, 18%, 22%, 25%, 53%, 57%, 100% { color:#0ff; text-shadow:0 0 5px #0ff,0 0 10px #0ff,0 0 20px #0ff; }
            20%, 24%, 55% { color:#088; text-shadow:none; }
        }

        /* Buttons */
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
    <div class="grid-background"></div>

    <!-- Particles -->
    <canvas id="particles" style="position:fixed; top:0; left:0; width:100%; height:100%; z-index:-1;"></canvas>

    <div class="flex flex-col items-center justify-center min-h-screen space-y-10 p-5">
        <h1 class="text-5xl neon font-bold">FUCK ALL OF YOU MOTHERFUCKERS</h1>

        <div class="terminal" id="terminal"></div>

        <div class="flex space-x-5">
            <button class="neon-button">Launch Hack</button>
            <button class="neon-button">Access Server</button>
        </div>
    </div>

    <!-- Online Cyberpunk Music -->
    <audio autoplay loop>
        <source src="https://cdn.pixabay.com/download/audio/2022/03/15/audio_1a3f4b8372.mp3?filename=cyberpunk-11718.mp3" type="audio/mpeg">
    </audio>

    <script>
        // Terminal Animation
        const terminal = document.getElementById('terminal');
        const lines = [
            'Initializing system...',
            'Connecting to secure server...',
            'Access granted.',
            'Loading modules...',
            'Decrypting data...',
            'Hacker mode activated.',
            'Welcome, cyber agent.',
            'System monitoring active...',
            'Firewall bypass engaged...',
            'Data streams decrypted...'
        ];

        let i = 0;
        function typeLine() {
            if(i < lines.length){
                const line = document.createElement('span');
                line.className = 'terminal-line flicker';
                line.textContent = lines[i];
                terminal.appendChild(line);
                terminal.scrollTop = terminal.scrollHeight;
                i++;
                setTimeout(typeLine, 700);
            }
        }
        typeLine();
    </script>

    <script>
        // Particles Animation
        const canvas = document.getElementById('particles');
        const ctx = canvas.getContext('2d');
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;

        const particles = [];
        for(let i=0; i<120; i++){
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





