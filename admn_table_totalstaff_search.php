<style>
/* Container for the cards */
.col {

    margin-bottom: 20px; /* Spacing between cards */
}

/* Card styling */
.card {
    position: relative; /* Make the card a positioning context */
    border-left: 10px solid #014bae !important; /* Remove any default borders */
    padding: 5px; /* Ensure space for content inside the card */
    background: white; /* Card background */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3); /* Optional shadow */
    border-radius: 10px; /* Optional rounded corners */

    overflow: hidden; /* Ensure content doesn't spill out */
}



/* Card hover effect */
.card:hover {
    transform: scale(1.02); /* Slightly enlarge the card */
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
}

/* Card body */
.card-body {
    padding: 20px;
}

/* Title styling */
.card-title {
    font-size: 22px;
    font-weight: bold;
    color: white;
	background-color: #014bae; /* Horizontal gradient */

	padding:10px;
	border-radius: 10px 10px 10px 0;


    margin-bottom: 15px;
	font-family: "PSemiBold";
}

/* Text styling */
.card-text {
    font-size: 1rem;
	font-family: "PRegular" !important;
	line-height: 25px;
	
    color: #555;
}

/* Strong text (labels) */
.card-text strong {
    color: #014bae;
	font-family: "PRegular" !important;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .card {
        max-width: 100%; /* Ensure cards use full width on smaller screens */
    }
}

</style>
<?php include ('logout_script.php'); ?>

<?php

$sql = "SELECT * FROM tbl_user WHERE role = :role";
$stmt = $conn->prepare($sql);

// Bind the parameter
$role = 'staff';
$stmt->bindParam(':role', $role, PDO::PARAM_STR);

// Execute the statement
$stmt->execute();

// Fetch all rows
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

 

if (count($result) == 0) {
    echo '
    <div style="text-align: center; padding: 20px !important; margin-top: 20px; margin-bottom: 50px">
        <img src="assets/emptystaff.png" alt="No Data Available" style="max-width: 600px; display: block; padding: 0 !important; margin: 0 auto;">
        <p class="norec">No staff members have been registered in the system yet.</p>
        <p class="norec2">Begin organizing your barangay team by adding new staff members. Click the button below to manage staff records.</p>
        <!-- Button added below the text -->
<button class="btnqr" onclick="window.location.href=\'admn_staff_crud.php\'">
    <i class="fas fa-user-plus" style="margin-right: 8px;"></i> Manage Staff
</button>
    </div>';
    return;
} 
?>

<div class = "add-staff-cnt">
<button class="add-staff-btn" onclick="window.location.href='admn_staff_crud.php'">
    <i class="fas fa-users-cog" style="margin-right: 8px;"></i> Manage Staff
</button>
</div>

<?php
	// require the database connection
	if(isset($_POST['search_totalstaff'])){
		$keyword = $_POST['keyword'];
?>



  
		<?php
$keywordLike = "%$keyword%";

$stmt = $conn->prepare("
SELECT * 
FROM `tbl_user` 
WHERE (`lname` LIKE ? OR  
	   `mi` LIKE ? OR  
       `username` LIKE ? OR 
	   `fname` LIKE ? OR 
	   `sex` LIKE ? OR 
	   `contact` LIKE ? OR 
	   `email` LIKE ?)
  AND `role` = 'staff'
ORDER BY lname ASC
");

// Bind the parameters
$stmt->execute([
$keywordLike, $keywordLike, $keywordLike, 
$keywordLike, $keywordLike, $keywordLike, 
$keywordLike
]);

// Fetch the results
$results = $stmt->fetchAll();
?>
    <div class="row" style = "display:flex">

 <?php if ($stmt->rowCount() > 0) { ?>
	<?php foreach ($results as $view) { ?>
		<div class="col-md-4 mb-4"> <!-- Column for each card -->
			<div class="card">
				<div class="card-body">
					<h5 class="card-title"><?= htmlspecialchars($view['fname']) . ' ' . htmlspecialchars($view['lname']); ?></h5>
					<p class="card-text">
                        <strong>Username:</strong> <?= htmlspecialchars($view['username']); ?><br>
						<strong>Email:</strong> <?= htmlspecialchars($view['email']); ?><br>
						<strong>Middle Initial:</strong> <?= htmlspecialchars($view['mi']); ?><br>
						<strong>Sex:</strong> <?= htmlspecialchars($view['sex']); ?><br>
						<strong>Contact #:</strong> <?= htmlspecialchars($view['contact']); ?><br>
					</p>
				</div>
			</div>
		</div>
	<?php } ?>
    <?php } else { ?>
    </div>
    <div style="text-align: center; padding: 20px !important; background-color: transparent !important; margin-bottom: 20px;">
                    <img src="assets/notfound.png" alt="No Data Available" style="max-width: 700px; display: block;  padding: 0 !important; margin: 0 auto;">
                        
                    <p class="norec">No staff found matching your search criteria.<p>
                        <p class="norec2">It seems no staff match your search. Try adjusting your search criteria or check back later.</p>
                        <button class="btnqr"  onclick="window.location.href = window.location.href;">
            <i class="fas fa-sync" style="margin-right: 8px;"></i> Reload
        </button>
                </div>

<?php		
	}}else{
?>


<div class="row"> <!-- Start row -->
    <?php if (is_array($view)) { ?>
        <?php foreach ($view as $view) { ?>
            <div class="col-md-4 mb-4"> <!-- Column for each card -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($view['fname']) . ' ' . htmlspecialchars($view['lname']); ?></h5>
                        <p class="card-text">
                            <strong>Username:</strong> <?= htmlspecialchars($view['username']); ?><br>
                            <strong>Email:</strong> <?= htmlspecialchars($view['email']); ?><br>
                            <strong>Middle Initial:</strong> <?= htmlspecialchars($view['mi']); ?><br>
                            <strong>Sex:</strong> <?= htmlspecialchars($view['sex']); ?><br>
                            <strong>Contact #:</strong> <?= htmlspecialchars($view['contact']); ?><br>
                        </p>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php } ?>
</div> <!-- End row -->


<?php
	}
$conn = null;


?>



<?php include('table_script.php'); ?>
