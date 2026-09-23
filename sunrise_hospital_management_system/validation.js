document.addEventListener('DOMContentLoaded', () => {
    const bookingForm = document.getElementById('appointmentForm');
    
    // Task 3: Set Minimum Date to Today to Prevent Past Selection
    const dateInput = document.getElementById('appointment_date');
    if (dateInput) {
        const today = new Date().toISOString().split('T')[0];
        dateInput.setAttribute('min', today);
    }

    if (bookingForm) {
        bookingForm.addEventListener('submit', function (e) {
            let isValid = true;
            
            // Clear previous errors
            document.querySelectorAll('.error-msg').forEach(el => el.textContent = '');

            // 1. Patient Name Validation
            const name = document.getElementById('patient_name').value.trim();
            if (name === '') {
                showError('nameError', 'Patient Name is required.');
                isValid = false;
            }

            // 2. National ID Validation
            const nationalId = document.getElementById('national_id').value.trim();
            if (nationalId === '') {
                showError('idError', 'National ID Number is required.');
                isValid = false;
            }

            // 3. Gender Validation
            const gender = document.getElementById('gender').value;
            if (gender === '') {
                showError('genderError', 'Please select a gender.');
                isValid = false;
            }

            // 4. Phone Number Validation (Kenyan / Standard format check)
            const phone = document.getElementById('phone_number').value.trim();
            const phoneRegex = /^(?:\+254|0)[17]\d{8}$/;
            if (phone === '') {
                showError('phoneError', 'Phone Number is required.');
                isValid = false;
            } else if (!phoneRegex.test(phone)) {
                showError('phoneError', 'Enter a valid phone number (e.g., 0712345678 or +254712345678).');
                isValid = false;
            }

            // 5. Email Address Format Validation
            const email = document.getElementById('email_address').value.trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (email === '') {
                showError('emailError', 'Email Address is required.');
                isValid = false;
            } else if (!emailRegex.test(email)) {
                showError('emailError', 'Enter a valid email address.');
                isValid = false;
            }

            // 6. Department Selection Validation
            const department = document.getElementById('department').value;
            if (department === '') {
                showError('deptError', 'Please select a department.');
                isValid = false;
            }

            // 7. Appointment Date Validation
            const selectedDateStr = document.getElementById('appointment_date').value;
            if (selectedDateStr === '') {
                showError('dateError', 'Appointment Date is required.');
                isValid = false;
            } else {
                const selectedDate = new Date(selectedDateStr);
                const todayDate = new Date();
                todayDate.setHours(0, 0, 0, 0);

                if (selectedDate < todayDate) {
                    showError('dateError', 'Appointment date cannot be in the past.');
                    isValid = false;
                }
            }

            if (!isValid) {
                e.preventDefault(); // Stop form submission
            }
        });
    }

    function showError(elementId, message) {
        const errorElement = document.getElementById(elementId);
        if (errorElement) {
            errorElement.textContent = message;
        }
    }
});