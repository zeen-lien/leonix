<x-guest-layout>
    <style>
        html, body { overflow-x: hidden; }
        .cyberpunk-gradient {
            background: linear-gradient(90deg, #00FFC6 0%, #A78BFA 50%, #FF5AF7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .cyberpunk-outline {
            border-width: 3px;
            border-style: solid;
            border-image: linear-gradient(90deg, #00FFC6 0%, #A78BFA 50%, #FF5AF7 100%) 1;
        }
        .cyberpunk-btn {
            background: linear-gradient(90deg, #00FFC6 0%, #A78BFA 50%, #FF5AF7 100%);
            color: #111;
            font-weight: bold;
            border: none;
            transition: background 0.2s;
        }
        .cyberpunk-btn:hover {
            background: linear-gradient(90deg, #FF5AF7 0%, #A78BFA 50%, #00FFC6 100%);
        }
        .cyberpunk-input:focus {
            border-image: linear-gradient(90deg, #FF5AF7 0%, #00FFC6 100%) 1;
            box-shadow: 0 0 8px #FF5AF7, 0 0 16px #00FFC6;
        }
        .scanline {
            position: absolute;
            left: 0; top: 0; width: 100%; height: 100%;
            pointer-events: none;
            background: repeating-linear-gradient(
                to bottom,
                rgba(255,255,255,0.04) 0px,
                rgba(255,255,255,0.04) 1px,
                transparent 1px,
                transparent 6px
            );
            animation: scanmove 4s linear infinite;
        }
        @keyframes scanmove {
            0% { background-position-y: 0; }
            100% { background-position-y: 6px; }
        }
        /* Animasi transisi blur + slide */
        .page-anim {
            transition: opacity 1.2s cubic-bezier(.77,0,.18,1), filter 1.2s cubic-bezier(.77,0,.18,1), transform 1.2s cubic-bezier(.77,0,.18,1);
            will-change: opacity, filter, transform;
        }
        .page-hidden {
            opacity: 0;
            filter: blur(32px) brightness(1.2);
            transform: translateY(60px) scale(1.04);
            pointer-events: none;
        }
        .page-visible {
            opacity: 1;
            filter: blur(0) brightness(1);
            transform: none;
            pointer-events: auto;
        }
        /* Loading overlay */
        .loading-overlay {
            position: fixed;
            inset: 0;
            z-index: 99999;
            background: rgba(10,10,20,0.98);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.7s cubic-bezier(.77,0,.18,1), filter 0.7s cubic-bezier(.77,0,.18,1);
            will-change: opacity, filter;
        }
        .loading-overlay.hide {
            opacity: 0;
            filter: blur(32px);
            pointer-events: none;
        }
        .leonix-logo {
            display: flex;
            gap: 0.2em;
            font-family: 'Space Grotesk', sans-serif;
            font-weight: bold;
            font-size: 4rem;
            letter-spacing: 0.12em;
            user-select: none;
        }
        .leonix-logo span {
            opacity: 0;
            transform: translateY(40px) scale(0.9);
            filter: blur(12px);
            animation: logoIn 0.5s cubic-bezier(.77,0,.18,1) forwards;
        }
        .leonix-logo span.l {
            color: #00FFC6;
            text-shadow: 0 0 16px #00FFC6, 0 0 32px #00FFC6;
            animation-delay: 0.1s;
        }
        .leonix-logo span.e {
            color: #A78BFA;
            text-shadow: 0 0 16px #A78BFA, 0 0 32px #A78BFA;
            animation-delay: 0.3s;
        }
        .leonix-logo span.o {
            color: #FF5AF7;
            text-shadow: 0 0 16px #FF5AF7, 0 0 32px #FF5AF7;
            animation-delay: 0.5s;
        }
        .leonix-logo span.n {
            color: #FFD600;
            text-shadow: 0 0 16px #FFD600, 0 0 32px #FFD600;
            animation-delay: 0.7s;
        }
        .leonix-logo span.i {
            color: #00FFC6;
            text-shadow: 0 0 16px #00FFC6, 0 0 32px #00FFC6;
            animation-delay: 0.9s;
        }
        .leonix-logo span.x {
            color: #FF5AF7;
            text-shadow: 0 0 16px #FF5AF7, 0 0 32px #FF5AF7;
            animation-delay: 1.1s;
        }
        @keyframes logoIn {
            0% { opacity: 0; transform: translateY(40px) scale(0.9); filter: blur(12px); }
            100% { opacity: 1; transform: none; filter: blur(0); }
        }
        /* Notifikasi cyberpunk (opsional) */
        .notif-cyberpunk {
            position: fixed;
            top: 0; left: 0; width: 100vw; height: 100vh;
            z-index: 9999;
            display: flex; align-items: center; justify-content: center;
            background: rgba(10,10,20,0.55);
            backdrop-filter: blur(2px);
        }
        .notif-card {
            background: rgba(10,10,20,0.98);
            border-radius: 1.2rem;
            border: 3px solid transparent;
            border-image: linear-gradient(90deg, #00FFC6 0%, #A78BFA 50%, #FF5AF7 100%) 1;
            box-shadow: 0 0 32px #00FFC6, 0 0 64px #FF5AF7;
            padding: 2.5rem 2.5rem 2rem 2.5rem;
            min-width: 320px;
            max-width: 90vw;
            text-align: center;
            color: #fff;
            font-family: 'Space Grotesk', sans-serif;
            animation: notifIn 1.2s cubic-bezier(.77,0,.18,1);
        }
        @keyframes notifIn {
            0% { opacity: 0; transform: scale(0.9) translateY(40px); filter: blur(16px); }
            100% { opacity: 1; transform: none; filter: blur(0); }
        }
        .notif-cyberpunk .cyberpunk-gradient {
            font-size: 2.1rem;
            font-weight: bold;
        }
    </style>
    <!-- Cyberpunk Background -->
    <div class="fixed inset-0 -z-10 pointer-events-none select-none bg-black w-full h-full overflow-hidden">
        <!-- Diagonal Grid SVG -->
        <svg class="absolute inset-0 w-full h-full" width="100%" height="100%" viewBox="0 0 1920 1080" fill="none" preserveAspectRatio="none">
            <g stroke="#00FFC6" stroke-width="1" opacity="0.08">
                <line x1="0" y1="0" x2="1920" y2="1080" />
                <line x1="0" y1="180" x2="1740" y2="1080" />
                <line x1="0" y1="360" x2="1560" y2="1080" />
                <line x1="0" y1="540" x2="1380" y2="1080" />
                <line x1="0" y1="720" x2="1200" y2="1080" />
                <line x1="0" y1="900" x2="1020" y2="1080" />
                <line x1="1920" y1="0" x2="0" y2="1080" />
                <line x1="1920" y1="180" x2="180" y2="1080" />
                <line x1="1920" y1="360" x2="360" y2="1080" />
                <line x1="1920" y1="540" x2="540" y2="1080" />
                <line x1="1920" y1="720" x2="720" y2="1080" />
                <line x1="1920" y1="900" x2="900" y2="1080" />
            </g>
        </svg>
        <!-- Particle/Starfield + Shooting Stars -->
        <canvas id="starfield" class="absolute inset-0 w-full h-full" style="z-index:1;"></canvas>
        <!-- Scanline -->
        <div class="scanline"></div>
    </div>
    <div class="min-h-screen w-full flex flex-col items-center justify-center py-10 px-4 overflow-x-hidden overflow-y-auto relative">
        <div class="w-full max-w-md rounded-2xl p-8 sm:p-10 bg-black/80 cyberpunk-outline">
            <h2 class="text-3xl font-extrabold text-center mb-8 tracking-wide cyberpunk-gradient">Masuk ke Leonix</h2>
            
            @if (session('status'))
                <div class="mb-6">
                    <div class="text-cyan-400 text-sm font-bold mb-1 border-l-4 border-cyan-400 pl-3 bg-black/60 rounded">
                        {{ session('status') }}
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6">
                    @foreach ($errors->all() as $error)
                        <div class="text-pink-400 text-sm font-bold mb-1 border-l-4 border-pink-400 pl-3 bg-black/60 rounded">{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" autocomplete="off">
                @csrf
                <!-- Email -->
                <div class="mb-5">
                    <label for="email" class="block text-sm font-semibold mb-1 cyberpunk-gradient">Email</label>
                    <input id="email" name="email" type="email" required autofocus autocomplete="username" class="block w-full rounded-xl bg-black/40 text-white border-2 cyberpunk-outline focus:border-pink-400 focus:ring-2 focus:ring-cyan-400 placeholder-cyan-300 px-4 py-2 transition-all duration-200 outline-none cyberpunk-input" placeholder="Email">
                </div>
                <!-- Password -->
                <div class="mb-5 relative">
                    <label for="password" class="block text-sm font-semibold mb-1 cyberpunk-gradient">Password</label>
                    <input :type="showPassword ? 'text' : 'password'" id="password" name="password" required autocomplete="current-password" class="block w-full rounded-xl bg-black/40 text-white border-2 cyberpunk-outline focus:border-pink-400 focus:ring-2 focus:ring-cyan-400 placeholder-cyan-300 px-4 py-2 pr-12 transition-all duration-200 outline-none cyberpunk-input" placeholder="Password">
                    <button type="button" @click="showPassword = !showPassword" class="absolute right-3 top-8 text-cyan-300 hover:text-pink-400 focus:outline-none transition">
                        <template x-if="showPassword">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-all duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                        </template>
                        <template x-if="!showPassword">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-all duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.956 9.956 0 012.293-3.95m1.414-1.414A9.956 9.956 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.956 9.956 0 01-4.043 5.197M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        </template>
                    </button>
                </div>
                <!-- Remember Me -->
                <div class="mb-6 flex items-center">
                    <input id="remember_login" name="remember" type="checkbox" class="h-4 w-4 text-cyan-400 bg-black border-cyan-400 rounded focus:ring-pink-400">
                    <label for="remember_login" class="ml-2 block text-sm text-cyan-200">Ingat saya</label>
                </div>
                <div class="flex flex-col gap-3">
                    <button type="submit" class="w-full py-3 px-4 rounded-xl cyberpunk-btn flex items-center justify-center relative text-lg transition-all duration-200">
                        Masuk
                    </button>
                    <a href="{{ route('register') }}" class="w-full py-3 px-4 rounded-xl border-2 cyberpunk-outline bg-black/60 text-cyan-100 font-bold shadow-md flex items-center justify-center gap-2 hover:bg-pink-900/40 hover:text-pink-400 transition text-base text-center">
                        Belum punya akun? <span class="font-bold ml-1">Daftar</span>
                    </a>
                </div>
            </form>
        </div>
        <!-- Notifikasi cyberpunk (opsional, bisa diaktifkan jika ingin) -->
        <!--
        <template x-if="notif">
            <div class="notif-cyberpunk">
                <div class="notif-card">
                    <div class="cyberpunk-gradient mb-2">Login Berhasil!</div>
                    <div class="text-cyan-200 mb-2">Selamat datang kembali di Leonix.</div>
                    <div class="text-xs text-pink-400">Mengalihkan ke dashboard...</div>
                </div>
            </div>
        </template>
        -->
    </div>
    <script>
        // Starfield/Particle background + Shooting Stars
        document.addEventListener('DOMContentLoaded', function() {
            const canvas = document.getElementById('starfield');
            if (!canvas) return;
            const ctx = canvas.getContext('2d');
            let w = canvas.width = window.innerWidth;
            let h = canvas.height = window.innerHeight;
            let stars = Array.from({length: 60}, () => ({
                x: Math.random()*w,
                y: Math.random()*h,
                r: Math.random()*1.5+0.5,
                dx: (Math.random()-0.5)*0.1,
                dy: (Math.random()-0.5)*0.1,
                c: ["#00FFC6","#A78BFA","#FF5AF7","#FFD600"][Math.floor(Math.random()*4)]
            }));
            // Shooting stars
            let shootingStars = [];
            function spawnShootingStar() {
                const y = Math.random() * h * 0.7 + h * 0.1;
                shootingStars.push({
                    x: Math.random() * w * 0.7,
                    y: y,
                    len: 120 + Math.random()*60,
                    speed: 8 + Math.random()*4,
                    alpha: 1,
                    color: ["#00FFC6","#A78BFA","#FF5AF7","#FFD600"][Math.floor(Math.random()*4)]
                });
            }
            setInterval(()=>{
                if (shootingStars.length < 2 && Math.random() > 0.5) spawnShootingStar();
            }, 1200);
            function draw() {
                ctx.clearRect(0,0,w,h);
                // Draw stars
                for (const s of stars) {
                    ctx.beginPath();
                    ctx.arc(s.x, s.y, s.r, 0, 2*Math.PI);
                    ctx.fillStyle = s.c;
                    ctx.globalAlpha = 0.7;
                    ctx.shadowColor = s.c;
                    ctx.shadowBlur = 8;
                    ctx.fill();
                    ctx.globalAlpha = 1;
                }
                // Draw shooting stars
                for (const s of shootingStars) {
                    ctx.save();
                    ctx.globalAlpha = s.alpha;
                    ctx.strokeStyle = s.color;
                    ctx.shadowColor = s.color;
                    ctx.shadowBlur = 16;
                    ctx.lineWidth = 2.5;
                    ctx.beginPath();
                    ctx.moveTo(s.x, s.y);
                    ctx.lineTo(s.x + s.len, s.y + s.len * 0.2);
                    ctx.stroke();
                    ctx.restore();
                }
            }
            function update() {
                for (const s of stars) {
                    s.x += s.dx;
                    s.y += s.dy;
                    if (s.x < 0) s.x = w; if (s.x > w) s.x = 0;
                    if (s.y < 0) s.y = h; if (s.y > h) s.y = 0;
                }
                for (let i = shootingStars.length-1; i >= 0; i--) {
                    const s = shootingStars[i];
                    s.x += s.speed;
                    s.y += s.speed * 0.2;
                    s.alpha -= 0.012;
                    if (s.x > w || s.y > h || s.alpha <= 0) shootingStars.splice(i,1);
                }
            }
            function loop() {
                update();
                draw();
                requestAnimationFrame(loop);
            }
            window.addEventListener('resize', ()=>{
                w = canvas.width = window.innerWidth;
                h = canvas.height = window.innerHeight;
            });
            loop();
        });
    </script>
</x-guest-layout>
