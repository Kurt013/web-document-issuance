<?php
	if(isset($_POST['search_totalstaff'])){
		$keyword = $_POST['keyword'];
?>

<table class="table table-hover table-bordered text-center responsive" >
	<thead class="alert-info">
		<tr>
			<th> Email </th>
			<th> Surname </th>
			<th> First name </th>
			<th> Middle name </th>
			<th> Sex </th>
			<th> Contact # </th>
			<th> Position </th>
		</tr>
	</thead>

	<tbody>     
		<?php
			$stmt = $conn->prepare("SELECT * FROM `tbl_user` WHERE `lname` LIKE '%$keyword%' or  `mi` LIKE '%$keyword%' or  `fname` LIKE '%$keyword%' 
			or  `sex` LIKE '%$keyword%' or  `contact` LIKE '%$keyword%'
			or `email` LIKE '%$keyword%'");
			$stmt->execute();
			
			while($view = $stmt->fetch()){
		?>
			<tr>
				<td> <?= $view['email'];?> </td>
				<td> <?= $view['lname'];?> </td>
				<td> <?= $view['fname'];?> </td>
				<td> <?= $view['mi'];?> </td>
				<td> <?= $view['sex'];?> </td>
				<td> <?= $view['contact'];?> </td>
				<td> <?= $view['position'];?> </td>
			</tr>
		<?php
		}
		?>
	</tbody>
</table>

<?php		
	}else{
?>

<table class="table table-hover table-bordered text-center responsive">
	<thead class="alert-info">
		<tr>
			<th> Email </th>
			<th> Surname </th>
			<th> First name </th>
			<th> Middle name </th>
			<th> Sex </th>
			<th> Contact # </th>
			<th> Position </th>
		</tr>
	</thead>

	<tbody>
		<?php if(is_array($view)) {?>
			<?php foreach($view as $view) {?>
				<tr>
					<td> <?= $view['email'];?> </td>
					<td> <?= $view['lname'];?> </td>
					<td> <?= $view['fname'];?> </td>
					<td> <?= $view['mi'];?> </td>
					<td> <?= $view['sex'];?> </td>
					<td> <?= $view['contact'];?> </td>
					<td> <?= $view['position'];?> </td>
				</tr>
			
			<?php
				}
			?>
		<?php
			}
		?>
	</tbody>
</table>

<?php
	}
$con = null;
?>