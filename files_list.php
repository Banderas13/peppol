<!DOCTYPE html>
<html>
<head>
    <title>Uploaded Documents</title>
    <style>
        :root {
            --primary-color: #3498db;
            --primary-dark: #2980b9;
            --secondary-color: #2ecc71;
            --text-color: #333;
            --light-bg: #f8f9fa;
            --border-color: #ddd;
            --table-hover: #edf7fd;
            --table-header: #e6f2fa;
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
            max-width: 1000px;
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
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }
        
        th {
            background-color: var(--table-header);
            font-weight: 600;
            color: var(--primary-dark);
        }
        
        tr:hover {
            background-color: var(--table-hover);
        }
        
        tr:last-child td {
            border-bottom: none;
        }
        
        .actions {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
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
        
        .btn-secondary {
            background-color: var(--secondary-color);
        }
        
        .btn-secondary:hover {
            background-color: #27ae60;
        }
        
        .navigation {
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid var(--border-color);
        }
        
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
        
        .checkbox-custom {
            position: relative;
            display: inline-block;
        }
        
        input[type="checkbox"] {
            cursor: pointer;
            width: 18px;
            height: 18px;
        }
        
        .no-files {
            padding: 20px;
            text-align: center;
            color: #666;
            font-style: italic;
        }
        
        .file-size {
            color: #666;
            font-size: 0.9em;
        }
        
        .file-type {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            background-color: #e1f0fa;
            color: var(--primary-dark);
            font-size: 0.85em;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Uploaded Documents</h1>
        
        <form id="filesForm" method="POST">
            <div class="actions">
                <button type="submit" formaction="export_csv.php" name="export" value="csv" class="btn">Download CSV</button>
                <button type="submit" formaction="export_pdf.php" name="export" value="pdf" class="btn btn-secondary">Download PDF</button>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th>
                            <div class="checkbox-custom">
                                <input type="checkbox" id="selectAll" onclick="toggleAll()">
                            </div>
                        </th>
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
                        echo '<tr><td colspan="5" class="no-files">No files uploaded yet.</td></tr>';
                    } else {
                        foreach ($files as $file) {
                            $filename = basename($file);
                            $filesize = round(filesize($file) / 1024, 2); // KB
                            $filetype = pathinfo($file, PATHINFO_EXTENSION);
                            $uploadDate = date("Y-m-d H:i:s", filemtime($file));
                            
                            echo '<tr>';
                            echo '<td><div class="checkbox-custom"><input type="checkbox" name="selected_files[]" value="' . $filename . '"></div></td>';
                            echo '<td>' . $filename . '</td>';
                            echo '<td><span class="file-type">' . strtoupper($filetype) . '</span></td>';
                            echo '<td><span class="file-size">' . $filesize . ' KB</span></td>';
                            echo '<td>' . $uploadDate . '</td>';
                            echo '</tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
        </form>
        
        <div class="navigation">
            <a href="index.php" class="nav-link">Back to Upload Page</a>
        </div>
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