
$(document).ready(function() {
//jQuery time
var current_fs, next_fs, previous_fs; //fieldsets
var left, opacity, scale; //fieldset properties which we will animate
var animating; //flag to prevent quick multi-click glitches

$("#Ministry").click(function(){
  $("#Ministryli").addClass("selected");
});
$(".date").datepicker({ dateFormat: "yy-mm-dd" });
$(".next").click(function(){
	if(animating) return false;
	animating = true;
	
	current_fs = $(this).parent();
	next_fs = $(this).parent().next();
	
	//activate next step on progressbar using the index of next_fs
	$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
	
	//show the next fieldset
	next_fs.show(); 
	//hide the current fieldset with style
	current_fs.animate({opacity: 0}, {
		step: function(now, mx) {
			//as the opacity of current_fs reduces to 0 - stored in "now"
			//1. scale current_fs down to 80%
			scale = 1 - (1 - now) * 0.2;
			//2. bring next_fs from the right(50%)
			left = (now * 50)+"%";
			//3. increase opacity of next_fs to 1 as it moves in
			opacity = 1 - now;
			current_fs.css({'transform': 'scale('+scale+')'});
			next_fs.css({'left': left, 'opacity': opacity});
		}, 
		duration: 800, 
		complete: function(){
			current_fs.hide();
			animating = false;
		}, 
		//this comes from the custom easing plugin
		easing: 'easeInOutBack'
	});
});
$('#slides').slides({
				preload: true,
				generateNextPrev: false,
				play:10000,
				generatePagination:false,
				fadespeed:10000,
				effect:'fade'
				
});

$(".previous").click(function(){
	if(animating) return false;
	animating = true;
	
	current_fs = $(this).parent();
	previous_fs = $(this).parent().prev();
	
	//de-activate current step on progressbar
	$("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
	
	//show the previous fieldset
	previous_fs.show(); 
	//hide the current fieldset with style
	current_fs.animate({opacity: 0}, {
		step: function(now, mx) {
			//as the opacity of current_fs reduces to 0 - stored in "now"
			//1. scale previous_fs from 80% to 100%
			scale = 0.8 + (1 - now) * 0.2;
			//2. take current_fs to the right(50%) - from 0%
			left = ((1-now) * 50)+"%";
			//3. increase opacity of previous_fs to 1 as it moves in
			opacity = 1 - now;
			current_fs.css({'left': left});
			previous_fs.css({'transform': 'scale('+scale+')', 'opacity': opacity});
		}, 
		duration: 800, 
		complete: function(){
			current_fs.hide();
			animating = false;
		}, 
		//this comes from the custom easing plugin
		easing: 'easeInOutBack'
	});
});

$(".submit").click(function(){	
	var Surname				= document.getElementById("Surname").value;
	var Name  				= document.getElementById("Name").value;
	var Dateofbirth 		= document.getElementById("Dateofbirth").value;
	var Telephonework  		= document.getElementById("Telephonework").value;
	var Cellphone 			= document.getElementById("Cellphone").value;
	var EmailAddress  		= document.getElementById("EmailAddress").value;
	var Datemarriage		= document.getElementById("Datemarriage").value;
	var Surnamewife			= document.getElementById("Surnamewife").value;
	var Namewife			= document.getElementById("Namewife").value;
	var Dateofbirthwife		= document.getElementById("Dateofbirthwife").value;
	var Telephoneworkwife	= document.getElementById("Telephoneworkwife").value;
	var Cellphonewife		= document.getElementById("Cellphonewife").value;
	var EmailAddresswife	= document.getElementById("EmailAddresswife").value;
	var residential			= document.getElementById("residential").value;
	var postal				= document.getElementById("postal").value;
	var emergency			= document.getElementById("emergency").value;
	var nochildren			= document.getElementById("nochildren").value;
	save_signup_entry(Surname,Name,Dateofbirth,Telephonework,Cellphone,EmailAddress,Datemarriage,Surnamewife,Namewife,Dateofbirthwife,Telephoneworkwife,Cellphonewife,EmailAddresswife,residential,postal,emergency,nochildren);
});

function save_signup_entry(Surname,Name,Dateofbirth,Telephonework,Cellphone,EmailAddress,Datemarriage,Surnamewife,Namewife,Dateofbirthwife,Telephoneworkwife,Cellphonewife,EmailAddresswife,residential,postal,emergency,nochildren) {
    var url = 'ajax.php?action=save_signup_entry';
    url    += '&Surname='    		+ Surname;
    url    += '&Name='       		+ Name;
    url    += '&Dateofbirth='      	+ Dateofbirth;
    url    += '&Telephonework='    	+ Telephonework;
    url    += '&Cellphone='   		+ Cellphone;
    url    += '&EmailAddress='      + EmailAddress;
    url    += '&Datemarriage='      + Datemarriage;
    url    += '&Surnamewife='      	+ Surnamewife;
    url    += '&Namewife='      	+ Namewife;
    url    += '&Dateofbirthwife='   + Dateofbirthwife;
    url    += '&Telephoneworkwife=' + Telephoneworkwife;
    url    += '&nochildren='   		+ nochildren;
    url    += '&Cellphonewife&='   	+ Cellphonewife;
    url    += '&EmailAddresswife='  + EmailAddresswife;
    url    += '&residential='   	+ residential;
    url    += '&postal='   			+ postal;
    url    += '&emergency='   		+ emergency;
    var result = ajax_get_data(url);
    return result;
   
}

function ajax_get_data(this_url) {
	// Get Response
	var new_html = $.ajax({
		url: this_url,
		async: false,
		dataType: "html"
	}).responseText;
	alert(new_html);
	// Return Response
	return new_html;
}

});
