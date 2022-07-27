 <?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    session_start();

    function getPDOObject()
    {
        $user = 'root';
        $pass = '';
        $pdo = new PDO("mysql:host=localhost;dbname=techvilla", $user, $pass);
        if (!$pdo) {
            echo "Not connected";
        }
        return $pdo;
    }

    // function for to check session variable
    function check_session()
    {
        if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
            header('location:login.php');
            die();
        }
    }
 
    // function for to check login credentials
    function user_login()
    {
        extract($_POST);
        $pdo = getPDOObject();
        // echo '<pre>';
        // print_r($_POST);
        // die();
        //require_once('function/function.php');

        if (empty($email) or empty($password)) {
            $msg = '<div class="alert alert-danger">User id and Password required !</div>';
        } else {
            $sql = "select id,fname,lname,email,pass,astatus,deleted from employee where email=? and deleted='0' limit 1 ";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$email]);
            $rows = $stmt->rowCount();
            // echo $rows;
            // die();
            if ($rows>0) {
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                // echo '<pre>';
                // print_r($data);
                // die();
                if (password_verify($password, $data['pass'])) {
                    
                    $_SESSION['user_id'] = $data['id'];
                    $_SESSION['user_name']  = $data['fname'];

                    if (isset($_SESSION['user_id'])) {
            
                        header('location:add_employee.php');
                        //die();
                    } else {
                
                        $msg = "<div> something went wrong </div>";
                    }
                } else {
                   
                    $msg = '<div class="alert alert-danger">Invalid credential</div>';
                }
            } else {
                $msg = '<div class="alert alert-danger">Invalid credential</div>';
            }
        }
        return $msg;
    }

    ?> 



 