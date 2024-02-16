<?php
include 'config.php';

$records_per_page = 20;
$page_number = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

// Calculate the offset
$offset = ($page_number - 1) * $records_per_page;

// Search query handling
$output = '';
if (isset($_GET['query'])) {
    $search = $_GET['query'];
    $query = "SELECT * FROM my_table WHERE firstname LIKE '%$search%' OR lastname LIKE '%$search%'";
} else {
    $query = "SELECT * FROM my_table";
}

// Add pagination LIMIT and OFFSET
$query .= " LIMIT $records_per_page OFFSET $offset";

$query_run = mysqli_query($conn, $query);

?>
<?php require "config.php" ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mintel Search</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="bg-secondary">
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <a class="navbar-brand" href="#">Mintel Solutions ltd</a>
        <ul class="navbar-nav">
            <li class="nav-item">
            </li>
        </ul>
        <form class="d-flex">
            <button class="btn btn-outline-success" type="submit">Logout</button>
        </form>
    </nav>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10 bg-light mt2-rounded pb-3">
                <div class="form-line">
                    <label for="search" class="font-weight-bold lead text-dark">Search Results</label> &nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="text" name="query" id="search_text" class="form-control form-control-lg w-50" placeholder="Search...">
        
                    <a href="export.php"><button type="button" class="btn btn-primary">Download Data</button></a>
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
                            if ($num > 0) {
                                while ($row = mysqli_fetch_array($query_run)) {
                                    echo "<tr>
                                        <td>" . $row['id'] . "</td>
                                        <td>" . $row['firstname'] . "</td>
                                        <td>" . $row['lastname'] . "</td>
                                        <td>" . $row['email'] . "</td>
                                        <td>" . $row['phonenumber'] . "</td>
                                        <td>" . $row['address'] . "</td>
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

                <div id='pagination'>
                    <?php
                    $previous_page = $page_number - 1;
                    if ($previous_page > 0) {
                        echo "<a href='{$_SERVER['PHP_SELF']}?page=$previous_page' class='btn btn-secondary' id='btn-previous'>Prev</a>";
                    }

                    $next_page = $page_number + 1;
                    echo "<a href='{$_SERVER['PHP_SELF']}?page=$next_page' class='btn btn-secondary' id='btn-next'>Next</a>";
                    ?>
                </div>


            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
    const btnNext = $('#btn-next');
    const btnPrevious = $('#btn-previous');
    const pagination = $('#pagination');

    $("#search_text").keyup(function(event) {
        event.preventDefault();
        var search = $(this).val();

        $.ajax({
            url: "action.php",
            method: 'GET',
            data: { query: search },
            success: function(data) {
                const response = JSON.parse(data);
                $('#table-data tbody').empty().html(response.html);

                pagination.empty();
                if (response.page_number > 1) {
                    pagination.append(`<a href='action.php?page=${response.page_number - 1}&query=${search}' class='btn btn-secondary' id='btn-previous'>Prev</a>`);
                }
                pagination.append(`<a href='action.php?page=${response.page_number + 1}&query=${search}' class='btn btn-secondary' id='btn-next'>Next</a>`);
            }
        });
    });

    pagination.on('click', '#btn-next', function(event) {
        event.preventDefault();
        const nextPage = parseInt($(this).attr('href').split('=')[1]);
        const search = $('#search_text').val();
        $.ajax({
            url: `action.php?page=${nextPage}&query=${search}`,
            method: 'GET',
            success: function(data) {
                const response = JSON.parse(data);
                $('#table-data tbody').empty().html(response.html);
                pagination.empty();
                pagination.append(`<a href='action.php?page=${response.page_number - 1}&query=${search}' class='btn btn-secondary' id='btn-previous'>Prev</a>`);
                pagination.append(`<a href='action.php?page=${response.page_number + 1}&query=${search}' class='btn btn-secondary' id='btn-next'>Next</a>`);
            }
        });
    });

    pagination.on('click', '#btn-previous', function(event) {
        event.preventDefault();
        const prevPage = parseInt($(this).attr('href').split('=')[1]);
        const search = $('#search_text').val();
        $.ajax({
            url: `action.php?page=${prevPage}&query=${search}`,
            method: 'GET',
            success: function(data) {
                const response = JSON.parse(data);
                $('#table-data tbody').empty().html(response.html);
                pagination.empty();
                pagination.append(`<a href='action.php?page=${response.page_number - 1}&query=${search}' class='btn btn-secondary' id='btn-previous'>Prev</a>`);
                pagination.append(`<a href='action.php?page=${response.page_number + 1}&query=${search}' class='btn btn-secondary' id='btn-next'>Next</a>`);
            }
        });
    });
});

    </script>
    
</body>

</html>