<?php 
    require './classes/main.class.php';

    $userdetails = $bmis->get_userdata();

    if ($userdetails && $userdetails['role'] == 'administrator') {
        echo '<script>window.location.href="./admn_dashboard.php"</script>';
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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="./node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

        <!-- responsive tags for screen compatibility -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- custom css --> 
        <link href="../BarangaySystem/customcss/pagestyle.css" rel="stylesheet" type="text/css">
        <!-- bootstrap css --> 
        <link href="../BarangaySystem/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">
        <!-- fontawesome icons --> 
        <script src="https://kit.fontawesome.com/67a9b7069e.js" crossorigin="anonymous"></script>


        <?php 
    include('user-sidebar.php');
?>   

        <?php include('user-header.php'); ?>




    <style>




@font-face {
            font-family: 'OSMedium'; 
            src: url('fonts/OpenSauceSans-Medium.ttf') format('truetype'); 
        }

        @font-face {
            font-family: 'OSBold'; 
            src: url('fonts/OpenSauceSans-Bold.ttf') format('truetype'); 
        }

        @font-face {
            font-family: 'OSBlack'; 
            src: url('fonts/OpenSauceSans-Black.ttf') format('truetype'); 
        }

        @font-face {
            font-family: 'OSExBold'; 
            src: url('fonts/OpenSauceSans-ExtraBold.ttf') format('truetype'); 
        }

        @font-face {
            font-family: 'OSBlackIt'; 
            src: url('fonts/OpenSauceSans-BlackItalic.ttf') format('truetype'); 
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
    margin: 0 3em 3em 0;
    border-radius: 50%;
    padding: 0.25em;
    width: 80px;
    height: 80px;
    background-color: #3661D5;
    }

    .content {
        margin-left: 270px;
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

    .screen-reader-text {
    position: absolute;
    clip-path: inset(50%);
    margin: -1px;
    border: 0;
    padding: 0;
    width: 1px;
    height: 1px;
    overflow: hidden;
    word-wrap: normal !important;
    clip: rect(1px, 1px, 1px, 1px);
    }
    .screen-reader-text:focus {
    display: block;
    top: 5px;
    left: 5px;
    z-index: 100000;
    clip-path: none;
    background-color: #eee;
    padding: 15px 23px 14px;
    width: auto;
    height: auto;
    text-decoration: none;
    line-height: normal;
    color: #444;
    font-size: 1em;
    clip: auto !important;
    }

    .header h2 {
        text-align: left; 
            color: white; 
            font-family: 'OSBlackIt' !important; 
            font-size: 2.2rem; 
            z-index: 1; 
            width: 85%;
            letter-spacing: 3px;
            margin-left: 10px;
            margin-bottom: 1px;
            margin-top: 70px;
               
             
            text-shadow: 5px 5px 10px rgba(1, 60, 139, 0.9);
            line-height: 42px;
            -webkit-text-stroke: 7px #012049;
         
            paint-order: stroke fill;
            line-height: 40px;
           
    }

    .header h3 {
        font-family: "OSMedium";
        font-size: 1.1rem;
        margin-left: 10px;
        color: #012049;
        width: 85%;
        line-height: 25px;
       

    }

/* General Reset */
/* General Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Container for Announcements */
.announcement-container {
    margin-top: 1%;
    margin-left: auto;
    margin-right: auto;
    margin-bottom: 1.5%;
    border-radius: 15px;
    width: 65%;
    background-color: #2C3E50; /* Darker background */
    color: #ECF0F1; /* Softer white text */
    padding: 0; /* Remove padding from container */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border: 4px solid #014bae; /* Outline for the container */
    overflow: hidden; /* Ensure rounded corners include the title */
}

/* Title Styling */
.announcement-title {
    background-color: #014bae; /* Distinct background color for the title */
    color: #FFFFFF; /* White text for contrast */
    padding: 10px;
    font-weight: 600;
    font-size: 1.2rem;
    text-align: center;
    border-top-left-radius: 15px; /* Rounded corners for the top */
    border-top-right-radius: 15px;
}

/* Content Styling */
.announcement-content {
    padding: 20px;
    font-size: 1rem;
    text-align: left; /* Formal left alignment */
    line-height: 1.5; /* Improved readability */
    background-color: white; /* Same background as the container */
    color:#014bae;
    font-family: "OSBold";
}

.announcement-content2 {
    padding: 20px;
    font-size: 1rem;
    font-style: italic;
    text-align: center; /* Formal left alignment */
    line-height: 1.5; /* Improved readability */
    background-color: white; /* Same background as the container */
    
    color: rgba(44, 62, 80, 0.7);
    font-family: "OSBold";
}

.steps {
    margin-top: 10px;
    padding: 20px;
    display: flex;
   
    align-items: center; /* Align items vertically */
    gap: 5px; /* Space between images */
    
}

.steps img {
    width: 29%; /* Adjust width as needed */
    height: auto; /* Maintain aspect ratio */
}


/* Close Button Styling */


.announcement-container .close:hover {
    opacity: 1;
}

/* No Announcement Styling */


/* Responsive Design */
@media (max-width: 768px) {
    .announcement-container, .no-announcement {
        width: 90%;
    }
}





    </style>
    <body> 

    
   <div class = "content">
                    
       
        <!-- Back-to-Top and Back Button -->

        <a data-toggle="tooltip"  class="top-link hide" href="" id="js-top">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12 6"><path d="M12 6H0l6-6z"/></svg>
            <span class="screen-reader-text">Back to top</span>
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
                            <h3> Our system makes it simple to get official documents. Just pick the document you need, fill out a quick form, and get a unique QR code. Use this code at the Barangay Office for fast and easy processing—no more long waits or extra paperwork. Get the documents you need, faster and easier!
                        <div class = "steps">
                        <img src="assets/step1.png" alt="Image 1">
                        <img src="assets/step2.png" alt="Image 2">
                        <img src="assets/step3.png" alt="Image 3">
                        <img src="assets/step4.png" alt="Image 4">
                        </div>





</h3>
                        </div>
                    </div>
                </div>
            </div>

            <br>
            <br>

            <div id="down2"></div>

<?php 
$view = $bmis->view_announcement();

if ($view && is_array($view) && count($view) > 0) { ?>
    <!-- Announcement Section -->
    <div class="announcement-container alert alert-info alert-dismissible fade show" role="alert">
        <!-- Announcement Title -->
        <h3 class="announcement-title">
            <span class="icon"><i class="fa fa-bullhorn" aria-hidden="true"></i></span>
            Announcement
        </h3>

        <!-- Display Announcement Content -->
        <?php foreach ($view as $announcement) { ?>
            <p class="announcement-content"><?= htmlspecialchars($announcement['event']); ?></p>
        <?php } ?>

        <!-- Close Button -->

    </div>
<?php 
} else { ?>
    <!-- No Announcement Section -->
    <div class="announcement-container alert alert-info alert-dismissible fade show" role="alert">
        <!-- Announcement Title -->
        <h3 class="announcement-title">
            <span class="icon"><i class="fa fa-bullhorn" aria-hidden="true"></i></span>
            Announcement
        </h3>
        <p class="announcement-content2">No announcement as of the moment</p>
        

    </div>
<?php } ?>





            <div class="container"> 
                <div class="row title-spacing">
                    <div class="col"> 
                        <h2 class="text-center"> E-Services</h2>
                        <hr>
                    </div> 
                </div>
                
                <div class="row">
                    <div class="col"> 
                        <a href="services_business.php ">
                            <div class="zoom1"> 
                                <div class="card"> 
                                    <div class="card-body text-center"> 
                                        <img src="./icons/ResidentHomepage/busper.png">
                                        <h4> Business Permit </h4> 
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col"> 
                        <a href="services_brgyid.php">
                            <div class="zoom1">
                                <div class="card"> 
                                    <div class="card-body text-center"> 
                                        <img style="height: 139px;" src="./icons/ResidentHomepage/brgyid.png">
                                        <h4> Barangay ID </h4>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col"> 
                        <a href="services_certofindigency.php ">
                            <div class="zoom1">
                                <div class="card"> 
                                    <div class="card-body text-center"> 
                                        <img src="./icons/ResidentHomepage/indigency.png">
                                        <h4> Certificate of Indigency </h4>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <br>
                <div class="row card-spacing"> 
                    <div class="col">
                        <a href="services_certofres.php "> 
                        <div class="zoom1">    
                            <div class="card"> 
                                <div class="card-body text-center"> 
                                <img src="./icons/ResidentHomepage/residency.png">
                                    <h4> Certificate of Residency </h4>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>

                    <div class="col">
                        <a href="services_brgyclearance.php "> 
                        <div class="zoom1">    
                            <div class="card"> 
                                <div class="card-body text-center">
                                <img src="./icons/ResidentHomepage/clearance.png"> 
                                    <h4> Barangay Clearance </h4>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
                </div>
            </div>
             <!-- Footer -->

        <footer id="footer" class="bg-primary text-white">
            <hr class="mt-0">

            <div class="text-center">
                <h1 class="text-white">Services</h1>
                <ul class="list-unstyled list-inline">

                &nbsp;

                <li class="list-inline-item">
                    <a class="footerlinks" href="#!" class="sbtn btn-large mx-1" title="Documents">
                    <i class="fas fa-file fa-2x"></i>
                    </a>
                </li>


                <li class="list-inline-item">
                    <a href="#!" class="footerlinks sbtn btn-large mx-1" title="Card">
                    <i class="fas fa-id-card fa-2x"></i>
                    </a>
                </li>


                <li class="list-inline-item">
                    <a class="footerlinks" href="#!" class="sbtn btn-large mx-1" title="Friends">
                    <i class="fas fa-user-friends fa-2x"></i>
                    </a>
                </li>


                <li class="list-inline-item">
                    <a class="footerlinks" href="#!" class="sbtn btn-large mx-1" title="Contact">
                    <i class="fas fa-phone fa-2x"></i>
                    </a>
                </li>
                </ul>
            </div>
        </section>
            <hr class="mb-0">

            <!--Footer Links-->

            <div class="container text-left text-md-center">
                <div class="row">

                    <!--First column-->

                    <div class="col-md-3 mx-auto shfooter">
                        <h5 class="my-2 font-weight-bold d-none d-md-block">Documentation</h5>
                        <div class="d-md-none title" data-target="#Documentation" data-toggle="collapse">
                            <div class="mt-3 font-weight-bold">Documentation
                                <div class="float-right navbar-toggler">
                                    <i class="fas fa-angle-down"></i>
                                    <i class="fas fa-angle-up"></i>
                                </div>
                            </div>
                        </div>



                    <div class="col-md-3 mx-auto shfooter" id="down">
                        <h5 class="my-2 font-weight-bold d-none d-md-block">Contact Us:</h5>
                        <div class="d-md-none title" data-target="#Contact-Us">
                        <div class="mt-3 font-weight-bold">Contact Us:</div>
                        </div>
                        <ul class="list-unstyled" id="Contact-Us">
                            <li>
                                <div class="zoom">
                                    <div class="chip" style="font-size:10px;">
                                        <img src="../BarangaySystem/icons/Contact/mikhos.png" alt="Person" width="96" height="96">
                                        Mikhos Dungca | 09514053044
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="zoom">
                                    <div class="chip" style="font-size:10px;">
                                        <img src="../BarangaySystem/icons/Contact/pj.png" alt="Person" width="96" height="96">
                                        PJ Mendros | 09179450661
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="zoom">
                                    <div class="chip" style="font-size:10px;">
                                        <img src="../BarangaySystem/icons/Contact/vincent.png" alt="Person" width="96" height="96">
                                        Vincent Vilfamat | 09512873394
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="zoom">
                                    <div class="chip" style="font-size:10px;">
                                        <img src="../BarangaySystem/icons/Contact/eugene.png" alt="Person" width="96" height="96">
                                        Joel Evangelista | 09301112368
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="zoom">
                                    <div class="chip" style="font-size:10px;">
                                        <img src="../BarangaySystem/icons/Contact/kyle.png" alt="Person" width="96" height="96">
                                        Kyle Pilapil | 09618853017
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>


                </div>
            </div>

            <div class="py-3 text-center">
                Copyright 2021 -
                <script>
                document.write(new Date().getFullYear())
                </script> 
                BI & ESMS | For Educational Purposes Only
            </div>

        </footer>
        </div>
        

        <br>
        <br>
        <br>

       

        <script>
    // Logout function
    function logout() {
        window.location.href = "logout.php";
    }

    // Scroll to top button functionality
    const scrollToTopButton = document.getElementById('js-top');

    const scrollFunc = () => {
        let y = window.scrollY;
        
        // Show or hide scroll-to-top button based on scroll position
        if (y > 0) {
            scrollToTopButton.className = "top-link show";
        } else {
            scrollToTopButton.className = "top-link hide";
        }
    };

    window.addEventListener("scroll", scrollFunc);

    const scrollToTop = () => {
        const c = document.documentElement.scrollTop || document.body.scrollTop;

        if (c > 0) {
            window.requestAnimationFrame(scrollToTop);
            window.scrollTo(0, c - c / 10);
        }
    };

    scrollToTopButton.onclick = function(e) {
        e.preventDefault();
        scrollToTop();
    }

    // Initialize Bootstrap tooltip
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();   
    });

    const ANIMATION_DURATION = 300;

