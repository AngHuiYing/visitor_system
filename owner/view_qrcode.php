<?php

include_once('../db.php');
include_once('header.php');
include_once('../VisitorController.php');

$visitor = new VisitorController();

$visitor_id = $_GET['visitor_id']; // Get the visitor_id from the URL

// Call the viewQRCode function to get the QR code data
$result = $visitor->viewQRCode($visitor_id);

// Fetch the result as an associative array
$row = $result->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <!-- Include jsPDF library -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <title>Visitor QR Code</title>
</head>
<body class="bg-light">
    <div class="container min-vh-100 d-flex flex-column justify-content-center align-items-center">
        <div class="text-center mb-4">
            <h1 class="display-4">Visitor QR Code</h1>
        </div>
        <figure class="text-center">
            <?php if (isset($row['qr_code'])): ?>
                <img src="<?php echo htmlspecialchars($row['qr_code']); ?>" alt="visitorQRcode" class="img-fluid mb-3" style="max-width: 300px;">
                <figcaption class="text-muted">QR Code for visitor</figcaption>
            <?php else: ?>
                <p class="text-danger">QR Code not found.</p>
            <?php endif; ?>
        </figure>
        <section class="text-center">
            <p><b>Visitor Name:</b> <?php echo htmlspecialchars($row['name']); ?></p>
            <p><b>Visitor Email:</b> <?php echo htmlspecialchars($row['email']); ?></p>
            <p><b>Visitor Phone:</b> <?php echo htmlspecialchars($row['phone']); ?></p>
            <p><b>Visitor Visit Date:</b> <?php echo htmlspecialchars($row['visit_date']); ?></p>
        </section>
        <button id="downloadPdf" class="btn btn-primary mt-4">Download QR Code</button>
    </div>

    <!-- Include Bootstrap JS and dependencies (optional, for interactive components) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        document.getElementById('downloadPdf').addEventListener('click', function () {
            // Use jsPDF to generate PDF
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            // Add content to the PDF
            doc.text("Visitor QR Code", 20, 20);
            doc.text("Visitor Name: <?php echo htmlspecialchars($row['name']); ?>", 20, 30);
            doc.text("Visitor Email: <?php echo htmlspecialchars($row['email']); ?>", 20, 40);
            doc.text("Visitor Phone: <?php echo htmlspecialchars($row['phone']); ?>", 20, 50);
            doc.text("Visitor Visit Date: <?php echo htmlspecialchars($row['visit_date']); ?>", 20, 60);

            // Capture and add QR code image if it exists
            const qrImage = document.querySelector('img');
            if (qrImage) {
                // Add QR code image to PDF
                doc.addImage(qrImage.src, 'PNG', 20, 70, 50, 50); // Adjust dimensions as needed
            }

            // Save the generated PDF
            doc.save('visitor_qrcode.pdf');
        });
    </script>
</body>
</html>
