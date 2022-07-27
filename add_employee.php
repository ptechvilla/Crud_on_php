 <?php
 require_once('function/function.php');
 check_session();
$pdo=getPDOObject();
$skill_str = "";
$qual_str = "";
$valid_ext = array("jpg","jpeg","png","gif");
$validSize = 2*1024*1024;


if (isset($_POST['btn'])) {

  extract($_POST); // extract converted keys into variable
  // echo '<pre>';
// print_r($_POST); 
 $password=$_POST['pass'];
 $pass1=password_hash($password,PASSWORD_BCRYPT);

//echo $pass1;
  $skill_str = implode(",", $_POST['Skills']);  // changes array into string
  $qual_str = implode(",", $_POST['qualification']);  // changes array into string
  // echo '<pre>';
  // print_r($_POST);
  // echo '</pre>';
  // echo $skill_str;
  // echo $qual_str;

  if(isset($_FILES['images']['name'])){
    $fileName=$_FILES['images']['name'];
    $fileSize=$_FILES['images']['size'];
    $fileExt=pathinfo($fileName,PATHINFO_EXTENSION);
    $target_path="images/".$fileName;
    if(!in_array($fileExt,$valid_ext)){
      die("invalid file");
     }
     if($fileSize > $validSize){
     die("Not allowed file size is greator than 2*1024*1024");
     }else{
      if(!move_uploaded_file($_FILES['images']['tmp_name'],$target_path)){
        die("Error in file upload");
      }
     }
    // echo "fileName: ".$fileName;
    // ECHO '<BR>';
    // echo "fileExt: ".$fileExt;
    // echo '<br>';
    // echo "fileSize: ".$fileSize;
    // die();

  }


  // INSERT DATA INTO DATABASE
  $sql = "insert into employee(fname,lname,pass,email,phone,dob,address,position,qualification,skills,doj,salary,image,gender,marital_status) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$fname, $lname, $pass1, $email, $phone, $dob, $address, $position, $qual_str, $skill_str, $doj, $salary,$fileName, $gender, $marital_status]);
  if ($stmt) {
      
       header('location:list-employee.php');
    // echo '<script type="text/javascript">';
    // echo 'alert("record inserted successfully")'; 
    // echo '</script>';
  } else {
    echo '<script type="text/javascript">';
    echo 'alert("something went wrong")'; 
    echo '</script>';
  }


}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>

<body>
  <div class="container">
    <div class="card mt-4">
      <h5 class="card-header text-center">Add Employee &nbsp; &nbsp;
        <a href="list-employee.php"><button class="btn btn-sm btn-primary">View</button></a>&nbsp; &nbsp;
        <a href="logout.php"><button class="btn btn-sm btn-warning">Logout</button></a>
      </h5>


      <div class="card-body">
        <form method="POST" enctype="multipart/form-data">

          <div class="row mt-3">
            <div class="col">
              <label class="form-label">First Name: </label>
              <input type="text" name="fname" class="form-control" placeholder="Enter First name" tabindex="1">
            </div>
            <div class="col">
              <label for="last_name" class="form-label">Last Name:</label>
              <input type="text" name="lname" class="form-control" placeholder=" Enter Last name" tabindex="2">
            </div>
          </div>

          <div class="col">
               <label class="form-label">Password :</label>
               <input type="password" class="form-control" name="pass" placeholder="enter Password">

             </div>

          <div class="row mt-3">
            <div class="col">
              <label for="email" class="form-label">Email:</label>
              <input type="email" name="email" class="form-control" placeholder="Enter email" tabindex="3">
            </div>
            <div class="col">
              <label for="phone" class="form-label">Phone number:</label>
              <input type="text" name="phone" pattern="[0-9]+" title="only numbers are allowed" maxlength="10" minlength="10" class="form-control" placeholder="Enter Phone number" tabindex="4">
            </div>
          </div>



          <div class="row mt-3">
            <div class="col">
              <label for="dob" class="form-label">DOB:</label>
              <input type="date" name="dob" class="form-control" placeholder="Enter DOB" tabindex="4">
            </div>
            <div class="col">
              <label for="address" class="form-label">Address:</label>
              <input type="text area" name="address" class="form-control" placeholder="Enter address" tabindex="5">
            </div>
          </div>

          <div class="row mt-3">
            <div class="col">
              <label for="position" class="form-label">Position:</label>
              <select name="position" tabindex="6" class="form-control">
                <option value="">--Please Select--</option>
                <option value="fresher">Fresher</option>
                <option value="developer">Junior Developer</option>
                <option value="team leader">Team Leader</option>
                <option value="manager">manager</option>
              </select>
            </div>

            

            <div class="col">
              <label for="doj" class="form-label">DOJ: </label>
              <input type="date" name="doj" max="<?= date('Y-m-d') ?>" placeholder="Enter dob" class="form-control">
            </div>
          </div>
             

          <div class="row mt-3">
            <div class="col">
              <label for="salary" class="form-label">Salary: </label>
              <input type="text" name="salary" class="form-control" placeholder="Enter Salary" tabindex="">
            </div>
          
            <div class="col">
              <label>Pic:</label>
              <input type="file" name="images" placeholder="insert a file" class="form-control">
            </div>
          </div>

          <div class="row mt-3">
            <div class="col">
              <label for="skills" name="Skills" class="form-label">Skills:</label>
              <input type="checkbox" name="Skills[]" value="JAVA">JAVA &nbsp;
              <input type="checkbox" name="Skills[]" value="HTML">HTML &nbsp;
              <input type="checkbox" name="Skills[]" value="JAVA SCRIPT">JAVA SCRIPT &nbsp;
              <input type="checkbox" name="Skills[]" value="PHP">PHP &nbsp;
              <input type="checkbox" name="Skills[]" value="ANGULAR">ANGULAR &nbsp;
            </div>
           
            <div class="col">
              <label for="qualification" name="qualification" class="form-label">Qualification: </label>
              <input type="checkbox" name="qualification[]" value="MCA">MCA &nbsp;
              <input type="checkbox" name="qualification[]" value="BCA">BCA &nbsp;
              <input type="checkbox" name="qualification[]" value="BSC">BSC &nbsp;
              <input type="checkbox" name="qualification[]" value="BBA">BBA &nbsp;
              <input type="checkbox" name="qualification[]" value="MBA">MBA &nbsp;
            </div>
          </div>

         


          <div class="row mt-3">
            <div class="col">
              <label for="mstatus" class="form-label">Marital status:</label><br>
              <input class="form-check-input" type="radio" id="mstatus" name="marital_status" value="Y">YES
              <input class="form-check-input" type="radio" id="mstatus" name="marital_status" value="N">NO
             </div>
             <div class="col">
              <label for="gender" class="form-label">Gender:</label>
              <input type="radio" name="gender" value="M">Male
              <input type="radio" name="gender" value="F">Female
              <input type="radio" name="gender" value="T">Other
            </div>
          </div>

          <div class="row mt-3">
            <div class="col">
              <button type="submit" class="btn btn-primary rounded-pill btn-lg px-5" name="btn">Submit</button>
            </div>

          </div>

        </form>

      </div>
    </div>

  </div>

  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/jquery.min.js"></script>
</body>

</html> 

  