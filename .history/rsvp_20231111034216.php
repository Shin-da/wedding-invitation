<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>You are Invited</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

  <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />
  <link href="styles.css" rel="stylesheet" />
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

    #mainNav {
      min-height: 3.5rem;
      font-family: 'Dancing Script';
      background-color: #fff3e7;

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
        color: #000;
      }

      #mainNav .nav-link {
        transition: none;
        padding: 2rem 1.5rem;
        color: #000;
        font-family: 'Dancing Script';
      }

      /* hover li */
      #mainNav .nav-link:hover {
        color: rgb(193, 153, 126);
      }

      #mainNav .nav-link:active {
        color: #fff3e7;
      }

      /* bookmark */
      #mainNav.navbar-shrink {
        background: none;
        background-color: #fff3e7;
      }

      #mainNav.navbar-shrink .navbar-brand {
        color: #000;
      }

      #mainNav.navbar-shrink .nav-link {
        color: #000;
        padding: 1.5rem 1.5rem 1.25rem;
        border-bottom: 0.25rem solid transparent;
      }

      #mainNav.navbar-shrink .nav-link:hover {
        color: rgb(193, 153, 126);
      }

      #mainNav.navbar-shrink .nav-link:active {
        color: rgb(100, 75, 62);
      }

      #mainNav.navbar-shrink .nav-link.active {
        color: rgb(108, 83, 69);
        outline: none;
        border-bottom: 0.25rem solid rgb(108, 83, 69);
      }
    }
  </style>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



  <script>
    // JavaScript to handle closing the form when the close (X) button is clicked
    document.getElementById('closeRSVPForm').addEventListener('click', function() {
        document.getElementById('rsvpFormContainer').style.display = 'none';
    });

    // JavaScript to handle showing the form when the "RSVP" button is clicked
    document.getElementById('showRSVPForm').addEventListener('click', function() {
        document.getElementById('rsvpFormContainer').style.display = 'block';
    });
</script>
  <script>
    $(document).ready(function() {
      var userId; // Variable to store the user's ID

      // Function to handle form submission
      function handleFormSubmission() {
        $.ajax({
          type: 'POST',
          url: 'process.php',
          data: $('#getUserForm').serialize(),
          success: function(response) {
            processFormResponse(response);
          }
        });
      }

      // Function to process form response
      function processFormResponse(response) {
        try {
          var responseObj = JSON.parse(response);

          if ("id" in responseObj) {
            userId = responseObj.id; // Store the user's ID

            if (userId > 0) {
              fetchUserData();
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

      // Function to fetch user data
      function fetchUserData() {
        $.ajax({
          type: 'POST',
          url: 'fetch_user_data.php',
          data: {
            id: userId
          },
          success: function(userData) {
            displayUserData(userData);
          }
        });
      }

      // Function to display user data in a modal
      function displayUserData(userData) {
        $('#modalContent').html(userData);
        $('#userModal').css('display', 'block');
      }

      // Event listener for form submission
      $('#getUserForm').submit(function(event) {
        event.preventDefault();
        handleFormSubmission();
      });

      // Event listener for closing the modal
      $('#closeModal').click(function() {
        $('#userModal').css('display', 'none');
      });

      // Event listener for confirmation modal submission
      $('#userModal').on('submit', 'form', function(event) {
        event.preventDefault();
        handleConfirmationSubmission();
      });

      // Function to handle confirmation submission
      function handleConfirmationSubmission() {
        var selectedAction = $('input[name="action"]:checked').val();

        if (selectedAction) {
          checkResponse();
        } else {
          alert("Please select a response before submitting.");
        }
      }

      // Function to check user response
      function checkResponse() {
        $.ajax({
          type: 'POST',
          url: 'check_response.php',
          data: {
            id: userId,
          },
          success: function(response) {
            processCheckResponse(response);
          }
        });
      }

      // Function to process check response
      function processCheckResponse(response) {
        if (response === 'not_submitted') {
          submitResponse();
        } else if (response === 'already_submitted') {
          $('#alreadySubmittedModal').css('display', 'block');
        } else {
          alert("Unexpected response: " + response);
        }
      }

      // Function to submit user response
      function submitResponse() {
        $.ajax({
          type: 'POST',
          url: 'add.php',
          data: {
            id: userId,
            action: selectedAction,
          },
          success: function(addResponse) {
            processAddResponse(addResponse);
          }
        });
      }

      // Function to process add response
      function processAddResponse(addResponse) {
        if (addResponse === 'response_added') {
          alert("Error submitting response.");
          // Additional actions can be added here
        } else {
          alert("Response submitted successfully.");
        }
      }

      // Event listener for closing the "You have already submitted a response" modal
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

  <nav class="navbar navbar-expand-lg navbar fixed-top" id="mainNav" style="background-color:#fff3e7;  box-shadow: 0px 3px 15px rgba(0,0,0,0.2);">
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
  <div class="container-fluid story" id="details">
    <div class="container content " style=" width:100vw; 
        background-color:#fff3e7;
        padding-top:19vh;
        box-shadow: 0px 3px 15px rgba(0,0,0,0.2);">

      <button id="showRSVPForm" class="btn btn-primary">RSVP</button>

      <div class="container-fluid content" id="rsvpFormContainer" data-aos="fade-up" style="background-color:#d2b48c; height:40vh; width:60vw; padding:4vw; display: none; position: relative;">
        <button type="button" class="btn-close" aria-label="Close" id="closeRSVPForm" style="position: absolute; top: 0; right: 0;"></button>
        <div class="container">
          <form id="getUserForm" action="process.php" method="POST">
            <div class="mb-3">
              <label for="first_name" class="form-label">First Name:</label>
              <input type="text" class="form-control" id="first_name" name="first_name" required>
            </div>
            <div class="mb-3">
              <label for="last_name" class="form-label">Last Name:</label>
              <input type="text" class="form-control" id="last_name" name="last_name" required>
            </div>
            <button type="submit" class="btn btn-primary">Get ID</button>
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
  <script src="js/scripts.js"></script>

</body>


</html>