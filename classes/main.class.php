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

    // ---------------------------------------- ACCOUNT ---------------------------------------------------------

    public function update_account_profile() {
        if (isset($_POST['update_account_profile'])) {
            $id_user = $_POST['id'];
            $lname = $_POST['lname'];
            $fname = $_POST['fname'];
            $suffix = $_POST['suffix'];
            $mi = $_POST['mi'];
            $email = $_POST['email'];
            $contact = $_POST['contact'];
    
            $connection = $this->openConn();
    
            // Check if the email already exists in tbl_user but not for the current user
            $checkStmt = $connection->prepare("SELECT COUNT(*) FROM tbl_user WHERE email = ? AND id_user != ?");
            $checkStmt->execute([$email, $id_user]);
            $emailExists = $checkStmt->fetchColumn();
    
            if ($emailExists > 0) {
                $toast = '
                
                <div class="toast" style = "border-left: 6px solid #D32F2F;">
                    <div class="toast-content">
                        <i class="fas fa-exclamation-triangle check" style = "background-color: #D32F2F;"></i>
                        <div class="message">
                            <span class="text text-1">Wrong Credentials</span>
                            <span class="text text-2">Invalid username or password </span>
                        </div>
                    </div>
                    <i class="fa-solid fa-xmark close close-error"  onclick="closeToast()"></i>
                    <div class="progress progress-error"></div>
                </div>
           ';

            // Redirect to prevent form re-submission
            header("Location: account_crud.php");
            exit();
            }
    
            // Proceed with the update if email is unique
            $stmt = $connection->prepare("UPDATE tbl_user SET lname = ?, fname = ?, mi = ?, email = ?, contact = ? WHERE id_user = ?");
            $stmt->execute([$lname, $suffix, $fname, $mi, $email, $contact, $id_user]);
    
            $toast = '
            <div class="toast">
                <div class="toast-content">
                    <i class="fas fa-solid fa-check check"></i>
                    <div class="message">
                        <span class="text text-1">Profile Updated</span>
                        <span class="text text-2">Your changes on your profile has been saved </span>
                    </div>
                </div>
                <i class="fa-solid fa-xmark close" onclick="closeToast()"></i>
                <div class="progress"></div>
            </div>';
        
        // Pass the toast message to the session for rendering in the UI
        $_SESSION['toast'] = $toast;

        // Redirect to prevent form re-submission
        header("Location: account_crud.php");
        exit();
        }
    }
    


    public function update_account_password() {
        if (isset($_POST['update_account_password'])) {
            $id_user = $_GET['id'];
            $oldpassword = $_POST['oldpassword'];
            $newpassword = $_POST['newpassword'];
            $checkpassword = $_POST['checkpassword'];

            $connection = $this->openConn();
            $stmt = $connection->prepare("SELECT `password` FROM tbl_user WHERE id_user = ?");
            $stmt->execute([$id_user]);
            $result = $stmt->fetch();

            if (!$result || !password_verify($oldpassword, $result['password'])) {
                echo "<script type='text/javascript'>alert('Old Password is Incorrect');</script>";
            } elseif ($newpassword !== $checkpassword) {
                echo "<script type='text/javascript'>alert('New Password and Confirm Password do not Match');</script>";
            } else {
                $hashedPassword = password_hash($newpassword, PASSWORD_DEFAULT);
                $stmt = $connection->prepare("UPDATE tbl_user SET password = ? WHERE id_user = ?");
                $stmt->execute([$hashedPassword, $id_user]);

                $message2 = "Password Updated";
                echo "<script type='text/javascript'>alert('$message2');</script>";
                header("refresh: 0");
            }
        }
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
                    if ($user['role'] === 'administrator') {
                        $this->set_userdata($user);
                        header('Location: admn_dashboard.php');
                        exit;
                    }
                    else if ($user['role'] === 'staff') {
                        $this->set_userdata($user);
                        header('Location: staff_dashboard.php');
                        exit;
                    }
                     else {
                        $message = "You are not authorized personnel!";
                        echo "<script type='text/javascript'>alert('$message');</script>";
                    }
                } else {
                   
                    $errormsg = '
                
                        <div class="toast" style = "border-left: 6px solid #D32F2F;">
                            <div class="toast-content">
                                <i class="fas fa-exclamation-triangle check" style = "background-color: #D32F2F;"></i>
                                <div class="message">
                                    <span class="text text-1">Wrong Credentials</span>
                                    <span class="text text-2">Invalid username or password </span>
                                </div>
                            </div>
                            <i class="fa-solid fa-xmark close close-error"  onclick="closeToast()"></i>
                            <div class="progress progress-error"></div>
                        </div>
                   ';

                    $_SESSION['toast'] = $errormsg;

                    // Redirect to prevent form re-submission
                    header("Location: login.php");
                    exit();
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
            "id" => isset($array['id_user']) ? $array['id_user'] : uniqid('guest_'),
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
            $suffix = $_POST['suffix'];
            $mi = $_POST['mi'];
            $role = $_POST['role'];
    
                if ($this->check_admin($email) == 0 ) {
        
                    $connection = $this->openConn();
                    $stmt = $connection->prepare("INSERT INTO tbl_admin (`email`,`password`,`lname`,`fname`,
                    `mi`, `role` ) VALUES (?, ?, ?, ?, ?, ?)");
                    
                    $stmt->Execute([$email, $password, $lname, $suffix, $fname, $mi, $role]);
                    
                    $message2 = "Administrator account added, you can now continue logging in";
                    echo "<script type='text/javascript'>alert('$message2');</script>";
                }
            }
    
            else {
                echo "<script type='text/javascript'>alert('Account already exists');</script>";
            }
    }

    public function get_single_admin($id_admin){        
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT * FROM tbl_user where id_user = ?");
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
    if (isset($_POST['create_announce'])) {
        $event = $_POST['event'];
        $created_by = $_POST['created_by'];

        $connection = $this->openConn();
        $stmt = $connection->prepare("INSERT INTO tbl_announcement (`event`, `created_by`) VALUES (?, ?)");
        $stmt->execute([$event, $created_by]);

        // Store the notification HTML in a variable
        $toast = '
            <div class="toast">
                <div class="toast-content">
                    <i class="fas fa-solid fa-check check"></i>
                    <div class="message">
                        <span class="text text-1">Announcement Posted</span>
                        <span class="text text-2">Your announcement has been published </span>
                    </div>
                </div>
                <i class="fa-solid fa-xmark close" onclick="closeToast()"></i>
                <div class="progress"></div>
            </div>';
        
        // Pass the toast message to the session for rendering in the UI
        $_SESSION['toast'] = $toast;

        // Redirect to prevent form re-submission
        header("Location: admn_announcement_crud.php");
        exit();
    }
}


    public function view_announcement(){
        $connection = $this->openConn();
        $stmt = $connection->prepare("SELECT u.lname, u.fname, u.mi, a.event, date(a.created_on) AS created_date, TIME_FORMAT(a.created_on, '%h:%i %p') AS created_time, a.id_announcement from tbl_user AS
            u JOIN tbl_announcement AS a ON u.id_user = a.created_by ORDER BY a.created_on DESC");
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

    public function delete_announcement() {
        if (isset($_POST['delete_announcement'])) {
            $id_announcement = $_POST['id_announcement'];
    
            $connection = $this->openConn();
            $stmt = $connection->prepare("DELETE FROM tbl_announcement WHERE id_announcement = ?");
            $stmt->execute([$id_announcement]);
    
            // Store the notification HTML in a variable
            $toastdelete = '
                <div class="toast">
                    <div class="toast-content">
                        <i class="fas fa-solid fa-check check"></i>
                        <div class="message">
                            <span class="text text-1">Announcement Deleted</span>
                            <span class="text text-2">The announcement has been removed</span>
                        </div>
                    </div>
                    <i class="fa-solid fa-xmark close" onclick="closeToast()"></i>
                    <div class="progress"></div>
                </div>';
    
            // Pass the toast message to the session for rendering in the UI
            $_SESSION['toast'] = $toastdelete;
    
            // Redirect to prevent form re-submission
            header("Location: admn_announcement_crud.php");
            exit();
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
    public function get_single_certofres(){
        $id_rescert = $_GET['id_rescert'];
        $status = isset($_GET['status']) ? $_GET['status'] : 'accepted' ;
        
        $connection = $this->openConn();

        $stmt = $connection->prepare("SELECT 
            id_rescert,
            fname,
            mi,
            lname, suffix,
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
            WHERE doc_status = ? AND id_rescert = ?");

       if ($status === 'archived') {
            $stmt = $connection->prepare("SELECT 
                id_rescert,
                fname,
                mi,
                lname, suffix,
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
                WHERE doc_status = ? AND id_rescert = ?
            ");
        }
        
        $stmt->execute([$status, $id_rescert]);
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
            SELECT * FROM tbl_rescert WHERE created_by = ? ORDER BY created_on DESC LIMIT 1
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
            $suffix = $_POST['suffix'];
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
                INSERT INTO tbl_rescert(fname, mi, lname, suffix, age, houseno, street, brgy, city, municipality, purpose, created_by)
                 VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ');
            
            $stmt->execute([
                $fname, 
                $mi,
                $lname, $suffix,
                $age,
                $houseno,
                $street,
                $brgy,
                $city,
                $municipality,
                $purpose,
                $created_by
                
            ]);

            $residentId = $this->get_latest_certofres($created_by);
            $qrCode = $this->generateQRCode($residentId['id_rescert'], 'rescert');

            echo '

                                  <div id="qr" class="overlay-qr">
        <div class="popup-qr">
          <h3>Your QR Code has been generated!</h3>
<p>Download or take a screenshot of it, and bring it to the barangay hall along with the required documents to claim your certificate.</p>

<p class = "qrid">BGRES - ' .strtoupper($lname). ' - ' .$residentId['id_rescert']. '</p>

<img src="' . $qrCode . '" alt="QR Code" />

                <a href="' . $qrCode . '" download="qr_code_certofindigency.png">
                    <button type="button" class ="btn-dl-qr">Download QR Code</button>
                </a>

            <button class="btn-close-qr" onclick="closeModal()">Close</button>
        </div>
    </div>
            ';
        }
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
        }
    }

    public function update_certofres() {
        if (isset($_POST['update_rescert'])) {
            $id_rescert = $_GET['id_rescert'];
            $lname = $_POST['lname'];
            $fname = $_POST['fname'];
            $suffix = $_POST['suffix'];
            $mi = $_POST['mi'];
            $age = $_POST['age'];
            $houseno = $_POST['houseno'];
            $street = $_POST['street'];
            $brgy = $_POST['brgy'];
            $city = $_POST['city'];
            $municipality = $_POST['municipality'];
            $purpose = $_POST['purpose'];
            $doc_status = 'pending';
    
            try {                
                $connection = $this->openConn();
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
                    $lname, $suffix,
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

                $stmt = $connection->prepare("UPDATE tbl_rescert SET doc_status = 'accepted' WHERE id_rescert = ?");

                $stmt->execute([$doc_status]);

                echo '
                    <dialog class="message-popup success" >
                        <div class="pop-up">
                            <div class="left-side">
                                <div class="left-side-wrapper"><i class="bx bxs-x-circle error-circle"></i></div>
                            </div>
                            <div class="right-side">
                                <div class="right-group">
                                <div class="content">
                                    <h1>Updated Successfully!</h1>
                                </div>
                                <button onclick="closeDialog()" onclick="closeDialog()" class="exit-btn">X</button>
                                </div>
                            </div>
                        </div>
                    </dialog>
                ';

            }
            catch (PDOException $e) {
                echo '
                    <dialog class="message-popup success" >
                        <div class="pop-up">
                            <div class="left-side">
                                <div class="left-side-wrapper"><i class="bx bxs-x-circle error-circle"></i></div>
                            </div>
                            <div class="right-side">
                                <div class="right-group">
                                <div class="content">
                                    <h1>'.$e->getMessage().'</h1>
                                </div>
                                <button onclick="closeDialog()" onclick="closeDialog()" class="exit-btn">X</button>
                                </div>
                            </div>
                        </div>
                    </dialog>
                ';
            }
        }
    }

    public function view_archive_certofres(){
        if (isset($_POST['archive_rescert'])) {
            $id_rescert = $_POST['id_rescert'];
            $id = $_POST['id'];
            $doc_status = 'archived';
    
            $connection = $this->openConn();
    
            $stmt = $connection->prepare('UPDATE tbl_rescert SET doc_status = ? WHERE id_rescert = ?');
            $stmt->execute([$doc_status, $id_rescert]);

            $toast = '
            <body>
                <div class="toast">
                    <div class="toast-content">
                        <i class="fas fa-solid fa-check check"></i>
                        <div class="message">
                            <span class="text text-1">Success</span>
                            <span class="text text-2">The request has been archived successfully</span>
                        </div>
                    </div>
                    <i class="fa-solid fa-xmark close" onclick="closeToast()"></i>
                    <div class="progress"></div>
                </div>
            </body>';
        
            $_SESSION['toast'] = $toast;
    
            echo '
                <script>
                    window.opener.location.href = window.opener.location.href;                
                    window.close();
                </script>
            ';
        }
    }
    
    public function view_unarchive_certofres(){
        if (isset($_POST['unarchive_rescert'])) {
            $id_rescert = $_POST['id_rescert'];
            $id = $_POST['id'];
            $doc_status = 'accepted';
    
            $connection = $this->openConn();
    
            $stmt = $connection->prepare('UPDATE tbl_rescert SET doc_status = ? WHERE id_rescert = ?');
            $stmt->execute([$doc_status, $id_rescert]);

            $toast = '
            <body>
                <div class="toast">
                    <div class="toast-content">
                        <i class="fas fa-solid fa-check check"></i>
                        <div class="message">
                            <span class="text text-1">Success</span>
                            <span class="text text-2">The request has been retrieved successfully</span>
                        </div>
                    </div>
                    <i class="fa-solid fa-xmark close" onclick="closeToast()"></i>
                    <div class="progress"></div>
                </div>
            </body>';
        
            $_SESSION['toast'] = $toast;
    
            echo '
                <script>
                    window.opener.location.href = window.opener.location.href;
                    window.close();
                </script>
            ';
        }
    }



    public function archive_certofres() {
        if (isset($_POST['archive_selected_rescert']) && isset($_POST['ids_to_archive'])) {
            $idsToArchive = explode(',', $_POST['ids_to_archive']);
            $id = $_POST['id'];
            $doc_status = 'archived';
            
            $connection = $this->openConn();
    
            try {
                $connection->beginTransaction();
    
                foreach ($idsToArchive as $idRescert) {
                    $insertStmt = $connection->prepare("
                       UPDATE tbl_rescert SET created_by = :created_by, doc_status = :doc_status WHERE id_rescert = :id_rescert
                    ");

                    $insertStmt->bindParam(':doc_status', $doc_status);
                    $insertStmt->bindParam(':created_by', $id);
                    $insertStmt->bindParam(':id_rescert', $idRescert);
                    $insertStmt->execute();
                }
    
                $connection->commit();
    
                // Set a success message
                $toast = '
                <body>
                    <div class="toast">
                        <div class="toast-content">
                            <i class="fas fa-solid fa-check check"></i>
                            <div class="message">
                                <span class="text text-1">Success</span>
                                <span class="text text-2">The request has been archived successfully</span>
                            </div>
                        </div>
                        <i class="fa-solid fa-xmark close" onclick="closeToast()"></i>
                        <div class="progress"></div>
                    </div>
                </body>';
            
                $_SESSION['toast'] = $toast;
    
                // Refresh the page to clear form resubmission
                header("Location: admn_certofres.php?list=active");
                exit();
    
            } catch (Throwable $e) {
                $connection->rollBack();
                $toast = '
                <div class="toast" style = "border-left: 6px solid #D32F2F;">
                    <div class="toast-content">
                        <i class="fas fa-exclamation-triangle check" style = "background-color: #D32F2F;"></i>
                        <div class="message">
                            <span class="text text-1">Error</span>
                            <span class="text text-2">An unexpected error occurred while processing your request</span>
                        </div>
                    </div>
                    <i class="fa-solid fa-xmark close close-error"  onclick="closeToast()"></i>
                    <div class="progress progress-error"></div>
                </div>
        ';
        $_SESSION['toast'] = $toast;
        header("Location: admn_certofres.php?list=active");
        exit();
            }
        }
    }

    public function unarchive_certofres() {
        if (isset($_POST['retrieve_selected_rescert']) && isset($_POST['ids_to_retrieve'])) {
            $idsToRetrieve = explode(',', $_POST['ids_to_retrieve']);
            $id = $_POST['id'];
            $doc_status = 'accepted';
            
    
            $connection = $this->openConn();
    
            try {
                $connection->beginTransaction();
    
                foreach ($idsToRetrieve as $idRescert) {
                    $insertStmt = $connection->prepare("
                        UPDATE tbl_rescert SET created_by = :created_by, doc_status = :doc_status WHERE id_rescert = :id_rescert
                    ");
    
                    $insertStmt->bindParam(':created_by', $id);
                    $insertStmt->bindParam(':id_rescert', $idRescert);
                    $insertStmt->bindParam(':doc_status', $doc_status);
                    $insertStmt->execute();
                }
    
                $connection->commit();
    
                // Set a success message
                $toast = '
                <body>
                    <div class="toast">
                        <div class="toast-content">
                            <i class="fas fa-solid fa-check check"></i>
                            <div class="message">
                                <span class="text text-1">Success</span>
                                <span class="text text-2">The request has been retrieved successfully</span>
                            </div>
                        </div>
                        <i class="fa-solid fa-xmark close" onclick="closeToast()"></i>
                        <div class="progress"></div>
                    </div>
                </body>';
            
                $_SESSION['toast'] = $toast;
    
                // Refresh the page to clear form resubmission
                header("Location: admn_certofres.php?list=archived");
                exit();
    
            } catch (Throwable $e) {
                $connection->rollBack();
                $toast = '
                <div class="toast" style = "border-left: 6px solid #D32F2F;">
                    <div class="toast-content">
                        <i class="fas fa-exclamation-triangle check" style = "background-color: #D32F2F;"></i>
                        <div class="message">
                            <span class="text text-1">Error</span>
                            <span class="text text-2">An unexpected error occurred while processing your request</span>
                        </div>
                    </div>
                    <i class="fa-solid fa-xmark close close-error"  onclick="closeToast()"></i>
                    <div class="progress progress-error"></div>
                </div>
        ';
        $_SESSION['toast'] = $toast;
        header("Location: admn_certofres.php?list=archived");
        exit();
            }
        }
    }

    
    
 
     //------------------------------------------ CERT OF INIDIGENCY CRUD -----------------------------------------------

     public function get_latest_certofindigency($id) {
        $connection = $this->openConn();            

        $stmt = $connection->prepare('
            SELECT * FROM tbl_indigency WHERE created_by = ? ORDER BY created_on DESC LIMIT 1
        ');
        $stmt->execute([$id]);

        $latestRecord = $stmt->fetch();
        return $latestRecord;
    }


     public function create_certofindigency() {

        if(isset($_POST['create_certofindigency'])) {
                // Gather the form data
                $lname = $_POST['lname'];
                $fname = $_POST['fname'];
                $suffix = $_POST['suffix'];
                $mi = $_POST['mi'];
                $age = $_POST['age'];
                $nationality = $_POST['nationality'];
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
                INSERT INTO tbl_indigency(fname, mi, lname, suffix, age, nationality, houseno, street, brgy, city, municipality, purpose, created_by)
                 VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ');
            
            $stmt->execute([
                $fname, 
                $mi,
                $lname, $suffix,
                $age,
                $nationality,
                $houseno,
                $street,
                $brgy,
                $city,
                $municipality,
                $purpose,
                $created_by
            ]);

            $residentId = $this->get_latest_certofindigency($created_by);
            $qrCode = $this->generateQRCode($residentId['id_indigency'], 'indigency');
         
            echo '

                                  <div id="qr" class="overlay-qr">
        <div class="popup-qr">
          <h3>Your QR Code has been generated!</h3>
<p>Download or take a screenshot of it, and bring it to the barangay hall along with the required documents to claim your certificate.</p>
<p class = "qrid">BGIND - ' .strtoupper($lname). ' - ' .$residentId['id_indigency']. '</p>            
<img src="' . $qrCode . '" alt="QR Code" />
                <a href="' . $qrCode . '" download="qr_code_certofindigency.png">
                    <button type="button" class ="btn-dl-qr">Download QR Code</button>
                </a>

            <button class="btn-close-qr" onclick="closeModal()">Close</button>
        </div>
    </div>
            ';
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
            $id_indigency = $_GET['id_indigency'];
            $lname = $_POST['lname'];
            $fname = $_POST['fname'];
            $suffix = $_POST['suffix'];
            $mi = $_POST['mi'];
            $age = $_POST['age'];
            $nationality = $_POST['nationality'];
            $houseno = $_POST['houseno'];
            $street = $_POST['street'];
            $brgy = $_POST['brgy'];
            $city = $_POST['city'];
            $municipality = $_POST['municipality'];
            $purpose = $_POST['purpose'];
            $doc_status = 'pending';
    
            try {                
                $connection = $this->openConn();
                $stmt = $connection->prepare("UPDATE tbl_indigency SET 
                    lname = ?,
                    fname = ?,
                    mi = ?,
                    age = ?,
                    nationality = ?,
                    houseno = ?,
                    street = ?,
                    brgy = ?,
                    city = ?,
                    municipality = ?,
                    purpose = ?,
                    doc_status = ?
                    WHERE
                    id_indigency = ?
                ");

                $stmt->execute([
                    $lname, $suffix,
                    $fname,
                    $mi,
                    $age,
                    $nationality,
                    $houseno,
                    $street,
                    $brgy,
                    $city,
                    $municipality,
                    $purpose,
                    $doc_status,
                    $id_indigency
                ]);

                echo '
                    <dialog class="message-popup success" >
                        <div class="pop-up">
                            <div class="left-side">
                                <div class="left-side-wrapper"><i class="bx bxs-x-circle error-circle"></i></div>
                            </div>
                            <div class="right-side">
                                <div class="right-group">
                                <div class="content">
                                    <h1>Updated Successfully!</h1>
                                </div>
                                <button onclick="closeDialog()" onclick="closeDialog()" class="exit-btn">X</button>
                                </div>
                            </div>
                        </div>
                    </dialog>
                ';
            }
            catch (PDOException $e) {
                $connection->rollBack();
                echo "<script>alert('Failed to update records: " . $e->getMessage() . "')</script>";
                exit;
            }
        }
    }

    public function view_archive_certofindigency(){
        if (isset($_POST['archive_certofindigency'])) {
            $id_indigency = $_POST['id_indigency'];
            $id = $_POST['id'];
            $doc_status = 'archived';
    
            $connection = $this->openConn();
    
            $stmt = $connection->prepare('UPDATE tbl_indigency SET doc_status = ? WHERE id_indigency = ?');
            $stmt->execute([$doc_status, $id_indigency]);

            $toast = '
            <body>
                <div class="toast">
                    <div class="toast-content">
                        <i class="fas fa-solid fa-check check"></i>
                        <div class="message">
                            <span class="text text-1">Success</span>
                            <span class="text text-2">The request has been archived successfully</span>
                        </div>
                    </div>
                    <i class="fa-solid fa-xmark close" onclick="closeToast()"></i>
                    <div class="progress"></div>
                </div>
            </body>';
        
            $_SESSION['toast'] = $toast;
    
            echo '
                <script>
                    window.opener.location.href = window.opener.location.href;                
                    window.close();
                </script>
            ';
        }
    }
    
    public function view_unarchive_certofindigency(){
        if (isset($_POST['unarchive_certofindigency'])) {
            $id_indigency = $_POST['id_indigency'];
            $id = $_POST['id'];
            $doc_status = 'accepted';
    
            $connection = $this->openConn();
    
            $stmt = $connection->prepare('UPDATE tbl_indigency SET doc_status = ? WHERE id_indigency = ?');
            $stmt->execute([$doc_status, $id_indigency]);

            $toast = '
            <body>
                <div class="toast">
                    <div class="toast-content">
                        <i class="fas fa-solid fa-check check"></i>
                        <div class="message">
                            <span class="text text-1">Success</span>
                            <span class="text text-2">The request has been retrieved successfully</span>
                        </div>
                    </div>
                    <i class="fa-solid fa-xmark close" onclick="closeToast()"></i>
                    <div class="progress"></div>
                </div>
            </body>';
        
            $_SESSION['toast'] = $toast;
    
            echo '
                <script>
                    window.opener.location.href = window.opener.location.href;
                    window.close();
                </script>
            ';
        }
    }



    public function archive_certofindigency() {
        if (isset($_POST['archive_selected_indigency']) && isset($_POST['ids_to_archive'])) {
            $idsToArchive = explode(',', $_POST['ids_to_archive']);
            $id = $_POST['id'];
            $doc_status = 'archived';
            
            $connection = $this->openConn();
    
            try {
                $connection->beginTransaction();
    
                foreach ($idsToArchive as $idIndigency) {
                    $insertStmt = $connection->prepare("
                       UPDATE tbl_indigency SET created_by = :created_by, doc_status = :doc_status WHERE id_indigency = :id_indigency
                    ");

                    $insertStmt->bindParam(':doc_status', $doc_status);
                    $insertStmt->bindParam(':created_by', $id);
                    $insertStmt->bindParam(':id_indigency', $idIndigency);
                    $insertStmt->execute();
                }
    
                $connection->commit();
    
                // Set a success message
                $toast = '
                <body>
                    <div class="toast">
                        <div class="toast-content">
                            <i class="fas fa-solid fa-check check"></i>
                            <div class="message">
                                <span class="text text-1">Success</span>
                                <span class="text text-2">The request has been archived successfully</span>
                            </div>
                        </div>
                        <i class="fa-solid fa-xmark close" onclick="closeToast()"></i>
                        <div class="progress"></div>
                    </div>
                </body>';
            
                $_SESSION['toast'] = $toast;
    
                // Refresh the page to clear form resubmission
                header("Location: admn_certofindigency.php?list=active");
                exit();
    
            } catch (Throwable $e) {
                $connection->rollBack();
                $toast = '
                <div class="toast" style = "border-left: 6px solid #D32F2F;">
                    <div class="toast-content">
                        <i class="fas fa-exclamation-triangle check" style = "background-color: #D32F2F;"></i>
                        <div class="message">
                            <span class="text text-1">Error</span>
                            <span class="text text-2">An unexpected error occurred while processing your request</span>
                        </div>
                    </div>
                    <i class="fa-solid fa-xmark close close-error"  onclick="closeToast()"></i>
                    <div class="progress progress-error"></div>
                </div>
        ';
        $_SESSION['toast'] = $toast;
        header("Location: admn_certofindigency.php?list=active");
        exit();
            }
        }
    }

    public function unarchive_certofindigency() {
        if (isset($_POST['retrieve_selected_indigency']) && isset($_POST['ids_to_retrieve'])) {
            $idsToRetrieve = explode(',', $_POST['ids_to_retrieve']);
            $id = $_POST['id'];
            $doc_status = 'accepted';
            
    
            $connection = $this->openConn();
    
            try {
                $connection->beginTransaction();
    
                foreach ($idsToRetrieve as $idIndigency) {
                    $insertStmt = $connection->prepare("
                        UPDATE tbl_indigency SET created_by = :created_by, doc_status = :doc_status WHERE id_indigency = :id_indigency
                    ");
    
                    $insertStmt->bindParam(':created_by', $id);
                    $insertStmt->bindParam(':id_indigency', $idIndigency);
                    $insertStmt->bindParam(':doc_status', $doc_status);
                    $insertStmt->execute();
                }
    
                $connection->commit();
    
                // Set a success message
                $toast = '
                <body>
                    <div class="toast">
                        <div class="toast-content">
                            <i class="fas fa-solid fa-check check"></i>
                            <div class="message">
                                <span class="text text-1">Success</span>
                                <span class="text text-2">The request has been retrieved successfully</span>
                            </div>
                        </div>
                        <i class="fa-solid fa-xmark close" onclick="closeToast()"></i>
                        <div class="progress"></div>
                    </div>
                </body>';
            
                $_SESSION['toast'] = $toast;
    
                // Refresh the page to clear form resubmission
                header("Location: admn_certofindigency.php?list=archived");
                exit();
    
            } catch (Throwable $e) {
                $connection->rollBack();
                $toast = '
                <div class="toast" style = "border-left: 6px solid #D32F2F;">
                    <div class="toast-content">
                        <i class="fas fa-exclamation-triangle check" style = "background-color: #D32F2F;"></i>
                        <div class="message">
                            <span class="text text-1">Error</span>
                            <span class="text text-2">An unexpected error occurred while processing your request</span>
                        </div>
                    </div>
                    <i class="fa-solid fa-xmark close close-error"  onclick="closeToast()"></i>
                    <div class="progress progress-error"></div>
                </div>
        ';
        $_SESSION['toast'] = $toast;
        header("Location: admn_certofindigency.php?list=archived");
        exit();
            }
        }
    }
   

    public function get_single_certofindigency(){
        $id_indigency = $_GET['id_indigency'];
        $status = isset($_GET['status']) ? $_GET['status'] : 'accepted' ;
        
        $connection = $this->openConn();

        $stmt = $connection->prepare("SELECT 
            id_indigency,
            fname,
            mi,
            lname, suffix,
            age,
            nationality,
            houseno,
            street,
            brgy,
            city,
            municipality,
            purpose,
            created_by,
            DATE_FORMAT(STR_TO_DATE(created_on, '%Y-%m-%d'), '%b. %d, %Y') AS `date` 
            FROM tbl_indigency 
            WHERE doc_status = ? AND id_indigency = ?");

       if ($status === 'archived') {
            $stmt = $connection->prepare("SELECT 
                id_indigency,
                fname,
                mi,
                lname, suffix,
                age,
                nationality,
                houseno,
                street,
                brgy,
                city,
                municipality,
                purpose,
                created_by,
                DATE_FORMAT(STR_TO_DATE(created_on, '%Y-%m-%d'), '%b. %d, %Y') AS `date` 
                FROM tbl_indigency
                WHERE doc_status = ? AND id_indigency = ?");
        }
        
        $stmt->execute([$status, $id_indigency]);
        $indigency = $stmt->fetch();
        $total = $stmt->rowCount();

        if($total > 0 )  {
            return $indigency;
        } else {
            return false;
        }
    }



     //------------------------------------------ BRGY CLEARANCE CRUD -----------------------------------------------

     public function get_single_clearance(){
        $id_clearance = $_GET['id_clearance'];
        $status = isset($_GET['status']) ? $_GET['status'] : 'accepted' ;
        
        $connection = $this->openConn();

        $stmt = $connection->prepare("SELECT 
            id_clearance,
            fname,
            mi,
            lname, suffix,
            age,
            houseno,
            street,
            brgy,
            city,
            municipality,
            purpose,
            created_by,
            DATE_FORMAT(STR_TO_DATE(created_on, '%Y-%m-%d'), '%b. %d, %Y') AS date 
            FROM tbl_clearance 
            WHERE doc_status = ? AND id_clearance = ?");

       if ($status === 'archived') {
            $stmt = $connection->prepare("SELECT 
                id_clearance,
                fname,
                mi,
                lname, suffix,
                age,
                houseno,
                street,
                brgy,
                city,
                municipality,
                purpose,
                created_by,
                DATE_FORMAT(STR_TO_DATE(created_on, '%Y-%m-%d'), '%b. %d, %Y') AS date 
                FROM tbl_clearance
                WHERE doc_status = ? AND id_clearance = ?");
        }
        
        $stmt->execute([$status, $id_clearance]);
        $clearance = $stmt->fetch();
        $total = $stmt->rowCount();

        if($total > 0 )  {
            return $clearance;
        } else {
            return false;
        }
    }

    public function get_latest_brgyclearance($id) {
        $connection = $this->openConn();            

        $stmt = $connection->prepare('
            SELECT * FROM tbl_clearance WHERE created_by = ? ORDER BY created_on DESC LIMIT 1
        ');
        $stmt->execute([$id]);

        $latestRecord = $stmt->fetch();
        return $latestRecord;
    }

     public function create_brgyclearance() {
        if(isset($_POST['create_brgyclearance'])) {
            // Gather the form data
            $lname = $_POST['lname'];
            $fname = $_POST['fname'];
            $suffix = $_POST['suffix'];
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
                INSERT INTO tbl_clearance(fname, mi, lname, suffix, age, houseno, street, brgy, city, municipality, purpose, created_by)
                 VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ');
            
            $stmt->execute([
                $fname, 
                $mi,
                $lname, $suffix,
                $age,
                $houseno,
                $street,
                $brgy,
                $city,
                $municipality,
                $purpose,
                $created_by
            ]);

            $residentId = $this->get_latest_brgyclearance($created_by);
            $qrCode = $this->generateQRCode($residentId['id_clearance'], 'clearance');

            echo '

                                  <div id="qr" class="overlay-qr">
        <div class="popup-qr">
          <h3>Your QR Code has been generated!</h3>
<p>Download or take a screenshot of it, and bring it to the barangay hall along with the required documents to claim your certificate.</p>
<p class = "qrid">BGCLR - ' .strtoupper($lname). ' - ' .$residentId['id_clearance']. '</p>            
<img src="' . $qrCode . '" alt="QR Code" />
                <a href="' . $qrCode . '" download="qr_code_certofindigency.png">
                    <button type="button" class ="btn-dl-qr">Download QR Code</button>
                </a>

            <button class="btn-close-qr" onclick="closeModal()">Close</button>
        </div>
    </div>
            ';
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

    public function accept_clearance() {
        $id_clearance = $_GET['id_clearance'];
        $connection = $this->openConn();
    
        // Fetch the current status
        $stmt = $connection->prepare("SELECT doc_status FROM tbl_clearance WHERE id_clearance = ?");
        $stmt->execute([$id_clearance]);
        $currentStatus = $stmt->fetchColumn();
    
        // Check the current status and update only if it is "pending"
        if ($currentStatus === 'pending') {
            $doc_status = 'accepted';
            $updateStmt = $connection->prepare("UPDATE tbl_clearance SET doc_status = ? WHERE id_clearance = ?");
            $updateStmt->execute([$doc_status, $id_clearance]);
        }
    }

    public function accept_indigency() {
        $id_indigency = $_GET['id_indigency'];
        $connection = $this->openConn();
    
        // Fetch the current status
        $stmt = $connection->prepare("SELECT doc_status FROM tbl_indigency WHERE id_indigency = ?");
        $stmt->execute([$id_indigency]);
        $currentStatus = $stmt->fetchColumn();
    
        // Check the current status and update only if it is "pending"
        if ($currentStatus === 'pending') {
            $doc_status = 'accepted';
            $updateStmt = $connection->prepare("UPDATE tbl_indigency SET doc_status = ? WHERE id_indigency = ?");
            $updateStmt->execute([$doc_status, $id_indigency]);
        }
    }

    public function accept_brgyid() {
        $id_brgyid = $_GET['id_brgyid'];
        $connection = $this->openConn();
    
        // Fetch the current status
        $stmt = $connection->prepare("SELECT doc_status FROM tbl_brgyid WHERE id_brgyid = ?");
        $stmt->execute([$id_brgyid]);
        $currentStatus = $stmt->fetchColumn();
    
        // Check the current status and update only if it is "pending"
        if ($currentStatus === 'pending') {
            $doc_status = 'accepted';
            $updateStmt = $connection->prepare("UPDATE tbl_brgyid SET doc_status = ? WHERE id_brgyid = ?");
            $updateStmt->execute([$doc_status, $id_brgyid]);
        }
    }

    public function accept_rescert() {
        $id_rescert = $_GET['id_rescert'];
        $connection = $this->openConn();
    
        // Fetch the current status
        $stmt = $connection->prepare("SELECT doc_status FROM tbl_rescert WHERE id_rescert = ?");
        $stmt->execute([$id_rescert]);
        $currentStatus = $stmt->fetchColumn();
    
        // Check the current status and update only if it is "pending"
        if ($currentStatus === 'pending') {
            $doc_status = 'accepted';
            $updateStmt = $connection->prepare("UPDATE tbl_rescert SET doc_status = ? WHERE id_rescert = ?");
            $updateStmt->execute([$doc_status, $id_rescert]);
        }
    }
    
    public function accept_bspermit() {
        $id_bspermit = $_GET['id_bspermit'];
        $connection = $this->openConn();
    
        // Fetch the current status
        $stmt = $connection->prepare("SELECT doc_status FROM tbl_bspermit WHERE id_bspermit = ?");
        $stmt->execute([$id_bspermit]);
        $currentStatus = $stmt->fetchColumn();
    
        // Check the current status and update only if it is "pending"
        if ($currentStatus === 'pending') {
            $doc_status = 'accepted';
            $updateStmt = $connection->prepare("UPDATE tbl_bspermit SET doc_status = ? WHERE id_bspermit = ?");
            $updateStmt->execute([$doc_status, $id_bspermit]);
        }
    }

    public function update_clearance() {
        if (isset($_POST['update_clearance'])) {  // Checks if update was triggered
            $id_clearance = $_GET['id_clearance'];
            $lname = $_POST['lname'];
            $fname = $_POST['fname'];
            $suffix = $_POST['suffix'];
            $mi = $_POST['mi'];
            $age = $_POST['age'];
            $houseno = $_POST['houseno'];
            $street = $_POST['street'];
            $brgy = $_POST['brgy'];
            $city = $_POST['city'];
            $municipality = $_POST['municipality'];
            $purpose = $_POST['purpose'];
            $doc_status = 'pending';
    
            try {                
                $connection = $this->openConn();
                $stmt = $connection->prepare("UPDATE tbl_clearance SET 
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
                    id_clearance = ?
                ");

                $stmt->execute([
                    $lname, $suffix,
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
                    $id_clearance
                ]);

                echo '
                    <dialog class="message-popup success" >
                        <div class="pop-up">
                            <div class="left-side">
                                <div class="left-side-wrapper"><i class="bx bxs-x-circle error-circle"></i></div>
                            </div>
                            <div class="right-side">
                                <div class="right-group">
                                <div class="content">
                                    <h1>Updated Successfully!</h1>
                                </div>
                                <button onclick="closeDialog()" onclick="closeDialog()" class="exit-btn">X</button>
                                </div>
                            </div>
                        </div>
                    </dialog>
                ';

            }
            catch (PDOException $e) {
                echo '
                    <dialog class="message-popup success" >
                        <div class="pop-up">
                            <div class="left-side">
                                <div class="left-side-wrapper"><i class="bx bxs-x-circle error-circle"></i></div>
                            </div>
                            <div class="right-side">
                                <div class="right-group">
                                <div class="content">
                                    <h1>'.$e->getMessage().'</h1>
                                </div>
                                <button onclick="closeDialog()" onclick="closeDialog()" class="exit-btn">X</button>
                                </div>
                            </div>
                        </div>
                    </dialog>
                ';
            }
        }
  }

    public function view_archive_brgyclearance(){
        if (isset($_POST['archive_clearance'])) {
            $id_clearance = $_POST['id_clearance'];
            $id = $_POST['id'];
            $doc_status = 'archived';
    
            $connection = $this->openConn();
    
            $stmt = $connection->prepare('UPDATE tbl_clearance SET doc_status = ? WHERE id_clearance = ?');
            $stmt->execute([$doc_status, $id_clearance]);

            $toast = '
            <body>
                <div class="toast">
                    <div class="toast-content">
                        <i class="fas fa-solid fa-check check"></i>
                        <div class="message">
                            <span class="text text-1">Success</span>
                            <span class="text text-2">The request has been archived successfully</span>
                        </div>
                    </div>
                    <i class="fa-solid fa-xmark close" onclick="closeToast()"></i>
                    <div class="progress"></div>
                </div>
            </body>';
        
            $_SESSION['toast'] = $toast;
    
            echo '
                <script>
                    window.opener.location.href = window.opener.location.href;                
                    window.close();
                </script>
            ';
        }
    }
    
    public function view_unarchive_brgyclearance(){
        if (isset($_POST['unarchive_clearance'])) {
            $id_clearance = $_POST['id_clearance'];
            $id = $_POST['id'];
            $doc_status = 'accepted';
    
            $connection = $this->openConn();
    
            $stmt = $connection->prepare('UPDATE tbl_clearance SET doc_status = ? WHERE id_clearance = ?');
            $stmt->execute([$doc_status, $id_clearance]);

            $toast = '
            <body>
                <div class="toast">
                    <div class="toast-content">
                        <i class="fas fa-solid fa-check check"></i>
                        <div class="message">
                            <span class="text text-1">Success</span>
                            <span class="text text-2">The request has been retrieved successfully</span>
                        </div>
                    </div>
                    <i class="fa-solid fa-xmark close" onclick="closeToast()"></i>
                    <div class="progress"></div>
                </div>
            </body>';
        
            $_SESSION['toast'] = $toast;
    
            echo '
                <script>
                    window.opener.location.href = window.opener.location.href;
                    window.close();
                </script>
            ';
        }
    }



    public function archive_brgyclearance() {
        if (isset($_POST['archive_selected_clearance']) && isset($_POST['ids_to_archive'])) {
            $idsToArchive = explode(',', $_POST['ids_to_archive']);
            $id = $_POST['id'];
            $doc_status = 'archived';
            
            $connection = $this->openConn();
    
            try {
                $connection->beginTransaction();
    
                foreach ($idsToArchive as $idClearance) {
                    $insertStmt = $connection->prepare("
                       UPDATE tbl_clearance SET created_by = :created_by, doc_status = :doc_status WHERE id_clearance = :id_clearance
                    ");

                    $insertStmt->bindParam(':doc_status', $doc_status);
                    $insertStmt->bindParam(':created_by', $id);
                    $insertStmt->bindParam(':id_clearance', $idClearance);
                    $insertStmt->execute();
                }
    
                $connection->commit();
    
                // Set a success message
                $toast = '
                <body>
                    <div class="toast">
                        <div class="toast-content">
                            <i class="fas fa-solid fa-check check"></i>
                            <div class="message">
                                <span class="text text-1">Success</span>
                                <span class="text text-2">The request has been archived successfully</span>
                            </div>
                        </div>
                        <i class="fa-solid fa-xmark close" onclick="closeToast()"></i>
                        <div class="progress"></div>
                    </div>
                </body>';
            
                $_SESSION['toast'] = $toast;
    
                // Refresh the page to clear form resubmission
                header("Location: admn_brgyclearance.php?list=active");
                exit();
    
            } catch (Throwable $e) {
                $connection->rollBack();
                $toast = '
                <div class="toast" style = "border-left: 6px solid #D32F2F;">
                    <div class="toast-content">
                        <i class="fas fa-exclamation-triangle check" style = "background-color: #D32F2F;"></i>
                        <div class="message">
                            <span class="text text-1">Error</span>
                            <span class="text text-2">An unexpected error occurred while processing your request</span>
                        </div>
                    </div>
                    <i class="fa-solid fa-xmark close close-error"  onclick="closeToast()"></i>
                    <div class="progress progress-error"></div>
                </div>
        ';
        $_SESSION['toast'] = $toast;
        header("Location: admn_brgyclearance.php?list=active");
        exit();
            }
        }
    }

    public function unarchive_brgyclearance() {
        if (isset($_POST['retrieve_selected_clearance']) && isset($_POST['ids_to_retrieve'])) {
            $idsToRetrieve = explode(',', $_POST['ids_to_retrieve']);
            $id = $_POST['id'];
            $doc_status = 'accepted';
            
    
            $connection = $this->openConn();
    
            try {
                $connection->beginTransaction();
    
                foreach ($idsToRetrieve as $idClearance) {
                    $insertStmt = $connection->prepare("
                        UPDATE tbl_clearance SET created_by = :created_by, doc_status = :doc_status WHERE id_clearance = :id_clearance
                    ");
    
                    $insertStmt->bindParam(':created_by', $id);
                    $insertStmt->bindParam(':id_clearance', $idClearance);
                    $insertStmt->bindParam(':doc_status', $doc_status);
                    $insertStmt->execute();
                }
    
                $connection->commit();
    
                // Set a success message
                $toast = '
                <body>
                    <div class="toast">
                        <div class="toast-content">
                            <i class="fas fa-solid fa-check check"></i>
                            <div class="message">
                                <span class="text text-1">Success</span>
                                <span class="text text-2">The request has been retrieved successfully</span>
                            </div>
                        </div>
                        <i class="fa-solid fa-xmark close" onclick="closeToast()"></i>
                        <div class="progress"></div>
                    </div>
                </body>';
            
                $_SESSION['toast'] = $toast;
    
                // Refresh the page to clear form resubmission
                header("Location: admn_brgyclearance.php?list=archived");
                exit();
    
            } catch (Throwable $e) {
                $connection->rollBack();
                $toast = '
                <div class="toast" style = "border-left: 6px solid #D32F2F;">
                    <div class="toast-content">
                        <i class="fas fa-exclamation-triangle check" style = "background-color: #D32F2F;"></i>
                        <div class="message">
                            <span class="text text-1">Error</span>
                            <span class="text text-2">An unexpected error occurred while processing your request</span>
                        </div>
                    </div>
                    <i class="fa-solid fa-xmark close close-error"  onclick="closeToast()"></i>
                    <div class="progress progress-error"></div>
                </div>
        ';
        $_SESSION['toast'] = $toast;
        header("Location: admn_brgyclearance.php?list=archived");
        exit();
            }
        }
    }


  //------------------------------------------ Business Permit CRUD -----------------------------------------------

  public function get_latest_bspermit($id) {
    $connection = $this->openConn();            

    $stmt = $connection->prepare('
        SELECT * FROM tbl_bspermit WHERE created_by = ? ORDER BY created_on DESC LIMIT 1
    ');
    $stmt->execute([$id]);

    $latestRecord = $stmt->fetch();
    return $latestRecord;
}

    public function create_bspermit() {
        if(isset($_POST['create_bspermit'])) {
            $lname = $_POST['lname'];
            $fname = $_POST['fname'];
            $suffix = $_POST['suffix'];
            $mi = $_POST['mi'];
            $bshouseno = $_POST['bshouseno'];
            $bsstreet = $_POST['bsstreet'];
            $bsbrgy = $_POST['bsbrgy'];
            $bscity = $_POST['bscity'];
            $bsmunicipality = $_POST['bsmunicipality'];
            $bsindustry = $_POST['bsindustry'];
            $bsname = $_POST['bsname'];
            $aoe = $_POST['aoe'];
            $created_by = $_POST['created_by'];

            // Check if "Other" was selected and handle custom purpose
            if ($bsindustry === "Other" && !empty($_POST['custom_purpose'])) {
                $bsindustry = $_POST['custom_purpose'];
            }
        
            $connection = $this->openConn();

            // Insert new data
            $stmt = $connection->prepare('
                INSERT INTO tbl_bspermit(fname, mi, lname, suffix, bshouseno, bsstreet, bsbrgy, bscity, bsmunicipality, bsname, bsindustry, aoe, created_by)
                 VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ');
            
            $stmt->execute([
                $fname, 
                $mi,
                $lname, $suffix,
                $bshouseno,
                $bsstreet,
                $bsbrgy,
                $bscity,
                $bsmunicipality,
                $bsname,
                $bsindustry,
                $aoe,
                $created_by
            ]);

            $residentId = $this->get_latest_bspermit($created_by);
            $qrCode = $this->generateQRCode($residentId['id_bspermit'], 'bspermit');

            echo '

                                  <div id="qr" class="overlay-qr">
        <div class="popup-qr">
          <h3>Your QR Code has been generated!</h3>
<p>Download or take a screenshot of it, and bring it to the barangay hall along with the required documents to claim your certificate.</p>
<p class = "qrid">BGPRM - ' .strtoupper($lname). ' - ' .$residentId['id_bspermit']. '</p>            
<img src="' . $qrCode . '" alt="QR Code" />
                <a href="' . $qrCode . '" download="qr_code_certofindigency.png">
                    <button type="button" class ="btn-dl-qr">Download QR Code</button>
                </a>

            <button class="btn-close-qr" onclick="closeModal()">Close</button>
        </div>
    </div>
            ';
        }  
    }

    public function get_single_bspermit(){
        $id_bspermit = $_GET['id_bspermit'];
        $status = isset($_GET['status']) ? $_GET['status'] : 'accepted' ;
        
        $connection = $this->openConn();

        $stmt = $connection->prepare("SELECT 
            id_bspermit,
            fname,
            mi,
            lname, suffix,
            bshouseno,
            bsstreet,
            bsbrgy,
            bscity,
            bsmunicipality,
            bsname,
            bsindustry,
            aoe,
            created_by,
            DATE_FORMAT(STR_TO_DATE(created_on, '%Y-%m-%d'), '%b. %d, %Y') AS `date` 
            FROM tbl_bspermit 
            WHERE doc_status = ? AND id_bspermit = ?");

        if ($status === 'archived') {
            $stmt = $connection->prepare("SELECT 
                id_bspermit,
                fname,
                mi,
                lname, suffix,
                bshouseno,
                bsstreet,
                bsbrgy,
                bscity,
                bsmunicipality,
                bsname,
                bsindustry,
                aoe,
                created_by,
                DATE_FORMAT(STR_TO_DATE(created_on, '%Y-%m-%d'), '%b. %d, %Y') AS `date` 
                FROM tbl_bspermit
                WHERE doc_status = ? AND id_bspermit = ?");
        }
        
        $stmt->execute([$status, $id_bspermit]);
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
            $id_bspermit = $_GET['id_bspermit'];
            $lname = $_POST['lname'];
            $fname = $_POST['fname'];
            $suffix = $_POST['suffix'];
            $mi = $_POST['mi'];
            $bsname = $_POST['bsname']; 
            $bshouseno = $_POST['bshouseno'];
            $bsstreet = $_POST['bsstreet'];
            $bsbrgy = $_POST['bsbrgy'];
            $bscity = $_POST['bscity'];
            $bsmunicipality = $_POST['bsmunicipality'];
            $bsindustry = $_POST['bsindustry'];
            $aoe = $_POST['aoe'];
            $doc_status = 'accepted';

            try {                
                $connection = $this->openConn();
                $stmt = $connection->prepare("UPDATE tbl_bspermit SET 
                    lname = ?,
                    fname = ?,
                    mi = ?,
                    bshouseno = ?,
                    bsstreet = ?,
                    bsbrgy = ?,
                    bscity = ?,
                    bsmunicipality = ?,
                    bsindustry = ?,
                    bsname = ?,
                    aoe = ?,
                    doc_status = ?
                    WHERE
                    id_bspermit = ?
                ");

                $stmt->execute([
                    $lname, $suffix,
                    $fname,
                    $mi,
                    $bshouseno,
                    $bsstreet,
                    $bsbrgy,
                    $bscity,
                    $bsmunicipality,
                    $bsindustry,
                    $bsname,
                    $aoe,
                    $doc_status,
                    $id_bspermit
                ]);

                echo '
                    <dialog class="message-popup success" >
                        <div class="pop-up">
                            <div class="left-side">
                                <div class="left-side-wrapper"><i class="bx bxs-x-circle error-circle"></i></div>
                            </div>
                            <div class="right-side">
                                <div class="right-group">
                                <div class="content">
                                    <h1>Updated Successfully!</h1>
                                </div>
                                <button onclick="closeDialog()" onclick="closeDialog()" class="exit-btn">X</button>
                                </div>
                            </div>
                        </div>
                    </dialog>
                ';

            }
            catch (PDOException $e) {
                echo '
                    <dialog class="message-popup success" >
                        <div class="pop-up">
                            <div class="left-side">
                                <div class="left-side-wrapper"><i class="bx bxs-x-circle error-circle"></i></div>
                            </div>
                            <div class="right-side">
                                <div class="right-group">
                                <div class="content">
                                    <h1>'.$e->getMessage().'</h1>
                                </div>
                                <button onclick="closeDialog()" onclick="closeDialog()" class="exit-btn">X</button>
                                </div>
                            </div>
                        </div>
                    </dialog>
                ';
                
            }
        }
    }

    public function view_archive_bspermit(){
        if (isset($_POST['archive_bspermit'])) {
            $id_bspermit = $_POST['id_bspermit'];
            $id = $_POST['id'];
            $doc_status = 'archived';
    
            $connection = $this->openConn();
    
            $stmt = $connection->prepare('UPDATE tbl_bspermit SET doc_status = ? WHERE id_bspermit = ?');
            $stmt->execute([$doc_status, $id_bspermit]);

            $toast = '
            <body>
                <div class="toast">
                    <div class="toast-content">
                        <i class="fas fa-solid fa-check check"></i>
                        <div class="message">
                            <span class="text text-1">Success</span>
                            <span class="text text-2">The request has been archived successfully</span>
                        </div>
                    </div>
                    <i class="fa-solid fa-xmark close" onclick="closeToast()"></i>
                    <div class="progress"></div>
                </div>
            </body>';
        
            $_SESSION['toast'] = $toast;
    
            echo '
                <script>
                    window.opener.location.href = window.opener.location.href;                
                    window.close();
                </script>
            ';
        }
    }
    
    public function view_unarchive_bspermit(){
        if (isset($_POST['unarchive_bspermit'])) {
            $id_bspermit = $_POST['id_bspermit'];
            $id = $_POST['id'];
            $doc_status = 'accepted';
    
            $connection = $this->openConn();
    
            $stmt = $connection->prepare('UPDATE tbl_bspermit SET doc_status = ? WHERE id_bspermit = ?');
            $stmt->execute([$doc_status, $id_bspermit]);

            $toast = '
            <body>
                <div class="toast">
                    <div class="toast-content">
                        <i class="fas fa-solid fa-check check"></i>
                        <div class="message">
                            <span class="text text-1">Success</span>
                            <span class="text text-2">The request has been retrieved successfully</span>
                        </div>
                    </div>
                    <i class="fa-solid fa-xmark close" onclick="closeToast()"></i>
                    <div class="progress"></div>
                </div>
            </body>';
        
            $_SESSION['toast'] = $toast;
    
    
            echo '
                <script>
                    window.opener.location.href = window.opener.location.href;
                    window.close();
                </script>
            ';
        }
    }



    public function archive_bspermit() {
        if (isset($_POST['archive_selected_bspermit']) && isset($_POST['ids_to_archive'])) {
            $idsToArchive = explode(',', $_POST['ids_to_archive']);
            $id = $_POST['id'];
            $doc_status = 'archived';
            
            $connection = $this->openConn();
    
            try {
                $connection->beginTransaction();
    
                foreach ($idsToArchive as $idBsPermit) {
                    $insertStmt = $connection->prepare("
                       UPDATE tbl_bspermit SET created_by = :created_by, doc_status = :doc_status WHERE id_bspermit = :id_bspermit
                    ");

                    $insertStmt->bindParam(':doc_status', $doc_status);
                    $insertStmt->bindParam(':created_by', $id);
                    $insertStmt->bindParam(':id_bspermit', $idBsPermit);
                    $insertStmt->execute();
                }
    
                $connection->commit();
    
                // Set a success message
                $toast = '
                <body>
                    <div class="toast">
                        <div class="toast-content">
                            <i class="fas fa-solid fa-check check"></i>
                            <div class="message">
                                <span class="text text-1">Success</span>
                                <span class="text text-2">The request has been archived successfully</span>
                            </div>
                        </div>
                        <i class="fa-solid fa-xmark close" onclick="closeToast()"></i>
                        <div class="progress"></div>
                    </div>
                </body>';
            
                $_SESSION['toast'] = $toast;
    
                // Refresh the page to clear form resubmission
                header("Location: admn_bspermit.php?list=active");
                exit();
    
            } catch (Throwable $e) {
                $connection->rollBack();
                $toast = '
                <div class="toast" style = "border-left: 6px solid #D32F2F;">
                    <div class="toast-content">
                        <i class="fas fa-exclamation-triangle check" style = "background-color: #D32F2F;"></i>
                        <div class="message">
                            <span class="text text-1">Error</span>
                            <span class="text text-2">An unexpected error occurred while processing your request</span>
                        </div>
                    </div>
                    <i class="fa-solid fa-xmark close close-error"  onclick="closeToast()"></i>
                    <div class="progress progress-error"></div>
                </div>
        ';
        $_SESSION['toast'] = $toast;
        header("Location: admn_bspermit.php?list=active");
        exit();
            }
        }
}


    public function unarchive_bspermit() {
        if (isset($_POST['retrieve_selected_bspermit']) && isset($_POST['ids_to_retrieve'])) {
            $idsToRetrieve = explode(',', $_POST['ids_to_retrieve']);
            $id = $_POST['id'];
            $doc_status = 'accepted';
            
    
            $connection = $this->openConn();
    
            try {
                $connection->beginTransaction();
    
                foreach ($idsToRetrieve as $idBsPermit) {
                    $insertStmt = $connection->prepare("
                        UPDATE tbl_bspermit SET created_by = :created_by, doc_status = :doc_status WHERE id_bspermit = :id_bspermit
                    ");
    
                    $insertStmt->bindParam(':created_by', $id);
                    $insertStmt->bindParam(':id_bspermit', $idBsPermit);
                    $insertStmt->bindParam(':doc_status', $doc_status);
                    $insertStmt->execute();
                }
    
                $connection->commit();
    
                // Set a success message
                $toast = '
                <body>
                    <div class="toast">
                        <div class="toast-content">
                            <i class="fas fa-solid fa-check check"></i>
                            <div class="message">
                                <span class="text text-1">Success</span>
                                <span class="text text-2">The request has been retrieved successfully</span>
                            </div>
                        </div>
                        <i class="fa-solid fa-xmark close" onclick="closeToast()"></i>
                        <div class="progress"></div>
                    </div>
                </body>';
            
                $_SESSION['toast'] = $toast;
    
                // Refresh the page to clear form resubmission
                header("Location: admn_bspermit.php?list=archived");
                exit();
    
            } catch (Throwable $e) {
                $connection->rollBack();
                $toast = '
                <div class="toast" style = "border-left: 6px solid #D32F2F;">
                    <div class="toast-content">
                        <i class="fas fa-exclamation-triangle check" style = "background-color: #D32F2F;"></i>
                        <div class="message">
                            <span class="text text-1">Error</span>
                            <span class="text text-2">An unexpected error occurred while processing your request</span>
                        </div>
                    </div>
                    <i class="fa-solid fa-xmark close close-error"  onclick="closeToast()"></i>
                    <div class="progress progress-error"></div>
                </div>
        ';
        $_SESSION['toast'] = $toast;
        header("Location: admn_bspermit.php?list=archived");
        exit();
            }
        }
    }


  //------------------------------------------ BRGY ID CRUD -----------------------------------------------

  public function get_latest_brgyid($id) {
    $connection = $this->openConn();            

    $stmt = $connection->prepare('
        SELECT * FROM tbl_brgyid WHERE created_by = ? ORDER BY created_on DESC LIMIT 1
    ');
    $stmt->execute([$id]);

    $latestRecord = $stmt->fetch();
    return $latestRecord;
}


    public function create_brgyid() {

        if(isset($_POST['create_brgyid'])) {
            $res_photo = file_get_contents($_FILES['res_photo']['tmp_name']);
            $fname = $_POST['fname'];
            $suffix = $_POST['suffix'];
            $mi = $_POST['mi']; 
            $lname = $_POST['lname'];
            $houseno = $_POST['houseno'];
            $street = $_POST['street'];
            $brgy = $_POST['brgy'];
            $city = $_POST['city'];
            $municipality = $_POST['municipality'];
            $bdate = $_POST['bdate'];
            $status = $_POST['status'];
            $precint_no = $_POST['precint_no'];
            $inc_lname = $_POST['inc_lname']; 
            $inc_fname = $_POST['inc_fname'];
            $inc_mi = $_POST['inc_mi'];
            $inc_contact = $_POST['inc_contact'];
            $inc_houseno = $_POST['inc_houseno'];
            $inc_street = $_POST['inc_street'];
            $inc_brgy = $_POST['inc_brgy'];
            $inc_city = $_POST['inc_city'];
            $inc_municipality = $_POST['inc_municipality'];
            $created_by = $_POST['created_by'];

            $connection = $this->openConn();

            $stmt = $connection->prepare('
                INSERT INTO tbl_brgyid(res_photo, fname, mi, lname, suffix, houseno, street, brgy, city, municipality, bdate, status, precint_no, inc_lname, inc_fname, inc_mi, inc_contact, inc_houseno, inc_street, inc_brgy, inc_city, inc_municipality, created_by)
                 VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ');
            
            $stmt->execute([
                $res_photo,
                $fname, 
                $mi,
                $lname, $suffix,
                $houseno,
                $street,
                $brgy,
                $city,
                $municipality,
                $bdate,
                $status,
                $precint_no,
                $inc_lname, 
                $inc_fname,
                $inc_mi,
                $inc_contact,
                $inc_houseno,
                $inc_street,
                $inc_brgy,
                $inc_city,
                $inc_municipality,
                $created_by
            ]);

            $residentId = $this->get_latest_brgyid($created_by);
            $qrCode = $this->generateQRCode($residentId['id_brgyid'], 'brgyid');

            echo '

                                  <div id="qr" class="overlay-qr">
        <div class="popup-qr">
          <h3>Your QR Code has been generated!</h3>
<p>Download or take a screenshot of it, and bring it to the barangay hall along with the required documents to claim your certificate.</p>

<p class = "qrid">BGID - ' .strtoupper($lname). ' - ' .$residentId['id_brgyid']. '</p>

<img src="' . $qrCode . '" alt="QR Code" />

                <a href="' . $qrCode . '" download="qr_code_certofindigency.png">
                    <button type="button" class ="btn-dl-qr">Download QR Code</button>
                </a>

            <button class="btn-close-qr" onclick="closeModal()">Close</button>
        </div>
    </div>
            ';
        
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

    public function get_single_brgyid(){
        $id_brgyid = $_GET['id_brgyid'];
        $status = isset($_GET['status']) ? $_GET['status'] : 'accepted' ;
        
        $connection = $this->openConn();

        $stmt = $connection->prepare("SELECT 
            *,
            DATE_FORMAT(STR_TO_DATE(valid_until, '%Y-%m-%d'), '%m-%d-%Y') AS `valid_date`
            FROM tbl_brgyid 
            WHERE doc_status = ? AND id_brgyid = ?");

       if ($status === 'archived') {
            $stmt = $connection->prepare("SELECT 
                *,
                DATE_FORMAT(STR_TO_DATE(valid_until, '%Y-%m-%d'), '%m-%d-%Y') AS `valid_date`
                FROM tbl_brgyid
                WHERE doc_status = ? AND id_brgyid = ?");
        }
        
        $stmt->execute([$status, $id_brgyid]);
        $brgyid = $stmt->fetch();
        $total = $stmt->rowCount();

        if($total > 0 )  {
            return $brgyid;
        } else {
            return false;
        }
    }


    public function view_archive_brgyid(){
        if (isset($_POST['archive_brgyid'])) {
            $id_brgyid = $_POST['id_brgyid'];
            $id = $_POST['id'];
            $doc_status = 'archived';
    
            $connection = $this->openConn();
    
            $stmt = $connection->prepare('UPDATE tbl_brgyid SET doc_status = ? WHERE id_brgyid = ?');
            $stmt->execute([$doc_status, $id_brgyid]);

            $toast = '
            <body>
                <div class="toast">
                    <div class="toast-content">
                        <i class="fas fa-solid fa-check check"></i>
                        <div class="message">
                            <span class="text text-1">Success</span>
                            <span class="text text-2">The request has been archived successfully</span>
                        </div>
                    </div>
                    <i class="fa-solid fa-xmark close" onclick="closeToast()"></i>
                    <div class="progress"></div>
                </div>
            </body>';
        
            $_SESSION['toast'] = $toast;
    
            echo '
                <script>
                    window.opener.location.href = window.opener.location.href;                
                    window.close();
                </script>
            ';
        }
    }
    
    public function view_unarchive_brgyid(){
        if (isset($_POST['unarchive_brgyid'])) {
            $id_brgyid = $_POST['id_brgyid'];
            $id = $_POST['id'];
            $doc_status = 'accepted';
    
            $connection = $this->openConn();
    
            $stmt = $connection->prepare('UPDATE tbl_brgyid SET doc_status = ? WHERE id_brgyid = ?');
            $stmt->execute([$doc_status, $id_brgyid]);

            $toast = '
            <body>
                <div class="toast">
                    <div class="toast-content">
                        <i class="fas fa-solid fa-check check"></i>
                        <div class="message">
                            <span class="text text-1">Success</span>
                            <span class="text text-2">The request has been retrieved successfully</span>
                        </div>
                    </div>
                    <i class="fa-solid fa-xmark close" onclick="closeToast()"></i>
                    <div class="progress"></div>
                </div>
            </body>';
        
            $_SESSION['toast'] = $toast;
    
            echo '
                <script>
                    window.opener.location.href = window.opener.location.href;
                    window.close();
                </script>
            ';
        }
    }


    public function archive_brgyid() {
        if (isset($_POST['archive_selected_brgyid']) && isset($_POST['ids_to_archive'])) {
            $idsToArchive = explode(',', $_POST['ids_to_archive']);
            $id = $_POST['id'];
            $doc_status = 'archived';
            
            $connection = $this->openConn();
    
            try {
                $connection->beginTransaction();
    
                foreach ($idsToArchive as $idBrgyid) {
                    $insertStmt = $connection->prepare("
                       UPDATE tbl_brgyid SET created_by = :created_by, doc_status = :doc_status WHERE id_brgyid = :id_brgyid
                    ");

                    $insertStmt->bindParam(':doc_status', $doc_status);
                    $insertStmt->bindParam(':created_by', $id);
                    $insertStmt->bindParam(':id_brgyid', $idBrgyid);
                    $insertStmt->execute();
                }
    
                $connection->commit();
    
                // Set a success message
                $toast = '
                <body>
                    <div class="toast">
                        <div class="toast-content">
                            <i class="fas fa-solid fa-check check"></i>
                            <div class="message">
                                <span class="text text-1">Success</span>
                                <span class="text text-2">The request has been archived successfully</span>
                            </div>
                        </div>
                        <i class="fa-solid fa-xmark close" onclick="closeToast()"></i>
                        <div class="progress"></div>
                    </div>
                </body>';
            
                $_SESSION['toast'] = $toast;
    
                // Refresh the page to clear form resubmission
                header("Location: admn_brgyid.php?list=active");
                exit();
    
            } catch (Throwable $e) {
                $connection->rollBack();
                $toast = '
                <div class="toast" style = "border-left: 6px solid #D32F2F;">
                    <div class="toast-content">
                        <i class="fas fa-exclamation-triangle check" style = "background-color: #D32F2F;"></i>
                        <div class="message">
                            <span class="text text-1">Error</span>
                            <span class="text text-2">An unexpected error occurred while processing your request</span>
                        </div>
                    </div>
                    <i class="fa-solid fa-xmark close close-error"  onclick="closeToast()"></i>
                    <div class="progress progress-error"></div>
                </div>
        ';
        $_SESSION['toast'] = $toast;
        header("Location: admn_brgyid.php?list=active");
        exit();
            }
        }
}

    public function unarchive_brgyid() {
        if (isset($_POST['retrieve_selected_brgyid']) && isset($_POST['ids_to_retrieve'])) {
            $idsToRetrieve = explode(',', $_POST['ids_to_retrieve']);
            $id = $_POST['id'];
            $doc_status = 'accepted';
            
    
            $connection = $this->openConn();
    
            try {
                $connection->beginTransaction();
    
                foreach ($idsToRetrieve as $idBrgyid) {
                    $insertStmt = $connection->prepare("
                        UPDATE tbl_brgyid SET created_by = :created_by, doc_status = :doc_status WHERE id_brgyid = :id_brgyid
                    ");
    
                    $insertStmt->bindParam(':created_by', $id);
                    $insertStmt->bindParam(':id_brgyid', $idBrgyid);
                    $insertStmt->bindParam(':doc_status', $doc_status);
                    $insertStmt->execute();
                }
    
                $connection->commit();
    
                // Set a success message
                $toast = '
                <body>
                    <div class="toast">
                        <div class="toast-content">
                            <i class="fas fa-solid fa-check check"></i>
                            <div class="message">
                                <span class="text text-1">Success</span>
                                <span class="text text-2">The request has been retrieved successfully</span>
                            </div>
                        </div>
                        <i class="fa-solid fa-xmark close" onclick="closeToast()"></i>
                        <div class="progress"></div>
                    </div>
                </body>';
            
                $_SESSION['toast'] = $toast;
    
                // Refresh the page to clear form resubmission
                header("Location: admn_brgyid.php?list=archived");
                exit();
    
            } catch (Throwable $e) {
                $connection->rollBack();
                $toast = '
                <div class="toast" style = "border-left: 6px solid #D32F2F;">
                    <div class="toast-content">
                        <i class="fas fa-exclamation-triangle check" style = "background-color: #D32F2F;"></i>
                        <div class="message">
                            <span class="text text-1">Error</span>
                            <span class="text text-2">An unexpected error occurred while processing your request</span>
                        </div>
                    </div>
                    <i class="fa-solid fa-xmark close close-error"  onclick="closeToast()"></i>
                    <div class="progress progress-error"></div>
                </div>
        ';
        $_SESSION['toast'] = $toast;
        header("Location: admn_brgyid.php?list=archived");
        exit();
            }
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
        if (isset($_POST['update_brgyid'])) {
            $res_photo = $_POST['res_photo'];
            $id_brgyid = $_GET['id_brgyid'];
            $fname = $_POST['fname'];
            $suffix = $_POST['suffix'];
            $mi = $_POST['mi']; 
            $lname = $_POST['lname'];
            $houseno = $_POST['houseno'];
            $street = $_POST['street'];
            $brgy = $_POST['brgy'];
            $city = $_POST['city'];
            $municipality = $_POST['municipality'];
            $status = $_POST['status'];
            $precint_no = $_POST['precint_no'];
            $inc_lname = $_POST['inc_lname']; 
            $inc_fname = $_POST['inc_fname'];
            $inc_mi = $_POST['inc_mi'];
            $inc_contact = $_POST['inc_contact'];
            $inc_houseno = $_POST['inc_houseno'];
            $inc_street = $_POST['inc_street'];
            $inc_brgy = $_POST['inc_brgy'];
            $inc_city = $_POST['inc_city'];
            $inc_municipality = $_POST['inc_municipality'];
            $doc_status = 'accepted';

            if (preg_match('/^data:image\/(\w+);base64,/', $res_photo, $matches)) {
                $imageData = substr($res_photo, strpos($res_photo, ',') + 1);
                $imageData = base64_decode($imageData);
            }

            try {                
                $connection = $this->openConn();
                $stmt = $connection->prepare("UPDATE tbl_brgyid SET 
                    res_photo = ?,
                    fname = ?,
                    mi = ?, 
                    lname = ?,
                    houseno = ?,
                    street = ?,
                    brgy = ?,
                    city = ?,
                    municipality = ?,
                    `status` = ?,
                    precint_no = ?,
                    inc_lname = ?, 
                    inc_fname = ?,
                    inc_mi = ?,
                    inc_contact = ?,
                    inc_houseno = ?,
                    inc_street = ?,
                    inc_brgy = ?,
                    inc_city = ?,
                    inc_municipality = ?,
                    doc_status = ?
                    WHERE
                    id_brgyid = ?
                ");

                $stmt->execute([
                    $imageData,
                    $fname,
                    $mi, 
                    $lname, $suffix,
                    $houseno,
                    $street,
                    $brgy,
                    $city,
                    $municipality,
                    $status,
                    $precint_no,
                    $inc_lname, 
                    $inc_fname,
                    $inc_mi,
                    $inc_contact,
                    $inc_houseno,
                    $inc_street,
                    $inc_brgy,
                    $inc_city,
                    $inc_municipality,
                    $doc_status,
                    $id_brgyid
                ]);

                echo json_encode([
                    'message' => 'Updated Successfully!'
                ]);
                exit();

            }
            catch (PDOException $e) {

                echo json_encode([
                    'message' => $e->getMessage()
                ]);
                exit();
            }
        }
    }

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
        } else if ($userdetails && $userdetails['role'] === "staff") { 
            header("Location: staff_dashboard.php");
            exit();
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
    
        if ($userdetails['role'] === "administrator" || $userdetails['role'] === "staff") {
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


    // function sendEmailWithQRCode($qrImage, $id_resident) {
    //     $conn = $this->openConn();
    //         // Fetch the recipient email from the database based on recipient ID
    //     $query = "SELECT email FROM tbl_resident WHERE id_resident = ?";
    //     $stmt = $conn->prepare($query);
    //     $stmt->execute([$id_resident]);

    //     // Check if email was found
    //     if ($row = $stmt->fetch()) {
    //         $recipientEmail = $row['email'];
    //     } else {
    //         echo "<script>alert('Error: No email found for this ID.')</script>";
    //         return; // Stop further execution if email is missing
    //     }


    //     $mail = new PHPMailer(true);
    //     try {
    //         // SMTP server configuration
    //         $mail->isSMTP();
    //         $mail->Host = 'smtp.mailersend.net';  // Set your SMTP server
    //         $mail->SMTPAuth = true;
    //         $mail->Username = 'MS_aEACuu@trial-0p7kx4xjwevl9yjr.mlsender.net'; // Your SMTP username
    //         $mail->Password = 'ZsOeSK3qqlPGnXj7'; // Your SMTP password or app password
    //         $mail->SMTPSecure = 'tls';
    //         $mail->Port = 587;
    
    //         // Email details
    //         $mail->setFrom('MS_aEACuu@trial-0p7kx4xjwevl9yjr.mlsender.net', 'Brgy. Sinalhan');
    //         $mail->addAddress($recipientEmail);
    //         $mail->isHTML(true);
    //         $mail->Subject = "Your QR Code";
    
    //         // Attach QR Code as an image
    //         $mail->Body = "Here is your QR code!";
    //         $mail->addStringAttachment($qrImage, 'qrcode.png', 'base64', 'image/png');
    
    //         $mail->send();
    //         echo "Email sent successfully.";
    //     } catch (Exception $e) {
    //         echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    //     }
    // }


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


    public function convertToImg($dataImg) {
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->buffer($dataImg); 

        $dataImgEncode = base64_encode($dataImg);

        if ($dataImg !== null) {
            echo "<img id='res_photo' style='width: 100px; height: 100px; object-fit: cover;' src='data:{$mimeType};base64,{$dataImgEncode}' alt='profile_photo'>";
        } else {
            echo "<img id='res_photo' style='width: 100px; height: 100px; object-fit: cover;' src='assets/default.png' alt='profile_photo'>";
        }
    }

    public function convertToJSON($dataImg) {
        $dataImg = base64_encode($dataImg);

        
    }

    // -------------------------- DOCUMENTS EXTRA FUNCTIONS ----------------------

    public function count_rescert() {
        $connection = $this->openConn();

        $stmt = $connection->prepare("SELECT COUNT(*) from tbl_rescert WHERE doc_status = ?");
        $doc_status = 'accepted';
        $stmt->execute([$doc_status]);
        $rescertcount = $stmt->fetchColumn();

        return $rescertcount;
    }

    public function count_indigency() {
        $connection = $this->openConn();

        $stmt = $connection->prepare("SELECT COUNT(*) from tbl_indigency WHERE doc_status = ?");
        $doc_status = 'accepted';
        $stmt->execute([$doc_status]);
        $indigencycount = $stmt->fetchColumn();

        return $indigencycount;
    }

    public function count_clearance() {
        $connection = $this->openConn();

        $stmt = $connection->prepare("SELECT COUNT(*) from tbl_clearance WHERE doc_status = ?");
        $doc_status = 'accepted';
        $stmt->execute([$doc_status]);
        $clearancecount = $stmt->fetchColumn();

        return $clearancecount;
    }

    public function count_bspermit() {
        $connection = $this->openConn();

        $stmt = $connection->prepare("SELECT COUNT(*) from tbl_bspermit WHERE doc_status = ?");
        $doc_status = 'accepted';
        $stmt->execute([$doc_status]);
        $bspermitcount = $stmt->fetchColumn();

        return $bspermitcount;
    }

    public function count_brgyid() {
        $connection = $this->openConn();

        $stmt = $connection->prepare("SELECT COUNT(*) from tbl_brgyid WHERE doc_status = ?");
        $doc_status = 'accepted';
        $stmt->execute([$doc_status]);
        $brgyidcount = $stmt->fetchColumn();

        return $brgyidcount;
    }


    public function count_total_day() {
        $connection = $this->openConn();

        $stmt = $connection->prepare("
            SELECT COUNT(*) 
            FROM (
                SELECT id_rescert AS id FROM tbl_rescert WHERE doc_status = 'archived' AND MONTH(created_on) = MONTH(CURDATE()) AND YEAR(created_on) = YEAR(CURDATE())
                UNION ALL
                SELECT id_bspermit AS id FROM tbl_bspermit WHERE doc_status = 'archived' AND MONTH(created_on) = MONTH(CURDATE()) AND YEAR(created_on) = YEAR(CURDATE())
                UNION ALL
                SELECT id_clearance AS id FROM tbl_clearance WHERE doc_status = 'archived' AND MONTH(created_on) = MONTH(CURDATE()) AND YEAR(created_on) = YEAR(CURDATE())
                UNION ALL
                SELECT id_indigency AS id FROM tbl_indigency WHERE doc_status = 'archived' AND MONTH(created_on) = MONTH(CURDATE()) AND YEAR(created_on) = YEAR(CURDATE())
                UNION ALL
                SELECT id_brgyid AS id FROM tbl_brgyid WHERE doc_status = 'archived' AND MONTH(created_on) = MONTH(CURDATE()) AND YEAR(created_on) = YEAR(CURDATE())
            ) AS combined_counts
        ");
        $stmt->execute();
        $totalCount = $stmt->fetchColumn();

        return $totalCount;
    }

    public function count_documents_issued_in_month($startDate, $endDate) {
        // Open the database connection
        $doc_status = 'archived';

        $connection = $this->openConn(); 
    
        // SQL query to count documents across multiple tables for the given date range
        $query = "
        SELECT 
            SUM(document_count) AS total_documents
        FROM (
            SELECT 
                COUNT(*) AS document_count
            FROM 
                tbl_indigency
            WHERE 
                doc_status = :doc_status AND
                DATE(created_on) BETWEEN :start_date AND :end_date
    
            UNION ALL
    
            SELECT 
                COUNT(*) AS document_count
            FROM 
                tbl_rescert
            WHERE 
                doc_status = :doc_status AND
                DATE(created_on) BETWEEN :start_date AND :end_date
    
            UNION ALL
    
            SELECT 
                COUNT(*) AS document_count
            FROM 
                tbl_brgyid
            WHERE 
                doc_status = :doc_status AND
                DATE(created_on) BETWEEN :start_date AND :end_date
    
            UNION ALL
    
            SELECT 
                COUNT(*) AS document_count
            FROM 
                tbl_bspermit
            WHERE 
                doc_status = :doc_status AND
                DATE(created_on) BETWEEN :start_date AND :end_date
    
            UNION ALL
    
            SELECT 
                COUNT(*) AS document_count
            FROM 
                tbl_clearance
            WHERE 
                doc_status = :doc_status AND
                DATE(created_on) BETWEEN :start_date AND :end_date
        ) AS combined_counts;
        ";
    
        // Prepare the query
        $stmt = $connection->prepare($query);
    
        // Bind the start and end date parameters
        $stmt->bindParam(':doc_status', $doc_status, PDO::PARAM_STR);
        $stmt->bindParam(':start_date', $startDate, PDO::PARAM_STR);
        $stmt->bindParam(':end_date', $endDate, PDO::PARAM_STR);
    
        // Execute the query
        $stmt->execute();
    
        // Fetch the result
        $result = $stmt->fetch();
    
        // Return the total document count (or 0 if no rows found)
        return $result['total_documents'] ?? 0;
    }

    // -------------------------- DASHBOARD GENERATION REPORT ----------------------


    public function daily_rescert_list() {
        $conn = $this->openConn();
        $stmt = $conn->prepare("SELECT * FROM tbl_rescert WHERE doc_status = 'archived' AND DATE(created_on) = CURDATE()");
        $stmt->execute();
        $rescertList = $stmt->fetchAll();
        return $rescertList;
    }

    public function daily_indigency_list() {
        $conn = $this->openConn();
        $stmt = $conn->prepare("SELECT * FROM tbl_indigency WHERE doc_status = 'archived' AND DATE(created_on) = CURDATE()");
        $stmt->execute();
        $indigencyList = $stmt->fetchAll();
        return $indigencyList;
    }

    public function daily_clearance_list() {
        $conn = $this->openConn();
        $stmt = $conn->prepare("SELECT * FROM tbl_clearance WHERE doc_status = 'archived' AND DATE(created_on) = CURDATE()");
        $stmt->execute();
        $clearanceList = $stmt->fetchAll();
        return $clearanceList;
    }

    public function daily_bspermit_list() {
        $conn = $this->openConn();
        $stmt = $conn->prepare("SELECT * FROM tbl_bspermit WHERE doc_status = 'archived' AND DATE(created_on) = CURDATE()");
        $stmt->execute();
        $bspermitList = $stmt->fetchAll();
        return $bspermitList;
    }

    public function daily_brgyid_list() {
        $conn = $this->openConn();
        $stmt = $conn->prepare("SELECT * FROM tbl_brgyid WHERE doc_status = 'archived' AND DATE(created_on) = CURDATE()");
        $stmt->execute();
        $brgyidList = $stmt->fetchAll();
        return $brgyidList;
    }
}
    

$bmis = new BMISClass(); //variable to call outside of its class

?>
