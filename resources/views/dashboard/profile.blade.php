<x-app-layout>
    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="glass-card p-6 sm:p-8">
                <!-- Header -->
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h1 class="text-3xl font-bold cyberpunk-gradient">Profile Settings</h1>
                        <p class="mt-2 text-gray-400">Manage your account information and preferences.</p>
                    </div>
                    <a href="{{ route('dashboard') }}" 
                       class="px-4 py-2 rounded-lg bg-gray-700/70 hover:bg-gray-600/70 border border-gray-600/90 text-white font-bold transition-all">
                        Back to Dashboard
                    </a>
                </div>

                @if(session('success'))
                    <div class="mb-6 p-4 rounded-lg bg-green-600/20 border border-green-500/30 text-green-400">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Profile Form -->
                <form method="POST" action="{{ route('dashboard.profile.update') }}" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    <!-- Name -->
                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-cyan-400">Name</label>
                        <input type="text" 
                               name="name" 
                               id="name" 
                               value="{{ old('name', $user->name) }}" 
                               required
                               class="w-full bg-gray-900/50 border-2 border-gray-700 text-white text-sm rounded-lg focus:ring-cyan-500 focus:border-cyan-500 block p-3">
                        @error('name')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-cyan-400">Email</label>
                        <input type="email" 
                               name="email" 
                               id="email" 
                               value="{{ old('email', $user->email) }}" 
                               required
                               class="w-full bg-gray-900/50 border-2 border-gray-700 text-white text-sm rounded-lg focus:ring-cyan-500 focus:border-cyan-500 block p-3">
                        @error('email')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Account Info -->
                    <div class="bg-gray-800/50 rounded-lg p-6 border border-gray-700/50">
                        <h3 class="text-lg font-medium text-white mb-4">Account Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-400">Member Since</label>
                                <p class="text-white">{{ $user->created_at->format('M d, Y') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-400">Email Verified</label>
                                <p class="text-white">
                                    @if($user->email_verified_at)
                                        <span class="text-green-400">✓ Verified</span>
                                    @else
                                        <span class="text-yellow-400">✗ Not Verified</span>
                                    @endif
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-400">Role</label>
                                <p class="text-white">{{ $user->roles->first() ? ucfirst($user->roles->first()->name) : 'User' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-400">Total Files</label>
                                <p class="text-white">{{ $user->files->count() }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-400">Storage Used</label>
                                <p class="text-white">{{ $user->formatted_storage_used }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-400">Total Folders</label>
                                <p class="text-white">{{ $user->folders->count() }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit" 
                                class="px-6 py-2 rounded-lg bg-gradient-to-r from-[#00FFC6] to-[#FF5AF7] text-gray-900 font-bold hover:shadow-lg hover:shadow-[#00FFC6]/20 transition-all duration-300 transform hover:scale-105">
                            Update Profile
                        </button>
                    </div>
                </form>

                <!-- Password Change Section -->
                <div class="mt-12 p-6 border border-cyan-500/20 rounded-lg bg-cyan-500/5">
                    <h3 class="text-lg font-medium text-cyan-400 mb-4">Change Password</h3>
                    <p class="text-gray-400 mb-4">
                        Use the default Laravel profile page to change your password securely.
                    </p>
                    <a href="{{ route('profile.edit') }}" 
                       class="px-4 py-2 rounded-lg bg-cyan-600 hover:bg-cyan-700 text-white font-bold transition-all duration-300">
                        Change Password
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 