<?php
    require('classes/staff.class.php');

    $user = $staffbmis->get_userdata();

    $staffbmis->validate_staff();

    $resident = $staffbmis->get_single_bspermit();

    $staffbmis->update_bspermit();

  // try {
  //   foreach ($resident as $key => $value) {
  //     if (empty($key)) {
  //       throw new Exception("Field {$resident} is missing in the data.");
  //     }
  //   }
  // } catch(Exception $e) {
  //   echo "<script>document.querySelector('body').innerText = '{$e->getMessage()}'";
  // }

  ?>
<!DOCTYPE html>
<html id="bspermit">
 <head>
    <meta charset="UTF-8">
    <title>Barangay Information System</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>  
    
    <style>
    @page { size: auto;  margin: 4mm; }

    [contenteditable] {
      border: 2px solid black;
      min-width: 10px;
      display: inline-block;
    }

    @media print {
      .noprint {
        visibility: hidden;
        }

      [contenteditable] {
        border: none;
        min-width: 0;
      }
      
    }
    </style>
</head>
 <body>
 <?php include './form_header.php' 
    ?>

  <h1 style="text-transform: uppercase;">Business Permit</h1>

    <p>ISSUANCE NO.: <u id="id_bspermit"><?= $resident['id_bspermit'] ?></u></p>
    <p>TO WHOM IT MAY CONCERN:</p>
    <p> This document hereby certifies that
        <span contenteditable="true" id="fname"><?= $resident['fname'];?></span>
        <span contenteditable="true" id="mi"><?= $resident['mi']?></span>.
        <span contenteditable="true" id="lname"><?= $resident['lname'] ?></span>, 
        is officially recognized as a legitimate resident of
        <span contenteditable="true" id="bshouseno"><?= $resident['bshouseno']?></span> 
        <span contenteditable="true" id="bsstreet"><?= $resident['bsstreet'] ?></span> Brgy.
        <span contenteditable="true" id="bsbrgy"><?= $resident['bsbrgy']; ?></span>
        <span contenteditable="true" id="bscity"><?= $resident['bscity']; ?></span> 
        <span contenteditable="true" id="bsmunicipality"><?= $resident['bsmunicipality'] ?></span>
        The said person is of good moral character and an active member of the community.
    </p>

    <p>
        This certification is being issued upon the request of the above mentioned person for
        <span contenteditable="true" id="bsname"><?= $resident['bsname']?></span> in the sector of
        <span contenteditable="true" id="bsindustry"><?= $resident['bsindustry'] ?></span>. With an area of
        <span contenteditable="true" id="aoe"><?= $resident['aoe'] ?></span>sqm.
    </p>

    <br><br>

    <p>
        Signed this date <?= $resident['date'] ?> at Barangay Sinalhan, Santa Rosa City, Laguna.
    </p>

  

    <br>

    <img src="" alt="Insert Signature Image here.">
    <p>HON. LADISLAO B. ALICBUSAN</p>
    <p>Punong Barangay</p>      




    <?php if (empty($_GET['status'])) { ?>
        <button class="btn btn-primary noprint" id="printpagebutton" onclick="PrintElem('#clearance')">Print</button>
        <button class="noprint btn-update">Update</button>
    <?php } ?>
  
  </body>
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
                update_bspermit: true,
                lname: $('#lname').text().trim(),
                fname: $('#fname').text().trim(),
                mi: $('#mi').text().trim(),
                bsname: $('#bsname').text().trim(),
                bsindustry: $('#bsindustry').text().trim(),
                bshouseno: $('#bshouseno').text().trim(),
                bsstreet: $('#bsstreet').text().trim(),
                bsbrgy: $('#bsbrgy').text().trim(),
                bsmunicipality: $('#bsmunicipality').text().trim(),
                aoe: $('#aoe').text().trim(),
                id_bspermit: $('#id_bspermit').text().trim()
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
    
    <script src="./js-components/component-js-popup.js"></script>
</html>