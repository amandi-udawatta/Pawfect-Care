<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo ROOT?>/assets/css/tables.css">
</head>
<body>
<div class = "table-container">
<table>
        

        <thead>
            <tr>
                <th>Staff ID</th>
                <th>Name</th>
                <th>Address</th>
                <th>Contact No.</th>
                <th>NIC</th>
                <th>Email</th>
                <th>Qualifications</th>
                <th>Status</th>
                <th class="edit-action-buttons"></th>
                <th class="activate-action-buttons"></th>
                <th class="deactivate-action-buttons"></th>
            </tr>
        </thead>


        <tbody>
            <?php if (is_array($receptionists) && !empty($receptionists)): ?>
                <?php foreach ($receptionists as $rec): ?>
                    <tr key = "<?php echo $rec->id; ?>" >
                        <td><?= htmlspecialchars($rec->id); ?></td>
                        <td><?= htmlspecialchars($rec->name); ?></td>
                        <td><?= htmlspecialchars($rec->address); ?></td>
                        <td><?= htmlspecialchars($rec->contact); ?></td>
                        <td><?= htmlspecialchars($rec->nic); ?></td>
                        <td><?= htmlspecialchars($rec->email); ?></td>
                        <td><?= htmlspecialchars($rec->qualifications); ?></td>
                        <td><?= htmlspecialchars($rec->status); ?></td>
                        <td class="edit-action-buttons">
                            <button class="edit-icon"></button>
                        </td>
                        <td class="activate-action-buttons">
                            <button class="activate-button">Activate</button>
                        </td>
                        <td class="deactivate-action-buttons">
                            <button class="deactivate-button">Deactivate</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="20">No receptionists found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
        
       
    </table>
</body>
</html>
