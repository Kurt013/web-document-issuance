<?php
	if(isset($_POST['search_bspermit'])){
		$keyword = $_POST['keyword'];
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
        <th> Area of Establishment </th>
    </tr>
</thead>

<tbody>     
    <?php
            $list === 'active' ?

            $stmnt = $conn->prepare("
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
                    AND `doc_status` = ?") : 
            $stmnt = $conn->prepare("
                SELECT *
                FROM
                    tbl_bspermit_archive
                WHERE
                    id_bspermit LIKE ? OR
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
                    archived_by LIKE ?
                ");

        $keywordLike = "%$keyword%";
        $pendingStatus = 'accepted';
        
        $list === 'active' ?
            $stmnt->execute([
                $keywordLike, $keywordLike, $keywordLike, $keywordLike, 
                $keywordLike, $keywordLike, $keywordLike, $keywordLike, 
                $keywordLike, $keywordLike, $keywordLike, $keywordLike,
                $keywordLike, $keywordLike, $pendingStatus
            ]):
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
                <a class="btn btn-success" target="_blank" style="width: 90px; font-size: 17px; border-radius:30px; margin-bottom: 2px;" href="bspermit_form.php?id_bspermit=<?= $view['id_bspermit'];?><?php if ($list === 'archived') echo '&status=archived';?>">Generate</a> 
                            <input type="hidden" name="id" value="<?= $userdetails['id'];?>">
                            <input type="hidden" name="id_bspermit" value="<?= $view['id_bspermit'];?>">
                            <?php 
                        echo $list === 'active' ? 
                            '<button class="btn btn-danger" type="submit" style="width: 90px; font-size: 17px; border-radius:30px;" name="archive_bspermit"> Archive </button>' :
                            '<button class="btn btn-danger" type="submit" style="width: 90px; font-size: 17px; border-radius:30px;" name="unarchive_bspermit"> Retrieve </button>'
                            ;
                    ?>    
            </form>
            </td>
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
        <th> </th>
        <th> Issuance No.</th>
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
            <td>    
            <form action="" method="post">
                <a class="btn btn-success" target="_blank" style="width: 90px; font-size: 17px; border-radius:30px; margin-bottom: 2px;" href="bspermit_form.php?id_bspermit=<?= $view['id_bspermit'];?><?php if ($list === 'archived') echo '&status=archived';?>">Generate</a> 
                <input type="hidden" name="id" value="<?= $userdetails['id'];?>">
                <input type="hidden" name="id_bspermit" value="<?= $view['id_bspermit'];?>">
                <?php 
                    echo $list === 'active' ? 
                        '<button class="btn btn-danger" type="submit" style="width: 90px; font-size: 17px; border-radius:30px;" name="archive_bspermit"> Archive </button>' :
                        '<button class="btn btn-danger" type="submit" style="width: 90px; font-size: 17px; border-radius:30px;" name="unarchive_bspermit"> Retrieve </button>'
                        ;
                ?>    
            </form>
            </td>
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

<?php
	}
$con = null;
?>