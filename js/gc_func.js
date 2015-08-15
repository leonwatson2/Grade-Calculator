var tabs = {
			"group-tab":function(){ 
				$("#group-tab").toggleClass("active");
				$("#pg-list").slideToggle();
			},
			"grades-tab":function(){ 
				$("#grades-tab").toggleClass("active");
				$("#final-group, #pg-table").slideToggle();
			},
			"final-tab":function(){
				$("#final-tab").toggleClass("active");
				$("#finals").slideToggle();
			},
			"add-group":function(){
				if(!$("#add-group").hasClass("disabled")){
				$("#add-group").addClass("disabled");
					$n_pg++;
					if(!isMobileDevice())
					$(".div").show(1500);
					$.ajax({
						url:"inc/pg.php?n_pg="+$n_pg

					}).done(function (data){
						$("#p-groups").append(data);
						$("#group-name"+$n_pg).parent().parent().fadeIn(1500);
						startTbl();
							
					}).complete(function (){
						$(".div").hide(1500);
					});
				}
			},
			"save":function(num){
				saveClass(num);
			}
			

		};
$error = [
		"",
	"There was the problem with the server please try again.",
	"Error with E-Mail/Password combination.",
	"There seems to be somebody with that email/username already signed up!"
];
$n_pg=$("#pg-groups").find("tr").length+1;
(function(){

	var waypoint = new Waypoint({
  		element: document.getElementById('clear-grades'),
  		handler: function(direction) {
  		direction == "down" ? $("#clear-grades").popover('show') : $("#clear-grades").popover("hide");
  	},
  	offset:'bottom-in-view'
});

$clickedNumber = 0;
});

function isMobileDevice(){
	//Stack overflow
	if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
 		return true;
	} else 
		return false;
}

function changeNav (width) {
	if(width < 751){
		$("#top-tabs>ul").removeClass("nav-tabs").addClass("nav-pills").addClass("nav-stacked");
		$("#add-group").removeClass("pull-right");
	} else{
		$("#top-tabs>ul").addClass("nav-tabs").removeClass("nav-pills").removeClass("nav-stacked");
		$("#add-group").addClass("pull-right");
	}
}

function checkTotalPerc () {
	$total_perc=0;
	for (var i = $n_pg - 1; i >= 0; i--) {
		if(typeof $("#p-groups .percentage")[i] != "undefined")
		$total_perc = $total_perc + parseFloat($("#p-groups .percentage")[i].value);
	};
	if($(".f-percentage").val() != "")
		$total_perc = $total_perc + parseFloat($(".f-percentage").val());

	if($total_perc > 115){
		$("#percent-alert").slideDown();
	} else {
		$("#percent-alert").slideUp();
	}
}

function getAssignmentChildren (n) {
	$group = $("#pg-assignments"+n);
	return $group.children();
}


function startTbl () {
	$.ajax({
		url:"inc/pg_table_start.php?n_pg="+$n_pg	}).done(function (data){
		$("#pg-table").append(data);
		addTbl($n_pg);
		$("#group"+$n_pg).fadeIn(2500, function () {
			$("#add-group").removeClass("disabled");
		});
	});

}


function addTbl(n) {
	$.ajax({
		url:"inc/pg_table.php?n_pg="+n
	}).done(function (data){
		$("#pg-assignments"+n).append(data);
		$("#pg-assignments"+n).fadeIn(4000, function (){
			updatePercEach(n);
		});
	});	
}


function removeGroup (n) {
	$("#group-name"+n).parent().parent().slideUp();
	$("#group-name"+n).parent().parent().detach();
	$("#group"+n).detach();
}
function updateFinalPerc () {
	$final_perc = parseInt($(".f-percentage").val());
	if(isNaN($final_perc))
		$("#final-group>thead>tr>th.f-percent-each").html("No % yet.");	
	else 
		$("#final-group>thead>tr>th.f-percent-each").html($final_perc + "% of grade.");
	checkTotalPerc();
}

function updatePercEach (tblNum) {
	$group_perc = $("table#group"+tblNum+">thead>tr>th.percent-each");
	$perc = $("#group-percentage"+tblNum).val();
	$num_of_grads = $("table #pg-assignments"+tblNum+">tr").length;
	$perc_each = parseFloat((parseInt($perc) / parseInt($num_of_grads)).toFixed(2));
	if(!isNaN($perc_each))
		$group_perc.html($perc_each + "% each");
	else 
		$group_perc.html("No % yet.");
}

function updateFinalGrades () {
	$final_exam = parseFloat(parseInt($(".f-percentage").val()) * parseFloat($("#final-exam-grade").find(".percentage").val()));
	$final_exam /= 100;
	$("#final-grade").html(getFinalGradeNoFinal()+parseFloat($final_exam));
	if($("#final-grade").html()==""){
		$("#final-grade").parent().slideUp();
	} else $("#final-grade").parent().slideDown();

	$("#final-grade-wo").html(getFinalGradeNoFinal());
	if ($n_pg != 1) {
		saveGrades();
	}
}


