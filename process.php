<?php
$title="Medxaminer";
include("header.php");
include("menu.php");
include("database.php");
session_start();
if(!isset($_SESSION['score'])){
    $_SESSION['score']=0;
}
if (isset($_POST["submit"])):
    $number=filter_input(INPUT_POST, 'number', FILTER_VALIDATE_INT);
    $selected=filter_input(INPUT_POST, 'choice', FILTER_VALIDATE_INT);
    $next=$number+1;
    $sql="SELECT * FROM answer WHERE questionid=:questionid AND is_correct=1";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':questionid', $number, PDO::PARAM_INT);
    #$stmt->bindValue(':is_correct',"1", PDO::PARAM_INT);
    if ($stmt->execute() == false) {
        echo "WARNING: error Fetching Question<br>";
    } else {
        if ($stmt->rowCount() === 1) {
            $record = $stmt->fetch();
            $correct = $record['answerid'];
            $stmt->closeCursor();
        }
    if ($selected==$correct){
        echo "true";
        print_r($_SESSION["score"]);
        $_SESSION["score"]=$_SESSION["score"]+1;
    }
    $sqltotal="SELECT * FROM question";
    $stmt = $db->prepare($sqltotal);
    $stmt->execute();
    $total=$stmt->rowCount();
    $stmt->closeCursor();
    if ($number==$total){
        #$_SESSION["total"]=$total;
        header("location: finish.php");
    }
    else{
        header("location:question.php?n=$next");
    } 
}  

endif; 
?>