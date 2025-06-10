<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>You are Invited</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="../../assets/vendor/aos/dist/aos.css">
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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
    $(document).ready(function() {
      var userId; // Variable to store the user's ID

      $('#getUserForm').submit(function(event) {
        event.preventDefault();

        $.ajax({
          type: 'POST',
          url: 'process.php',
          data: $('#getUserForm').serialize(),
          success: function(response) {
            try {
              var responseObj = JSON.parse(response);

              if ("id" in responseObj) {
                userId = responseObj.id; // Store the user's ID

                if (userId > 0) {
                  // Fetch user data using another AJAX request
                  $.ajax({
                    type: 'POST',
                    url: 'fetch_user_data.php',
                    data: {
                      id: userId
                    },
                    success: function(userData) {
                      // Display the fetched data
                      $('#modalContent').html(userData);

                      // Show the modal
                      $('#userModal').css('display', 'block');
                    }
                  });
                } else {
                  alert("User not found.");
                }
              } else if ("error" in responseObj) {
                alert(responseObj.error);
              }
            } catch (error) {
              console.error("Error parsing JSON: " + error);
            }
          }
        });
      });

      $('#closeModal').click(function() {
        $('#userModal').css('display', 'none');
      });

      // Show the confirmation modal when the "Submit" button is clicked
      $('#userModal').on('submit', 'form', function(event) {
        event.preventDefault();

        var selectedAction = $('input[name="action"]:checked').val();

        if (selectedAction) {
          // Check if the user has already submitted a response
          $.ajax({
            type: 'POST',
            url: 'check_response.php',
            data: {
              id: userId,
            },
            success: function(response) {
              if (response === 'not_submitted') {
                // The user has not submitted a response, proceed to save it
                $.ajax({
                  type: 'POST',
                  url: 'add.php',
                  data: {
                    id: userId,
                    action: selectedAction,
                  },
                  success: function(addResponse) {
                    if (addResponse === 'response_added') {
                      // Response submitted successfully
                      alert("Error submitting response.");
                      // Additional actions can be added here
                    } else {
                      // Handle errors from add.php
                      alert("Response submitted successfully.");
                    }
                  }
                });
              } else if (response === 'already_submitted') {
                // Display a modal message saying "you have already submitted a response"
                $('#alreadySubmittedModal').css('display', 'block');
              } else {
                // Handle other responses if needed
                alert("Unexpected response: " + response);
              }
            }
          });
        } else {
          // Handle the case where the user hasn't selected a response
          alert("Please select a response before submitting.");
        }
      });

      // Close the "You have already submitted a response" modal when the "Okay" button is clicked
      $('#closeAlreadySubmittedModal').click(function() {
        $('#alreadySubmittedModal').css('display', 'none');
      });
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

  $sql = "SELECT * FROM attendees";
  $result = $conn->query($sql);

  if ($result === false) {
    die("Query execution failed: " . $conn->error);
  }
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
          <li class="nav-item"><a class="nav-link " href="details.html">Wedding Details</a></li>
          <li class="nav-item"><a class="nav-link "> RSVP</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container-fluid welcome">
    <div class="container-fluid " data-aos="zoom-in" style="background-color:#af8d6b; height:30vh; ">
      <div class="container">
        <form id="getUserForm" action="process.php" method="POST">
          <div>
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" required> <br>
          </div>
          <div>
            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" required>
          </div>
          <div>
            <input type="submit" class="btn btn-primary" value="Get ID">

          </div>
        </form>
      </div>

    </div>
    <!-- Modal container -->
    <div class="container-fluid">

      <div class="modal container " id="userModal" style="display: none; ">
        <div class="modal-content">
          <span class="close" id="closeModal">&times;</span>

          <form class='form' action='check_response.php' method='POST'>
            <input type='hidden' name='id' id='userId' value=''>
            <table id='myTable' class='table table-bordered'>
              <thead>
                <tr>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody id="modalContent">
                <!-- User data will be populated here -->
                <label for="comingRadio">Coming</label>
                <input type='radio' id="comingRadio" name='action' value='Coming'>
                <label for="notComingRadio">Not Coming</label>
                <input type='radio' id="notComingRadio" name='action' value='Not Coming'>
                <input class='btn btn-primary' type='submit' value='Submit'>
              </tbody>
            </table>
          </form>

        </div>
      </div>

      <!-- "You have already submitted a response" modal -->
      <div class="modal" id="alreadySubmittedModal" style="display: none;">
        <div class="modal-content">
          <span class="close" id="closeAlreadySubmittedModal">&times;</span>
          <div class="modal-body">
            You have already submitted a response.
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="closeAlreadySubmittedButton">Okay</button>
          </div>
        </div>
      </div>
    </div>
  </div>


  </div>
  </div>

  <!-- Modal for Confirmation Message -->
  <div class="modal" id="confirmationModal" style="display: none;">
    <div class="modal-content">
      <span class="close" id="closeConfirmationModal">&times;</span>
      <div class="modal-body">
        <p>We are expecting you!</p>
      </div>
      <div class="modal-footer">
        <button type="button" id="editButton">Edit</button>
        <button type="button" id="okayButton">Okay</button>
      </div>
    </div>
  </div>


  <div class="container-fluid Head" style="background-image:url('ABC01003.JPG')">
    <div class="overlay container-fluid"></div>
  </div>
  <script src="../../assets/vendor/aos/dist/aos.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/scripts.js"></script>
  <script>
  $(document).on('ready', function () {
    // initialization of aos
    AOS.init({
      duration: 650,
      once: true
    });
  });
</script>
</body>


</html>