<script>
/* MATRIX TERMINAL */
const terminal = document.getElementById('terminal');
const message = "BOGO SI KERBIE VILLACERAN";
let index = 0;

function addLine() {
    const line = document.createElement('span');
    
    let output = "";
    for (let i = 0; i < 80; i++) {
        output += message[index % message.length];
        index++;
    }

    line.textContent = output;
    line.className = 'terminal-line';
    terminal.appendChild(line);
    terminal.scrollTop = terminal.scrollHeight;
}

setInterval(addLine, 120);


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


/* GUARANTEED AUTOPLAY FIX — MUTED FIRST THEN UNMUTE */
const music = document.getElementById('cyberMusic');
const playBtn = document.getElementById('playMusic');
const visualizer = document.getElementById('audioVisualizer');
let isPlaying = false;

music.volume = 0.5;

// Start muted (bypass Chrome restriction)
music.muted = true;

// Function to force autoplay
function forceAutoplay() {
    music.play().then(() => {
        isPlaying = true;
        playBtn.textContent = "Pause Music";

        // show visualizer
        visualizer.style.opacity = 1;

        // unmute after autoplay success
        setTimeout(() => {
            music.muted = false;
        }, 500);

    }).catch(() => {
        // retry until autoplay works
        setTimeout(forceAutoplay, 500);
    });
}

forceAutoplay();

// Manual toggle
playBtn.addEventListener('click', () => {
    if (!isPlaying) {
        music.play();
        isPlaying = true;
        playBtn.textContent = "Pause Music";
        visualizer.style.opacity = 1;
    } else {
        music.pause();
        isPlaying = false;
        playBtn.textContent = "Play Music";
        visualizer.style.opacity = 0;
    }
});


/* MANY POP-UP GLITCH IMAGES (UNCHANGED) */
const glitchContainer = document.getElementById('glitchContainer');
const popImages = [
    "{{ asset('images/kebri.png') }}",
    "{{ asset('images/kebri.png') }}",
    "{{ asset('images/kebri.png') }}"
];

function createGlitchPop(){
    const img=document.createElement('div');
    img.className="glitch-pop";
    img.style.backgroundImage=`url('${popImages[Math.floor(Math.random()*popImages.length)]}')`;

    const size=Math.random()*120+80;
    img.style.width=size+"px";
    img.style.height=size+"px";

    img.style.top=Math.random()*window.innerHeight+"px";
    img.style.left=Math.random()*window.innerWidth+"px";

    glitchContainer.appendChild(img);

    setTimeout(()=>{ img.remove(); },3000);
}

setInterval(()=>{ 
    for(let i=0;i<5;i++){ createGlitchPop(); }
},800);
</script>
