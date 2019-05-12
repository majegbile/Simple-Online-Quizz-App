<?php
session_start();
$title="Medxaminer";
include("header.php");
include("menu.php");
// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    $username ="Anonymous";
}
else{
    $username=$_SESSION["username"];
    $currentuserid=$_SESSION["userid"];
}

include("database.php");
$topicid=filter_input(INPUT_GET, 't', FILTER_VALIDATE_INT);
$query="SELECT * FROM topic WHERE topicid=:topicid";
$stmt = $db->prepare($query);
$stmt->bindValue(':topicid', $topicid, PDO::PARAM_INT);
if ($stmt->execute() == false) {
    echo "WARNING: error Fetching Question<br>";
} else {
    if ($stmt->rowCount() === 1) {
        $record = $stmt->fetch();
        $topichead=$record['topichead'];
        $topic = $record['topic'];
        $userid = $record['userid'];
    } else {
        $sql="";
    }
    
    $stmt->closeCursor();
}
$sql="SELECT * FROM response WHERE topicid=:topicid";
$stmt = $db->prepare($sql);
$stmt->bindValue(':topicid', $topicid, PDO::PARAM_INT);
if ($stmt->execute() == false) {
    echo "WARNING: error Fetching Responses<br>";
} else {
    if ($stmt->rowCount()>0) {
        $records = $stmt->fetchall();
        $nres=$stmt->rowCount();
        #DO everything HERE
    } else {
            $records=null;
            $nres=0;
        }
    }
$stmt->closeCursor();


##if response is posted
if (isset($_POST["submit"])){

    $topicid=filter_input(INPUT_POST, 'topicid', FILTER_VALIDATE_INT);
   $query="SELECT * FROM topic WHERE topicid=:topicid";
   $stmt = $db->prepare($query);
   $stmt->bindValue(':topicid', $topicid, PDO::PARAM_INT);
   if ($stmt->execute() == false) {
    echo "WARNING: error Fetching Question<br>";
} else {
    if ($stmt->rowCount() === 1) {
        $record = $stmt->fetch();
        $topichead=$record['topichead'];
        $topic = $record['topic'];
        $userid = $record['userid'];
    } else {
        $sql="";
    }
    
    $stmt->closeCursor();
}



    $response=filter_input(INPUT_POST, 'response');
    $sql="INSERT INTO response (topicid,userid,response,`time`) VALUES (:topicid,:userid,:response,NOW())";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':topicid', $topicid, PDO::PARAM_INT);
    $stmt->bindValue(':userid', $currentuserid, PDO::PARAM_INT);
    $stmt->bindValue(':response', $response, PDO::PARAM_STR);
    $stmt->execute();
    $stmt->closeCursor();
    header("Location: discuss.php");



} 
?>
<div id="container">
<h1><?php echo "Welcome $username" ?></h1>
<h5><?php echo $topic; ?></h5>
<ul>
<?php
if ($records!=null){
foreach($records as $row){
    $responseid=$row["responseid"];
    $userid=$row["userid"];
    $response=$row["response"];
    $time=$row["time"];
    $sql="SELECT * FROM user WHERE userid=:userid";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':userid', $userid, PDO::PARAM_INT);
    if ($stmt->execute() == false) {
        echo "WARNING: error Fetching USER<br>";
    } else {
        if ($stmt->rowCount() === 1) {
            $record = $stmt->fetch();
            $userna= $record['username'];
            $stmt->closeCursor();
        }
    echo "<li>";    
    echo "<p>$response</p>";
    echo "By $userna at $time";    
    #echo "$nres responses";
    echo "</li>";
   }
}
}
else{
    echo "No Response to this topic yet";
}
   ?>
</ul>
<h3>Your Answer</h3>
<form id="ajax" method="post"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <div>
    <label for="response">Respond</label>
    <textarea rows="4" cols="50" name="response"><?php if(isset($response)){echo $response;}?> </textarea>
    <br>
    <br>
    <input type="hidden" name="topicid" value="<?php echo $topicid;?>">
    <input type="submit" id="submit" name="submit" value="submit">
    <form>
</div>
  