const SIDEBAR_EL = document.getElementById("sidebar");

const SUB_MENU_ELS = document.querySelectorAll(
  ".menu > ul > .menu-item.sub-menu"
);

const FIRST_SUB_MENUS_BTN = document.querySelectorAll(
  ".menu > ul > .menu-item.sub-menu > a"
);

const INNER_SUB_MENUS_BTN = document.querySelectorAll(
  ".menu > ul > .menu-item.sub-menu .menu-item.sub-menu > a"
);

class PopperObject {
  instance = null;
  reference = null;
  popperTarget = null;

  constructor(reference, popperTarget) {
    this.init(reference, popperTarget);
  }

  init(reference, popperTarget) {
    this.reference = reference;
    this.popperTarget = popperTarget;
    this.instance = Popper.createPopper(this.reference, this.popperTarget, {
      placement: "right",
      strategy: "fixed",
      resize: true,
      modifiers: [
        {
          name: "computeStyles",
          options: {
            adaptive: false
          }
        },
        {
          name: "flip",
          options: {
            fallbackPlacements: ["left", "right"]
          }
        }
      ]
    });

    document.addEventListener(
      "click",
      (e) => this.clicker(e, this.popperTarget, this.reference),
      false
    );

    const ro = new ResizeObserver(() => {
      this.instance.update();
    });

    ro.observe(this.popperTarget);
    ro.observe(this.reference);
  }

