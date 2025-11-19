<!-- resources/views/cyberpunk.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CYBERPUNK SYSTEM ACCESS</title>
<script src="https://cdn.tailwindcss.com"></script>

<style>
    body {
        margin:0;
        padding:0;
        background:#050505;
        color:#00faff;
        font-family: "Courier New", monospace;
        overflow:hidden;
    }

    /* CRT Scanlines */
    .scanlines {
        position: fixed;
        top:0; left:0;
        width:100%; height:100%;
        pointer-events:none;
        background: repeating-linear-gradient(
            to bottom,
            rgba(0,255,255,0.03) 0px,
            rgba(0,255,255,0.03) 1px,
            transparent 1px,
            transparent 3px
        );
        z-index:999;
        animation: scan 8s linear infinite;
    }
    @keyframes scan {
        0% { transform: translateY(-100%); }
        100% { transform: translateY(100%); }
    }

    /* Grid BG */
    .grid-bg {
        position:fixed;
        inset:0;
        background:
        linear-gradient(0deg, rgba(0,255,255,0.06) 1px, transparent 1px),
        linear-gradient(90deg, rgba(0,255,255,0.06) 1px, transparent 1px);
        background-size: 30px 30px;
        animation: moveGrid 15s linear infinite;
        z-index:-10;
    }
    @keyframes moveGrid {
        from { background-position:0 0; }
        to { background-position:300px 300px; }
    }

    /* Stronger Glitch Image Layer */
    .glitch {
        position:fixed;
        inset:0;
        background-size:cover;
        background-position:center;
        opacity:0.08;
        mix-blend-mode:screen;
        animation: glitchMove 2s infinite;
        z-index:-9;
    }
    @keyframes glitchMove {
        0% { transform:translate(0,0); opacity:0.05; }
        25% { transform:translate(-20px,10px); opacity:0.12; }
        50% { transform:translate(15px,-10px); opacity:0.09; }
        75% { transform:translate(-10px,20px); opacity:0.13; }
        100% { transform:translate(0,0); opacity:0.05; }
    }

    /* SUPER HACKER TERMINAL BOX */
    .terminal {
        width:90%;
        max-width:900px;
        height:420px;
        overflow-y:auto;
        border:2px solid #00faff;
        border-radius:10px;
        background:rgba(0,0,0,0.75);
        box-shadow:0 0 25px #00faff, inset 0 0 20px #00faff;
        padding:20px;
        font-size:17px;
        text-shadow:0 0 4px #00faff;
    }

    .terminal-line {
        display:block;
        color:#00faff;
        animation: typeIn 0.08s linear forwards;
    }

    @keyframes typeIn {
        from { opacity:0; transform:translateX(-10px); }
        to   { opacity:1; transform:translateX(0); }
    }

    /* Buttons */
    .btn {
        border:2px solid #00faff;
        padding:12px 25px;
        color:#00faff;
        font-weight:bold;
        border-radius:10px;
        transition:0.2s;
        text-shadow:0 0 5px #00faff;
    }
    .btn:hover {
        background:#00faff;
        color:black;
        box-shadow:0 0 20px #00faff;
    }

    /* VISUALIZER */
    #visual {
        width:210px;
        height:70px;
        display:flex;
        opacity:0;
        transition:0.5s;
        margin-top:10px;
    }
    .bar {
        width:10px;
        margin-right:5px;
        background:#00faff;
        border-radius:5px;
        animation: bounce 0.6s infinite alternate ease-in-out;
    }
    @keyframes bounce {
        from { height:10px; }
        to { height:70px; }
    }

</style>
</head>
<body>

<div class="grid-bg"></div>

<div class="glitch" style="background-image:url('{{ asset('images/kebri.png') }}');"></div>

<div class="scanlines"></div>

<div class="flex flex-col items-center justify-center min-h-screen space-y-6 p-6">
    
    <h1 class="text-4xl md:text-5xl font-bold neon">
        SYSTEM BREACH // ACCESS GRANTED
    </h1>

    <div class="terminal" id="terminal"></div>

    <div class="flex space-x-6">
        <button class="btn">INITIATE BREACH</button>
        <button class="btn">OVERRIDE FIREWALL</button>
    </div>

    <div id="visual">
        <div class="bar" style="animation-delay:0s"></div>
        <div class="bar" style="animation-delay:0.1s"></div>
        <div class="bar" style="animation-delay:0.2s"></div>
        <div class="bar" style="animation-delay:0.3s"></div>
        <div class="bar" style="animation-delay:0.4s"></div>
    </div>
</div>

<!-- AUTOPLAY MUSIC -->
<audio id="cyberMusic" autoplay loop>
    <source src="{{ asset('music/Sub_Urban_-_Cradles_slowed_reverb_(mp3.pm).mp3') }}" type="audio/mpeg">
</audio>

<script>
/* TERMINAL STREAMING */
const terminal = document.getElementById("terminal");
let text = "ACCESSING ENCRYPTED CHANNEL >>> KERBIE VILLACERAN IS A CERTIFIED BOGO >>> ";
let i = 0;

function addLine(){
    let line = document.createElement("div");
    line.className = "terminal-line";

    let out = "";
    for(let x = 0; x < 100; x++){
        out += text[i % text.length];
        i++;
    }

    line.textContent = out;
    terminal.appendChild(line);
    terminal.scrollTop = terminal.scrollHeight;
}
setInterval(addLine, 100);


/* FORCE AUTOPLAY MUSIC */
const audio = document.getElementById("cyberMusic");
const visual = document.getElementById("visual");

audio.volume = 0.5;

// Autoplay fallback
const tryPlay = () => {
    audio.play().then(() => {
        visual.style.opacity = 1;
    }).catch(() => {
        setTimeout(tryPlay, 1000); // keep trying until browser allows
    });
};

tryPlay();
</script>

</body>
</html>
