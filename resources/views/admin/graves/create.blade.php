<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grave Registration Form</title>
    <!-- Load Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Load Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Optional: Set a nice background for the whole page */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
        }
    </style>
</head>
<body>
    <div class="container mx-auto p-6 md:p-10">
        <!-- Card Container for the Form -->
        <div class="bg-white shadow-xl rounded-lg p-6 md:p-8 max-w-2xl mx-auto">

            <h2 class="text-3xl font-extrabold mb-6 text-gray-900 border-b pb-3 flex items-center">
                <i class="fas fa-cross text-green-600 mr-3 text-xl"></i> Add New Grave
            </h2>

            <!-- Validation Error Message Block (Displayed for demonstration) 
            <div class="bg-red-50 border border-red-400 text-red-700 p-4 rounded-lg mb-6 shadow-sm">
                <div class="flex items-center">
                    <svg class="h-6 w-6 text-red-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <strong class="font-bold mr-1">Validation Error!</strong> Please correct the following issues:
                </div>
                <ul class="mt-2 list-disc pl-6 space-y-1 text-sm">
                    <li>The Date of Death field is required.</li>
                    <li>The Plot Number must be unique.</li>
                </ul>
            </div>-->

            <form action="{{ route('graves.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <!-- Grid for Name & IC Number -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Deceased Name</label>
                        <input type="text" name="name" id="name" placeholder="E.g., John Doe" required
                               class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 transition duration-150 ease-in-out p-2.5">
                    </div>

                    <div>
                        <label for="ic_number" class="block text-sm font-semibold text-gray-700 mb-1">IC Number (Optional)</label>
                        <input type="text" name="ic_number" id="ic_number" placeholder="E.g., 901231-14-5678"
                               class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 transition duration-150 ease-in-out p-2.5">
                    </div>
                </div>
                
                <!-- Grid for Date of Death & Plot Number -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="date_of_death" class="block text-sm font-semibold text-gray-700 mb-1">Date of Death <span class="text-red-500">*</span></label>
                        <input type="date" name="date_of_death" id="date_of_death" required
                               class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 transition duration-150 ease-in-out p-2.5">
                    </div>

                    <div>
                        <label for="plot_number" class="block text-sm font-semibold text-gray-700 mb-1">Plot Number <span class="text-red-500">*</span></label>
                        <input type="text" name="plot_number" id="plot_number" placeholder="E.g., A-102" required
                               class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 transition duration-150 ease-in-out p-2.5">
                    </div>
                </div>

                <!-- Section for GPS Coordinates -->
                <fieldset class="border border-gray-200 p-4 rounded-lg">
                    <legend class="text-sm font-bold text-gray-700 px-2">GPS Coordinates</legend>
                    <p class="text-xs text-gray-500 mb-4">Enter the exact latitude and longitude for precise location tracking.</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="gps_lat" class="block text-sm font-medium text-gray-700 mb-1">Latitude <span class="text-red-500">*</span></label>
                            <input type="text" name="gps_lat" id="gps_lat" placeholder="E.g., 3.14159" required
                                   class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 transition duration-150 ease-in-out p-2.5">
                        </div>

                        <div>
                            <label for="gps_lng" class="block text-sm font-medium text-gray-700 mb-1">Longitude <span class="text-red-500">*</span></label>
                            <input type="text" name="gps_lng" id="gps_lng" placeholder="E.g., 101.68457" required
                                   class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 transition duration-150 ease-in-out p-2.5">
                        </div>
                    </div>
                </fieldset>

                <!-- Picture URL 
                <div>
                    <label for="photo" class="block text-sm font-semibold text-gray-700 mb-1">Picture URL (Optional)</label>
                    <input type="text" name="photo" id="photo" placeholder="Link to the grave marker's picture"
                           class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 transition duration-150 ease-in-out p-2.5">
                </div>-->

                <!-- Picture Upload -->
                <div>
                    <label for="photo" class="block text-sm font-semibold text-gray-700 mb-1">Upload Picture (Optional)</label>
                    <input type="file" name="photo" id="photo" accept="image/*"
                        class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 transition duration-150 ease-in-out p-2.5">
                    <p class="mt-1 text-sm text-gray-500">Maximum file size: 1MB.</p>
                </div>
                
                <!-- Action Buttons -->
                <div class="pt-4 border-t border-gray-200 flex justify-end gap-3">
                <a href="{{ route('graves.index') }}" class="inline-flex items-center px-6 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-150 ease-in-out">
                        Cancel / Back
                    </a>
                    <button type="submit" class="inline-flex items-center px-6 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out">
                        <i class="fas fa-save mr-2"></i> Save Grave
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>