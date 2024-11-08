<?php
require('classes/resident.class.php');
$userdetails = $residentbmis->get_userdata();
$residentbmis->validate_admin();
$residentbmis->update_brgyid();
$residentbmis->update_brgyid_photo();

$id_resident = $_GET['id_resident'];
$resident = $residentbmis->get_single_brgyid($id_resident);

$imageData = $resident['res_photo'];

$finfo = new finfo(FILEINFO_MIME_TYPE);
$mimeType = $finfo->buffer($imageData); // Detects MIME type from the binary data

// Encode the image data to base64
$base64Image = base64_encode($imageData);
  ?>
<!DOCTYPE html>
<html id="barangayid">
<style>
    @media print {
        .noprint {
        visibility: hidden;
         }
    }
    @page { size: auto;  margin: 4mm; }
    
label {
  color: black !important;
}



</style>

 <head>
    <meta charset="UTF-8">
    <title>Barangay Information System</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- bootstrap 3.0.2 -->
    <link href="../BarangaySystem/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- font Awesome -->
    <link href="../BarangaySystem/bootstrap/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="../BarangaySystem/bootstrap/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <link href="../BarangaySystem/bootstrap/css/morris-0.4.3.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="../BarangaySystem/bootstrap/css/AdminLTE.css" rel="stylesheet" type="text/css" />
    <link href="./BarangaySystem/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="../BarangaySystem/bootstrap/css/select2.css" rel="stylesheet" type="text/css" />
    <script src="../BarangaySystem/bootstrap/css/jquery-1.12.3.js" type="text/javascript"></script>  
    
    
    

</head>
 <body class="skin-black" >
     <!-- header logo: style can be found in header.less -->
    
    
     <?php 
     
     include "classes/conn.php"; 

     ?> 

    <img style="width: 192px; height: 192px; object-fit:cover;" src="data:<?= $mimeType ?>;base64,<?= $base64Image ?>" alt="Resident Image">
    <button class="noprint" onclick="changePic('camera.php?id_resident=<?= $id_resident ?>');" > Retake Photo </button>

                      
      <p>
      <span contenteditable="true" id="fname"><?= $resident['fname'] ?></span> 
      <span contenteditable="true" id="mi"><?= $resident['mi'] ?></span> 
      <span contenteditable="true" id="lname"><?= $resident['lname'] ?></span>
    </p>

    <h1>ADDRESS</h1>
    <p>
      <span contenteditable="true" id="houseno"><?= $resident['houseno'] ?></span>
      <span contenteditable="true" id="street"><?= $resident['street'] ?></span>,
      <span contenteditable="true" id="brgy"><?= $resident['brgy'] ?></span>,
      <span contenteditable="true" id="city"><?= $resident['city'] ?></span>,
      <span contenteditable="true" id="municipal"><?= $resident['municipal'] ?></span>
    </p>

    <p id="id_brgyid"><?= $resident['id_brgyid'] ?></p>
    <p contenteditable="true" id="valid_until"><?= $resident['valid_until']?><p>

    <p contenteditable="true" id="status"><?= $resident['status']?><p>
    <p id="precint_no"><?= $resident['precint_no'] ?></p>

    <h1>In case of emergency please notify</h1>
        
    <p>
      <span contenteditable="true" id="inc_fname"><?= $resident['inc_fname'] ?></span>
      <span contenteditable="true" id="inc_mi"><?= $resident['inc_mi'] ?>.</span>
      <span contenteditable="true" id="inc_lname"><?= $resident['inc_lname'] ?></span> /
      <span contenteditable="true" id="inc_contact"><?= $resident['inc_contact'] ?></span>
    </p>

    <h2>Address</h2>
    <p>
      <span contenteditable="true" id="inc_houseno"><?= $resident['inc_houseno'] ?></span>
      <span contenteditable="true" id="inc_street"><?= $resident['inc_street'] ?></span>,
      <span contenteditable="true" id="inc_brgy"><?= $resident['inc_brgy'] ?></span>,
      <span contenteditable="true" id="inc_city"><?= $resident['inc_city'] ?></span>,
      <span contenteditable="true" id="inc_municipal"><?= $resident['inc_municipal'] ?></span>
    </p>
            
    <button class="btn btn-primary noprint" id="printpagebutton" onclick="PrintElem('#clearance')">Print</button>
    </body><button class="noprint btn-update">Update</button>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="./js-components/component-js-openwindow.js"></script>
    <?php
    
    ?>


    <script>
         function PrintElem(elem)
    {
        window.print();
    }

    function Popup(data) 
    {
        var mywindow = window.open('', 'my div', 'height=400,width=1000');
        //mywindow.document.write('<html><head><title>my div</title>');
        /*optional stylesheet*/ //mywindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
        //mywindow.document.write('</head><body class="skin-black" >');
         var printButton = document.getElementById("printpagebutton");
        //Set the print button visibility to 'hidden' 
        printButton.style.visibility = 'hidden';
        mywindow.document.write(data);
        //mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10

        mywindow.print();

        printButton.style.visibility = 'visible';
        mywindow.close();

        return true;
    }

    
    $(document).ready(function () {
        $('.btn-update').on('click', function () {
            // Capture the editable content
            const data = {
                update_brgyid: true,
                fname: $('#fname').text(),
                mi: $('#mi').text(),
                lname: $('#lname').text(),
                houseno: $('#houseno').text(),
                street: $('#street').text(),
                brgy: $('#brgy').text(),
                city: $('#city').text(),
                municipal: $('#municipal').text(),
                valid_until: $('#valid_until').text(),
                status: $('#status').text(),
                inc_fname: $('#inc_fname').text(),
                inc_mi: $('#inc_mi').text(),
                inc_lname: $('#inc_lname').text(),
                inc_houseno: $('#inc_houseno').text(),
                inc_street: $('#inc_street').text(),
                inc_brgy: $('#inc_brgy').text(),
                inc_city: $('#inc_city').text(),
                inc_municipal: $('#inc_municipal').text()
            };

            $.ajax({
                type: "POST",
                url: window.location.href,
                data: data,
                success: function (response) {
                    alert("updated succesfully!");
                    location.reload();
             },
                error: function () {
                    alert("An error occurred while updating.");
                }
            });
        });
    });
    </script>
</html>