<!DOCTYPE html>
<html>
<head>
    <title>Uploaded Documents</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .actions {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        button {
            padding: 8px 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .navigation {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Uploaded Documents</h1>
    
    <form id="filesForm" method="POST">
        <div class="actions">
            <button type="submit" formaction="export_csv.php" name="export" value="csv">Download CSV</button>
            <button type="submit" formaction="export_pdf.php" name="export" value="pdf">Download PDF</button>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th><input type="checkbox" id="selectAll" onclick="toggleAll()"></th>
                    <th>File Name</th>
                    <th>File Type</th>
                    <th>Size</th>
                    <th>Upload Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $files = glob('uploads/*.{xml,ubl}', GLOB_BRACE);
                
                if (empty($files)) {
                    echo '<tr><td colspan="5">No files uploaded yet.</td></tr>';
                } else {
                    foreach ($files as $file) {
                        $filename = basename($file);
                        $filesize = round(filesize($file) / 1024, 2); // KB
                        $filetype = pathinfo($file, PATHINFO_EXTENSION);
                        $uploadDate = date("Y-m-d H:i:s", filemtime($file));
                        
                        echo '<tr>';
                        echo '<td><input type="checkbox" name="selected_files[]" value="' . $filename . '"></td>';
                        echo '<td>' . $filename . '</td>';
                        echo '<td>' . strtoupper($filetype) . '</td>';
                        echo '<td>' . $filesize . ' KB</td>';
                        echo '<td>' . $uploadDate . '</td>';
                        echo '</tr>';
                    }
                }
                ?>
            </tbody>
        </table>
    </form>
    
    <div class="navigation">
        <a href="index.php">Back to Upload Page</a>
    </div>

    <script>
        function toggleAll() {
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.getElementsByName('selected_files[]');
            
            for (let i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = selectAll.checked;
            }
        }
    </script>
</body>
</html> 