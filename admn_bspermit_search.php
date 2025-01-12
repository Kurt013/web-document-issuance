
<style>
form label {
         
         font-size: 1rem;
         color: #012049 !important;
         font-family: "PSemiBold";
         text-align: left;
     }

     .btn-primary {
        font-size: 0.9rem !important;
        margin-left: 4px;
     }
  

         
        form select  {
                font-family: "PMedium" !important;
                font-size: 1rem;
                border-radius: 5px;
                border: 2px solid #012049;
                padding: 0 5px;
                cursor: pointer;
                margin-left: 5px;
                text-align: center;
                margin-bottom: 10px;
                color: #012049;
                            
            }

            th:nth-child(5),  /* Issuance No. */
            td:nth-child(5),  /* Issuance No. */
            th:nth-child(7),  /* Business Name */
            td:nth-child(7),            
            th:nth-child(8),  /* Issuance No. */
            td:nth-child(8),  /* Issuance No. */
            th:nth-child(9),  /* Business Name */
            td:nth-child(9),            
            th:nth-child(10),  /* Issuance No. */
            td:nth-child(10),  /* Issuance No. */
            th:nth-child(11),  /* Business Name */
            td:nth-child(11) { /* Business Name */
             display: none; /* Hide the columns */
    }


            .form-control option:hover {
        background-color: #2c91c9; /* Light gray background on hover */
        color: #000; /* Darker text on hover */
}



        .form-control:focus {
    border-color: black; /* Highlight border on focus */
    box-shadow: 0 0 5px rgba(52, 152, 219, 0.3); /* Subtle shadow on focus */
  
    
}

.form-buttons {
    display: flex; /* Aligns forms in a row */
    gap: 10px; /* Adds space between the buttons */    align-items: center; /* Ensures buttons align vertically */
}

.form-buttons form {
    margin: 0; /* Removes default margins from forms */
}

.btnexpex, .btnexpdf {
    padding: 5px 20px; /* Adjusts button size */
    font-size: 16px; /* Adjusts font size */
    border: 2px solid #012049; /* Adds a border */
    border-radius: 5px; /* Rounds button corners */
    background-color: white; /* Light background color */
    font-family: "PSemiBold";
    cursor: pointer; /* Changes cursor to pointer */
    margin-bottom: 30px;
}
.btnexpex {
    color: #388E3C;
    border: 2px solid #388E3C; 
}

.btnexpdf {
    color: #D32F2F;
    border: 2px solid #D32F2F; 
}
.btnexpex i,.btnexpdf i {
    margin-right: 5px; /* Adds spacing between icon and text */

}

.btnexpex:hover {
    background-color: #388E3C; /* Darker background on hover */
    color: white; /* White text on hover */
}

.btnexpdf:hover {
    background-color: #D32F2F; /* Darker background on hover */
    color: white; /* White text on hover */
}

