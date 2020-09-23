
				<!-- Column 3 start -->
				<h3>Leaderboard</h3>
				<?
					$numRec=1;//ranking starts at 1
					
					// gets all contestants and their team/school/conference/division, orders them by total points and numbered (numRec)
					$leaderboard = "
						SELECT cnFirst,cnLast,
						CASE WHEN cnNickName IS NOT NULL then cnNickname ELSE cnFirst END AS teamName,
						Schools.scName AS schoolName,
						Teams.tmName AS proName,
						Conferences.cfName as conferenceName,
						Divisions.dvName AS divisionName,
						cnPointsTotal,
						cnPointsLogo,
						cnPointsPlayers,
						cnPointsEmail,
						cnPointsFood,
						cnPointsDivision,
						cnPointsConference,
						cnPointsTrivia,
						cnPointsPenalty,
						cnCurrentPlace,
						cnPreviousPlace,
						cnNotes,
						cnPointsChallenge
						FROM Contestants,Schools,Teams,Conferences,Divisions
						WHERE Contestants.cnSchool = Schools.scID
						AND Contestants.cnTeam = Teams.tmID
						AND Contestants.cnConference = Conferences.cfID
						AND Contestants.cnDivision = Divisions.dvID
						AND Contestants.cnActive = 1
						ORDER BY cnPointsTotal DESC, teamName
					"; 
					$leaderboard_result = mysqli_query($con, $leaderboard);
					while($info = mysqli_fetch_array($leaderboard_result)){
				?>
				<h5 style="margin:0;"><?=$numRec?>: <a href="#leaderboard-<?=$info['teamName'];?>" class="fancybox"><?=$info['cnPointsTotal'];?> (<?=$info['teamName'];?>)</a></h5>
				<div style="margin-top:0;display:none;" id="leaderboard-<?=$info['teamName'];?>">
					<h5><?=$numRec?>: <?=$info['cnPointsTotal'];?> (<?=$info['teamName'];?>)</h5>
					<p>
						<?=$info['schoolName'];?>
						<br /><?=$info['proName'];?>
						<br /><?=$info['conferenceName'];?>
						<br /><?=$info['divisionName'];?>
						
						<br />Logo: <?=$info['cnPointsLogo'];?>
						<br />Players: <?=$info['cnPointsPlayers'];?>
						<br />Email: <?=$info['cnPointsEmail'];?>
						<br />Food: <?=$info['cnPointsFood'];?>
						<br />Division:<?=$info['cnPointsDivision'];?>
						<br />Conference: <?=$info['cnPointsConference'];?>
						<br />School: <?=$info['cnPointsTeamSchool'];?>
						<br />Players Picked: <?=$info['cnPointsPlayerPick'];?>
						<br />Trivia: <?=$info['cnPointsTrivia'];?>
						<br />Penalty: <?=$info['cnPointsPenalty'];?>
						<br />Challenge: <?=$info['cnPointsChallenges'];?>
						<br />Current Place: <?=$info['cnCurrentPlace'];?>
						<br />Previous Place: <?=$info['cnPreviousPlace'];?>
						<br />Notes: <?=$info['cnNotes'];?>
					</p>
				</div>
				<?
					$numRec++;
				}?>