<?php
	// require the database connection
	require 'classes/conn.php';
	if(isset($_POST['search_bspermit'])){
		$keyword = $_POST['keyword'];
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
            <th> Business Name </th>
            <th> House No. </th>
            <th> Street </th>
            <th> Barangay </th>
            <th> City </th>
            <th> Municipality </th>
            <th> Business Industry </th>
            <th> Area of Establishment </th>
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
                    b.id_bspermit,
                    b.bshouseno,
                    b.bsstreet,
                    b.bsbrgy,
                    b.bscity,
                    b.bsmunicipal,
                    b.bsname,
                    b.bsindustry,
                    b.aoe,
                    b.req_status
                FROM
                    tbl_resident AS r
                JOIN
                    tbl_bspermit AS b ON r.id_resident = b.id_resident
                WHERE
                    (r.`lname` LIKE ? OR  
                        r.`mi` LIKE ? OR  
                        r.`fname` LIKE ? OR 
                        r.`id_resident` LIKE ? OR  
                        b.`bshouseno` LIKE ? OR
                        b.`bsstreet` LIKE ? OR 
                        b.`bsbrgy` LIKE ? OR 
                        b.`bscity` LIKE ? OR 
                        b.`bsmunicipal` LIKE ? OR 
                        b.`bsname` LIKE ? OR
                        b.bsindustry LIKE ? OR
                        b.aoe LIKE ?) 
                    AND b.`req_status` = ?");

            $keywordLike = "%$keyword%";
            $pendingStatus = 'pending';
            
            $stmnt->execute([
                $keywordLike, $keywordLike, $keywordLike, $keywordLike, 
                $keywordLike, $keywordLike, $keywordLike, $keywordLike, 
                $keywordLike, $keywordLike, $keywordLike, $keywordLike,
                $pendingStatus
            ]);
            
            while($view = $stmnt->fetch()){
        ?>
            <tr>
                <td>    
                    <form action="" method="post">
                        <button class="btn btn-success" type="submit" name="accept_bspermit"  style="width: 90px; font-size: 17px; border-radius:30px; margin-bottom: 2px;">Accept</button> 
                        <?= $view['id_bspermit']; ?>
                        <input type="hidden" name="id_resident" value="<?= $view['id_resident'];?>">
                        <button class="btn btn-danger"  style="width: 90px; font-size: 17px; border-radius:30px;" type="submit" name="delete_bspermit"> Decline </button>
                    </form>
                </td>
                <td> <?= $view['id_resident'];?> </td> 
                <td> <?= $view['lname'];?> </td>
                <td> <?= $view['fname'];?> </td>
                <td> <?= $view['mi'];?> </td>
                <td> <?= $view['bsname'];?> </td>
                <td> <?= $view['bshouseno'];?> </td>
                <td> <?= $view['bsstreet'];?> </td>
                <td> <?= $view['bsbrgy'];?> </td>
                <td> <?= $view['bscity'];?> </td>
                <td> <?= $view['bsmunicipal'];?> </td>
                <td> <?= $view['bsindustry'];?> </td>
                <td> <?= $view['aoe'];?> </td>
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
        <th> Business Name </th>
        <th> House No. </th>
        <th> Street </th>
        <th> Barangay </th>
        <th> City </th>
        <th> Municipality </th>
        <th> Business Industry </th>
        <th> Area of Establishment </th>
    </tr>
</thead>

<tbody>     
    <?php
        
            $stmnt = $conn->prepare("
            SELECT 
                r.id_resident,
                b.id_bspermit,
                r.lname,
                r.mi,
                r.fname,
                b.bshouseno,
                b.bsstreet,
                b.bsbrgy,
                b.bscity,
                b.bsmunicipal,
                b.bsname,
                b.bsindustry,
                b.aoe,
                b.req_status
            FROM
                tbl_resident AS r
            JOIN
                tbl_bspermit AS b ON r.id_resident = b.id_resident
            WHERE
                (r.`lname` LIKE ? OR  
                    r.`mi` LIKE ? OR  
                    r.`fname` LIKE ? OR 
                    r.`id_resident` LIKE ? OR  
                    b.`bshouseno` LIKE ? OR
                    b.`bsstreet` LIKE ? OR 
                    b.`bsbrgy` LIKE ? OR 
                    b.`bscity` LIKE ? OR 
                    b.`bsmunicipal` LIKE ? OR 
                    b.`bsname` LIKE ? OR
                    b.bsindustry LIKE ? OR
                    b.aoe LIKE ?) 
                AND b.`req_status` = ?");

        $keywordLike = "%$keyword%";
        $pendingStatus = 'accepted';
        
        $stmnt->execute([
            $keywordLike, $keywordLike, $keywordLike, $keywordLike, 
            $keywordLike, $keywordLike, $keywordLike, $keywordLike, 
            $keywordLike, $keywordLike, $keywordLike, $keywordLike,
            $pendingStatus
        ]);
        
        while($view = $stmnt->fetch()){
    ?>
        <tr>
            <td>    
                <form action="" method="post">
                    <a class="btn btn-success" target="blank"  style="width: 90px; font-size: 17px; border-radius:30px; margin-bottom: 2px;" href="businesspermit_form.php?id_resident=<?= $view['id_resident'];?>">Generate</a> 
                    <input type="hidden" name="id_bspermit" value="<?= $view['id_bspermit'];?>">
                    <input type="hidden" name="id_resident" value="<?= $view['id_resident'];?>">
                    <button class="btn btn-danger"  style="width: 90px; font-size: 17px; border-radius:30px;" type="submit" name="delete_bspermit"> Delete </button>
                </form>
            </td>
            <td> <?= $view['id_resident'];?> </td> 
            <td> <?= $view['lname'];?> </td>
            <td> <?= $view['fname'];?> </td>
            <td> <?= $view['mi'];?> </td>
            <td> <?= $view['bsname'];?> </td>
            <td> <?= $view['bshouseno'];?> </td>
            <td> <?= $view['bsstreet'];?> </td>
            <td> <?= $view['bsbrgy'];?> </td>
            <td> <?= $view['bscity'];?> </td>
            <td> <?= $view['bsmunicipal'];?> </td>
            <td> <?= $view['bsindustry'];?> </td>
            <td> <?= $view['aoe'];?> </td>
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
            <th> Business Name </th>
            <th> House No. </th>
            <th> Street </th>
            <th> Barangay </th>
            <th> City </th>
            <th> Municipality </th>
            <th> Business Industry </th>
            <th> Area of Establishment </th>
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
                    tbl_bspermit AS b ON r.id_resident = b.id_resident
                WHERE 
                    b.`req_status` = ?");

            $pendingStatus = 'pending';
            $stmnt->execute([$pendingStatus]);

        
            while($view = $stmnt->fetch()){
            ?>
                <tr>
                    <td>    
                        <form action="" method="post">
                            <button class="btn btn-success" type="submit" name="accept_bspermit" style="width: 90px; font-size: 17px; border-radius:30px; margin-bottom: 2px;">Accept</button> 
                            <input type="hidden" name="id_bspermit" value="<?= $view['id_bspermit'];?>">
                            <input type="hidden" name="id_resident" value="<?= $view['id_resident'];?>">
                            <button class="btn btn-danger"  style="width: 90px; font-size: 17px; border-radius:30px;" type="submit" name="delete_bspermit"> Decline </button>
                        </form>
                    </td>
                    <td> <?= $view['id_resident'];?> </td> 
                    <td> <?= $view['lname'];?> </td>
                    <td> <?= $view['fname'];?> </td>
                    <td> <?= $view['mi'];?> </td>
                    <td> <?= $view['bsname'];?> </td>
                    <td> <?= $view['bshouseno'];?> </td>
                    <td> <?= $view['bsstreet'];?> </td>
                    <td> <?= $view['bsbrgy'];?> </td>
                    <td> <?= $view['bscity'];?> </td>
                    <td> <?= $view['bsmunicipal'];?> </td>
                    <td> <?= $view['bsindustry'];?> </td>
                    <td> <?= $view['aoe'];?> </td>
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
        <th> Business Name </th>
        <th> House No. </th>
        <th> Street </th>
        <th> Barangay </th>
        <th> City </th>
        <th> Municipality </th>
        <th> Business Industry </th>
        <th> Area of Establishment </th>
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
            tbl_bspermit AS b ON r.id_resident = b.id_resident
        WHERE 
            b.`req_status` = ?");

        $pendingStatus = 'accepted';
        $stmnt->execute([$pendingStatus]);

        while($view = $stmnt->fetch()){
    ?>
        <tr>
            <td>    
                <form action="" method="post">
                    <a class="btn btn-success" target="blank"  style="width: 90px; font-size: 17px; border-radius:30px; margin-bottom: 2px;" href="businesspermit_form.php?id_resident=<?= $view['id_resident'];?>">Generate</a> 
                    <input type="hidden" name="id_bspermit" value="<?= $view['id_bspermit'];?>">
                    <input type="hidden" name="id_resident" value="<?= $view['id_resident'];?>">
                    <button class="btn btn-danger"  style="width: 90px; font-size: 17px; border-radius:30px;" type="submit" name="delete_bspermit"> Delete </button>
                </form>
            </td>
            <td> <?= $view['id_resident'];?> </td> 
            <td> <?= $view['lname'];?> </td>
            <td> <?= $view['fname'];?> </td>
            <td> <?= $view['mi'];?> </td>
            <td> <?= $view['bsname'];?> </td>
            <td> <?= $view['bshouseno'];?> </td>
            <td> <?= $view['bsstreet'];?> </td>
            <td> <?= $view['bsbrgy'];?> </td>
            <td> <?= $view['bscity'];?> </td>
            <td> <?= $view['bsmunicipal'];?> </td>
            <td> <?= $view['bsindustry'];?> </td>
            <td> <?= $view['aoe'];?> </td>
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