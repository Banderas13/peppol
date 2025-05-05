<?php
/**
 * Parses Universal Business Language (UBL) XML files to extract invoice data
 * 
 * @param string $xmlPath Path to the XML/UBL file to be parsed
 * @return array Associative array containing extracted invoice data
 */
function parseUBL($xmlPath) {
    // Initialize data array to store extracted values
    $data = [];
    
    // Load XML file using SimpleXML
    $xml = simplexml_load_file($xmlPath);
    
    // Get all namespaces from the XML document
    $ns = $xml->getNamespaces(true);
    
    // Register namespaces for XPath queries
    // cbc = Common Basic Components
    // cac = Common Aggregate Components
    $xml->registerXPathNamespace('cbc', $ns['cbc']);
    $xml->registerXPathNamespace('cac', $ns['cac']);

    // Extract invoice number (ID) from the document
    $invoice_number = $xml->xpath('//cbc:ID');
    $data['invoice_number'] = !empty($invoice_number) ? (string)$invoice_number[0] : '';
    
    // Extract invoice issue date
    $invoice_date = $xml->xpath('//cbc:IssueDate');
    $data['invoice_date'] = !empty($invoice_date) ? (string)$invoice_date[0] : '';
    
    // Extract client name from PartyName
    $client_name = $xml->xpath('//cac:PartyName/cbc:Name');
    $data['client_name'] = !empty($client_name) ? (string)$client_name[0] : '';
    
    // Extract client VAT/Company ID
    $client_vat = $xml->xpath('//cac:Party/cbc:CompanyID');
    $data['client_vat'] = !empty($client_vat) ? (string)$client_vat[0] : '';

    // Extract total amount excluding VAT
    $total_excl = $xml->xpath('//cac:LegalMonetaryTotal/cbc:LineExtensionAmount');
    $data['total_excl'] = !empty($total_excl) ? (float)$total_excl[0] : 0;
    
    // Extract tax/VAT amount
    $tax_amount = $xml->xpath('//cac:TaxTotal/cbc:TaxAmount');
    $data['tax_amount'] = !empty($tax_amount) ? (float)$tax_amount[0] : 0;
    
    // Extract total amount including VAT (payable amount)
    $total_incl = $xml->xpath('//cac:LegalMonetaryTotal/cbc:PayableAmount');
    $data['total_incl'] = !empty($total_incl) ? (float)$total_incl[0] : 0;

    return $data;
}

?> 