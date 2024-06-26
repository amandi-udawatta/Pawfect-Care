<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vaccination History</title>
    <?php $activePage = 'petdetails';?>
    <script src="<?php echo ROOT ?>/assets/js/validatehistory.js"></script>
    <link rel="stylesheet" href="<?php echo ROOT?>/assets/css/panelheader.css">
    <style>
    /* Adjust font size for vaccine names and serial numbers */
    #vaccines label {
        font-size: 14px;
        /* Adjust the font size as needed */
    }

    /* Additional styling for checkboxes and labels */
    #vaccines input[type="checkbox"] {
        display: inline-block;
        margin-right: 5px;
        /* Adjust spacing between checkbox and label */
    }

    #vaccines label {
        display: inline-block;
        vertical-align: middle;
        /* Align label vertically with checkbox */
    }
    </style>
</head>

<!--body onload="setInitialDate()"-->

<body>


    <?php include '../app/views/components/panel-header-bar/hiuser.php'; ?>
    <div style="margin-top: 80px; ">
        <?php include '../app/views/components/dashboard-compo/medicalstaffsidebar.php'; ?>
        <div style="margin-left: 230px; margin-top:130px">
            <div class="panel-header">
                <button class="add-new-button">Add New</button>

            <?php if (!empty($vaccinationhistory)): ?>
            <?php $petId = $vaccinationhistory[0]->pet_id; ?>
            <script>var petId = <?= json_encode($petId); ?>;</script>

            <?php endif; ?>

                <div class="search-bar">
                    <input type="text" id="search"
                        placeholder="Search by vaccine name,serial number or veterinarian...">
                    <button class="search-button">Search</button>
                </div>

                </header>
            </div>
            <?php include '../app/views/components/tables/vaccinationhistoryupdatetable.php'; ?>
        </div>
    </div>

</body>

</html>

<!-- Add vaccination Modal -->

<div class="modal-form" id="add-modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h1>Add Vaccination</h1>
        <div class="form-container">
            <form id="add-vaccination-form" action="<?php echo ROOT ?>/Medicalstaff/VaccinationHistory/add"
                method="post">
                <div class="column">
                    <!--input type="hidden" name="pet_id" value="<!?php echo htmlspecialchars($vaccinationhistory->pet_id); ?>"-->
                    <!--label for="date">Date:</label>
                    <input type="date" id="date" name="date" required><br-->

                    <label for="patient no">Patient No:</label>
                    <!--input type="text" class="disabled-field" id="patient_no" name="patient_no" value="<?php echo htmlspecialchars($data['appointments']); ?>"readonly><br-->
                    <input type="text" id="patient_no" name="patient_no">
                    <div id="error-patient_no" class="error-message"></div>

                    <label for="weight">Weight:</label>
                    <input type="text" id="weight" name="weight"><br>
                    <div id="error-weight" class="error-message"></div>

                    <label for="temperature">Temperature:</label>
                    <input type="text" id="temperature" name="temperature"><br>
                    <div id="error-temperature" class="error-message"></div>

                    <!--label for="vaccine name">Vaccine Name:</label>
                    <select id="vaccine_name" name="vaccine_name">
                    <option value="">Select Vaccine</option>
                        <!?php foreach ($vaccinenames as $vaccine): ?>
                            <option value="<!?= htmlspecialchars($vaccine->vaccine_name) ?>">
                            <!?= htmlspecialchars($vaccine->vaccine_name) ?>
                            </option>
                        <!?php endforeach; ?>
                        <option value="new_vaccinename">+ New Vaccine Name</option>
                    </select>
                    <div id="error-vaccine_name" class="error-message"></div-->

                    <label for="vaccines">Vaccines:</label>
                    <div id="vaccines">
                        <?php foreach ($vaccines as $vaccine): ?>
                        <div class="vaccine-checkbox">
                            <input type="checkbox" id="vaccine_<?= htmlspecialchars($vaccine->id) ?>" name="vaccines[]"
                                value="<?= htmlspecialchars($vaccine->id) ?>">
                            <label for="vaccine_<?= htmlspecialchars($vaccine->id) ?>">
                                <?= htmlspecialchars($vaccine->name) ?> - <?= htmlspecialchars($vaccine->serial_no) ?>
                            </label>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <!--div id="error-vaccines" class="error-message"></div-->

                </div>
                <div class="column">

                    <!--label for="serial no">Serial No:</label>
                    <select id="serial_no" name="serial_no">
                    <option value="">Select Prescription</option>
                        <!?php foreach ($serialno as $no): ?>
                            <option value="<!?= htmlspecialchars($no->serial_no) ?>">
                            <!?= htmlspecialchars($no->serial_no) ?>
                            </option>
                        <!?php endforeach; ?>
                        <option value="new_serialno">+ New Serial No</option>
                    </select>
                    <div id="error-serial_no" class="error-message"></div-->

                    <!--label for="administered by">Administered By:</label>
                    <input type="text" id="administered_by" name="vet_name"><br>
                    <div id="error-administered_by" class="error-message"></div-->

                    <label for="due date">Next Due Date:</label>
                    <input type="date" id="due_date" name="due_date"><br>
                    <div id="error-due_date" class="error-message"></div>

                    <label for="remarks">Remarks:</label>
                    <textarea id="remarks" name="remarks" rows="4" style="border-radius: 10px;"></textarea><br>

                </div>
                <div class="flex-container">
                    <button type="submit" id="add-vaccination-button">Add Vaccination</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Update vaccinationhistory Modal -->
