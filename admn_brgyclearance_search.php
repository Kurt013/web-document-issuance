<?php
	// require the database connection
	require 'classes/conn.php';
	if(isset($_POST['search_clearance'])){
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
            <th> Purpose </th>
            <th> House No. </th>
            <th> Street </th>
            <th> Barangay </th>
            <th> City </th>
            <th> Municipality </th>
            <th> Status </th>
            <th> Age </th>
        </tr>
    </thead>

    <tbody>
        <?php
        $stmnt = $conn->prepare("
                SELECT 
                    r.id_resident,
                    r.lname,
                    r.mi,
                    r.fname,
                    r.age,
                    r.houseno,
                    r.street,
                    r.brgy,
                    r.city,
                    r.municipal,
                    c.id_clearance,
                    c.purpose,
                    c.req_status
                FROM
                    tbl_resident AS r
                JOIN
                    tbl_clearance AS c ON r.id_resident = c.id_resident
                WHERE
                    (r.`lname` LIKE ? OR  
                        r.`mi` LIKE ? OR  
                        r.`fname` LIKE ? OR 
                        r.`age` LIKE ? OR  
                        r.`id_resident` LIKE ? OR  
                        r.`houseno` LIKE ? OR
                        r.`street` LIKE ? OR 
                        r.`brgy` LIKE ? OR 
                        r.`municipal` LIKE ? OR 
                        r.`city` LIKE ? OR 
                        c.`purpose` LIKE ?) 
                    AND c.`req_status` = ?");
        
        $keywordLike = "%$keyword%";
        $pendingStatus = 'pending';
        
        $stmnt->execute([
            $keywordLike, $keywordLike, $keywordLike, $keywordLike, 
            $keywordLike, $keywordLike, $keywordLike, $keywordLike, 
            $keywordLike, $keywordLike, $keywordLike, $pendingStatus
        ]);
            
            
            while($view = $stmnt->fetch()){
        ?>
            <tr>
                <td>    
                    <form action="" method="post">
                        <button class="btn btn-success" type="submit" name="accept_clearance" style="width: 90px; font-size: 17px; border-radius:30px; margin-bottom: 2px;">Accept</a> 
                            <input type="hidden" name="id_resident" value="<?= $view['id_resident'];?>">
                        <input type="hidden" name="id_clearance" value="<?= $view['id_clearance'];?>">
                        <button class="btn btn-danger"  style="width: 90px; font-size: 17px; border-radius:30px;" type="submit" name="delete_clearance"> Decline </button>
                    </form>
                </td>
                <td> <?= $view['id_resident'];?> </td> 
                <td> <?= $view['lname'];?> </td>
                <td> <?= $view['fname'];?> </td>
                <td> <?= $view['mi'];?> </td>
                <td> <?= $view['purpose'];?> </td>
                <td> <?= $view['houseno'];?> </td>
                <td> <?= $view['street'];?> </td>
                <td> <?= $view['brgy'];?> </td>
                <td> <?= $view['city'];?> </td>
                <td> <?= $view['municipal'];?> </td>
                <td> <?= $view['status'];?> </td>
                <td> <?= $view['age'];?> </td>
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
            <th> Purpose </th>
            <th> House No. </th>
            <th> Street </th>
            <th> Barangay </th>
            <th> City </th>
            <th> Municipality </th>
            <th> Status </th>
            <th> Age </th>
        </tr>
    </thead>

    <tbody>
        <?php
        $stmnt = $conn->prepare("
        SELECT 
            r.id_resident,
            r.lname,
            r.mi,
            r.fname,
            r.age,
            r.houseno,
            r.street,
            r.brgy,
            r.city,
            c.id_clearance,
            r.municipal,
            c.purpose,
            c.req_status
        FROM
            tbl_resident AS r
        JOIN
            tbl_clearance AS c ON r.id_resident = c.id_resident
        WHERE
            (r.`lname` LIKE ? OR  
                r.`mi` LIKE ? OR  
                r.`fname` LIKE ? OR 
                r.`age` LIKE ? OR  
                r.`id_resident` LIKE ? OR  
                r.`houseno` LIKE ? OR
                r.`street` LIKE ? OR 
                r.`brgy` LIKE ? OR 
                r.`municipal` LIKE ? OR 
                r.`city` LIKE ? OR 
                c.`purpose` LIKE ?) 
            AND c.`req_status` = ?");

        $keywordLike = "%$keyword%";
        $pendingStatus = 'accepted';

        $stmnt->execute([
            $keywordLike, $keywordLike, $keywordLike, $keywordLike, 
            $keywordLike, $keywordLike, $keywordLike, $keywordLike, 
            $keywordLike, $keywordLike, $keywordLike, $pendingStatus
        ]);
            
            while($view = $stmnt->fetch()){
        ?>
            <tr>
                <td>    
                    <form action="" method="post">
                        <a class="btn btn-success" target="_blank" style="width: 90px; font-size: 17px; border-radius:30px; margin-bottom: 2px;" href="brgyclearance_form.php?id_resident=<?= $view['id_resident'];?>">Generate</a> 
                        <input type="hidden" name="id_clearance" value="<?= $view['id_clearance'];?>">
                        <input type="hidden" name="id_resident" value="<?= $view['id_resident'];?>">
                        <button class="btn btn-danger"  style="width: 90px; font-size: 17px; border-radius:30px;" type="submit" name="archive_clearance"> Archive </button>
                    </form>
                </td>
                <td> <?= $view['id_resident'];?> </td> 
                <td> <?= $view['lname'];?> </td>
                <td> <?= $view['fname'];?> </td>
                <td> <?= $view['mi'];?> </td>
                <td> <?= $view['purpose'];?> </td>
                <td> <?= $view['houseno'];?> </td>
                <td> <?= $view['street'];?> </td>
                <td> <?= $view['brgy'];?> </td>
                <td> <?= $view['city'];?> </td>
                <td> <?= $view['municipal'];?> </td>
                <td> <?= $view['status'];?> </td>
                <td> <?= $view['age'];?> </td>
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
            <th> Purpose </th>
            <th> House No. </th>
            <th> Street </th>
            <th> Barangay </th>
            <th> City </th>
            <th> Municipality </th>
            <th> Status </th>
            <th> Age </th>
        </tr>
    </thead>

    <tbody>
        <?php 
            $stmnt = $conn->prepare("
                SELECT 
                    r.*, c.* 
                FROM 
                    tbl_resident AS r
                JOIN
                    tbl_clearance AS c ON r.id_resident = c.id_resident
                WHERE 
                    c.`req_status` = ?");

            $pendingStatus = 'pending';
            $stmnt->execute([$pendingStatus]);

            while($view = $stmnt->fetch()){ ?>
                <tr>
                    <td>    
                        <form action="" method="post">
                            <button class="btn btn-success" type="submit" name="accept_clearance" style="width: 90px; font-size: 17px; border-radius:30px; margin-bottom: 2px;">Accept</button> 
                            <input type="hidden" name="id_clearance" value="<?= $view['id_clearance'];?>">
                            <input type="hidden" name="id_resident" value="<?= $view['id_resident'];?>">
                            <button class="btn btn-danger"  style="width: 90px; font-size: 17px; border-radius:30px;" type="submit" name="delete_clearance"> Decline</button>
                        </form>
                    </td>
                    <td> <?= $view['id_resident'];?> </td> 
                    <td> <?= $view['lname'];?> </td>
                    <td> <?= $view['fname'];?> </td>
                    <td> <?= $view['mi'];?> </td>
                    <td> <?= $view['purpose'];?> </td>
                    <td> <?= $view['houseno'];?> </td>
                    <td> <?= $view['street'];?> </td>
                    <td> <?= $view['brgy'];?> </td>
                    <td> <?= $view['city'];?> </td>
                    <td> <?= $view['municipal'];?> </td>
                    <td> <?= $view['status'];?> </td>
                    <td> <?= $view['age'];?> </td>
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
            <th> Purpose </th>
            <th> House No. </th>
            <th> Street </th>
            <th> Barangay </th>
            <th> City </th>
            <th> Municipality </th>
            <th> Status </th>
            <th> Age </th>
        </tr>
    </thead>

    <tbody>
        <?php 
            $stmnt = $conn->prepare("
            SELECT 
                r.*, c.* 
            FROM 
                tbl_resident AS r
            JOIN
                tbl_clearance AS c ON r.id_resident = c.id_resident
            WHERE 
                c.`req_status` = ?");

            $pendingStatus = 'accepted';
            $stmnt->execute([$pendingStatus]);
            
            while($view = $stmnt->fetch()){ ?>
                <tr>
                    <td>    
                        <form action="" method="post">
                            <a class="btn btn-success" target="_blank" style="width: 90px; font-size: 17px; border-radius:30px; margin-bottom: 2px;" href="brgyclearance_form.php?id_resident=<?= $view['id_resident'];?>">Generate</a> 
                            <input type="hidden" name="id_clearance" value="<?= $view['id_clearance'];?>">
                            <input type="hidden" name="id_resident" value="<?= $view['id_resident'];?>">
                            <button class="btn btn-danger"  style="width: 90px; font-size: 17px; border-radius:30px;" type="submit" name="archive_clearance"> Archive </button>
                        </form>
                    </td>
                    <td> <?= $view['id_resident'];?> </td> 
                    <td> <?= $view['lname'];?> </td>
                    <td> <?= $view['fname'];?> </td>
                    <td> <?= $view['mi'];?> </td>
                    <td> <?= $view['purpose'];?> </td>
                    <td> <?= $view['houseno'];?> </td>
                    <td> <?= $view['street'];?> </td>
                    <td> <?= $view['brgy'];?> </td>
                    <td> <?= $view['city'];?> </td>
                    <td> <?= $view['municipal'];?> </td>
                    <td> <?= $view['status'];?> </td>
                    <td> <?= $view['age'];?> </td>
                </tr>
        <?php
            }
        ?>
    </tbody>

</table>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-modal/2.2.6/js/bootstrap-modalmanager.min.js" integrity="sha512-/HL24m2nmyI2+ccX+dSHphAHqLw60Oj5sK8jf59VWtFWZi9vx7jzoxbZmcBeeTeCUc7z1mTs3LfyXGuBU32t+w==" crossorigin="anonymous"></script>
<!-- responsive tags for screen compatibility -->
<meta name="viewport" content="width=device-width, initial-scale=1 shrink-to-fit=no">
<!-- custom css --> 
<link href="../BarangaySystem/customcss/regiformstyle.css" rel="stylesheet" type="text/css">
<!-- bootstrap css --> 
<link href="../BarangaySystem/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css"> 
<!-- fontawesome icons -->
<script src="https://kit.fontawesome.com/67a9b7069e.js" crossorigin="anonymous"></script>
<script src="../BarangaySystem/bootstrap/js/bootstrap.bundle.js" type="text/javascript"> </script>

<?php
	}
$con = null;
?>