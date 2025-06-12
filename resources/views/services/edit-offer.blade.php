<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-2xl font-bold mb-6">Edit Service</h2>

                    <form method="POST" action="{{ route('services.update', $service) }}">
                        @csrf
                        @method('PUT')

                        <!-- Title -->
                        <div class="mb-4">
                            <x-input-label for="title" :value="__('Service Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" 
                                         name="title" :value="old('title', $service->title)" required />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Category -->
                        <div class="mb-4">
                            <x-input-label for="category_id" :value="__('Category')" />
                            <select id="category_id" name="category_id" required
                                class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                        {{ $service->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" rows="4" required
                                class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700">{{ old('description', $service->description) }}</textarea>
                        </div>

                        <!-- Delivery Time -->
                        <div class="mb-4">
                            <x-input-label for="delivery_time" :value="__('Delivery Time (days)')" />
                            <x-text-input id="delivery_time" class="block mt-1 w-full" type="number"
                                         name="delivery_time" min="1" :value="old('delivery_time', $service->delivery_time)" required />
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            <label class="inline-flex items-center">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" name="is_active" value="1" 
                                    {{ $service->is_active ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <span class="ml-2">Active Service</span>
                            </label>
                        </div>

                        <div class="flex justify-end gap-2 mt-6">
                            <a href="{{ route('services.index') }}" class="btn-secondary">
                                Cancel
                            </a>
                            <button type="submit" class="btn-primary">
                                Update Service
                            </button>
                        </div>
                    </form>

                    <!-- Delete Form -->
                    <div class="mt-8 pt-4 border-t">
                        <form method="POST" action="{{ route('services.destroy', $service) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-danger" 
                                onclick="return confirm('Are you sure you want to delete this service?')">
                                Delete Service
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>