<?php $n = $_GET["n_pg"]; 
$groups = array("Quizzes", "Projects", "Labs", "Exams", "Participation");
?>
<tr style = "display:none">
 <td>
 <input id="group-name<?php echo $n; ?>" type="text" class="name form-control" placeholder="<?php echo $groups[($n-2)%count($groups)]; ?>">
 </td>
 <td class="hidden-xs">
 <input id="group-points<?php echo $n; ?>" type="number" class="points-top form-control" placeholder="90">
 </td>
 <td class="hidden-xs">
 <input id="group-outof<?php echo $n; ?>" type="number" class="points-bottom form-control" placeholder="100">
 </td>
 <td>
 <div class="input-group">
 	<input id="group-percentage<?php echo $n; ?>" type="number" class="percentage form-control">
<span class="input-group-addon">%</span>
 </div>
 </td>
 </tr>
