<?php $n = $_GET["n_pg"]; 
if($n%2 == 0){$tbl_type="grade-table2 pull-right"; 
} else {$tbl_type="grade-table pull-left"; 
} 
$groups = array("Quizzes", "Projects", "Labs", "Exams", "Participation");

?> <table id="group<?php echo $n ?>" class="<?php echo $tbl_type; ?> table col-md-6 col-sm-12" style="display:none;"> 
<thead> 
	<tr> 
		<th class="col-sm-3 col-xs-5 nm"><?php echo $groups[($n-2)%count($groups)]; ?></th> 
		<th class="hidden-xs col-sm-3">Points</th> 
		<th class="hidden-xs col-sm-3">Total # of points</th> 
		<th class="col-sm-3 col-xs-5">Percentage</th> 
		<th class="percent-each col-sm-2 col-xs-5">20% each.
		</th> 
	</tr> 
</thead> 
<tbody id="pg-assignments<?php echo $n; ?>">


</tbody> 
</table>