<nav class="px-3 mt-6 space-y-2">
    <a href="{{ route('admin.dashboard') }}" class="nav-link flex items-center px-4 py-3 text-gray-300 rounded-lg group {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <x-lucide-layout-dashboard class="w-6 h-6"/>
        <span class="ml-3 transition-all duration-200" :class="!isOpen && 'opacity-0 hidden'">Dashboard</span>
    </a>
    <a href="{{ route('admin.users.index') }}" class="nav-link flex items-center px-4 py-3 text-gray-300 rounded-lg group {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
        <x-lucide-users class="w-6 h-6"/>
        <span class="ml-3 transition-all duration-200" :class="!isOpen && 'opacity-0 hidden'">Manajemen Pengguna</span>
    </a>
    {{-- Add other admin links here in the future --}}
</nav> 