<div class="modal-form" id="update-modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h1>Update Vaccination History</h1>
        <div id="updatevaccinationhistory" class="form-container">

        </div>
    </div>
</div>

<!-- Delete vaccinationhistory Modal 
    <div class="modal-form" id="delete-modal">
        <div class="modal-content-delete">
            <h1>Delete vaccinatioon History</h1>
            <p>Are you sure you want to delete?</p>
            <div class="flex-container">
                <button class="reject">No</button>
                <a id="delete-vaccinationhistory" href=""><button class="delete-button">Delete</button></a>
            </div>
            
        </div>
    </div>-->


<script>




            $(document).ready(function(){
                //$('.search-button').on('click', function(){ 
                $('#search').on('keyup', function(){
                    //var searchTerm = $('#search').val(); 
                    var searchTerm = $(this).val();
                    
                    console.log(petId)
                    $.ajax({
                        url: "<?php echo ROOT ?>/Medicalstaff/VaccinationHistory/search",
                        type: "POST",
                        data: { search: searchTerm,petId:petId }, 
                        success: function(data) {
                            $('tbody').html(data);
                        }
                    
                    });
                });

                // to update when filtered by search
                $('body').on('click', '.edit-icon', function(){
                    var Id = $(this).closest('tr').attr('key');
                    openUpdateModal(Id,petId);
                });
            });






// Get the modal elements
var addModal = document.getElementById("add-modal");
var updateModal = document.getElementById("update-modal");
//var deleteModal = document.getElementById("delete-modal");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// Function to open add form modal
function openAddModal() {
    addModal.style.display = "block";
}

function openUpdateModal(Id, petId) {
    console.log(Id);
    console.log(petId);

    updateModal.style.display = "block";

    // Fetch data and update the modal content
    $.get(`<?php echo ROOT?>/Medicalstaff/VaccinationHistory/viewVaccinationHistory/${Id}/${petId}`, function(data) {
        // Update the content with the fetched data
        $("#updatevaccinationhistory").html(data);
    });

    setTimeout(updateFormInit, 1000);

    // to close the modal
    span.onclick = function() {
        updateModal.style.display = "none";
    }
}

/*function setInitialDate() {
   
    var currentDate = new Date().toISOString().split('T')[0];
    document.getElementById('date').value = currentDate;
}
// Call setInitialDate() when the form is loaded
window.addEventListener('DOMContentLoaded', setInitialDate);*/

// Event listener for add button click
document.querySelector('.add-new-button').addEventListener('click', function() {
    openAddModal();
});



/*document.getElementById('vaccine_name').addEventListener('change', function () {
        if (this.value === 'new_vaccinename') {
            var input = document.createElement('input');
            input.type = 'text';
            input.name = 'vaccine_name';
            input.placeholder = 'Enter new vaccine name';
            this.parentNode.replaceChild(input, this);
        }
    });

    document.getElementById('serial_no').addEventListener('change', function () {
        if (this.value === 'new_serialno') {
            var input = document.createElement('input');
            input.type = 'text';
            input.name = 'serial_no';
            input.placeholder = 'Enter new serial no';
            this.parentNode.replaceChild(input, this);
        }
    });*/


