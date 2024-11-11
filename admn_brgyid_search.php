<?php
	// require the database connection
	require 'classes/conn.php';
	if(isset($_POST['search_bspermit'])){
		$keyword = $_POST['keyword'];
?>
<h2>Pending Requests</h2>

<table class="table table-hover text-center table-bordered table-responsive" >

    <thead class="alert-info">
        
        <tr>
            <th> Actions</th>
            <th> Resident ID </th>
            <th> Surname </th>
            <th> First Name </th>
            <th> Middle Name </th>
            <th> House No. </th>
            <th> Street </th>
            <th> Barangay </th>
            <th> City </th>
            <th> Municipality </th>
            <th> Birth Date </th>
            <th> Birth Place </th>
            <th> Emergency Contact Person </th>
            <th> Emergency Contact Number </th>
        </tr>
    </thead>

    <tbody> 
        <?php
         $stmnt = $conn->prepare("
            SELECT
               r.*, b.*
            FROM 
                tbl_resident AS r
            JOIN
                tbl_brgyid AS b ON r.id_resident = b.id_resident
            WHERE 
                (b.`id_brgyid` LIKE ? OR
                r.id_resident LIKE ? OR
                r.`lname` LIKE ? OR
                r.`mi` LIKE ? OR
                r.`fname` LIKE ? OR
                r.`houseno` LIKE ? OR
                r.`street` LIKE ? OR
                r.`brgy` LIKE ? OR
                r.`city` LIKE ? OR
                r.`municipal` LIKE ? OR
                r.`bplace` LIKE ? OR
                r.`bdate` LIKE ? OR
                b.`inc_lname` LIKE ? OR
                b.`inc_fname` LIKE ? OR
                b.`inc_mi` LIKE ? OR
                b.`inc_contact` LIKE ? OR
                b.`inc_houseno` LIKE ? OR
                b.`inc_street` LIKE ? OR
                b.`inc_brgy` LIKE ? OR
                b.`inc_city` LIKE ? OR
                b.`inc_municipal` LIKE ?)
            AND b.`req_status` = ?
        ");

        $keywordLike = "%$keyword%";
        $pendingStatus = 'pending';
        
        $stmnt->execute([
            $keywordLike, $keywordLike, $keywordLike, $keywordLike, 
            $keywordLike, $keywordLike, $keywordLike, $keywordLike, 
            $keywordLike, $keywordLike, $keywordLike, $keywordLike, 
            $keywordLike, $keywordLike, $keywordLike, $keywordLike, 
            $keywordLike, $keywordLike, $keywordLike, $keywordLike, 
            $keywordLike, $pendingStatus
        ]);
            while($view = $stmnt->fetch()){
        ?>
            <tr>
                <td>    
                    <form action="" method="post">
                        <button class="btn btn-success" type="submit" name="accept_brgyid" style="width: 90px; font-size: 17px; border-radius:30px; margin-bottom: 2px;">Accept</a>     
                        <input type="hidden" name="id_resident" value="<?= $view['id_resident'];?>">
                        <input type="hidden" name="id_brgyid" value="<?= $view['id_brgyid'];?>">
                        <button class="btn btn-danger" style="width: 90px; font-size: 17px; border-radius:30px;" type="submit" name="delete_brgyid"> Archive </button>
                    </form>
                </td>
                <td> <?= $view['id_resident'];?> </td> 
                <td> <?= $view['lname'];?> </td>
                <td> <?= $view['fname'];?> </td>
                <td> <?= $view['mi'];?> </td>
                <td> <?= $view['houseno'];?> </td>
                <td> <?= $view['street'];?> </td>
                <td> <?= $view['brgy'];?> </td>
                <td> <?= $view['city'];?> </td>
                <td> <?= $view['municipal'];?> </td>
                <td> <?= $view['bdate'];?> </td>
                <td> <?= $view['bplace'];?> </td>
                <td> <?= $view['inc_lname'];?>, <?= $view['inc_fname'];?> </td>
                <td> <?= $view['inc_contact'];?> </td>
            </tr>
        <?php
        }
        ?>
    </tbody>
    
</table>

<h2>Accepted Requests</h2>

<table class="table table-hover text-center table-bordered table-responsive" >

    <thead class="alert-info">
        
        <tr>
            <th> Actions</th>
            <th> Resident ID </th>
            <th> Surname </th>
            <th> First Name </th>
            <th> Middle Name </th>
            <th> House No. </th>
            <th> Street </th>
            <th> Barangay </th>
            <th> City </th>
            <th> Municipality </th>
            <th> Birth Date </th>
            <th> Birth Place </th>
            <th> Emergency Contact Person </th>
            <th> Emergency Contact Number </th>
        </tr>
    </thead>

    <tbody> 
        <?php
            
            $stmnt = $conn->prepare("
            SELECT
               r.*, b.*
            FROM 
                tbl_resident AS r
            JOIN
                tbl_brgyid AS b ON r.id_resident = b.id_resident
            WHERE 
                (b.`id_brgyid` LIKE ? OR
                r.id_resident LIKE ? OR
                r.`lname` LIKE ? OR
                r.`mi` LIKE ? OR
                r.`fname` LIKE ? OR
                r.`houseno` LIKE ? OR
                r.`street` LIKE ? OR
                r.`brgy` LIKE ? OR
                r.`city` LIKE ? OR
                r.`municipal` LIKE ? OR
                r.`bplace` LIKE ? OR
                r.`bdate` LIKE ? OR
                b.`inc_lname` LIKE ? OR
                b.`inc_fname` LIKE ? OR
                b.`inc_mi` LIKE ? OR
                b.`inc_contact` LIKE ? OR
                b.`inc_houseno` LIKE ? OR
                b.`inc_street` LIKE ? OR
                b.`inc_brgy` LIKE ? OR
                b.`inc_city` LIKE ? OR
                b.`inc_municipal` LIKE ?)
            AND b.`req_status` = ?
        ");

        $keywordLike = "%$keyword%";
        $pendingStatus = 'accepted';
        
        $stmnt->execute([
            $keywordLike, $keywordLike, $keywordLike, $keywordLike, 
            $keywordLike, $keywordLike, $keywordLike, $keywordLike, 
            $keywordLike, $keywordLike, $keywordLike, $keywordLike, 
            $keywordLike, $keywordLike, $keywordLike, $keywordLike, 
            $keywordLike, $keywordLike, $keywordLike, $keywordLike, 
            $keywordLike, $pendingStatus
        ]);
            
            while($view = $stmnt->fetch()){
        ?>
            <tr>
                <td>    
                    <form action="" method="post">
                        <a class="btn btn-success" target="blank" style="width: 90px; font-size: 17px; border-radius:30px; margin-bottom: 2px;" href="brgyid_form.php?id_resident=<?= $view['id_resident'];?>">Generate</a> 
                        <input type="hidden" name="id_resident" value="<?= $view['id_resident'];?>">
                        <input type="hidden" name="id_brgyid" value="<?= $view['id_brgyid'];?>">
                        <button class="btn btn-danger" style="width: 90px; font-size: 17px; border-radius:30px;" type="submit" name="delete_brgyid"> Archive </button>
                    </form>
                </td>
                <td> <?= $view['id_resident'];?> </td> 
                <td> <?= $view['lname'];?> </td>
                <td> <?= $view['fname'];?> </td>
                <td> <?= $view['mi'];?> </td>
                <td> <?= $view['houseno'];?> </td>
                <td> <?= $view['street'];?> </td>
                <td> <?= $view['brgy'];?> </td>
                <td> <?= $view['city'];?> </td>
                <td> <?= $view['municipal'];?> </td>
                <td> <?= $view['bdate'];?> </td>
                <td> <?= $view['bplace'];?> </td>
                <td> <?= $view['inc_lname'];?>, <?= $view['inc_fname'];?> </td>
                <td> <?= $view['inc_contact'];?> </td>
            </tr>
        <?php
        }
        ?>
    </tbody>
    
</table>

<?php		
	}else{
?>

<h2>Pending Requests</h2>

<table class="table table-hover text-center table-bordered table-responsive">

    <thead class="alert-info">
        <tr>
            <th> Actions</th>
            <th> Resident ID </th>
            <th> Surname </th>
            <th> First Name </th>
            <th> Middle Name </th>
            <th> House No. </th>
            <th> Street </th>
            <th> Barangay </th>
            <th> City </th>
            <th> Municipality </th>
            <th> Birth Date </th>
            <th> Birth Place </th>
            <th> Emergency Contact Person </th>
            <th> Emergency Contact Number </th>
        </tr>
    </thead>
    
    <tbody>
        <?php 
              $stmnt = $conn->prepare("
                SELECT 
                    r.*, b.* 
                FROM 
                    tbl_resident AS r
                JOIN
                    tbl_brgyid AS b ON r.id_resident = b.id_resident
                WHERE 
                    b.`req_status` = ?");
    
              $pendingStatus = 'pending';
              $stmnt->execute([$pendingStatus]);
            
            while($view = $stmnt->fetch()){?>
                <tr>
                    <td>    
                        <form action="" method="post">
                            <button class="btn btn-success" type="submit" name="accept_brgyid" style="width: 90px; font-size: 17px; border-radius:30px; margin-bottom: 2px;">Accept</a> 
                            <input type="hidden" name="id_resident" value="<?= $view['id_resident'];?>">
                            <input type="hidden" name="id_brgyid" value="<?= $view['id_brgyid'];?>">
                            <button class="btn btn-danger" style="width: 90px; font-size: 17px; border-radius:30px;" type="submit" name="delete_brgyid"> Decline </button>
                        </form>
                    </td>
                    <td> <?= $view['id_resident'];?> </td> 
                    <td> <?= $view['lname'];?> </td>
                    <td> <?= $view['fname'];?> </td>
                    <td> <?= $view['mi'];?> </td>
                    <td> <?= $view['houseno'];?> </td>
                    <td> <?= $view['street'];?> </td>
                    <td> <?= $view['brgy'];?> </td>
                    <td> <?= $view['city'];?> </td>
                    <td> <?= $view['municipal'];?> </td>
                    <td> <?= $view['bdate'];?> </td>
                    <td> <?= $view['bplace'];?> </td>
                    <td> <?= $view['inc_lname'];?>, <?= $view['inc_fname'];?> </td>
                    <td> <?= $view['inc_contact'];?> </td>
                </tr>
        <?php
            }
        ?>
    </tbody>

</table>

<h2>Accepted Requests</h2>

<table class="table table-hover text-center table-bordered table-responsive">

    <thead class="alert-info">
        <tr>
            <th> Actions</th>
            <th> Resident ID </th>
            <th> Surname </th>
            <th> First Name </th>
            <th> Middle Name </th>
            <th> House No. </th>
            <th> Street </th>
            <th> Barangay </th>
            <th> City </th>
            <th> Municipality </th>
            <th> Birth Date </th>
            <th> Birth Place </th>
            <th> Emergency Contact Person </th>
            <th> Emergency Contact Number </th>
        </tr>
    </thead>
    
    <tbody>
        <?php 
            $stmnt = $conn->prepare("
            SELECT 
                r.*, b.* 
            FROM 
                tbl_resident AS r
            JOIN
                tbl_brgyid AS b ON r.id_resident = b.id_resident
            WHERE 
                b.`req_status` = ?");

            $pendingStatus = 'accepted';
            $stmnt->execute([$pendingStatus]);

            while($view = $stmnt->fetch()){?>
                <tr>
                    <td>    
                        <form action="" method="post">
                            <a class="btn btn-success" target="blank" style="width: 90px; font-size: 17px; border-radius:30px; margin-bottom: 2px;" href="brgyid_form.php?id_resident=<?= $view['id_resident'];?>">Generate</a> 
                            <input type="hidden" name="id_resident" value="<?= $view['id_resident'];?>">
                            <input type="hidden" name="id_brgyid" value="<?= $view['id_brgyid'];?>">
                            <button class="btn btn-danger" style="width: 90px; font-size: 17px; border-radius:30px;" type="submit" name="delete_brgyid"> Delete </button>
                        </form>
                    </td>
                    <td> <?= $view['id_resident'];?> </td> 
                    <td> <?= $view['lname'];?> </td>
                    <td> <?= $view['fname'];?> </td>
                    <td> <?= $view['mi'];?> </td>
                    <td> <?= $view['houseno'];?> </td>
                    <td> <?= $view['street'];?> </td>
                    <td> <?= $view['brgy'];?> </td>
                    <td> <?= $view['city'];?> </td>
                    <td> <?= $view['municipal'];?> </td>
                    <td> <?= $view['bdate'];?> </td>
                    <td> <?= $view['bplace'];?> </td>
                    <td> <?= $view['inc_lname'];?>, <?= $view['inc_fname'];?> </td>
                    <td> <?= $view['inc_contact'];?> </td>
                </tr>
        <?php
            }
        ?>
    </tbody>

</table>


<?php
	}
$con = null;
?>