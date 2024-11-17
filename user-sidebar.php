
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
            font-family: 'PBlackIt'; 
            src: url('fonts/Poppins-BlackItalic.ttf') format('truetype'); 
        }
        .layout {
  z-index: 1;
  .header {
    display: flex;
    align-items: center;
    padding: 20px;
  }
  .content {
    padding: 12px 50px;
    display: flex;
    flex-direction: column;
  }

  .footer {
    text-align: center;
    margin-top: auto;
    margin-bottom: 20px;
    padding: 20px;
  }
}


.sidebar {
  color: #7d84ab;
  overflow-x: hidden !important;
  position: fixed;
  z-index: 3;
  height: 100vh;
  width: 250px;
  margin:0 !important;
  overflow-y: scroll;
}

.sidebar-logo {
    text-align: center; /* Center the logo */
    padding: 10px 0; /* Space above and below the logo */
}

.sidebar-logo img {
    max-width: 50%; /* Adjust logo size to fit the sidebar */
    height: auto; /* Maintain aspect ratio */
    margin-top: 15px;
}

/* Menu Styles */

.sidebar::-webkit-scrollbar {
      width: 10px; /* Width of the scrollbar */
    }

    .sidebar::-webkit-scrollbar-thumb {
      background-color: #162d4a; /* Color of the scroll thumb */
      border-radius: 10px;
    }

    .sidebar::-webkit-scrollbar-thumb:hover {
      background-color: #3a5b7c; /* Color of the thumb when hovered */
    }

    .sidebar::-webkit-scrollbar-track {
      background: #012049; /* Background of the scrollbar */
      
    }

  .image-wrapper {
    overflow: hidden;
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 1;
    display: none;
    > img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      object-position: center;
    }
  }
  &.has-bg-image .image-wrapper {
    display: block;
  }


  .sidebar-layout {
    height: auto;
    min-height: 100%;
    display: flex;
    flex-direction: column;
    position: relative;
    background-color: #012049;
    z-index: 2;

    .sidebar-header {
      height: 100px;
      min-height: 100px;
      display: flex;
      align-items: center;
      padding: 0 20px;
      > span {
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
      }
    }
    .sidebar-content {
      flex-grow: 1;
      padding: 10px 0;
    }
    .sidebar-footer {
      height: 230px;
      min-height: 230px;
      display: flex;
      align-items: center;
      padding: 0 20px;
      > span {
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
      }
    }
  }


@keyframes swing {
  0%,
  30%,
  50%,
  70%,
  100% {
    transform: rotate(0deg);
  }

  10% {
    transform: rotate(10deg);
  }

  40% {
    transform: rotate(-10deg);
  }

  60% {
    transform: rotate(5deg);
  }

  80% {
    transform: rotate(-5deg);
  }
}

