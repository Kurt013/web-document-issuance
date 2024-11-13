<!DOCTYPE html>
<html lang="en" id="html">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  <link rel="stylesheet" href="styles.css">
  <title>Footer at Bottom</title>
</head>
<style>
    /* Ensure the body takes up the full height of the viewport */
/* Ensure the body takes up the full height of the viewport */


/* Main content section */
/* Ensure the body takes up the full height of the viewport */


/* Main content section */
@font-face {
            font-family: 'OSMedium'; 
            src: url('fonts/OpenSauceSans-Medium.ttf') format('truetype'); 
        }

html, body {
  height: 100%;
  margin: 0;
  box-sizing: border-box;
}

/* Footer styling (placed at the bottom of the page) */
#footerend {
    background-color: #01439c;
  color: #fff;
  padding: 20px;
  line-height: 25px;
  text-align: center;
  width: calc(100% - 250px); /* Adjust width to account for the left margin */
  margin-left: 250px;
  margin-top: 50px; /* Ensures the footer is pushed to the bottom */
  box-sizing: border-box; /* Prevents overflow by including padding and borders in width */
  font-family: "OSMedium";
}

/* Footer container, icons, and layout styling remain the same */
#footer-container {
  display: flex;
  justify-content: space-between;
  align-items: center;
  max-width: 100%;
  padding: 0 15px; /* Add some padding to prevent content from touching edges */
  box-sizing: border-box; /* Ensures padding is included in the container's width calculation */
  margin: 0 auto;
}

/* Left Section: Logo and Contact Info */
#footer-left {
  flex: 1;
  text-align: left;
}



#footer-left .location, .footer-left .email {
 
}

#footer-left i {
    margin-right: 10px;
    font-size: 18px;
}

#footer-left a {
  color: #fff;
  text-decoration: none;
}

/* Right Section: Social Icons and Copyright */
#footer-right {
  flex: 1;
  text-align: right;
}

#social-icons a {
  color: #fff;
  margin: 0 5px;
  font-size: 20px;
  text-decoration: none;


            
}

#social-icons a:hover {
  color: #4CAF50; /* Change color on hover */
}

/* Copyright */
#footerend p {
  margin-top: 10px;
  font-size: 14px;
}



</style>
<body id= "body">



  <!-- Footer Section -->
  <footer id = "footerend">
    <div id="footer-container">
      <!-- Left Side: Location and Contact Info -->
      <div id="footer-left">
        
        <p class="location"><i class="fas fa-map-marker-alt"></i> Brgy. Sinalhan, Santa Rosa, Laguna, Philippines</p>
        <div>&copy; <?php echo date("Y"); ?> Barangay Management System. All Rights Reserved.</div>
      </div>

      <!-- Right Side: Social Icons and Copyright -->
      <div id="footer-right">
        <div id= cwu> 
            <p> Connect with us!</p>
        <div id="social-icons">
          <a href="https://www.facebook.com" target="_blank"><i class="bi bi-facebook"></i></a>
          <a href="mailto:your-email@gmail.com" target="_blank"><i class="bi bi-envelope-fill"></i></a>
        </div>
        
      </div>
    </div>
  </footer>

</body>
</html>