.toasterr {
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
        max-width: 650px;
        /* Optional: limit the maximum width */
        white-space: nowrap;
        /* Prevent the text from wrapping to the next line */
    }


    .toasterr.active {
        transform: translateX(0%);
        opacity: 1 !important;
        visibility: visible;
    }

    .toasterr .toasterr-content {
        display: flex;
        align-items: center;
    }

    .toasterr-content .check {
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

    .toasterr-content .message {
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

    .toasterr .close {
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

    .toasterr .close-error {
        color: #D32F2F !important;
    }

    .toasterr .close:hover {

        color: #4070f4 !important;
    }

    .toasterr .close-error:hover {
        color: #D32F2F !important;
    }

    .toasterr .progresserr {
        position: absolute;
        bottom: 0;
        left: 0;
        height: 3px;
        width: 100%;
        background: #ddd !important;
    }

    .toasterr .progresserr:before {
        content: "";
        position: absolute;
        bottom: 0;
        right: 0;
        height: 100%;
        width: 100%;
        background-color: #4070f4;
    }

    .toasterr .progresserr-error:before {

        background-color: #D32F2F;
    }

    .progresserr.active:before {
        animation: progress 5s linear forwards;
    }

    @keyframes progress {
        100% {
            right: 100%;
        }
    }

.comfirm-slt, .cancel-btn-slt {
    padding: 10px 20px;
    font-size: 16px;
    border: none;
    cursor: pointer;
    border-radius: 5px;
}


.popup-slt {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    opacity: 0;
    visibility: hidden;
    align-items: center;
    background-color: rgba(0, 0, 0, 0.4);
    box-sizing: content-box;
    z-index: 1000000;
}

.popup-content-slt {
    background-color: white;
    padding: 30px;
    border-radius: 10px;
    text-align: center;
    width: 400px;
    white-space:initial;
}

.popup-content-slt h2 {
    margin-bottom: 10px;
    font-size: 1.3rem;
    font-family: "PBold";
}

.popup-content-slt p {
    font-size: 14px;
    color: #666;
    margin-bottom: 20px;
}

.popup-buttons-slt {
    display: flex;
    justify-content: space-around;
}

.confirm-slt {
    background-color: #D32F2F;
    color: white;
}

.cancel-btn-slt, .cancel-btn-slt:hover {
    background-color: white;
    color: #d32f2f;
    border: 2px solid #d32f2f;
}



.popup-slt.active {
  
    opacity: 1;
    visibility: visible;
}

.comfirm-slt, .cancel-btn-slt {
    padding: 10px 30px;
    border-radius: 5px;
    font-weight: bold;
    cursor: pointer;
}

    </style>
<?php include('popup-toast.php'); ?>

<!-- Alert Component -->
<div class="toasterr" style = "border-left: 6px solid #D32F2F;" >
                <div class="toasterr-content">
                    <i class="fas fa-exclamation-triangle check" style = "background-color: #D32F2F;"></i>
                    <div class="message">
                        <span class="text text-1">Error</span>
                        <span class="text text-2">Please select at least one row</span>
                    </div>
                </div>
                <i class="fa-solid fa-xmark close close-error"  onclick="closeToast()"></i>
                <div class="progresserr progresserr-error"></div>
            </div>


            <div id="popup-slt" class="popup-slt">
    <div class="popup-content-slt">
        <h2>Are you sure to proceed?</h2>
        <p>This will modify your current view and may impact navigation within the system.</p>

        <div class="popup-buttons-slt">
            <button id="confirm-btn-slt" class="confirm-slt">Confirm</button>
            <button id="cancel-btn-slt" class="cancel-btn-slt">Cancel</button>
        </div>
    </div>
</div>




<?php

    include('popup-confirm.php'); 

    $from = isset($_POST['from']) ? date('Y-m-d', strtotime($_POST['from'])) : date('Y-m-d');
    $to = isset($_POST['to']) ? date('Y-m-d', strtotime($_POST['to'])) : date('Y-m-d');

	if(isset($_POST['search_bspermit'])){
		$keyword = $_POST['keyword'];

?>
        <?php if (!empty($toast)): ?>
        <?= $toast; ?>
    <?php endif; ?>
    <div style="float: right; align-items:right; margin-bottom: -40px; position: relative; z-index: 10;">
    <form class="form-select" method="GET" action="">
        <label for="list">Select List: </label>
        <select name="list" id="list" onchange="this.form.submit()">
            <option value="active" <?= (isset($_GET['list']) && $_GET['list'] == 'active') ? 'selected' : ''; ?>>Active</option>
            <option value="archived" <?= (isset($_GET['list']) && $_GET['list'] == 'archived') ? 'selected' : ''; ?>>Archived</option>
        </select>
    </form>
</div>

 
<table class="table table-border table-striped custom-table datatable mb-0" id="myTable">
<thead class="alert-info">
    <tr>
        <th> </th>
        <th> Issuance No. </th>
        <th> Surname </th>
        <th> First Name </th>
        <th> Middle Initial</th>
        <th> Business Name </th>
        <th> House No. </th>
        <th> Street </th>
        <th> Barangay </th>
        <th> City </th>
        <th> Municipality </th>
        <th> Business Industry </th>
        <th> AoE </th>
        <th></th>
    </tr>
</thead>


<tbody>     
    <?php
            $list === 'active' ?

            $stmt = $conn->prepare("
                SELECT *
                FROM
                    tbl_bspermit
                WHERE
                    (id_bspermit like ? OR
                        `lname` LIKE ? OR  
                        `mi` LIKE ? OR  
                        `fname` LIKE ? OR 
                        `bshouseno` LIKE ? OR
                        `bsstreet` LIKE ? OR 
                        `bsbrgy` LIKE ? OR 
                        `bscity` LIKE ? OR 
                        `bsmunicipality` LIKE ? OR 
                        `bsname` LIKE ? OR
                        bsindustry LIKE ? OR
                        aoe LIKE ? OR
                        created_by LIKE ? OR
                        created_on LIKE ?) 
                    AND `doc_status` = ? ORDER BY created_on DESC
                    ") : 
            $stmt = $conn->prepare("
                SELECT *
                FROM
                    tbl_bspermit_archive
                WHERE
                    (id_bspermit LIKE ? OR
                    `lname` LIKE ? OR  
                    `mi` LIKE ? OR  
                    `fname` LIKE ? OR 
                    `bshouseno` LIKE ? OR
                    `bsstreet` LIKE ? OR 
                    `bsbrgy` LIKE ? OR 
                    `bscity` LIKE ? OR 
                    `bsmunicipality` LIKE ? OR 
                    `bsname` LIKE ? OR
                    bsindustry LIKE ? OR
                    aoe LIKE ? OR
                    archived_on LIKE ? OR
                    archived_by LIKE ?)
                        AND (date(archived_on) BETWEEN ? AND ?) ORDER BY archived_on DESC
                ");

        $keywordLike = "%$keyword%";
        $pendingStatus = 'accepted';
        
        $list === 'active' ?
            $stmt->execute([
                $keywordLike, $keywordLike, $keywordLike, $keywordLike, 
                $keywordLike, $keywordLike, $keywordLike, $keywordLike, 
                $keywordLike, $keywordLike, $keywordLike, $keywordLike,
                $keywordLike, $keywordLike, $pendingStatus, $from, $to
            ]):
            $stmt->execute([
                $keywordLike, $keywordLike, $keywordLike, $keywordLike, 
                $keywordLike, $keywordLike, $keywordLike, $keywordLike, 
                $keywordLike, $keywordLike, $keywordLike, $keywordLike,
                $keywordLike, $keywordLike, $from, $to
            ]);
        
        $views = $stmt->fetchAll();
        if ($stmt->rowCount() > 0) {
            foreach ($views as $view) {
    ?>
        <tr>
            <td><input type="checkbox" class="rowCheckbox" value="<?= $view['id_bspermit']; ?>"></td>           
            <td> <?= $view['id_bspermit'];?> </td> 
            <td> <?= $view['lname'];?> </td>
            <td> <?= $view['fname'];?> </td>
            <td> <?= $view['mi'];?> </td>
            <td> <?= $view['bsname'];?> </td>
            <td> <?= $view['bshouseno'];?> </td>
            <td> <?= $view['bsstreet'];?> </td>
            <td> <?= $view['bsbrgy'];?> </td>
            <td> <?= $view['bscity'];?> </td>
            <td> <?= $view['bsmunicipality'];?> </td>
            <td> <?= $view['bsindustry'];?> </td>
            <td> <?= $view['aoe'];?> </td>
            <td>    
            <form id="archiveForm" action="" method="post">
                <a class="btn btn-success" target="_blank" style="width: 70px; font-size: 17px; border-radius:30px; margin-bottom: 2px;" href="bspermit_form.php?id_bspermit=<?= $view['id_bspermit'];?><?php if ($list === 'archived') echo '&status=archived';?>"> <i class="fas fa-cogs"></i></a> 
                <input type="hidden" name="id" value="<?= $userdetails['id'];?>">
                <input type="hidden" name="id_bspermit" value="<?= $view['id_bspermit'];?>">
                <button type="submit" id="hiddenSubmitBtn" style="display:none;" name="archive_bspermit">Submit</button>
                <?php
echo $list === 'active' ? 
    // Display both buttons if the status is active
    
'<a href="javascript:void(0);" class="btn btn-primary" onclick="openPopup(\'view_bspermit.php?id_bspermit=' . urlencode($view['id_bspermit']) . '\')" style="width: 70px; font-size: 17px; border-radius:30px;">
    <i class="fa fa-eye"></i>
</a>' :
    
    // Display only the unarchive button if the status is not active
    '<button class="btn btn-danger" type="submit" style="width: 70px; font-size: 17px; border-radius:30px;" name="unarchive_bspermit">  <i class="fas fa-undo"></i> </button>';
?>
   
         
            </form>
            </td>
        </tr>
    <?php
    }
}

    ?>
</tbody>


</table>
<script>
document.addEventListener("DOMContentLoaded", () => {
    // Get all archive buttons
    const openPopupBtns = document.querySelectorAll('.archive-btn');
    
    // Get popup and other necessary elements
    const popup = document.getElementById('popup');
    const confirmBtn = document.getElementById('confirm-btn');
    const cancelBtn = document.getElementById('cancel-btn');
    const archiveForm = document.getElementById('archiveForm');
    const hiddenSubmitBtn = document.getElementById('hiddenSubmitBtn');  // Hidden submit button

    // Loop through all archive buttons and add event listeners
    openPopupBtns.forEach((openPopupBtn) => {
        openPopupBtn.addEventListener('click', function () {
            const dataId = this.closest('form').querySelector('input[name="id_bspermit"]').value;
            // Store the ID in the form's data-id (or set a hidden input value if necessary)
            archiveForm.querySelector('input[name="id_bspermit"]').value = dataId; // Set the correct id_indigency
            
            // Show the popup
            popup.classList.remove('hidden'); 
        });
    });

    // Close popup when Cancel is clicked
    cancelBtn.addEventListener('click', () => {
        popup.classList.add('hidden'); // Hide the popup when cancel is clicked
    });

    // Confirm action and submit form when Confirm is clicked
    confirmBtn.addEventListener('click', () => {
        // Programmatically trigger the hidden submit button
        hiddenSubmitBtn.click();  // Click the hidden submit button
        
        // Hide the popup after submission
        popup.classList.add('hidden');
        

    });
});
</script>
<?php		
	}else{

?>
 <div style="float: right; align-items:right; margin-bottom: -40px; position: relative; z-index: 10;">
    <form class="form-select" method="GET" action="">
        <label for="list">Select List: </label>
        <select name="list" id="list" onchange="this.form.submit()">
            <option value="active" <?= (isset($_GET['list']) && $_GET['list'] == 'active') ? 'selected' : ''; ?>>Active</option>
            <option value="archived" <?= (isset($_GET['list']) && $_GET['list'] == 'archived') ? 'selected' : ''; ?>>Archived</option>
        </select>
    </form>
</div>
<table class="table table-border table-striped custom-table datatable mb-0" id="myTable">


<thead class="alert-info">
    <tr>
        <th> </th>
        <th> Issuance No.</th>
        <th> Surname </th>
        <th> First Name </th>
        <th> Middle Initial </th> <!-- hide -->
        <th> Business Name </th> 
        <th> House No. </th> <!-- hide -->
        <th> Street </th> <!-- hide -->
        <th> Barangay </th> <!-- hide -->
        <th> City </th> <!-- hide -->
        <th> Municipality </th> <!-- hide -->
        <th> Business Industry </th>
        <th> AoE</th>
        <th> </th>
    </tr>
</thead>

<tbody>     
    <?php
        $pendingStatus = 'accepted';

        if ($list === 'active') {
            $stmt = $conn->prepare("SELECT * FROM tbl_bspermit WHERE doc_status = ?");
            $stmt->execute([$pendingStatus]);
        } else {
            $stmt = $conn->prepare("SELECT * FROM tbl_bspermit_archive");
            $stmt->execute();
        }
        $views = $stmt->fetchAll();
        if ($stmt->rowCount() > 0) {
            foreach ($views as $view){
                
    ?>
        <tr>

            <td><input type="checkbox" class="rowCheckbox" value="<?= $view['id_bspermit']; ?>"></td>           
            <td> <?= $view['id_bspermit'];?> </td> 
            <td> <?= $view['lname'];?> </td>
            <td> <?= $view['fname'];?> </td>
            <td> <?= $view['mi'];?> </td>
            <td> <?= $view['bsname'];?> </td>
            <td> <?= $view['bshouseno'];?> </td>
            <td> <?= $view['bsstreet'];?> </td>
            <td> <?= $view['bsbrgy'];?> </td>
            <td> <?= $view['bscity'];?> </td>
            <td> <?= $view['bsmunicipality'];?> </td>
            <td> <?= $view['bsindustry'];?> </td>
            <td> <?= $view['aoe'];?> </td>
            <td>    
            <form id="archiveForm" action="" method="post">
                <a class="btn btn-success" target="_blank" style="width: 70px; font-size: 17px; border-radius:30px; margin-bottom: 2px;" href="bspermit_form.php?id_bspermit=<?= $view['id_bspermit'];?><?php if ($list === 'archived') echo '&status=archived';?>"> <i class="fas fa-cogs"></i></a> 
                <input type="hidden" name="id" value="<?= $userdetails['id'];?>">
                <input type="hidden" name="id_bspermit" value="<?= $view['id_bspermit'];?>">
                <button type="submit" id="hiddenSubmitBtn" style="display:none;" name="archive_bspermit">Submit</button>
                <?php
echo $list === 'active' ? 
    // Display both buttons if the status is active
    
'<a href="javascript:void(0);" class="btn btn-primary" onclick="openPopup(\'view_bspermit.php?id_bspermit=' . urlencode($view['id_bspermit']) . '\')" style="width: 70px; font-size: 17px; border-radius:30px;">
    <i class="fa fa-eye"></i>
</a>' :
    
    // Display only the unarchive button if the status is not active
    '<button class="btn btn-danger" type="submit" style="width: 70px; font-size: 17px; border-radius:30px;" name="unarchive_bspermit">  <i class="fas fa-undo"></i> </button>';
?>
   
         
            </form>
            </td>
            </tr>
            <?php
        }
    }

    ?>            </table>
    <?php if ($list === 'active') { ?>

            <form id="archiveSelect" action="" method="post">

                <input type="hidden" name="ids_to_archive" id="idsToArchive">
                <input type="hidden" name="id" value="<?= $userdetails['id'];?>">
                <input type="hidden" name="id_bspermit" value="<?= $view['id_bspermit'];?>">
                <button type="submit" class="btn btn-danger" id="archiveSelected" style="margin-bottom: 10px;" name="archive_selected_bspermit">
        Archive Selected
    </button>
            </form>
            <?php } ?>




<?php
	}

    $viewsJson = json_encode($views);
    $list === 'archived' ?
        $tableName = 'tbl_bspermit_archive' :
        $tableName = 'tbl_bspermit';
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>  <!-- Updated jQuery -->
<script src="assets/js/popper.min.js"></script>  <!-- Keep if using Bootstrap tooltips/popovers -->
<script src="assets/js/bootstrap.min.js"></script>  <!-- Keep for Bootstrap components -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>  <!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">  <!-- DataTables CSS -->
<script src="assets/js/app.js"></script>  <!-- Your custom logic -->

    <script>
        $(document).ready(function() {
    $('#myTable').DataTable({
        stateSave: true
    });
});

    </script>
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
    const popup_slt = document.getElementById('popup-slt');
    const confirmBtn_slt = document.getElementById('confirm-slt');
    const cancelBtn_slt = document.getElementById('cancel-btn-slt');

    if (ids.length === 0) {
        event.preventDefault(); // Prevent the form or default action
        toast.classList.add("active");
        progress.classList.add("active");

        // Set timers to hide the toast and progress after 5 seconds
        setTimeout(() => {
            toast.classList.remove("active");
        }, 5000);

        setTimeout(() => {
            progress.classList.remove("active");;
        }, 5000);

        return; // Stop further execution
    }
   else {
    popup_slt.classList.add("active");

   }
    // Set the collected IDs to the hidden input field
    document.getElementById('idsToArchive').value = ids.join(',');

    // Allow form submission
});

// Function to manually close the alert
function closeAlert() {
    document.getElementById('customAlert').style.display = 'none';
}


</script>


<?php if ($list === 'archived') { ?>
    <div class="form-buttons">
        <form action="./export_to_pdf.php" method="POST" target="_blank">
            <button name="export_pdf" class="btnexpdf" ><i class="fas fa-file-pdf"></i>Export to PDF</button>
            <input type="hidden" name="views_data" value="<?php echo htmlspecialchars($viewsJson, ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" name="table_name" value="<?= $tableName ?>">
        </form>
        <form action="./export_to_excel.php" method="POST" target="_blank">
            <button name="export_excel" class="btnexpex"><i class="fas fa-file-excel"></i>Export to Excel</button>
            <input type="hidden" name="views_data" value="<?php echo htmlspecialchars($viewsJson, ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" name="table_name" value="<?= $tableName ?>">
        </form>
    </div>
<?php } ?>
