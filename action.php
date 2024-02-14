<?php
include 'config.php';

$records_per_page = 20;
$page_number = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page_number - 1) * $records_per_page;

$output = '';

if (isset($_GET['query'])) {
    $search = $_GET['query'];
    $query = "SELECT * FROM my_table WHERE firstname LIKE '%$search%' OR lastname LIKE '%$search%' LIMIT $records_per_page OFFSET $offset";
} else {
    $query = "SELECT * FROM my_table LIMIT $records_per_page OFFSET $offset";
}

$query_run = mysqli_query($conn, $query);

if ($query_run) {
    if (mysqli_num_rows($query_run) > 0) {
        while ($row = mysqli_fetch_array($query_run)) {
            $output .= "<tr>
                            <td>".$row['id']."</td>
                            <td>".$row['firstname']."</td>
                            <td>".$row['lastname']."</td>
                            <td>".$row['email']."</td>
                            <td>".$row['phonenumber']."</td>
                            <td>".$row['address']."</td>
                        </tr>";
        }
    } else {
        $output .= "<tr><td colspan='6'>No Records Found!</td></tr>";
    }
} else {
    $output .= "<tr><td colspan='6'>Error: Unable to execute query</td></tr>";
}

echo json_encode([
    'html' => $output,
    'page_number' => $page_number
 
]);

mysqli_close($conn);
?>
