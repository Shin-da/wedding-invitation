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
  <div class="form-container">
	<p class="title">Login</p>
	<form class="form">
		<div class="input-group">
			<label for="username">Username</label>
			<input type="text" name="username" id="username" placeholder="">
		</div>
		<div class="input-group">
			<label for="password">Password</label>
			<input type="password" name="password" id="password" placeholder="">
			<div class="forgot">
				<a rel="noopener noreferrer" href="#">Forgot Password ?</a>
			</div>
		</div>
		<button class="sign">Sign in</button>
	</form>
	<div class="social-message">
		<div class="line"></div>
		<p class="message">Login with social accounts</p>
		<div class="line"></div>
	</div>
	<div class="social-icons">
		<button aria-label="Log in with Google" class="icon">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" class="w-5 h-5 fill-current">
				<path d="M16.318 13.714v5.484h9.078c-0.37 2.354-2.745 6.901-9.078 6.901-5.458 0-9.917-4.521-9.917-10.099s4.458-10.099 9.917-10.099c3.109 0 5.193 1.318 6.38 2.464l4.339-4.182c-2.786-2.599-6.396-4.182-10.719-4.182-8.844 0-16 7.151-16 16s7.156 16 16 16c9.234 0 15.365-6.49 15.365-15.635 0-1.052-0.115-1.854-0.255-2.651z"></path>
			</svg>
		</button>
		<button aria-label="Log in with Twitter" class="icon">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" class="w-5 h-5 fill-current">
				<path d="M31.937 6.093c-1.177 0.516-2.437 0.871-3.765 1.032 1.355-0.813 2.391-2.099 2.885-3.631-1.271 0.74-2.677 1.276-4.172 1.579-1.192-1.276-2.896-2.079-4.787-2.079-3.625 0-6.563 2.937-6.563 6.557 0 0.521 0.063 1.021 0.172 1.495-5.453-0.255-10.287-2.875-13.52-6.833-0.568 0.964-0.891 2.084-0.891 3.303 0 2.281 1.161 4.281 2.916 5.457-1.073-0.031-2.083-0.328-2.968-0.817v0.079c0 3.181 2.26 5.833 5.26 6.437-0.547 0.145-1.131 0.229-1.724 0.229-0.421 0-0.823-0.041-1.224-0.115 0.844 2.604 3.26 4.5 6.14 4.557-2.239 1.755-5.077 2.801-8.135 2.801-0.521 0-1.041-0.025-1.563-0.088 2.917 1.86 6.36 2.948 10.079 2.948 12.067 0 18.661-9.995 18.661-18.651 0-0.276 0-0.557-0.021-0.839 1.287-0.917 2.401-2.079 3.281-3.396z"></path>
			</svg>
		</button>
		<button aria-label="Log in with GitHub" class="icon">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" class="w-5 h-5 fill-current">
				<path d="M16 0.396c-8.839 0-16 7.167-16 16 0 7.073 4.584 13.068 10.937 15.183 0.803 0.151 1.093-0.344 1.093-0.772 0-0.38-0.009-1.385-0.015-2.719-4.453 0.964-5.391-2.151-5.391-2.151-0.729-1.844-1.781-2.339-1.781-2.339-1.448-0.989 0.115-0.968 0.115-0.968 1.604 0.109 2.448 1.645 2.448 1.645 1.427 2.448 3.744 1.74 4.661 1.328 0.14-1.031 0.557-1.74 1.011-2.135-3.552-0.401-7.287-1.776-7.287-7.907 0-1.751 0.62-3.177 1.645-4.297-0.177-0.401-0.719-2.031 0.141-4.235 0 0 1.339-0.427 4.4 1.641 1.281-0.355 2.641-0.532 4-0.541 1.36 0.009 2.719 0.187 4 0.541 3.043-2.068 4.381-1.641 4.381-1.641 0.859 2.204 0.317 3.833 0.161 4.235 1.015 1.12 1.635 2.547 1.635 4.297 0 6.145-3.74 7.5-7.296 7.891 0.556 0.479 1.077 1.464 1.077 2.959 0 2.14-0.020 3.864-0.020 4.385 0 0.416 0.28 0.916 1.104 0.755 6.4-2.093 10.979-8.093 10.979-15.156 0-8.833-7.161-16-16-16z"></path>
			</svg>
		</button>
	</div>
	<p class="signup">Don't have an account?
		<a rel="noopener noreferrer" href="#" class="">Sign up</a>
	</p>
</div>
  <div class="container-fluid welcome">
    <div class="container-fluid " data-aos="zoom-in" style="background-color:#af8d6b; height:40vh; width:60vw; padding:4vw;">
      <div class="container">
        <form id="getUserForm"  action="process.php" method="POST">
          <div style="margin:1vw;">
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" required> <br>
          </div>
          <div style="margin:1vw;">
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