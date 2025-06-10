<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>You are Invited</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css" />
  <link href="styles.css" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />
  <link href='https://fonts.googleapis.com/css?family=Dancing Script&effect=emboss' rel='stylesheet'>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <link href="https://fonts.cdnfonts.com/css/goladon" rel="stylesheet">

  <style>
    body {
      animation: fadeInAnimation ease 3s;
      animation-iteration-count: 1;
      animation-fill-mode: forwards;
    }

    input[type=radio] {
      accent-color: #c19c60;
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
    @media (max-width: 300px) {
    
    
    }
    @media (min-width: 992px) {

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
        color:#c19c60;
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
      font-family: 'Dancing Script';
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
      height: 100%;
      background-color: rgb(0, 0, 0, 30%);
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
                      $('#successModal').modal('show');
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
      $('#alreadySubmittedModal').on('click', '#closeAlreadySubmittedModal', function() {
        $('#alreadySubmittedModal').css('display', 'none');
        // Additional actions you may want to perform when the modal is closed
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
          <li class="nav-item"><a class="nav-link " href="details.html">Wedding Details</a></li>
          <li class="nav-item"><a class="nav-link " href="#rsvp"> RSVP</a></li>
        </ul>
      </div>

    </div>
  </nav>


  <div class="container-fluid story" id="rsvp">
    <div class="container content " height="200vh">

      <div class="container-fluid " data-aos="fade-up" style="background-color:#263a45; margin-top:3%; height:70vh; width:80vw; padding:4vw; border-radius: 1pc;">

        <div class="container">
          <h2 class="h2 text-center">
            Find your name on the list.
          </h2>
          <br>
          <form id="getUserForm" action="process.php" method="POST">
            <span style="font-family: 'Dancing Script';">

              <div class="mb-3 ">
                <label for="first_name" class="form-label" style="color: #fff3e7;">First Name:</label>
                <input type="text" class="form-control" id="first_name" name="first_name" required>
              </div>
              <div class="mb-3  d-flex flex-column">
                <label for="last_name" class="form-label" style="color: #fff3e7;">Last Name:</label>
                <input type="text" class="form-control" id="last_name" name="last_name" required>
              </div>
              <div style="text-align:center;">
                <button type="submit" class="btn mx-auto" style="background-color: #c19c60; color:#fff3e7; 
      font-family: 'Goladon', sans-serif;">Submit</button>
              </div>

            </span>
          </form>
        </div>
      </div>


      <!-- Modal container -->
      <div class="container-fluid">

        <div class="modal container-fluid " id="userModal" style="display: none; ">
          <div class="modal-content container  aos-init aos-animate" data-aos="fade-down">
            <span class="close" id="closeModal" width="100px ">&times;</span>

            <form class='form' action='check_response.php' method='POST'>
              <input type='hidden' name='id' id='userId' value=''>
              <table id='myTable' class='table table-bordered d-flex justify-content-center '>

                <div>
                  <p>
                    <tbody id="modalContent"></tbody> <!-- User data will be populated here -->
                  </p>
                </div>
              </table>
              <div class='d-flex justify-content-center flex-row'>
                <div>
                  <div class="d-flex flex-row form">
                    <div>
                      <h3>Are you</h3>
                    </div>
                    <div>
                      <h3 style="margin-left: 20px;">
                        <label for="comingRadio">Coming</label>
                        <input type='radio' id="comingRadio" name='action' style="width:20px; height:20px;" value='Coming'>
                      </h3>

                      <h3 style="margin-bottom: 12%;"> <label for="notComingRadio">Not Coming</label>
                        <input type='radio' id="notComingRadio" name='action' style="width:20px; height:20px;" style="font-family: 'Goladon', sans-serif;" value='Not Coming'>

                        ?
                      </h3>

                    </div>

                  </div>
                </div>
              </div>
              <div class="container text-end">
                <input style="font-family: 'Goladon', sans-serif; background-color:#152630;color:#c19c60;" class='btn btn-primary' type='submit' value='Submit'>

              </div>

            </form>

          </div>
        </div>

        <!-- "You have already submitted a response" modal -->
        <div class="modal" id="alreadySubmittedModal" style="display: none; ">
          <div class="modal-content container" style="background-color:#263a45;">
            <div class="modal-body lbl-inp">
              <h3>
                You have already submitted a response. Thank you!
              </h3>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn " type="button" style="background-color: #c19c60; color:#fff3e7;" id="closeAlreadySubmittedModal" aria-label="Close">Okay</button>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
  <div class="container-fluid">
    <div class="modal" id="successModal" style="display: none;">

      <div class="modal-content container">
        <div class="modal-header">
          <span class="close" id="closeModal" width="100px ">&times;</span>
        </div>
        <div class="modal-body">
          <p>Thank you for confirming your attendance! We're so excited to celebrate our wedding with you. Please don't forget to bring any ID and follow the dress code. See you there!</p>
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