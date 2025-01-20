
<style>

            th:nth-child(6),  /* Issuance No. */
            td:nth-child(6),  /* Issuance No. */
            th:nth-child(7),  /* Business Name */
            td:nth-child(7),            
            th:nth-child(8),  /* Issuance No. */
            td:nth-child(8),  /* Issuance No. */
            th:nth-child(9),  /* Business Name */
            td:nth-child(9),            
            th:nth-child(10),  /* Issuance No. */
            td:nth-child(10),  /* Issuance No. */
            th:nth-child(11),  /* Business Name */
            td:nth-child(11),
            th:nth-child(15),  /* Business Name */
            td:nth-child(15), 
            th:nth-child(16),  /* Business Name */
            td:nth-child(16),
            th:nth-child(17),  /* Business Name */
            td:nth-child(17){ /* Business Name */
             display: none; /* Hide the columns */
    }


</style>


<!-- Alert Component -->
<div class="toasterr" id = "toasterr" style = "border-left: 6px solid #D32F2F;" >
                <div class="toasterr-content">
                    <i class="fas fa-exclamation-triangle check" style = "background-color: #D32F2F;"></i>
                    <div class="message">
                        <span class="text text-1">Error</span>
                        <span class="text text-2">Please select at least one row</span>
                    </div>
                </div>
                <i class="fa-solid fa-xmark close close-error"  onclick="closeToasterr()"></i>
                <div class="progresserr progresserr-error"></div>
            </div>

            <div style="float: right; align-items:right; margin-bottom: -40px; position: relative; z-index: 10;">
        <form class="form-select" method="GET" action="">
            <label class = "selectlabel" for="list">Select List: </label>
            <select name="list" id="list" class = "selectlist" onchange="this.form.submit()">
                <option value="active" <?= (isset($_GET['list']) && $_GET['list'] == 'active') ? 'selected' : ''; ?>>Active</option>
                <option value="archived" <?= (isset($_GET['list']) && $_GET['list'] == 'archived') ? 'selected' : ''; ?>>Archived</option>
            </select>
        </form>
    </div>

   
<?php if ($list === 'active') { ?>
    <?php

$sql = "SELECT * FROM tbl_brgyid WHERE doc_status = :doc_status";
$stmt = $conn->prepare($sql);

// Bind the parameter
$doc_status = 'accepted';
$stmt->bindParam(':doc_status', $doc_status, PDO::PARAM_STR);

// Execute the statement
$stmt->execute();

// Fetch all rows
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

 

if (count($result) == 0) {
    echo '
    <div style="text-align: center; padding: 20px !important; margin-top: 20px; margin-bottom: 50px">
        <img src="assets/emptystate.png" alt="No Data Available" style="max-width: 600px; display: block; padding: 0 !important; margin: 0 auto;">
        <p class="norec">Oops! No active requests right now.</p>
        <p class="norec2">Currently, there are no active requests in your list. Click the button below to scan a QR code and quickly add a new request.</p>
        <!-- Button added below the text -->
<button class="btnqr" onclick="window.location.href=\'admn_scanqrcode.php\';">
    <i class="fas fa-qrcode" style="margin-right: 8px;"></i> Scan QR Code
</button>
    </div>';

    return;
} 
?>
<?php } ?>

<?php if ($list === 'archived') { ?>
    <?php

$sql = "SELECT * FROM tbl_brgyid WHERE doc_status = :doc_status";
$stmt = $conn->prepare($sql);

// Bind the parameter
$doc_status = 'archived';
$stmt->bindParam(':doc_status', $doc_status, PDO::PARAM_STR);

// Execute the statement
$stmt->execute();

// Fetch all rows
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);


if (count($result) == 0) {
    echo '
    <div style="text-align: center; padding: 20px !important; margin-top: 20px; margin-bottom: 50px">
        <img src="assets/emptystate.png" alt="No Data Available" style="max-width: 600px; display: block; padding: 0 !important; margin: 0 auto;">
        <p class="norec">There are currently no archived requests.</p>
        <p class="norec2">It looks like there are no archived requests in your list. You can add new requests or check back later.</p>
        <!-- Button added below the text -->
<button class="btnqr" onclick="window.location.href=\'admn_scanqrcode.php\';">
    <i class="fas fa-qrcode" style="margin-right: 8px;"></i> Scan QR Code
</button>
    </div>';

    return;
} 
?>
<?php } ?>

