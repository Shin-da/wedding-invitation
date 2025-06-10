<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Res</title>

       
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
                <!-- Dropdown for filtering -->
                <form method="get" action="">
                    <label for="filter">Filter by Action:</label>
                    <select name="filter" id="filter">
                        <option value="">Show All</option>
                        <option value="Coming">Coming</option>
                        <option value="Not Coming">Not Coming</option>
                        <option value="">No Action</option>
                    </select>
                    <button type="submit">Apply Filter</button>
                </form>

                <!-- Display table with data -->
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
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
                            // Add other columns as needed
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Include your AOS and Bootstrap scripts here -->

</body>

</html>
