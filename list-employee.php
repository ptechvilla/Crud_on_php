<?php
require_once('function/function.php');
check_session();
$pdo=getPDOObject();

if (isset($_REQUEST['del_id'])) {
    $delId = $_REQUEST['del_id'];
    //echo $delId;
    $delquery = "delete from employee where id=?";
    $stmt = $pdo->prepare($delquery);
    $stmt->execute([$delId]);
    if ($stmt) {
        echo '<script type="text/javascript">';
        echo ' alert("record deleted successfully")'; 
        echo '</script>';
        header("location:list-employee.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>  
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List employee</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head> 

<body>
    <div class="container">
        <div class="card mt-5">
            <h5 class="card-header text-center">List Employee
            <a href="add_employee.php"><button class="btn btn-sm btn-info">Go back</button></a>&nbsp; &nbsp;
            </h5>

            <div card="card-body">
                <table class="table table-striped">
                    <thead >
                        <tr>
                            <th>id</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>DOB</th>
                            <th>gender</th>
                            <th>Address</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $query = "select id,fname,lname,email,phone,dob,gender,address,created_on from employee where astatus='1' AND deleted='0'";
                        $stmt = $pdo->prepare($query);
                        $stmt->execute();
                        // $data=$stmt->fetchAll(PDO::FETCH_ASSOC);
                        // echo '<pre>';
                        // print_r($data) ;
                        // echo '</pre>';
                        $cntRows = $stmt->rowCount();
                        $cnt = 1;
                        if ($cntRows) {
                            while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                                <tr>
                                    <td><?= $cnt++; ?></td>
                                    <td><?= $data['fname'] . "  " . $data['lname']; ?></td>
                                    <td><?= $data['email']; ?></td>
                                    <td><?= $data['phone']; ?></td>
                                    <td><?= $data['dob']; ?></td>
                                    <td><?=$data['gender'];?></td>
                                    <td><?= $data['address']; ?></td>
                                    <td>
                                        <i class="fa fa-eye"></i>&nbsp;/&nbsp;
                                        <a href="?del_id=<?= $data['id'] ?>"><i class="fa fa-trash"></i></a>&nbsp;/&nbsp;
                                        <a href="edit-employee.php?id=<?= $data['id'] ?>"><i class="fa fa-edit"></i></a>

                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo '<h4>No record found</h4>';
                        }
                        ?>


                    </tbody>

                </table>

            </div>
        </div>

    </div>


    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.min.js"></script>
</body>

</html> 