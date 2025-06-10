<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>You are Invited</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />
  <link href="styles.css" rel="stylesheet" />
  <link href='https://fonts.googleapis.com/css?family=Dancing Script&effect=emboss' rel='stylesheet'>

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
        color: rgb(193, 153, 126);
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
        background: none;
        background-color: #224156;
      }

      #mainNav.navbar-shrink .navbar-brand {
        color: rgb(193, 153, 126);

      }

      #mainNav.navbar-shrink .nav-link {
        color: rgb(193, 153, 126);

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
  </style>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
    $(document).ready(function() {
      // Event listener for the "RSVP" button click
      $('#showRSVPForm').click(function() {
        // Show the RSVP form container
        $('#rsvpFormContainer').show();
      });

      // Event listener for the close (X) button click
      $('#closeRSVPForm').click(function() {
        // Hide the RSVP form container
        $('#rsvpFormContainer').hide();
      });

      // Rest of your existing JavaScript code...
    });
  </script>

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

  <nav class="navbar navbar-expand-lg navbar fixed-top" id="mainNav" style=" box-shadow: 0px 3px 15px rgba(0,0,0,0.2);">
    <div class="container px-4 px-lg-5">

      <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        Menu
        <i class="fas fa-bars"></i>
      </button>

      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link " href="index.html"> Home</a></li>
          <li class="nav-item"><a class="nav-link " href="ourstory.html" style="-color:#123;">Our Story</a></li>
          <li class="nav-item"><a class="nav-link " href="#details">Wedding Details</a></li>
          <li class="nav-item"><a class="nav-link " href="#rsvp"> RSVP</a></li>
        </ul>
      </div>

    </div>
  </nav>


  <div class="container-fluid story" id="rsvp">
    <div class="container content ">

      <div class="container-fluid content" data-aos="fade-up" style="background-color:#263a45; margin-top:3%; height:70vh; width:80vw; padding:4vw; border-radius: 1pc;">

        <div class="container" >
          <h2 class="h2">
            Find your name on the list.
          </h2>
          <br>
          <form id="getUserForm" action="process.php" method="POST">
            <div class="mb-3">
              <label for="first_name" class="form-label" style="color: #fff3e7;">First Name:</label>
              <input type="text" class="form-control" id="first_name" name="first_name" required>
            </div>
            <div class="mb-3">
              <label for="last_name" class="form-label"  style="color: #fff3e7;">Last Name:</label>
              <input type="text" class="form-control" id="last_name" name="last_name" required>
            </div>
            <button type="submit" class="btn " style="background-color: #c19c60; ">Submit</button>
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


                <!-- User data will be populated here -->
                <div>
                <tbody id="modalContent"></tbody>

                  <label for="comingRadio">Coming</label>
                  <input type='radio' id="comingRadio" name='action' value='Coming'>
                  <label for="notComingRadio">Not Coming</label>
                  <input type='radio' id="notComingRadio" name='action' value='Not Coming'>
                  <input class='btn btn-primary' type='submit' value='Submit'>
                </div>
               

              </table>
            </form>

          </div>
        </div>

        <!-- "You have already submitted a response" modal -->
        <div class="modal" id="alreadySubmittedModal" style="display: none;">
          <div class="modal-content">
            <span class="close" id="closeAlreadySubmittedModal">&times;</span>
            <div class="modal-body">
              You have already submitted a response. Thank you!
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" type="button" id="closeAlreadySubmittedModal" aria-label="Close">Okay</button>
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

  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <!-- <script src="http://localhost:3002/dist/aos.js"></script> -->

  <script>
    AOS.init({
      easing: 'ease-out-back',
      duration: 1000
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="scripts.js"></script>

</body>


</html>