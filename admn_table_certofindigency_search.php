<?php
	// require the database connection
	require 'classes/conn.php';
	if(isset($_POST['search_certofindigency'])){
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
            <th> Nationality </th>
            <th> House Number </th>
            <th> Street </th>
            <th> City </th>
            <th> Barangay </th>
            <th> Municipality </th>
            <th> Purpose </th>
            <th> Date </th>
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
                r.nationality,
                r.houseno,
                r.street,
                r.brgy,
                r.city,
                r.municipal,
                i.id_indigency,
                i.`date`,
                i.purpose,
                i.req_status
            FROM
                tbl_resident AS r
            JOIN
                tbl_indigency AS i ON r.id_resident = i.id_resident
            WHERE
                (r.`lname` LIKE ? OR  
                 r.`mi` LIKE ? OR  
                 r.`fname` LIKE ? OR 
                 r.`age` LIKE ? OR  
                 r.`id_resident` LIKE ? OR  
                 r.`nationality` LIKE ? OR  
                 r.`houseno` LIKE ? OR
                 r.`street` LIKE ? OR 
                 r.`brgy` LIKE ? OR 
                 r.`municipal` LIKE ? OR 
                 r.`city` LIKE ? OR 
                 i.`date` LIKE ? OR 
                 ic.`purpose` LIKE ?) 
                AND i.`req_status` = ?");
        
        $keywordLike = "%$keyword%";
        $pendingStatus = 'pending';
        
        $stmnt->execute([
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
                        <button class="btn btn-success" type="submit" name="accept_certofindigency" style="width: 90px; font-size: 17px; border-radius:30px; margin-bottom: 2px;"> Accept </button> 
                        <input type="hidden" name="id_indigency" value="<?= $view['id_indigency'];?>">
                        <input type="hidden" name="id_resident" value="<?= $view['id_resident'];?>">
                        <button class="btn btn-danger" style="width: 90px; font-size: 17px; border-radius:30px;" type="submit" name="delete_certofindigency"> Decline </button>
                    </form>
                </td>
                <td> <?= $view['id_resident'];?> </td> 
                <td> <?= $view['lname'];?> </td>
                <td> <?= $view['fname'];?> </td>
                <td> <?= $view['mi'];?> </td>
                <td> <?= $view['nationality'];?> </td>
                <td> <?= $view['houseno'];?> </td>
                <td> <?= $view['street'];?> </td>
                <td> <?= $view['brgy'];?> </td>
                <td> <?= $view['city'];?> </td>
                <td> <?= $view['municipal'];?> </td>
                <td> <?= $view['purpose'];?> </td>
                <td> <?= $view['date'];?> </td>
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
            <th> Nationality </th>
            <th> House Number </th>
            <th> Street </th>
            <th> Barangay </th>
            <th> City </th>
            <th> Municipality </th>
            <th> Purpose </th>
            <th> Date </th>
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
                r.nationality,
                r.houseno,
                r.street,
                r.brgy,
                r.city,
                r.municipal,
                i.id_indigency,
                i.`date`,
                i.purpose,
                i.req_status
            FROM
                tbl_resident AS r
            JOIN
                tbl_indigency AS i ON r.id_resident = i.id_resident
            WHERE
                (r.`lname` LIKE ? OR  
                 r.`mi` LIKE ? OR  
                 r.`fname` LIKE ? OR 
                 r.`age` LIKE ? OR  
                 r.`id_resident` LIKE ? OR  
                 r.`nationality` LIKE ? OR  
                 r.`houseno` LIKE ? OR
                 r.`street` LIKE ? OR 
                 r.`brgy` LIKE ? OR 
                 r.`municipal` LIKE ? OR 
                 r.`city` LIKE ? OR 
                 i.`date` LIKE ? OR 
                 ic.`purpose` LIKE ?) 
                AND i.`req_status` = ?");
        
        $keywordLike = "%$keyword%";
        $pendingStatus = 'accepted';
        
        $stmnt->execute([
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
                        <a class="btn btn-success" target="_blank" style="width: 90px; font-size: 17px; border-radius:30px; margin-bottom: 2px;" href="indigency_form.php?id_resident=<?= $view['id_resident'];?>">Generate</a> 
                        <input type="hidden" name="id_indigency" value="<?= $view['id_indigency'];?>">
                        <input type="hidden" name="id_resident" value="<?= $view['id_resident'];?>">
                        <button class="btn btn-danger" style="width: 90px; font-size: 17px; border-radius:30px;" type="submit" name="archive_certofindigency"> Archive </button>
                    </form>
                </td>
                <td> <?= $view['id_resident'];?> </td> 
                <td> <?= $view['lname'];?> </td>
                <td> <?= $view['fname'];?> </td>
                <td> <?= $view['mi'];?> </td>
                <td> <?= $view['nationality'];?> </td>
                <td> <?= $view['houseno'];?> </td>
                <td> <?= $view['street'];?> </td>
                <td> <?= $view['brgy'];?> </td>
                <td> <?= $view['city'];?> </td>
                <td> <?= $view['municipal'];?> </td>
                <td> <?= $view['purpose'];?> </td>
                <td> <?= $view['date'];?> </td>
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
            <th> Nationality </th>
            <th> House Number </th>
            <th> Street </th>
            <th> Barangay </th>
            <th> City </th>
            <th> Municipality </th>
            <th> Purpose </th>
            <th> Date </th>
        </tr>
    </thead>
    
    <tbody>
        <?php 
            $stmnt = $conn->prepare("
                SELECT 
                    r.*, i.* 
                FROM 
                    tbl_resident AS r
                JOIN
                    tbl_indigency AS i ON r.id_resident = i.id_resident
                WHERE 
                    i.`req_status` = ?");

            $pendingStatus = 'pending';
            $stmnt->execute([$pendingStatus]);

            while ($view = $stmnt->fetch()) { ?>
                <tr>
                    <td>    
                        <form action="" method="post">
                            <button class="btn btn-success" type="submit" name="accept_certofindigency" style="width: 90px; font-size: 17px; border-radius:30px; margin-bottom: 2px;"> Accept </button>  
                            <input type="hidden" name="id_indigency" value="<?= $view['id_indigency'];?>">
                            <input type="hidden" name="id_resident" value="<?= $view['id_resident'];?>">
                            <button class="btn btn-danger" style="width: 90px; font-size: 17px; border-radius:30px;" type="submit" name="delete_certofindigency"> Decline </button>
                        </form>
                    </td>
                    <td> <?= $view['id_resident'];?> </td> 
                    <td> <?= $view['lname'];?> </td>
                    <td> <?= $view['fname'];?> </td>
                    <td> <?= $view['mi'];?> </td>
                    <td> <?= $view['nationality'];?> </td>
                    <td> <?= $view['houseno'];?> </td>
                    <td> <?= $view['street'];?> </td>
                    <td> <?= $view['brgy'];?> </td>
                    <td> <?= $view['city'];?> </td>
                    <td> <?= $view['municipal'];?> </td>
                    <td> <?= $view['purpose'];?> </td>
                    <td> <?= $view['date'];?> </td>
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
            <th> Nationality </th>
            <th> House Number </th>
            <th> Street </th>
            <th> Barangay </th>
            <th> City </th>
            <th> Municipality </th>
            <th> Purpose </th>
            <th> Date </th>
        </tr>
    </thead>
    
    <tbody>
        <?php 
        $stmnt = $conn->prepare("
            SELECT 
                r.*, i.* 
            FROM 
                tbl_resident AS r
            JOIN
                tbl_indigency AS i ON r.id_resident = i.id_resident
            WHERE 
                i.`req_status` = ?");

        $pendingStatus = 'accepted';

        $stmnt->execute([$pendingStatus]);
            while ($view = $stmnt->fetch()) { ?>
                <tr>
                    <td>    
                        <form action="" method="post">
                            <a class="btn btn-success" target="_blank" style="width: 90px; font-size: 17px; border-radius:30px; margin-bottom: 2px;" href="indigency_form.php?id_resident=<?= $view['id_resident'];?>">Generate</a> 
                            <input type="hidden" name="id_indigency" value="<?= $view['id_indigency'];?>">
                            <input type="hidden" name="id_resident" value="<?= $view['id_resident'];?>">
                            <button class="btn btn-danger" style="width: 90px; font-size: 17px; border-radius:30px;" type="submit" name="archive_certofindigency"> Archive </button>
                        </form>
                    </td>
                    <td> <?= $view['id_resident'];?> </td> 
                    <td> <?= $view['lname'];?> </td>
                    <td> <?= $view['fname'];?> </td>
                    <td> <?= $view['mi'];?> </td>
                    <td> <?= $view['nationality'];?> </td>
                    <td> <?= $view['houseno'];?> </td>
                    <td> <?= $view['street'];?> </td>
                    <td> <?= $view['brgy'];?> </td>
                    <td> <?= $view['city'];?> </td>
                    <td> <?= $view['municipal'];?> </td>
                    <td> <?= $view['purpose'];?> </td>
                    <td> <?= $view['date'];?> </td>
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