<?php
$title="MEDXAMINER";
include("header.php");
include("menu.php");
include("database.php");

if (isset($_POST["submit"])):
  #print_r($_FILES["image"]);
     $firstname=filter_input(INPUT_POST, 'firstname');
     if ($firstname===false || strlen(trim($firstname))===0 || $firstname===null){
			echo "<p class='error'>Empty </p";
			unset($firstname);
      exit();
     }
     $lastname=filter_input(INPUT_POST, 'lastname');
     if ($lastname===false || strlen(trim($lastname))===0 || $lastname===null){
			echo "<p class='error'>Empty </p>";
			unset($lastname);
      exit();
     }
     $username=filter_input(INPUT_POST, 'username');
     if ($username===false || strlen(trim($username))<5 || $username===null){
			echo "<p class='error'>Username can't be empty and should have at least 5 characters </p";
			unset($username);
      exit();
     }
     $password=filter_input(INPUT_POST, 'password');
     if ($password===false || strlen(trim($password))<5 || $password===null){
			echo "<p class='error'>Password can't be empty and should be longer than 5 characters </p";
			unset($password);
      exit();
     }
     $password1=filter_input(INPUT_POST, 'password1');
     if ($password1===false || strlen(trim($password1))<5 || $password1===null){
			echo "<p class='error'>Password can't be empty and should be longer than 5 characters </p";
      unset($password1);
      exit();
     }
     #$image=filter_input(INPUT_POST, 'image');
     $date=filter_input(INPUT_POST, 'date');
     $email=filter_input(INPUT_POST, 'email');
     if ($email===false || strlen(trim($email))===0 || $email===null){
			echo "<p class='error'>Empty Email</p";
			unset($email);
      exit();
     }
     $imgTemp=$_FILES["image"]["tmp_name"];
    $imgError=$_FILES["image"]["error"];
    /* if (!empty($) && !empty($state) && !empty($sdesc) && !empty($imgName)){
        $target=$uploads.$imgName;
        if (move_uploaded_file($_FILES["screenshot"]["tmp_name"],$target)){
        } */ 
      if ($password===$password1){
         $query="SELECT * FROM user where username=:username";
         $stmt=$db->prepare($query);
         $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        if  ($stmt->execute() == false) {
            echo "WARNING: Not working";
         } else {
             if ($stmt->rowCount() === 1) {
            echo "Username Taken";}
             else{
         $query="INSERT INTO user 
                (firstname,lastname,username,`password`,image_url,date_of_birth,email) VALUES (:firstname,:lastname,:username,:pass,:image_url,:date_of_birth,:email)";
         $stmt=$db->prepare($query);
         $stmt->bindValue(':firstname',$firstname,PDO::PARAM_STR);
         $stmt->bindValue(':lastname',$lastname,PDO::PARAM_STR);
         $stmt->bindValue(':username',$username,PDO::PARAM_STR);
         $stmt->bindValue(':pass',$password,PDO::PARAM_STR);
         $stmt->bindValue(':image_url',$imgTemp,PDO::PARAM_STR);
         $stmt->bindValue(':date_of_birth',$date,PDO::PARAM_STR);
         $stmt->bindValue(':email',$email,PDO::PARAM_STR);  
         if ($stmt->execute()){
            header("location: login.php");
        } else {
            echo "SOmething Went Wrong";
            echo "<a href='index.php'>Click here to Go back Home</a>";
            $stmt->closeCursor();
    }     
             }
 }
}  
#unset($db);      
endif  
?>
<?php
#include("header.php");  
#include("menu.php");
?>
<div id="container">
  <h1>REGISTRATION FORM</h1>
  <br>
  
  <form id="ajax" method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <div>
    <label for="firstname">Firstname</label>
    <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Firstname" value="<?php if (isset($firstname)){echo htmlspecialchars($firstname);}?>">
    <br>
    <br>
    <label for="lastname">Lastname</label>
    <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Lastname" value="<?php if (isset($lastname)) {echo htmlspecialchars($lastname);}?>">
    <br>
    <br>
    <label for="username">Username</label>
    <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?php if (isset($username)){echo htmlspecialchars($username);}?>">
    <br>
    <br>
    <label for="password">Password</label>
    <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="<?php if (isset($pasword)){echo htmlspecialchars($password);} ?>">
    <br>
    <br>
    <label for="password1">Password Again</label>
    <input type="password" class="form-control" id="password1" name="password1" placeholder="Password" value="<?php if (isset($pasword))  {echo htmlspecialchars($password1);} ?>">
    <br>
    <br>
    <label for="Image">Image</label>
    <input type="file" name="image" id="image">
    <br> 
    <br>
  <label for="birth">Date of Birth</label>
  <input type="date" id="date" name="date">
  <br>
  <br>
    <label for="email">Email</label>
    <input type="email" class="form-control" id="email" name="email" placeholder="email" value="<?php #echo $email; ?>">
  </div>
  <br>
  <br>
  <div>
  <input type="submit" class="form-control" id="submit" name="submit" value="submit">
  </div>
</form>
</div>
<?php
include("footer.php");  
?>
</div>