function getFinalGradeNoFinal(){
	$groups = $("#p-groups").children();
	$final_grade = 0;
	for (var i = 0; i < $groups.length; i++) {
		$id_Str = $($($groups[i]).children().children()[0]).attr("id");
		$tbl_Num = $id_Str.substring(10, $id_Str.length);
		$final_grade += parseFloat(getGroupFinalPerc($tbl_Num));
	};
	return $final_grade;

}


function getGroupFinalPerc (n) {
	$perc = parseFloat($("#group-percentage"+n).val());
	$final_perc = parseFloat(getGroupAverage(n)*$perc/100);
	return $final_perc.toFixed(2);
}


function getGroupAverage (n) {
	$assignments = getAssignmentChildren(n);
	$total_perc = 0;
	for (var i = 0;  i < $assignments.length; i++) {
		$x = parseFloat($($assignments[i]).children().children().children(".percentage").val());
		if(!isNaN($x))
		$total_perc += $x;
	};
	return $total_perc/$assignments.length;
}


function addError (id) {
	$("#"+id).parent().addClass("has-error").removeClass("has-success");
	$("#"+id).next().addClass("glyphicon glyphicon-remove form-control-feedback");
}
function addSuccess (id) {
	$("#"+id).parent().removeClass("has-error").addClass("has-success");
	$("#"+id).next().addClass("glyphicon glyphicon-ok form-control-feedback").removeClass("glyphicon-remove");
}


var saved=[
	{"class-name":""},
	{"groups":[]},
	{"assignments":[["",""]]},
	{"final":["",""]}
];
// Saves grades to cache
function saveGrades () {
	saved["groups"]=[];
	saved["assignments"]=[[]];
	var className = $("#class-name>input").val();
	saved["class-name"]=className;
	$groups= $("#p-groups").children("tr").length;
	for (var i = 0, n_g=0; i < $n_pg; i++) {
		$group=$("#p-groups").children("tr")[i];
		$name = $("#p-groups").find("#group-name"+(i+1)).val();
		$percent = $("#p-groups").find("#group-percentage"+(i+1)).val();
		if(typeof $name != "undefined"){
			n_g++;
			saved["groups"].push([$name,$percent]);
			saved["assignments"].push([]);
			for (var j = 0; j < $("#pg-assignments"+(i+1)+">tr").length; j++) {
				$assignment_name = $("#pg-assignments"+(i+1)).find("td>input[type=text]")[j].value;
				$assignment_perc = $("#pg-assignments"+(i+1)).find(".percentage")[j].value;
				$assignment = [$assignment_name, $assignment_perc];
				saved["assignments"][n_g].push($assignment);
			};
		}
	}; 
	saved["final"] =[$(".f-percentage").val(),$("#final-exam-grade").find(".percentage").val()];
	saved["assignments"].shift();
	$.cookie('className', saved["class-name"]);
	$.cookie('groups',JSON.stringify(saved["groups"]));
	$.cookie('assignments', JSON.stringify(saved["assignments"]));
	$.cookie('final', JSON.stringify(saved["final"]));
	
}

function getCookies () {
	$old_groups = $.parseJSON($.cookie("groups"));
	alert($old_groups);
}
function setOldGroups (groups) {
	$g_length = groups.length;
	alert(groups[1][0]);
	$("#group-name1").val(groups[0][0]);
	$("#group-percentage1").val(groups[0][1]);
	for (var i = 1; i < groups.length; i++) {
		$.when(tabs["add-group"]()).then(function(){
			$("#group-name"+(i+1)).val(groups[i][0]);
		$("#group-percentage"+(i+1)).val(groups[i][1]);
		});
		
	};
}

function clearCookies () {
	$.cookie('className',"Enter class name!");
	$.cookie('groups',"['','']");
	$.cookie('assignments',"[['','']]");
	$.cookie('final',"['10','']");
}
function updateNames(tbl){
	if (tbl !="all"){
		$id_Str = tbl.attr("id");
		$tbl_Num = $id_Str.substring(10, $id_Str.length);
		$group_name = $("table#group"+$tbl_Num+">thead>tr>th.nm");
		$name = tbl.val();
		if($name == "delete"){
			removeGroup($tbl_Num);
		
		} else {
			$group_name.text($name);
		}
		if($group_name.html() == "")
			$group_name.text(tbl.attr("placeholder"));
	} else {
		for($i=1; $i <= $("#p-groups>tr").length; $i++){
			tbl = $("#group-name"+$i);
			$group_name = $("#group"+$i+">thead>tr>th.nm");
			$name = $("#group-name"+ $i).val();
			//Somethins wrong here
			$group_name.text($name);
		}
	}
	
}

