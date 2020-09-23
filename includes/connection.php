<?php
date_default_timezone_set('America/Chicago');
/* connects to my database */
$servername = "localhost";
$username = "teschsco_jtesch";
$password = "G0d!sg00d!";
$dbname="teschsco_draftparty";

$amIAnAdmin = $_GET['amIAnAdmin'];

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    /* echo "Connected successfully"; */
    $teamOTC="";
    $teamOTCID="";
    $next_pick="";
    $getCurrentPick = $pdo->prepare("SELECT
                        min(DraftOrder.drSelection) as next_pick,tmID,tmCity,tmName
                        FROM Teams,DraftOrder
                        WHERE Teams.tmID = DraftOrder.drTeam
                        AND DraftOrder.drSelection not in (select slID from Selections)
                        LIMIT 1");
    if ($getCurrentPick->execute()) {
        while ($row = $getCurrentPick->fetch(PDO::FETCH_ASSOC)) {
            $teamOTC= $row["tmCity"]." ". $row["tmName"];
            $teamOTCID = $row["tmID"];
            $next_pick = $row["next_pick"];
        }}
} catch(PDOException $e){
     echo "Connection failed: It was probably Chips fault...or " . $e->getMessage();
}
?>
