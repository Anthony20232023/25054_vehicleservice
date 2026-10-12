// ==========================================
// VEHICLE SERVICE BOOKING SYSTEM
// ==========================================


// Get the form from service.html
const serviceForm = document.getElementById("serviceForm");


// Get all service checkboxes
const serviceCheckboxes = document.querySelectorAll(
    'input[name="services[]"]'
);


// Get the elements where we will display information
const selectedServices = document.getElementById("selectedServices");
const totalCost = document.getElementById("totalCost");


// ==========================================
// FUNCTION 1: CALCULATE SERVICE COST
// ==========================================

function calculateServiceCost() {

    let total = 0;
    let selected = [];


    // Go through every service checkbox
    serviceCheckboxes.forEach(function(service) {

        // Check whether the service was selected
        if (service.checked) {

            // Get the price stored in data-price
            let price = Number(service.dataset.price);

            // Add the price to the total
            total = total + price;

            // Add the service name to our list
            selected.push(service.value);
        }
    });


    // Display the selected services
    if (selected.length === 0) {

        selectedServices.innerHTML =
            "No services selected yet.";

    } else {

        selectedServices.innerHTML =
            "<strong>Selected Services:</strong><br>" +
            selected.join("<br>");
    }


    // Display the total cost
    totalCost.textContent = total.toLocaleString();
}


// ==========================================
// FUNCTION 2: VALIDATE SERVICE FORM
// ==========================================

function validateServiceForm() {

    // Get values from the form
    const customerName =
        document.getElementById("customerName").value.trim();

    const phone =
        document.getElementById("phone").value.trim();

    const email =
        document.getElementById("email").value.trim();

    const registration =
        document.getElementById("registration").value.trim();

    const vehicleType =
        document.getElementById("vehicleType").value;

    const vehicleModel =
        document.getElementById("vehicleModel").value.trim();

    const year =
        document.getElementById("year").value;

    const serviceDate =
        document.getElementById("serviceDate").value;


    // Check customer name
    if (customerName === "") {

        alert("Please enter your customer name.");

        return false;
    }


    // Check phone number
    const phonePattern = /^[0-9]{10}$/;

    if (!phonePattern.test(phone)) {

        alert("Phone number must contain exactly 10 digits.");

        return false;
    }


    // Check email
    const emailPattern =
        /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!emailPattern.test(email)) {

        alert("Please enter a valid email address.");

        return false;
    }


    // Check registration number
    if (registration === "") {

        alert("Please enter the vehicle registration number.");

        return false;
    }


    // Check vehicle type
    if (vehicleType === "") {

        alert("Please select a vehicle type.");

        return false;
    }


    // Check vehicle model
    if (vehicleModel === "") {

        alert("Please enter the vehicle model.");

        return false;
    }


    // Check year
    const currentYear = new Date().getFullYear();

    if (
        year === "" ||
        year < 1900 ||
        year > currentYear
    ) {

        alert(
            "Please enter a valid year of manufacture."
        );

        return false;
    }


    // Check service date
    if (serviceDate === "") {

        alert("Please select a preferred service date.");

        return false;
    }


    // Check whether at least one service was selected
    let serviceSelected = false;

    serviceCheckboxes.forEach(function(service) {

        if (service.checked) {

            serviceSelected = true;
        }
    });


    if (!serviceSelected) {

        alert("Please select at least one service.");

        return false;
    }


    // Everything is valid
    return true;
}


// ==========================================
// FUNCTION 3: CHECK VEHICLE AGE
// ==========================================

function checkVehicleAge() {

    const year =
        Number(document.getElementById("year").value);

    const currentYear = new Date().getFullYear();

    if (year > 0) {

        const vehicleAge = currentYear - year;

        if (vehicleAge > 15) {

            alert(
                "Notice: This vehicle is more than 15 years old."
            );
        }
    }
}


// ==========================================
// EVENT: SERVICE SELECTION
// ==========================================

serviceCheckboxes.forEach(function(service) {

    service.addEventListener(
        "change",
        calculateServiceCost
    );

});


// ==========================================
// EVENT: YEAR INPUT
// ==========================================

document.getElementById("year").addEventListener(
    "change",
    checkVehicleAge
);


// ==========================================
// EVENT: FORM SUBMISSION
// ==========================================

serviceForm.addEventListener(
    "submit",
    function(event) {

        // Stop submission temporarily
        event.preventDefault();


        // Validate the form
        const valid = validateServiceForm();


        // If everything is correct, submit the form
        if (valid) {

            serviceForm.submit();
        }
    }
);


// ==========================================
// INITIAL CALCULATION
// ==========================================

calculateServiceCost();
// ==========================================
// EVENT: PHONE NUMBER INPUT
// ==========================================

document.getElementById("phone").addEventListener(
    "input",
    function() {

        // Remove anything that is not a number
        this.value = this.value.replace(/\D/g, "");

        // Limit phone number to 10 digits
        if (this.value.length > 10) {
            this.value = this.value.substring(0, 10);
        }
    }
);