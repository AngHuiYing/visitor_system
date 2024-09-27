<?php

include_once('../VisitorController.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = $_POST['name'];
    $IC = $_POST['IC'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $visit_date = $_POST['visit_date'];
    $valid_days = $_POST['valid_days'];
    $owner_id = $_SESSION['owner_id'];

    $visitor_code = $name . '_' . date('Ymd', strtotime($visit_date));

    $status = 'approved';

    $visitorManagement = new VisitorController();

    if ($visitorManagement->ApplyVisitor($name, $IC, $email, $phone, $visitor_code, $visit_date, $status, $owner_id, $valid_days)) {
        $success = true;
    }else{
        $success = false;
    }


}


?>

<?php include('header.php')?>
<html>
    <?php if (!empty($success)): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Visitor has been applied successfully!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <div class="container">

        <form action="visitors.php" method="POST" >

            <div class="form-group">
                <label for="name">Visitor Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="IC">Visitor IC:</label>
                <input type="text" class="form-control" id="IC" name="IC" required>
            </div>

            <div class="form-group">
                <label for="email">Visitor Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="phone">Visitor Phone:</label>
                <input type="text" class="form-control" id="phone" name="phone" required>
            </div>

            <div class="form-group">
                <label for="visit_date">Visit Date:</label>
                <input type="date" class="form-control" id="visit_date" name="visit_date" required min="<?php echo date('Y-m-d'); ?>">
            </div>


            <div class="form-group">
                <label for="valid_days">QR Code Validity (in days):</label>
                <input type="number" class="form-control" id="valid_days" name="valid_days" required>
            </div>

            <input type="hidden" name="owner_id" value="<?php echo $_SESSION['owner_id']; ?>">

            <button type="submit" class="btn btn-primary">Apply Visitor</button>
        </form>
    </div>

</html>

<?php include('../footer.php')?>