  clicker(event, popperTarget, reference) {
    if (
      SIDEBAR_EL.classList.contains("collapsed") &&
      !popperTarget.contains(event.target) &&
      !reference.contains(event.target)
    ) {
      this.hide();
    }
  }

  hide() {
    this.instance.state.elements.popper.style.visibility = "hidden";
  }
}

class Poppers {
  subMenuPoppers = [];

  constructor() {
    this.init();
  }

  init() {
    SUB_MENU_ELS.forEach((element) => {
      this.subMenuPoppers.push(
        new PopperObject(element, element.lastElementChild)
      );
      this.closePoppers();
    });
  }

  togglePopper(target) {
    if (window.getComputedStyle(target).visibility === "hidden")
      target.style.visibility = "visible";
    else target.style.visibility = "hidden";
  }

  updatePoppers() {
    this.subMenuPoppers.forEach((element) => {
      element.instance.state.elements.popper.style.display = "none";
      element.instance.update();
    });
  }

  closePoppers() {
    this.subMenuPoppers.forEach((element) => {
      element.hide();
    });
  }
}

const slideUp = (target, duration = ANIMATION_DURATION) => {
  const { parentElement } = target;
  parentElement.classList.remove("open");
  target.style.transitionProperty = "height, margin, padding";
  target.style.transitionDuration = `${duration}ms`;
  target.style.boxSizing = "border-box";
  target.style.height = `${target.offsetHeight}px`;
  target.offsetHeight;
  target.style.overflow = "hidden";
  target.style.height = 0;
  target.style.paddingTop = 0;
  target.style.paddingBottom = 0;
  target.style.marginTop = 0;
  target.style.marginBottom = 0;
  window.setTimeout(() => {
    target.style.display = "none";
    target.style.removeProperty("height");
    target.style.removeProperty("padding-top");
    target.style.removeProperty("padding-bottom");
    target.style.removeProperty("margin-top");
    target.style.removeProperty("margin-bottom");
    target.style.removeProperty("overflow");
    target.style.removeProperty("transition-duration");
    target.style.removeProperty("transition-property");
  }, duration);
};
const slideDown = (target, duration = ANIMATION_DURATION) => {
  const { parentElement } = target;
  parentElement.classList.add("open");
  target.style.removeProperty("display");
  let { display } = window.getComputedStyle(target);
  if (display === "none") display = "block";
  target.style.display = display;
  const height = target.offsetHeight;
  target.style.overflow = "hidden";
  target.style.height = 0;
  target.style.paddingTop = 0;
  target.style.paddingBottom = 0;
  target.style.marginTop = 0;
  target.style.marginBottom = 0;
  target.offsetHeight;
  target.style.boxSizing = "border-box";
  target.style.transitionProperty = "height, margin, padding";
  target.style.transitionDuration = `${duration}ms`;
  target.style.height = `${height}px`;
  target.style.removeProperty("padding-top");
  target.style.removeProperty("padding-bottom");
  target.style.removeProperty("margin-top");
  target.style.removeProperty("margin-bottom");
  window.setTimeout(() => {
    target.style.removeProperty("height");
    target.style.removeProperty("overflow");
    target.style.removeProperty("transition-duration");
    target.style.removeProperty("transition-property");
  }, duration);
};

