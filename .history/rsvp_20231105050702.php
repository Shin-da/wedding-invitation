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
          <li class="nav-item"><a class="nav-link " href="index2.html">Guest List</a></li>
          <li class="nav-item"><a class="nav-link " href="details.html">Wedding Details</a></li>
          <li class="nav-item"><a class="nav-link "> RSVP</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container-fluid welcome">
    <div class="container" style="background-color:#af8d6b; margin-top:1vh;">
      <div class="container">
        <form id="getUserForm" action="process.php" method="POST">
          <label for="first_name">First Name:</label>
          <input type="text" id="first_name" name="first_name" required>
          <label for="last_name">Last Name:</label>
          <input type="text" id="last_name" name="last_name" required>
          <input type="submit" value="Get ID">
        </form>
      </div>


      <!-- Modal container -->
<div class="modal" id="userModal">
    <div class="modal-content">
        <span class="close" id="closeModal">&times;</span>
        <form class='form' action='add.php' method='POST'>
            <!-- Hidden input for ID (outside the table) -->
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
                    <!-- Include the table rows here -->
                    <tr>
                        <td id="firstNameCell"></td>
                        <td id="lastNameCell"></td>
                        <td>
                            <input type='radio' name='action' value='Coming'> Coming
                            <input type='radio' name='action' value='Not Coming'> Not Coming
                        </td>
                    </tr>
                </tbody>
            </table>
            <input class='btn btn-primary' type='submit' value='Submit'>
        </form>
    </div>
</div>

   
<script>
    // Wait for the document to be fully loaded
$(document).ready(function () {
    // When the "Get ID" button is clicked
    $('#getUserForm input[type="submit"]').click(function (event) {
        event.preventDefault();

        // Log the form data being sent
        console.log("Form data:", $('#getUserForm').serialize());

        // Fetch the user data using AJAX
        $.ajax({
            type: 'POST',
            url: 'process.php',
            data: $('#getUserForm').serialize(),
            success: function (response) {
                console.log("Response from process.php:", response); // Log the response

                try {
                    var responseObj = JSON.parse(response);

                    if ("id" in responseObj) {
                        var id = responseObj.id;

                        if (id > 0) { // Check if a valid ID is returned
                            var userData = responseObj.userData;

                            // Populate the user data in the modal
                            var modalContent = $('#modalContent');
                            modalContent.empty(); // Clear any existing rows

                            // Set the user ID in the hidden input
                            $('#userId').val(id);

                            // Show the modal
                            $('#userModal').css('display', 'block');
                            
                            // Populate the first name and last name
                            $('#firstNameCell').text(userData.first_name);
                            $('#lastNameCell').text(userData.last_name);
                            
                            // Add radio buttons for actions
                            modalContent.append(
                                "<tr>" +
                                "<td> . $row["first_name"] . </td>" +
                                "<td>" + userData.last_name + "</td>" +
                                "<td>" +
                                "<input type='radio' name='action[" + id + "]' value='Coming'> Coming " +
                                "<input type='radio' name='action[" + id + "]' value='Not Coming'> Not Coming " +
                                "</td>" +
                                "</tr>"
                            );
                        } else {
                            // Handle the case where a valid user ID is not found
                            alert("User not found.");
                        }
                    } else if ("error" in responseObj) {
                        // Handle the error case
                        alert(responseObj.error);
                    }
                } catch (error) {
                    console.error("Error parsing JSON: " + error);
                }
            }
        });
    });

    // Close the modal when the close button is clicked
    $('#closeModal').click(function () {
        $('#userModal').css('display', 'none');
    });
});

</script>



    </div>
  </div>
  <div class="container-fluid Head" style="background-image:url('ABC01003.JPG')">
    <div class="overlay container-fluid"></div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/scripts.js"></script>
</body>


</html>