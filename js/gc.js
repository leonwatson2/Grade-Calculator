

$(document).ready(function (){

/* Set up for page. */

(function(){
	changeNav($(window).width);
	updateFinalPerc();
	updateFinalGrades();
	updatePercB();
	$(function () {
  $('[data-toggle="popover"]').popover()
	});
	if ($.cookie("firstTime") ==="true") {
		$("#notify-msg").html('<a id="clear-grades>To Clear Example Click Here</a>');
		$("#notify").fadeIn(4000);
		$("#notify-msg").addClass("");
	}
	for (var i = 1; i <= $("#p-groups").children().length; i++) {
		updatePercEach(i);
	}
	$("#p-groups").find(".name").each(function () {
		updateNames($(this));
	});

	if(!isMobileDevice()){	 
		$("#pg-list>table").popover("show");
		$("#pg-table>table").popover("show");
	} 
$("#class-name>input").select();
})();	
/*end setup*/



$(window).resize(function (){
	var width = $(window).width();
	$("#pg-list>table").popover("hide")
	$("#pg-table>table").popover("hide");

	changeNav(width);
});


$("#class-name>input").blur(function(){
	if ($(this).val()=="") {
		$(this).val($(this).attr("placeholder"));
	}
});



$("#p-groups").on("keyup", ".name", function(){
	$id_Str = $(this).attr("id");
	$tbl_Num = $id_Str.substring(10, $id_Str.length);
	$group_name = $("table#group"+$tbl_Num+">thead>tr>th.nm");
	$name = $(this).val();
	if($name == "delete"){
		removeGroup($tbl_Num);
	
	} else {
			$group_name.text($name);
	}
	if($group_name.html() == "")
		$group_name.text($(this).attr("placeholder"));

});
$("body").keyup(function (event) {
	
	if(event.which == 107 || event.which == 187)
		tabs["add-group"]();
});

$('#save-load-delete').on('hidden.bs.modal', function (e) {
  $clickedNumber = 0;
});



$("#p-groups").on("keyup", ".percentage", function(){
	$id_Str = $(this).attr("id");
	$tbl_Num = $id_Str.substring(16, $id_Str.length);
	checkTotalPerc();
	updatePercEach($tbl_Num);
	updateFinalPerc();
	updateFinalGrades();
});

$(".f-percentage").keyup(updateFinalPerc());

$("html").on("keyup", "input", function(event){
	if($(this).hasClass("points-top")){
		$pts_top = $(this);
		$pts_btm = $(this).parent().parent().find(".points-bottom");
		$perc = $(this).parent().parent().find(".percentage");
		if($pts_btm.val() == "")
		$pts_btm.val(100);
	}
	else if($(this).hasClass("points-bottom")){
		$pts_btm = $(this);
		$pts_top = $(this).parent().parent().find(".points-top");
		$perc = $(this).parent().parent().find(".percentage");
		$("#pg-list").find(".points-bottom").val($(this).val());
		if($pts_top.val() == "")
			$pts_top.val($pts_btm.val());
	} else if($(this).hasClass("percentage")){
		$pts_btm = $(this).parent().parent().parent().find(".points-bottom");
		$pts_top = $(this).parent().parent().parent().find(".points-top");
		$pts_btm.val(100);
		$pts_top.val($(this).val());
		updateFinalGrades();
		return;
	} else{
		updateFinalGrades();
		return;
	}
	$percN = parseFloat(($pts_top.val()/$pts_btm.val()));
	if(!isNaN($percN))
		$perc.val(($percN*100).toFixed(0));
	else $perc.val(0);
	checkTotalPerc();
	updateFinalGrades();
});
/*
* on click handelers
*
*/

$("button[data-target=#top-tabs]").on("click", function(){
	changeNav($(window).width());
	});

$("#contact-form").click(function () {
	$("#contact-form").toggleClass("active");
	$("#contact").slideToggle();
})
$("#clear-grades, .clear-grades").click(function (){
	clearCookies();
	$.cookie("firstTime", false);
	location.reload(true);
});
$("#sign-up-btn").click(function () {
	window.location.assign("grdcalc.com/signup.php");
});
$("#pg-table").on('click', "td button", function(event){
	$id_Str = $(this).attr("id");
	$operation = $id_Str.substring(0, 3);
	$tbl_Num = $id_Str.substring(3, $id_Str.length);
	if($operation == "add")
			addTbl($tbl_Num);
	else if ($tbl_Num != 1 || getAssignmentChildren($tbl_Num).length != 1){
		
		$(this).parent().parent().remove();

	}
	$children = getAssignmentChildren($tbl_Num);
	if($children.length == 0 && $tbl_Num != 1){
		removeGroup($tbl_Num);
	}
	updatePercEach($tbl_Num);
});
$("ul.nav-pills li, ul.nav-tabs li").click(function(){
	
	clickedTab = $(this).attr("id");
	if(typeof(clickedTab) != "undefined")
		if(clickedTab != "saves" && clickedTab.substring(0,4) != "load"){
			if(hasDigit(clickedTab)){
				tabs[clickedTab.substring(0,4)](Number(clickedTab.substring(4,clickedTab.length)));
			} else tabs[$(this).attr("id")]();
		} 
		
});
$("#save-class, #delete-class, #load-class").click(function(){
	$clicked = $(this).attr("id");
	switch($clicked){
		case "save-class": saveClass($clickedNumber);
			break;
		case "load-class": loadClass($clickedNumber);
			break;
		default: deleteClass($clickedNumber);
	}
	$("#save-load-delete").modal("hide");
});
$("#class-name>input").click(function(){
	$(this)[0].setSelectionRange(0,999);
});
$("#print").click(function(){
	window.print()
});


$("#saves").on("click","#load1, #load2, #load3",function(){
	clickedTab = $(this).attr("id");
	$num = Number(clickedTab.substring(4,clickedTab.length));
	choiceModal($num);
	
});

/*
*	Form Validation
*
*/
$validForm = [false, false, false];
$("#contact-me").on('keyup blur','input,textarea',function(event){
	
	$formPart = $(this).attr("id");
	if($formPart=="ymail"){
		var regEmail = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/;
		if(regEmail.exec($(this).val())==null){
			addError($formPart);
			$validForm[0] = false;
		} else{
			addSuccess($formPart);
			$validForm[0] = true;
		} 
	}else if($formPart == "yName"){
		if($(this).val().length < 1){
			addError($formPart);
			$validForm[1] = false;
		} else {
			addSuccess($formPart);
			$validForm[1] = true;
		}
	} else if($formPart == "ymessage"){
		if($(this).val().length < 10){
			addError($formPart);
			$validForm[2] = false;
		} else {
			addSuccess($formPart);
			$validForm[2] = true;
		} 
	}
	if($validForm[0] && $validForm[1] && $validForm[2])
		$("#submit-btn").addClass("has-success").removeClass("has-error");
	else 
		$("#submit-btn").addClass("has-error").removeClass("has-success");


});
$("#contact-me").submit(function(e){
			e.preventDefault();
			if($("#submit-btn").hasClass("has-success")){
				post_data={
					'yName':$("#yName").val(),
					'email': $("#ymail").val(),
					'ymessage':$("#ymessage").val()
				};

				$.post('inc/sendMail.php', post_data, function(response){
					if(response.type != "error"){ 
						$("#submit-btn").html("Got it!").attr("type","button");
					}			
					else 
						$("#submit-btn").html("Try again");
					
				});
			} else {
				$('html, body').animate({
				    scrollTop: $(".has-error").offset().top
				}, 500);
			}
});
$('body').scrollspy({ target: '#spying-scroll' });






/*sign in or up or out*/

$signupForm = [false,false,false];
$("#sign-up-form").on("keyup blur", "input",function () {
	$formPart = $(this).attr("id");
	console.log("sign up form test;?");
	if($formPart=="ymail"){
		var regEmail = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/;
		if(regEmail.exec($(this).val())==null){
			addError($formPart);
			$signupForm[0] = false;
		} else{
			addSuccess($formPart);
			$signupForm[0] = true;
		} 
	}else if($formPart == "yName"){
		if($(this).val().length < 4){
			addError($formPart);
			$signupForm[1] = false;
		} else {
			addSuccess($formPart);
			$signupForm[1] = true;
		}
	} else if($formPart == "pass"){
		if($(this).val().length < 7){
			addError($formPart);
			$signupForm[2] = false;
		} else {
			addSuccess($formPart);
			$signupForm[2] = true;
		} 
	}
	if($signupForm[0] && $signupForm[1] && $signupForm[2])
		$(".submit-btn").addClass("has-success").removeClass("has-error");
	else 
		$(".submit-btn").addClass("has-error").removeClass("has-success");
});

$("#sign-up-form").submit(function(e){
	e.preventDefault();
	if($(".submit-btn").hasClass("has-success")){
		post_data={
			'username':$("#yName").val(),
			'email': $("#ymail").val(),
			'pass':$("#pass").val()
		};
		/* DONT FORGET TO CHANGE THIS*/
			$url = "http://grdcalc.com/mysql/newUser.php";
		$.post($url, post_data, function(e){
			if(isNaN(parseInt(e))){ 
				$("#signup").html("Got it!").attr("type","button");
				$("#error-panel").slideUp();
				$.post("http://grdcalc.com/mysql/confirmEmail.php", post_data, confirmEmail());
			}			
			else {
				$("#error-panel").slideDown();
				$("#error-panel").children(".panel-body").html($error[parseInt(e)]);

			}
			console.log(parseInt(e));
		});
	}
});
$("#login").click(function(e){
	loginForm(e);
});
$(".firstTit, .secondTit").click(function(){
	window.location.assign("http://grdcalc.com");
});


$(".popover").click(function () {
	$(this).hide();
});
$(function () {
  $('[data-toggle="popover"]').popover()
});

	

})