const slideToggle = (target, duration = ANIMATION_DURATION) => {
  if (window.getComputedStyle(target).display === "none")
    return slideDown(target, duration);
  return slideUp(target, duration);
};

const PoppersInstance = new Poppers();

/**
 * wait for the current animation to finish and update poppers position
 */
const updatePoppersTimeout = () => {
  setTimeout(() => {
    PoppersInstance.updatePoppers();
  }, ANIMATION_DURATION);
};

/**
 * sidebar collapse handler
 */
document.getElementById("btn-collapse").addEventListener("click", () => {
  SIDEBAR_EL.classList.toggle("collapsed");
  PoppersInstance.closePoppers();
  if (SIDEBAR_EL.classList.contains("collapsed"))
    FIRST_SUB_MENUS_BTN.forEach((element) => {
      element.parentElement.classList.remove("open");
    });

  updatePoppersTimeout();
});

/**
 * sidebar toggle handler (on break point )
 */
document.getElementById("btn-toggle").addEventListener("click", () => {
  SIDEBAR_EL.classList.toggle("toggled");

  updatePoppersTimeout();
});

/**
 * toggle sidebar on overlay click
 */
document.getElementById("overlay").addEventListener("click", () => {
  SIDEBAR_EL.classList.toggle("toggled");
});

