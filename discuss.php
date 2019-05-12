<?php
session_start();
$title="Medxaminer";
include("header.php");
include("menu.php");
// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: register.php");
    exit;
}
else{
    $username=$_SESSION["username"];
    $userid=$_SESSION["userid"]; 

}
include("database.php");
#$username=$_SESSION["username"];
#$userid=$_SESSION["userid"]; 
####INSERT POSTED TOPICS
if (isset($_POST["submit"])):
    $topichead=filter_input(INPUT_POST, 'topichead');
    if ($topichead===false || strlen(trim($topichead))===0 || $topichead===null){
        echo "<p class='error'>Empty </p";
        unset($topichead);
  exit();
 }
    $topic=filter_input(INPUT_POST, 'topic');
    if ($topic===false || strlen(trim($topic))===0 || $topic===null){
        echo "<p class='error'>Empty </p";
        unset($topic);
  exit();
    }
    #validate and sanitize later
    $sql="INSERT INTO topic (userid,topichead,topic,time) VALUES (:userid,:topichead,:topic, NOW())";
    $stmt=$db->prepare($sql);
    $stmt->bindValue(':userid',$userid,PDO::PARAM_INT);
    $stmt->bindValue(':topichead',$topichead,PDO::PARAM_STR);
    $stmt->bindValue(':topic',$topic,PDO::PARAM_STR);
    if ($stmt->execute()){
        echo "topic Added";
    } else {
        $sql="";
        $stmt->closeCursor();
        exit();
    }
endif;
###SELECT AVAILABLE TOPICS
$sql="SELECT * FROM topic ORDER BY `time` DESC";
$stmt = $db->prepare($sql);
$stmt->execute();
$total=$stmt->rowCount();
if ($total>0){
    $record=$stmt->fetchall();
}
$stmt->closeCursor();
?>
<div id="container">
<h1><?php echo "Welcome $username" ;?></h1>
<h4>List of Topics</h4>
<ul>
<?php
foreach($record as $row){
    $topichead=$row["topichead"];
    $topicid=$row["topicid"];
    $userid=$row["userid"];
    $topic=$row["topic"];
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

}
  echo "<h3><li><a href='response.php?t=$topicid'>",$topichead,"<br>",$topic,"</a></li></h3><br>";
  echo "<h6> Posted By $userna on $time</h6>";##Add time later
  echo"<hr>";
}
?>
</ul>

 <br>
<br>
<h3>POST A QUESTION</h3>
<form id="ajax" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <div>
  <label for="topichead">Title</label>
  <input type="text" class= id="topichead" name="topichead" placeholder="Title" value="<?php if (isset($topichead)){echo $topichead;}?>">
  <br>
  <br>
    <label for="topic">Question</label>
    <textarea rows="4" cols="50" name="topic"><?php if(isset($topic)){echo $topic;}?> </textarea>
    <input type="submit" id="submit" name="submit" value="submit">
</div> 