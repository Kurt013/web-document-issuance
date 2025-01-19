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
	   `fname` LIKE ? OR 
	   `sex` LIKE ? OR 
	   `contact` LIKE ? OR 
	   `email` LIKE ? OR 
	   `position` LIKE ?)
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
						<strong>Email:</strong> <?= htmlspecialchars($view['email']); ?><br>
						<strong>Middle Name:</strong> <?= htmlspecialchars($view['mi']); ?><br>
						<strong>Sex:</strong> <?= htmlspecialchars($view['sex']); ?><br>
						<strong>Contact #:</strong> <?= htmlspecialchars($view['contact']); ?><br>
						<strong>Position:</strong> <?= htmlspecialchars($view['position']); ?><br>
					</p>
				</div>
			</div>
		</div>
	<?php } ?>
<?php } ?>
	

</div>
<?php		
	}else{
?>


<div class="row"> <!-- Start row -->
    <?php if (is_array($view)) { ?>
        <?php foreach ($view as $view) { ?>
            <div class="col-md-4 mb-4"> <!-- Column for each card -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($view['fname']) . ' ' . htmlspecialchars($view['lname']); ?></h5>
                        <p class="card-text">
                            <strong>Email:</strong> <?= htmlspecialchars($view['email']); ?><br>
                            <strong>Middle Name:</strong> <?= htmlspecialchars($view['mi']); ?><br>
                            <strong>Sex:</strong> <?= htmlspecialchars($view['sex']); ?><br>
                            <strong>Contact #:</strong> <?= htmlspecialchars($view['contact']); ?><br>
                            <strong>Position:</strong> <?= htmlspecialchars($view['position']); ?><br>
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
