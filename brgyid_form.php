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
      background-color:rgb(179, 227, 255);
      overflow: hidden;
      height: 240px;
      width: 460px;
    }

    .front {
      position: relative;
      margin-bottom: 10px;

    } 

    .header {
      font-family: "Impact";
      color: white;
      position: relative;
      display: flex;
      justify-content: center;
      align-items: center;
      font-size: 20px;
      z-index: 1000;
    }

    span {
      text-transform: uppercase !important;

    }

    #fname, #lname, #suffix {
      font-size: 14px;
      font-family: "Arial";
    }

    .header::after {
      content: "";
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 100%;
      height: 60%;
      background-color: #0A3981;
      z-index: -1;
    }

    #res_photo {
      border: #0A3981 2px solid;
    }

    .header img {
      width: 70px;
      height: 70px;
    }

    .header p {
      margin: 0;
      text-align: center;
    }
    
    .sub-header {
      font-size: 11px;
    }

    .content {
      display: flex;
      padding-left: 10px;
      align-items: center;
    }

    .content * {
      text-transform: capitalize;
      font-size: 12px;
      margin: 0;
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


    .address-container > * {
      font-size: 10px;
    
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
            <button class="noprint retakeBtn" onclick="changePic('camera.php?id_brgyid=<?= $resident['id_brgyid'] ?>');" > Update Photo </button>
          </div>
          <div class="right-side" style="width: 100%">
            <p class="name-container" style="margin-bottom: 10px; display: flex; justify-content: center; letter-spacing: 1.5px; column-gap: 10px; height: 30px; background-color: #0A3981; color: white; align-items: center; width: 100%">
              <span contenteditable="true" id="fname"><?= $resident['fname'] ?></span>
              <span contenteditable="true" id="lname"><?= $resident['lname'] ?></span>
              <span contenteditable="true" id="suffix"><?= $resident['suffix'] ?></span>

            </p>
            <p class="address-container" style="display: flex; column-gap: 2px; justify-content: center; align-items: center; padding-bottom: 10px; ">
              <span contenteditable="true" id="houseno"><?= $resident['houseno'] ?></span>
              <span contenteditable="true" id="street"><?= $resident['street'] ?></span>,
              <span>BRGY SINALHAN, CSRL</span>
            </p >
            <div class="info-1" style="display: flex; column-gap: 20px; justify-content: center; align-items: center;">
              <div style="display: flex; align-items: center">ID NO: <p id="id_brgyid"><?= $resident['id_brgyid'] ?></p></div>
              <div style="display: flex; align-items: center">VALID UNTIL: <p contenteditable="true" id="valid_date"><?= $resident['valid_date']?><p></div>
            </div>
            <div class="info-2" style="padding-left: 10px; display: flex; justify-content: space-between; align-items: center; padding-right: 10px;">
              <div style="padding-top: 20px;">CIVIL STATUS:<p contenteditable="true" id="status"> <?= $resident['status']?><p></div>
              <div style="padding-top: 20px;">PRECINCT NO: <p contenteditable="true" id="precint_no"><?= $resident['precint_no'] ?></p></div>
            </div>
          </div>
        </div>
      </div>

      <div class="back card">
        <h1 style="display:flex; align-items: center; justify-content:center; font-family: 'Arial'; font-weight: bold; height: 40px; background-color:#0A3981; letter-spacing: 1px; color:white; font-size: 18px;">IN CASE OF EMERGENCY PLEASE NOTIFY</h1>
      
        <p style="background-color: rgb(255, 0, 0); color: white; height: 45px; display:flex; justify-content: center; align-items: center; font-size: 14px; font-family: 'Arial';column-gap: 10px;">
          <span contenteditable="true" id="inc_fname"><?= $resident['inc_fname'] ?></span> 
            <span contenteditable="true" id="inc_mi"><?= substr($resident['inc_mi'], 0, 1) ?></span>
          <span contenteditable="true" id="inc_lname"><?= $resident['inc_lname'] ?></span> /
          <span contenteditable="true" id="inc_contact"><?= $resident['inc_contact'] ?></span>
        </p>
        <h2>ADDRESS</h2>
        <p style="font-size: 11px !important;">
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
                suffix: $('#suffix').text(),
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