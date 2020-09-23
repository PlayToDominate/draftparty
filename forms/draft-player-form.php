<?php 
include("../includes/connection.php");
// prepare sql and bind parameters
$stmt = $pdo->prepare("INSERT INTO Selections (slPlayer, slTeam) VALUES (:slPlayer, :slTeam)");
$stmt->bindParam(':slPlayer', $slPlayer);
$stmt->bindParam(':slTeam', $slTeam);

// insert a row
$slPlayer = $_POST["slPlayer"];
$slTeam = $_POST["slTeam"];
$stmt->execute();


echo "New records created successfully";

?>