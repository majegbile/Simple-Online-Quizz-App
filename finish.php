<?php
$title="Medxaminer";
include("header.php");
include("menu.php");
include("database.php");
session_start();
$finalscore=(float)$_SESSION["score"];
#echo $finalscore;
#echo $total;
 $sqltotal="SELECT * FROM question";
$stmt = $db->prepare($sqltotal);
$stmt->execute();
$total=(float)$stmt->rowCount();
$stmt->closeCursor();
if ($finalscore>0 && $total>0){
$percentage=($finalscore/$total)*100;
}
else{
    $percentage=0;
} 
?>
<div id="container">
   <div class="output">
   <h1><?php echo "congrats ", $_SESSION["username"];?></h1>
    <h4><?php echo "Your had $percentage percent";?></h4>
    <h5><a href="index.php">Home</a></h5>
   </div>
</div>