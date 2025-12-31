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

    <div class="container mx-auto p-6 md:p-10">
        <!-- Card Container for the Form -->
        <div class="bg-white shadow-xl rounded-lg p-6 md:p-8 max-w-2xl mx-auto">

            <h2 class="text-3xl font-extrabold mb-6 text-gray-900 border-b pb-3 flex items-center">
                <i class="fas fa-edit text-green-600 mr-3 text-xl"></i> Edit Grave Record
            </h2>

            @if ($errors->any())
                <div class="bg-red-50 border border-red-400 text-red-700 p-4 rounded-lg mb-6 shadow-sm" role="alert">
                    <div class="flex items-center">
                        <svg class="h-6 w-6 text-red-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <strong class="font-bold mr-1">Validation Error!</strong> Please correct the issues.
                    </div>
                    <ul class="mt-2 list-disc pl-6 space-y-1 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('graves.update', $grave->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Grid for Name & IC Number -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Deceased Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $grave->name) }}" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 transition duration-150 ease-in-out p-2.5">
                    </div>
                    <div>
                        <label for="ic_number" class="block text-sm font-semibold text-gray-700 mb-1">IC Number</label>
                        <input type="text" name="ic_number" id="ic_number" value="{{ old('ic_number', $grave->ic_number) }}" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 transition duration-150 ease-in-out p-2.5">
                    </div>
                </div>

                <!-- Grid for Date of Death & Plot Number -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="date_of_death" class="block text-sm font-semibold text-gray-700 mb-1">Date of Death <span class="text-red-500">*</span></label>
                        <input type="date" name="date_of_death" id="date_of_death" value="{{ old('date_of_death', $grave->date_of_death) }}" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 transition duration-150 ease-in-out p-2.5" required>
                    </div>
                    <div>
                        <label for="plot_number" class="block text-sm font-semibold text-gray-700 mb-1">Plot Number <span class="text-red-500">*</span></label>
                        <input type="text" name="plot_number" id="plot_number" value="{{ old('plot_number', $grave->plot_number) }}" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 transition duration-150 ease-in-out p-2.5" required>
                    </div>
                </div>

                <!-- Section for GPS Coordinates -->
                <fieldset class="border border-gray-200 p-4 rounded-lg">
                    <legend class="text-sm font-bold text-gray-700 px-2">GPS Coordinates</legend>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="gps_lat" class="block text-sm font-medium text-gray-700 mb-1">Latitude <span class="text-red-500">*</span></label>
                            <input type="text" name="gps_lat" id="gps_lat" value="{{ old('gps_lat', $grave->gps_lat) }}" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 transition duration-150 ease-in-out p-2.5" required>
                        </div>
                        <div>
                            <label for="gps_lng" class="block text-sm font-medium text-gray-700 mb-1">Longitude <span class="text-red-500">*</span></label>
                            <input type="text" name="gps_lng" id="gps_lng" value="{{ old('gps_lng', $grave->gps_lng) }}" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 transition duration-150 ease-in-out p-2.5" required>
                        </div>
                    </div>
                </fieldset>

                <!-- Picture Upload -->
                    <div>
                        <label for="photo" class="block text-sm font-semibold text-gray-700 mb-1">Upload Picture (Optional)</label>
                        <input type="file" name="photo" id="photo" accept="image/*"
                            class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 transition duration-150 ease-in-out p-2.5">
                        <p class="mt-1 text-sm text-gray-500">Maximum file size: 1MB.</p>
                        
                        @if ($grave->photo)
                            <div class="mt-4">
                                <p class="text-sm text-gray-700 font-medium">Current Photo:</p>
                                <img src="{{ asset('storage/' . $grave->photo) }}" alt="Current Grave Photo"
                                    class="w-32 h-32 object-cover rounded-lg border border-gray-300 shadow-sm mt-2">
                            </div>
                        @endif
                    </div>
                <!-- Action Buttons -->
                <div class="pt-4 border-t border-gray-200 flex justify-end gap-3">
                    <a href="{{ route('graves.index') }}" class="inline-flex items-center px-6 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-150 ease-in-out">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex items-center px-6 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out">
                        <i class="fas fa-save mr-2"></i> Update Grave
                    </button>
                </div>
            </form>
            <script>
                document.getElementById('edit-grave-form').addEventListener('submit', function (e) {
                    const photoInput = document.getElementById('photo');
                    const photoError = document.getElementById('photo-error');

                    // Reset error message
                    photoError.classList.add('hidden');

                    if (photoInput.files.length > 0) {
                        const fileSize = photoInput.files[0].size / 1024 / 1024; // Convert bytes to MB
                        if (fileSize > 2) {
                            e.preventDefault(); // Prevent form submission
                            photoError.classList.remove('hidden'); // Show error message
                        }
                    }
                });
            </script>
        </div>
    </div>
</x-app-layout>