const defaultOpenMenus = document.querySelectorAll(".menu-item.sub-menu.open");

defaultOpenMenus.forEach((element) => {
  element.lastElementChild.style.display = "block";
});

/**
 * handle top level submenu click
 */
FIRST_SUB_MENUS_BTN.forEach((element) => {
  element.addEventListener("click", () => {
    if (SIDEBAR_EL.classList.contains("collapsed"))
      PoppersInstance.togglePopper(element.nextElementSibling);
    else {
      const parentMenu = element.closest(".menu.open-current-submenu");
      if (parentMenu)
        parentMenu
          .querySelectorAll(":scope > ul > .menu-item.sub-menu > a")
          .forEach(
            (el) =>
              window.getComputedStyle(el.nextElementSibling).display !==
                "none" && slideUp(el.nextElementSibling)
          );
      slideToggle(element.nextElementSibling);
    }
  });
});

/**
 * handle inner submenu click
 */
INNER_SUB_MENUS_BTN.forEach((element) => {
  element.addEventListener("click", () => {
    slideToggle(element.nextElementSibling);
  });
});

    // Smooth scrolling for anchor links
    $(document).ready(function(){
        $("a").on('click', function(event) {
            if (this.hash !== "") {
                event.preventDefault();
                var hash = this.hash;

                $('html, body').animate({
                    scrollTop: $(hash).offset().top
                }, 800, function(){
                    window.location.hash = hash;
                });
            }
        });
    });
</script>

<!-- Back to Top -->
<script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.js" type="text/javascript"></script>

    </body>
</html>
        