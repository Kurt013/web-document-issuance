<style>
form label {
         
         font-size: 1rem;
         color: #012049;
         font-family: "PSemiBold";
         text-align: left;
     }

     form select  {
            font-family: "PMedium" !important;
            font-size: 1rem;
            border-radius: 5px;
            border: 2px solid #012049;
            padding: 0 5px;
            cursor: pointer;
            width: 15%;
            margin-left: 5px;
            text-align: center;
            margin-bottom: 10px;
            color: #012049;
          
            
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

</style>
<form method="GET" action="">
        <label for="list">Select List: </label>
        <select name="list" id="list" onchange="this.form.submit()">
            <option value="active" <?= (isset($_GET['list']) && $_GET['list'] == 'active') ? 'selected' : ''; ?>>Active</option>
            <option value="archived" <?= (isset($_GET['list']) && $_GET['list'] == 'archived') ? 'selected' : ''; ?>>Archived</option>
        </select>
</form>
<?php
	if(isset($_POST['search_brgyid'])){
		$keyword = $_POST['keyword'];
?>

<table class="table table-hover text-center table-bordered table-responsive" >

    <thead class="alert-info">
        
        <tr>
            <th> </th>
            <th> Photo </th>
            <th> ID No. </th>
            <th> Surname </th>
            <th> First Name </th>
            <th> Middle Name </th>
            <th> House No. </th>
            <th> Street </th>
            <th> Barangay </th>
            <th> City </th>
            <th> Municipality </th>
            <th> Birth Date </th>
            <th> Emergency Contact Person </th>
            <th> Emergency Contact Number </th>
        </tr>
    </thead>

    <tbody> 
        <?php
            $list === 'active' ?
            $stmt = $conn->prepare("
            SELECT
              *
            FROM 
                tbl_brgyid
            WHERE 
                (`id_brgyid` LIKE ? OR
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
                `inc_lname` LIKE ? OR
                `inc_fname` LIKE ? OR
                `inc_mi` LIKE ? OR
                `inc_contact` LIKE ? OR
                `inc_houseno` LIKE ? OR
                `inc_street` LIKE ? OR
                `inc_brgy` LIKE ? OR
                `inc_city` LIKE ? OR
                `inc_municipality` LIKE ? OR
                valid_until LIKE ? OR
                created_on LIKE ? OR
                created_by LIKE ?)
            AND `doc_status` = ?
        ") :
        $stmt = $conn->prepare("
            SELECT
              *
            FROM 
                tbl_brgyid_archive
            WHERE 
                `id_brgyid` LIKE ? OR
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
                `inc_lname` LIKE ? OR
                `inc_fname` LIKE ? OR
                `inc_mi` LIKE ? OR
                `inc_contact` LIKE ? OR
                `inc_houseno` LIKE ? OR
                `inc_street` LIKE ? OR
                `inc_brgy` LIKE ? OR
                `inc_city` LIKE ? OR
                `inc_municipality` LIKE ? OR
                valid_until LIKE ? OR
                archived_on LIKE ? OR
                archived_by LIKE ?
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
            $pendingStatus
        ]):
        $stmt->execute([
            $keywordLike, $keywordLike, $keywordLike, $keywordLike, 
            $keywordLike, $keywordLike, $keywordLike, $keywordLike, 
            $keywordLike, $keywordLike, $keywordLike, $keywordLike, 
            $keywordLike, $keywordLike, $keywordLike, $keywordLike, 
            $keywordLike, $keywordLike, $keywordLike, $keywordLike, 
            $keywordLike, $keywordLike, $keywordLike, $keywordLike,
        ]);
            
        $views = $stmt->fetchAll();
        if ($stmt->rowCount() > 0) {
            foreach ($views as $view) {

        ?>
            <tr>
                <td>    
                    <form action="" method="post">
                        <a class="btn btn-success" target="_blank" style="width: 90px; font-size: 17px; border-radius:30px; margin-bottom: 2px;" href="brgyid_form.php?id_brgyid=<?= $view['id_brgyid'];?><?php if ($list === 'archived') echo '&status=archived';?>">Generate</a> 
                                    <input type="hidden" name="id" value="<?= $userdetails['id'];?>">
                                    <input type="hidden" name="id_brgyid" value="<?= $view['id_brgyid'];?>">
                                    <?php 
                                echo $list === 'active' ? 
                                    '<button class="btn btn-danger" type="submit" style="width: 90px; font-size: 17px; border-radius:30px;" name="archive_certofres"> Archive </button>' :
                                    '<button class="btn btn-danger" type="submit" style="width: 90px; font-size: 17px; border-radius:30px;" name="unarchive_certofres"> Retrieve </button>'
                                    ;
                            ?>    
                    </form>
                </td>
                <td> <?= $staffbmis->convertToImg($view['res_photo']) ;?> </td> 
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
                <td> <?= $view['inc_lname'];?>, <?= $view['inc_fname'];?> </td>
                <td> <?= $view['inc_contact'];?> </td>
            </tr>
        <?php
        }
    }
    else {
        echo "<tr><td colspan='13'>No existing list</td></tr>";
    }
        ?>
    </tbody>
    
</table>

<?php		
	}else{
?>
<table class="table table-hover text-center table-bordered table-responsive">

    <thead class="alert-info">
        <tr>
            <th> </th>
            <th> Photo </th>
            <th> ID No. </th>
            <th> Surname </th>
            <th> First Name </th>
            <th> Middle Name </th>
            <th> House No. </th>
            <th> Street </th>
            <th> Barangay </th>
            <th> City </th>
            <th> Municipality </th>
            <th> Birth Date </th>
            <th> Emergency Contact Person </th>
            <th> Emergency Contact Number </th>
        </tr>
    </thead>
    
    <tbody>
        <?php 
              $pendingStatus = 'accepted';

              if ($list === 'active') {
                  $stmt = $conn->prepare("SELECT * FROM tbl_brgyid WHERE doc_status = ?");
                  $stmt->execute([$pendingStatus]);
              } else {
                  $stmt = $conn->prepare("SELECT * FROM tbl_brgyid_archive");
                  $stmt->execute();
              }
              $views = $stmt->fetchAll();
              if ($stmt->rowCount() > 0) {
            
                foreach ($views as $view) {

                ?>
                <tr>
                    <td>    
                        <form action="" method="post">
                                    <a class="btn btn-success" target="_blank" style="width: 90px; font-size: 17px; border-radius:30px; margin-bottom: 2px;" href="brgyid_form.php?id_brgyid=<?= $view['id_brgyid'];?><?php if ($list === 'archived') echo '&status=archived';?>">Generate</a> 
                                    <input type="hidden" name="id" value="<?= $userdetails['id'];?>">
                                    <input type="hidden" name="id_brgyid" value="<?= $view['id_brgyid'];?>">
                            <?php 
                                echo $list === 'active' ? 
                                    '<button class="btn btn-danger" type="submit" style="width: 90px; font-size: 17px; border-radius:30px;" name="archive_brgyid"> Archive </button>' :
                                    '<button class="btn btn-danger" type="submit" style="width: 90px; font-size: 17px; border-radius:30px;" name="unarchive_brgyid"> Retrieve </button>'
                                    ;
                            ?>    
                            
                        </form>
                    </td>
                    <td> <?= $staffbmis->convertToImg($view['res_photo']) ;?> </td> 
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
                    <td> <?= $view['inc_lname'];?>, <?= $view['inc_fname'];?> </td>
                    <td> <?= $view['inc_contact'];?> </td>
                </tr>
        <?php
            }

            foreach ($views as &$view) {
                unset($view['res_photo']);
            }
        
        }
        else {
            echo "<tr><td colspan='13'>No existing list</td></tr>";
        }
        ?>
    </tbody>
</table>
<?php
	}
    $viewsJson = json_encode($views);
    
    $list === 'archived' ?
        $tableName = 'tbl_brgyid_archive' :
        $tableName = 'tbl_brgyid';
?>


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