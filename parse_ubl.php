<?php
function parseUBL($xmlPath) {
    $data = [];
    $xml = simplexml_load_file($xmlPath);
    $ns = $xml->getNamespaces(true);
    $xml->registerXPathNamespace('cbc', $ns['cbc']);
    $xml->registerXPathNamespace('cac', $ns['cac']);

    $invoice_number = $xml->xpath('//cbc:ID');
    $data['invoice_number'] = !empty($invoice_number) ? (string)$invoice_number[0] : '';
    
    $invoice_date = $xml->xpath('//cbc:IssueDate');
    $data['invoice_date'] = !empty($invoice_date) ? (string)$invoice_date[0] : '';
    
    $client_name = $xml->xpath('//cac:PartyName/cbc:Name');
    $data['client_name'] = !empty($client_name) ? (string)$client_name[0] : '';
    
    $client_vat = $xml->xpath('//cac:Party/cbc:CompanyID');
    $data['client_vat'] = !empty($client_vat) ? (string)$client_vat[0] : '';

    $total_excl = $xml->xpath('//cac:LegalMonetaryTotal/cbc:LineExtensionAmount');
    $data['total_excl'] = !empty($total_excl) ? (float)$total_excl[0] : 0;
    
    $tax_amount = $xml->xpath('//cac:TaxTotal/cbc:TaxAmount');
    $data['tax_amount'] = !empty($tax_amount) ? (float)$tax_amount[0] : 0;
    
    $total_incl = $xml->xpath('//cac:LegalMonetaryTotal/cbc:PayableAmount');
    $data['total_incl'] = !empty($total_incl) ? (float)$total_incl[0] : 0;

    return $data;
}

?> 