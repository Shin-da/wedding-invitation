<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>You are Invited</title>
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous">
        <link rel="stylesheet" href="style.css" />
        <link href="styles.css" rel="stylesheet">
        <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />
        <link
            href='https://fonts.googleapis.com/css?family=Dancing Script&effect=emboss'
            rel='stylesheet'>
        <script
            src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <link href="https://fonts.cdnfonts.com/css/goladon" rel="stylesheet">
        <link href="https://fonts.cdnfonts.com/css/spaceroom" rel="stylesheet">
        <style>
    body {
      animation: fadeInAnimation ease 3s;
      animation-iteration-count: 1;
      animation-fill-mode: forwards;
      overflow: hidden;
    }
*{
    color: #152630;
}


    
    @keyframes fadeInAnimation {
      0% {
        opacity: 0;
      }

      100% {
        opacity: 1;
      }
    }


    @media (max-width:500px) {
      .firstform {
       padding: 19vw;
       position: absolute;
       width: 100vw;
      }
      .story{
        padding: 0;
        background-color:#fff3e7;
      }
      .content{
        padding: 0;
        /* background-color: transparent; */
      }
    }

   
    .content {
      background-color: #fff3e7;
      box-shadow: 0px 3px 15px rgba(0, 0, 0, 0.2);
      padding-top: 19vh;
      padding-bottom: 19vh;
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
