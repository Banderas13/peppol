<!-- index.php -->
<!DOCTYPE html>
<html>
<head>
    <title>UBL Parser</title>
    <link rel="stylesheet" href="assets/dropzone/dropzone.css" />
</head>
<body>
    <!-- <form action="upload.php" class="dropzone" id="ublDropzone"></form> -->

    <form action="upload.php" method="post" enctype="multipart/form-data">
    Select UBL / XML file to upload:
    <input type="file" name="fileToUpload[]" id="fileToUpload" multiple>
    <input type="submit" value="Upload UBL / XML" name="submit">
    </form>

    <script src="assets/dropzone/dropzone.js"></script>
</body>
</html>
