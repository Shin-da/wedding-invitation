<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>You are Invited</title>
  <link href="css/styles.css" rel="stylesheet" />
  <link href='https://fonts.googleapis.com/css?family=Dancing Script&effect=emboss' rel='stylesheet'>
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      animation: fadeInAnimation ease 3s;
      animation-iteration-count: 1;
      animation-fill-mode: forwards;
    }

    @keyframes fadeInAnimation {
      0% {
        opacity: 0;
      }

      100% {
        opacity: 1;
      }
    }
  </style>
 
</head>

<body class="fadeOut">
<?php
  $hostname = "localhost";
  $username = "root";
  $password = "";
  $dbname = "wedding";
  $conn = new mysqli($hostname, $username, $password, $dbname);


  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id = $_GET['id'];
    $sql = "DELETE FROM Products WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
      echo "Record deleted successfully";
    } else {
      echo "Error deleting record: " . $conn->error;
    }
  }

  $sql = "SELECT * FROM Products";
  $result = $conn->query($sql);

  ?>
  <!-- BACKGROUND MUSIC -->
  <!-- <audio src="buttercup.mp3" autoplay loop></audio> -->

  <nav class="navbar navbar-expand-lg navbar fixed-top" id="mainNav">
    <div class="container px-4 px-lg-5">
     
      <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse"
        data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
        aria-label="Toggle navigation">
        Menu
        <i class="fas fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link " href="index.html">Our Story</a></li>
          <li class="nav-item"><a class="nav-link " href="index2.html">Guest List</a></li>
          <li class="nav-item"><a class="nav-link " href="#details">Wedding Details</a></li>
          <li class="nav-item"><a class="nav-link " href="#details"> RSVP</a></li>
        </ul>
      </div>
    </div>
  </nav>


  <div class="container-fluid welcome" id="entourage">
    <div class="container" style="background-color:#af8d6b; margin-top:1vh;">
      <table id="myTable" class="table table-bordered">
        <thead>
          <tr>
            <th></th>
            <th>Name</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              echo "<tr>
                <td>" . $row["id"] . "</td>
                <td>" . $row["name"] . "</td>
                <td class='action'>
                <th>Option 1</th>
                        <th>Option 2</th>
                </td>
            </tr>";
            }
          } else {
            echo "0 results";
          }
          $conn->close();
          ?>
        </tbody>
      </table>
    </div>
  </div>

    <div class="container-fluid Head" >
      <div class="overlay container-fluid"></div>
    </div>





  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/scripts.js"></script>
</body>


</html>