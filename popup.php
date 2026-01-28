<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

<style>
    
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap");
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


    body,
    html {
        overflow-x: hidden;
        /* Prevents horizontal scrolling */
    }


    body {
        visibility: hidden;
        opacity: 0;
    }

    body.loaded {
        visibility: visible;
        opacity: 1;
    }

    .toast {
        position: fixed;
        font-family: "Poppins";
        z-index: 1000;
        top: 25px;
        right: 30px;
        border-radius: 12px;
        background: #fff;
        box-sizing: content-box;
        padding: 20px 35px 20px 25px;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
        border-left: 6px solid #4070f4;
        overflow: hidden;
        transform: translateX(calc(100% + 30px));
        opacity: 0;
        visibility: hidden;
        transition: transform 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.35), opacity 0.5s ease-out;
        width: auto;
        /* Adjust width based on content */
        max-width: 800px;
        /* Optional: limit the maximum width */
        white-space: nowrap;
        /* Prevent the text from wrapping to the next line */
    }


    .toast.active {
        transform: translateX(0%);
        opacity: 1 !important;
        visibility: visible;
    }

    .toast .toast-content {
        display: flex;
        align-items: center;
    }

    .toast-content .check {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 35px;
        width: 35px;
        background-color: #4070f4;
        color: #fff;
        font-size: 20px;
        border-radius: 50%;
    }

    .toast-content .message {
        display: flex;
        flex-direction: column;
        margin: 0 20px;
        white-space: nowrap;
        /* Prevents text from wrapping */
        overflow: hidden;
        /* Ensures that overflowing text doesn't show */
        text-overflow: ellipsis;
        /* Adds '...' at the end if the text is too long */
    }


    .message .text {
        text-align: left;
        font-size: 1rem;
        font-weight: 400;
        color: #666666;
    }

    .message .text.text-1 {
        font-family: "PSemiBold";
        font-size: 1.1rem;
    }

    .toast .close {
        position: absolute;
        top: 10px;
        right: 15px;
        padding: 5px;
        cursor: pointer;
        color: #4070f4;
        z-index: 1000;
        opacity: 1;
        font-size: 1.4rem !important;
    }

    .toast .close-error {
        color: #D32F2F !important;
    }

    .toast .close:hover {

        color: #4070f4 !important;
    }

    .toast .close-error:hover {
        color: #D32F2F !important;
    }

    .toast .progress {
        position: absolute;
        bottom: 0;
        left: 0;
        height: 3px;
        width: 100%;
        background: #ddd !important;
    }

    .toast .progress:before {
        content: "";
        position: absolute;
        bottom: 0;
        right: 0;
        height: 100%;
        width: 100%;
        background-color: #4070f4;
    }

    .toast .progress-error:before {

        background-color: #D32F2F;
    }

    .progress.active:before {
        animation: progress 5s linear forwards;
    }

    @keyframes progress {
        100% {
            right: 100%;
        }
    }
</style>
<script>
    document.addEventListener("DOMContentLoaded", () => {
    document.body.classList.add("loaded");
});
</script>
<script>
// Prevent page reload by manipulating the browser history
if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}

let timer1, timer2;


document.addEventListener("DOMContentLoaded", function() {
    // Save the current scroll position
    const currentScrollY = window.scrollY;
    
    
    fetch('http://localhost/sinalhan/dashboard_sidebar_start.php', {
        
            headers: {
                'X-Requested-With': 'XMLHttpRequest' // Ensure the server recognizes it as an AJAX request
            }
        })
        
        .then(response => response.json()) // Parse the JSON response
        .then(data => {
            
            // Update the notification elements with the fetched counts
            document.querySelector('.notif.rescert').textContent = data.rescertcount;
            document.querySelector('.notif.brgyid').textContent = data.brgyidcount;
            document.querySelector('.notif.bspermit').textContent = data.bspermitcount;
            document.querySelector('.notif.clearance').textContent = data.clearancecount;
            document.querySelector('.notif.indigency').textContent = data.indigencycount;

            // Hide the loading spinner after data is fetched
           
            setTimeout(hideLoading, 300);
            // Show the toast after data is fetched and loading is hidden
            showToast();
        })
        .catch(error => console.error('Error:', error));

    // After toast is shown, maintain the scroll position
    setTimeout(() => {
        window.scrollTo(0, currentScrollY); // Ensure scroll position is restored
    }, 0); // Delay scroll restoration until after any layout changes
});

// Add 'loaded' class once the page is fully loaded to prevent FOUC


// Function to show the toast
function showToast() {
    const toast = document.querySelector(".toast");
    const progress = document.querySelector(".progress");

    // Ensure toast does not cause scroll or layout shifts
    toast.classList.add("active");
    progress.classList.add("active");

    // Set timers to remove 'active' class after 5 seconds for toast and 5.5 seconds for progress bar
    timer1 = setTimeout(() => {
        toast.classList.remove("active");
    }, 5000);

    timer2 = setTimeout(() => {
        progress.classList.remove("active");
    }, 5000);
}

// Function to hide the loading spinner
function hideLoading() {
    const loading = document.getElementById("loading");

    // Ensure loading spinner is hidden only when the toast is shown
    if (document.querySelector(".toast").classList.contains("active")) {
        loading.style.display = "opacity 0.3s ease-out"; // Add smooth transition
        loading.style.opacity = "0"; // Fade out

        // Hide the spinner completely after the transition
        setTimeout(() => {
            loading.style.display = "none"; // Completely hide the spinner
        }, 300); // Delay to match the fade-out transition
    }
}

// Function to close the toast immediately if needed
function closeToast() {
    const toast = document.querySelector(".toast");
    const progress = document.querySelector(".progress");

    // Hide the toast and progress bar
    toast.classList.remove("active");

    setTimeout(() => {
        progress.classList.remove("active");
    }, 300);

    // Clear any active timeouts
    clearTimeout(timer1);
    clearTimeout(timer2);
}
</script>
