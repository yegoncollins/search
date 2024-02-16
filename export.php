<?php 
require "config.php";

// Filtering function for Excel data
function filterData(&$str){
    $str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);
    if(strstr($str,'"')) $str = '"' . str_replace( '"', '""', $str) . '"';
}

// Excel file name for download
$fileName = "search-data". date('Y-m-d'). ".xls";

// Column names
$fields = array('Id','Firstname','Lastname','Email','Phonenumber','Address');

// Display column names as the first row
$excelData = implode("\t", array_values($fields)) . "\n";

// Fetch records from the database
$query = $conn->query("SELECT * FROM my_table ORDER BY id ASC");
if ($query->num_rows > 0){
    while ($row = $query->fetch_assoc()) {
        // Prepare row data
        $rowData = array(
            $row['id'],
            $row['firstname'],
            $row['lastname'],
            $row['email'],
            $row['phonenumber'],
            $row['address']
        );
        // Filter and format data
        array_walk($rowData, 'filterData');
        // Add row to Excel data
        $excelData .= implode("\t", $rowData) . "\n";
    }
} else {
    $excelData .= 'No records found...'. "\n";
}

// Set headers for Excel download
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"$fileName\"");

// Output Excel data
echo $excelData;

exit();
?>
