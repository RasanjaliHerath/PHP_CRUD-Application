<?php
include 'Model.php';
$obj = new Model();

/** Update Record */
if (isset($_POST['update'])) {
    $obj->updateRecord($_POST);
}

/** Insert Record */
if (isset($_POST['submit'])) {
    $obj->insertRecord($_POST);
}

/** Delete Record */
if (isset($_GET['deleteid'])) {
    $delid = $_GET['deleteid'];
    $obj->deleteRecord($delid);
}

/** Fetch record for update */
$myrecord = ['name' => '', 'email' => '', 'id' => ''];
$isEditing = false;
if (isset($_GET['editid'])) {
    $editid = $_GET['editid'];
    $myrecord = $obj->displayRecordById($editid);
    $isEditing = true; // Set the flag to true for update
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Operation in PHP OOPS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>
    <h2 class="text-center text-info">CRUD OPERATION IN PHP USING OOPS</h2>
    <div class="container">
        <!-- Success messages -->
        <?php
        if (isset($_GET['msg']) && $_GET['msg'] == 'ins') {
            echo '<div class="alert alert-primary" role="alert">Record inserted successfully!</div>';
        } elseif (isset($_GET['msg']) && $_GET['msg'] == 'ups') {
            echo '<div class="alert alert-primary" role="alert">Record updated successfully!</div>';
        } elseif (isset($_GET['msg']) && $_GET['msg'] == 'del') {
            echo '<div class="alert alert-primary" role="alert">Record deleted successfully!</div>';
        }
        ?>

        <!-- Conditional form for Insert and Update -->
        <form action="index.php" method="post">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" value="<?php echo $myrecord['name']; ?>" class="form-control" placeholder="Enter your Name" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="<?php echo $myrecord['email']; ?>" class="form-control" placeholder="Enter your Email" required>
            </div>
            
            <!-- Show hidden field only for update -->
            <?php if ($isEditing) { ?>
                <input type="hidden" name="hid" value="<?php echo $myrecord['id']; ?>">
                <input type="submit" name="update" value="Update" class="btn btn-info">
            <?php } else { ?>
                <input type="submit" name="submit" value="Insert" class="btn btn-success">
            <?php } ?>
        </form>

        <!-- Display records -->
        <h4 class="text-center text-danger">Display Records</h4>
        <table class="table table-bordered">
            <tr class="bg-primary text-center">
                <th>S.No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
            <?php
            $data = $obj->displayRecord();
            
            // Check if $data is not empty before iterating
            if (!empty($data)) {
                $sno = 1;
                foreach ($data as $value) {
                    ?>
                    <tr class="text-center">
                        <td><?php echo $sno++; ?></td>
                        <td><?php echo $value['name']; ?></td>
                        <td><?php echo $value['email']; ?></td>
                        <td>
                            <a href="index.php?editid=<?php echo $value['id']; ?>" class="btn btn-info">Edit</a>
                            <a href="index.php?deleteid=<?php echo $value['id']; ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                echo '<tr><td colspan="4" class="text-center">No records found</td></tr>';
            }
            ?>
        </table>

    </div>
</body>
</html>