<?php
$skill_str = "";
$qual_str = "";

require_once('function/function.php');
check_session();
$pdo=getPDOObject();

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  if (!is_numeric($id)) {
    header("location:list-employee.php");
  }
  //  echo "<pre>";
  //  echo $id;
  //  die;

  $sql = "SELECT * from employee where id=? LIMIT 1";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$id]);
  $data = $stmt->fetch(PDO::FETCH_ASSOC);

  $qual = $data['qualification'];
  $qual_arr = explode(',', $qual);

  
  // echo "<pre>";
  // print_r($data);
  // print_r($data['position']);
  // die;


  $rowCnt = $stmt->rowCount();
  if (!$rowCnt) {
    header("location:list-employee.php");
  }
  
}

// Query for update data
if(isset($_POST['update'])){
  $date=date("Y-m-d h:i:sa");
  extract($_POST); // extract converted keys into variable
//    echo '<pre>';
//    echo $date;
//  print_r($_POST); 
  $skill_str1 = implode(",", $_POST['Skills']);  // changes array into string
  $qual_str1 = implode(",", $_POST['qualification']);  // changes array into string
  // echo $skil_str1;
  // echo $qual_str1;

  $sql="update employee SET fname=?, lname=?, email=?, phone=?, dob=?, address=?, position=?, qualification=?, skills=?, doj=?, salary=?, gender=?, marital_status=?,updated_on=? where id=?";
  $stmt=$pdo->prepare($sql);
  $stmt->execute([$fname,$lname,$email,$phone,$dob,$address,$position,$qual_str1,$skill_str1,$doj,$salary,$gender,$marital_status,$date,$id]);
  if($stmt){
    header("location:list-employee.php");
  }
  echo "Something went wrong";
 
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
   
      <h5 class="card-header text-center">Edit Employee &nbsp; &nbsp;
        <a href="list-employee.php"><button class="btn btn-sm btn-primary">View</button></a> 
        <a href="list-employee.php"><button class="btn btn-sm btn-info">Go back to previous page</button></a>
    &nbsp; &nbsp;
      </h5>


      <div class="card-body">
        <form method="POST">

          <div class="row mt-3">
            <div class="col">
              <label class="form-label">First Name: </label>
              <input type="text" name="fname" class="form-control" placeholder="Enter First name" value="<?= $data["fname"]; ?>" tabindex="1">
            </div>
            <div class="col">
              <label for="last_name" class="form-label">Last Name:</label>
              <input type="text" name="lname" class="form-control" placeholder=" Enter Last name" value="<?= $data["lname"]; ?>" tabindex="2">
            </div>
          </div>

          <div class="row mt-3">
            <div class="col">
              <label for="email" class="form-label">Email:</label>
              <input type="email" name="email" class="form-control" placeholder="Enter email" value="<?= $data["email"]; ?>" tabindex="3">
            </div>
            <div class="col">
              <label for="phone" class="form-label">Phone number:</label>
              <input type="text" name="phone" pattern="[0-9]+" title="only numbers are allowed" maxlength="10" minlength="10" value="<?= $data["phone"]; ?>" class="form-control" placeholder="Enter Phone number" tabindex="4">
            </div>
          </div>



          <div class="row mt-3">
            <div class="col">
              <label for="dob" class="form-label">DOB:</label>
              <input type="date" name="dob" class="form-control" value="<?= $data["dob"]; ?>" placeholder="Enter DOB" tabindex="4">
            </div>
            <div class="col">
              <label for="address" class="form-label">Address:</label>
              <input type="text area" name="address" class="form-control" value="<?= $data["address"]; ?>" placeholder="Enter address" tabindex="5">
            </div>
          </div>

          <div class="row mt-3">
            <div class="col">
              <label for="position" class="form-label">Position:</label>
              <select name="position" tabindex="6" class="form-control">
                <option value="">--Please Select--</option>
                <option value="fresher" <?php if ($data['position'] =='fresher') {echo 'selected';}?>>Fresher</option>
                <option value="developer" <?php if ($data['position'] =='developer'){echo 'selected';}?>>Developer</option>
                <option value="team leader" <?php if ($data['position'] =='team leader') {
                echo 'selected';}?>>Team Leader</option>
                <option value="manager" <?php if ($data['position'] =='manager') {echo 'selected';} ?>>manager</option>
              </select>
            </div>

            <div class="col">
              <label for="qualification" name="qualification" class="form-label">Qualification: </label>
              <input type="checkbox" name="qualification[]" value="MCA" <?php if (in_array("MCA", $qual_arr)) {echo 'checked';} ?>>MCA &nbsp;

              <input type="checkbox" name="qualification[]" value="BCA" <?php if (in_array('BCA', $qual_arr)) {echo 'checked';} ?>>BCA &nbsp;

              <input type="checkbox" name="qualification[]" value="BSC" <?php if (in_array('BSC', $qual_arr)) {echo 'checked';} ?>>BSC &nbsp;

              <input type="checkbox" name="qualification[]" value="BBA" <?php if (in_array('BBA', $qual_arr)) {echo 'checked';} ?>>BBA &nbsp;

              <input type="checkbox" name="qualification[]" value="MBA" <?php if (in_array('MBA', $qual_arr)) {echo 'checked';} ?>>MBA &nbsp;

            </div>
          </div>


          <div class="row mt-3">
            <div class="col">
              <label for="skills" name="Skills" class="form-label">Skills:</label>
              <input type="checkbox" name="Skills[]" value="JAVA" <?php
              if(in_array("JAVA",$skill_arr)) {echo 'checked';}?>>JAVA &nbsp;

              <input type="checkbox" name="Skills[]" value="HTML" <?php
              if(in_array("HTML",$skill_arr)) {echo 'checked';}?>>HTML &nbsp;

              <input type="checkbox" name="Skills[]" value="JAVA SCRIPT" <?php
              if(in_array("JAVA SCRIPT",$skill_arr)) {echo 'checked';}?>>JAVA SCRIPT &nbsp;

              <input type="checkbox" name="Skills[]" value="PHP" <?php
              if(in_array("PHP",$skill_arr)) {echo 'checked';}?>>PHP &nbsp;

              <input type="checkbox" name="Skills[]" value="ANGULAR" <?php
              if(in_array("ANGULAR",$skill_arr)) {echo 'checked';}?>>ANGULAR &nbsp;
            </div>
            <div class="col">
              <label for="doj" class="form-label">DOJ: </label>
              <input type="date" name="doj" value="<?= $data['doj'];?>" max="<?= date('Y-m-d') ?>" placeholder="Enter dob" class="form-control">
            </div>
          </div>

          <div class="row mt-3">
            <div class="col">
              <label for="salary" class="form-label">Salary: </label>
              <input type="text" name="salary" class="form-control" placeholder="Enter Salary"  value="<?= $data["salary"]; ?>" tabindex="">
            </div>

            <div class="col">
              <label for="gender" class="form-label">Gender:</label>
              <input type="radio" name="gender" value="M" <?php if($data['gender']=="M"){echo 'checked';}?>>Male
              <input type="radio" name="gender" value="F" <?php if($data['gender']=="F"){echo 'checked';}?>>Female
              <input type="radio" name="gender" value="T" <?php if($data['gender']=="T"){echo 'checked';}?> >Other
            </div>
          </div>


          <div class="row mt-3">
            <div class="col">
              <label for="mstatus" class="form-label">Marital status:</label><br>
              <input type="radio" id="mstatus" name="marital_status" value="Y" <?php if($data['marital_status']=='Y'){echo 'checked';}?>>YES
              <input type="radio" id="mstatus" name="marital_status" value="N" <?php if($data['marital_status']=='N'){echo 'checked';}?>>NO
            </div>

            

          </div>

          <div class="row mt-3">
            <div class="col">
            <button type="submit" class="btn btn-primary rounded-pill btn-lg px-5" name="update">update</button>
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