<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boxing Ads</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        .bg-gradient-boxing {
            background: linear-gradient(to right, #8b0000, #cc0000, #e60000);
        }
        .text-outline {
            text-shadow: 0 0 10px rgba(0,0,0,0.7);
        }
    </style>
</head>

<body class="bg-black text-white">

    <section class="bg-gradient-boxing min-h-screen flex items-center justify-center">
        <div class="max-w-6xl w-full grid grid-cols-1 md:grid-cols-2 items-center px-6 py-10">

            <!-- TEXT SIDE -->
            <div class="space-y-4">
                <p class="uppercase tracking-widest text-sm text-gray-200">BET ON THE</p>

                <h1 class="text-6xl md:text-7xl font-extrabold leading-tight text-outline">
                    BOXING <br> ODDS
                </h1>

                <p class="text-lg font-semibold text-gray-200 tracking-wide">
                    Props, Futures and Betting Lines
                </p>

                <button class="
                    mt-6 px-6 py-3 bg-black/40 border border-white 
                    rounded-lg font-semibold text-white hover:bg-white hover:text-red-700 transition">
                    Learn More
                </button>
            </div>

            <!-- IMAGE SIDE -->
            <div class="flex justify-center md:justify-end">
                <img 
                    src="/images/boxing.png" 
                    alt="Boxer" 
                    class="w-[360px] md:w-[440px] drop-shadow-xl"
                >
            </div>

        </div>
    </section>

</body>
</html>


