$(document).ready(function () {
    $('#register-form').on('submit', function (e) {
        e.preventDefault();

        const name = $('#name').val().trim();
        const email = $('#email').val().trim();
        let password = $('#password').val();
        let cpassword = $('#confirm_password').val();
        const role = $('#role').val();
        let has_license = 0;

        const namePattern = /^[A-Za-z\s'-]+$/;
        isValid = true;

        if (!namePattern.test(name)) {
            isValid = false;
            $('#nameError').css('display', 'block');
        }

        if (password !== cpassword) {
            isValid = false;
            $('#pwMatchError').css('display', 'block');
            console.log
        }

        if (role === 'driver') {
            has_license = $('#has_license').is(':checked') ? 1 : 0
            
            if (has_license != 1) {
                isValid = false;
                $('#license').css('display', 'block');
            }
        }

        if (isValid) {
            $.ajax({
                type: 'POST',
                url: 'controllers/register_controller.php',
                data: { name: name, email: email, password: password, role: role},
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        $('.form-error').hide();
                        window.location.href = 'index.php';
                    } else {
                        $('.form-error').hide();
                        $('#emailExisted').css('display', 'block');
                    }
                },
                error: function (xhr, status, error) {
                    console.log("Error Status: " + status);  // Logs the status of the request (e.g., timeout, error)
                    console.log("Error Message: " + error);  // Logs the error message
                    console.log("Response: " + xhr.responseText);  // Logs the response from the server
                    alert('Error connecting to the server. Please try again later.');
                }
            })
        }


    })
})