<x-app-layout>
    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="glass-card p-6 sm:p-8">
                <h2 class="text-3xl font-bold cyberpunk-gradient mb-8">Edit File</h2>

                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-500/10 text-red-300 border border-red-500/20 rounded-lg">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('files.update', $file) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <!-- File Name -->
                    <div class="mb-6">
                        <label for="name" class="block mb-2 text-sm font-medium text-cyan-400">File Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $file->name) }}"
                               class="w-full bg-gray-900/50 border-2 border-gray-700 text-white text-sm rounded-lg focus:ring-cyan-500 focus:border-cyan-500 block p-3">
                    </div>

                    <!-- Folder -->
                    <div class="mb-6">
                        <label for="folder_id" class="block mb-2 text-sm font-medium text-cyan-400">Move to Folder</label>
                        <select name="folder_id" id="folder_id"
                                class="w-full bg-gray-900/50 border-2 border-gray-700 text-white text-sm rounded-lg focus:ring-cyan-500 focus:border-cyan-500 block p-3">
                            <option value="">Root Directory</option>
                            @foreach ($folders as $folder)
                                <option value="{{ $folder->id }}" @if(old('folder_id', $file->folder_id) == $folder->id) selected @endif>
                                    {{ $folder->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <label for="description" class="block mb-2 text-sm font-medium text-cyan-400">Description</label>
                        <textarea name="description" id="description" rows="5"
                                  class="w-full bg-gray-900/50 border-2 border-gray-700 text-white text-sm rounded-lg focus:ring-cyan-500 focus:border-cyan-500 block p-3">{{ old('description', $file->description) }}</textarea>
                    </div>

                    <!-- Is Public -->
                    <div class="mb-8">
                        <label for="is_public" class="inline-flex items-center cursor-pointer">
                            <input type="hidden" name="is_public" value="0">
                            <input type="checkbox" name="is_public" id="is_public" value="1" @if(old('is_public', $file->is_public)) checked @endif
                                   class="sr-only peer">
                            <div class="relative w-11 h-6 bg-gray-700 rounded-full peer peer-focus:ring-4 peer-focus:ring-cyan-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-cyan-600"></div>
                            <span class="ms-3 text-sm font-medium text-gray-300">Make file public (sharable with a link)</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-end space-x-4">
                        <a href="{{ url()->previous() }}" class="px-6 py-3 rounded-lg bg-gray-700 hover:bg-gray-600 text-white font-bold transition-all">Cancel</a>
                        <button type="submit" class="btn-gradient px-6 py-3">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout> 