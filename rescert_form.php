<?php
    require('classes/staff.class.php');

    $user = $staffbmis->get_userdata();

    $staffbmis->validate_staff();

    $resident = $staffbmis->get_single_certofres();

    $staffbmis->update_certofres();
  ?>

<!DOCTYPE html>
<html id="rescert">
 <head>
    <meta charset="UTF-8">
    <title>Barangay Information System</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        @media print {
            .noprint {
            visibility: hidden;
            }
        }
        @page { size: auto;  margin: 4mm; }

        span {
            /* text-decoration: underline; */
            font-weight: bold;
            text-transform: uppercase;
        }

        .empty-field {
            display: inline-block;
            padding: 2px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
            color: black;
        }

        span[contenteditable="true"]:empty {
            display: inline-block;
            padding: 5px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
            color: #aaa;
        }

    </style>
</head>
 <body>
    <?php include './form_header.php' 
    ?>

<h1 style="text-transform: uppercase;">Certificate of Residency</h1>

    <p>ISSUANCE NO.: <u id="id_rescert"><?= !empty($resident['id_rescert']) ?$resident['id_rescert'] : 'N/A'?></u></p>
    <p>TO WHOM IT MAY CONCERN:</p>
    <p> This document hereby certifies that
        <span contenteditable="true" id="fname" class="<?= empty($resident['fname']) ? 'empty-field' : '' ?>">
            <?= !empty($resident['fname']) ? $resident['fname'] : '[Enter First Name]'; ?>
        </span>
        <span contenteditable="true" id="mi" class="<?= empty($resident['mi']) ? 'empty-field' : '' ?>">
            <?= !empty($resident['mi']) ? $resident['mi'] : '[Enter MI]'; ?>.
        </span>
        <span contenteditable="true" id="lname" class="<?= empty($resident['lname']) ? 'empty-field' : '' ?>">
            <?= !empty($resident['lname']) ? $resident['lname'] : '[Enter Last Name]'; ?>
        </span>, aged
        <span contenteditable="true" id="age" class="<?= empty($resident['age']) ? 'empty-field' : '' ?>">
            <?= !empty($resident['age']) ? $resident['age'] : '[Enter Age]'; ?>
        </span>, is officially recognized as a legitimate resident of
        <span contenteditable="true" id="houseno" class="<?= empty($resident['houseno']) ? 'empty-field' : '' ?>">
            <?= !empty($resident['houseno']) ? $resident['houseno'] : '[Enter House No]'; ?>
        </span> 
        <span contenteditable="true" id="street" class="<?= empty($resident['street']) ? 'empty-field' : '' ?>">
            <?= !empty($resident['street']) ? $resident['street'] : '[Enter Street]'; ?>
        </span>
        <span contenteditable="true" id="brgy" class="<?= empty($resident['brgy']) ? 'empty-field' : '' ?>">
            <?= $resident['brgy']; ?>
        </span> 
        <span contenteditable="true" id="city" class="<?= empty($resident['city']) ? 'empty-field' : '' ?>">
            <?= $resident['city']; ?>
        </span> 
        <span contenteditable="true" id="municipality" class="<?= empty($resident['municipality']) ? 'empty-field' : '' ?>">
            <?= $resident['municipality'] ?>
        </span>
        The said person is of good moral character and an active member of the community.
    .</p>

    <p>
        This certification is being issued upon the request of the above mentioned person for
        <span contenteditable="true" id="purpose" class="<?= empty($resident['purpose']) ? 'empty-field' : '' ?>">
            <?= !empty($resident['purpose']) ? $resident['purpose'] : '[Enter Purpose]'; ?>
        </span>.
    </p>

    <br><br>

    <p>
        Signed this date <?= !empty($resident['date']) ? $resident['date'] : 'Enter Date'; ?> at Barangay Sinalhan, Santa Rosa City, Laguna.
    </p>

    <br>

    <img src="" alt="Insert Signature Image here.">
    <p>HON. LADISLAO B. ALICBUSAN</p>
    <p>Punong Barangay</p>      

    <?php if (empty($_GET['status'])) { ?>
        <button class="btn btn-primary noprint" id="printpagebutton" onclick="PrintElem()">Print</button>
        <button class="noprint btn-update">Update</button>
    <?php } ?>

    <script>

         function PrintElem()
    {
        window.print();
    }

    function Popup(data) 
    {
        var mywindow = window.open('', 'my div', 'height=400,width=600');
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
                update_rescert: true,
                lname: $('#lname').text().trim(),
                fname: $('#fname').text().trim(),
                mi: $('#mi').text().trim(),
                age: $('#age').text().trim(),
                houseno: $('#houseno').text().trim(),
                street: $('#street').text().trim(),
                brgy: $('#brgy').text().trim(),
                city: $('#city').text().trim(),
                municipality: $('#municipality').text().trim(),
                purpose: $('#purpose').text().trim(),  // Using trim() to clean the text
                id_rescert: $('#id_rescert').text().trim()
            };

            $.ajax({
                type: "POST",
                url: window.location.href,
                data: data,
                success: function (response) {
                    alert("updated successfully!");
                    location.reload();
             },
                error: function () {
                    alert("An error occurred while updating.");
                }
            });
        });
    });
    </script>
    </body>
</html>