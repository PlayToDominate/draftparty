<?php 
include("../includes/connection.php");
// prepare sql and bind parameters
$stmt = $pdo->prepare("
SELECT cnID,cnNickName,cnPointsTotal,cnNotes,cnPointsSchoolBor,cnPointsTeamBor,cnPointsConference,cnPointsDivision,
cnPointsTeamSch,cnPointsEmail,cnPointsLogo,cnPointsFood,cnPointsPlayerPicked,cnPointsPositionPicked,cnPointsLogo,
cnPointsChallenge,cnPointsPenalty,cnPointsPlayers,
scName,scNickName,tmCity,tmName,cfName,dvName 
FROM Contestants, Conferences, Teams, Schools, Divisions
WHERE cnID = :cnID
and cnConference = cfID
and cnTeam = tmID
and cnSchool = scID
and cnDivision = dvID
");
$stmt->bindParam(':cnID', $cnID);
$cnID = $_GET["cnID"];
if ($stmt->execute()) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

?>			
			
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"><?= $row["cnNickName"];?>: <?= $row["cnPointsTotal"];?></h4>
			</div>
			<div class="modal-body">
				<div class="row">
        			<div class="col-sm-12">
        				<div class="col-sm-12 col-md-6">
        					<h5>Points</h5>
        					<p>Players: <?=$row["cnPointsPlayers"];?></p>
            				<p>School: <?= $row["scName"];?> <?= $row["scNickName"];?>: <?= $row["cnPointsSchoolBor"];?></p>
            				<p>Team: <?= $row["tmCity"];?> <?= $row["tmName"];?>: <?= $row["cnPointsTeamBor"];?></p>
            				<p>Conference: <?= $row["cfName"];?>: <?= $row["cnPointsConference"];?></p>
            				<p>Division: <?= $row["dvName"];?>: <?= $row["cnPointsDivision"];?></p>
            				<p>NFL Team picked from School: <?= $row["cnPointsTeamSch"];?></p>
        				</div>
        				<div class="col-sm-12 col-md-6">
        					<h5>Bonus Points</h5>
        					<p>Email: <?= $row["cnPointsEmail"];?></p>
        					<p>Logo: <?= $row["cnPointsLogo"];?></p>
        					<p>Food: <?= $row["cnPointsFood"];?></p>
        					<p>Packers Player: <?= $row["cnPointsPlayerPicked"];?></p>
        					<p>Packers Position: <?= $row["cnPointsPositionPicked"];?></p>
        					<p>Trivia: <?= $row["cnPointsLogo"];?></p>
        					<p>Challenge: <?= $row["cnPointsChallenge"];?></p>
        					<p>Penalty: <?= $row["cnPointsPenalty"];?></p>
        				</div>
        				<div class="col-sm-12"><p>Notes: <?= $row["cnNotes"];?></p></div>
        			</div>
        		</div>
			</div>
<?}}?>