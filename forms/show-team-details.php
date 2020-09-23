<?php 
include("../includes/connection.php");
// prepare sql and bind parameters
$previousPicks = $pdo->prepare("
SELECT drSelection,drSelInRound,drRound,avFirst,avLast,avPosition
from DraftOrder,AvailablePlayers,Selections,Teams
WHERE slTeam = tmID
AND slPlayer = avID
AND slID = drSelection
AND tmID = :tmID
");
$upcomingPicks = $pdo->prepare("
SELECT
    drSelection,
    drRound,
    drSelInRound,
    tmCity,
    tmName
FROM
    Teams,DraftOrder 
WHERE tmID = :tmID
and tmID = drTeam
and drSelection > $next_pick
ORDER BY
    drSelection
");
$previousPicks->bindParam(':tmID', $tmID);
$upcomingPicks->bindParam(':tmID', $tmID);
$tmID = $_GET["tmID"];
$tmName="";
if ($upcomingPicks->execute()) {
    while ($row = $upcomingPicks->fetch(PDO::FETCH_ASSOC)) {
    	$tmName=$row["tmCity"]." ".$row["tmName"];
}}
?>			
			
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"><?=$tmName?></h4>
			</div>
			<div class="modal-body">
				<div class="row">
        			<div class="col-sm-12">
        				<table class="table table-sm table-striped">
        				<?
if ($previousPicks->execute()) {
    while ($row = $previousPicks->fetch(PDO::FETCH_ASSOC)) {
    ?>
                        <tr>
                        	<td><?=$row["drRound"]?> #<?=$row["drSelInRound"]?> (<?=$row["drSelection"]?>): <?=$row["avFirst"]?> <?=$row["avLast"]?> <?=$row["avPosition"]?></td>
                        </tr>    
    <?}}?>
        				<?
if ($upcomingPicks->execute()) {
    while ($row = $upcomingPicks->fetch(PDO::FETCH_ASSOC)) {
    ?>
                        <tr>
                        	<td><?=$row["drRound"]?> #<?=$row["drSelInRound"]?> (<?=$row["drSelection"]?>)<!--: <?=$row["avFirst"]?> <?=$row["avLast"]?>--></td>
                        </tr>
                        <?}}?>
                        </table>
        			</div>
        		</div>
			</div>