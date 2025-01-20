<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>  <!-- Updated jQuery -->
<script src="assets/js/popper.min.js"></script>  <!-- Keep if using Bootstrap tooltips/popovers -->
<script src="assets/js/bootstrap.min.js"></script>  <!-- Keep for Bootstrap components -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>  <!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">  <!-- DataTables CSS -->
<script src="assets/js/app.js"></script>  <!-- Your custom logic -->
<script>
function openPopup(url) {
    // Open the URL in a new popup window
    window.open(url, 'popupWindow', 'width=900,height=600,scrollbars=yes');
}

document.getElementById('archiveSelected').addEventListener('click', function (event) {
    const selectedCheckboxes = document.querySelectorAll('.rowCheckbox:checked');
    const ids = Array.from(selectedCheckboxes).map(checkbox => checkbox.value); // Collect IDs
    const toast = document.querySelector(".toasterr");
    const progress = document.querySelector(".progresserr");
    const popup = document.getElementById('popup-archive-slt');
    const confirmBtn = document.getElementById('confirm-btn-arc-slt');
    const cancelBtn = document.getElementById('cancel-btn-arc-slt');

    if (ids.length === 0) {
        event.preventDefault(); // Prevent the form or default action
        toast.classList.add("active");
        progress.classList.add("active");


        // Set timers to hide the toast and progress after 5 seconds
        setTimeout(() => {
            toast.classList.remove("active");
        }, 5000);

        setTimeout(() => {
            progress.classList.remove("active");
        }, 5000);

    }

    else {
        popup.classList.remove('hidden'); 
    }

    cancelBtn.addEventListener('click', () => {
        popup.classList.add('hidden'); // Hide the popup when cancel is clicked
    });

    // Confirm action and submit form when Confirm is clicked
    confirmBtn.addEventListener('click', () => {
        // Programmatically trigger the hidden submit button
        document.getElementById('idsToArchive').value = ids.join(',');
        document.getElementById('hiddensubmitslt').click();
        
        // Hide the popup after submission
        popup.classList.add('hidden');
        

    });

});
// Function to manually close the alert
function closeToasterr() {
    const toast = document.querySelector(".toasterr");
    const progress = document.querySelector(".progresserr");

    toast.classList.remove("active");
    progress.classList.remove("active");
}
</script>
<script>

document.getElementById('retrieveSelected').addEventListener('click', function (event) {
    const selectedCheckboxes = document.querySelectorAll('.rowCheckbox:checked');
    const ids = Array.from(selectedCheckboxes).map(checkbox => checkbox.value); // Collect IDs
    const toast = document.querySelector(".toasterr");
    const progress = document.querySelector(".progresserr");
    const popup = document.getElementById('popup-retrieve-slt');
    const confirmBtn = document.getElementById('confirm-btn-ret-slt');
    const cancelBtn = document.getElementById('cancel-btn-ret-slt');


    if (ids.length === 0) {
        event.preventDefault(); // Prevent the form or default action
        toast.classList.add("active");
        progress.classList.add("active");


        // Set timers to hide the toast and progress after 5 seconds
        setTimeout(() => {
            toast.classList.remove("active");
        }, 5000);

        setTimeout(() => {
            progress.classList.remove("active");
        }, 5000);

    }

    else {
        popup.classList.remove('hidden'); 
    }

    cancelBtn.addEventListener('click', () => {
        popup.classList.add('hidden'); // Hide the popup when cancel is clicked
    });

    // Confirm action and submit form when Confirm is clicked
    confirmBtn.addEventListener('click', () => {
        // Programmatically trigger the hidden submit button
        document.getElementById('idsToRetrieve').value = ids.join(',');
        document.getElementById('hiddensubmitret').click();
        
        // Hide the popup after submission
        popup.classList.add('hidden');
        

    });

});

</script>

<script>
    // Get the "Select All" button and the checkboxes
const selectAllBtn = document.getElementById('selectAllBtn');
const rowCheckboxes = document.querySelectorAll('.rowCheckbox');

// Event listener for "Select All" button
selectAllBtn.addEventListener('click', function() {
    // Check if all checkboxes are already checked
    let allChecked = Array.from(rowCheckboxes).every(checkbox => checkbox.checked);
    
    // Toggle the checked state of all checkboxes
    rowCheckboxes.forEach(checkbox => {
        checkbox.checked = !allChecked;
    });
});

</script>

<script>
document.addEventListener("DOMContentLoaded", () => {
    // Get the single archive button
    const logoutBtn = document.querySelector('.logout-btn');
    
    // Get popup and other necessary elements
    const popup = document.getElementById('popup-logout');
    const confirmBtn = document.getElementById('confirm-btn-logout');
    const cancelBtn = document.getElementById('cancel-btn-logout');

    // Add event listener to the archive button
    logoutBtn.addEventListener('click', function () {


        // Show the popup
        popup.classList.remove('hidden');
    });

    // Close popup when Cancel is clicked
    cancelBtn.addEventListener('click', () => {
        popup.classList.add('hidden'); // Hide the popup when cancel is clicked
    });

    // Confirm action and submit form when Confirm is clicked
    confirmBtn.addEventListener('click', () => {
        // Redirect directly to logout.php
        window.location.href = 'logout.php';

        // Hide the popup after redirection
        popup.classList.add('hidden');
    });
});
</script>

<script>    
   $("#myTable").on('draw.dt', function(){
        $('#myTable .dataTables_empty').html(`
                <div style="text-align: center; padding: 20px !important; background-color: white !important; margin-top: 20px;">
                    <img src="assets/notfound.png" alt="No Data Available" style="max-width: 500px; display: block;  padding: 0 !important; margin: 0 auto;>
                        <p style="display: none;"><p>
                    <p class="norec">No matching requests found.<p>
                        <p class="norec2">It looks like your search didn’t match any existing requests. Try adjusting your search criteria or check back later.</p>
                </div>
            `);
    });
</script>