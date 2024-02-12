<?php 
include 'config.php';

$output = '';

if(isset($_GET['query'])){
    $search = $_GET['query'];
    $query = "SELECT * FROM my_table WHERE firstname LIKE '%$search%' OR lastname LIKE '%$search%'";
} else {
    $query = "SELECT * FROM my_table";
}

$query_run = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mintel</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-secondary">
<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
 
  <a class="navbar-brand" href="#">Mintel</a>
  
  
  <ul class="navbar-nav">
    <li class="nav-item">
      
    </li>
    
    </li>
  </ul>
</nav>
<div class="container-fluid">
  <div class="row justify-content-center">
     <div class="col-md-10 bg-light mt2-rounded pb-3">
       <div class="form-line">
        <label for="search" class="font-weight-bold lead text-dark">Search</label> &nbsp;&nbsp;&nbsp;&nbsp;
        <input type="text" name="query" id="search_text" class="form-control form-control-lg rounded border-primary" placeholder="Search...">
       </div>
          
          <table class="table table-hover table-light table-striped" id="table-data">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Firstname</th>
                    <th>Lastname</th>
                    <th>Email</th>
                    <th>Phonenumber</th>
                    <th>Address</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($query_run) {
                    $num = mysqli_num_rows($query_run);
                    if ($num > 0){
                        while($row = mysqli_fetch_array($query_run)){
                            echo "<tr>
                                    <td>".$row['id']."</td>
                                    <td>".$row['firstname']."</td>
                                    <td>".$row['lastname']."</td>
                                    <td>".$row['email']."</td>
                                    <td>".$row['phonenumber']."</td>
                                    <td>".$row['address']."</td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No Records Found!</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Error: Unable to execute query</td></tr>";
                }
                ?>
            </tbody>
          </table>
     </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
    $("#search_text").keyup(function(event){
        event.preventDefault();
        // Capture the value of the search input field
        var search = $(this).val(); 
        $.ajax({
            url: "action.php",

            // use GET not POST
            method: 'GET', 
            data: {query: search}, 
            success: function(data){
                // Update table with search results
                $("#table-data tbody").html(data); 
            }
        });
    });
  });
</script>
</body>
</html>
