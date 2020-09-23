<?php 
include("../includes/connection.php");
// prepare sql and bind parameters
$stmt = $pdo->prepare("
SELECT
    avFirst,
    avLast,
    avOverall,
    avPosition,
    avRank,
    scName,
    scNickName
FROM
    Schools,AvailablePlayers 
WHERE scID = :scID
and scID = avSchool
ORDER BY
    avOverall
");
$stmt->bindParam(':scID', $scID);
$scID = $_GET["scID"];
$scName="";
if ($stmt->execute()) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $scName=$row["scName"]." ".$row["scNickName"];
}}
?>			
			
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"><?=$scName?></h4>
			</div>
			<div class="modal-body">
				<div class="row">
        			<div class="col-sm-12">
        				<table class="table table-sm table-striped">
        				<?
                            if ($stmt->execute()) {
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <tr>
                        	<td><?=$row["avOverall"]?> (<?=$row["avPosition"]?><?=$row["avRank"]?>)  <?=$row["avFirst"]?> <?=$row["avLast"]?></td>
                        </tr>
                        <?}}?>
                        </table>
        			</div>
        		</div>
			</div>