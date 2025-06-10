<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>You are Invited</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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


  $name = "name";
  $sql = "SELECT * FROM attendees";

  ?>
  <!-- BACKGROUND MUSIC -->
  <!-- <audio src="buttercup.mp3" autoplay loop></audio> -->

  <nav class="navbar navbar-expand-lg navbar fixed-top" id="mainNav">
    <div class="container px-4 px-lg-5">

      <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        Menu
        <i class="fas fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link " href="index.html">Our Story</a></li>
          <li class="nav-item"><a class="nav-link " href="index2.html">Guest List</a></li>
          <li class="nav-item"><a class="nav-link " href="details.html">Wedding Details</a></li>
          <li class="nav-item"><a class="nav-link "> RSVP</a></li>
          <li class="nav-item"><a class="nav-link " href="attendees.php"> Attendees</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container-fluid welcome" id="entourage">
    <div class="container" style="background-color:#af8d6b; margin-top:1vh;">
      <div class="container">
        <h1 class="name" style="font-size: 4vw;">You are Invited</h1>
        <input class="form-control" id="myInput" type="text" placeholder="Search for your name..">
        <br>
      </div>
      <script>
        $(document).ready(function() {
          $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable tbody tr").filter(function() {
              $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
          });
        });
      </script>

<form class="form" action="update.php" method="POST">
<input type="hidden" name="id" value="<?php echo $id; ?>">
      <table id="myTable" class="table table-bordered">
        <thead>
          <tr>

            <th>Name</th>
            <th>Option 1</th>
                        <th>Option 2</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              echo "<tr>
                    <td>" . $row["name"] . "</td>
                    <td><input type='radio' name='choice1' value='option1'></td>
                    <td><input type='radio' name='hoice1' value='option2'> </td>
                  </tr>";
            }
          } else {
            echo "0 results";
          }

          $conn->close();
          ?>
        </tbody>
      </table>
      <input class="btn btn-primary" type="submit" value="Update" onclick="location.href='attendees.php?id=<?php echo $id; ?>'">
      </form>
    </div>
  </div>

  <div class="container-fluid Head">
    <div class="overlay container-fluid"></div>
  </div>





  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/scripts.js"></script>
</body>


</html>