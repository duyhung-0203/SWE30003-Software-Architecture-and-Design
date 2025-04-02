// Initialize the map with a global view
const map = L.map('map').setView([21.0278, 105.8342], 13);

// Add OpenStreetMap tiles
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);

let routingControl = null;
let startMarker = null;
let endMarker = null;
let distanceKm = null;
let fare = null;
let startCoords = null;
let endCoords = null;

// Function to fetch coordinates for a given address using Nominatim
function getCoordinates(address) {
    const url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}`;
    return fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data && data.length > 0) {
                return { lat: parseFloat(data[0].lat), lon: parseFloat(data[0].lon) };
            } else {
                throw new Error('Address not found: ' + address);
            }
        });
}


// Main function to get user input, fetch coordinates, and display the route
function showRoute() {
    const startAddress = document.getElementById('start').value;
    const endAddress = document.getElementById('end').value;

    if (!startAddress || !endAddress) {
        alert("Please enter both start and end locations.");
        return;
    }

    // Geocode both addresses
    Promise.all([getCoordinates(startAddress), getCoordinates(endAddress)])
        .then(results => {
            [startCoords, endCoords] = results;

            // Remove old markers if they exist
            if (startMarker) {
                map.removeLayer(startMarker);
            }
            if (endMarker) {
                map.removeLayer(endMarker);
            }

            // Create new markers
            startMarker = L.marker([startCoords.lat, startCoords.lon]).addTo(map);
            endMarker = L.marker([endCoords.lat, endCoords.lon]).addTo(map);

            // Center the map on the new start location
            map.setView([startCoords.lat, startCoords.lon], 13);

            // Remove any previous route
            if (routingControl) {
                map.removeControl(routingControl);
                document.getElementById('bookButton').style.display = "none";
                document.getElementById('fare').style.display = "none";
            }

            // Create and add the new route
            routingControl = L.Routing.control({
                router: new L.Routing.osrmv1({
                    serviceUrl: 'https://router.project-osrm.org/route/v1'
                }),
                waypoints: [
                    L.latLng(startCoords.lat, startCoords.lon),
                    L.latLng(endCoords.lat, endCoords.lon)
                ],
                lineOptions: {
                    styles: [
                        { color: 'blue', opacity: 1, weight: 5 }
                    ]
                },
                routeWhileDragging: false
            }).on('routesfound', function (e) {
                // e.routes is an array of route objects
                var route = e.routes[0];
                // Distance in meters
                var distanceMeters = route.summary.totalDistance;
                distanceKm = distanceMeters / 1000;

                // Now apply your fare formula
                var baseFare = 2.50;
                var ratePerKm = 1.25;
                fare = baseFare + (ratePerKm * distanceKm);

                document.getElementById('fare').innerHTML = `${distanceKm.toFixed(2)}km - $${fare.toFixed(2)}`;
                document.getElementById('fare').style.display = "block";
                document.getElementById('bookButton').style.display = 'initial';

            }).addTo(map);

            // Show popups on the markers
            startMarker.bindPopup('Start point', {
                autoClose: false,
                closeOnClick: false,
                offset: [0, 0]
            }).openPopup();

            endMarker.bindPopup('End point', {
                autoClose: false,
                closeOnClick: false,
                offset: [0, 0]
            }).openPopup();
        })
        .catch(error => {
            alert(error.message);
        });
}

document.getElementById('bookButton').addEventListener('click', function (event) {
    // Optionally, prevent default form submission
    event.preventDefault();

    // Get the values of the start and end locations
    const startLocation = document.getElementById('start').value;
    const endLocation = document.getElementById('end').value;


    $.ajax({
        type: 'POST',
        url: 'controllers/book_request.php',
        data: {
            pickup: startLocation, dropoff: endLocation, startLat: startCoords.lat, startLon: startCoords.lon,
            endLat: endCoords.lat, endLon: endCoords.lon, fare: fare, distance: distanceKm
        },
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                document.getElementById('bookButton').outerHTML = `<h2>Finding driver ...</h2>`
                document.getElementById('update').style.display = "block";
            }
        },
        error: function (xhr, status, error) {
            console.log("Error Status: " + status);  // Logs the status of the request (e.g., timeout, error)
            console.log("Error Message: " + error);  // Logs the error message
            console.log("Response: " + xhr.responseText);  // Logs the response from the server
            alert('Error connecting to the server. Please try again later.');
        }
    });


});
