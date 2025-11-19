<!-- resources/views/cyberpunk.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CYBERPUNK HAC</title>
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

    /* Grid background */
    .grid-background {
        position: fixed;
        top:0; left:0;
        width:100%; height:100%;
        background: repeating-linear-gradient(
            0deg, rgba(0,255,255,0.05) 0px, rgba(0,255,255,0.05) 1px, transparent 1px, transparent 20px
        ), repeating-linear-gradient(
            90deg, rgba(0,255,255,0.05) 0px, rgba(0,255,255,0.05) 1px, transparent 1px, transparent 20px
        );
        z-index: -3;
        animation: gridmove 20s linear infinite;
    }
    @keyframes gridmove { 
        0% {background-position:0 0,0 0;} 
        100% {background-position:200px 200px,200px 200px;} 
    }

    /* Glitch background images */
    .glitch-bg {
        position: fixed;
        top:0; left:0;
        width:100%; height:100%;
        background-size: cover;
        background-position: center;
        z-index: -2;
        opacity:0.05;
        animation: glitch 3s infinite;
        mix-blend-mode: screen;
    }
    @keyframes glitch {
        0%{opacity:0.05; transform:translate(0,0) rotate(0deg);}
        25%{opacity:0.1; transform:translate(-10px,5px) rotate(-1deg);}
        50%{opacity:0.07; transform:translate(8px,-5px) rotate(1deg);}
        75%{opacity:0.12; transform:translate(-5px,10px) rotate(-0.5deg);}
        100%{opacity:0.05; transform:translate(0,0) rotate(0deg);}
    }

    /* MANY POP-UP GLITCH IMAGES */
    .glitch-pop {
        position: fixed;
        width: 180px;
        height: 180px;
        background-size: cover;
        background-position: center;
        opacity: 0.15;
        mix-blend-mode: screen;
        animation: popGlitch 3s infinite ease-in-out;
        z-index: -1;
    }

    @keyframes popGlitch {
        0% { transform: scale(0.8) translate(0,0); opacity:0.05; }
        25% { transform: scale(1.1) translate(-10px,5px); opacity:0.25; }
        50% { transform: scale(0.9) translate(8px,-5px); opacity:0.18; }
        75% { transform: scale(1.2) translate(-5px,10px); opacity:0.30; }
        100% { transform: scale(0.8) translate(0,0); opacity:0.10; }
    }

    /* Neon text */
    .neon { 
        color:#0ff; 
        text-shadow:0 0 5px #0ff,0 0 10px #0ff,0 0 20px #0ff,0 0 40px #0ff; 
        animation:flicker 1.5s infinite alternate;
    }
    @keyframes flicker { 
        0%,19%,21%,23%,25%,54%,56%,100%{
            text-shadow:0 0 5px #0ff,0 0 10px #0ff,0 0 20px #0ff,0 0 40px #0ff;
            color:#0ff;
        } 
        20%,24%,55%{
            text-shadow:none;
            color:#088;
        } 
    }

    /* Terminal box */
    .terminal {
        background: rgba(0,0,0,0.7);
        border:1px solid #0ff;
        box-shadow:0 0 20px #0ff;
        border-radius:10px;
        padding:20px;
        max-width:700px;
        width:90%;
        overflow-y:auto;
        height:400px;
        font-size:16px;
        line-height:1.2em;
    }

    .terminal-line { display:block; color:#0ff; }

    /* Buttons */
    .neon-button { 
        border:1px solid #0ff; 
        color:#0ff; 
        padding:12px 24px; 
        font-weight:bold; 
        border-radius:8px; 
        transition:0.3s; 
    }
    .neon-button:hover { 
        background:#0ff; 
        color:black; 
        box-shadow:0 0 20px #0ff,0 0 40px #0ff; 
    }

    .music-btn { 
        margin-top:10px; 
        border:1px solid #f0f; 
        color:#f0f; 
        padding:10px 20px; 
        border-radius:8px; 
        cursor:pointer; 
        font-weight:bold; 
    }
    .music-btn:hover { 
        background:#f0f; 
        color:black; 
        box-shadow:0 0 20px #f0f,0 0 40px #f0f; 
    }
</style>
</head>
<body>

<div class="grid-background"></div>

<!-- Static glitch background layers -->
<div class="glitch-bg" id="glitch1" style="background-image:url('{{ asset('images/bg1.jpg') }}');"></div>
<div class="glitch-bg" id="glitch2" style="background-image:url('{{ asset('images/bg2.jpg') }}');"></div>

<!-- Container for MANY glitch pop-up images -->
<div id="glitchContainer"></div>

<canvas id="particles" style="position:fixed; top:0; left:0; width:100%; height:100%; z-index:-1;"></canvas>

<div class="flex flex-col items-center justify-center min-h-screen space-y-5 p-5">
    <h1 class="text-5xl neon font-bold">CYBERPUNK HACKER TERMINAL</h1>

    <div class="terminal" id="terminal"></div>

    <div class="flex space-x-5">
        <button class="neon-button">Launch Hack</button>
        <button class="neon-button">Access Server</button>
    </div>

    <button id="playMusic" class="music-btn">Play Cyberpunk Music</button>
</div>

<!-- Audio -->
<audio id="cyberMusic" loop>
    <source src="{{ asset('music/cyberpunk.mp3') }}" type="audio/mpeg">
</audio>

<script>
/* MATRIX TERMINAL */
const terminal = document.getElementById('terminal');
const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@#$%^&*()*&^%';
function randomChar(){ return chars.charAt(Math.floor(Math.random()*chars.length)); }

function addLine(){
    const line = document.createElement('span');
    let text = '';
    const length = Math.floor(Math.random()*80)+20;
    for(let i=0;i<length;i++){ text += randomChar(); }
    line.textContent = text;
    line.className = 'terminal-line';
    terminal.appendChild(line);
    terminal.scrollTop = terminal.scrollHeight;
}
setInterval(addLine,120);

/* PARTICLE BACKGROUND */
const canvas=document.getElementById('particles'), ctx=canvas.getContext('2d');
canvas.width=window.innerWidth; canvas.height=window.innerHeight;
const particles=[];
for(let i=0;i<150;i++){
    particles.push({
        x:Math.random()*canvas.width,
        y:Math.random()*canvas.height,
        size:Math.random()*3+1,
        speed:Math.random()*1+0.5,
        color:['#0ff','#f0f','#0f0','#ff0'][Math.floor(Math.random()*4)]
    });
}
function animate(){
    ctx.clearRect(0,0,canvas.width,canvas.height);
    particles.forEach(p=>{
        ctx.fillStyle=p.color;
        ctx.beginPath();
        ctx.arc(p.x,p.y,p.size,0,Math.PI*2);
        ctx.fill();
        p.y -= p.speed;
        if(p.y<0) p.y=canvas.height;
    });
    requestAnimationFrame(animate);
}
animate();

/* WORKING MUSIC */
const music=document.getElementById('cyberMusic');
document.getElementById('playMusic').addEventListener('click',()=>{ music.play(); });
music.volume=0.5;

/* MANY POP-UP GLITCH IMAGES */
const glitchContainer = document.getElementById('glitchContainer');
const popImages = [
    "{{ asset('images/kebri.png') }}",
    "{{ asset('images/kebri.png') }}",
    "{{ asset('images/kebri.png') }}"
];

function createGlitchPop(){
    const img=document.createElement('div');
    img.className="glitch-pop";

    // Random image
    img.style.backgroundImage=`url('${popImages[Math.floor(Math.random()*popImages.length)]}')`;

    // Random size
    const size=Math.random()*120+80;
    img.style.width=size+"px";
    img.style.height=size+"px";

    // Random position
    img.style.top=Math.random()*window.innerHeight+"px";
    img.style.left=Math.random()*window.innerWidth+"px";

    glitchContainer.appendChild(img);

    setTimeout(()=>{ img.remove(); },3000);
}

// Create 5 new glitch images every 0.8 seconds
setInterval(()=>{ 
    for(let i=0;i<5;i++){ createGlitchPop(); }
},800);
</script>

</body>
</html>
