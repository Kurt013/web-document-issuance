<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class BMISClass {

//------------------------------------------ DATABASE CONNECTION ----------------------------------------------------
    
    protected $server = "mysql:host=localhost;dbname=bmis";
    protected $user = "root";
    protected $pass = "";
    protected $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);
    protected $con;


    public function show_404()
    {
        http_response_code(404);
        echo "Page is currently unavailable";
        die;
    }

    public function openConn() {
        try {
            $this->con = new PDO($this->server, $this->user, $this->pass, $this->options);
            return $this->con;
        }

        catch(PDOException $e) {
            echo "Datbase Connection Error! ", $e->getMessage();
        }
    }

    //eto yung nag c close ng connection ng db
    public function closeConn() {
        $this->con = null;
    }


    //------------------------------------------ AUTHENTICATION & SESSION HANDLING --------------------------------------------
        public function login() {

            // $password = password_hash('admin', PASSWORD_DEFAULT);
            // $connection = $this->openConn();
            // $stmt = $connection->prepare("UPDATE tbl_user SET password = ? WHERE id_user = 1");

            // $stmt->execute([$password]);

            if (isset($_POST['login'])) {
                $username = $_POST['username'];
                $password = $_POST['password']; // Keep the raw password input
                
                $connection = $this->openConn();
                $stmt = $connection->prepare("SELECT * FROM tbl_user WHERE username = ?");
                $stmt->execute([$username]);
                $user = $stmt->fetch();
        
                // Check if user exists and verify the password
                if ($user && password_verify($password, $user['password'])) {
                    if ($user['role'] == 'administrator') {
                        $this->set_userdata($user);
                        header('Location: admn_dashboard.php');
                        exit;
                    } elseif ($user['role'] == 'staff') {
                        $this->set_userdata($user);
                        header('Location: staff_dashboard.php');
                        exit;
                    } else {
                        $message = "You are not authorized personnel!";
                        echo "<script type='text/javascript'>alert('$message');</script>";
                    }
                } else {
                    $message = "Invalid username or password!";
                    echo "<script type='text/javascript'>alert('$message');</script>";
                }
            }
        }
        

    public function logout(){
        if(!isset($_SESSION)) {
            session_start();
        }
        $_SESSION['userdata'] = null;
        unset($_SESSION['userdata']); 
        
    }

    public function get_userdata(){
    
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        return isset($_SESSION['userdata']) ? $_SESSION['userdata'] : null;
    }

    public function set_userdata($array = []) {

        if(!isset($_SESSION)) {
            session_start();
        }
    
        $_SESSION['userdata'] = array(
            "id" => isset($array['id_user']) ? $array['id_user'] : uniqid('guest_', true),
            "email" => isset($array['email']) ? $array['email'] : '',
            "role" => isset($array['role']) ? $array['role'] : 'guest',
            "firstname" => isset($array['fname']) ? $array['fname'] : '',
            "surname" => isset($array['lname']) ? $array['lname'] : '',
            "mname" => isset($array['mi']) ? $array['mi'] : ''
        );
    
        return $_SESSION['userdata'];
    }

 //----------------------------------------------------- ADMIN CRUD ---------------------------------------------------------
    public function create_admin() {

        if(isset($_POST['add_admin'])) {
        
            $email = $_POST['email'];
            $password = md5($_POST['password']);
            $lname = $_POST['lname'];
            $fname = $_POST['fname'];
            $mi = $_POST['mi'];
            $role = $_POST['role'];
    
                if ($this->check_admin($email) == 0 ) {
        
                    $connection = $this->openConn();
                    $stmt = $connection->prepare("INSERT INTO tbl_admin (`email`,`password`,`lname`,`fname`,
                    `mi`, `role` ) VALUES (?, ?, ?, ?, ?, ?)");
                    
                    $stmt->Execute([$email, $password, $lname, $fname, $mi, $role]);
                    
                    $message2 = "Administrator account added, you can now continue logging in";
                    echo "<script type='text/javascript'>alert('$message2');</script>";
                }
            }
    
            else {
                echo "<script type='text/javascript'>alert('Account already exists');</script>";
            }
    }

    public function get_single_admin($id_admin){

        $id_admin = $_GET['id_admin'];
        
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_admin where id_admin = ?");
        $stmt->execute([$id_admin]);
        $admin = $stmt->fetch();
        $total = $stmt->rowCount();

        if($total > 0 )  {
            return $admin;
        }
        else{
            return false;
        }
    }

    public function admin_changepass() {
        $id_admin = $_GET['id_admin'];
        $oldpassword = ($_POST['oldpassword']);
        $oldpasswordverify = ($_POST['oldpasswordverify']);
        $newpassword = ($_POST['newpassword']);
        $checkpassword = $_POST['checkpassword'];

        if(isset($_POST['admin_changepass'])) {

            $connection = $this->openConn();
            $stmt = $connection->prepare("SELECT `password` FROM tbl_admin WHERE id_admin = ?");
            $stmt->execute([$id_admin]);
            $result = $stmt->fetch();

            if($result == 0) {
                
                echo "Old Password is Incorrect";
            }

            elseif ($oldpassword != $oldpasswordverify) {
            }

            elseif ($newpassword != $checkpassword){
                echo "New Password and Verification Password does not Match";
            }

            else {
                $connection = $this->openConn();
                $stmt = $connection->prepare("UPDATE tbl_admin SET password =? WHERE id_admin = ?");
                $stmt->execute([$newpassword, $id_admin]);
                
                $message2 = "Password Updated";
                echo "<script type='text/javascript'>alert('$message2');</script>";
                header("refresh: 0");
            }


        }
    }



 //  ----------------------------------------------- ANNOUNCEMENT CRUD ---------------------------------------------------------


    public function create_announcement() {
        if(isset($_POST['create_announce'])) {
            $event = $_POST['event'];
            $created_by = $_POST['created_by'];

            $connection = $this->openConn();
            $stmt = $connection->prepare("INSERT INTO tbl_announcement (`event`, `created_by`)
                VALUES (?, ?)");
            $stmt->execute([$event, $created_by]);

            $message2 = "Announcement Added";
            echo "<script type='text/javascript'>alert('$message2');</script>";
            header('refresh:0');
        }
    }

    public function view_announcement(){
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT u.lname, u.fname, u.mi, a.event, date(a.created_on) AS created_date, a.id_announcement from tbl_user AS
            u JOIN tbl_announcement AS a ON u.id_user = a.created_by");
        $stmt->execute();
        $view = $stmt->fetchAll();
        $row = $stmt->rowCount();

        if ($row > 0)
            return $view;
        else
            return false;
    }

    // public function update_announcement() {
    //     if (isset($_POST['update_announce'])) {
    //         $id_announcement = $_GET['id_announcement'];
    //         $event = $_POST['event'];
    //         $start_date = $_POST['start_date'];
    //         $end_date = $_POST['end_date'];
    //         $addedby = $_POST['addedby'];

    //         $connection = $this->openConn();
    //         $stmt = $connection->prepare("UPDATE tbl_announcement SET event =?, start_date =?, 
    //         end_date = ?, addedby =? WHERE id_announcement = ?");
    //         $stmt->execute([ $event, $start_date, $end_date, $addedby, $id_announcement]);
               
    //         $message2 = "Announcement Updated";
    //         echo "<script type='text/javascript'>alert('$message2');</script>";
    //          header("refresh: 0");
    //     }

    //     else {
    //     }
    // }

    public function delete_announcement(){
        if(isset($_POST['delete_announcement'])) {
            $id_announcement = $_POST['id_announcement'];

            $connection = $this->openConn();
            $stmt = $connection->prepare("DELETE FROM tbl_announcement where id_announcement = ?");
            $stmt->execute([$id_announcement]);

            header("Refresh:0");
        }
    }

    public function count_announcement() {
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT COUNT(*) from tbl_announcement");
        $stmt->execute();
        $ancount = $stmt->fetchColumn();
        return $ancount;
    }

    //------------------------------------------ Certificate of Residency CRUD -----------------------------------------------
    public function get_single_certofres($id_rescert){        
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT 
            id_rescert,
            fname,
            mi,
            lname,
            age,
            houseno,
            street,
            brgy,
            city,
            municipality,
            purpose,
            created_by,
            DATE_FORMAT(STR_TO_DATE(created_on, '%Y-%m-%d'), '%b. %d, %Y') AS `date` 
            FROM tbl_rescert 
            WHERE id_rescert = ?");
        $stmt->execute([$id_rescert]);
        $rescert = $stmt->fetch();
        $total = $stmt->rowCount();

        if($total > 0 )  {
            return $rescert;
        } else {
            return false;
        }
    }

    public function get_latest_certofres($id) {
        $connection = $this->openConn();
        $stmt = $connection->prepare('
            SELECT id_rescert FROM tbl_rescert WHERE created_by = ? ORDER BY created_on DESC LIMIT 1
        ');
        $stmt->execute([$id]);

        $latestRecord = $stmt->fetch();
        return $latestRecord;
    }

    public function create_certofres() {
        if (isset($_POST['create_certofres'])) {
            // Gather the form data
            $lname = $_POST['lname'];
            $fname = $_POST['fname'];
            $mi = $_POST['mi'];
            $age = $_POST['age'];
            $houseno = $_POST['houseno'];
            $street = $_POST['street'];
            $brgy = $_POST['brgy'];
            $city = $_POST['city'];
            $municipality = $_POST['municipality'];
            $purpose = $_POST['purpose'];
            $created_by = $_POST['created_by'];
            
            // Check if "Other" was selected and handle custom purpose
            if ($purpose === "Other" && !empty($_POST['custom_purpose'])) {
                $purpose = $_POST['custom_purpose'];
            }
        
            $connection = $this->openConn();
            
            // Insert new data
            $stmt = $connection->prepare('
                INSERT INTO tbl_rescert(fname, mi, lname, age, houseno, street, brgy, city, municipality, purpose, created_by)
                 VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ');
            
            $stmt->execute([
                $fname, 
                $mi,
                $lname,
                $age,
                $houseno,
                $street,
                $brgy,
                $city,
                $municipality,
                $purpose,
                $created_by
            ]);

            // Get the latest requested docu by the user and store it in qr code

            $residentId = $this->get_latest_certofres($created_by);
            
            $qrCode = $this->generateQRCode($residentId['id_rescert'], 'rescert');

            echo '<script>alert("QR Code Successfully Generated!")</script>
            <h1>Here is your generated qr code go to the brgy.hall to get your document!"</h1>
            <img src="'.$qrCode.'" alt="QR Code" />';
        }
    }

    

    public function insert_certofres($user) {
        $connection = $this->openConn();
        $stmt = $connection->prepare("INSERT INTO tbl_rescert (lname, fname, mi, age, houseno, street, purpose, created_by, doc_status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->execute([
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            $user['firstname'] . '_' . $user['surname'],
            'temporary'
        ]);
        
        $stmt = $connection->prepare("SELECT id_rescert FROM tbl_rescert WHERE created_by = ? ORDER BY created_on DESC LIMIT 1");

        $stmt->execute([$user['firstname'] . '_' . $user['surname']]);
        $resident_id = $stmt->fetch();

        return './rescert_form.php?id_rescert='.$resident_id['id_rescert'];
    }
    
    

    public function view_certofres(){
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * from tbl_rescert");
        $stmt->execute();
        $view = $stmt->fetchAll();
        return $view;
    }

    public function delete_certofres(){
        if(isset($_POST['delete_certofres'])) {
            $id_rescert = $_POST['id_rescert'];

            $connection = $this->openConn();
            $stmt = $connection->prepare("DELETE FROM tbl_rescert where id_rescert = ?");
            $stmt->execute([$id_rescert]);

            header("Refresh:0");
        }
    }

    public function update_certofres() {
        if (isset($_POST['update_rescert'])) {  // Checks if update was triggered
            $connection = $this->openConn();
    
            try {                
                $id_rescert = $_POST['id_rescert'];
                $lname = $_POST['lname'];
                $fname = $_POST['fname'];
                $mi = $_POST['mi'];
                $age = $_POST['age'];
                $houseno = $_POST['houseno'];
                $street = $_POST['street'];
                $brgy = $_POST['brgy'];
                $city = $_POST['city'];
                $municipality = $_POST['municipality'];
                $purpose = $_POST['purpose'];
                $doc_status = 'pending';

                $stmt = $connection->prepare("UPDATE tbl_rescert SET 
                    lname = ?,
                    fname = ?,
                    mi = ?,
                    age = ?,
                    houseno = ?,
                    street = ?,
                    brgy = ?,
                    city = ?,
                    municipality = ?,
                    purpose = ?,
                    doc_status = ?
                    WHERE
                    id_rescert = ?
                ");

                $stmt->execute([
                    $lname,
                    $fname,
                    $mi,
                    $age,
                    $houseno,
                    $street,
                    $brgy,
                    $city,
                    $municipality,
                    $purpose,
                    $doc_status,
                    $id_rescert
                ]);
            }
            catch (PDOException $e) {
                echo "<script>alert('Failed to update records: " . $e->getMessage() . "')</script>";
                exit;
            }
        }
    }


    public function archive_certofres() {
        if (isset($_POST['archive_certofres'])) {
            $id_rescert = $_POST['id_rescert'];
            $connection = $this->openConn();
        
            try {
                // Begin transaction
                $connection->beginTransaction();
        
                // Step 1: Insert into archive table
                $insertStmt = $connection->prepare("
                    INSERT INTO tbl_archive_rescert (id_rescert, fname, mi, lname, age, houseno, street, brgy, city, municipality, purpose, created_on, created_by)
                    SELECT id_rescert, fname, mi, lname, age, houseno, street, brgy, city, municipality, purpose, created_on, created_by
                    FROM tbl_rescert
                    WHERE id_rescert = :id_rescert
                ");
                $insertStmt->bindParam(':id_rescert', $id_rescert);
                $insertStmt->execute();
        
                // Step 2: Delete from original table
                $deleteStmt = $connection->prepare("
                    DELETE FROM tbl_rescert
                    WHERE id_rescert = :id_rescert
                ");
                $deleteStmt->bindParam(':id_rescert', $id_rescert);
                $deleteStmt->execute();
        
                // Commit transaction
                $connection->commit();

                echo "<script>alert('Archived Successfully');</script>";
        
            } catch (Exception $e) {
                // Rollback if there is an error
                $connection->rollBack();
                echo "Failed to archive record: " . $e->getMessage();
            }
        }
    }
    
    
 
     //------------------------------------------ CERT OF INIDIGENCY CRUD -----------------------------------------------

     public function create_certofindigency() {

        if(isset($_POST['create_certofindigency'])) {
                // Gather the form data
                $lname = $_POST['lname'];
                $fname = $_POST['fname'];
                $mi = $_POST['mi'];
                $age = $_POST['age'];
                $nationality = $_POST['nationality'];
                $houseno = $_POST['houseno'];
                $street = $_POST['street'];
                $brgy = $_POST['brgy'];
                $city = $_POST['city'];
                $municipality = $_POST['municipality'];
                $purpose = $_POST['purpose'];
                $doc_type = 'indigency';
                
                // Check if "Other" was selected and handle custom purpose
                if ($purpose === "Other" && !empty($_POST['custom_purpose'])) {
                    $purpose = $_POST['custom_purpose'];
                }
            
                // Create the data array
                $data = [
                    'lname' => $lname,
                    'fname' => $fname,
                    'mi' => $mi,
                    'age' => $age,
                    'nationality' => $nationality,
                    'houseno' => $houseno,
                    'street' => $street,
                    'brgy' => $brgy,
                    'city' => $city,
                    'municipality' => $municipality,
                    'purpose' => $purpose,
                    'doc_type' => $doc_type
                ];
            
                // Convert data to JSON
                $json_data = json_encode($data);
                
                $qrCode = $this->generateQRCode($json_data);
    
                echo '<script>alert("QR Code Successfully Generated!")</script>
                <h1>Here is your generated qr code go to the brgy.hall to get your document!"</h1>
                <img src="'.$qrCode.'" alt="QR Code" />';
        }
        
        
    }

    public function view_certofindigency(){
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * from tbl_indigency");
        $stmt->execute();
        $view = $stmt->fetchAll();
        return $view;
    }


    public function delete_certofindigency(){
        $id_indigency = $_POST['id_indigency'];

        if(isset($_POST['delete_certofindigency'])) {
            $connection = $this->openConn();
            $stmt = $connection->prepare("DELETE FROM tbl_indigency where id_indigency = ?");
            $stmt->execute([$id_indigency]);

            header("Refresh:0");
        }
    }


    public function update_certofindigency() {
        if (isset($_POST['update_indigency'])) {  // Checks if update was triggered
            $connection = $this->openConn();
    
            try {
                $id_resident = $_GET['id_resident'];
                // Retrieving data from POST request
                $lname = $_POST['lname'];
                $fname = $_POST['fname'];
                $mi = $_POST['mi'];
                $age = $_POST['age'];
                $nationality = $_POST['nationality'];
                $houseno = $_POST['houseno'];
                $street = $_POST['street'];
                $brgy = $_POST['brgy'];
                $city = $_POST['city'];
                $municipal = $_POST['municipal'];
                $purpose = $_POST['purpose'];

                $connection->beginTransaction();
        
                $stmt = $connection->prepare("UPDATE tbl_resident SET 
                        lname = ?, fname = ?, mi = ?, age = ?, 
                        nationality = ?, houseno = ?, street = ?, 
                        brgy = ?, city = ?, municipal = ?
                        WHERE id_resident = ?");
        
                // Attempt to execute the query
                $stmt->execute([$lname, $fname, $mi, $age, $nationality, $houseno, 
                    $street, $brgy, $city, $municipal, $id_resident]);

                $stmt = $connection->prepare("UPDATE tbl_indigency SET purpose = ? WHERE id_resident = ?");
        
                // Attempt to execute the query
                $stmt->execute([$purpose, $id_resident]);

                $connection->commit();
            }
            catch (PDOException $e) {
                $connection->rollBack();
                echo "<script>alert('Failed to update records: " . $e->getMessage() . "')</script>";
                exit;
            }
        }
    }

    public function archive_certofindigency() {
        $id_indigency = $_POST['id_indigency'];
        $id_resident = $_POST['id_resident'];

        if (isset($_POST['archive_certofindigency'])) {
            try {
                $connection = $this->openConn();

                $connection->beginTransaction();

                $stmt = $connection->prepare("
                    SELECT
                        r.*, c.*
                    FROM
                        tbl_resident AS r
                    JOIN
                        tbl_indigency AS c ON r.id_resident = c.id_resident
                    WHERE
                        c.id_indigency = ? AND r.id_resident = ?
                ");
                $stmt->execute([$id_indigency, $id_resident]);

                $view = $stmt->fetch();

                $stmt1 = $connection->prepare("
                    INSERT INTO tbl_archive_indigency(id_indigency, lname, fname, mi, age, houseno,
                        street, brgy, city, municipal, purpose) VALUES (?, ?, ?, ?, ?, ?,
                        ?, ?, ?, ?, ?)
                ");

                $stmt1->execute([$view['id_indigency'], $view['lname'], $view['fname'], $view['mi'], $view['age'], 
                    $view['houseno'], $view['street'], $view['brgy'], $view['city'], $view['municipal'], 
                    $view['purpose']]);
                
                $stmt2 = $connection->prepare("DELETE FROM tbl_indigency where id_indigency = ?");
                $stmt2->execute([$id_indigency]);

                $connection->commit();

                echo "<script>alert(" . json_encode('Record archived successfully.') . ");</script>";
            } catch (PDOException $e) {
                $connection->rollBack();
                echo "<script>alert('Failed to update records: " . $e->getMessage() . "')</script>";
                exit;
            }
        }
    }
    

    public function get_single_certofindigency($id_indigency){
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_indigency WHERE id_indigency = ?");
        $stmt->execute([$id_indigency]);
        $indigency = $stmt->fetch();
        $total = $stmt->rowCount();

        if($total > 0 )  {
            return $indigency;
        } else {
            return false;
        }
    }


     //------------------------------------------ BRGY CLEARANCE CRUD -----------------------------------------------

     public function get_single_clearance($id_clearance){
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_clearance WHERE id_clearance = ?");
        $stmt->execute([$id_clearance]);
        $clearance = $stmt->fetch();
        $total = $stmt->rowCount();

        if($total > 0 )  {
            return $clearance;
        } else {
            return false;
        }
    }


     public function create_brgyclearance() {
        if(isset($_POST['create_brgyclearance'])) {
            // Gather the form data
            $lname = $_POST['lname'];
            $fname = $_POST['fname'];
            $mi = $_POST['mi'];
            $age = $_POST['age'];
            $houseno = $_POST['houseno'];
            $street = $_POST['street'];
            $brgy = $_POST['brgy'];
            $city = $_POST['city'];
            $municipality = $_POST['municipality'];
            $purpose = $_POST['purpose'];
            $doc_type = 'clearance';
            
            // Check if "Other" was selected and handle custom purpose
            if ($purpose === "Other" && !empty($_POST['custom_purpose'])) {
                $purpose = $_POST['custom_purpose'];
            }
        
            // Create the data array
            $data = [
                'lname' => $lname,
                'fname' => $fname,
                'mi' => $mi,
                'age' => $age,
                'houseno' => $houseno,
                'street' => $street,
                'brgy' => $brgy,
                'city' => $city,
                'municipality' => $municipality,
                'purpose' => $purpose,
                'doc_type' => $doc_type
            ];
        
            // Convert data to JSON
            $json_data = json_encode($data);
            
            $qrCode = $this->generateQRCode($json_data);

            echo '<script>alert("QR Code Successfully Generated!")</script>
            <h1>Here is your generated qr code go to the brgy.hall to get your document!"</h1>
            <img src="'.$qrCode.'" alt="QR Code" />';
        }
        
    }


    public function view_clearance(){
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * from tbl_clearance");
        $stmt->execute();
        $view = $stmt->fetchAll();
        return $view;
    }


    public function delete_clearance(){
        $id_clearance = $_POST['id_clearance'];

        if(isset($_POST['delete_clearance'])) {
            $connection = $this->openConn();
            $stmt = $connection->prepare("DELETE FROM tbl_clearance where id_clearance = ?");
            $stmt->execute([$id_clearance]);

            header("Refresh:0");
        }
    }

    public function update_clearance() {
        if (isset($_POST['update_clearance'])) {  // Checks if update was triggered
          $connection = $this->openConn();
  
          try {
              $id_resident = $_GET['id_resident'];
              
              // Retrieving data from POST request
              $lname = $_POST['lname'];
              $fname = $_POST['fname'];
              $mi = $_POST['mi'];
              $age = $_POST['age'];
              $houseno = $_POST['houseno'];
              $street = $_POST['street'];
              $brgy = $_POST['brgy'];
              $city = $_POST['city'];
              $municipal = $_POST['municipal'];
              $purpose = $_POST['purpose'];

              $connection->beginTransaction();
      
              $stmt = $connection->prepare("UPDATE tbl_resident SET 
                      lname = ?, fname = ?, mi = ?, age = ?,
                      houseno = ?, street = ?, 
                      brgy = ?, city = ?, municipal = ?
                      WHERE id_resident = ?");
      
              // Attempt to execute the query
              $stmt->execute([$lname, $fname, $mi, $age, $houseno, 
                  $street, $brgy, $city, $municipal, $id_resident]);

              $stmt = $connection->prepare("UPDATE tbl_clearance SET purpose = ? WHERE id_resident = ?");
      
              // Attempt to execute the query
              $stmt->execute([$purpose, $id_resident]);

              $connection->commit();
          }
          catch (PDOException $e) {
              $connection->rollBack();
              echo "<script>alert('Failed to update records: " . $e->getMessage() . "')</script>";
              exit;
          }
      }
  }

  public function archive_clearance() {
    $id_clearance = $_POST['id_clearance'];
    $id_resident = $_POST['id_resident'];

    if (isset($_POST['archive_clearance'])) {
        try {
            $connection = $this->openConn();

            $connection->beginTransaction();

            $stmt = $connection->prepare("
                SELECT
                    r.*, c.*
                FROM
                    tbl_resident AS r
                JOIN
                    tbl_clearance AS c ON r.id_resident = c.id_resident
                WHERE
                    c.id_clearance = ? AND r.id_resident = ?
            ");
            $stmt->execute([$id_clearance, $id_resident]);

            $view = $stmt->fetch();

            $stmt1 = $connection->prepare("
                INSERT INTO tbl_archive_clearance(id_clearance, lname, fname, mi, age, houseno,
                    street, brgy, city, municipal, status, purpose) VALUES (?, ?, ?, ?, ?, ?, ?,
                    ?, ?, ?, ?, ?)
            ");

            $stmt1->execute([$view['id_clearance'], $view['lname'], $view['fname'], $view['mi'], $view['age'], 
                $view['houseno'], $view['street'], $view['brgy'], $view['city'], $view['municipal'], $view['status'],
                $view['purpose']]);
            
            $stmt2 = $connection->prepare("DELETE FROM tbl_clearance where id_clearance = ?");
            $stmt2->execute([$id_clearance]);

            $connection->commit();

            echo "<script>alert(" . json_encode('Record archived successfully.') . ");</script>";
        } catch (PDOException $e) {
            $connection->rollBack();
            echo "<script>alert('Failed to update records: " . $e->getMessage() . "')</script>";
            exit;
        }
    }
}


  //------------------------------------------ Business Permit CRUD -----------------------------------------------

    public function create_bspermit() {
        if(isset($_POST['create_bspermit'])) {
            $lname = $_POST['lname'];
            $fname = $_POST['fname'];
            $mi = $_POST['mi'];
            $bshouseno = $_POST['bshouseno'];
            $bsstreet = $_POST['bsstreet'];
            $bsbrgy = $_POST['bsbrgy'];
            $bscity = $_POST['bscity'];
            $bsmunicipality = $_POST['bsmunicipality'];
            $bsindustry = $_POST['bsindustry'];
            $bsname = $_POST['bsname'];
            $aoe = $_POST['aoe'];
            $doc_type = 'bspermit';

            // Check if "Other" was selected and handle custom purpose
            if ($bsindustry === "Other" && !empty($_POST['custom_purpose'])) {
                $bsindustry = $_POST['custom_purpose'];
            }
            // Create the data array
            $data = [
                'lname' => $lname,
                'fname' => $fname,
                'mi' => $mi,
                'bshouseno' => $bshouseno,
                'bsstreet' => $bsstreet,
                'bsbrgy' => $bsbrgy,
                'bscity' => $bscity,
                'bsmunicipality' => $bsmunicipality,
                'bsindustry' => $bsindustry,
                'bsname' => $bsname,
                'aoe' => $aoe,
                'doc_type' => $doc_type
            ];
        
            // Convert data to JSON
            $json_data = json_encode($data);
            
            $qrCode = $this->generateQRCode($json_data);

            echo '<script>alert("QR Code Successfully Generated!")</script>
            <h1>Here is your generated qr code go to the brgy.hall to get your document!"</h1>
            <img src="'.$qrCode.'" alt="QR Code" />';
        
        }  
    }

    public function get_single_bspermit($id_bspermit){
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_bspermit WHERE id_bspermit = ?");
        $stmt->execute([$id_bspermit]);
        $bspermit = $stmt->fetch();
        $total = $stmt->rowCount();

        if($total > 0 )  {
            return $bspermit;
        } else {
            return false;
        }
    }


    public function view_bspermit(){
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * from tbl_bspermit");
        $stmt->execute();
        $view = $stmt->fetchAll();
        return $view;
    }


    public function delete_bspermit(){
        if(isset($_POST['delete_bspermit'])) {
            $id_bspermit = $_POST['id_bspermit'];

            $connection = $this->openConn();
            $stmt = $connection->prepare("DELETE FROM tbl_bspermit where id_bspermit = ?");
            $stmt->execute([$id_bspermit]);

            header("Refresh:0");
        }
    }

    public function update_bspermit() {
        if (isset($_POST['update_bspermit'])) {
            $id_bspermit = $_POST['id_bspermit'];
            // $lname = $_POST['lname'];
            $fname = $_POST['fname'];
            // $mi = $_POST['mi'];
            // $bsname = $_POST['bsname']; 
            // $bshouseno = $_POST['bshouseno'];
            // $bsstreet = $_POST['bsstreet'];
            // $bsbrgy = $_POST['bsbrgy'];
            // $bscity = $_POST['bscity'];
            // $bsmunicipal = $_POST['bsmunicipal'];
            // $bsindustry = $_POST['bsindustry'];
            // $aoe = $_POST['aoe'];

            $connection = $this->openConn();

            try {
                $connection->beginTransaction();

                $stmt->execute([$fname, $id_bspermit]);

                // $stmt = $connection->prepare("UPDATE tbl_bspermit SET bshouseno = ?, bsstreet = ?, bsbrgy = ?, bscity = ?, bsmunicipal = ?, bsindustry = ?, bsname = ?, aoe = ? WHERE id_bspermit = ?");

                // $stmt->execute([$bshouseno, $bsstreet, $bsbrgy, $bscity, $bsmunicipal, $bsindustry, $bsname, $aoe, $id_bspermit]);

                $connection->commit();

                $message2 = "Application Applied, you will receive our text message for further details";
                echo "<script type='text/javascript'>alert('$message2');</script>";
                header("refresh: 0");
            }
            catch (PDOException $e) {
                $connection->rollBack();
                echo "Failed to update records: " . $e->getMessage();
            }
        }
    }


  //------------------------------------------ BRGY ID CRUD -----------------------------------------------



    public function create_brgyid() {

        if(isset($_POST['create_brgyid'])) {
            $lname = $_POST['lname'];
            $fname = $_POST['fname'];
            $mi = $_POST['mi']; 
            $houseno = $_POST['houseno'];
            $street = $_POST['street'];
            $brgy = $_POST['brgy'];
            $city = $_POST['city'];
            $municipality = $_POST['municipality'];
            $bdate = $_POST['bdate'];
            $res_photo = file_get_contents($_FILES['res_photo']['tmp_name']);
            $inc_lname = $_POST['inc_lname']; 
            $inc_fname = $_POST['inc_fname'];
            $inc_mi = $_POST['inc_mi'];
            $inc_contact = $_POST['inc_contact'];
            $inc_houseno = $_POST['inc_houseno'];
            $inc_street = $_POST['inc_street'];
            $inc_brgy = $_POST['inc_brgy'];
            $inc_city = $_POST['inc_city'];
            $inc_municipality = $_POST['inc_municipality'];
            $doc_type = 'brgyid';

            // Upload the image to ImgBB using the API
            $imageBase64 = base64_encode($res_photo);

            $tempLink = $this->set_temp_link($imageBase64);

            $data = [
                'lname' => $lname,
                'fname' => $fname,
                'mi' => $mi,
                'bdate' => $bdate,
                'houseno' => $houseno,
                'street' => $street,
                'brgy' => $brgy,
                'city' => $city,
                'municipality' => $municipality,
                'inc_lname' => $inc_lname,
                'inc_fname' => $inc_fname,
                'inc_mi' => $inc_mi,
                'inc_contact' => $inc_contact,
                'inc_houseno' => $inc_houseno,
                'inc_street' => $inc_street,
                'inc_brgy' => $inc_brgy,
                'inc_city' => $inc_city,
                'inc_municipality' => $inc_municipality,
                'res_photo' => $tempLink,
                'doc_type' => $doc_type
            ];
        
            // Convert data to JSON
            $json_data = json_encode($data);
            
            $qrCode = $this->generateQRCode($json_data);

            echo '<script>alert("QR Code Successfully Generated!")</script>
            <h1>Here is your generated qr code go to the brgy.hall to get your document!"</h1>
            <img src="'.$qrCode.'" alt="QR Code" />';
        
        }  
    }

    public function set_temp_link($image) {
        $url = 'https://api.imgbb.com/1/upload';
        $api_key = 'e4e5d492a7e93b32274f3280e4df7784';
        $expiration = 86400;

        $postFields = [
            'key' => $api_key,
            'image' => $image,
            'expiration' => $expiration
        ];

         // Initialize cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute the request
        $response = curl_exec($ch);
        curl_close($ch);

        // Decode the JSON response
        $responseData = json_decode($response, true);

        if (isset($responseData['data']['url'])) {
            // Return the temporary URL of the uploaded image
            return [
                'url' => $responseData['data']['url'],
                'delete_hash' => $responseData['data']['delete_hash']
            ];
        } else {
            // Handle errors (if any)
            throw new Exception('Image upload failed: ' . $responseData['error']['message']);
        }
    }

    public function get_single_brgyid($id_brgyid){
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_brgyid WHERE id_brgyid = ?");
        $stmt->execute([$id_brgyid]);
        $brgyid = $stmt->fetch();
        $total = $stmt->rowCount();

        if($total > 0 )  {
            return $brgyid;
        } else {
            return false;
        }
    }


    public function view_brgyid(){
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * from tbl_brgyid");
        $stmt->execute();
        $view = $stmt->fetchAll();
        return $view;
    }


    public function delete_brgyid(){
        $id_brgyid = $_POST['id_brgyid'];

        if(isset($_POST['delete_brgyid'])) {
            $connection = $this->openConn();
            $stmt = $connection->prepare("DELETE FROM tbl_brgyid where id_brgyid = ?");
            $stmt->execute([$id_brgyid]);

            header("Refresh:0");
        }
    } 

    public function update_brgyid() {
        if (isset($_POST['update_brgyid'])) {  // Checks if update was triggered
            $connection = $this->openConn();
    
            try {
                $id_resident = $_GET['id_resident'];
                
                // Retrieving data from POST request
                $fname = $_POST['fname'];
                $mi = $_POST['mi'];
                $lname = $_POST['lname'];
                $houseno = $_POST['houseno'];
                $street = $_POST['street'];
                $brgy = $_POST['brgy'];
                $city = $_POST['city'];
                $status = $_POST['status'];
                
                $municipal = $_POST['municipal'];
                $valid_until = $_POST['valid_until'];
                $inc_fname = $_POST['inc_fname'];
                $inc_mi = $_POST['inc_mi'];
                $inc_lname = $_POST['inc_lname'];
                $inc_houseno = $_POST['inc_houseno'];
                $inc_street = $_POST['inc_street'];
                $inc_brgy = $_POST['inc_brgy'];
                $inc_city = $_POST['inc_city'];
                $inc_municipal = $_POST['inc_municipal'];

                $connection->beginTransaction();
        
                $stmt = $connection->prepare("UPDATE tbl_resident SET 
                        lname = ?, fname = ?, mi = ?, houseno = ?, street = ?, 
                        brgy = ?, city = ?, municipal = ?, `status` = ?, valid_until = ?
                        WHERE id_resident = ?");
        
                // Attempt to execute the query
                $stmt->execute([$lname, $fname, $mi, $houseno, 
                    $street, $brgy, $city, $municipal, $status, $valid_until, $id_resident]);

                $stmt = $connection->prepare("UPDATE tbl_rescert SET         
                    inc_lname = ?, inc_fname = ?, inc_mi = ?, inc_houseno = ?, inc_street = ?, 
                        inc_brgy = ?, inc_city = ?, inc_municipal = ?, `inc_status` = ?
                        WHERE id_resident = ?");
        
                // Attempt to execute the query
                $stmt->execute([$inc_lname, $inc_fname, $inc_mi, $inc_houseno, $inc_street,
                    $inc_brgy, $inc_city, $inc_municipal, $id_resident]);

                $connection->commit();
            }
            catch (PDOException $e) {
                $connection->rollBack();
                echo "<script>alert('Failed to update records: " . $e->getMessage() . "')</script>";
                exit;
            }
        }
    }

    public function update_brgyid_photo() {
        if (isset($_POST['update_resphoto'])) {
            $id_resident = $_GET['id_resident'];
            $res_photo = isset($_POST['res_photo'])? base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $_POST['res_photo'])) : null;           

            $connection = $this->openConn();
            $stmt = $connection->prepare('UPDATE tbl_brgyid SET res_photo = ? WHERE id_resident = ?');
            $stmt->execute([$res_photo, $id_resident]);
            
            echo "<script>window.location.href</script>";
        }
    }

 //  ----------------------------------------------- RESIDENT RECORDS CRUD ---------------------------------------------------------



    
    //------------------------------------------ EXTRA FUNCTIONS ----------------------------------------------

    public function check_admin($email) {

        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_admin WHERE email = ?");
        $stmt->Execute([$email]);
        $total = $stmt->rowCount(); 

        return $total;
    }

    //eto yung function na mag bibigay restriction sa mga admin pages
    public function validate_admin() {
        $userdetails = $this->get_userdata();
    
        // Check if user data is available and if the role is 'administrator'
        if ($userdetails && $userdetails['role'] === "administrator") {
            return $userdetails;
        } else {
            // Redirect to login page if user is not logged in or not an administrator
            header("Location: index.php");
            exit();
        }
    }
    
    public function validate_staff() {
        // Retrieve user details from session
        $userdetails = $this->get_userdata();
        
        // Check if user data is available
        if (!$userdetails) {
            // Redirect to login page if user is not logged in
            header("Location: index.php");
            exit();
        }
    
        // Check if the user role is either 'administrator' or 'user'
        if ($userdetails['role'] === "administrator") {
            return $userdetails;
        } else {
            // Show a 404 page if the user is neither an administrator nor a regular user
            $this->show_404();
            exit(); // Ensure no further code runs after showing 404
        }
    }
    

// ------------------------------------- ADDITIONAL FUNCTIONS --------------------------------------------------

    function generateQRCode($doc_id, $doc_type) {
        ob_start();
        $link = "./{$doc_type}_form.php?id_{$doc_type}={$doc_id}";
        QRcode::png($link, null, QR_ECLEVEL_L, 10);
        $qrImage = ob_get_clean();
            // Convert the image data to base64 encoding
        $base64Image = base64_encode($qrImage);
        
        // Return the data URI for embedding in an <img> tag
        return 'data:image/png;base64,' . $base64Image;
    }

    function sendEmailWithQRCode($qrImage, $id_resident) {
        $conn = $this->openConn();
            // Fetch the recipient email from the database based on recipient ID
        $query = "SELECT email FROM tbl_resident WHERE id_resident = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$id_resident]);

        // Check if email was found
        if ($row = $stmt->fetch()) {
            $recipientEmail = $row['email'];
        } else {
            echo "<script>alert('Error: No email found for this ID.')</script>";
            return; // Stop further execution if email is missing
        }


        $mail = new PHPMailer(true);
        try {
            // SMTP server configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.mailersend.net';  // Set your SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'MS_aEACuu@trial-0p7kx4xjwevl9yjr.mlsender.net'; // Your SMTP username
            $mail->Password = 'ZsOeSK3qqlPGnXj7'; // Your SMTP password or app password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
    
            // Email details
            $mail->setFrom('MS_aEACuu@trial-0p7kx4xjwevl9yjr.mlsender.net', 'Brgy. Sinalhan');
            $mail->addAddress($recipientEmail);
            $mail->isHTML(true);
            $mail->Subject = "Your QR Code";
    
            // Attach QR Code as an image
            $mail->Body = "Here is your QR code!";
            $mail->addStringAttachment($qrImage, 'qrcode.png', 'base64', 'image/png');
    
            $mail->send();
            echo "Email sent successfully.";
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    public function deleteTemporaryDocs() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitize and validate the table name
            $allowedTables = ['tbl_rescert', 'tbl_clearance', 'tbl_indigency', 'tbl_brgyid', 'tbl_bspermit'];  // List of allowed table names
            $tbl = $_POST['tbl'];
    
            if (!in_array($tbl, $allowedTables)) {
                die('Invalid table specified');
            }
    
            $connection = $this->openConn();
    
            // Prepare and execute the deletion statement
            $stmt = $connection->prepare('DELETE FROM tbl_rescert WHERE doc_status = ');
            $success = $stmt->execute(['temporary']);
    
            if ($success) {
                echo "Records successfully deleted.";
            } else {
                echo "Error: Unable to delete records.";
            }
        }
    }

    // -------------------------- DOCUMENTS EXTRA FUNCTIONS ----------------------

    public function count_rescert() {
        $connection = $this->openConn();

        $stmt = $connection->prepare("SELECT COUNT(*) from tbl_rescert");
        $stmt->execute();
        $rescertcount = $stmt->fetchColumn();

        return $rescertcount;
    }

    public function count_indigency() {
        $connection = $this->openConn();

        $stmt = $connection->prepare("SELECT COUNT(*) from tbl_indigency");
        $stmt->execute();
        $indigencycount = $stmt->fetchColumn();

        return $indigencycount;
    }

    public function count_clearance() {
        $connection = $this->openConn();

        $stmt = $connection->prepare("SELECT COUNT(*) from tbl_clearance");
        $stmt->execute();
        $clearancecount = $stmt->fetchColumn();

        return $clearancecount;
    }

    public function count_bspermit() {
        $connection = $this->openConn();

        $stmt = $connection->prepare("SELECT COUNT(*) from tbl_bspermit");
        $stmt->execute();
        $bspermitcount = $stmt->fetchColumn();

        return $bspermitcount;
    }

    public function count_brgyid() {
        $connection = $this->openConn();

        $stmt = $connection->prepare("SELECT COUNT(*) from tbl_brgyid");
        $stmt->execute();
        $brgyidcount = $stmt->fetchColumn();

        return $brgyidcount;
    }


    public function count_total_month() {
        $connection = $this->openConn();

        $stmt = $connection->prepare("
            SELECT * 
            FROM tbl_rescert
            WHERE 
                MONTH(booking_date) = ? AND YEAR(booking_date) = YEAR(CURDATE()) 
            ORDER BY booking_date DESC;
            ");
        $stmt->execute();
        $brgyidcount = $stmt->fetchColumn();

        return $brgyidcount;
    }
}
    

$bmis = new BMISClass(); //variable to call outside of its class

?>