<?php
    $from = isset($_POST['from']) ? date('Y-m-d', strtotime($_POST['from'])) : date('Y-m-d');
    $to = isset($_POST['to']) ? date('Y-m-d', strtotime($_POST['to'])) : date('Y-m-d');

	if(isset($_POST['search_brgyid'])){
		$keyword = $_POST['keyword'];

?>
        <?php if (!empty($toast)): ?>
        <?= $toast; ?>
    <?php endif; ?>

 
<table class="table table-border table-striped custom-table datatable mb-0" id="myTable">
<thead class="alert-info">
    <tr>
        <th> </th>
        <th> Photo</th>
        <th> ID No. </th>
        <th> Surname </th>
        <th> First Name </th>
        <th> Middle Initial</th>
        <th> House No. </th>
        <th> Street </th>
        <th> Barangay </th>
        <th> City </th>
        <th> Municipality </th>
        <th> Birthdate </th>
        <th> Civil Status </th>
        <th> Precint No. </th>
        <th> Emergency Contact Person</th>
        <th> Emergency Contact Number </th>
        <th> Payment </th>
        <th></th>
    </tr>
</thead>


<tbody>     
    <?php
            $list === 'active' ?

            $stmt = $conn->prepare("
                SELECT *
                FROM
                    tbl_brgyid
                WHERE
                    (id_brgyid like ? OR
                        `lname` LIKE ? OR  
                        `mi` LIKE ? OR  
                        `fname` LIKE ? OR 
                        `houseno` LIKE ? OR
                        `street` LIKE ? OR 
                        `brgy` LIKE ? OR 
                        `city` LIKE ? OR 
                        `municipality` LIKE ? OR 
                        `bdate` LIKE ? OR
                        status LIKE ? OR
                        precint_no LIKE ? OR
                        inc_lname LIKE ? OR
                        inc_fname LIKE ? OR
                        inc_mi LIKE ? OR
                        inc_contact LIKE ? OR
                        inc_houseno LIKE ? OR
                        inc_street LIKE ? OR
                        inc_brgy LIKE ? OR
                        inc_city LIKE ? OR
                        inc_municipality LIKE ? OR
                        valid_until LIKE ? OR
                        price LIKE ? OR
                        created_on LIKE ? OR
                        created_by LIKE ?) 
                    AND `doc_status` = ? ORDER BY created_on DESC
                    ") : 
            $stmt = $conn->prepare("
                SELECT *
                FROM
                    tbl_brgyid
                WHERE
                    (id_brgyid like ? OR
                        `lname` LIKE ? OR  
                        `mi` LIKE ? OR  
                        `fname` LIKE ? OR 
                        `houseno` LIKE ? OR
                        `street` LIKE ? OR 
                        `brgy` LIKE ? OR 
                        `city` LIKE ? OR 
                        `municipality` LIKE ? OR 
                        `bdate` LIKE ? OR
                        status LIKE ? OR
                        precint_no LIKE ? OR
                        inc_lname LIKE ? OR
                        inc_fname LIKE ? OR
                        inc_mi LIKE ? OR
                        inc_contact LIKE ? OR
                        inc_houseno LIKE ? OR
                        inc_street LIKE ? OR
                        inc_brgy LIKE ? OR
                        inc_city LIKE ? OR
                        inc_municipality LIKE ? OR
                        valid_until LIKE ? OR
                        price LIKE ? OR
                        created_on LIKE ? OR
                        created_by LIKE ?)
                    AND doc_status = ?
                    AND (date(created_on) BETWEEN ? AND ?) ORDER BY created_on DESC
                ");

        $keywordLike = "%$keyword%";
        $pendingStatus = 'accepted';
        
        $list === 'active' ?
            $stmt->execute([
                $keywordLike, $keywordLike, $keywordLike, $keywordLike, 
                $keywordLike, $keywordLike, $keywordLike, $keywordLike, 
                $keywordLike, $keywordLike, $keywordLike, $keywordLike,
                $keywordLike, $keywordLike, $keywordLike, $keywordLike,
                $keywordLike, $keywordLike, $keywordLike, $keywordLike,
                $keywordLike, $keywordLike, $keywordLike, $keywordLike,
                $keywordLike, $pendingStatus,
            ]):
            $stmt->execute([
                $keywordLike, $keywordLike, $keywordLike, $keywordLike, 
                $keywordLike, $keywordLike, $keywordLike, $keywordLike, 
                $keywordLike, $keywordLike, $keywordLike, $keywordLike, 
                $keywordLike, $keywordLike, $keywordLike, $keywordLike, 
                $keywordLike, $keywordLike, $keywordLike, $keywordLike, 
                $keywordLike, $keywordLike, $keywordLike, $keywordLike,
                $keywordLike, $list, $from, $to
            ]);
        
        $views = $stmt->fetchAll();
        if ($stmt->rowCount() > 0) {
            foreach ($views as $view) {
    ?>
        <tr>
            <td><input type="checkbox" class="rowCheckbox" value="<?= $view['id_brgyid']; ?>"></td>           
            <td> <?= $staffbmis->convertToImg($view['res_photo']);?> </td> 
            <td> <?= $view['id_brgyid'];?> </td> 
            <td> <?= $view['lname'];?> </td>
            <td> <?= $view['fname'];?> </td>
            <td> <?= $view['mi'];?> </td>
            <td> <?= $view['houseno'];?> </td>
            <td> <?= $view['street'];?> </td>
            <td> <?= $view['brgy'];?> </td>
            <td> <?= $view['city'];?> </td>
            <td> <?= $view['municipality'];?> </td>
            <td> <?= $view['bdate'];?> </td>
            <td> <?= $view['status'];?> </td>
            <td> <?= $view['precint_no'];?> </td>
            <td> <?= $view['inc_lname'] ?>, <?= $view['inc_fname'] ?> </td>
            <td> <?= $view['inc_contact'];?> </td>
            <td> <?= $view['price'];?> </td>
            <td>    
            <form id="archiveForm" action="" method="post">
                <a class="btn btn-success" target="_blank" title = "Generate" style="width: 70px; font-size: 17px; border-radius:30px; margin-bottom: 2px;" href="brgyid_form.php?id_brgyid=<?= $view['id_brgyid'];?><?php if ($list === 'archived') echo '&status=archived';?>"> <i class="fas fa-cogs"></i></a> 
                <input type="hidden" name="id" value="<?= $userdetails['id'];?>">
                <input type="hidden" name="id_brgyid" value="<?= $view['id_brgyid'];?>">
                <button type="submit" id="hiddenSubmitBtn" style="display:none;" name="archive_brgyid">Submit</button>
                <?php
echo $list === 'active' ? 
// Display both buttons if the status is active

'<a href="javascript:void(0);" class="btn btn-primary" title = "View Details" onclick="openPopup(\'view_brgyid.php?id_brgyid=' . urlencode($view['id_brgyid']) . '\')" style="width: 70px; font-size: 17px; border-radius:30px;">
<i class="fa fa-eye"></i>
</a>' :

// Display only the unarchive button if the status is not active
'<a href="javascript:void(0);" class="btn btn-primary" title = "View Details" onclick="openPopup(\'view_brgyid_archive.php?id_brgyid=' . urlencode($view['id_brgyid']) . '\')" style="width: 70px; font-size: 17px; border-radius:30px;">
<i class="fa fa-eye"></i>
</a>';
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
<?php		
	}else{

?>
 <div style="float: right; align-items:right; margin-bottom: -40px; position: relative; z-index: 10;">
    <form class="form-select" method="GET" action="">
        <label class = "selectlabel" for="list">Select List: </label>
        <select name="list" id="list" class = "selectlist" onchange="this.form.submit()">
            <option value="active" <?= (isset($_GET['list']) && $_GET['list'] == 'active') ? 'selected' : ''; ?>>Active</option>
            <option value="archived" <?= (isset($_GET['list']) && $_GET['list'] == 'archived') ? 'selected' : ''; ?>>Archived</option>
        </select>
    </form>
</div>
<table class="table table-border table-striped custom-table datatable mb-0" id="myTable">


<thead class="alert-info">
    <tr>
        <th> </th>
        <th> Photo</th> 
        <th> ID No. </th> 
        <th> Surname </th>
        <th> First Name </th>
        <th> Middle Initial</th> <!-- hide -->
        <th> House No. </th> <!-- hide -->
        <th> Street </th> <!-- hide -->
        <th> Barangay </th> <!-- hide -->
        <th> City </th> <!-- hide -->
        <th> Municipality </th> <!-- hide -->
        <th> Birthdate </th> 
        <th> Civil Status </th> 
        <th> Precint No. </th>
        <th> Emergency Contact Person</th> <!-- hide -->
        <th> Emergency Contact Number </th> <!-- hide -->
        <th> Payment </th>
        <th></th>
    </tr>
</thead>

<tbody>     
    <?php
        $pendingStatus = 'accepted';

        if ($list === 'active') {
            $stmt = $conn->prepare("SELECT * FROM tbl_brgyid WHERE doc_status = ? ORDER BY created_on DESC");
            $stmt->execute([$pendingStatus]);
        } else {
            $stmt = $conn->prepare("SELECT * FROM tbl_brgyid WHERE doc_status = ? ORDER BY created_on DESC");
            $stmt->execute([$list]);
        }
        $views = $stmt->fetchAll();
        if ($stmt->rowCount() > 0) {
            foreach ($views as $view){
                
    ?>
        <tr>

            <td><input type="checkbox" class="rowCheckbox" value="<?= $view['id_brgyid']; ?>"></td>           
            <td> <?= $staffbmis->convertToImg($view['res_photo']);?> </td> 
            <td> <?= $view['id_brgyid'];?> </td> 
            <td> <?= $view['lname'];?> </td>
            <td> <?= $view['fname'];?> </td>
            <td> <?= $view['mi'];?> </td>
            <td> <?= $view['houseno'];?> </td>
            <td> <?= $view['street'];?> </td>
            <td> <?= $view['brgy'];?> </td>
            <td> <?= $view['city'];?> </td>
            <td> <?= $view['municipality'];?> </td>
            <td> <?= $view['bdate'];?> </td>
            <td> <?= $view['status'];?> </td>
            <td> <?= $view['precint_no'];?> </td>
            <td> <?= $view['inc_lname'] ?>, <?= $view['inc_fname'] ?> </td>
            <td> <?= $view['inc_contact'];?> </td>
            <td> <?= $view['price'];?> </td>
            <td>    
            <form id="archiveForm" action="" method="post">
                <a class="btn btn-success" target="_blank" title = "Generate" style="width: 70px; font-size: 17px; border-radius:30px; margin-bottom: 2px;" href="brgyid_form.php?id_brgyid=<?= $view['id_brgyid'];?><?php if ($list === 'archived') echo '&status=archived';?>"> <i class="fas fa-cogs"></i></a> 
                <input type="hidden" name="id" value="<?= $userdetails['id'];?>">
                <input type="hidden" name="id_brgyid" value="<?= $view['id_brgyid'];?>">
                <?php
echo $list === 'active' ? 
    // Display both buttons if the status is active
    
'<a href="javascript:void(0);" class="btn btn-primary" title = "View Details" onclick="openPopup(\'view_brgyid.php?id_brgyid=' . urlencode($view['id_brgyid']) . '\')" style="width: 70px; font-size: 17px; border-radius:30px;">
    <i class="fa fa-eye"></i>
</a>' :
    
    // Display only the unarchive button if the status is not active
    '<a href="javascript:void(0);" class="btn btn-primary" title = "View Details" onclick="openPopup(\'view_brgyid_archive.php?id_brgyid=' . urlencode($view['id_brgyid']) . '\')" style="width: 70px; font-size: 17px; border-radius:30px;">
    <i class="fa fa-eye"></i>
</a>';
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

 <?php
	}
    $viewsJson = json_encode(array_map(function($view) {
        unset($view['res_photo']); // Remove 'res_photo' field
        return $view;
    }, $views));
    $tableName = 'tbl_brgyid';
?>

 <?php if ($list === 'active') { ?>
    <form id="archiveSelect" action="" method="post">
        <input type="hidden" name="ids_to_archive" id="idsToArchive">
        <input type="hidden" name="id" value="<?= htmlspecialchars($userdetails['id'], ENT_QUOTES); ?>">
        <input type="hidden" name="id_brgyid" value="<?= htmlspecialchars($view['id_brgyid'], ENT_QUOTES); ?>">

        <!-- Actual Submit Button -->
        <button type="submit" class="btn btn-danger" id="hiddensubmitslt" style="display: none;" name="archive_selected_brgyid">
            Archive Selected
        </button>


    </form>
<?php } ?>

<?php if ($list === 'archived') { ?>
    <form id="retrieveSelect" action="" method="post">
        <input type="hidden" name="ids_to_retrieve" id="idsToRetrieve">
        <input type="hidden" name="id" value="<?= htmlspecialchars($userdetails['id'], ENT_QUOTES); ?>">
        <input type="hidden" name="id_brgyid" value="<?= htmlspecialchars($view['id_brgyid'], ENT_QUOTES); ?>">

        <!-- Actual Submit Button -->
        <button type="submit" class="btn btn-danger" id="hiddensubmitret" style="display: none;" name="retrieve_selected_brgyid">
            Retrieve Selected
        </button>

    </form>
<?php } ?>

<?php include('table_script.php'); ?>

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
