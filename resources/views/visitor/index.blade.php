<x-app-layout>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Ensuring map container fills space and looks good */
        #map {
            height: 500px;
            width: 100%;
            border: 4px solid #10B981; /* Green border for visual appeal */
        }
        .container {
            font-family: 'Inter', sans-serif;
        }
        /* Custom styling for info window content */
        .info-window-content h3 {
            color: #10B981;
        }
    </style>

    <div class="container mx-auto p-6 bg-gray-50 min-h-screen">

        <!-- Header -->
        <h2 class="text-3xl font-extrabold mb-6 text-green-700 text-center border-b-2 border-green-200 pb-3 shadow-lg rounded-t-xl bg-white p-4">
        {{ __('messages.finder') }}
        </h2>

        <!-- Search Bar -->
        <div class="flex justify-center mb-10">
            <div class="flex w-full max-w-2xl shadow-xl rounded-xl">
                <input id="graveSearch" type="text" 
                       placeholder="{{ __('messages.search_placeholder') }}" 
                       class="flex-grow border-gray-300 rounded-l-xl px-5 py-3 text-gray-700 placeholder-gray-400 focus:ring-green-500 focus:border-green-500 transition duration-150 ease-in-out">
                <button onclick="searchGrave()" 
                        class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-r-xl transition duration-300 ease-in-out flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="https://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    {{ __('messages.search') }}
                </button>
            </div>
        </div>

        <!-- Map Container -->
        <div id="map" class="mb-8 rounded-xl shadow-2xl"></div>
       
    </div>

    <!-- Google Maps Integration Script -->
    <script>
    let map;
    let markers = [];
    let directionsService;
    let directionsRenderer;

    /**
     * Initializes the Google Map. This is called by the Google Maps API script callback.
     */
    function initMap() {
        console.log("Map initialized successfully.");
        
        // Default center (e.g., a known cemetery location)
        const defaultCenter = { lat: 2.9096780355990672, lng: 101.46449890505642 };

        map = new google.maps.Map(document.getElementById("map"), {
            zoom: 29,
            center: defaultCenter,
            mapTypeId: 'satellite', // Show a nice satellite view by default
            streetViewControl: false,
            mapTypeControl: true,
        });

        // Initialize Directions Service and Renderer
        directionsService = new google.maps.DirectionsService();
        directionsRenderer = new google.maps.DirectionsRenderer({
            map: map,
            polylineOptions: {
                strokeColor: '#FF0000', // Red path for directions
                strokeOpacity: 0.8,
                strokeWeight: 5
            }
        });
        
        // Optional: Add a placeholder marker for the default center
        new google.maps.Marker({
            position: defaultCenter,
            map: map,
            title: 'Cemetery Main Area',
            icon: {
                url: "http://maps.google.com/mapfiles/ms/icons/green-dot.png"
            }
        });
    }

    /**
     * Searches for graves based on the input query.
     */
    async function searchGrave() {
        const query = document.getElementById('graveSearch').value.trim();
        
        // Clear existing markers and directions
        markers.forEach(marker => marker.setMap(null));
        markers = [];
        directionsRenderer.setDirections({ routes: [] });

        if (!query) {
            alertUser('Please enter a name, plot, or date to search.', 'bg-yellow-100 border-yellow-400 text-yellow-700');
            return;
        }

        try {
            const response = await fetch(`{{ route('visitor.search') }}?query=${encodeURIComponent(query)}`);
            const data = await response.json();

            if (data.length === 0) {
                console.log("No results found for query:", query);
                alertUser('No graves found matching your search.', 'bg-yellow-100 border-yellow-400 text-yellow-700');
                return;
            }

            let bounds = new google.maps.LatLngBounds();

            // Add new markers to the map
            data.forEach(grave => {
                const lat = parseFloat(grave.gps_lat);
                const lng = parseFloat(grave.gps_lng);
                
                if (lat && lng) {
                    const position = { lat, lng };
                    
                    const marker = new google.maps.Marker({
                        position: position,
                        map: map,
                        title: grave.name,
                        animation: google.maps.Animation.DROP
                    });

                    const infoWindow = new google.maps.InfoWindow({
                        content: `
                            <div class="info-window-content px-2 pt-1 pb-2">
                                <h3 class="text-lg font-bold text-gray-800 mb-1">${grave.name ?? 'Unknown Name'}</h3>
                                <p class="text-sm text-gray-600">
                                    <strong>IC Number:</strong> ${grave.ic_number ?? 'N/A'}
                                </p>
                                <p class="text-sm text-gray-600">
                                    <strong>Date of Death:</strong> ${grave.date_of_death ?? 'Unknown date'}
                                </p>
                                <p class="text-sm text-gray-600">
                                    <strong>Plot:</strong> ${grave.plot_number ?? 'N/A'}
                                </p>
                                <div class="flex justify-center mt-2">
                                    <button onclick="getDirections(${lat}, ${lng})"
                                            class="bg-green-600 hover:bg-green-700 text-white font-medium px-3 py-1 text-sm rounded shadow focus:outline-none transition duration-150">
                                        🚗 Get Directions
                                    </button>
                                </div>
                            </div>
                        `,
                    });

                    marker.addListener("click", () => {
                        infoWindow.open(map, marker);
                    });

                    markers.push(marker);
                    bounds.extend(position);
                }
            });

            // Fit the map to show all markers
            if (markers.length > 0) {
                map.fitBounds(bounds);
            }
            
            alertUser(`Found ${data.length} grave record(s).`, 'bg-green-100 border-green-400 text-green-700');

        } catch (error) {
            console.error('Search failed:', error);
            alertUser('An error occurred while searching. Please try again.', 'bg-red-100 border-red-400 text-red-700');
        }
    }
    

    /**
     * Calculates walking directions from the user's current location to the grave.
     * @param {number} gps_lat - Destination latitude.
     * @param {number} gps_lng - Destination longitude.
     */
    function getDirections(gps_lat, gps_lng) {
        if (!gps_lat || !gps_lng || isNaN(gps_lat) || isNaN(gps_lng)) {
            alertUser('Invalid grave coordinates.', 'bg-red-100 border-red-400 text-red-700');
            return;
        }

        const destination = { lat: parseFloat(gps_lat), lng: parseFloat(gps_lng) };
        directionsRenderer.setDirections({ routes: [] }); // Clear previous directions

        // Get the user's current location
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                position => {
                    const userLocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude,
                    };

                    // 1. Display directions on the map
                    const request = {
                        origin: userLocation,
                        destination: destination,
                        travelMode: 'WALKING',
                    };

                    directionsService.route(request, (result, status) => {
                        if (status === 'OK') {
                            directionsRenderer.setDirections(result);
                            alertUser('Walking directions displayed on the map.', 'bg-blue-100 border-blue-400 text-blue-700');
                            
                            // Center map to show the route
                            map.fitBounds(result.routes[0].bounds);

                        } else {
                            alertUser('Directions request failed: ' + status, 'bg-red-100 border-red-400 text-red-700');
                        }
                    });
                    
                    // 2. Open Google Maps for external navigation (optional, but helpful)
                    // The correct format for Google Maps navigation URL
                    const navigationUrl = `https://www.google.com/maps/dir/${userLocation.lat},${userLocation.lng}/${gps_lat},${gps_lng}`;
                    window.open(navigationUrl, '_blank');

                },
                error => {
                    alertUser('Error getting your location: ' + error.message, 'bg-red-100 border-red-400 text-red-700');
                },
                // Geolocation options
                { enableHighAccuracy: true, timeout: 5000, maximumAge: 0 }
            );
        } else {
            alertUser('Geolocation is not supported by your browser. Cannot get directions.', 'bg-red-100 border-red-400 text-red-700');
        }
    }
    
    /**
     * Custom function to display transient messages instead of using alert().
     * This avoids blocking the iframe.
     */
    function alertUser(message, classes) {
        let msgBox = document.getElementById('messageBox');
        
        // If message box doesn't exist, create it
        if (!msgBox) {
            msgBox = document.createElement('div');
            msgBox.id = 'messageBox';
            msgBox.className = 'fixed top-4 left-1/2 transform -translate-x-1/2 p-3 rounded-lg border shadow-lg z-50 text-center transition-opacity duration-300 ease-out opacity-0 min-w-[300px]';
            document.body.appendChild(msgBox);
        }
        
        msgBox.className = `fixed top-4 left-1/2 transform -translate-x-1/2 p-3 rounded-lg border shadow-lg z-50 text-center transition-opacity duration-300 ease-out opacity-100 ${classes}`;
        msgBox.innerHTML = `<strong>Attention:</strong> ${message}`;
        
        // Fade out after 4 seconds
        setTimeout(() => {
            msgBox.classList.remove('opacity-100');
            msgBox.classList.add('opacity-0');
        }, 4000);
    }
    
    // Global function to be called by the Google Maps API
    window.initMap = initMap;
    
    </script>

    <!--
        CRITICAL FIX: The Google Maps API script tag MUST be here, after the initMap function is defined.
        The 'callback=initMap' parameter ensures the map starts only when the API is ready.
        NOTE: Replace the placeholder key 'AIzaSyCG0N76OUBZvuTEyKbeafBzHuXgai4OdSw' with a valid API key for production.
    -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCG0N76OUBZvuTEyKbeafBzHuXgai4OdSw&callback=initMap" async defer></script>
</x-app-layout>
