<?php 
include('http://grdcalc.com/mysql/server.php');
$randmessage = array("Your site is awesome!", 
						"I wish you would make me my website!", 
						"This is pretty cool. . .",
						"Thanks man! This really helps!",
						"You're amazing!",
						"I'm definately following you on twitter! @_Vlw2",
						"Let's work on a project together!"); 
$popovers = array(
	'clear-grades' => 'data-container="body" data-toggle="popover" data-trigger="focus" data-placement="top" title="Clear Example" data-content="Clear the example and start your own."',
	'pg-list' => 'data-container = "body" data-toggle="popover" data-trigger="focus" data-placement="top" data-content="Enter the name and weight of each part of your grade here"',
	'pg-table' => 'data-container = "body" data-toggle="popover" data-trigger="focus" data-placement="top" data-content="Enter the name and grade for each assignment here."');
$ex_className = 'Science Example';
$ex_groups = array(

	array('my Homeworks', '25'),
	array('my Labs', '10'),
	array('my quizzes', '45')

	);
$ex_assignments = json_decode('[[["hw1","100"],["hw2","100"],["hw3","69"],["hw4","80"]],[["lab1","80"],["lab2","100"],["lab3","100"],["lab4","100"]],[["Quiz1","78"]]]');
$ex_final = array('15','85');
$totalClasses=3;
function setupPageValues(){

}

function addGroupTop($groups)
{
	//echo count($groups);
	for ($i=1; $i < count($groups); $i++) { 
	echo '<tr>
		<td>
			<input id="group-name' .($i+1). '" type="text" class="name form-control" value="' .$groups[$i][0]. '"placeholder="Homeworks">
		</td>';
	echo '<td class="hidden-xs">
			<input id="group-points' .($i+1). '" type="datetime" class="points-top form-control" placeholder="90">
		</td>
		<td class="hidden-xs">
			<input id="group-outof' .($i+1). '" type="number" class="points-bottom form-control" placeholder="100">
		</td>
		<td>';
	echo  '<div class="input-group">
				<input id="group-percentage' .($i+1). '" type="number" value="' .$groups[$i][1]. '"class="percentage form-control"><span class="input-group-addon">%</span>
			</div>
		</td>
	</tr>';
	}
}

function assignments($assignments)
{
	for ($i=1; $i < count($assignments); $i++) { 
		echo '<table id="group' .($i+1). '" class="col-md-6 col-xs-12 table grade-table">
			<thead>
				<tr>
					<th class="col-sm-3 col-xs-5 nm">Homeworks</th>
					<th class="hidden-xs col-sm-3">Points</th>
					<th class="hidden-xs col-sm-3">Total # of points</th>
					<th class="col-sm-3 col-xs-5">Percentage</th>
					<th class="percent-each col-sm-2 col-xs-5">20% each.</th>
				</tr>
			</thead>
			<tbody id="pg-assignments' .($i+1). '">';
			for ($j=0; $j < count($assignments[$i]); $j++) { 
			echo '<tr>
					<td><input type="text" class="form-control" value="'.$assignments[$i][$j][0].'"placeholder="Assignment ' .($j+1). '"></td>
					<td class="hidden-xs"><input type="number" class="points-top form-control" placeholder="90">
					</td>
					<td class="hidden-xs"><input type="number" class="points-bottom form-control" placeholder="100">
					</td>
					<td ><div class="input-group">
						<input type="number" value="'.$assignments[$i][$j][1].'"class="percentage form-control"><span class="input-group-addon">%</span>
					</div>
					</td>
					<td class="btn-group col-sm-2 col-xs-2"> 
						<button id="add' .($i+1). '" class="btn btn-primary plus">+</button>
						<button id="sub' .($i+1). '" class="btn btn-danger minus">-</button>
					</td>
				</tr>';
			}//endfor(j)
		echo	'</tbody>
		</table>';
	}//end for(i)
}

function firstAssignments($assignments)
{	

	if($assignments == ""){
			$assignments = array( array(array("",100)) );
	}
	for ($i=0; $i < count($assignments[0]); $i++) { 
	echo '<tr>
		<td><input type="text" class="form-control" value="'.$assignments[0][$i][0].'" placeholder="Assignment 1"></td>
		<td class="hidden-xs"><input type="number" class="points-top form-control" placeholder="90">
		</td>
		<td class="hidden-xs"><input type="number" class="points-bottom form-control" placeholder="100">
		</td>
		<td ><div class="input-group">
			<input type="number" class="percentage form-control" value="'.$assignments[0][$i][1].'"><span class="input-group-addon">%</span>
		</div>
		</td>
		<td class="btn-group col-sm-2 col-xs-2"> 
			<button id="add1" class="btn btn-primary plus">+</button>
			<button id="sub1" class="btn btn-danger minus">-</button>
		</td>
	</tr>';
	}//end for()
}

function getClassNames($link){
	 $query="SELECT * FROM `saves` WHERE `id`='".$_SESSION['id']."'";
	 if ($result=mysqli_query($link, $query)) {
		$row = mysqli_fetch_array($result);
	return $row;
	} else return 0;
}

function hasClass($row,$number){
	
	if ($row["Class".$number]==""){ 
		$listItem = '<li id="save'.$number.'">';
		$listItem = $listItem . '<a role="menuitem" tabindex="-1"> Save Class';
		$listItem = $listItem . '</a>';
		$listItem = $listItem . '</li>';
		return $listItem;
	}
	else {
		$listItem = '<li id="load'.$number.'">';
		$listItem = $listItem . '<a class="saved" role="menuitem" tabindex="-1">'.$row["Class".$number].'</a>';
		$listItem = $listItem . '</li>';
		return $listItem;
	}
}
function printClass($row,$number){
	echo "<br>";
	echo "Class Name: ".$row["Class".$number];
	echo "<br>";
	echo "Groups: ".$row["groups".$number];
	echo "<br>";
	echo "Final: ".$row["final".$number];
}


 ?>