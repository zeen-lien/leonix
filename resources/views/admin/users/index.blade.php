<x-admin-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success & Error Messages -->
            @if(session('success'))
                <div class="mb-4 bg-green-500/20 border border-green-500/50 text-green-300 px-4 py-3 rounded-lg" role="alert">
                    <span class="font-bold">Success!</span>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
             @if(session('error'))
                <div class="mb-4 bg-red-500/20 border border-red-500/50 text-red-300 px-4 py-3 rounded-lg" role="alert">
                    <span class="font-bold">Error!</span>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-gray-800/50 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-bold text-white mb-4">Daftar Pengguna</h3>

                    <!-- User Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-700">
                            <thead class="bg-gray-800">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Nama</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Email</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Peran</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Bergabung</th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Aksi</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-gray-900/50 divide-y divide-gray-700">
                                @foreach($users as $user)
                                <tr class="{{ !$user->is_active ? 'bg-gray-900/80 opacity-60' : '' }}">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">
                                        {{ $user->name }}
                                        @if(!$user->is_active)
                                            <span class="ml-2 text-xs font-semibold rounded-full bg-yellow-600 text-yellow-100 px-2 py-1">Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $user->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @foreach($user->getRoleNames() as $role)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $role === 'admin' ? 'bg-indigo-500 text-indigo-100' : 'bg-sky-500 text-sky-100' }}">
                                                {{ $role }}
                                            </span>
                                        @endforeach
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">{{ $user->created_at->format('d M Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium flex justify-end items-center space-x-4">
                                        <a href="{{ route('admin.users.edit', $user) }}" class="text-indigo-400 hover:text-indigo-300" title="Edit">
                                            <x-lucide-file-pen-line class="w-5 h-5"/>
                                        </a>
                                        <form action="{{ route('admin.users.toggleStatus', $user) }}" method="POST" class="leading-none">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="{{ $user->is_active ? 'text-yellow-500 hover:text-yellow-400' : 'text-green-500 hover:text-green-400' }}" title="{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                @if($user->is_active)
                                                    <x-lucide-user-x class="w-5 h-5"/>
                                                @else
                                                    <x-lucide-user-check class="w-5 h-5"/>
                                                @endif
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');" class="leading-none">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-400" title="Hapus">
                                                <x-lucide-trash-2 class="w-5 h-5"/>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout> 