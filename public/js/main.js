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

//envoie du formulaire add-friend
window.addEventListener("load", function () {
	//formulaire ajout d'amis
	jQuery(document).on('click', ".add-friend", function (){
		document.getElementById("friend_receiver").value = jQuery(this).find('input').val();

		// Accédez à l'élément form …
		var form = document.getElementById("add-friend");

		// … et prenez en charge l'événement submit.
		form.addEventListener("submit", function (event) {
			event.preventDefault();
		});

		sendData(form);

		return false;
	});
	function sendData(form) {
		var XHR = new XMLHttpRequest();
		var FD = new FormData(form); // Liez l'objet FormData et l'élément form

		// Définissez ce qui se passe si la soumission s'est opérée avec succès
		XHR.addEventListener("load", function(event) {
			alert(event.target.responseText);
		});

		// Definissez ce qui se passe en cas d'erreur
		XHR.addEventListener("error", function(event) {
			alert('Oups! Quelque chose s\'est mal passé.');
		});

		// Configurez la requête
		XHR.open("POST", "{{ path('add-friend') }}");

		// Les données envoyées sont ce que l'utilisateur a mis dans le formulaire
		XHR.send(FD);
	}
});