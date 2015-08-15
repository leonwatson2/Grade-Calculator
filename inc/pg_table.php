<?php $n = $_GET["n_pg"]; ?> 
<tr> 
	<td>
		<input type="text" class="form-control" placeholder="Assignment 1">
	</td> 
	<td class="hidden-xs">
		<input type="number" class="points-top form-control hidden-xs" placeholder="90"> 
	</td> 
	<td class="hidden-xs">
		<input type="number" class="points-bottom form-control hidden-xs" placeholder="100"> </td> 
	<td>
		<div class="input-group"><input type="number" class="percentage form-control"><span class="input-group-addon">%</span> </div></td> <td class="col-xs-2 btn-group"> <button id="add<?php echo $n; ?>" class="btn btn-primary plus">+</button> <button id="sub<?php echo $n;?>" class="btn btn-danger minus">-</button> 
	</td> 
</tr>