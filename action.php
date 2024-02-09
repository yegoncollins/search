<?php 
include 'config.php';
$output='';

if(isset($_POST['query'])){
    $search=$_POST['query'];
    $stmt=$conn->prepare("SELECT * FROM my_table WHERE firstname LIKE CONCAT('%', ?, '%') OR lastname LIKE CONCAT('%', ?, '%')");
    $stmt->bind_param("ss", $search, $search);
}
else{
    $stmt=$conn->prepare("SELECT * FROM my_table");
}

$stmt->execute();
$result=$stmt->get_result();

if($result->num_rows>0){
    $output = "<thead>
                <tr>
                    <th>#</th>
                    <th>Firstname</th>
                    <th>Lastname</th>
                    <th>Email</th>
                    <th>Phonenumber</th>
                    <th>Address</th>
                </tr>
            </thead>
            <tbody>";

    while($row=$result->fetch_assoc()){
        $output .= "<tr>
                        <td>".$row['id']."</td>
                        <td>".$row['firstname']."</td>
                        <td>".$row['lastname']."</td>
                        <td>".$row['email']."</td>
                        <td>".$row['phonenumber']."</td>
                        <td>".$row['address']."</td>
                    </tr>";
    }

    $output .= "</tbody>";
    echo $output;
}
else{
    echo "<h3>No Records Found!</h3>";
}

$stmt->close();
$conn->close();
?>
