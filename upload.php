<?php
/**
 * File Upload Handler for UBL/XML Documents
 * 
 * This script processes uploaded UBL/XML files, validates them, and moves them to the uploads directory.
 * It shows results to the user and provides navigation options.
 */

// Define the target directory for uploaded files
$target_dir = "uploads/";

// Create the uploads directory if it doesn't exist
if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
}

// Initialize upload status flag and results array
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
        
        // Check file size (500KB limit)
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
            // Move uploaded file from temporary location to target directory
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
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload Results</title>
    <style>
        /* CSS Variables for consistent theming */
        :root {
            --primary-color: #3498db;
            --primary-dark: #2980b9;
            --secondary-color: #2ecc71;
            --text-color: #333;
            --light-bg: #f8f9fa;
            --border-color: #ddd;
            --success-color: #2ecc71;
            --error-color: #e74c3c;
        }
        
        /* Base styling */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--light-bg);
            color: var(--text-color);
            line-height: 1.6;
        }
        
        /* Main container */
        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 30px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        
        /* Page header */
        h1 {
            color: var(--primary-color);
            margin-top: 0;
            border-bottom: 2px solid var(--border-color);
            padding-bottom: 15px;
            font-weight: 600;
        }
        
        /* Results container */
        .results {
            margin: 20px 0;
            padding: 15px;
            background-color: var(--light-bg);
            border-radius: 5px;
            border: 1px solid var(--border-color);
        }
        
        /* Individual result items */
        .result-item {
            padding: 10px;
            margin-bottom: 8px;
            border-radius: 4px;
        }
        
        /* Success message styling */
        .success {
            background-color: rgba(46, 204, 113, 0.1);
            border-left: 4px solid var(--success-color);
        }
        
        /* Error message styling */
        .error {
            background-color: rgba(231, 76, 60, 0.1);
            border-left: 4px solid var(--error-color);
        }
        
        /* Button styling */
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            text-decoration: none;
        }
        
        .btn:hover {
            background-color: var(--primary-dark);
        }
        
        .btn-secondary {
            background-color: var(--secondary-color);
        }
        
        .btn-secondary:hover {
            background-color: #27ae60;
        }
        
        /* Action buttons container */
        .actions {
            margin-top: 25px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        
        /* Navigation links container */
        .navigation {
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid var(--border-color);
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }
        
        /* Navigation link styling */
        .nav-link {
            display: inline-block;
            padding: 10px 20px;
            color: var(--primary-color);
            text-decoration: none;
            border-radius: 4px;
            transition: all 0.3s;
            border: 1px solid var(--primary-color);
        }
        
        .nav-link:hover {
            background-color: var(--primary-color);
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Upload Results</h1>
        
        <div class="results">
            <?php
            // Display all upload results with appropriate styling
            foreach($upload_results as $result) {
                // Set class based on whether the upload was successful
                $isSuccess = strpos($result, "has been uploaded") !== false;
                $class = $isSuccess ? "success" : "error";
                echo "<div class='result-item $class'>" . $result . "</div>";
            }
            ?>
        </div>
        
        <div class="actions">
            <!-- Form to download CSV export of uploaded files -->
            <form method="POST" action="export_csv.php">
                <button type="submit" class="btn">Download CSV</button>
            </form>

            <!-- Form to download PDF export of uploaded files -->
            <form method="POST" action="export_pdf.php">
                <button type="submit" class="btn btn-secondary">Download PDF</button>
            </form>
        </div>

        <div class="navigation">
            <!-- Navigation links -->
            <a href="index.php" class="nav-link">Back to Upload Page</a>
            <a href="files_list.php" class="nav-link">View Uploaded Documents</a>
        </div>
    </div>
</body>
</html>