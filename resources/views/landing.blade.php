<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leonix - Manajemen Dokumen yang Aman</title>
    <meta name="description" content="Simpan, atur, dan akses dokumen Anda dengan aman menggunakan Leonix. Manajemen file modern dengan keamanan tingkat militer.">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Space Grotesk', sans-serif;
            background: #000000;
            color: #ffffff;
            overflow-x: hidden;
        }
        
        .hero-gradient {
            background: #000000;
        }
        
        .text-gradient {
            background: linear-gradient(135deg, #00ff88 0%, #00ffff 50%, #ff00ff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .btn-primary {
            background: transparent;
            border: 2px solid #00ff88;
            color: #00ff88;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background: #00ff88;
            color: #000000;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 255, 136, 0.3);
        }
        
        .btn-secondary {
            background: transparent;
            border: 2px solid #00ffff;
            color: #00ffff;
            transition: all 0.3s ease;
        }
        
        .btn-secondary:hover {
            background: #00ffff;
            color: #000000;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 255, 255, 0.3);
        }
        
        .particle-canvas {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
        }
        
        .feature-card {
            background: transparent;
            border: 2px solid #00ff88;
            transition: all 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            border-color: #00ffff;
            box-shadow: 0 20px 40px rgba(0, 255, 255, 0.2);
        }
        
        .feature-icon {
            border: 2px solid #00ff88;
            background: transparent;
            color: #00ff88;
        }
        
        .feature-card:hover .feature-icon {
            border-color: #00ffff;
            color: #00ffff;
        }
        
        .step-circle {
            border: 3px solid #00ff88;
            background: transparent;
            color: #00ff88;
        }
        
        .logo-container {
            position: relative;
            width: 400px;
            height: 400px;
        }
        
        @media (max-width: 768px) {
            .logo-container {
                width: 300px;
                height: 300px;
            }
        }
        
        .stats-card {
            background: transparent;
            border: 2px solid #00ff88;
            transition: all 0.3s ease;
        }
        
        .stats-card:hover {
            border-color: #00ffff;
            transform: translateY(-3px);
        }
        
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #000000;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.5s ease;
        }
        
        .loading-logo {
            width: 200px;
            height: 200px;
        }
        
        .mouse-trail {
            position: fixed;
            pointer-events: none;
            z-index: 1000;
        }
        
        @keyframes fade-in {
            0% { opacity: 0; transform: translateY(-24px) scale(0.98); }
            100% { opacity: 1; transform: none; }
        }
        .animate-fade-in { animation: fade-in 0.7s cubic-bezier(.77,0,.18,1); }
    </style>