function updatePercB () {
	$(".percentage").each(function(){
		$pts_btm = $(this).parent().parent().parent().find(".points-bottom");
		$pts_top = $(this).parent().parent().parent().find(".points-top");
		$pts_btm.val(100);
		$pts_top.val($(this).val());
		updateFinalGrades();
	});
	$("#p-groups tr").each(function(){
		$n_pg++;
	});
}

function confirmEmail (){
	$("#sign-up-form").slideUp();
	$confirm_msg = "Thanks for signing up! We have sent you a confirmation email to activate your account! Due to our server being in the UK please allow 24 hours to recieve it!";
	$("#confirm-email .panel-body").html($confirm_msg);
	$("#confirm-email").slideDown();
}

function loginForm(e){
	e.preventDefault();
	post_data={
			'email': $("#user-name").val(),
			'pass':$("#pass").val()
		};
	$.post("/signin.php", post_data, function(e){
			if(isNaN(parseInt(e))){ 
				$("#login-modal").modal("toggle");
				location.reload(true);
			}			
			else {
				$("#error-panel").slideUp().slideDown();
				$("#error-panel").children(".panel-body").html($error[parseInt(e)]);

			}
			console.log(e);
			
		});
}
function choiceModal($num){
	$("#save-load-delete").modal("show");
	$("#clicked-class").html($("#load"+$num+" a").html());
	$clickedNumber = $num;	
}
function saveClass ($num) {
	
		post_data = {
			"class" : $.cookie("className"),
			"groups" : $.cookie("groups"),
			"assignments" : $.cookie("groups"),
			"final" : $.cookie("groups"),
			"num" : $num
		};
		$.post("inc/saveClass.php", post_data, function(response){
			$("#save"+$num+">a").html($.cookie("className"));
			$("#save"+$num+">a").addClass("saved"); $("#save"+$num).attr("id","load"+$num);
			
			if (response == "Error") {
				console.error("Grdcalc:There was an error with our servers.");
			}
		
			//Used to make sure the php updates itself when refreshed
			$.cookie('updated', true);
		});

		notifyUser("Saved Class \"" + post_data["class"] + "\"");
		
}
function loadClass($num){
	
	$url = "http://grdcalc.com/mysql/loadUserClass.php";
	$post_data = {
		'num' : $num
	};
	$.post($url, $post_data, function(response){
	$Class = JSON.parse(response);
	$.cookie('className', $Class["Class"]);
	$.cookie('groups',JSON.stringify($Class["groups"]));
	$.cookie('assignments', JSON.stringify($Class["assignments"]));
	$.cookie('final', JSON.stringify($Class["final"]));
	$("#class-name>input").val($Class["Class"])
	$("#pg-list").html(getGroups($Class["groups"]));
	$("#pg-table").html(getAssignments($Class["assignments"]));
	}).done(function(){ 
		updatePercB();
		updateNames("all");
		updateFinalPerc();
		updateFinalGrades();
		updateFinalPerc();	
	 notifyUser("Loaded class \""+ $.cookie('className') + "\"");
	});
	//Used to make sure the php updates itself when refreshed
	$.cookie('updated', true);
	
}
function deleteClass($num){
	$className = $("#load"+$num+">a").html();
	$("#load"+$num+">a").html("Save Class");
	$("#load"+$num).attr("id", "save"+$num);
	$post_data = {
		'num':$num
	};
	$url = "http://grdcalc.com/mysql/deleteUserClass.php";
	$.post($url, $post_data, function(response){
		if(response != "1") console.error("Grdcalc.com: Something went wrong with our server. ", response);

		notifyUser("Deleted class \""+$className+"\"");
	});
	$.cookie("updated", false);
}
function getGroups($groups){
	$string = '<h3>Percent Group List</h3>';
				$string +='<table class="sorted-table table">';
						$string +='<thead>';
							$string +='<tr>';
								$string +='<th class="col-xs-6 col-sm-4">Name</th>';
								$string +='<th class="hidden-xs col-sm-2">Points</th>';
								$string +='<th class="hidden-xs col-sm-2">Total # of points</th>';
								$string +='<th class="col-xs-6 col-sm-3">Percentage</th>';
							$string +='</tr>';
						$string +='</thead>';
						$string +='<!-- <h2>Your Window Width: <span id="width">	</span></h2> -->';
						$string +='<tbody id="p-groups">';
							$string +='<tr>';
								$string +='<td>';
									$string +='<input id="group-name1" type="text" class="name form-control" value="'+$groups[0][0]+'"placeholder="Homeworks">';
								$string +='</td>';
								$string +='<td class="hidden-xs">';
									$string +='<input id="group-points1" type="number" class="points-top form-control" placeholder="90">';
								$string +='</td>';
								$string +='<td class="hidden-xs">';
									$string +='<input id="group-outof1"type="number" class="points-bottom form-control" placeholder="100">';
								$string +='</td>';
								$string +='<td>';
									$string +='<div class="input-group">';
										$string +='<input id="group-percentage1" type="number" value="'+$groups[0][1]+'" class="percentage form-control"><span class="input-group-addon">%</span>';
									$string +='</div>';
								$string +='</td>';
							$string +='</tr>';
							$string +=addGroupTop($groups);
						$string +='</tbody>';
						$string +='<tfoot>';
							$string +='<tr>';
								$string +='<td ><input disabled type="text" class="form-control" value="Final Exam">';
								$string +='</td>';
								$string +='<td class="hidden-xs"><input type="number" class="points-top form-control" placeholder="90">';
								$string +='</td>';
								$string +='<td class="hidden-xs"><input type="number" class="points-bottom form-control" placeholder="100">';
								$string +='</td>';
								$string +='<td ><div class="input-group">';
											$string +='<input type="number" value="<?php echo $final[0]; ?>" class="f-percentage percentage form-control"><span class="input-group-addon">%</span>';
										$string +='</div>';
								$string +='</td>';
							$string +='</tr>';
						$string +='</tfoot>';
				$string +='</table>';
				return $string;
				
}
function addGroupTop ($groups){
	$string = "";
	for ($i=1; $i < $groups.length; $i++) { 
	 $string+='<tr>';
		$string+='<td>';
			$string+='<input id="group-name' +($i+1)+ '" type="text" class="name form-control" value="' +$groups[$i][0]+ '"placeholder="Homeworks">';
		$string+='</td>';
	 $string+='<td class="hidden-xs">';
			$string+='<input id="group-points' +($i+1)+ '" type="number" class="points-top form-control" placeholder="90">';
		$string+='</td>';
		$string+='<td class="hidden-xs">';
			$string+='<input id="group-outof' +($i+1)+ '" type="number" class="points-bottom form-control" placeholder="100">';
		$string+='</td>';
		$string+='<td>';
	  $string+='<div class="input-group">';
				$string+='<input id="group-percentage' +($i+1)+ '" type="number" value="' +$groups[$i][1]+ '"class="percentage form-control"><span class="input-group-addon">%</span>';
			$string+='</div>';
		$string+='</td>';
	$string+='</tr>';
	}
	return $string;
}

