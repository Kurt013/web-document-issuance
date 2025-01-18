<?php 
    require './classes/main.class.php';

    $userdetails = $bmis->get_userdata();

    if (!$bmis->get_userdata()) {
        $bmis->set_userdata();
    }

    if ($userdetails) {
        if ($userdetails['role'] === 'staff' || $userdetails['role'] === 'administrator') {
            echo '<script>window.location.href="./admn_dashboard.php"</script>';
            exit;
        }
    }

    $dt = new DateTime("now", new DateTimeZone('Asia/Manila'));
    $tm = new DateTime("now", new DateTimeZone('Asia/Manila'));
    $cdate = $dt->format('Y/m/d');
    $ctime = $tm->format('H');

    
?>

 

<!DOCTYPE html> 
<html>

    <head> 
    <title> Homepage </title>
        <link rel="stylesheet" href="./css/responsive.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="./node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

        <link rel="icon" href="./assets/sinlogo.png" type="image/x-icon">

        <!-- responsive tags for screen compatibility -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link href="../BarangaySystem/customcss/pagestyle.css" rel="stylesheet" type="text/css">
        
        <link href="../BarangaySystem/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">
        
        <script src="https://kit.fontawesome.com/67a9b7069e.js" crossorigin="anonymous"></script>
        
        <?php include('loading.php'); ?>
    <style>

        @font-face {
            font-family: 'PMedium'; 
            src: url('fonts/Poppins-Medium.ttf') format('truetype'); 
        }

        @font-face {
            font-family: 'PBold'; 
            src: url('fonts/Poppins-Bold.ttf') format('truetype'); 
        }

        @font-face {
            font-family: 'PBlack'; 
            src: url('fonts/Poppins-Black.ttf') format('truetype'); 
        }

        @font-face {
            font-family: 'PExBold'; 
            src: url('fonts/Poppins-ExtraBold.ttf') format('truetype'); 
        }

        @font-face {
          font-family: 'PExBoldIt'; 
          src: url('fonts/Poppins-ExtraBoldItalic.ttf') format('truetype'); 
        }

        @font-face {
            font-family: 'PBlackIt'; 
            src: url('fonts/Poppins-BlackItalic.ttf') format('truetype'); 
        }

        @font-face {
            font-family: 'PSemiBold'; 
            src: url('fonts/Poppins-SemiBold.ttf') format('truetype'); 
        }

        @font-face {
            font-family: 'PRegular'; 
            src: url('fonts/Poppins-Regular.ttf') format('truetype'); 
        }

       
    .heading-section {
        padding-inline: 20px;
    }
    

    .top-link {
    transition: all 0.25s ease-in-out;
    position: fixed;
    bottom: 0;
    right: 0;
    display: inline-flex;
    cursor: pointer;
    align-items: center;
    justify-content: center;
    margin: 0 1rem 5em 0;
    border-radius: 50%;
    width: 80px;
    height: 80px;
    background-color: #3661D5;
    }
    .btncontainer {
        display: flex;
        padding: 20px 10px;
        flex-direction: column;
    }
    .btncontainer button {
        background-color: transparent;  /* Green background */
        width: 100%;
        max-width: 380px;
        margin-bottom: 15px;
        
        letter-spacing: 1px;
        color: #012049;               /* White text color */
        font-size: 1rem;            /* Font size */
        padding: 8px 15px !important;         /* Padding around the text */
        border: 3px solid #012049;               /* Remove default border */
        border-radius: 10px;         /* Rounded corners */
        cursor: pointer;   
        font-family: "PExBold";        /* Pointer cursor on hover */
        transition: background-color 0.3s ease; /* Smooth background color transition */
    }

    .col button:hover {
        background-color: #012049;
        color: white;
    }
    .header button {
        background-color: transparent;  
            margin-left: 10px;
            margin-bottom: 15px;
            
            letter-spacing: 1px;
            color: #012040;               /* White text color */
            font-size: 1rem;            /* Font size */
            padding: 6px 15px !important;         /* Padding around the text */
            border: 3px solid #012049;            /* Remove default border */
            border-radius: 20px;         /* Rounded corners */
            cursor: pointer;   
            font-family: "PExBold";        /* Pointer cursor on hover */
            transition: background-color 0.3s ease; /* Smooth background color transition */
    }

    .header button:hover {
        background-color: #2c91c9;  
          
            color: white;               /* White text color */
          border-color: #2c91c9;
    }
    .content {
        margin-left: 275px;
    }
    .top-link.show {
    visibility: visible;
    opacity: 1;
    }
    .top-link.hide {
    visibility: hidden;
    opacity: 0;
    }
   
    .top-link svg {
    fill: white;
    width: 24px;
    height: 12px;
    }
    .top-link:hover {
    background-color: #00357b;
    }
    .top-link:hover svg {
    fill: white;
    }




    .header h2 {
        text-align: left; 
            color: white; 
            font-family: 'PExBoldIt' !important; 
            font-size: 2.1rem; 
            z-index: 1; 
            /* width: 85%; */
            letter-spacing: 3px;
            margin-left: 10px;
            margin-bottom: 1px;
            margin-top: 70px;  
            text-shadow: 5px 5px 10px rgba(1, 60, 139, 0.9);
            line-height: 42px;
            -webkit-text-stroke: 7px #012049;
            paint-order: stroke fill;
         
           
    }
    html {
    scroll-padding-top: 70px; /* Adjust based on header height */
    scroll-behavior: smooth; /* Enables smooth scrolling globally */
}
    .header h3 {
        font-family: "PMedium";
        font-size: 1rem;
        margin-left: 10px;
        color: #012049;
        /* width: 85%; */
        line-height: 25px;
       

    }

