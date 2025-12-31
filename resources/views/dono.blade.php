<x-app-layout>
    <!-- 
        1. Tailwind CDN added back for immediate styling support.
        2. Ensure 'images/duit-now-logo.png' and 'images/qr-code.png' exist in your 'public' folder.
    -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Outer Wrapper: Light Gray background to make the white board pop -->
    <div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 font-sans">
        
        <!-- Main Sign Board Container -->
        <!-- White background with a bold Lime border -->
        <div class="relative w-full max-w-sm bg-white border-[6px] border-lime-500 rounded-3xl shadow-xl shadow-lime-200/50 overflow-hidden flex flex-col items-center text-center">
             
            <!-- Decorative Pattern (Subtle grid for texture) -->
            <div class="absolute inset-0 opacity-[0.03] bg-[url('https://www.transparenttextures.com/patterns/grid-me.png')] pointer-events-none"></div>

            <!-- Content Wrapper -->
            <div class="z-10 w-full flex flex-col items-center">

                <!-- Header Title -->
                <div class="mt-10 mb-6">
                    <h1 class="font-extrabold tracking-tighter drop-shadow-sm flex items-baseline justify-center">
                        <!-- Darker text for 'Infaq' to contrast against white -->
                        <span class="text-5xl text-gray-800">Infaq</span>
                        <span class="text-3xl text-lime-500 mx-0.5">n</span>
                        <!-- Vibrant Lime for 'Go' -->
                        <span class="text-5xl text-lime-500">Go</span>
                    </h1>
                </div>

                <!-- DuitNow Logo Box -->
                <!-- Added a light gray border since background is now white -->
                <div class="bg-white px-4 py-2 mb-4">
                    <img src="{{ asset('images/duit-now-logo.png') }}" 
                         alt="DuitNow Logo" 
                         class="h-12 w-auto object-contain">
                </div>

                <!-- QR Code Area -->
                <div class="bg-white p-1 mb-4 rounded-xl shadow-sm border border-gray-100">
                    <img src="{{ asset('images/qr-code.png') }}"
                         alt="Scan QR Code" 
                         class="w-56 h-55 object-cover border-4 border-lime-500 rounded-lg">
                </div>

                <!-- Mosque Name -->
                <div class="mb-8 px-4">
                    <h2 class="text-gray-800 font-bold text-xl tracking-widest uppercase">
                        Masjid Al-Hidayah
                    </h2>
                    <p class="text-lime-600 text-xs font-semibold tracking-wide uppercase mt-1">
                        Tabung Pembangunan
                    </p>
                </div>
            </div>

            <!-- Bottom Lime Strip -->
            <div class="z-10 w-full bg-lime-400 py-5 flex flex-col items-center justify-center mt-auto relative">
                <!-- Decorative jagged line top (CSS trick) or just a simple border -->
                <div class="absolute top-0 w-full border-t-4 border-lime-500"></div>

                <!-- Account Number -->
                <div class="flex items-center space-x-2 mb-1">
                    <span class="text-lime-950 font-black text-2xl tracking-widest drop-shadow-sm font-mono">
                        1005 5410 0001 0976
                    </span>
                </div>
                
                <!-- Bank Name -->
                <div class="flex items-center gap-2">
                    <span class="text-lime-900 font-bold text-sm tracking-wider uppercase">
                        Agro Bank Berhad
                    </span>
                </div>
            </div>

        </div>
    </div>

    <!-- Font Import (Poppins) & Custom Styles -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap');
        .font-sans { font-family: 'Poppins', sans-serif; }
    </style>
</x-app-layout>