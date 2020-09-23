<!doctype html>
<html lang="en">
<?
include("includes/connection.php");
$page_title="Tesch NFL Draft Party";
include 'includes/draft-year.php';
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?include 'includes/css-script.php';?>
</head>
<body>
<?include 'includes/header.php';?>
<div class="container-fluid">
	<div class="row">
		<div class="col">
        	<h1><?php echo $page_title;?> <?=$draftYear?></h1>
        	<!-- <h2>The Game</h2>-->
            <div class="col-sm-12 col-md-2">
            	<div class="col-sm-12">
            		<?include 'includes/navigation.php';?>
            	</div>

            </div>
			<div class="col-sm-12 col-md-6">
                <ul class="nav nav-tabs" id="rdTabs">
                	 <li><a data-toggle="tab" href="#rd1" id="rd1-tab">1</a></li>
                 	 <li><a data-toggle="tab" href="#rd2" id="rd2-tab">2</a></li>
                 	 <li><a data-toggle="tab" href="#rd3" id="rd3-tab">3</a></li>
                 	 <li><a data-toggle="tab" href="#rd4" id="rd4-tab">4</a></li>
                 	 <li><a data-toggle="tab" href="#rd5" id="rd5-tab">5</a></li>
                 	 <li><a data-toggle="tab" href="#rd6" id="rd6-tab">6</a></li>
                 	 <li><a data-toggle="tab" href="#rd7" id="rd7-tab">7</a></li>
                </ul>
                <div class="tab-content" id="tab-container">
                  	<div id="rd1" class="tab-pane fade in tab-child">
        				<table class="table table-striped table-sm">
                            <? 
                            $selectedPlayers_list = $pdo->prepare("SELECT 
                                Selections.slPlayer, 
                                Selections.slTeam, 
                                AvailablePlayers.avFirst, 
                                AvailablePlayers.avLast, 
                                AvailablePlayers.avSchool,
                                AvailablePlayers.avRank,
                                AvailablePlayers.avOverall,
                                AvailablePlayers.avPosition,
                                Schools.scID,
                                Schools.scName, 
                                Schools.scNickname, 
                                Teams.tmID,
                                Teams.tmCity, 
                                Teams.tmName,
                                DraftOrder.drSelection,
                                DraftOrder.drRound,
                                cnFirst,cnLast,cnID,cnSchool,cnNickName
                                FROM Selections, 
                                Schools,DraftOrder,Teams,AvailablePlayers
                                LEFT JOIN Contestants on cnSchool = avSchool and cnActive='Y'
                                
                                WHERE Selections.slPlayer = AvailablePlayers.avID 
                                AND AvailablePlayers.avSchool = Schools.scID 
                                AND Selections.slID = DraftOrder.drSelection 
                                AND Teams.tmID = Selections.slTeam 
                                
                                ORDER BY DraftOrder.drSelection
                            ");
                            $rank100AlreadyShown=false; 
                            $rank200AlreadyShown=false; 
                            $rank300AlreadyShown=false; 
                            $firstSchoolDayOne="";
                            $firstSchoolDayTwo="";
                            $firstSchoolDayThree="";
                            $firstConferenceDayOne="";
                            $firstConferenceDayTwo="";
                            $firstConferenceDayThree="";
                            $currRound="1";
                            if ($selectedPlayers_list->execute()) {
                                while ($row = $selectedPlayers_list->fetch(PDO::FETCH_ASSOC)) {
                                    $infoContent="";
                                    $infoHeader="";
                                    $popOver="";
                                    $showSpecialClass=false;
                                    $specialClass="";
                                    $pickMatchesSchool=false;
                                    $pickMatchesConference=false;
                                    if($row["avSchool"] == $row["cnSchool"]) {
                                        $pickMatchesSchool=true;
                                    } if($row["avConference"] == $row["cnConference"]){
                                        $pickMatchesConference=true;
                                    }
                                    
                                    
                                    if(($row["avOverall"] > 100) && (!$rank100AlreadyShown)){
                                        $infoHeader="MILD REACH";
                                        $infoContent="This was the first player picked who was ranked outside the top 100.";
                                        $specialClass.="warning ";
                                        $popOver.="<a tabindex=\"0\" role=\"button\" data-toggle=\"popover\" data-trigger=\"click\" data-container=\"body\" data-placement=\"left\" title=\"".$infoHeader."\" data-content=\"".$infoContent."\"><span class=\"glyphicon glyphicon-info-sign\"></span></a>";
                                        $rank100AlreadyShown=true;
                                    }if(($row["avOverall"] > 200) && (!$rank200AlreadyShown)){
                                        $infoHeader="REACH";
                                        $infoContent="This was the first player picked who was ranked outside the top 200.";
                                        $specialClass.="warning ";
                                        $popOver.="<a tabindex=\"0\" role=\"button\" data-toggle=\"popover\" data-trigger=\"click\" data-container=\"body\" data-placement=\"left\" title=\"".$infoHeader."\" data-content=\"".$infoContent."\"><span class=\"glyphicon glyphicon-info-sign\"></span></a>";
                                        $rank200AlreadyShown=true;
                                    }if(($row["avOverall"] > 300) && (!$rank300AlreadyShown)){
                                        $infoHeader="MAJOR REACH";
                                        $infoContent="This was the first player picked who was ranked outside the top 300.";
                                        $specialClass.="danger ";
                                        $popOver.="<a tabindex=\"0\" role=\"button\" data-toggle=\"popover\" data-trigger=\"click\" data-container=\"body\" data-placement=\"left\" title=\"".$infoHeader."\" data-content=\"".$infoContent."\"><span class=\"glyphicon glyphicon-info-sign\"></span></a>";
                                        $rank300AlreadyShown=true;
                                    } if($row["avSchool"]==129){
                                        $infoHeader="Automatic Cigar";
                                        $infoContent="Wisconsin Guy - probably a lineman";  
                                        $popOver.="<a tabindex=\"0\" role=\"button\" data-toggle=\"popover\" data-trigger=\"click\" data-container=\"body\" data-placement=\"left\" title=\"".$infoHeader."\" data-content=\"".$infoContent."\"><span class=\"glyphicon glyphicon-info-sign\"></span></a>";
                                        $specialClass.="danger ";
                                    } if(($pickMatchesSchool) || ($pickMatchesConference)){
                                        if($currRound == 1){
                                            if($pickMatchesSchool){
                                                if (empty($firstSchoolDayOne)) {
                                                    $firstSchoolDayOne=$row["cnNickName"];
                                                    $infoHeader=$firstSchoolDayOne.", you win a prize!";
                                                    $infoContent="First school selection of day 1!";
                                                    $popOver.="<a tabindex=\"0\" role=\"button\" data-toggle=\"popover\" data-trigger=\"click\" data-container=\"body\" data-placement=\"left\" title=\"".$infoHeader."\" data-content=\"".$infoContent."\"><span class=\"glyphicon glyphicon-info-sign\"></span></a>";
                                                    $specialClass.="success ";
                                                }
                                            } if($pickMatchesConference){
                                                if (empty($firstConferenceDayOne)) {
                                                    $firstConferenceDayOne=$row["cnNickName"];
                                                    $infoHeader=$firstConferenceDayOne.", you win a prize!";
                                                    $infoContent="First conference selection of day 1!";
                                                    $popOver.="<a tabindex=\"0\" role=\"button\" data-toggle=\"popover\" data-trigger=\"click\" data-container=\"body\" data-placement=\"left\" title=\"".$infoHeader."\" data-content=\"".$infoContent."\"><span class=\"glyphicon glyphicon-info-sign\"></span></a>";
                                                    $specialClass.="success ";
                                                }
                                            }
                                        } if(($currRound == 2) || ($currRound == 3)){
                                            if($pickMatchesSchool){
                                                if (empty($firstSchoolDayTwo)) {
                                                    $firstSchoolDayTwo=$row["cnNickName"];
                                                    $infoHeader=$firstSchoolDayTwo.", you win a prize!";
                                                    $infoContent="First school selection of day 2!";
                                                    $popOver.="<a tabindex=\"0\" role=\"button\" data-toggle=\"popover\" data-trigger=\"click\" data-container=\"body\" data-placement=\"left\" title=\"".$infoHeader."\" data-content=\"".$infoContent."\"><span class=\"glyphicon glyphicon-info-sign\"></span></a>";
                                                    $specialClass.="success ";
                                                }
                                            } if($pickMatchesConference){
                                                if (empty($firstConferenceDayTwo)) {
                                                    $firstConferenceDayTwo=$row["cnNickName"];
                                                    $infoHeader=$firstConferenceDayTwo.", you win a prize!";
                                                    $infoContent="First conference selection of day 2!";
                                                    $popOver.="<a tabindex=\"0\" role=\"button\" data-toggle=\"popover\" data-trigger=\"click\" data-container=\"body\" data-placement=\"left\" title=\"".$infoHeader."\" data-content=\"".$infoContent."\"><span class=\"glyphicon glyphicon-info-sign\"></span></a>";
                                                    $specialClass.="success ";
                                                }
                                            }
                                        } if($currRound > 3){
                                            if($pickMatchesSchool){
                                                if (empty($firstSchoolDayThree)) {
                                                    $firstSchoolDayThree=$row["cnNickName"];
                                                    $infoHeader=$firstSchoolDayThree.", you win a prize!";
                                                    $infoContent="First school selection of day 3!";
                                                    $popOver.="<a tabindex=\"0\" role=\"button\" data-toggle=\"popover\" data-trigger=\"click\" data-container=\"body\" data-placement=\"left\" title=\"".$infoHeader."\" data-content=\"".$infoContent."\"><span class=\"glyphicon glyphicon-info-sign\"></span></a>";
                                                    $specialClass.="success ";
                                                }
                                            } if($pickMatchesConference){
                                                if (empty($firstConferenceDayThree)) {
                                                    $firstConferenceDayThree=$row["cnNickName"];
                                                    $infoHeader=$firstConferenceDayThree.", you win a prize!";
                                                    $infoContent="First conference selection of day 3!";
                                                    $popOver.="<a tabindex=\"0\" role=\"button\" data-toggle=\"popover\" data-trigger=\"click\" data-container=\"body\" data-placement=\"left\" title=\"".$infoHeader."\" data-content=\"".$infoContent."\"><span class=\"glyphicon glyphicon-info-sign\"></span></a>";
                                                    $specialClass.="success ";
                                                }
                                            }
                                        }
                                    }
                                    if (!empty($specialClass)) {
                                        $showSpecialClass=true;
                                    }
                                    if($currRound != $row["drRound"]){
                                        $currRound = $row["drRound"];
                            ?>
                            <!-- new round starting -->
                        </table>
                      </div>
                      <div id="rd<?=$row["drRound"]?>" class="tab-pane fade in tab-child">
                      	<table class="table table-striped table-sm">
                            <?}?>
                            <tr<?if($showSpecialClass){?> class="<?=$specialClass?>"<?}?>>
                                <td><?= $row["drSelection"];?></td>
                                <td><?= $row["avFirst"];?> <?= $row["avLast"];?><br /><small class="text-muted">(OVR<?=$row["avOverall"]?> <?=$row["avPosition"]?><?=$row["avRank"]?>)</small></td>
                                <td><a href="#" data-curridlbl="scID" data-formurl="forms/show-school-details.php" data-currid="<?=$row["scID"]?>" class="getDetails"><?= $row["scName"];?> <?= $row["scNickname"];?></a></td>
                                <td><a href="#" data-curridlbl="tmID" data-formurl="forms/show-team-details.php" data-currid="<?=$row["tmID"]?>" class="getDetails"><?= $row["tmCity"];?> <?= $row["tmName"];?></a></td>
                                <td><?if (!empty($popOver)) {?><?=$popOver?><?}?></td>                      
                            </tr>
                        <?}}?>
                        </table>
                    </div>
                </div>
			</div>
            <div class="col-sm-12 col-md-4">
           		<table class="table table-striped table-sm">
                    <? 
                    $cnRank=0;
                    $scoreboard = $pdo->prepare("SELECT
                    cnID,cnNickName,cnPointsTotal,cnSchool,cnTeam,cnConference,cnDivision,cnNotes
                    FROM Contestants
                    WHERE cnActive='Y'
                    ORDER BY cnPointsTotal DESC,cnNickname");
                    if ($scoreboard->execute()) {
                        while ($row = $scoreboard->fetch(PDO::FETCH_ASSOC)) {
                            $cnRank++;
                    ?>
                    <tr>
                        <td><?=$cnRank?> <a href="#" data-curridlbl="cnID" data-formurl="forms/show-contestant-details.php" data-currid="<?=$row["cnID"]?>" class="getDetails"><?= $row["cnNickName"];?></td><td><?= $row["cnPointsTotal"];?></a></td> 
                	<?}}?>
                	</tr>
                </table>              
        	</div>
    	</div>
    </div>
</div>
<div id="onTheClock" class="modal fade">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">On The Clock</h4>
			</div>
			<div class="modal-body">
				<div class="row">
        			<div class="col-sm-12">

        				<h5><?=$teamOTC?></h5>
        				<p>Current Pick: <?=$next_pick?></p>
        				<table class="table table-sm table-striped">
        				<?
                            $previousPicks = $pdo->prepare("
                            SELECT drSelection,drSelInRound,drRound,avFirst,avLast,avPosition
                            from DraftOrder,AvailablePlayers,Selections,Teams
                            WHERE slTeam = tmID
                            AND slPlayer = avID
                            AND slID = drSelection
                            AND tmID = $teamOTCID
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
                            WHERE tmID = $teamOTCID
                            and tmID = drTeam
                            and drSelection > $next_pick
                            ORDER BY
                                drSelection
                            ");
                            if(!empty($teamOTCID)){
                                if ($previousPicks->execute()) {
                                    while ($row = $previousPicks->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                            <tr>
                            	<td><?=$row["drRound"]?> #<?=$row["drSelInRound"]?> (<?=$row["drSelection"]?>): <?=$row["avFirst"]?> <?=$row["avLast"]?> <?=$row["avPosition"]?></td>
                            </tr>    
        					<?}} if(!empty($next_pick))?>
            				<?
                                if ($upcomingPicks->execute()) {
                                    while ($row = $upcomingPicks->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                            <tr>
                            	<td><?=$row["drRound"]?> #<?=$row["drSelInRound"]?> (<?=$row["drSelection"]?>)<!--: <?=$row["avFirst"]?> <?=$row["avLast"]?>--></td>
                            </tr>
                            <?}}}?>
                        </table>
        				<p>Anything more will probably be a "next year" project...</p>
        			</div>
        		</div>
			</div>
		</div>
	</div>
</div>
<div id="draftPlayer" class="modal fade">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Draft Player at Pick <?=$next_pick?></h4>
			</div>
			<div class="modal-body">
				<div class="row">
        			<div class="col-sm-12">
                         <form method = "POST" action = "forms/draft-player-form.php" name="newSelection" id="newSelection" target="_blank">
        				<div class="col-xs-12 col-md-4">
        					<select name="slTeam" class="form-control" >
                                <? 
                                $nflTeams = $pdo->prepare("SELECT
                                tmID,tmCity,tmName
                                FROM Teams
                                ORDER BY tmCity,tmName");
                                if ($nflTeams->execute()) {
                                    while ($row = $nflTeams->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                <option value="<?= $row["tmID"];?>"<?if($row["tmID"] == $teamOTCID){?> selected="selected"<?}?>><?= $row["tmCity"];?> <?= $row["tmName"];?></option> 
                            	<?}}?>
        					</select>
        				</div>
        				<div class="col-xs-12 col-md-4">
        					<input type="text" name="slPlayer" value="" id="slPlayer" class="form-control" autocomplete="off"/>
        				</div>
        				<div class="col-xs-12 col-md-4">
        					<button type="submit" class="btn btn-primary">Select Player</button>
        				</div>
        				</form>
        			</div>
        		</div>
			</div>
     	 	<div class="modal-footer">
        		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      		</div>
		</div>
	</div>
</div>
<div id="genericModal" class="modal fade">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
            <div class="modal-header">header</div>
            <div class="modal-body">body</div>
		</div>
	</div>
</div>
<?include 'includes/footer.php';?>
<script type="text/javascript">

$(document).ready(function() {
	$('[data-toggle="popover"]').popover();	
	$('#rdTabs li').removeClass('active');
	var lastTabDiv=$('#tab-container div.tab-child:last');
	var lastTavDivID = lastTabDiv.attr('id');
	lastTabDiv.addClass('active');
	$('#'+lastTavDivID+'-tab').parent().addClass('active').nextAll().hide();
	
	
	<?if($amIAnAdmin == 'P2D'){?>
	//http://docs.jquery.com/UI/Autocomplete
	var availableList = [
		<? $i=0;
    		$availableList = $pdo->prepare("SELECT
    				avID,avRank,avOverall,avFirst,avLast,avPosition,avSchool,avHt,avWt,
                    sc.scName
    			FROM AvailablePlayers ap, Schools sc
    			WHERE ap.avID not in (select slPlayer from Selections)
                    AND ap.avSchool = sc.scID
    			ORDER BY avFirst, avLast"
            );
    		if ($availableList->execute()) {
    		    while ($info = $availableList->fetch(PDO::FETCH_ASSOC)) {
        			$firstname = $info['avFirst'];
        			$lastname = $info['avLast'];
        			if($i == 0){
    	?>
    	{value: "<?=$info['avID']?>", label: "<?=$firstname?> <?=$lastname?>, <?=$info['scName']?> (<?=$info['avPosition']?>)"}
        <?} else {?>
        	,{value: "<?=$info['avID']?>", label: "<?=$firstname?> <?=$lastname?>, <?=$info['scName']?> (<?=$info['avPosition']?>)"}
		<?} $i++;  }}?>
	];
	$( "#slPlayer").autocomplete({
		source: availableList,autoFocus: true
	});
	<?}?>
});
<?if($amIAnAdmin == 'P2D'){?>
$(document).on('submit','#newSelection',function(){
	$.ajax({
		url: $(this).attr('action'),
		type: $(this).attr('method'),
		data: $(this).serialize(),
		beforeSend: function(){
			$(this).closest('button[type="submit"]').text('Selecting...');
		},
		success: function(data){
			$('button[type="submit"]').text('Select Player');
		},
		error: function(){
			console.log('error');
		},
		complete: function(){
			location.reload();
		}
	});
	return false;
});
$(document).on('submit','.update-player-conference',function(){
	$.ajax({
		url: $(this).attr('action'),
		type: $(this).attr('method'),
		data: $(this).serialize(),
		beforeSend: function(){
			$(this).closest('button[type="submit"]').text('Updating...');
		},
		success: function(data){
			$(this).find('button[type="submit"]').text('Go');
		},
		error: function(){
			console.log('error');
		},
		complete: function(){
			//location.reload();
		}
	});
	return false;
});
<?}?>
//$(document).off('click','.getContestant');
$(document).on('click','.getDetails',function(e){
	e.preventDefault();
	var formURL = $(this).data('formurl');
	var currIDLBL = $(this).data('curridlbl');
	var currID = $(this).data('currid');
	$.ajax({
		url: formURL+"?"+currIDLBL+"="+currID,
		dataType: "html",
		success: function(data){
			//console.log('details success: '+data);
            $('#genericModal .modal-content').html(data);
		},
		error: function(){
			console.log('error');
		},
		complete: function(){
			//console.log('details complete');
			$('#genericModal').modal('show');
		}
	});
	return false;
});
</script>
</body>
</html>
