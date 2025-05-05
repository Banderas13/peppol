<?php
/**
 * PDF Export Script for UBL/XML Invoices
 * 
 * This script processes the uploaded UBL/XML files and generates a PDF report
 * displaying summary information for all invoices. It uses the DOMPDF library
 * to render HTML content into a downloadable PDF document.
 */

// Include required libraries
require 'vendor/autoload.php';
require_once 'parse_ubl.php';

use Dompdf\Dompdf;

// Create the exports directory if it doesn't exist (in case PDF needs to be saved)
if (!file_exists('exports')) {
    mkdir('exports', 0777, true);
}

// Initialize arrays for file paths and running totals
$files = [];
$totals = ['excl' => 0, 'vat' => 0, 'incl' => 0];

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

// Parse each file and collect data for the report
$fileDetails = [];
foreach ($files as $file) {
    $data = parseUBL($file);
    
    // Add values to running totals
    $totals['excl'] += $data['total_excl'];
    $totals['vat'] += $data['tax_amount'];
    $totals['incl'] += $data['total_incl'];
    
    // Store invoice details for the report
    $fileDetails[] = [
        'name' => basename($file),
        'invoice_number' => $data['invoice_number'],
        'invoice_date' => $data['invoice_date'],
        'client_name' => $data['client_name'],
        'total_excl' => $data['total_excl'],
        'tax_amount' => $data['tax_amount'],
        'total_incl' => $data['total_incl']
    ];
}

// Build the HTML content for the PDF
$html = "
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .totals { font-weight: bold; }
    </style>
    <h1>UBL Invoice Summary</h1>
    
    <h2>Selected Files</h2>
    <table>
        <thead>
            <tr>
                <th>File Name</th>
                <th>Invoice Number</th>
                <th>Invoice Date</th>
                <th>Client</th>
                <th>Excl. VAT</th>
                <th>VAT</th>
                <th>Incl. VAT</th>
            </tr>
        </thead>
        <tbody>
";

// Add each invoice as a row in the table
foreach ($fileDetails as $file) {
    $html .= "
        <tr>
            <td>{$file['name']}</td>
            <td>{$file['invoice_number']}</td>
            <td>{$file['invoice_date']}</td>
            <td>{$file['client_name']}</td>
            <td>€" . number_format($file['total_excl'], 2) . "</td>
            <td>€" . number_format($file['tax_amount'], 2) . "</td>
            <td>€" . number_format($file['total_incl'], 2) . "</td>
        </tr>
    ";
}

// Add totals row to the table
$html .= "
        <tr class='totals'>
            <td colspan='4'>Totals</td>
            <td>€" . number_format($totals['excl'], 2) . "</td>
            <td>€" . number_format($totals['vat'], 2) . "</td>
            <td>€" . number_format($totals['incl'], 2) . "</td>
        </tr>
        </tbody>
    </table>
    
    <p>Generated on: " . date('Y-m-d H:i:s') . "</p>
";

// Generate the PDF using DOMPDF
try {
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();
    $dompdf->stream("UBL_Summary.pdf", ["Attachment" => true]);
} catch (Exception $e) {
    echo "Error generating PDF: " . $e->getMessage();
    echo "<br><a href='files_list.php'>Back to Files List</a>";
}
exit;
?> 