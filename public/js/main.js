//Button Link Home Page
$(function(){
	$("#btn-link-1").click(function(){
		$('#hp-lien-0').show();
		$('#hp-lien-1').hide();
		$('#hp-lien-2').hide();
		$('#btn-link-1').css({
			"color": "white",
			"background-color": "#e10080",
		});
		$('#btn-link-2').css({
			"color": "#e10080",
			"background-color": "#f8f9fd",
		});
		$('#btn-link-3').css({
			"color": "#e10080",
			"background-color": "#f8f9fd",
		});
	});
	$("#btn-link-2").click(function(){
		$('#hp-lien-0').hide();
		$('#hp-lien-1').show();
		$('#hp-lien-2').hide();
		$('#btn-link-1').css({
			"color": "#e10080",
			"background-color": "#f8f9fd",
		});
		$('#btn-link-2').css({
			"color": "white",
			"background-color": "#e10080",
		});
		$('#btn-link-3').css({
			"color": "#e10080",
			"background-color": "#f8f9fd",
		});
	});
	$("#btn-link-3").click(function(){
		$('#hp-lien-0').hide();
		$('#hp-lien-1').hide();
		$('#hp-lien-2').show();
		$('#btn-link-1').css({
			"color": "#e10080",
			"background-color": "#f8f9fd",
		});
		$('#btn-link-2').css({
			"color": "#e10080",
			"background-color": "#f8f9fd",
		});
		$('#btn-link-3').css({
			"color": "white",
			"background-color": "#e10080",
		});
	});
});
//Login Register
$(function(){
	$("#btn-login").click(function(){
		$('#login-display').show();
		$('#register-display').hide();
		$('#btn-login').css({
			"color": "white",
			"background-color": "#e10080",
		});
		$('#btn-registre').css({
			"color": "#e10080",
			"background-color": "#f8f9fd",
		});
	});
	$("#btn-registre").click(function(){
		$('#login-display').hide();
		$('#register-display').show();
		$('#btn-login').css({
			"color": "#e10080",
			"background-color": "#f8f9fd",
		});
		$('#btn-registre').css({
			"color": "white",
			"background-color": "#e10080",
		});
	});
});
//Button Search
$(function search_pcl_btn(){
$("#search-pcl-btn").click(function search_pcl_btn(){
	$('#search-pcl-filtre').toggle();
	});
});
//formulaire ajout d'amis
jQuery(document).on('click', ".add-friend", function (){
	document.getElementById("friend_receiver").value = jQuery(this).find('input').val();
	var test = document.getElementById("friend_receiver").value;
	console.log(test);
});