.layout {
  .sidebar {
    .menu {
      ul {
        list-style-type: none;
        padding: 0;
        margin: 0;
      }
      .menu-header {
        font-weight: 600;
        padding: 10px 25px;
        font-size: 0.85em;
        letter-spacing: 2px;
        transition: opacity 0.3s;
        opacity: 0.7;
        font-family: 'PBlack';
      }
    }
  }
      .menu-item {
        a {
          display: flex;
          align-items: center;
          height: 50px;
          padding: 0 20px;
          color: #7d84ab;
       

          .menu-icon {
            font-size: 1.2rem;
            width: 35px;
            min-width: 35px;
            height: 35px;
            line-height: 35px;
            text-align: center;
            display: inline-block;
            margin-right: 10px;
            border-radius: 2px;
            transition: color 0.3s;
            i {
              display: inline-block;
            }
          }
        }

          .menu-title {
            font-size: 0.9em;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            flex-grow: 1;
            transition: color 0.3s;
            font-family: "PMedium";
          }
          .menu-prefix,
          .menu-suffix {
            display: inline-block;
            padding: 5px;
            opacity: 1;
            transition: opacity 0.3s;
          }
          &:hover {
            .menu-title {
              color: #dee2ec;
            }
            .menu-icon {
              color: #dee2ec;
              i {
                animation: swing ease-in-out 0.5s 1 alternate;
              }
            }
            &::after {
              border-color: #dee2ec !important;
            }
          }
        }
    }
 



        &.sub-menu {
          position: relative;
          > a {
            &::after {
              content: '';
              transition: transform 0.3s;
              border-right: 2px solid currentcolor;
              border-bottom: 2px solid currentcolor;
              width: 5px;
              height: 5px;
              transform: rotate(-45deg);
            }
          }

          > .sub-menu-list {
            padding-left: 20px;
            display: none;
            overflow: hidden;
            z-index: 999;
          }
          &.open {
            > a {
              color: #dee2ec;
              &::after {
                transform: rotate(45deg);
              }
            }
          }
        }

        &.active {
          > a {
            .menu-title {
              color: #dee2ec;
            }
            &::after {
              border-color: #dee2ec;
            }
            .menu-icon {
              color: #dee2ec;
            }
          }
        
        
      
      > ul > .sub-menu > .sub-menu-list {
        background-color: #0b1a2c;
      }
        }

      &.icon-shape-circle,
      &.icon-shape-rounded,
      &.icon-shape-square {
        .menu-item a .menu-icon {
          background-color: #0b1a2c;
        }
      }

      &.icon-shape-circle .menu-item a .menu-icon {
        border-radius: 50%;
      }
      &.icon-shape-rounded .menu-item a .menu-icon {
        border-radius: 4px;
      }
      &.icon-shape-square .menu-item a .menu-icon {
        border-radius: 0;
      }
    

    &:not(.collapsed) {
      .menu > ul {
        > .menu-item {
          &.sub-menu {
            > .sub-menu-list {
              visibility: visible !important;
              position: static !important;
              transform: translate(0, 0) !important;
            }
          }
        }
      }
    }

    &.collapsed {
      .menu > ul {
        > .menu-header {
          opacity: 0;
        }
    }

        > .menu-item {
          > a {
            .menu-prefix,
            .menu-suffix {
              opacity: 0;
            }
          }
        }
          &.sub-menu {
            > a {
              &::after {
                content: '';
                width: 5px;
                height: 5px;
                background-color: currentcolor;
                border-radius: 50%;
                display: inline-block;
                position: absolute;
                right: 10px;
                top: 50%;
                border: none;
                transform: translateY(-50%);
              }
              &:hover {
                &::after {
                  background-color: #dee2ec;
                }
              }
            }
            > .sub-menu-list {
              transition: none !important;
              width: 200px;
              margin-left: 3px !important;
              border-radius: 4px;
              display: block !important;
            }
          }
          &.active {
            > a {
              &::after {
                background-color: #dee2ec;
              }
            }
          }
        }
      
    
    &.has-bg-image {
      .menu {
        &.icon-shape-circle,
        &.icon-shape-rounded,
        &.icon-shape-square {
          .menu-item a .menu-icon {
            background-color: rgba(#0b1a2c, 0.6);
          }
        }
      }
    }
      &:not(.collapsed) {
        .menu {
          > ul > .sub-menu > .sub-menu-list {
            background-color: rgba(#0b1a2c, 0.6);
          }
        }
      }
    
  

  &.rtl {
    .sidebar {
      .menu {
        .menu-item {
          a {
            .menu-icon {
              margin-left: 10px;
              margin-right: 0;
            }
          }

          &.sub-menu {
            > a {
              &::after {
                transform: rotate(135deg);
              }
            }

            > .sub-menu-list {
              padding-left: 0;
              padding-right: 20px;
            }
            &.open {
              > a {
                &::after {
                  transform: rotate(45deg);
                }
              }
            }
          }
        }
      }

      &.collapsed {
        .menu > ul {
          > .menu-item {
            &.sub-menu {
              a::after {
                right: auto;
                left: 10px;
              }

              > .sub-menu-list {
                margin-left: -3px !important;
              }
            }
          }
        }
      }
    }
  }


* {
  box-sizing: border-box;
}

body {
  margin: 0;
  height: 100vh;
  
  font-family: 'Poppins', sans-serif;
  color: #3f4750;
  font-size: 0.9rem;
}

a {
  text-decoration: none;
}

@media (max-width: 576px) {
  #btn-collapse {
    display: none;
  }
}


.layout {
  .sidebar {
    .pro-sidebar-logo {
      display: flex;
      align-items: center;

      > div {
        width: 35px;
        min-width: 35px;
        height: 35px;
        min-height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        color: white;
        font-size: 24px;
        font-weight: 700;
        background-color: #ff8100;
        margin-right: 10px;
      }

      > h5 {
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        font-size: 20px;
        line-height: 30px;
        transition: opacity 0.3s;
        opacity: 1;
      }
    }

    .footer-box {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
      font-size: 0.8em;
      padding: 20px 0;
      border-radius: 8px;
      width: 180px;
      min-width: 190px;
      margin: 0 auto;
      background-color:rgba(0, 13, 51, 0.5);
    
      img.react-logo {
        width: 40px;
        height: 40px;
        margin-bottom: 10px;
      }
      a {
        color: #fff;
        font-weight: 600;
        margin-bottom: 10px;
      }
    }
  }
  


      .footer-box {
        display: none;
      }
      .sidebar-collapser {
        left: 60px;
        i {
          transform: rotate(180deg);
        }
      }
    }
  


.badge {
  display: inline-block;
  padding: 0.25em 0.4em;
  font-size: 75%;
  font-weight: 700;
  line-height: 1;
  text-align: center;
  white-space: nowrap;
  vertical-align: baseline;
  border-radius: 0.25rem;
  color: #fff;
  background-color: #6c757d;

  &.primary {
    background-color: #ab2dff;
  }

  &.secondary {
    background-color: #079b0b;
  }
}

.sidebar-toggler {
  position: fixed;
  right: 20px;
  top: 20px;
}

.social-links {
  a {
    margin: 0 10px;
    color: #3f4750;
  }
}



   



    </style>
    <body> 

    <div class="layout has-sidebar fixed-sidebar fixed-header">
      <aside id="sidebar" class="sidebar break-point-sm has-bg-image">
        
        
        <div class="sidebar-layout">
          <div class="sidebar-header">
          <div class="sidebar-logo">
        <img src="assets/sinlogo.png" alt="Logo">
    </div>
          </div>
          <div class="sidebar-content">
            <nav class="menu open-current-submenu">
              <ul>
                <li class="menu-header"><span> GENERAL </span></li>
                <li class="menu-item sub-menu">
                <a href="index.php">
                    <span class="menu-icon">
                      <i class="fas fa-home"></i>
                    </span>
                    <span class="menu-title">Home</span>
                    
                  </a>
                </li>
                <li class="menu-item">
                <a href="#" onclick="window.location.href='index.php#annsec'; return false;">
                    <span class="menu-icon">
                      <i class="fas fa-bullhorn"></i>
                    </span>
                    <span class="menu-title">Announcement</span>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="#">
                    <span class="menu-icon">
                      <i class="fas fa-address-book"></i>
                    </span>
                    <span class="menu-title">Contacts</span>
                  </a>
                </li>
                 
                <li class="menu-header" style="padding-top: 20px"><span> DOCUMENT SERVICES </span></li>
                <li class="menu-item">
                <a href="services_certofres.php">
                    <span class="menu-icon">
                      <i class="fa fa-file-alt"></i>
                    </span>
                    <span class="menu-title">Certificate of Residency</span>
                    </a>
             

                <li class="menu-item sub-menu">
                  <a href="services_brgyclearance.php">
                    <span class="menu-icon">
                      <i class="fas fa-file-contract"></i>
                    </span>
                    <span class="menu-title">Barangay Clearance</span>
                  </a>
                </li>
                  
                <li class="menu-item sub-menu">
                  <a href="services_certofindigency.php">
                    <span class="menu-icon">
                      <i class="fa fa-file-alt"></i>
                    </span>
                    <span class="menu-title">Certificate of Indigency</span>
                  </a>
                </li>
                  
                <li class="menu-item sub-menu">
                  <a href="services_business.php">
                    <span class="menu-icon">
                      <i class="fa fa-briefcase"></i>
                    </span>
                    <span class="menu-title">Business Permit</span>
                  </a>
                </li>
                  
                <li class="menu-item sub-menu">
                  <a href="services_brgyid.php">
                    <span class="menu-icon">
                     <i class="fa fa-id-card"></i>
                    </span>
                    <span class="menu-title">Barangay ID</span>
                  </a>
                </li>
                  
              </ul>
            </nav>
          </div>
          <div class="sidebar-footer">
            <div class="footer-box">
<!-- Facebook icon -->
<div style="margin-bottom: 15px;">
  <a href="https://web.facebook.com/profile.php?id=61554520484549" target="_blank" style="text-decoration: none;">
    <i class="fab fa-facebook" style="font-size: 30px; color: #ffff;"></i>
  </a>
</div>
              <div style="padding: 0 10px">
                <span style="display: block; margin-bottom: 10px"
                  >Connect with us for the updates!                </span>

                  <a href="https://web.facebook.com/profile.php?id=61554520484549" target="_blank"
                    >Check it out!</a
                  >
                </div>
              </div>
            </div>
          </div>
        </div>
      </aside>
      
      </div>
  





    </div>
    </html>