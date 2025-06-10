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
<div class="modal" id="userModal" style="display: none;">
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
        </tbody>
      </table>
      <input class='btn btn-primary' type='submit' value='Submit'>
    </form>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            var userId; // Variable to store the user's ID

            $('#getUserForm').submit(function (event) {
                event.preventDefault();

                $.ajax({
                    type: 'POST',
                    url: 'process.php',
                    data: $('#getUserForm').serialize(),
                    success: function (response) {
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
                                        }, // Send the ID to fetch_user_data.php
                                        success: function (userData) {
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

            $('#closeModal').click(function () {
                $('#userModal').css('display', 'none');
            });
        });
    </script>

  <!-- Modal -->
  <?php
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "wedding";

// ... your database connection code ...

$showModal = false; // Initialize the $showModal variable

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];

    $sql = "SELECT id FROM attendees WHERE first_name = ? AND last_name = ?";
    
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ss", $first_name, $last_name);
        $stmt->execute();
        $stmt->bind_result($id);
        $stmt->fetch();
        
        if ($id !== null) {
            echo json_encode(["id" => $id]);

            // Set $showModal to true when the user is found
            $showModal = true;
        } else {
            echo json_encode(["error" => "User not found"]);
        }

        $stmt->close();
    } else {
        echo json_encode(["error" => "Error in the SQL query: " . $conn->error]);
    }
    
    // Close the database connection
    $conn->close();
}
?>

<!-- ... your HTML and JavaScript code ... -->

<?php if ($showModal): ?>
  <!-- Display the confirmation modal when $showModal is true -->
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
Make sure that the JavaScript and HTML code are properly integrated into your web page. If you're still experiencing issues, please provide any error messages or additional details to help identify the problem.






  <script>
  $(document).ready(function () {
    var userId; // Variable to store the user's ID

    $('#getUserForm').submit(function (event) {
        event.preventDefault();

        $.ajax({
            type: 'POST',
            url: 'process.php',
            data: $('#getUserForm').serialize(),
            success: function (response) {
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
                                success: function (userData) {
                                    // Display the fetched data
                                    $('#modalContent').html(userData);

                                    // Show the modal
                                    $('#userModal').css('display', 'block');

                                    // Check if "Coming" is selected and show the confirmation modal
                                    $('#userModal form').submit(function (event) {
                                        event.preventDefault();
                                        var selectedAction = $('input[name="action[' + userId + '"]:checked').val();
                                        if (selectedAction === 'Coming') {
                                            // Display the confirmation modal
                                            $('#confirmationModal').modal('show');
                                        }
                                    });
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

    $('#closeModal').click(function () {
        $('#userModal').css('display', 'none');
    });

    // Add an event listener for when the close button is clicked in the confirmation modal
    $('#confirmationModal .close').click(function () {
        // Select the confirmation modal and hide it
        $('#confirmationModal').modal('hide');
    });

    // Add an event listener for when the "Close" button is clicked in the confirmation modal
    $('#confirmationModal .btn-primary').click(function () {
        // Select the confirmation modal and hide it
        $('#confirmationModal').modal('hide');
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