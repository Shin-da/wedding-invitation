<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>You are Invited</title>
  <link href="styles.css" rel="stylesheet" />
  <link href='https://fonts.googleapis.com/css?family=Dancing Script&effect=emboss' rel='stylesheet'>
  <link rel="stylesheet" href="style.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
  <script>
  $(document).ready(function () {
    // Check if the "showModal" parameter is set to "true"
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('showModal') === 'true') {
      $('#confirmationModal').modal('show');
    }
  });
</script>
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

  $showModal = isset($_GET['showModal']) ? $_GET['showModal'] : false;

  $name = "name";
  $sql = "SELECT * FROM attendees";

  ?>

  <!-- Modal -->
  
<?php if ($showModal): ?>
    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="confirmationModalLabel">Confirmation Message</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            We are expecting you!
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>
  <script>
  // Wait for the document to be ready
  $(document).ready(function() {
    // Add an event listener for when the close button is clicked
    $(".close").click(function() {
      // Select the modal element and hide it
      $("#confirmationModal").modal("hide");
    });

    // Add an event listener for when the "Close" button is clicked
    $(".btn-primary").click(function() {
      // Select the modal element and hide it
      $("#confirmationModal").modal("hide");
    });
  });
</script>

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
          <li class="nav-item"><a class="nav-link "href="rsvp.php"> RSVP</a></li>
        </ul>
      </div>
    </div>
  </nav><div class="container-fluid welcome" id="entourage">
  <div class="container" style="background-color:#af8d6b; margin-top:1vh;">
    <div class="container">
      <h1 class="name" style="font-size: 4vw;">Attendees</h1>
    </div>
    <table id="myTable" class="table table-bordered">
      <thead>
        <tr>
          <th>Name</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql = "SELECT * FROM attendees WHERE action = 'Coming'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo "<tr>
                  <td>" . $row["name"] . "</td>
                </tr>";
          }
        } else {
          echo "No attendees have accepted the invitation.";
        }

        $conn->close();
        ?>
      </tbody>
    </table>
  </div>
</div>


  <div class="container-fluid Head">
    <div class="overlay container-fluid"></div>
  </div>





  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/scripts.js"></script>
</body>


</html>