// Event listeners for update buttons click
document.querySelectorAll('.edit-icon').forEach(function(button) {
    button.addEventListener('click', function() {
        var Id = this.getAttribute('id');
        var petId = this.getAttribute('pet-id');
        openUpdateModal(Id, petId);
    });
});

// Event listeners for delete buttons click
/**document.querySelectorAll('.delete-icon').forEach(function (button) {
    button.addEventListener('click', function () {
        var id = this.parentElement.parentElement.getAttribute('key');
        console.log(id)
        openDeleteModal(id);
    });
});**/

// Close modals when the close button is clicked
var closeButtons = document.querySelectorAll('.close');

// Close modals when the no button is clicked
/**var noButtons = document.querySelectorAll('.reject');**/

closeButtons.forEach(function(button) {
    button.addEventListener('click', function() {
        addModal.style.display = "none";
        updateModal.style.display = "none";

    });
});
/*noButtons.forEach(function(button) {
    button.addEventListener('click', function() {
        deleteModal.style.display = "none";

    });
});***/

// Attach event listeners for validation on input for add form

document.getElementById('patient_no').addEventListener('input', validatePatientNo);
document.getElementById('weight').addEventListener('focus', validatePatientNo);
document.getElementById('temperature').addEventListener('focus', validateWeight);
document.getElementById('vaccines').addEventListener('focus', validateTemperature);
//document.getElementById('serial_no').addEventListener('focus', validateVaccineName);
//document.getElementById('administered_by').addEventListener('focus', validateSerialNo);
//document.getElementById('due_date').addEventListener('focus', validateVaccines);
document.getElementById('due_date').addEventListener('input', validateDueDate);
document.getElementById('remarks').addEventListener('focus', validateDueDate);

function validateAddForm() {
    var isValid = true;

    isValid = validatePatientNo() && isValid;
    isValid = validateWeight() && isValid;
    isValid = validateTemperature() && isValid;
    //isValid = validateVaccines() && isValid;
    isValid = validateDueDate() && isValid;


    if (!isValid) {
        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            html: "Please correct the errors before submitting.",
        });
        return false;
    }
    return true;
}
document.getElementById("add-vaccination-form").addEventListener('submit', function(event) {

    if (!validateAddForm()) {
        event.preventDefault();
    } else {
        addModal.style.display = "none";
    }
});

function updateFormInit() {

    //document.getElementById('update-vaccine_name').addEventListener('input', validateUpdateVaccineName);
    //document.getElementById('update-serial_no').addEventListener('input', validateUpdateSerialNo);
    document.getElementById('update-weight').addEventListener('input', validateUpdateWeight);
    document.getElementById('update-temperature').addEventListener('input', validateUpdateTemperature);
    //document.getElementById('update-due_date').addEventListener('input', validateUpdateDueDate);

    document.getElementById("updated-form").addEventListener('submit', function(event) {
        //console.log("insideee");
        if (!validateUpdateForm()) {
            event.preventDefault();
        } else {
            addModal.style.display = "none";
        }

    });
}

function validateUpdateForm() {
    var isValid = true;

    //isValid = validateUpdateVaccineName() && isValid;
    //isValid = validateUpdateSerialNo() && isValid;
    isValid = validateUpdateWeight() && isValid;
    isValid = validateUpdateTemperature() && isValid;
    //isValid = validateUpdateDueDate() && isValid;


    if (!isValid) {
        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            html: "Please correct the errors before submitting.",
        });
        return false;
    }
    return true;
}

//sweeetalert for validation SUCCESS and ERROR
/*window.onload = function() {
    <?php if (isset($_SESSION['flash'])): ?>
    const flash = <?php echo json_encode($_SESSION['flash']); ?>;
    if (flash.success) {
        Swal.fire('Success', flash.success, 'success');
    } else if (flash.error) {
        Swal.fire('Error', flash.error, 'error');
    }
    <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>
};
*/

window.onload = function() {
    <?php if (isset($_SESSION['flash'])): ?>
    const flash = <?php echo json_encode($_SESSION['flash']); ?>;
    if (flash.success) {
        Swal.fire('Success', flash.success, 'success');
    } else if (flash.error) {
        Swal.fire('Error', flash.error, 'error');
    }
    <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>
};


</script>
</body>

</html>