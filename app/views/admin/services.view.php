<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services</title>
</head>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<link rel="stylesheet" href="<?php echo ROOT?>/assets/css/tables.css">
<link rel="stylesheet" href="<?php echo ROOT?>/assets/css/panelheader.css">

<?php $activePage = 'services';?>




<body>
    <?php include '../app/views/components/panel-header-bar/hiadmin.php'; ?>
    <div style="margin-top: 80px; ">
        <?php include '../app/views/components/dashboard-compo/adminsidebar.php'; ?>
        <div style="margin-left: 230px; margin-top:130px">
            <div class="panel-header">
                <button class="add-new-button">Add New</button>
                <div class="search-bar">
                    <input type="text" id="search" placeholder="Search services...">
                    <button class="search-button">Search</button>
                </div>

                </header>
            </div>
            <div class="table-container">

                <table>
                    <thead>
                        <tr>
                            <th>Service</th>
                            <th>Description</th>
                            <th class="edit-action-buttons"></th>
                            <th class="delete-action-buttons"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (is_array($services) && !empty($services)): ?>
                        <?php foreach ($services as $service) : ?>
                        <tr key="<?php echo $service->id; ?>">
                            <td><b><?= htmlspecialchars($service->service); ?></b></td>
                            <td><?= htmlspecialchars($service->description); ?></td>
                            <td class="edit-action-buttons">
                                <button class="edit-icon"></button>
                            </td>
                            <td class="delete-action-buttons">
                                <button class="delete-icon"></button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="10">No services found.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- </body>
</html>

Add Service Modal -->

    <div class="modal-form" id="add-modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h1>Add Service</h1>
            <div class="form-container">
                <form id="add-service-form" action="<?php echo ROOT?>/Admin/Services/add" method="post">

                    <label for="service">Service:</label>
                    <input type="text" id="service" name="service" required><br>

                    <label for="description">Description:</label>
                    <textarea id="description" name="description" style="border-radius: 10px;" rows="4"
                        required></textarea>

                    <div class="flex-container">
                        <button type="submit" id="add-service-button">Add Service</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <!-- Update Service Modal -->
    <div class="modal-form" id="update-modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h1>Update Service</h1>
            <div id="updateservice" class="form-container">

            </div>
        </div>
    </div>

    <!-- Delete Service Modal -->
    <div class="modal-form" id="delete-modal">
        <div class="modal-content-delete">
            <h1>Delete Service</h1>
            <p>Are you sure you want to delete this service?</p>
            <div class="flex-container">
                <button class="reject">No</button>
                <a id="delete-service" href=""><button class="delete-button">Delete</button></a>
            </div>

        </div>
    </div>


    <script>
    $(document).ready(function() {
        $('#search').on('keyup', function() {
            var searchTerm = $(this).val();
            $.ajax({
                url: "<?php echo ROOT ?>/Admin/Services/search",
                type: "POST",
                data: {
                    search: searchTerm
                },
                success: function(data) {
                    $('tbody').html(data);
                }
            });
        });

        // to update when filtered bu search
        $('body').on('click', '.edit-icon', function() {
            var id = $(this).closest('tr').attr('key');
            openUpdateModal(id);
        });

        // to delete when filtered bu search
        $('body').on('click', '.delete-icon', function() {
            var id = $(this).closest('tr').attr('key');
            openDeleteModal(id);
        });
    });

    // Get the modal elements
    var addModal = document.getElementById("add-modal");
    var updateModal = document.getElementById("update-modal");
    var deleteModal = document.getElementById("delete-modal");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // Function to open add form modal
    function openAddModal() {
        addModal.style.display = "block";
    }

    function openUpdateModal(id) {
        updateModal.style.display = "block";
        $.get(`<?php echo ROOT?>/admin/Services/viewService/${id}`, function(data) {
            // Update the modal content with the fetched data
            $("#updateservice").html(data);
        });
        span.onclick = function() {
            modal.style.display = "none";
        }

    }

    function openDeleteModal(id) {
        console.log(id);
        deleteModal.style.display = "block";
        document.getElementById("delete-service").href = `<?php echo ROOT?>/admin/Services/delete/${id}`;
        span.onclick = function() {
            modal.style.display = "none";
        }

    }

    // Event listener for add button click
    document.querySelector('.add-new-button').addEventListener('click', function() {
        openAddModal();
    });

    // to update when filtered bu search
    $('body').on('click', '.edit-icon', function() {
        var id = $(this).closest('tr').attr('key');
        console.log(id)

        openUpdateModal(id);
    });

    // Event listeners for delete buttons click
    document.querySelectorAll('.delete-icon').forEach(function(button) {
        button.addEventListener('click', function() {
            var id = this.parentElement.parentElement.getAttribute('key');
            console.log(id)
            openDeleteModal(id);
        });
    });

    // Close modals when the close button is clicked
    var closeButtons = document.querySelectorAll('.close');

    // Close modals when the no button is clicked
    var noButtons = document.querySelectorAll('.reject');

    closeButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            addModal.style.display = "none";
            updateModal.style.display = "none";
            deleteModal.style.display = "none";

        });
    });
    noButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            deleteModal.style.display = "none";

        });
    });

    document.getElementById("add-service-form").addEventListener('submit', function(event) {

        addModal.style.display = "none";
    });

    //sweeetalert for validation SUCCESS and ERROR
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