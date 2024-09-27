<?php

include_once('../OwnerController.php');

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $unit = $_POST['unit'];

    $ownerController = new OwnerController();
    if ($ownerController->OwnerRegistation($name, $email, $password, $unit, $phone)) {
        $success = true;
    }else{
        $success = false;
    }
}

?>
<?php include_once('header.php'); ?>

<html>
<div class="container mt-5">
        <?php if (!empty($success)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Your registration was successful.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>
        <h2 class="mb-4">Owner Registration</h2>
        <form action="OwnerRegistration.php" method="POST">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input type="tel" class="form-control" id="phone" name="phone" required>
            </div>
            <div class="form-group">
                <label for="unit">Unit:</label>
                <input type="text" class="form-control" id="unit" name="unit" required>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>
<?php include_once('../footer.php'); ?>
</html>