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
    input[type=radio] {
      accent-color: #c19c60;
    }

    .input,
    .inputR {
      -webkit-appearance: none;
      -moz-appearance: none;
      appearance: none;

      border-radius: 50%;
      width: 20px;
      height: 20px;

      border: 2px solid #999;
      transition: 0.2s all linear;
      margin-right: 5px;

      position: relative;
      top: 4px;
    }

    .input:checked {
      border: 6px solid #c19c60;
      outline: unset !important
        /* I added this one for Edge (chromium) support */
    }

    .inputR:checked {
      border: 6px solid #4a0a0a;
      outline: unset !important
        /* I added this one for Edge (chromium) support */
    }

    @keyframes fadeInAnimation {
      0% {
        opacity: 0;
      }

      100% {
        opacity: 1;
      }
    }

    #mainNav {
      min-height: 3.5rem;
      font-family: 'Dancing Script';
      background-color: #152630;

    }

    @media (min-width: 992px) {
      #mainNav {
        padding-top: 0;
        padding-bottom: 0;
        border-bottom: none;
        transition: background-color 0.3s ease-in-out;
      }

      /* BOOKMARK */
      #mainNav .navbar-brand {
        padding: 0.5rem 0;
        color: #f9f9f9;
      }

      #mainNav .nav-link {
        transition: none;
        padding: 2rem 1.5rem;
        color: #fff3e7;
        font-family: 'Dancing Script';
        display: flex;
        justify-content: center;
      }

      /* hover li */
      #mainNav .nav-link:hover {
        color: rgb(193, 153, 126);
      }

      #mainNav .nav-link:active {
        color: rgb(193, 153, 126);

      }

      /* bookmark */
      #mainNav.navbar-shrink {

        background-color: #152630;
      }

      #mainNav.navbar-shrink .navbar-brand {
        color: #f9f9f9;

      }

      #mainNav.navbar-shrink .nav-link {
        color: #f9f9f9;

        padding: 1.5rem 1.5rem 1.25rem;
        border-bottom: 0.25rem solid transparent;
      }

      #mainNav.navbar-shrink .nav-link:hover {
        color: rgb(193, 153, 126);
      }

      #mainNav.navbar-shrink .nav-link:active {
        color: rgb(193, 153, 126);

      }

      #mainNav.navbar-shrink .nav-link.active {
        color: rgb(193, 153, 126);

        outline: none;
        border-bottom: 0.25rem solid rgb(193, 153, 126);
        ;
      }
    }

    /* Modal styles */
    .form h3 {
      font-family: 'Dancing Script';
      font-size: 29px;
      color: #264653;
    }


    .lbl-inp {
      padding: 50px;
    }

    .lbl-inp h3 {
      /* font-family: 'Goladon', sans-serif; */
      font-size: 22px;
      color: #c19c60;
    }

    .modal {
      display: none;
      position: absolute;
      z-index: 1;
      left: 0;
      top: 0;
      width: 100%;
      height: 140%;
      background-color: rgb(0, 0, 0, 30%);
    }

    .modal-content {
      top: 25%;
    }

    .firstform {
    background-color: #263a45;
    margin-top: 3%;
    width: 60vw;
    padding: 7vw;
    border-radius: 1pc;
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
        background-color: transparent;
      }
    }

    /* Close button */

    .close {
      border-radius: 2px;
      width: 50px;
      height: 50px;
      position: absolute;
      top: 12px;
      right: 12px;
      background-color: rgb(172, 94, 78);
      color: rgb(255, 255, 255);
      float: right;
      font-size: 28px;
      font-weight: bold;
      text-align: center;
    }

    .close:hover {
      color: black;

      background-color: rgb(140, 82, 70);
      text-decoration: none;
      cursor: pointer;
    }

    /* Add this in your <style> or custom CSS file */
    #closeRSVPForm {
      cursor: pointer;
      font-size: 24px;
      color: #aaa;
      position: absolute;
      top: 10px;
      right: 10px;
    }

    #closeRSVPForm:hover {
      color: #333;
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
