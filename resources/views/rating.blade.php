<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rate Your Purchase</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">

    <div class="max-w-md mx-auto px-4 py-12">

        <div class="bg-white rounded-lg shadow-sm p-6 text-center">

            @if (session('success'))
                <div class="text-green-600 font-bold text-lg mb-4">✅ {{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="text-red-600 mb-4">{{ session('error') }}</div>
            @endif

            <h1 class="text-xl font-bold text-gray-900 mb-2">⭐ Rate Your Purchase!</h1>

            <p class="text-sm text-gray-600 mb-4">
                You bought: <strong>{{ $order->product->name }}</strong><br>
                from <strong>{{ $order->store->store_name }}</strong>
            </p>

            @if ($alreadyRated)
                <div class="text-center py-4">
                    <p class="text-lg font-bold text-yellow-600 mb-2">
                        @for ($i = 1; $i <= 5; $i++)
                            {{ $i <= $order->review->rating ? '★' : '☆' }}
                        @endfor
                    </p>
                    <p class="text-gray-600">You already rated this purchase!</p>
                    @if ($order->review->comment)
                        <p class="text-sm text-gray-500 mt-2">"{{ $order->review->comment }}"</p>
                    @endif
                </div>
            @else
                <form action="{{ route('rating.store', $order->rating_code) }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">How was your experience?</label>
                        <div class="flex justify-center gap-1 text-3xl" id="star-rating">
                            @for ($i = 1; $i <= 5; $i++)
                                <button type="button" data-value="{{ $i }}" class="star-btn text-gray-300 hover:text-yellow-400 focus:outline-none">★</button>
                            @endfor
                        </div>
                        <input type="hidden" name="rating" id="rating-input" required>
                        @error('rating') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Comment (optional)</label>
                        <textarea name="comment" rows="2" class="w-full border border-gray-300 rounded px-3 py-2 text-sm">{{ old('comment') }}</textarea>
                    </div>

                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded text-sm font-medium hover:bg-blue-700">
                        Submit Rating
                    </button>
                </form>
            @endif
        </div>

    </div>

    <script>
        // Star rating functionality
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

</body>
</html>