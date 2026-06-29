<x-guest-layout title="Rate Your Purchase">
    <div class="max-w-md mx-auto">

        <div class="bg-white rounded-lg shadow-sm p-6 text-center">

            @if (session('success'))
                <div class="flex items-center justify-center p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50">
                    <span>✅ {{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="flex items-center justify-center p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50">
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <h1 class="text-2xl font-bold text-gray-900 mb-3">⭐ Rate Your Purchase!</h1>

            <p class="text-gray-600 mb-6">
                You bought: <strong>{{ $order->product->name }}</strong><br>
                from <strong>{{ $order->store->store_name }}</strong>
            </p>

            @if ($alreadyRated)
                <div class="py-4">
                    <p class="text-3xl mb-2">
                        @for ($i = 1; $i <= 5; $i++)
                            {{ $i <= $order->review->rating ? '★' : '☆' }}
                        @endfor
                    </p>
                    <p class="text-gray-600 font-medium">You already rated this purchase!</p>
                    @if ($order->review->comment)
                        <p class="text-sm text-gray-500 mt-2 italic">"{{ $order->review->comment }}"</p>
                    @endif
                </div>
            @else
                <form action="{{ route('rating.store', $order->rating_code) }}" method="POST">
                    @csrf

                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 mb-3">How was your experience?</label>
                        <div class="flex justify-center gap-1 text-4xl" id="star-rating">
                            @for ($i = 1; $i <= 5; $i++)
                                <button type="button" data-value="{{ $i }}" class="star-btn text-gray-300 hover:text-yellow-400 focus:outline-none transition">★</button>
                            @endfor
                        </div>
                        <input type="hidden" name="rating" id="rating-input" required>
                        @error('rating') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Comment (optional)</label>
                        <textarea name="comment" rows="3"
                            class="block w-full p-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Tell others about your experience...">{{ old('comment') }}</textarea>
                    </div>

                    <button type="submit"
                        class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-3">
                        Submit Rating
                    </button>
                </form>
            @endif
        </div>

    </div>

    <script>
        const stars = document.querySelectorAll('.star-btn');
        const ratingInput = document.getElementById('rating-input');

        stars.forEach(star => {
            star.addEventListener('click', function() {
                const value = this.dataset.value;
                ratingInput.value = value;
                stars.forEach(s => {
                    if (s.dataset.value <= value) {
                        s.classList.add('text-yellow-400');
                        s.classList.remove('text-gray-300');
                    } else {
                        s.classList.add('text-gray-300');
                        s.classList.remove('text-yellow-400');
                    }
                });
            });
        });
    </script>
</x-guest-layout>