/* General Reset */
/* General Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.announcements {
    display: flex;
    flex-direction: column;
    gap: 30px; /* Space between boxes */
    margin: 20px 0;
    width: 80%;
    font-family: "PRegular";
}

.announcement-box {
    background-color: #e7f3ff;
    border-left: 7px solid #014bae;
    border-radius: 10px;
    padding: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.announcement-title {
    font-size: 1.1rem;
    font-family: "PMedium";
    display: flex;
    align-items: center;
    margin-bottom: 10px;
    color: #014bae;
   
}

.announcement-title .icon {
    margin-right: 10px;
    color: #014bae; /* Primary color for the icon */
    margin-left: 10px;
}

.announcement-content {
    font-size: 0.95rem;
    line-height: 1.5;
    color: #333;
    margin-bottom: 10px;
    font-weight: bold;
    margin-left: 10px;
}

.announcement-meta {
    font-size: 0.9rem;
    color: #012049;
    opacity: 0.8;
    margin-top: 5px;
    font-style: italic;
    margin-left: 10px;
    font-family: "PSemiBold";
}

.no-announcement {
    margin-top: 100px;
    margin-bottom: 150px;
    text-align: center;
    font-family: "PBold";
    font-size: 1.2rem;
    font-style: italic;
    opacity: 0.8;
}

.steps {
    width: 100%;
    margin-top: 10px;
    padding: 20px;
    display: flex;
    flex-wrap: wrap;
    align-items: center; /* Align items vertically */
    gap: 5px; /* Space between images */
    
}

.steps img {
    width: 270px;
}

    </style>
    </head>
    <body> 

    <?php 
    include('user-sidebar.php');
?>   

        <?php include('user-header.php'); ?>
   <div class = "content">
                    
       
        <!-- Back-to-Top and Back Button -->

        <a data-toggle="tooltip"  class="top-link hide" href="" id="js-top">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12 6"><path d="M12 6H0l6-6z"/></svg>
            
        </a>

    

        <!-- Eto yung navbar -->



      

        <div id="down1"></div>

        <br>

        <section class="heading-section"> 
            <div class="container text-center"> 
                <div class="row"> 
                    <div class="col"> 
                        
                        <br>
                        <br>
                       
                        <div class="header"> 
                            <h2> We make document request faster and easier for you! </h2><bR>
                            <button  onclick="window.location.href='index.php#docsec'">
                            <i class="fa-solid fa-arrow-circle-right icon"></i>
Request Now
                </button>
                            
                            <h3> Our system makes it simple to get official documents. Just pick the document you need, fill out a quick form, and get a unique QR code. Use this code at the Barangay Office for fast and easy processing—no more long waits or extra paperwork. Get the documents you need, faster and easier! </h3>
                            
                        <div class = "steps">
                        <img src="assets/step1.png" alt="Image 1">
                        <img src="assets/step2.png" alt="Image 2">
                        <img src="assets/step3.png" alt="Image 3">
                        <img src="assets/step4.png" alt="Image 4">
                    
                        </div>
                        

                       

        


                        </div>
                    </div>
                    
                </div>
            </div>
            <section id="annsec"></section>
            <br>
         
            <br>


           
            <div class="header">
    <h2 style="margin-top: 20px">Latest Announcements</h2>
    <br>
    <h3>Important updates and notices will be posted here. Please check regularly for the latest information.</h3>
</div>

<?php 
$view = $bmis->view_announcement();
if ($view && is_array($view) && count($view) > 0) { ?>
    <!-- Announcements Container -->
    <div class="announcements">
        <?php foreach ($view as $announcement) { ?>
            <!-- Individual Announcement -->
            <div class="announcement-box">
                <h3 class="announcement-title">
                    <span class="icon"><i class="fa fa-bullhorn" aria-hidden="true"></i></span>
                    New Announcement
                </h3>
                <p class="announcement-content"><?= htmlspecialchars($announcement['event']); ?></p>
                <p class="announcement-meta">
                    Posted by <?= htmlspecialchars($announcement['fname'] . ' ' . $announcement['lname']); ?> 
                    on <?= htmlspecialchars($announcement['created_date']); ?> 
                    at <?= htmlspecialchars($announcement['created_time']); ?>
                </p>
            </div>
        <?php } ?>
    </div>
<?php 
} else { ?>
    <!-- No Announcement Box -->
   

        <p class="no-announcement">No announcement as of the moment.</p>
   
<?php } ?>




          
<div id="docsec"></div>   
<div class="header" > 
                            <h2 style = "margin-top: 70px" > Document Services </h2><bR>
                            <h3> Please select the specific document that you would like to request from the list below. Make sure to review your choice carefully to ensure that it matches your requirements.</h3>
            </div>

            <div class="btncontainer"> 
                <div class="col">
                    
                    <button  onclick="window.location.href='services_certofres.php'">
                    <i class="fa fa-file-alt"></i> Certificate  of Residency
                </button>
</div>

<div class="col">
                    
                    <button  onclick="window.location.href='services_brgyclearance.php'">
                    <i class="fa fa-file-alt"></i> Barangay Clearance
                </button>
</div>

<div class="col">
                    
                    <button  onclick="window.location.href='services_certofindigency.php'">
                    <i class="fa fa-file-alt"></i> Certificate  of Indigency
                </button>
</div>

<div class="col">
                    
                    <button  onclick="window.location.href='services_business.php'">
                    <i class="fa fa-file-alt"></i> Business Permit
                </button>
</div>

<div class="col">
                    
                    <button  onclick="window.location.href='services_brgyid.php'">
                    <i class="fa fa-file-alt"></i> Barangay ID
                </button>
</div>
</div> 
</div> 

<?php include('user-footer.php'); ?>

             <!-- Footer -->



       

        <script>

    document.getElementById('sidebar-toggle').addEventListener('click', function() {
        document.getElementById('sidebar').classList.remove('sidebar-hide');
    });

    document.getElementById('sidebar-toggle-2').addEventListener('click', function() {
        document.getElementById('sidebar').classList.add('sidebar-hide');
    });




    // Logout function
    function logout() {
        window.location.href = "logout.php";
    }

    // Scroll to top button functionality
    const scrollToTopButton = document.getElementById('js-top');

// Show/hide button based on scroll position
window.addEventListener('scroll', () => {
    if (window.scrollY > 200) {
        scrollToTopButton.classList.remove('hide');
        scrollToTopButton.classList.add('show');
    } else {
        scrollToTopButton.classList.remove('show');
        scrollToTopButton.classList.add('hide');
    }
});

// Scroll to the top when the button is clicked
scrollToTopButton.addEventListener('click', (e) => {
    e.preventDefault();
    window.scrollTo({ top: 0, behavior: 'smooth' });
});
</script>

<!-- Back to Top -->
<script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.js" type="text/javascript"></script>

    </body>
</html>

