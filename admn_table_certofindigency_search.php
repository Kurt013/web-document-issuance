<?php
	if(isset($_POST['search_certofindigency'])){
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
            <th> </th>
            <th> Issuance No. </th>
            <th> Surname </th>
            <th> First Name </th>
            <th> Middle Name </th>
            <th> Age </th>
            <th> Nationality </th>
            <th> House Number </th>
            <th> Street </th>
            <th> City </th>
            <th> Barangay </th>
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
                tbl_indigency
            WHERE
                (id_indigency LIKE ? OR
                    fname LIKE ? OR
                    mi LIKE ? OR
                    lname LIKE ? OR
                    age LIKE ? OR   
                    nationality LIKE ? OR
                    houseno LIKE ? OR
                    street LIKE ? OR
                    brgy LIKE ? OR
                    city LIKE ? OR
                    municipality LIKE ? OR
                    purpose LIKE ? OR
                    created_by LIKE ? OR
                    created_on LIKE ?) AND
                doc_status = ?
            ") :
            $stmt = $conn->prepare("
            SELECT *
            FROM
                tbl_indigency_archive
            WHERE
                id_indigency LIKE ? OR
                fname LIKE ? OR
                mi LIKE ? OR
                lname LIKE ? OR
                age LIKE ? OR
                nationality LIKE ? OR
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
        $pendingStatus = "accepted";

        $list === 'active' ?
            $stmt->execute([
                $keywordLike, $keywordLike, $keywordLike, $keywordLike, 
                $keywordLike, $keywordLike, $keywordLike, $keywordLike, 
                $keywordLike, $keywordLike, $keywordLike, $keywordLike, 
                $keywordLike, $keywordLike, $pendingStatus
            ]):
            $stmt->execute([
                $keywordLike, $keywordLike, $keywordLike, $keywordLike, 
                $keywordLike, $keywordLike, $keywordLike, $keywordLike, 
                $keywordLike, $keywordLike, $keywordLike, $keywordLike, 
                $keywordLike, $keywordLike
            ]);
            
            while($view = $stmt->fetch()){
        ?>
            <tr>
                <td>    
                    <form action="" method="post">
                        <a class="btn btn-success" target="_blank" style="width: 90px; font-size: 17px; border-radius:30px; margin-bottom: 2px;" href="indigency_form.php?id_indigency=<?= $view['id_indigency'];?><?php if ($list === 'archived') echo '&status=archived';?>">Generate</a> 
                        <input type="hidden" name="id" value="<?= $userdetails['id'];?>">
                        <input type="hidden" name="id_indigency" value="<?= $view['id_indigency'];?>">
                        <?php 
                            echo $list === 'active' ? 
                                '<button class="btn btn-danger" type="submit" style="width: 90px; font-size: 17px; border-radius:30px;" name="archive_certofindigency"> Archive </button>' :
                                '<button class="btn btn-danger" type="submit" style="width: 90px; font-size: 17px; border-radius:30px;" name="unarchive_certofindigency"> Retrieve </button>'
                                ;
                        ?>    
                    </form>
                </td>
                <td> <?= $view['id_indigency'];?> </td> 
                <td> <?= $view['lname'];?> </td>
                <td> <?= $view['fname'];?> </td>
                <td> <?= $view['mi'];?> </td>
                <td> <?= $view['age'];?> </td>
                <td> <?= $view['nationality'];?> </td>
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
            <th> </th>
            <th> Issuance No. </th>
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
        $pendingStatus = 'accepted';

        if ($list === 'active') {
            $stmt = $conn->prepare("SELECT * FROM tbl_indigency WHERE doc_status = ?");
            $stmt->execute([$pendingStatus]);
        } else {
            $stmt = $conn->prepare("SELECT * FROM tbl_indigency_archive");
            $stmt->execute();
        }

        $views = $stmt->fetchAll();
        if ($stmt->rowCount() > 0) {
            foreach ($views as $view) {
        ?>
            <tr>
                <td>    
                    <form action="" method="post">
                        <a class="btn btn-success" target="_blank" style="width: 90px; font-size: 17px; border-radius:30px; margin-bottom: 2px;" href="indigency_form.php?id_indigency=<?= $view['id_indigency'];?><?php if ($list === 'archived') echo '&status=archived';?>">Generate</a> 
                        <input type="hidden" name="id" value="<?= $userdetails['id'];?>">
                        <input type="hidden" name="id_indigency" value="<?= $view['id_indigency'];?>">
                    <?php 
                        echo $list === 'active' ? 
                            '<button class="btn btn-danger" type="submit" style="width: 90px; font-size: 17px; border-radius:30px;" name="archive_certofindigency"> Archive </button>' :
                            '<button class="btn btn-danger" type="submit" style="width: 90px; font-size: 17px; border-radius:30px;" name="unarchive_certofindigency"> Retrieve </button>'
                            ;
                    ?>    
                            
                    </form>
                </td>
                <td> <?= $view['id_indigency'];?> </td> 
                <td> <?= $view['lname'];?> </td>
                <td> <?= $view['fname'];?> </td>
                <td> <?= $view['mi'];?> </td>
                <td> <?= $view['age'];?> </td>
                <td> <?= $view['nationality'];?> </td>
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

<?php
	}
$con = null;
?>