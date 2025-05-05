<?php
$target_dir = "uploads/";

// Create the uploads directory if it doesn't exist
if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
}

$uploadOk = 1;
$upload_results = [];

// Check if files were uploaded
if(!empty($_FILES["fileToUpload"]["name"][0])) {
    // Process each uploaded file
    foreach($_FILES["fileToUpload"]["name"] as $key => $filename) {
        $uploadOk = 1;
        $target_file = $target_dir . basename($filename);
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        // Check if file already exists
        if (file_exists($target_file)) {
            $upload_results[] = "Sorry, file '$filename' already exists.";
            $uploadOk = 0;
        }
        
        // Check file size
        if ($_FILES["fileToUpload"]["size"][$key] > 500000) {
            $upload_results[] = "Sorry, file '$filename' is too large.";
            $uploadOk = 0;
        }
        
        // Allow only XML and UBL file formats
        if($fileType != "xml" && $fileType != "ubl") {
            $upload_results[] = "Sorry, only XML and UBL files are allowed. '$filename' is not allowed.";
            $uploadOk = 0;
        }
        
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $upload_results[] = "Sorry, your file '$filename' was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$key], $target_file)) {
                $upload_results[] = "The file '" . htmlspecialchars($filename) . "' has been uploaded.";
            } else {
                $upload_results[] = "Sorry, there was an error uploading your file '$filename'.";
            }
        }
    }
} else {
    $upload_results[] = "No files were selected for upload.";
}

// Display all upload results
foreach($upload_results as $result) {
    echo $result . "<br>";
}
?>

<div style="margin-top: 20px;">
    <form method="POST" action="export_csv.php">
        <button type="submit">Download CSV</button>
    </form>

    <form method="POST" action="export_pdf.php" style="margin-top: 10px;">
        <button type="submit">Download PDF</button>
    </form>

    <div style="margin-top: 20px;">
        <a href="index.php">Back to Upload Page</a> | 
        <a href="files_list.php">View Uploaded Documents</a>
    </div>
</div>