<?php
require_once 'parse_ubl.php';

// Create the exports directory if it doesn't exist
if (!file_exists('exports')) {
    mkdir('exports', 0777, true);
}

$data = [];
$files = [];

// Check if specific files were selected
if (isset($_POST['selected_files']) && !empty($_POST['selected_files'])) {
    foreach ($_POST['selected_files'] as $filename) {
        // Validate filename to prevent directory traversal
        $filename = basename($filename);
        $filepath = 'uploads/' . $filename;
        
        if (file_exists($filepath) && (pathinfo($filepath, PATHINFO_EXTENSION) === 'xml' || 
                                      pathinfo($filepath, PATHINFO_EXTENSION) === 'ubl')) {
            $files[] = $filepath;
        }
    }
} else {
    // No files selected, process all files
    $files = glob('uploads/*.xml');
    $files = array_merge($files, glob('uploads/*.ubl'));
}

if (empty($files)) {
    echo "No files to process. Please select at least one file.";
    echo "<br><a href='files_list.php'>Back to Files List</a>";
    exit;
}

foreach ($files as $file) {
    $data[] = parseUBL($file);
}

$fp = fopen('exports/invoices.csv', 'w');
if ($fp === false) {
    die("Unable to open file exports/invoices.csv for writing");
}

fputcsv($fp, ['InvoiceNumber', 'InvoiceDate', 'Excl. VAT', 'VAT', 'Incl. VAT', 'ClientName', 'Client VAT']);

foreach ($data as $row) {
    fputcsv($fp, [
        $row['invoice_number'],
        $row['invoice_date'],
        $row['total_excl'],
        $row['tax_amount'],
        $row['total_incl'],
        $row['client_name'],
        $row['client_vat'],
    ]);
}
fclose($fp);

// Force download
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="invoices.csv"');
readfile('exports/invoices.csv');
exit;

?> 