function getAssignments($assignments){
	$string = "";
	for ($i=0; $i < $assignments.length; $i++) { 
		$string += '<table id="group' +($i+1)+ '" class="col-md-6 col-xs-12 table grade-table">';
			$string += '<thead>';
				$string += '<tr>';
					$string += '<th class="col-sm-3 col-xs-5 nm">Homeworks</th>';
					$string += '<th class="hidden-xs col-sm-3">Points</th>';
					$string += '<th class="hidden-xs col-sm-3">Total # of points</th>';
					$string += '<th class="col-sm-3 col-xs-5">Percentage</th>';
					$string += '<th class="percent-each col-sm-2 col-xs-5">20% each.</th>';
				$string += '</tr>';
			$string += '</thead>';
			$string += '<tbody id="pg-assignments' +($i+1)+ '">';
			$substring = "";
			for ($j=0; $j < $assignments[$i].length; $j++) { 
			$substring += '<tr>';
					$substring += '<td><input type="text" class="form-control" value="'+$assignments[$i][$j][0]+'"placeholder="Assignment ' +($j+1)+ '"></td>';
					$substring += '<td class="hidden-xs"><input type="number" class="points-top form-control" placeholder="90">';
					$substring += '</td>';
					$substring += '<td class="hidden-xs"><input type="number" class="points-bottom form-control" placeholder="100">';
					$substring += '</td>';
					$substring += '<td ><div class="input-group">';
						$substring += '<input type="number" value="'+$assignments[$i][$j][1]+'"class="percentage form-control"><span class="input-group-addon">%</span>';
					$substring += '</div>';
					$substring += '</td>';
					$substring += '<td class="btn-group col-sm-2 col-xs-2"> ';
						$substring += '<button id="add' +($i+1)+ '" class="btn btn-primary plus">+</button>';
						$substring += '<button id="sub' +($i+1)+ '" class="btn btn-danger minus">-</button>';
					$substring += '</td>';
				$substring += '</tr>';
			}//endfor(j)
		$string+=$substring;
		$string+='</tbody>';
		$string+='</table>';
	}//end for(i)
	return $string;
}

function notifyUser($string){
	$("#notify-msg").html($string);
	$("#notify").fadeIn(1000).delay(2500).fadeOut(2000);
}
function hasDigit(temp){
	return /\d/.test(temp);
}