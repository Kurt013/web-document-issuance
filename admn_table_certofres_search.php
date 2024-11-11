<?php
	// require the database connection
	require 'classes/conn.php';
	if(isset($_POST['search_certofres'])){
		$keyword = $_POST['keyword'];
?>
<h2>Accepted Requests</h2>

<table class="table table-hover text-center table-bordered table-responsive" >
    <thead class="alert-info">
        
        <tr>
            <th>  </th>
            <th> Clearance No. </th>
            <th> Surname </th>
            <th> First Name </th>
            <th> Middle Name </th>
            <th> Age </th>
            <th> Nationality </th>
            <th> House Number </th>
            <th> Street </th>
            <th> Barangay </th>
            <th> City </th>
            <th> Municipality </th>
            <th> Purpose </th>
        </tr>
    </thead>

    <tbody>    
        <?php
            $stmnt = $conn->prepare("
            SELECT *
            FROM
                tbl_rescert
            WHERE
                id_rescert LIKE ? AND
                fname LIKE ? AND
                mi LIKE ? AND
                lname LIKE ? AND
                age LIKE ? AND
                nationality LIKE ? AND
                houseno LIKE ? AND
                street LIKE ? AND
                brgy LIKE ? AND
                city LIKE ? AND
                municipality LIKE ? AND
                purpose LIKE ? AND
                generated_by LIKE ? AND
                generated_on LIKE ?
            ");
        
        $keywordLike = "%$keyword%";

        $stmnt->execute([
            $keywordLike, $keywordLike, $keywordLike, $keywordLike, 
            $keywordLike, $keywordLike, $keywordLike, $keywordLike, 
            $keywordLike, $keywordLike, $keywordLike, $keywordLike, 
            $keywordLike, $keywordLike
        ]);
            
            while($view = $stmnt->fetch()){
        ?>
            <tr>
                <td>    
                    <form action="" method="post">
                        <a class="btn btn-success" target="_blank" style="width: 90px; font-size: 17px; border-radius:30px; margin-bottom: 2px;" href="rescert_form.php?id_resident=<?= $view['id_resident'];?>">Generate</a> 
                        <input type="hidden" name="id_rescert" value="<?= $view['id_rescert'];?>">
                        <button class="btn btn-danger" type="submit" style="width: 90px; font-size: 17px; border-radius:30px;" name="archive_certofres"> Archive </button>
                    </form>
                </td>
                <td> <?= $view['id_rescert'];?> </td> 
                <td> <?= $view['lname'];?> </td>
                <td> <?= $view['fname'];?> </td>
                <td> <?= $view['mi'];?> </td>
                <td> <?= $view['age'];?> </td>
                <td> <?= $view['nationality'];?> </td>
                <td> <?= $view['houseno'];?> </td>
                <td> <?= $view['street'];?> </td>
                <td> <?= $view['brgy'];?> </td>
                <td> <?= $view['city'];?> </td>
                <td> <?= $view['municipal'];?> </td>
                <td> <?= $view['purpose'];?> </td>

            </tr>
        <?php
        }
        ?>
    </tbody>

</table>



<?php		
	}else{
?>
    <h2>Accepted Requests</h2>

    <table class="table table-hover text-center table-bordered table-responsive">
		<thead class="alert-info">
			<tr>
                <th> Actions</th>
                <th> Clearance No. </th>
                <th> Surname </th>
                <th> First Name </th>
                <th> Middle Name </th>
                <th> Age </th>
                <th> Nationality </th>
                <th> House Number </th>
                <th> Street </th>
                <th> Barangay </th>
                <th> City </th>
                <th> Municipality </th>
                <th> Purpose </th>
			</tr>
		</thead>
		<tbody>
		    <?php 
            $stmnt = $conn->prepare("SELECT * FROM tbl_rescert");
            $views = $stmt->fetchAll();
            if ($stmnt->rowCount() > 0) {
                foreach ($view as $views) {
                ?>
                        <tr>
                            <td>    
                                <form action="" method="post">
                                    <a class="btn btn-success" target="_blank" style="width: 90px; font-size: 17px; border-radius:30px; margin-bottom: 2px;" href="rescert_form.php?id_resident=<?= $view['id_resident'];?>">Generate</a> 
                                    <input type="hidden" name="id_rescert" value="<?= $view['id_rescert'];?>">
                            <button class="btn btn-danger" type="submit" style="width: 90px; font-size: 17px; border-radius:30px;" name="delete_certofres"> Archive </button>
                                </form>
                            </td>
                            <td> <?= $view['id_rescert'];?> </td> 
                            <td> <?= $view['lname'];?> </td>
                            <td> <?= $view['fname'];?> </td>
                            <td> <?= $view['mi'];?> </td>
                            <td> <?= $view['age'];?> </td>
                            <td> <?= $view['nationality'];?> </td>
                            <td> <?= $view['houseno'];?> </td>
                            <td> <?= $view['street'];?> </td>
                            <td> <?= $view['brgy'];?> </td>
                            <td> <?= $view['city'];?> </td>
                            <td> <?= $view['municipal'];?> </td>
                            <td> <?= $view['purpose'];?> </td>
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