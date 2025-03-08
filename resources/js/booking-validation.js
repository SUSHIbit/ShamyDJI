const startDateInput = document.getElementById("start_date");
const endDateInput = document.getElementById("end_date");
const totalDaysSpan = document.getElementById("total_days");
const bookingForm = document.getElementById("booking_form");

// Fetch existing bookings for the camera
const bookings = JSON.parse(
    document.getElementById("camera_bookings").textContent
);
const bookedDates = [];

// Create array of all booked dates
bookings.forEach((booking) => {
    let currentDate = new Date(booking.start_date);
    const endDate = new Date(booking.end_date);

    while (currentDate <= endDate) {
        bookedDates.push(currentDate.toISOString().split("T")[0]);
        currentDate.setDate(currentDate.getDate() + 1);
    }
});

function isDateBooked(date) {
    return bookedDates.includes(date);
}

function calculateTotalDays() {
    if (startDateInput.value && endDateInput.value) {
        const start = new Date(startDateInput.value);
        const end = new Date(endDateInput.value);
        const diffTime = Math.abs(end - start);
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1; // Including start day

        totalDaysSpan.textContent = diffDays;
    }
}

function validateDates() {
    if (startDateInput.value && endDateInput.value) {
        const start = new Date(startDateInput.value);
        const end = new Date(endDateInput.value);

        // Check if any date in the range is booked
        let currentDate = new Date(start);
        while (currentDate <= end) {
            const dateString = currentDate.toISOString().split("T")[0];
            if (isDateBooked(dateString)) {
                alert(
                    "One or more dates in your selected range are already booked."
                );
                return false;
            }
            currentDate.setDate(currentDate.getDate() + 1);
        }
    }
    return true;
}

startDateInput.addEventListener("change", calculateTotalDays);
endDateInput.addEventListener("change", calculateTotalDays);

bookingForm.addEventListener("submit", function (e) {
    if (!validateDates()) {
        e.preventDefault();
    }
});
