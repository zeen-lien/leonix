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
        @vite(['resources/css/app.css', 'resources/js/app.js'])
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
                @include('layouts.admin-navigation')
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
                        @include('layouts.admin-navigation')

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
                    <header class="bg-gray-800/50 shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                <!-- Page Content -->
                <main>
                    {{ $slot }}
                </main>
            </div>
        </div>

        @stack('scripts')
    </body>
</html>
