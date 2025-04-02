$(document).ready(function () {
    $('#login-form').on('submit', function (e) {
        e.preventDefault();

        const email = $('#email').val().trim();
        const password = $('#password').val().trim();
        const role = $('#role').val();

        $.ajax({
            type: 'POST',
            url: 'controllers/login_controller.php',
            data: { email: email, password: password, role: role },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    $('#login-error').hide();
                    if(role === 'driver') {
                        window.location.href = 'driver_dashboard.php';
                    } else if (role ==='passenger'){
                        window.location.href = 'passenger_dashboard.php';
                    }
                } else {
                    $('#login-error').css('display', 'inline-block');
                }
            },
            error: function (xhr, status, error) {
                console.log("Error Status: " + status);  // Logs the status of the request (e.g., timeout, error)
                console.log("Error Message: " + error);  // Logs the error message
                console.log("Response: " + xhr.responseText);  // Logs the response from the server
                alert('Error connecting to the server. Please try again later.');
            }
        })
    })
})