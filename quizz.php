<?php
$title="Medxaminer";
include("header.php");
include("menu.php");
 session_start();
// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
include("database.php");
require_once("header.php");
$username=$_SESSION["username"];
$userid=$_SESSION["userid"]; 
$sqltotal="SELECT * FROM question";
$stmt = $db->prepare($sqltotal);
$stmt->execute();
#if ($stmt->rowCount()>0){
$total=$stmt->rowCount() ;//check again
?>
<div id="container">
   <div class="output">
  <h1><?php echo "WELCOME $username";?></h1>
  <ul>
  <li><strong>Number of Questions:</stong><?php echo $total;?></li>
  <li><strong>Type:</strong>Multiple Choice</li>
  <li><strong>Estimated Time:<?php echo $total*0.5;?></strong></li>
  </ul>
  <a href="question.php?n=1">Start Quizz</a> 
  <?php
   /*  $sql1="SELECT questionid, question FROM question";
   $stmt = $db->prepare($sql);
   if ($stmt->execute() == false) {
    echo "WARNING: error deleting item<br>";
  } else {
    
    if ($stmt->rowCount() === 1) {
      $record = $stmt->fetch();
      
      $productId = $record['product_id'];
      $productName = $record['name'];
      $productPrice = $record['price'];
      $quantity = $record['quantity'];
    }
  } */
?> 
</div>
</div>
<?php
include("footer.php");
?>