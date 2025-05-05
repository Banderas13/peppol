<!-- 
    index.php - Main entry page for the UBL Parser application
    
    This page provides a file upload form for users to submit UBL/XML files
    for processing and analysis.
-->
<!DOCTYPE html>
<html>
<head>
    <title>UBL Parser</title>
    <link rel="stylesheet" href="assets/dropzone/dropzone.css" />
    <style>
        /* CSS Variables for consistent theming */
        :root {
            --primary-color: #3498db;
            --primary-dark: #2980b9;
            --secondary-color: #2ecc71;
            --text-color: #333;
            --light-bg: #f8f9fa;
            --border-color: #ddd;
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
        
        /* Form styling */
        form {
            margin: 25px 0;
            padding: 20px;
            background-color: var(--light-bg);
            border-radius: 5px;
            border: 1px solid var(--border-color);
        }
        
        /* Form group container */
        .form-group {
            margin-bottom: 15px;
        }
        
        /* Form label */
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }
        
        /* File input field */
        input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            background-color: white;
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
        }
        
        .btn:hover {
            background-color: var(--primary-dark);
        }
        
        /* Navigation container */
        .navigation {
            margin-top: 25px;
            text-align: center;
        }
        
        /* Navigation link */
        .nav-link {
            display: inline-block;
            padding: 10px 20px;
            background-color: var(--secondary-color);
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: opacity 0.3s;
        }
        
        .nav-link:hover {
            opacity: 0.9;
            text-decoration: none;
        }
        
        /* File upload container */
        .file-upload-wrapper {
            position: relative;
            margin-bottom: 15px;
        }
        
        /* File info text */
        .file-info {
            margin-top: 5px;
            font-size: 14px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>UBL File Upload</h1>
        
        <!-- Dropzone implementation (currently commented out) -->
        <!-- <form action="upload.php" class="dropzone" id="ublDropzone" method="post" enctype="multipart/form-data"></form> -->

        <!-- File upload form with multiple file selection support -->
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label class="form-label" for="fileToUpload">Select UBL / XML file to upload:</label>
                <div class="file-upload-wrapper">
                    <!-- Multiple file selection enabled with the multiple attribute -->
                    <input type="file" name="fileToUpload[]" id="fileToUpload" multiple>
                    <div class="file-info">Supported formats: UBL, XML</div>
                </div>
            </div>
            <input type="submit" value="Upload Files" name="submit" class="btn">
        </form>

        <!-- Navigation to view uploaded documents -->
        <div class="navigation">
            <a href="files_list.php" class="nav-link">View Uploaded Documents</a>
        </div>
    </div>

    <!-- JavaScript for Dropzone functionality (currently not in use) -->
    <script src="assets/dropzone/dropzone.js"></script>
</body>
</html>
