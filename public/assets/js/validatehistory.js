function validatePatientNo() {
    var patientNo = document.getElementById('patient_no').value;
    if (!patientNo) {
        document.getElementById('error-patient_no').textContent = "* Patient No is required.";
        return false;
    } else {
        document.getElementById('error-patient_no').textContent = "";
        return true;
    }
}

function validateWeight() {
    var Weight = document.getElementById('weight').value;
    if (!Weight) {
        document.getElementById('error-weight').textContent = "* Weight is required.";
        return false;
    } else {
        document.getElementById('error-weight').textContent = "";
        return true;
    }
}

function validateTemperature() {
    var Temperature = document.getElementById('temperature').value;
    if (!Temperature) {
        document.getElementById('error-temperature').textContent = "* Temperature is required.";
        return false;
    } else {
        document.getElementById('error-temperature').textContent = "";
        return true;
    }
}

function validateVaccineName() {
    var vaccineName = document.getElementById('vaccine_name').value;
    if (!vaccineName) {
        document.getElementById('error-vaccine_name').textContent = "* Vaccine Name is required.";
        return false;
    } else {
        document.getElementById('error-vaccine_name').textContent = "";
        return true;
    }
}

function validateSerialNo() {
    var serialNo = document.getElementById('serial_no').value;
    if (!serialNo) {
        document.getElementById('error-serial_no').textContent = "* Serial No is required.";
        return false;
    } else {
        document.getElementById('error-serial_no').textContent = "";
        return true;
    }
}
function validateAdministeredBy() {
    var administeredBy = document.getElementById('administered_by').value;
    if (!administeredBy) {
        document.getElementById('error-administered_by').textContent = "* Administered By is required.";
        return false;
    } else {
        document.getElementById('error-administered_by').textContent = "";
        return true;
    }

}

function validateDueDate() {
    var DueDate = document.getElementById('due_date').value;
    if (!DueDate) {
        document.getElementById('error-due_date').textContent = "* Next Due Date is required.";
        return false;
    } else {
        document.getElementById('error-due_date').textContent = "";
        return true;
    }
    
}

//validate update form

function validateUpdateWeight() {
    var weight = document.getElementById('update-weight').value;
    if (!weight) {
        document.getElementById('error-update-weight').textContent = "* Weight is required.";
        return false;
    } else {
        document.getElementById('error-update-weight').textContent = "";
        return true;
    }
    
}

function validateUpdateTemperature() {
    var Temperature = document.getElementById('update-temperature').value;
    if (!Temperature) {
        document.getElementById('error-update-temperature').textContent = "* Temperature is required.";
        return false;
    } else {
        document.getElementById('error-update-temperature').textContent = "";
        return true;
    }
}

/*function validateUpdateVaccineName() {
    var vaccineName = document.getElementById('update-vaccine_name').value;
    if (!vaccineName) {
        document.getElementById('error-update-vaccine_name').textContent = "* Vaccine is required.";
        return false;
    } else {
        document.getElementById('error-update-vaccine_name').textContent = "";
        return true;
    }
}

function validateUpdateSerialNo() {
    var serialNo = document.getElementById('update-serial_no').value;
    if (!serialNo) {
        document.getElementById('error-update-serial_no').textContent = "* Serial No is required.";
        return false;
    } else {
        document.getElementById('error-update-serial_no').textContent = "";
        return true;
    }
}*/

function validateUpdateDueDate() {
    var DueDate = document.getElementById('update-due_date').value;
    if (!DueDate) {
        document.getElementById('error-update-due_date').textContent = "* Next Due Date is required.";
        return false;
    } else {
        document.getElementById('error-update-due_date').textContent = "";
        return true;
    }
    
}


 //if (!contact.match(/^[0-9]{10}$/))   "* Contact number must be 10 digits."
 //(!nic.match(/^[0-9]{9}[vVxX]$|^([0-9]{12})$/))    "* NIC format is not valid."
 //(!email.match(/^\S+@\S+\.\S+$/))   "* Email format is not valid."
 //(!password.match(/^(?=.*[\W]).{6,}$/))    "* Password must be at least 6 characters long and contain at least one symbol."
