// Initialize the map with a global view
const map = L.map('map').setView([21.0278, 105.8342], 13);

// Add OpenStreetMap tiles
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);

let routingControl = null;
let driverRoutingControl = null;
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
function showRoute(startAddress, endAddress) {
    if (!startAddress || !endAddress) {
        alert("Please enter both start and end locations.");
        return;
    }

    // Geocode both addresses
    Promise.all([getCoordinates(startAddress), getCoordinates(endAddress)])
        .then(results => {
            [startCoords, endCoords] = results;

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
                document.getElementById('status').style.display = 'block';
                document.getElementById('updateButton').style.display = 'block';

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

            setTimeout(driverRoute, 2000);
        })
        .catch(error => {
            alert(error.message);
        });
}


function driverRoute() {
    // Hard-code a driver location (for example, coordinates in Hanoi)
    const driverCoords = { lat: 21.028511, lon: 105.804817 };

    // Create a marker for the driver (optional: customize the icon)
    const driverMarker = L.marker([driverCoords.lat, driverCoords.lon]).addTo(map);
    driverMarker.bindPopup('Driver Location').openPopup();

    // Use Leaflet Routing Machine to compute a driving route from driverCoords to startCoords
    driverRoutingControl = L.Routing.control({
        waypoints: [
            L.latLng(driverCoords.lat, driverCoords.lon),
            L.latLng(startCoords.lat, startCoords.lon)
        ],
        lineOptions: {
            styles: [{ color: 'red', weight: 5, opacity: 0.8 }]
        },
        // Hide the default routing markers if you already have your own markers
        createMarker: function (i, wp, nWps) { return null; },
        // Optionally disable the dragging of the route
        routeWhileDragging: false
    }).addTo(map);
}

function showMap(pickup, dropoff) {
    console.log("Pickup:", pickup, "Dropoff:", dropoff);
    document.getElementById('route').style.display = "none";
    showRoute(pickup, dropoff);
}

document.getElementById('updateButton').addEventListener('click', function (e) {
    e.preventDefault();

    let rideID = this.getAttribute('rideID');

    $.ajax({
        type: 'POST',
        url: 'controllers/check_status.php',
        data: { rideID: rideID },
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                console.log("hello");
                document.getElementById('status').innerHTML = `<h2>Go to Payment</h2>`;

            }
        },
        error: function (xhr, status, error) {
            console.log("Error Status: " + status);  // Logs the status of the request (e.g., timeout, error)
            console.log("Error Message: " + error);  // Logs the error message
            console.log("Response: " + xhr.responseText);  // Logs the response from the server
            alert('Error connecting to the server. Please try again later.');
        }

    })


});