<x-app-layout>
    <div class="max-w-2xl mx-auto py-12 px-6">

        <h1 class="text-2xl font-bold mb-6">Review Service: {{ $service->title }}</h1>

        <form action="{{ route('services.review.store', $service) }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="rating" class="block font-semibold mb-1">Rating (1 - 5)</label>
                <select name="rating" id="rating" class="input-select w-full" required>
                    <option value="">Select rating</option>
                    @for ($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
                @error('rating')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="comment" class="block font-semibold mb-1">Comment (optional)</label>
                <textarea name="comment" id="comment" rows="5" class="input-textarea w-full" placeholder="Write your review here...">{{ old('comment') }}</textarea>
                @error('comment')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex space-x-4">
                <button type="submit" class="btn-primary">Submit Review</button>
                <a href="{{ route('services.show', $service) }}" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</x-app-layout>
