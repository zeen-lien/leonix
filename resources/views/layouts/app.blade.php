<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Leonix') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <style>
            body {
                background: #0a0a16;
            }
            .cyberpunk-gradient {
                background: linear-gradient(90deg, #00FFC6 0%, #FF5AF7 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }
            .glass-card {
                background: rgba(20, 20, 35, 0.85);
                border: 2px solid transparent;
                border-image: linear-gradient(90deg, #00FFC6 0%, #FF5AF7 100%) 1;
                border-radius: 1rem;
                backdrop-filter: blur(12px);
                box-shadow: 0 8px 32px rgba(0, 255, 198, 0.1);
                padding: 1.5rem;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }
            .glass-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 12px 48px rgba(255, 90, 247, 0.2);
            }
            .glass-title {
                font-size: 1.1rem;
                font-weight: 600;
                margin-bottom: 0.75rem;
                color: #00FFC6;
                text-shadow: 0 0 20px rgba(0, 255, 198, 0.5);
            }
            .glass-value {
                font-size: 2.5rem;
                font-weight: 700;
                background: linear-gradient(90deg, #00FFC6 0%, #FF5AF7 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
                text-shadow: 0 0 30px rgba(255, 90, 247, 0.3);
            }
            .sidebar-desktop {
                background: rgba(20, 20, 35, 0.95);
                border-right: 2px solid rgba(0, 255, 198, 0.1);
                backdrop-filter: blur(12px);
                transition: all 0.3s ease-in-out;
            }
            .nav-link {
                position: relative;
                transition: all 0.3s;
                border: 1px solid rgba(0, 255, 198, 0.1);
                margin-bottom: 0.5rem;
            }
            .nav-link:hover {
                border-color: #00FFC6;
                background: rgba(0, 255, 198, 0.1);
            }
            .nav-link.active {
                border-color: #FF5AF7;
                background: rgba(255, 90, 247, 0.1);
            }
            .fab-menu {
                position: fixed;
                right: 1.5rem;
                bottom: 1.5rem;
                z-index: 50;
            }
            .fab-button {
                width: 56px;
                height: 56px;
                border-radius: 50%;
                background: linear-gradient(135deg, #00FFC6 0%, #FF5AF7 100%);
                box-shadow: 0 0 20px rgba(0, 255, 198, 0.3),
                           0 0 40px rgba(255, 90, 247, 0.2);
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: all 0.3s;
            }
            .fab-button:hover {
                transform: scale(1.1);
                box-shadow: 0 0 30px rgba(0, 255, 198, 0.4),
                           0 0 60px rgba(255, 90, 247, 0.3);
            }
            .mobile-menu {
                background: rgba(20, 20, 35, 0.98);
                backdrop-filter: blur(12px);
                border: 2px solid transparent;
                border-image: linear-gradient(135deg, #00FFC6 0%, #FF5AF7 100%) 1;
            }
            @keyframes slideIn {
                from { transform: translateX(-100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            .animate-slide-in {
                animation: slideIn 0.3s ease-out;
            }
            .logo {
                font-size: 2rem;
                font-weight: 900;
                letter-spacing: 0.1em;
                color: #2dd4bf;
            }
            .btn-gradient {
                background: linear-gradient(90deg, #2dd4bf 0%, #a78bfa 100%);
                color: #ffffff;
                font-weight: bold;
                border-radius: 0.8rem;
                padding: 0.9rem 2.2rem;
            }
        </style>

        @vite(['resources/css/app.css'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-[#0a0a16]" x-data="{ isOpen: true, mobileMenuOpen: false }">
            <!-- Desktop Sidebar -->
            <aside class="sidebar-desktop fixed top-0 left-0 z-40 h-screen hidden lg:block transition-all duration-300"
                   :class="{ 'w-64': isOpen, 'w-20': !isOpen }">
                <!-- Logo -->
                <div class="flex items-center h-16 px-6" :class="{'justify-center': !isOpen}">
                    <span class="text-2xl font-bold cyberpunk-gradient" x-show="isOpen">> L - X <</span>
                    <span class="text-2xl font-bold cyberpunk-gradient" x-show="!isOpen">X</span>
                </div>

                <!-- Navigation -->
                <nav class="px-3 mt-6 space-y-2">
                    <a href="{{ route('dashboard') }}" class="nav-link flex items-center px-4 py-3 text-gray-300 rounded-lg group">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        <span class="ml-3 transition-all duration-200" :class="!isOpen && 'opacity-0 hidden'">Dashboard</span>
                    </a>
                    <a href="{{ route('files.index') }}" class="nav-link flex items-center px-4 py-3 text-gray-300 rounded-lg group">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z"></path></svg>
                        <span class="ml-3 transition-all duration-200" :class="!isOpen && 'opacity-0 hidden'">Berkas</span>
                    </a>
                    @role('admin')
                    <a href="{{ route('admin.dashboard') }}" class="nav-link flex items-center px-4 py-3 text-gray-300 rounded-lg group">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        <span class="ml-3 transition-all duration-200" :class="!isOpen && 'opacity-0 hidden'">Admin</span>
                    </a>
                    @endrole
                    <a href="{{ route('trash.index') }}" class="nav-link flex items-center px-4 py-3 text-gray-300 rounded-lg group">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        <span class="ml-3 transition-all duration-200" :class="!isOpen && 'opacity-0 hidden'">Trash</span>
                    </a>
                </nav>
            </aside>

            <!-- Mobile Menu Button (FAB) -->
            <div class="fab-menu lg:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="fab-button">
                    <svg class="w-8 h-8 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" x-show="!mobileMenuOpen" d="M4 6h16M4 12h16M4 18h16"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" x-show="mobileMenuOpen" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-full" x-transition:enter-end="opacity-100 transform translate-x-0" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform translate-x-0" x-transition:leave-end="opacity-0 transform translate-x-full" class="fixed inset-0 z-50 lg:hidden" style="display: none;">
                <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="mobileMenuOpen = false"></div>
                <nav class="mobile-menu absolute right-0 w-64 h-full py-6 px-4 bg-gray-900">
                    <div class="flex items-center justify-between mb-8">
                        <span class="text-2xl font-bold cyberpunk-gradient">LEONIX</span>
                        <button @click="mobileMenuOpen = false" class="p-2 rounded-lg border border-[#00FFC6]/20 hover:border-[#FF5AF7] hover:bg-[#FF5AF7]/10 transition-all duration-300">
                            <svg class="w-6 h-6 text-[#FF5AF7]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                    <div class="space-y-3">
                        <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-gray-300 rounded-lg border border-[#00FFC6]/20 hover:border-[#00FFC6] hover:bg-[#00FFC6]/10 transition-all duration-300 group">
                            <svg class="w-6 h-6 text-[#00FFC6] group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            <span class="ml-3 font-medium">Dashboard</span>
                        </a>
                        <a href="{{ route('files.index') }}" class="flex items-center px-4 py-3 text-gray-300 rounded-lg border border-[#00FFC6]/20 hover:border-[#00FFC6] hover:bg-[#00FFC6]/10 transition-all duration-300 group">
                            <svg class="w-6 h-6 text-[#00FFC6] group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z"></path></svg>
                            <span class="ml-3 font-medium">Berkas</span>
                        </a>
                        @role('admin')
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-gray-300 rounded-lg border border-[#00FFC6]/20 hover:border-[#00FFC6] hover:bg-[#00FFC6]/10 transition-all duration-300 group">
                            <svg class="w-6 h-6 text-[#00FFC6] group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            <span class="ml-3 font-medium">Admin</span>
                        </a>
                        @endrole
                        <a href="{{ route('trash.index') }}" class="flex items-center px-4 py-3 text-gray-300 rounded-lg border border-[#00FFC6]/20 hover:border-[#00FFC6] hover:bg-[#00FFC6]/10 transition-all duration-300 group">
                            <svg class="w-6 h-6 text-[#00FFC6] group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            <span class="ml-3 font-medium">Trash</span>
                        </a>
                        <!-- Profile Section in Mobile -->
                        <div class="mt-8 pt-6 border-t border-[#00FFC6]/10">
                            <div class="flex items-center px-4 py-3 rounded-lg border border-[#00FFC6]/20 bg-[#00FFC6]/5">
                                <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-[#00FFC6] to-[#FF5AF7] p-[2px]"><div class="w-full h-full rounded-lg bg-gray-900 flex items-center justify-center text-white font-medium">{{ substr(Auth::user()->name, 0, 1) }}</div></div>
                                <div class="ml-3"><div class="text-sm font-medium text-gray-300">{{ Auth::user()->name }}</div><div class="text-xs text-gray-500">{{ Auth::user()->email }}</div></div>
                            </div>
                            <div class="mt-3 space-y-2">
                                <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 text-sm text-gray-300 rounded-lg border border-[#00FFC6]/20 hover:border-[#00FFC6] hover:bg-[#00FFC6]/10 transition-all duration-300">Profile Settings</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left flex items-center px-4 py-2 text-sm text-red-400 rounded-lg border border-red-500/20 hover:border-red-500 hover:bg-red-500/10 transition-all duration-300">Sign Out</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="transition-all duration-300" :class="{ 'lg:pl-64': isOpen, 'lg:pl-20': !isOpen }">
                <!-- Top Navigation -->
                <nav class="sticky top-0 z-30 bg-[#0a0a16]/80 backdrop-blur-md border-b border-[#00FFC6]/10">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="flex items-center justify-between h-16">
                            <!-- Toggle Sidebar (Desktop) -->
                             <button @click="isOpen = !isOpen" class="hidden lg:flex items-center justify-center w-10 h-10 rounded-lg border border-[#00FFC6]/20 hover:border-[#00FFC6] hover:bg-[#00FFC6]/10 transition-all duration-300">
                                 <svg class="w-6 h-6 text-[#00FFC6]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                            </button>

                             <!-- Spacer to push profile to the right -->
                             <div class="flex-grow"></div>

                            <!-- Profile Menu -->
                             <div class="relative ml-3" x-data="{ open: false }">
                                 <button @click="open = !open" class="flex items-center space-x-3 px-4 py-2 rounded-lg border border-[#00FFC6]/20 hover:border-[#00FFC6] hover:bg-[#00FFC6]/10 transition-all duration-300">
                                     <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-[#00FFC6] to-[#FF5AF7] p-[2px]"><div class="w-full h-full rounded-lg bg-gray-900 flex items-center justify-center text-white font-medium">{{ substr(Auth::user()->name, 0, 1) }}</div></div>
                                     <div class="hidden sm:block"><div class="text-sm font-medium text-gray-300">{{ Auth::user()->name }}</div><div class="text-xs text-gray-500">{{ Auth::user()->email }}</div></div>
                                </button>
                                <!-- Profile Dropdown -->
                                 <div x-show="open" @click.away="Tutup" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute right-0 mt-3 w-48 rounded-lg shadow-lg py-1 bg-gray-900 ring-1 ring-[#00FFC6]/10 border border-[#00FFC6]/20" style="display: none;">
                                     <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-[#00FFC6]/10 hover:text-[#00FFC6] transition-colors">Profile Settings</a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                         <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-red-500/10 hover:text-red-300 transition-colors">Sign Out</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>

                <!-- Page Heading -->
                @if (isset($header))
                    <header class="bg-gray-900/50 shadow-lg shadow-black/20">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endif
                
                <main>
                    {{ $slot }}
                </main>
            </div>
        </div>

        @stack('modals')

        @stack('scripts')
        @vite(['resources/js/app.js'])
    </body>
</html>
