<?php    
    $list = $_GET['list'];

	if(isset($_POST['search_certofres'])){
		$keyword = $_POST['keyword'];
?>
 <form method="GET" action="">
        <label for="list">Select List: </label>
        <select name="list" id="list" onchange="this.form.submit()">
            <option value="active" <?= (isset($_GET['list']) && $_GET['list'] == 'active') ? 'selected' : ''; ?>>Active</option>
            <option value="archived" <?= (isset($_GET['list']) && $_GET['list'] == 'archived') ? 'selected' : ''; ?>>Archived</option>
        </select>
    </form>
<table class="table table-hover text-center table-bordered table-responsive" >
    <thead class="alert-info">
        
        <tr>
            <th>  </th>
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
        </tr>
    </thead>

    <tbody>    
        <?php
            $list === 'active' ?
            $stmt = $conn->prepare("
            SELECT *
            FROM
                tbl_rescert
            WHERE
                (id_rescert LIKE ? OR
                fname LIKE ? OR
                mi LIKE ? OR
                lname LIKE ? OR
                age LIKE ? OR
                houseno LIKE ? OR
                street LIKE ? OR
                brgy LIKE ? OR
                city LIKE ? OR
                municipality LIKE ? OR
                purpose LIKE ? OR
                created_by LIKE ? OR
                created_on LIKE ?) AND
                doc_status = 'accepted')
            "):
            $stmt = $conn->prepare("
            SELECT *
            FROM
                tbl_rescert_archive
            WHERE
                id_rescert LIKE ? OR
                fname LIKE ? OR
                mi LIKE ? OR
                lname LIKE ? OR
                age LIKE ? OR
                houseno LIKE ? OR
                street LIKE ? OR
                brgy LIKE ? OR
                city LIKE ? OR
                municipality LIKE ? OR
                purpose LIKE ? OR
                archived_on LIKE ? OR
                archived_by LIKE ?
            ");
        
        $keywordLike = "%$keyword%";
        $list === 'active' ?
        $stmt->execute([
            $keywordLike, $keywordLike, $keywordLike, $keywordLike, 
            $keywordLike, $keywordLike, $keywordLike, $keywordLike, 
            $keywordLike, $keywordLike, $keywordLike, $keywordLike, 
            $keywordLike, $keywordLike
        ]):
        $stmt->execute([
            $keywordLike, $keywordLike, $keywordLike, $keywordLike, 
            $keywordLike, $keywordLike, $keywordLike, $keywordLike, 
            $keywordLike, $keywordLike, $keywordLike, $keywordLike, 
            $keywordLike
        ])
        ;
            
            while($view = $stmt->fetch()){
        ?>
            <tr>
                <td>    
                    <form action="" method="post">
                        <a class="btn btn-success" target="_blank" style="width: 90px; font-size: 17px; border-radius:30px; margin-bottom: 2px;" href="rescert_form.php?id_rescert=<?= $view['id_rescert'];?>">Generate</a> 
                                    <input type="hidden" name="id" value="<?= $userdetails['id'];?>">
                                    <input type="hidden" name="id_rescert" value="<?= $view['id_rescert'];?>">
                                    <?php 
                                echo $list === 'active' ? 
                                    '<button class="btn btn-danger" type="submit" style="width: 90px; font-size: 17px; border-radius:30px;" name="archive_certofres"> Archive </button>' :
                                    '<button class="btn btn-danger" type="submit" style="width: 90px; font-size: 17px; border-radius:30px;" name="unarchive_certofres"> Retrieve </button>'
                                    ;
                            ?>    
                    </form>
                </td>
                <td> <?= $view['id_rescert'];?> </td> 
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

            </tr>
        <?php
        }
        ?>
    </tbody>

</table>



<?php		
	}else{
?>
    <form method="GET" action="">
        <label for="list">Select List: </label>
        <select name="list" id="list" onchange="this.form.submit()">
            <option value="active" <?= (isset($_GET['list']) && $_GET['list'] == 'active') ? 'selected' : ''; ?>>Active</option>
            <option value="archived" <?= (isset($_GET['list']) && $_GET['list'] == 'archived') ? 'selected' : ''; ?>>Archived</option>
        </select>
    </form>
    <table class="table table-hover text-center table-bordered table-responsive">
		<thead class="alert-info">
			<tr>
                <th> Actions</th>
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
			</tr>
		</thead>
		<tbody>
		    <?php 
            $list === 'active' ? 
                $stmt = $conn->prepare("SELECT * FROM tbl_rescert WHERE doc_status = 'accepted'") : 
                $stmt = $conn->prepare("SELECT * FROM tbl_rescert_archive");

            $stmt->execute();
            $views = $stmt->fetchAll();
            if ($stmt->rowCount() > 0) {
                foreach ($views as $view) {
                ?>
                        <tr>
                            <td>    
                                <form action="" method="post">
                                    <a class="btn btn-success" target="_blank" style="width: 90px; font-size: 17px; border-radius:30px; margin-bottom: 2px;" href="rescert_form.php?id_rescert=<?= $view['id_rescert'];?>">Generate</a> 
                                    <input type="hidden" name="id" value="<?= $userdetails['id'];?>">
                                    <input type="hidden" name="id_rescert" value="<?= $view['id_rescert'];?>">
                            <?php 
                                echo $list === 'active' ? 
                                    '<button class="btn btn-danger" type="submit" style="width: 90px; font-size: 17px; border-radius:30px;" name="archive_certofres"> Archive </button>' :
                                    '<button class="btn btn-danger" type="submit" style="width: 90px; font-size: 17px; border-radius:30px;" name="unarchive_certofres"> Retrieve </button>'
                                    ;
                            ?>    
                            
                                </form>
                            </td>
                            <td> <?= $view['id_rescert'];?> </td> 
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