<!-- index.php -->
<!DOCTYPE html>
<html>
<head>
    <title>UBL Parser</title>
    <link rel="stylesheet" href="assets/dropzone/dropzone.css" />
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        form {
            margin-bottom: 20px;
        }
        .navigation {
            margin-top: 20px;
        }
        a {
            text-decoration: none;
            color: #0066cc;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>UBL File Upload</h1>
    
    <!-- <form action="upload.php" class="dropzone" id="ublDropzone"></form> -->

    <form action="upload.php" method="post" enctype="multipart/form-data">
        Select UBL / XML file to upload:
        <input type="file" name="fileToUpload[]" id="fileToUpload" multiple>
        <input type="submit" value="Upload UBL / XML" name="submit">
    </form>

    <div class="navigation">
        <a href="files_list.php">View Uploaded Documents</a>
    </div>

    <script src="assets/dropzone/dropzone.js"></script>
</body>
</html>
