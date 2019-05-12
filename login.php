<?php
session_start();
include("database.php");
$title="MEDXAMINER";
if (isset($_POST["submit"])):
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
    $query="SELECT * FROM user where username=:username AND password=:password";
    $stmt=$db->prepare($query);
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->bindValue(':password', $password, PDO::PARAM_STR);
    if  ($stmt->execute() == false) {
        echo "WARNING:User Login Failed<br>";
     } else {
         if ($stmt->rowCount() === 1) {
             $result=$stmt->fetch();
             $stmt->closeCursor();
             $_SESSION["loggedin"]=true;
             $_SESSION["userid"]=$result["userid"];
             $_SESSION["username"]=$result["username"];
             #var_dump($_SESSION["userid"]);
             $_SESSION["image_url"]=$result["image_url"];
            header("Location: quizz.php");
         }
         else{
             "echo Username and Password does not match";
         }
        } 
    unset($db);  
endif; 

?>
<?php
include("header.php");  
include("menu.php");
?>
<div id="container">
  <h1>LOGIN FORM</h1>
  <br> 
  <form id="ajax" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  <label for="username">Username</label>
    <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?php if (isset($username)){echo htmlspecialchars($username);}?>">
    <br>
    <br>
    <label for="password">Password</label>
    <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="<?php if (isset($pasword)){echo htmlspecialchars($password);} ?>">
    <br>
    <br>
    <div>
  <input type="submit" class="form-control" id="submit" name="submit" value="submit">
  </div>
</form>
<?php
include("footer.php");  
?>
</div>



