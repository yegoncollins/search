<?php 
include 'config.php';

if(isset($_GET['query'])){ 
    $search = $_GET['query']; 
    $query = "SELECT * FROM my_table WHERE firstname LIKE '%$search%' OR lastname LIKE '%$search%'";
} else {
    $query = "SELECT * FROM my_table";
}

$query_run = mysqli_query($conn, $query);

$output = '';

if ($query_run) {
    $num = mysqli_num_rows($query_run);
    if ($num > 0){
        while($row = mysqli_fetch_array($query_run)){
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

echo $output;

mysqli_close($conn);
?>