</head>
<body>
    <!-- Loading Animation -->
    <div id="loadingOverlay" class="loading-overlay">
        <canvas id="loadingCanvas" class="loading-logo" width="200" height="200"></canvas>
    </div>

    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 bg-black/50 backdrop-blur-md border-b border-white/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <span class="text-2xl font-bold text-gradient">L - X</span>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        @if(Auth::user()->hasRole('admin'))
                            <a href="{{ route('admin.dashboard') }}" class="btn-primary px-6 py-2 rounded-lg font-medium">Admin Dashboard</a>
                        @else
                            <a href="{{ route('dashboard') }}" class="btn-primary px-6 py-2 rounded-lg font-medium">Dashboard</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="text-gray-300 hover:text-white transition-colors">Masuk</a>
                        <a href="{{ route('register') }}" class="btn-primary px-6 py-2 rounded-lg font-medium">Mulai</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-gradient min-h-screen flex items-center relative overflow-hidden">
        <!-- Particle Canvas -->
        <canvas id="particleCanvas" class="particle-canvas"></canvas>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Text Content -->
                <div class="hero-content">
                    <h1 class="text-5xl lg:text-7xl font-bold mb-6">
                        <span class="text-gradient">L E O N I X</span>
                    </h1>
                    <p class="text-xl lg:text-2xl text-gray-300 mb-8 leading-relaxed">
                        Manajemen dokumen yang aman untuk dunia modern. Simpan, atur, dan akses file Anda dengan keamanan tingkat militer dan desain yang elegan.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        @auth
                            @if(Auth::user()->hasRole('admin'))
                                <a href="{{ route('admin.dashboard') }}" class="btn-primary px-8 py-4 rounded-lg font-medium text-lg text-center">
                                    Ke Admin Dashboard
                                </a>
                            @else
                                <a href="{{ route('dashboard') }}" class="btn-primary px-8 py-4 rounded-lg font-medium text-lg text-center">
                                    Ke Dashboard
                                </a>
                            @endif
                        @else
                            <a href="{{ route('register') }}" class="btn-primary px-8 py-4 rounded-lg font-medium text-lg text-center">
                                Mulai Gratis
                            </a>
                            <a href="#features" class="btn-secondary px-8 py-4 rounded-lg font-medium text-lg text-center">
                                Pelajari Lebih Lanjut
                            </a>
                        @endauth
                    </div>
                </div>
                
                <!-- Logo Animation -->
                <div class="hero-content flex justify-center lg:justify-end">
                    <div class="logo-container">
                        <canvas id="logoCanvas" width="400" height="400"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if (session('status'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 2500)" x-show="show" x-transition.opacity.duration.500ms class="fixed top-20 left-1/2 transform -translate-x-1/2 z-50 bg-black/90 border-2 border-cyan-400 px-6 py-3 rounded-xl shadow-lg text-cyan-300 font-bold text-lg animate-fade-in">
            {{ session('status') }}
        </div>
    @endif

    <!-- Statistics Section -->
    <section class="py-20 bg-black/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl lg:text-5xl font-bold mb-6 text-white">
                    <span class="text-gradient">Leonix</span> dalam Angka
                </h2>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                    Platform yang dipercaya oleh ribuan pengguna di seluruh Indonesia
                </p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="stats-card p-6 rounded-xl text-center">
                    <div class="text-3xl font-bold text-gradient mb-2" data-count="50">0</div>
                    <div class="text-gray-400">Ribu+ Pengguna</div>
                </div>
                <div class="stats-card p-6 rounded-xl text-center">
                    <div class="text-3xl font-bold text-gradient mb-2" data-count="1000000">0</div>
                    <div class="text-gray-400">File Tersimpan</div>
                </div>
                <div class="stats-card p-6 rounded-xl text-center">
                    <div class="text-3xl font-bold text-gradient mb-2" data-count="99">0</div>
                    <div class="text-gray-400">% Uptime</div>
                </div>
                <div class="stats-card p-6 rounded-xl text-center">
                    <div class="text-3xl font-bold text-gradient mb-2" data-count="256">0</div>
                    <div class="text-gray-400">Bit Enkripsi</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-black/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl lg:text-5xl font-bold mb-6">
                    Mengapa Memilih <span class="text-gradient">Leonix</span>?
                </h2>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                    Rasakan masa depan manajemen file dengan fitur-fitur canggih yang dirancang untuk keamanan, kecepatan, dan kesederhanaan.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Feature 1 -->
                <div class="feature-card p-6 rounded-xl">
                    <div class="w-16 h-16 feature-icon rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-white">Keamanan Tingkat Militer</h3>
                    <p class="text-gray-400">File Anda dienkripsi dengan AES-256 dan disimpan dengan aman di infrastruktur yang terlindungi.</p>
                </div>
                
                <!-- Feature 2 -->
                <div class="feature-card p-6 rounded-xl">
                    <div class="w-16 h-16 feature-icon rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-white">Super Cepat</h3>
                    <p class="text-gray-400">Upload dan akses file Anda secara instan dengan infrastruktur yang dioptimalkan dan jaringan CDN.</p>
                </div>
                
                <!-- Feature 3 -->
                <div class="feature-card p-6 rounded-xl">
                    <div class="w-16 h-16 feature-icon rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-white">Organisasi Cerdas</h3>
                    <p class="text-gray-400">Kategorisasi file berbasis AI dan pencarian cerdas membuat menemukan dokumen Anda menjadi mudah.</p>
                </div>
                
                <!-- Feature 4 -->
                <div class="feature-card p-6 rounded-xl">
                    <div class="w-16 h-16 feature-icon rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-white">Multi-Platform</h3>
                    <p class="text-gray-400">Akses file Anda dari mana saja - desktop, tablet, atau mobile dengan antarmuka web yang responsif.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl lg:text-5xl font-bold mb-6">
                    Bagaimana <span class="text-gradient">Leonix</span> Bekerja
                </h2>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                    Mulai dalam hitungan menit dengan proses tiga langkah sederhana kami.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Step 1 -->
                <div class="text-center">
                    <div class="w-20 h-20 step-circle rounded-full flex items-center justify-center mx-auto mb-6 text-2xl font-bold">
                        1
                    </div>
                    <h3 class="text-2xl font-semibold mb-4 text-white">Upload</h3>
                    <p class="text-gray-400">Drag and drop file Anda atau gunakan antarmuka upload yang intuitif. Mendukung semua jenis file.</p>
                </div>
                
                <!-- Step 2 -->
                <div class="text-center">
                    <div class="w-20 h-20 step-circle rounded-full flex items-center justify-center mx-auto mb-6 text-2xl font-bold">
                        2
                    </div>
                    <h3 class="text-2xl font-semibold mb-4 text-white">Atur</h3>
                    <p class="text-gray-400">AI kami secara otomatis mengkategorikan file Anda dan membuat struktur folder yang cerdas.</p>
                </div>
                
                <!-- Step 3 -->
                <div class="text-center">
                    <div class="w-20 h-20 step-circle rounded-full flex items-center justify-center mx-auto mb-6 text-2xl font-bold">
                        3
                    </div>
                    <h3 class="text-2xl font-semibold mb-4 text-white">Akses</h3>
                    <p class="text-gray-400">Akses file Anda dari mana saja, kapan saja dengan antarmuka web yang aman dan cepat.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section class="py-20 bg-black/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl lg:text-5xl font-bold mb-6 text-white">
                    Pilihan <span class="text-gradient">Paket</span>
                </h2>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                    Pilih paket yang sesuai dengan kebutuhan Anda
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Free Plan -->
                <div class="feature-card p-8 rounded-xl text-center">
                    <h3 class="text-2xl font-bold mb-4 text-white">Gratis</h3>
                    <div class="text-4xl font-bold text-gradient mb-6">Rp 0</div>
                    <ul class="text-gray-400 mb-8 space-y-3">
                        <li>• 5GB Storage</li>
                        <li>• Upload hingga 100MB</li>
                        <li>• Dasar Enkripsi</li>
                        <li>• Support Email</li>
                    </ul>
                    <a href="{{ route('register') }}" class="btn-secondary w-full py-3 rounded-lg">Mulai Gratis</a>
                </div>
                
                <!-- Pro Plan -->
                <div class="feature-card p-8 rounded-xl text-center border-2 border-00ffff">
                    <h3 class="text-2xl font-bold mb-4 text-white">Pro</h3>
                    <div class="text-4xl font-bold text-gradient mb-6">Rp 99.000</div>
                    <div class="text-gray-400 mb-6">/bulan</div>
                    <ul class="text-gray-400 mb-8 space-y-3">
                        <li>• 100GB Storage</li>
                        <li>• Upload hingga 2GB</li>
                        <li>• Enkripsi AES-256</li>
                        <li>• AI Organization</li>
                        <li>• Priority Support</li>
                    </ul>
                    <a href="{{ route('register') }}" class="btn-primary w-full py-3 rounded-lg">Pilih Pro</a>
                </div>
                
                <!-- Enterprise Plan -->
                <div class="feature-card p-8 rounded-xl text-center">
                    <h3 class="text-2xl font-bold mb-4 text-white">Enterprise</h3>
                    <div class="text-4xl font-bold text-gradient mb-6">Custom</div>
                    <ul class="text-gray-400 mb-8 space-y-3">
                        <li>• Unlimited Storage</li>
                        <li>• Upload tanpa batas</li>
                        <li>• Enkripsi End-to-End</li>
                        <li>• Custom Integration</li>
                        <li>• 24/7 Support</li>
                        <li>• SLA Guarantee</li>
                    </ul>
                    <a href="#contact" class="btn-secondary w-full py-3 rounded-lg">Hubungi Kami</a>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-black/50">
        <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
            <h2 class="text-4xl lg:text-5xl font-bold mb-6 text-white">
                Siap untuk Memulai?
            </h2>
            <p class="text-xl text-gray-300 mb-8">
                Bergabunglah dengan ribuan pengguna yang mempercayai Leonix untuk kebutuhan manajemen dokumen mereka.
            </p>
            @auth
                @if(Auth::user()->hasRole('admin'))
                    <a href="{{ route('admin.dashboard') }}" class="btn-primary px-8 py-4 rounded-lg font-medium text-lg inline-block">
                        Ke Admin Dashboard
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="btn-primary px-8 py-4 rounded-lg font-medium text-lg inline-block">
                        Ke Dashboard
                    </a>
                @endif
            @else
                <a href="{{ route('register') }}" class="btn-primary px-8 py-4 rounded-lg font-medium text-lg inline-block">
                    Mulai Uji Coba Gratis
                </a>
            @endauth
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-12 border-t border-white/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <span class="text-2xl font-bold text-gradient">Leonix</span>
                <p class="text-gray-400 mt-4">
                    © 2024 Leonix. Semua hak dilindungi. Manajemen dokumen yang aman untuk dunia modern.
                </p>
            </div>
        </div>
    </footer>

    <!-- Audio Context for Sound Effects -->
    <audio id="particleSound" preload="auto">
        <source src="data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+DyvmwhBSuBzvLZiTYIG2m98OScTgwOUarm7blmGgU7k9n1unEiBC13yO/eizEIHWq+8+OWT" type="audio/wav">
    </audio>

    <!-- Animation Scripts -->
    <script>
        // Loading Animation
        class LoadingAnimation {
            constructor() {
                this.canvas = document.getElementById('loadingCanvas');
                this.ctx = this.canvas.getContext('2d');
                this.particles = [];
                this.targetPositions = [];
                this.loadingProgress = 0;
                
                this.init();
                this.animate();
            }
            
            init() {
                // Define L and X shapes for loading
                const centerX = this.canvas.width / 2;
                const centerY = this.canvas.height / 2;
                const size = 40;
                
                // L shape positions
                for (let i = 0; i < 10; i++) {
                    this.targetPositions.push({
                        x: centerX - size + (i * 4),
                        y: centerY - size
                    });
                }
                for (let i = 0; i < 10; i++) {
                    this.targetPositions.push({
                        x: centerX - size,
                        y: centerY - size + (i * 4)
                    });
                }
                
                // X shape positions
                for (let i = 0; i < 10; i++) {
                    this.targetPositions.push({
                        x: centerX + (i * 4),
                        y: centerY - size + (i * 4)
                    });
                }
                for (let i = 0; i < 10; i++) {
                    this.targetPositions.push({
                        x: centerX + (i * 4),
                        y: centerY + size - (i * 4)
                    });
                }
                
                // Create particles
                for (let i = 0; i < this.targetPositions.length; i++) {
                    this.particles.push({
                        x: Math.random() * this.canvas.width,
                        y: Math.random() * this.canvas.height,
                        targetX: this.targetPositions[i].x,
                        targetY: this.targetPositions[i].y,
                        vx: 0,
                        vy: 0,
                        size: 2,
                        color: i < 20 ? '#00ff88' : '#00ffff'
                    });
                }
            }
            
            animate() {
                this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
                
                this.loadingProgress += 0.02;
                
                this.particles.forEach((particle, index) => {
                    if (index < this.loadingProgress * this.particles.length) {
                        // Move towards target
                        const dx = particle.targetX - particle.x;
                        const dy = particle.targetY - particle.y;
                        
                        particle.vx += dx * 0.05;
                        particle.vy += dy * 0.05;
                        
                        particle.vx *= 0.9;
                        particle.vy *= 0.9;
                        
                        particle.x += particle.vx;
                        particle.y += particle.vy;
                        
                        // Draw particle
                        this.ctx.beginPath();
                        this.ctx.arc(particle.x, particle.y, particle.size, 0, Math.PI * 2);
                        this.ctx.fillStyle = particle.color;
                        this.ctx.fill();
                    }
                });
                
                if (this.loadingProgress < 1) {
                    requestAnimationFrame(() => this.animate());
                } else {
                    // Hide loading overlay
                    setTimeout(() => {
                        document.getElementById('loadingOverlay').style.opacity = '0';
                        setTimeout(() => {
                            document.getElementById('loadingOverlay').style.display = 'none';
                        }, 500);
                    }, 1000);
                }
            }
        }

        // Enhanced Particle System
        class ParticleSystem {
            constructor() {
                this.canvas = document.getElementById('particleCanvas');
                this.ctx = this.canvas.getContext('2d');
                this.particles = [];
                this.mouse = { x: 0, y: 0 };
                this.mouseTrail = [];
                this.audioContext = null;
                this.audioBuffer = null;
                
                this.init();
                this.animate();
                this.addEventListeners();
                this.initAudio();
            }
            
            init() {
                this.canvas.width = window.innerWidth;
                this.canvas.height = window.innerHeight;
                
                // Create particles with neon colors
                const neonColors = ['#00ff88', '#00ffff', '#ff00ff', '#ff0080'];
                for (let i = 0; i < 100; i++) {
                    this.particles.push({
                        x: Math.random() * this.canvas.width,
                        y: Math.random() * this.canvas.height,
                        vx: (Math.random() - 0.5) * 0.5,
                        vy: (Math.random() - 0.5) * 0.5,
                        size: Math.random() * 2 + 1,
                        opacity: Math.random() * 0.5 + 0.2,
                        color: neonColors[Math.floor(Math.random() * neonColors.length)],
                        originalX: Math.random() * this.canvas.width,
                        originalY: Math.random() * this.canvas.height
                    });
                }
            }
            
            initAudio() {
                try {
                    this.audioContext = new (window.AudioContext || window.webkitAudioContext)();
                    const audio = document.getElementById('particleSound');
                    audio.addEventListener('canplaythrough', () => {
                        this.audioBuffer = audio;
                    });
                } catch (e) {
                    console.log('Audio not supported');
                }
            }
            
            playSound() {
                if (this.audioContext && this.audioBuffer) {
                    const source = this.audioContext.createMediaElementSource(this.audioBuffer);
                    source.connect(this.audioContext.destination);
                    this.audioBuffer.currentTime = 0;
                    this.audioBuffer.play();
                }
            }
            
            animate() {
                this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
                
                this.particles.forEach(particle => {
                    // Update position
                    particle.x += particle.vx;
                    particle.y += particle.vy;
                    
                    // Wrap around edges
                    if (particle.x < 0) particle.x = this.canvas.width;
                    if (particle.x > this.canvas.width) particle.x = 0;
                    if (particle.y < 0) particle.y = this.canvas.height;
                    if (particle.y > this.canvas.height) particle.y = 0;
                    
                    // Draw particle with glow effect
                    this.ctx.shadowColor = particle.color;
                    this.ctx.shadowBlur = 10;
                    this.ctx.beginPath();
                    this.ctx.arc(particle.x, particle.y, particle.size, 0, Math.PI * 2);
                    this.ctx.fillStyle = particle.color;
                    this.ctx.fill();
                    this.ctx.shadowBlur = 0;
                });
                
                // Draw mouse trail
                this.drawMouseTrail();
                
                // Draw connections
                this.drawConnections();
                
                requestAnimationFrame(() => this.animate());
            }
            
            drawMouseTrail() {
                this.mouseTrail.forEach((trail, index) => {
                    const opacity = (index / this.mouseTrail.length) * 0.5;
                    this.ctx.beginPath();
                    this.ctx.arc(trail.x, trail.y, 2, 0, Math.PI * 2);
                    this.ctx.fillStyle = `rgba(0, 255, 136, ${opacity})`;
                    this.ctx.fill();
                });
            }
            
            drawConnections() {
                for (let i = 0; i < this.particles.length; i++) {
                    for (let j = i + 1; j < this.particles.length; j++) {
                        const dx = this.particles[i].x - this.particles[j].x;
                        const dy = this.particles[i].y - this.particles[j].y;
                        const distance = Math.sqrt(dx * dx + dy * dy);
                        
                        if (distance < 100) {
                            this.ctx.beginPath();
                            this.ctx.moveTo(this.particles[i].x, this.particles[i].y);
                            this.ctx.lineTo(this.particles[j].x, this.particles[j].y);
                            this.ctx.strokeStyle = `rgba(0, 255, 136, ${0.1 * (1 - distance / 100)})`;
                            this.ctx.stroke();
                        }
                    }
                }
            }
            
            scatterParticles() {
                this.particles.forEach(particle => {
                    const angle = Math.random() * Math.PI * 2;
                    const speed = Math.random() * 5 + 2;
                    particle.vx = Math.cos(angle) * speed;
                    particle.vy = Math.sin(angle) * speed;
                });
                
                // Play sound effect
                this.playSound();
            }
            
            addEventListeners() {
                window.addEventListener('resize', () => {
                    this.canvas.width = window.innerWidth;
                    this.canvas.height = window.innerHeight;
                });
                
                this.canvas.addEventListener('mousemove', (e) => {
                    this.mouse.x = e.clientX;
                    this.mouse.y = e.clientY;
                    
                    // Add to mouse trail
                    this.mouseTrail.push({ x: e.clientX, y: e.clientY });
                    if (this.mouseTrail.length > 20) {
                        this.mouseTrail.shift();
                    }
                    
                    // Particles follow mouse
                    this.particles.forEach(particle => {
                        const dx = this.mouse.x - particle.x;
                        const dy = this.mouse.y - particle.y;
                        const distance = Math.sqrt(dx * dx + dy * dy);
                        
                        if (distance < 100) {
                            particle.vx += dx * 0.001;
                            particle.vy += dy * 0.001;
                        }
                    });
                });
                
                this.canvas.addEventListener('click', () => {
                    this.scatterParticles();
                });
            }
        }

        // Enhanced Logo Animation
        class LogoAnimation {
            constructor() {
                this.canvas = document.getElementById('logoCanvas');
                this.ctx = this.canvas.getContext('2d');
                this.particles = [];
                this.targetPositions = [];
                this.animationPhase = 0;
                this.letterColors = ['#00ff88', '#00ffff', '#ff00ff', '#ff0080', '#ffff00', '#00ff88'];
                window.addEventListener('resize', () => this.resizeAndRedraw());
                this.init();
                this.animate();
            }
            
            resizeAndRedraw() {
                this.particles = [];
                this.targetPositions = [];
                this.init();
            }
            
            init() {
                // Responsive logo size and position
                const w = this.canvas.width = this.canvas.offsetWidth;
                const h = this.canvas.height = this.canvas.offsetHeight;
                const minDim = Math.min(w, h);
                const padding = minDim * 0.08;
                const letterSize = Math.max(36, Math.floor((minDim - 1 * padding) / 15));
                const letterSpacing = letterSize * 1.8;
                const diagonalStep = letterSize * 1.5;
                const centerX = w / 2;
                const centerY = h / 2 + letterSize * 0.5; // Centered
                const letters = 'LEONIX';
                // Place each letter diagonally from bottom-left to top-right
                for (let i = 0; i < letters.length; i++) {
                    const x = centerX - ((letters.length-1)/2) * letterSpacing + i * letterSpacing;
                    const y = centerY + ((letters.length-1)/2) * diagonalStep - i * diagonalStep;
                    this.createLetterParticles(letters[i], x, y, letterSize, this.letterColors[i]);
                }
                // Add diagonal underline (from under L to under X)
                const underlineStartX = centerX - ((letters.length-1)/2) * letterSpacing - letterSize * 0.5;
                const underlineStartY = centerY + ((letters.length-1)/2) * diagonalStep + letterSize * 0.5 + 60;
                const underlineEndX = centerX + ((letters.length-1)/2) * letterSpacing + letterSize * 0.5;
                const underlineEndY = centerY - ((letters.length-1)/2) * diagonalStep + letterSize * 0.5 + 60;
                const underlineParticles = 50;
                for (let i = 0; i < underlineParticles; i++) {
                    const t = i / (underlineParticles - 1);
                    this.targetPositions.push({
                        x: underlineStartX + (underlineEndX - underlineStartX) * t,
                        y: underlineStartY + (underlineEndY - underlineStartY) * t,
                        color: '#00ffff',
                        size: 3
                    });
                }
                // Create particles
                for (let i = 0; i < this.targetPositions.length; i++) {
                    this.particles.push({
                        x: Math.random() * w,
                        y: Math.random() * h,
                        targetX: this.targetPositions[i].x,
                        targetY: this.targetPositions[i].y,
                        vx: 0,
                        vy: 0,
                        size: this.targetPositions[i].size || 5,
                        color: this.targetPositions[i].color,
                        phase: Math.random() * Math.PI * 2,
                        originalSize: this.targetPositions[i].size || 5
                    });
                }
            }
            
            createLetterParticles(letter, startX, startY, size, color) {
                const positions = this.getLetterPositions(letter, startX, startY, size);
                positions.forEach(pos => {
                    this.targetPositions.push({
                        x: pos.x,
                        y: pos.y,
                        color: color,
                        size: 5
                    });
                });
            }
            
            getLetterPositions(letter, startX, startY, size) {
                const positions = [];
                const s = size / 10;
                switch(letter) {
                    case 'L':
                        for (let i = 0; i < 10; i++) positions.push({ x: startX, y: startY + i * s });
                        for (let i = 0; i < 7; i++) positions.push({ x: startX + i * s, y: startY + 9 * s });
                        break;
                    case 'E':
                        for (let i = 0; i < 10; i++) positions.push({ x: startX, y: startY + i * s });
                        for (let i = 0; i < 7; i++) positions.push({ x: startX + i * s, y: startY });
                        for (let i = 0; i < 5; i++) positions.push({ x: startX + i * s, y: startY + 4.5 * s });
                        for (let i = 0; i < 7; i++) positions.push({ x: startX + i * s, y: startY + 9 * s });
                        break;
                    case 'O':
                        for (let i = 0; i < 18; i++) {
                            const angle = (i * Math.PI * 2) / 18;
                            const r = 4 * s;
                            positions.push({ x: startX + Math.cos(angle) * r, y: startY + Math.sin(angle) * r });
                        }
                        break;
                    case 'N':
                        for (let i = 0; i < 10; i++) positions.push({ x: startX, y: startY + i * s });
                        for (let i = 0; i < 10; i++) positions.push({ x: startX + 7 * s, y: startY + i * s });
                        for (let i = 0; i < 11; i++) positions.push({ x: startX + i * (7 * s / 10), y: startY + i * s });
                        break;
                    case 'I':
                        for (let i = 0; i < 7; i++) positions.push({ x: startX + i * s, y: startY });
                        for (let i = 0; i < 10; i++) positions.push({ x: startX + 3 * s, y: startY + i * s });
                        for (let i = 0; i < 7; i++) positions.push({ x: startX + i * s, y: startY + 9 * s });
                        break;
                    case 'X':
                        for (let i = 0; i < 11; i++) positions.push({ x: startX + i * (7 * s / 10), y: startY + i * s });
                        for (let i = 0; i < 11; i++) positions.push({ x: startX + 7 * s - i * (7 * s / 10), y: startY + i * s });
                        break;
                }
                return positions;
            }
            
            animate() {
                this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
                this.animationPhase += 0.02;
                this.particles.forEach((particle, index) => {
                    particle.phase += 0.03;
                    const floatX = Math.sin(particle.phase) * 2;
                    const floatY = Math.cos(particle.phase) * 2;
                    const dx = particle.targetX + floatX - particle.x;
                    const dy = particle.targetY + floatY - particle.y;
                    particle.vx += dx * 0.015;
                    particle.vy += dy * 0.015;
                    particle.vx *= 0.92;
                    particle.vy *= 0.92;
                    particle.x += particle.vx;
                    particle.y += particle.vy;
                    const pulse = Math.sin(this.animationPhase + index * 0.3) * 0.3 + 0.8;
                    const currentSize = particle.originalSize * pulse;
                    this.ctx.shadowColor = particle.color;
                    this.ctx.shadowBlur = 15;
                    this.ctx.beginPath();
                    this.ctx.arc(particle.x, particle.y, currentSize, 0, Math.PI * 2);
                    this.ctx.fillStyle = particle.color;
                    this.ctx.fill();
                    this.ctx.shadowBlur = 0;
                });
                requestAnimationFrame(() => this.animate());
            }
        }

        // Counter Animation
        function animateCounters() {
            const counters = document.querySelectorAll('[data-count]');
            
            counters.forEach(counter => {
                const target = parseInt(counter.getAttribute('data-count'));
                const duration = 2000;
                const step = target / (duration / 16);
                let current = 0;
                
                const timer = setInterval(() => {
                    current += step;
                    if (current >= target) {
                        current = target;
                        clearInterval(timer);
                    }
                    counter.textContent = Math.floor(current).toLocaleString();
                }, 16);
            });
        }

        // Initialize everything when page loads
        document.addEventListener('DOMContentLoaded', () => {
            // Start loading animation
            new LoadingAnimation();
            
            // Initialize main animations after loading
            setTimeout(() => {
                new ParticleSystem();
                new LogoAnimation();
                
                // Animate counters when they come into view
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            animateCounters();
                            observer.unobserve(entry.target);
                        }
                    });
                });
                
                const statsSection = document.querySelector('.stats-card');
                if (statsSection) {
                    observer.observe(statsSection);
                }
            }, 2000);
        });
    </script>
</body>
</html> 