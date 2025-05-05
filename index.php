<!-- index.php -->
<!DOCTYPE html>
<html>
<head>
    <title>UBL Parser</title>
    <link rel="stylesheet" href="assets/dropzone/dropzone.css" />
    <style>
        :root {
            --primary-color: #3498db;
            --primary-dark: #2980b9;
            --secondary-color: #2ecc71;
            --text-color: #333;
            --light-bg: #f8f9fa;
            --border-color: #ddd;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--light-bg);
            color: var(--text-color);
            line-height: 1.6;
        }
        
        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 30px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        
        h1 {
            color: var(--primary-color);
            margin-top: 0;
            border-bottom: 2px solid var(--border-color);
            padding-bottom: 15px;
            font-weight: 600;
        }
        
        form {
            margin: 25px 0;
            padding: 20px;
            background-color: var(--light-bg);
            border-radius: 5px;
            border: 1px solid var(--border-color);
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }
        
        input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            background-color: white;
        }
        
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
        
        .navigation {
            margin-top: 25px;
            text-align: center;
        }
        
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
        
        .file-upload-wrapper {
            position: relative;
            margin-bottom: 15px;
        }
        
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
        
        <!-- <form action="upload.php" class="dropzone" id="ublDropzone" method="post" enctype="multipart/form-data"></form> -->

        <form action="upload.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label class="form-label" for="fileToUpload">Select UBL / XML file to upload:</label>
                <div class="file-upload-wrapper">
                    <input type="file" name="fileToUpload[]" id="fileToUpload" multiple>
                    <div class="file-info">Supported formats: UBL, XML</div>
                </div>
            </div>
            <input type="submit" value="Upload Files" name="submit" class="btn">
        </form>

        <div class="navigation">
            <a href="files_list.php" class="nav-link">View Uploaded Documents</a>
        </div>
    </div>

    <script src="assets/dropzone/dropzone.js"></script>
</body>
</html>
