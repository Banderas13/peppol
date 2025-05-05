<?php
/**
 * CSV Export Script for UBL/XML Invoices
 * 
 * This script processes the uploaded UBL/XML files and exports their data
 * to a CSV file for download. It can handle both specifically selected files
 * and process all files if none are explicitly selected.
 */

// Include the UBL parser function
require_once 'parse_ubl.php';

// Create the exports directory if it doesn't exist
if (!file_exists('exports')) {
    mkdir('exports', 0777, true);
}

// Initialize arrays to store processed data and file paths
$data = [];
$files = [];

// Check if specific files were selected
if (isset($_POST['selected_files']) && !empty($_POST['selected_files'])) {
    // Process only the selected files
    foreach ($_POST['selected_files'] as $filename) {
        // Validate filename to prevent directory traversal
        $filename = basename($filename);
        $filepath = 'uploads/' . $filename;
        
        // Only process XML and UBL files that exist
        if (file_exists($filepath) && (pathinfo($filepath, PATHINFO_EXTENSION) === 'xml' || 
                                      pathinfo($filepath, PATHINFO_EXTENSION) === 'ubl')) {
            $files[] = $filepath;
        }
    }
} else {
    // No files selected, process all files in the uploads directory
    $files = glob('uploads/*.xml');
    $files = array_merge($files, glob('uploads/*.ubl'));
}

// Check if we have files to process
if (empty($files)) {
    echo "No files to process. Please select at least one file.";
    echo "<br><a href='files_list.php'>Back to Files List</a>";
    exit;
}

// Parse each file to extract invoice data
foreach ($files as $file) {
    $data[] = parseUBL($file);
}

// Create and open CSV file for writing
$fp = fopen('exports/invoices.csv', 'w');
if ($fp === false) {
    die("Unable to open file exports/invoices.csv for writing");
}

// Write CSV header row
fputcsv($fp, ['InvoiceNumber', 'InvoiceDate', 'Excl. VAT', 'VAT', 'Incl. VAT', 'ClientName', 'Client VAT']);

// Write each invoice's data as a row in the CSV
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

// Force browser to download the file
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="invoices.csv"');
readfile('exports/invoices.csv');
exit;
?> 