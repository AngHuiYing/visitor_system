
<?php

include_once '../OwnerController.php';



if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $owner = $_POST['Owner'];
    $password = $_POST['password'];


    $ownerController = new OwnerController();

    $result = $ownerController->OwnerLogin($owner, $password);

    if($result){
        header('Location: dashboard.php');
        exit();
    }else{
        $error = "Invalid username or password";
    }
}

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
    <main class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
            <?php if (!empty($error)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
            <?php endif; ?>
                <form action="index.php" method="post" class="mt-5 p-4 border rounded bg-light">
                    <h2 class="text-center mb-4">Owner Login</h2>
                    <div class="form-group">
                        <label for="Owner">Owner Username</label>
                        <input type="text" name="Owner" id="Owner" class="form-control" placeholder="Enter owner username" required>
                    </div>
                    <div class="form-group">
                        <label for="Password">Password</label>
                        <input type="password" name="password" id="Password" class="form-control" placeholder="Enter Password" required>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
<?php include_once('../footer.php');?>
