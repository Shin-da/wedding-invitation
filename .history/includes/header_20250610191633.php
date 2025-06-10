<?php
// Check if title is set
$pageTitle = isset($pageTitle) ? $pageTitle : "Wedding Invitation";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/fonts.css">
    <link href='https://fonts.googleapis.com/css?family=Dancing Script&effect=emboss' rel='stylesheet'>
    <link href="https://fonts.cdnfonts.com/css/edu-sa-beginner" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/simple-home" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />
    <link href="https://fonts.cdnfonts.com/css/herova" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar fixed-top" id="mainNav" style="background-color:#152630;">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="#page-top"></a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
                aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link list-link" href="/">Home</a></li>
                    <li class="nav-item"><a class="nav-link list-link" href="/pages/ourstory.html">Our Story</a></li>
                    <li class="nav-item"><a class="nav-link list-link" href="/pages/details.html">Wedding Details</a></li>
                    <li class="nav-item"><a class="nav-link list-link" href="/pages/rsvp.php">RSVP</a></li>
                    <li class="nav-item"><a class="nav-link list-link" href="/pages/weddingTimeline.html">Wedding Timeline</a></li>
                </ul>
            </div>
        </div>
    </nav>
