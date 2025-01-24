
<style>
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

            <?php if ($list === 'active') { ?>
    <?php

$sql = "SELECT * FROM tbl_clearance WHERE doc_status = :doc_status";
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
    <div style="float: right; align-items:right; margin-bottom: -40px; position: relative; z-index: 10;">
    <form class="form-select" method="GET" action="">
        <label class="selectlabel" for="list">Select List: </label>
        <select name="list" id="list" class="selectlist" onchange="this.form.submit()">
            <option value="active" ' . (isset($_GET['list']) && $_GET['list'] == 'active' ? 'selected' : '') . '>Active</option>
            <option value="archived" ' . (isset($_GET['list']) && $_GET['list'] == 'archived' ? 'selected' : '') . '>Archived</option>
        </select>
    </form>
</div>
    <div style="text-align: center; padding: 20px !important; margin-top: 20px; margin-bottom: 50px">
        <img src="assets/emptyst8.png" alt="No Data Available" style="max-width: 600px; display: block; padding: 0 !important; margin: 0 auto;">
        <p class="norec">Oops! There are no active requests for this document at the moment.</p>
        <p class="norec2">This list is currently empty for this document. Click the button below to scan a QR code and add a new request instantly.</p>
        <!-- Button added below the text -->
<button class="btnqr" onclick="window.location.href=\'admn_scanqrcode.php\';">
    <i class="fas fa-qrcode" style="margin-right: 8px;"></i> Scan QR Code
</button>
    </div>';

    return;
} else {
    
        echo '
        <div class="cols">
            <button type="button" id="selectAllBtn" title="Select All">
                <i class="fas fa-check-square"></i> Select All
            </button>
            <button type="button" class="btn btn-danger" id="archiveSelected" title="Archive Selected">
                <i class="fas fa-archive"></i>
            </button>
        </div>
        <br>';
    } 
} 
?>


<?php if ($list === 'archived') { ?>
    <?php

$sql = "SELECT * FROM tbl_clearance WHERE doc_status = :doc_status";
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
<div style="float: right; align-items:right; margin-bottom: -40px; position: relative; z-index: 10;">
    <form class="form-select" method="GET" action="">
        <label class="selectlabel" for="list">Select List: </label>
        <select name="list" id="list" class="selectlist" onchange="this.form.submit()">
            <option value="active" ' . (isset($_GET['list']) && $_GET['list'] == 'active' ? 'selected' : '') . '>Active</option>
            <option value="archived" ' . (isset($_GET['list']) && $_GET['list'] == 'archived' ? 'selected' : '') . '>Archived</option>
        </select>
    </form>
</div>
    <div style="text-align: center; padding: 20px !important; margin-top: 20px; margin-bottom: 50px">
        <img src="assets/emptyst8.png" alt="No Data Available" style="max-width: 600px; display: block; padding: 0 !important; margin: 0 auto;">
        <p class="norec">There are currently no archived requests for this document.</p>
        <p class="norec2">It looks like there are no archived requests in the list for this document. You can add new requests or check back later.</p>

        <!-- Button added below the text -->
<button class="btnqr" onclick="window.location.href=\'admn_scanqrcode.php\';">
    <i class="fas fa-qrcode" style="margin-right: 8px;"></i> Scan QR Code
</button>
    </div>';

    return;
} else {
    
    echo '
    <div class="cols">
        <button type="button" id="selectAllBtn" title="Select All">
            <i class="fas fa-check-square"></i> Select All
        </button>
        <button type="button" class="btn btn-danger" id="retrieveSelected" title="Retrieve Selected">
            <i class="fas fa-undo"></i>
        </button>
    </div>
    <br>';
} 
} 
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


