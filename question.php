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
#require_once("header.php");
$username=$_SESSION["username"];
$userid=$_SESSION["userid"]; 
$number=filter_input(INPUT_GET, 'n', FILTER_VALIDATE_INT);
$sql="SELECT questionid, question, question_image FROM question WHERE questionid=:questionid";
$stmt = $db->prepare($sql);
$stmt->bindValue(':questionid', $number, PDO::PARAM_INT);
if ($stmt->execute() == false) {
    echo "WARNING: error Fetching Question<br>";
} else {
    if ($stmt->rowCount() === 1) {
        $record = $stmt->fetch();
        
        $questionid = $record['questionid'];
        $question = $record['question'];
        $question_image = $record['question_image'];
    } else {
        # cancels the update
        #$operation = "";
    }
    
    $stmt->closeCursor();
}
$sqltotal="SELECT * FROM question";
$stmt = $db->prepare($sqltotal);
$stmt->execute();
$total=$stmt->rowCount() ;//check again
#echo $total;
$sql1="SELECT * FROM answer WHERE questionid=:questionid";
$stmt = $db->prepare($sql1);
$stmt->bindValue(':questionid', $number, PDO::PARAM_INT);
if ($stmt->execute() == false) {
    echo "WARNING: error Fetching Question<br>";
} else {
    if ($stmt->rowCount()>1) {
        $record = $stmt->fetchall();
        //I have to loop here
        #$questionid = $record['questionid'];
        #$question = $record['question'];
        #$question_image = $record['image'];
    } else {
        # cancels the update
        #$operation = "";
    }
    
    $stmt->closeCursor();
}
?>
<div id="container">
    <div class="current"><?php echo "Question $number of $total"?>
    <p><?php echo $question;?></p>;
    <form method="post" action="process.php"> 
    <ul class="choice">
   <?php foreach ($record as $row){?>
   <li><input type="radio" name="choice" value="<?php echo $row["answerid"];?>"><?php echo $row["choice"];?></li>
   <?php
   }
   ?>
   </ul>
   <input type="hidden" name="number" value="<?php echo $number;?>">
   <input type="submit" name="submit" value="submit">
   </div>
</div
<?php
include("footer.php");  
?>
</div>
