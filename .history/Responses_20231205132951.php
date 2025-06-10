<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responses</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Add your existing styles here -->
    <style>
        body {
            background-color: #3498db; /* Blue background color */
            color: #fff; /* White text color */
        }

        .container-fluid {
            padding: 20px;
        }

        .firstform {
            background-color: #fff; /* White background color */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .table {
            margin-top: 20px;
        }
    </style>
</head>

<body class="fadeOut">

    <?php
    // Your database connection code here
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $dbname = "wedding";
    $conn = new mysqli($hostname, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get data based on filter (action)
    $filter = isset($_GET['filter']) ? $_GET['filter'] : ''; // assuming 'action' is your filter column
    $sql = "SELECT * FROM attendees";
    if (!empty($filter)) {
        $sql .= " WHERE action = '$filter'";
    }
    $result = $conn->query($sql);

    if ($result === false) {
        die("Query execution failed: " . $conn->error);
    }
    ?>

    <div class="container-fluid story" id="rsvp">
        <div class="container content " style="padding-top: 40px;" height="200vh">

            <div class="container-fluid firstform" data-aos="fade-up">
                <!-- Bootstrap Form -->
                <form class="mb-3" method="get" action="">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="filter" class="form-label">Filter by Action:</label>
                            <select class="form-select" name="filter" id="filter">
                                <option value="">Show All</option>
                                <option value="Coming">Coming</option>
                                <option value="Not Coming">Not Coming</option>
                                <option value="">No Action</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary">Apply Filter</button>
                        </div>
                    </div>
                </form>

                <!-- Bootstrap Table -->
                <table class="table table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Action</th>
                            <!-- Add other columns as needed -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Display data in the table
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>{$row['id']}</td>";
                            echo "<td>{$row['first_name']}</td>";
                            echo "<td>{$row['last_name']}</td>";
                            echo "<td>{$row['action']}</td>";
                            // Add other columns as needed
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bootstrap Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
