<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-2xl font-bold mb-6">
                        {{ isset($service) ? 'Edit Service' : 'Create New Service' }}
                    </h2>

                    <form method="POST" 
                          action="{{ isset($service) ? route('services.update', $service) : route('services.store') }}">
                        @csrf
                        @if(isset($service))
                            @method('PUT')
                        @endif

                        <!-- Title -->
                        <div class="mb-4">
                            <x-input-label for="title" :value="__('Service Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" 
                                         name="title" :value="old('title', $service->title ?? '')" required />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Category Dropdown -->
                        <div class="mb-4">
                            <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Category
                            </label>
                            <select id="category_id" name="category_id" required
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md dark:bg-gray-700 dark:border-gray-600">
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                        {{ old('category_id', $service->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" rows="4" required
                                class="block mt-1 w-full rounded-md border-gray-300 shadow-sm 
                                      focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700">{{ old('description', $service->description ?? '') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Delivery Time -->
                        <div class="mb-4">
                            <label for="delivery_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Delivery Time (days)
                            </label>
                            <input type="number" id="delivery_time" name="delivery_time" min="1" required
                                value="{{ old('delivery_time', $service->delivery_time ?? 1) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
                            @error('delivery_time')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status (for edit only) -->
                        @if(isset($service))
                        <div class="mb-4">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="is_active" value="1" 
                                    {{ old('is_active', $service->is_active) ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <span class="ml-2">Active Service</span>
                            </label>
                        </div>
                        @endif

                        <div class="flex justify-end mt-6">
                            <a href="{{ route('services.index') }}" class="btn-secondary mr-2">
                                Cancel
                            </a>
                            <button type="submit" class="btn-primary">
                                {{ isset($service) ? 'Update Service' : 'Create Service' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>