<?php
    $from = isset($_POST['from']) ? date('Y-m-d', strtotime($_POST['from'])) : date('Y-m-d');
    $to = isset($_POST['to']) ? date('Y-m-d', strtotime($_POST['to'])) : date('Y-m-d');

	if(isset($_POST['search_clearance'])){
		$keyword = $_POST['keyword'];

?>
        <?php if (!empty($toast)): ?>
        <?= $toast; ?>
    <?php endif; ?>
 
<table class="table table-border table-striped custom-table datatable mb-0" id="myTable">
<thead class="alert-info">
    <tr>
        <th> </th>
        <th> Issuance No. </th> 
        <th> Surname </th>
        <th> First Name </th>
        <th> Middle Name </th> 
        <th> Age </th> 
        <th> House Number </th> <!-- hidden -->
        <th> Street </th> <!-- hidden -->
        <th> Barangay </th> <!-- hidden -->
        <th> City </th> <!-- hidden -->
        <th> Municipality </th> <!-- hidden -->
        <th> Purpose </th>
        <!-- delete payment --> <!-- hidden -->
        <th> </th>
    </tr>
</thead>


<tbody>     
    <?php
            $list === 'active' ?

            $stmt = $conn->prepare("
                SELECT *
                FROM
                    tbl_clearance
                WHERE
                    (id_clearance like ? OR
                        `lname` LIKE ? OR  
                        `mi` LIKE ? OR  
                        `fname` LIKE ? OR
                        age LIKE ? OR 
                        `houseno` LIKE ? OR
                        `street` LIKE ? OR 
                        `brgy` LIKE ? OR 
                        `city` LIKE ? OR 
                        `municipality` LIKE ? OR 
                        purpose LIKE ? OR
                        created_by LIKE ? OR
                        created_on LIKE ?) 
                    AND `doc_status` = ? ORDER BY created_on DESC
                    ") : 
            $stmt = $conn->prepare("
                SELECT *
                FROM
                    tbl_clearance
                WHERE
                    (id_clearance LIKE ? OR
                    `lname` LIKE ? OR  
                    `mi` LIKE ? OR  
                    `fname` LIKE ? OR
                    age LIKE ? OR 
                    `houseno` LIKE ? OR
                    `street` LIKE ? OR 
                    `brgy` LIKE ? OR 
                    `city` LIKE ? OR 
                    `municipality` LIKE ? OR 
                    purpose LIKE ? OR
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
                $keywordLike, $keywordLike, $keywordLike, 
                $keywordLike, $keywordLike, $keywordLike, $keywordLike,
                $keywordLike, $keywordLike, $pendingStatus,
            ]):
            $stmt->execute([
                $keywordLike, $keywordLike, $keywordLike, $keywordLike, 
                $keywordLike, $keywordLike, $keywordLike, $keywordLike, 
                $keywordLike, $keywordLike, $keywordLike,
                $keywordLike, $keywordLike, $list, $from, $to
            ]);
        
        $views = $stmt->fetchAll();
        if ($stmt->rowCount() > 0) {
            foreach ($views as $view) {
    ?>
        <tr>
            <td><input type="checkbox" class="rowCheckbox" value="<?= $view['id_clearance']; ?>"></td>           
            <td> <?= $view['id_clearance'];?> </td> 
            <td> <?= $view['lname'];?> </td>
            <td> <?= $view['fname'];?> </td>
            <td> <?= $view['mi'];?> </td>
            <td> <?= $view['age'];?> </td>
            <td> <?= $view['houseno'];?> </td>
            <td> <?= $view['street'];?> </td>
            <td> <?= $view['brgy'];?> </td>
            <td> <?= $view['city'];?> </td>
            <td> <?= $view['municipality'];?> </td>
            <td> <?= $view['purpose'];?> </td>
            <!-- delete payment -->
            <td>    
            <form id="archiveForm" action="" method="post">
                <input type="hidden" name="id" value="<?= $userdetails['fname']; ?> <?= $userdetails['lname'];?>">
                <input type="hidden" name="id_clearance" value="<?= $view['id_clearance'];?>">
                <?php
echo $list === 'active' ? 
// Display both buttons if the status is active
'<a class="btn btn-success" target="_blank" title="Generate" style="width: 70px; font-size: 17px; border-radius:30px; margin-bottom: 2px;" href="clearance_form.php?id_clearance='.$view['id_clearance'].'"> <i class="fas fa-cogs"></i></a>'. 

'<a href="javascript:void(0);" class="btn btn-primary" title="View Details" onclick="openPopup(\'view_clearance.php?id_clearance=' . urlencode($view['id_clearance']) . '\')" style="width: 70px; font-size: 17px; border-radius:30px;">
<i class="fa fa-eye"></i>
</a>' :

// Display only the unarchive button if the status is not active
'<a href="javascript:void(0);" class="btn btn-primary" title="View Details" onclick="openPopup(\'view_clearance_archive.php?id_clearance=' . urlencode($view['id_clearance']) . '\')" style="width: 70px; font-size: 17px; border-radius:30px;">
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
        <th> Issuance No. </th>
        <th> Surname </th>
        <th> First Name </th>
        <th> Middle Name </th>
        <th> Age </th>
        <th> House Number </th>
        <th> Street </th>
        <th> Barangay </th>
        <th> City </th>
        <th> Municipality </th>
        <th> Purpose </th>
        <!-- delete payment -->
        <th> </th>
    </tr>
</thead>

<tbody>     
    <?php
        $pendingStatus = 'accepted';

        if ($list === 'active') {
            $stmt = $conn->prepare("SELECT * FROM tbl_clearance WHERE doc_status = ? ORDER BY created_on DESC");
            $stmt->execute([$pendingStatus]);
        } else {
            $stmt = $conn->prepare("SELECT * FROM tbl_clearance WHERE doc_status = ? ORDER BY created_on DESC");
            $stmt->execute([$list]);
        }
        $views = $stmt->fetchAll();
        if ($stmt->rowCount() > 0) {
            foreach ($views as $view){
                
    ?>
        <tr>

            <td><input type="checkbox" class="rowCheckbox" value="<?= $view['id_clearance']; ?>"></td>           
            <td> <?= $view['id_clearance'];?> </td> 
            <td> <?= $view['lname'];?> </td>
            <td> <?= $view['fname'];?> </td>
            <td> <?= $view['mi'];?> </td>
            <td> <?= $view['age'];?> </td>
            <td> <?= $view['houseno'];?> </td>
            <td> <?= $view['street'];?> </td>
            <td> <?= $view['brgy'];?> </td>
            <td> <?= $view['city'];?> </td>
            <td> <?= $view['municipality'];?> </td>
            <td> <?= $view['purpose'];?> </td>
            <!-- delete payment -->
            <td>    
            <form id="archiveForm" action="" method="post">
                <input type="hidden" name="id" value="<?= $userdetails['fname']; ?> <?= $userdetails['lname'];?>">
                <input type="hidden" name="id_clearance" value="<?= $view['id_clearance'];?>">
                <?php
echo $list === 'active' ? 
    // Display both buttons if the status is active
'<a class="btn btn-success" target="_blank" title="Generate" style="width: 70px; font-size: 17px; border-radius:30px; margin-bottom: 2px;" href="clearance_form.php?id_clearance='.$view['id_clearance'].'"> <i class="fas fa-cogs"></i></a>'. 
    
'<a href="javascript:void(0);" class="btn btn-primary" title="View Details" onclick="openPopup(\'view_clearance.php?id_clearance=' . urlencode($view['id_clearance']) . '\')" style="width: 70px; font-size: 17px; border-radius:30px;">
    <i class="fa fa-eye"></i>
</a>' :
    
    // Display only the unarchive button if the status is not active
    '<a href="javascript:void(0);" class="btn btn-primary" title="View Details" onclick="openPopup(\'view_clearance_archive.php?id_clearance=' . urlencode($view['id_clearance']) . '\')" style="width: 70px; font-size: 17px; border-radius:30px;">
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
    $viewsJson = json_encode($views);
    $tableName = 'tbl_clearance';
?>

 <?php if ($list === 'active') { ?>
    <form id="archiveSelect" action="" method="post">
        <input type="hidden" name="ids_to_archive" id="idsToArchive">
        <input type="hidden" name="id" value="<?= htmlspecialchars($userdetails['id'], ENT_QUOTES); ?>">
        <input type="hidden" name="id_clearance" value="<?= htmlspecialchars($view['id_clearance'], ENT_QUOTES); ?>">

        <!-- Actual Submit Button -->
        <button type="submit" class="btn btn-danger" id="hiddensubmitslt" style="display: none;" name="archive_selected_clearance">
            Archive Selected
        </button>

    </form>
<?php } ?>

<?php if ($list === 'archived') { ?>
    <form id="retrieveSelect" action="" method="post">
        <input type="hidden" name="ids_to_retrieve" id="idsToRetrieve">
        <input type="hidden" name="id" value="<?= htmlspecialchars($userdetails['id'], ENT_QUOTES); ?>">
        <input type="hidden" name="id_clearance" value="<?= htmlspecialchars($view['id_clearance'], ENT_QUOTES); ?>">

        <!-- Actual Submit Button -->
        <button type="submit" class="btn btn-danger" id="hiddensubmitret" style="display: none;" name="retrieve_selected_clearance">
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
