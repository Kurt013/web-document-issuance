<?php
    require('classes/staff.class.php');

    $user = $staffbmis->get_userdata();

    $staffbmis->validate_staff();


    $staffbmis->update_brgyid();
    $staffbmis->accept_brgyid();

    $resident = $staffbmis->get_single_brgyid();


  ?>
<!DOCTYPE html>
<html id="barangayid">
 <head>
 <meta charset="UTF-8">
    <title>Barangay ID Form</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    
    <link rel="icon" href="./assets/sinlogo.png" type="image/x-icon">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
    <style>
    @page { size: auto;  margin: 25.4mm; }

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

    body {
      -webkit-print-color-adjust:exact !important;
      print-color-adjust:exact !important;
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      display: flex;
      min-height: 100vh;
      justify-content: center;
      align-items: center;
      font-family: Arial, sans-serif;
    }

    .card {
      position: relative;
      background-color: #89cff0;
      overflow: hidden;
      height: 240px;
      width: 460px;
    }

    .front {
      position: relative;
      margin-bottom: 10px;
    } 

    .header {
      padding: 10px;
      background-color: #012049;
      font-family: Impact, sans-serif;
      color: white;
      position: relative;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 20px;
    }

    .header img {
      width: 50px;
      height: 50px;
    }

    .header p {
      margin: 0;
      text-align: center;
    }
    
    .sub-header {
      font-size: 12px;
    }

    .content {
      display: flex;
      padding: 10px;
      column-gap: 10px;
      align-items: center;
    }

    .content * {
      text-transform: capitalize;
      font-size: 12px;
      margin: 0;
      margin-bottom: 2px;
    }

    .retakeBtn {
      display: block;
    }   


    .right-side h1 {
      font-size: 14px;
      font-family: "PSemiBold";
    }


    .back {
      font-size: 14px;
      text-align: center;
    }


    </style>
</head>
 <body>
    <div class="brgyid">
      <div class="front card">
        <div class="header">
          <div><img class="left" src="./assets/sinlogo.png" alt=""></div>
          <div class="middle">
            <p class="sub-header">Republic of Philippines Province of Laguna City of Santa Rosa</p>
            <p>Barangay Sinalhan Identification Card</p>
          </div>
          <div><img class="right" src="./assets/sntrlogo.png" alt=""></div>
        </div>

        <div class="content">
          <div class="left-side">
            <?php $staffbmis->convertToImg($resident['res_photo']) ?>
            <button class="noprint retakeBtn" onclick="changePic('camera.php?id_brgyid=<?= $resident['id_brgyid'] ?>');" > Retake Photo </button>
          </div>
          <div class="right-side">
            <p>
              <span contenteditable="true" id="fname"><?= $resident['fname'] ?></span>
              <span contenteditable="true" id="mi"><?= $resident['mi'] ?></span>
              <span contenteditable="true" id="lname"><?= $resident['lname'] ?></span>
            </p>
            <p>
              <span contenteditable="true" id="houseno"><?= $resident['houseno'] ?></span>
              <span contenteditable="true" id="street"><?= $resident['street'] ?></span>,
              <span id="brgy"><?= $resident['brgy'] ?></span>,
              <span id="city"><?= $resident['city'] ?></span>,
              <span id="municipality"><?= $resident['municipality'] ?></span>
            </p>
            <p id="id_brgyid"><?= $resident['id_brgyid'] ?></p>
            <p contenteditable="true" id="valid_date"><?= $resident['valid_date']?><p>
            <p contenteditable="true" id="status"><?= $resident['status']?><p>
            <p contenteditable="true" id="precint_no"><?= $resident['precint_no'] ?></p>
          </div>
        </div>
      </div>

      <div class="back card">
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
          <span contenteditable="true" id="inc_municipality"><?= $resident['inc_municipality'] ?></span>
        </p>
      </div>
      
      <button class="btn btn-primary noprint" id="printpagebutton" onclick="PrintElem('#clearance')">Print</button>
      <button class="noprint btn-update">Update</button>

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <script src="./js-components/component-js-openwindow.js"></script>

    </div>


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
                res_photo: $('#res_photo').attr('src'),
                id_brgyid: $('#id_brgyid').text(),
                fname: $('#fname').text(),
                mi: $('#mi').text(),
                lname: $('#lname').text(),
                houseno: $('#houseno').text(),
                street: $('#street').text(),
                brgy: $('#brgy').text(),
                city: $('#city').text(),
                municipality: $('#municipality').text(),
                bdate: $('#bdate').text(),
                status: $('#status').text(),
                precint_no: $('#precint_no').text(),
                inc_fname: $('#inc_fname').text(),
                inc_mi: $('#inc_mi').text(),
                inc_lname: $('#inc_lname').text(),
                inc_contact: $('#inc_contact').text(),
                inc_houseno: $('#inc_houseno').text(),
                inc_street: $('#inc_street').text(),
                inc_brgy: $('#inc_brgy').text(),
                inc_city: $('#inc_city').text(),
                inc_municipality: $('#inc_municipality').text()
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
    </body>
</html>