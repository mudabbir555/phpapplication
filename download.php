<?php
include_once "dbconn.php";
require_once('fpdf/fpdf.php');

if (isset($_GET['row_id'])) {
    $row_id = $_GET['row_id'];

    // Fetch the row data from the database
    $query = "SELECT * FROM add_issue WHERE id = '$row_id'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        // Create a new PDF instance
        $pdf = new FPDF();

        // Add a new page to the PDF
        $pdf->AddPage();

        // Set the font size and style
        $pdf->SetFont('Arial', 'B', 16);

        // Output the row data in the PDF
        $pdf->Cell(40, 10, 'Vehicle: ' . $row['vehicle']);
        $pdf->Ln();
        $pdf->Cell(40, 10, 'Title: ' . $row['title']);
        $pdf->Ln();
        $pdf->Cell(40, 10, 'Description: ' . $row['description']);
        $pdf->Ln();
        $pdf->Cell(40, 10, 'Priority: ' . $row['priority']);
        $pdf->Ln();

        // Check if the image BLOB data is not empty
        $imageData = $row['file'];
        if (!empty($imageData)) {
            // Convert BLOB data to image file
            $imagePath = 'temp_image.jpg'; // Temporary file to store the image
            file_put_contents($imagePath, $imageData);

            // Get the image dimensions
            $imageInfo = getimagesize($imagePath);
            $imageWidth = $imageInfo[0];
            $imageHeight = $imageInfo[1];

            // Calculate the maximum width and height for the image
            $maxWidth = 100; // Adjust as needed
            $maxHeight = 100; // Adjust as needed

            // Calculate the aspect ratio of the image
            $aspectRatio = $imageWidth / $imageHeight;

            // Calculate the new width and height while maintaining the aspect ratio
            if ($imageWidth > $maxWidth || $imageHeight > $maxHeight) {
                if ($maxWidth / $maxHeight > $aspectRatio) {
                    $imageWidth = $maxHeight * $aspectRatio;
                    $imageHeight = $maxHeight;
                } else {
                    $imageHeight = $maxWidth / $aspectRatio;
                    $imageWidth = $maxWidth;
                }
            }

            // Load the image and place it in the PDF
            $pdf->Image($imagePath, $pdf->GetX(), $pdf->GetY(), $imageWidth, $imageHeight);

            // Remove the temporary image file
            unlink($imagePath);
        }

        $pdf->Ln();
        $pdf->Cell(40, 10, 'Assigned: ' . $row['assigned']);
        $pdf->Ln();

        // Save the PDF to a file
        $pdf->Output('table_data.pdf', 'F');
    } else {
        echo "Row not found.";
    }
}

$filePath = 'table_data.pdf';

// Set the appropriate headers to initiate the download
header('Content-type: application/pdf');
header('Content-Disposition: attachment; filename="table_data.pdf"');
header('Content-Length: ' . filesize($filePath));

// Read the file and output it to the browser
readfile($filePath);

// Close the database connection
$conn->close();
?>
