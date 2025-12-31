<x-app-layout>
    <!-- NOTE: Tailwind CSS is loaded via script tag below for the editor environment -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Configure Tailwind to use a clean color palette for the design -->
    <style>
        /* Optional: Add a custom font */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
            /* Light grey/off-white background for the page */
            background-color: #f7f7f7; 
        }
    </style>

    <div class="container mx-auto px-4 py-10 sm:px-6 lg:px-8">
        
        <!-- 🌳 Title Section with Enhanced Styling -->
        <header class="text-center mb-12">
        <h1 class="text-5xl font-extrabold text-gray-800 tracking-tight mb-2">
            <span class="text-green-600">{{ __('messages.title') }}</span>
        </h1>
        <p class="text-xl text-gray-500 font-light">
            {{ __('messages.description') }}
        </p>
    </header>

        <!-- 🔍 Search and Action Bar (Modernized) -->
        <div class="flex flex-col sm:flex-row justify-between items-center mb-10 p-4 bg-white shadow-xl rounded-2xl border border-gray-100">
            <!-- Search Input -->
            <form action="{{ route('graves.index') }}" method="GET" class="w-full sm:w-3/4 mb-6 sm:mb-0">
        <div class="flex items-center space-x-4">
            <input type="text" name="search" placeholder=" {{ __('messages.search_placeholder') }}" 
                value="{{ request('search') }}" 
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-green-500 focus:border-green-500">
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                {{ __('messages.search') }}
            </button>
        </div>
    </form>

            <!-- Add Button -->
            <a href="{{ route('graves.create') }}"
               class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-3 rounded-xl shadow-md transition duration-300 ease-in-out flex items-center justify-center">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                {{ __('messages.add_new_record') }}
            </a>
        </div>

        <!-- 📜 Grave Records Table (Card-like Design - Cleaned) -->
<div class="bg-white p-6 rounded-2xl shadow-2xl border border-gray-100">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.Name') }}</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.icnumber') }}</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.dod') }}</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.plot') }}</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.photo') }}</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse ($graves as $grave)
                <tr class="{{ request('search') && (stripos($grave->name, request('search')) !== false || stripos($grave->ic_number, request('search')) !== false || stripos($grave->plot_number, request('search')) !== false) ? 'bg-yellow-100' : '' }}">
                    <td class="px-6 py-3 text-sm text-gray-600">
                        {{ $grave->name }}
                    </td>
                    <td class="px-6 py-3 text-sm text-gray-600">
                        {{ $grave->ic_number }}
                    </td>
                    <td class="px-6 py-3 text-sm text-gray-600">
                        {{ $grave->date_of_death }}
                    </td>
                    <td class="px-6 py-3 text-sm text-gray-600">
                        {{ $grave->plot_number }}
                    </td>
                    <!-- Photo -->
                    <td class="px-6 py-3">
                        @if ($grave->photo)
                            <div class="relative group">
                                <img src="/storage/{{ $grave->photo }}" alt="Grave Photo"
                                    class="w-20 h-20 object-cover rounded-lg border border-gray-300 shadow-md transition-transform duration-300 transform group-hover:scale-105 group-hover:shadow-lg">
                                <div class="absolute inset-0 bg-black bg-opacity-30 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-lg flex items-center justify-center">
                                    <span class="text-white text-sm font-medium">View Photo</span>
                                </div>
                            </div>
                        @else
                            <span class="text-sm text-gray-500 italic">No Photo Available</span>
                        @endif
                    </td>
                    <!-- Actions -->
                    <td class="px-6 py-3 text-sm font-medium text-center">
                        <div class="flex justify-center space-x-4">
                            <a href="{{ route('graves.edit', $grave->id) }}"
                                class="text-blue-600 hover:text-blue-900 transition duration-150 ease-in-out">
                                Edit
                            </a>
                            <form action="{{ route('graves.destroy', $grave->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('Are you sure you want to delete this grave record?')"
                                        class="text-red-600 hover:text-red-900 transition duration-150 ease-in-out">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-3 text-center text-sm text-gray-500 italic">
                        No graves found matching your search.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

    </div>

</x-app-layout>