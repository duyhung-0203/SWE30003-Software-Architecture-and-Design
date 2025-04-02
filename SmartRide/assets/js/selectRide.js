document.querySelectorAll('.action-btn').forEach(button => {
    button.addEventListener('click', function () {
        const rideID = this.getAttribute('data-rideid');
        const driverID = this.getAttribute('data-driverid');
        const pickup = this.getAttribute('data-pickup');
        const dropoff = this.getAttribute('data-dropoff');

        $.ajax({
            type: 'POST',
            url: 'controllers/ride_controller.php',
            data: { rideID: rideID, driverID: driverID, pickup: pickup, dropoff: dropoff },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    window.location.href = 'tracking_driver.php';
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
});
