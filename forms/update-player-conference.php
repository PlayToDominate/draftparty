<?php 
include("../includes/connection.php");
// prepare sql and bind parameters
$stmt = $pdo->prepare("UPDATE SchoolsConferences set sccfID = :sccfID where scscID =  :scscID");
$stmt->bindParam(':sccfID', $sccfID);
$stmt->bindParam(':scscID', $scscID);

// insert a row
$sccfID = $_POST["sccfID"];
$scscID = $_POST["scscID"];
$stmt->execute();

echo "Conference successfully updated.";

?>