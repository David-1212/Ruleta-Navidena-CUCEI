<x-app-layout>
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        🎰 Ruleta
    </h2>
</x-slot>

<button
    id="btnToggleNavbar"
    class="fixed top-24 right-4 sm:right-6 z-50 bg-green-600 hover:bg-green-700 text-white px-4 sm:px-5 py-2 rounded-xl shadow-lg transition text-sm sm:text-base">
    ⬆ Ocultar menú
</button>

<div class="min-h-screen flex items-center justify-center bg-gray-900 px-2 sm:px-6">

<style>
/* ===== OCULTAR NAVBAR ===== */
body.navbar-hidden #navbar-global { display:none; }
body.navbar-hidden { overflow:hidden; }

/* ===== ESCENARIO ===== */
.slot-stage{ background:#000; padding:40px 30px; border-radius:28px; box-shadow:0 0 55px rgba(34,197,94,.65); }
.slot-machine{ display:flex; align-items:center; gap:80px; color:white; }
.reels{ display:flex; gap:40px; }
.reel{ width:520px; height:260px; overflow:hidden; border:6px solid #22c55e; border-radius:22px; background:#000; position:relative; isolation:isolate; }
.reel ul{ list-style:none; padding:0; margin:0; text-align:center; transition:transform 4.8s cubic-bezier(.08,.82,.17,1); }
.reel li{ height:80px; line-height:80px; font-size:34px; color:#777; opacity:.55; white-space:nowrap; padding:0 30px; }
.reel li.active{ color:#22c55e; font-weight:800; opacity:1; }
.window{ position:absolute; top:90px; left:0; right:0; height:80px; border-top:4px solid #22c55e; border-bottom:4px solid #22c55e; z-index:10; }
.reel::before,.reel::after{ content:""; position:absolute; left:0; right:0; height:70px; z-index:9; }
.reel::before{ top:0; background:linear-gradient(to bottom,#000,transparent);}
.reel::after{ bottom:0; background:linear-gradient(to top,#000,transparent);}
.lever{ width:60px; height:380px; }
.lever-stick{ width:12px; height:260px; background:#ccc; margin:0 auto; border-radius:6px; transform-origin:top; transition:transform .25s ease; }
.lever-ball{ width:52px; height:52px; background:red; border-radius:50%; margin:14px auto 0; }
.lever.down .lever-stick{ transform:rotate(32deg); }
</style>

<div class="slot-stage">
<div class="slot-machine">

    <div class="reels">
        <div class="reel">
            <div class="window"></div>
            <ul id="reelNombre"></ul>
        </div>

        <div class="reel">
            <div class="window"></div>
            <ul id="reelPremio"></ul>
        </div>
    </div>

    <div class="lever" id="lever">
        <div class="lever-stick"></div>
        <div class="lever-ball"></div>
    </div>

</div>
</div>

<script>
const btnNavbar=document.getElementById('btnToggleNavbar');
btnNavbar.addEventListener('click',()=>{
    document.body.classList.toggle('navbar-hidden');
    btnNavbar.textContent=document.body.classList.contains('navbar-hidden')
        ? '⬇ Mostrar menú'
        : '⬆ Ocultar menú';
});

let estado="nombre";        // controla la fase de ruleta
let bloqueado=false;
let participanteId=null;
let enterCount=0;           // contador de Enter

const nombres=@json($nombres);
const premios=@json($premios);

const reelNombre=document.getElementById('reelNombre');
const reelPremio=document.getElementById('reelPremio');
const lever=document.getElementById('lever');

function preparar(reel,data){
    reel.innerHTML='';
    let lista=[];
    for(let i=0;i<16;i++) lista.push(...data);
    lista.forEach(t=>{
        const li=document.createElement('li');
        li.textContent=t;
        reel.appendChild(li);
    });
}

preparar(reelNombre,nombres);
preparar(reelPremio,premios);

function girar(reel,valor){
    const items=[...reel.children];
    items.forEach(i=>i.classList.remove('active'));

    const idxs=items.map((el,i)=>el.textContent===valor?i:null).filter(i=>i!==null);
    const index=idxs[idxs.length-4];
    reel.style.transform=`translateY(-${index*80-80}px)`;
    setTimeout(()=>items[index].classList.add('active'),4500);
}

function accionar(){
    lever.classList.add('down');
    setTimeout(()=>lever.classList.remove('down'),320);
}

document.addEventListener('keydown', e=>{
    if(e.key!=='Enter'||bloqueado) return;

    accionar();

    // lógica de 3 Enter
    enterCount++;

    if(enterCount===1){
        girarNombre();
    } else if(enterCount===2){
        girarPremio();
    } else if(enterCount===3){
        // Quita la iluminación de ambos
        [...reelNombre.children, ...reelPremio.children].forEach(i=>i.classList.remove('active'));
        enterCount=0; // reinicia contador
        estado="nombre";
    }
});

function girarNombre(){
    bloqueado=true;
    fetch("{{ route('rifa.girarNombre') }}",{
        method:'POST',
        headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'}
    })
    .then(r=>r.json())
    .then(d=>{
        girar(reelNombre,d.ganador);
        participanteId=d.id;
        estado="premio";
        bloqueado=false;
    });
}

function girarPremio(){
    bloqueado=true;
    fetch("{{ route('rifa.girarPremio') }}",{
        method:'POST',
        headers:{
            'X-CSRF-TOKEN':'{{ csrf_token() }}',
            'Content-Type':'application/json'
        },
        body:JSON.stringify({participante_id:participanteId})
    })
    .then(r=>r.json())
    .then(d=>{
        girar(reelPremio,d.premio);
        estado="reset";
        bloqueado=false;
    });
}
</script>

</div>
</x-app-layout>
