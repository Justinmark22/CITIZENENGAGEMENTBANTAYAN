<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boxing Ads</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-100">

    <section class="min-h-screen py-16 px-6">
        
        <!-- Page Header -->
        <div class="max-w-5xl mx-auto mb-12 text-center">
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900">🥊 Boxing Promotions & Ads</h1>
            <p class="text-gray-600 mt-2 text-sm md:text-base">
                Hardcoded sample ads — latest boxing promos, training schedules, and events.
            </p>
        </div>

        <!-- Ads Grid -->
        <div class="max-w-6xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

            <!-- AD ITEM 1 -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition transform hover:-translate-y-1" x-data="{ open:false }">

                <img src="https://images.unsplash.com/photo-1590086782792-42dd2350140c" class="w-full h-52 object-cover">

                <div class="p-5">
                    <h2 class="text-xl font-bold text-gray-900">Ultimate Boxing Training Promo</h2>
                    <p class="text-gray-600 mt-1 text-sm">
                        Get 50% off on all boxing classes this month! Beginners welcome.
                    </p>

                    <button 
                        @click="open = true"
                        class="mt-4 inline-block px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm shadow transition"
                    >
                        View Details
                    </button>
                </div>

                <!-- Modal -->
                <div x-show="open" x-transition class="fixed inset-0 bg-black/60 backdrop-blur flex items-center justify-center z-50 p-4">
                    <div class="bg-white rounded-xl shadow-xl max-w-lg w-full p-6 relative">
                        <button @click="open = false" class="absolute top-3 right-3 text-gray-500 hover:text-black">✖</button>

                        <h2 class="text-2xl font-bold mb-3">Ultimate Boxing Training Promo</h2>

                        <img src="https://images.unsplash.com/photo-1590086782792-42dd2350140c" class="w-full h-60 object-cover rounded-md shadow mb-4">

                        <p class="text-gray-700 text-sm leading-relaxed">
                            Join our 30-day boxing program with full-access to equipment and daily coaching sessions.  
                            Promo runs until end of the month.
                        </p>

                        <div class="mt-6 flex justify-end gap-3">
                            <a href="#" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg shadow hover:bg-blue-700">Learn More</a>
                            <button @click="open = false" class="px-4 py-2 bg-gray-200 text-gray-800 text-sm rounded-lg hover:bg-gray-300">Close</button>
                        </div>
                    </div>
                </div>

            </div>

            <!-- AD ITEM 2 -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition transform hover:-translate-y-1" x-data="{ open:false }">

                <img src="https://images.unsplash.com/photo-1605296867304-46d5465a13f1" class="w-full h-52 object-cover">

                <div class="p-5">
                    <h2 class="text-xl font-bold text-gray-900">Boxing Gloves SALE</h2>
                    <p class="text-gray-600 mt-1 text-sm">
                        Premium gloves 30% off — limited stocks only!
                    </p>

                    <button 
                        @click="open = true"
                        class="mt-4 inline-block px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm shadow transition"
                    >
                        View Details
                    </button>
                </div>

                <!-- Modal -->
                <div x-show="open" x-transition class="fixed inset-0 bg-black/60 backdrop-blur flex items-center justify-center z-50 p-4">
                    <div class="bg-white rounded-xl shadow-xl max-w-lg w-full p-6 relative">
                        <button @click="open = false" class="absolute top-3 right-3 text-gray-500 hover:text-black">✖</button>

                        <h2 class="text-2xl font-bold mb-3">Boxing Gloves SALE</h2>

                        <img src="https://images.unsplash.com/photo-1605296867304-46d5465a13f1" class="w-full h-60 object-cover rounded-md shadow mb-4">

                        <p class="text-gray-700 text-sm leading-relaxed">
                            Grab high-quality boxing gloves at a discounted price! Perfect for sparring, training, or casual fitness.
                        </p>

                        <div class="mt-6 flex justify-end gap-3">
                            <a href="#" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg shadow hover:bg-blue-700">Buy Now</a>
                            <button @click="open = false" class="px-4 py-2 bg-gray-200 text-gray-800 text-sm rounded-lg hover:bg-gray-300">Close</button>
                        </div>
                    </div>
                </div>

            </div>

            <!-- AD ITEM 3 -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition transform hover:-translate-y-1" x-data="{ open:false }">

                <img src="https://images.unsplash.com/photo-1517430816045-df4b7de11d1d" class="w-full h-52 object-cover">

                <div class="p-5">
                    <h2 class="text-xl font-bold text-gray-900">Local Boxing Event • This Weekend</h2>
                    <p class="text-gray-600 mt-1 text-sm">
                        Watch fighters from Cebu compete! Tickets available now.
                    </p>

                    <button 
                        @click="open = true"
                        class="mt-4 inline-block px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm shadow transition"
                    >
                        View Details
                    </button>
                </div>

                <!-- Modal -->
                <div x-show="open" x-transition class="fixed inset-0 bg-black/60 backdrop-blur flex items-center justify-center z-50 p-4">
                    <div class="bg-white rounded-xl shadow-xl max-w-lg w-full p-6 relative">
                        <button @click="open = false" class="absolute top-3 right-3 text-gray-500 hover:text-black">✖</button>

                        <h2 class="text-2xl font-bold mb-3">Local Boxing Event</h2>

                        <img src="https://images.unsplash.com/photo-1517430816045-df4b7de11d1d" class="w-full h-60 object-cover rounded-md shadow mb-4">

                        <p class="text-gray-700 text-sm leading-relaxed">
                            Don’t miss the most awaited local boxing showdown happening this Saturday!  
                            Gates open at 6 PM. VIP seats still available.
                        </p>

                        <div class="mt-6 flex justify-end gap-3">
                            <a href="#" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg shadow hover:bg-blue-700">Get Tickets</a>
                            <button @click="open = false" class="px-4 py-2 bg-gray-200 text-gray-800 text-sm rounded-lg hover:bg-gray-300">Close</button>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </section>

</body>
</html>

