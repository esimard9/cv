$(function(){
	$(".navbar a, footer a").on("click", function(event){
		event.preventDefault();
		var hash = this.hash;
		
		$("body").animate({scrollTop: $(hash).offset().top}, 900, function(){
			window.location.hash = hash;
		});
	});
	
	
	$("#contact-form").submit(function(e){
		e.preventDefault(); //Empêcher le traitement de la page actuel avec une autre page PHP
		$('.comments').empty(); //Vide tous les champs commentaires
		$('.thank-you').empty(); //Vide le champ dont la classe est thank-you
		var postdata = $('#contact-form').serialize(); //Tout le contenu des champs du formulaire vont se retrouver dans la variable postdata
		
		$.ajax({
			type: 'POST',
			url: 'php/contact.php', //où le traitement sera fait
			data: postdata,
			dataType: 'json',
			success: function(result){
				//isSuccess est un des paramètres du tableau  contenant tous les éléments du formulaire
				if(result.isSuccess) {
					$("#contact-form").append("<p class='thank-you'>Votre message été envoyé avec succès. Merci de m'avoir contacté</p>");
					$("#contact-form")[0].reset();
				}
				else {
					$("#id_firstname + .comments").html(result.firstnameError);
					$("#id_lastname + .comments").html(result.lastnameError);
					$("#id_email + .comments").html(result.emailError);
					$("#id_phone + .comments").html(result.phoneError);
					$("#id_msg + .comments").html(result.msgError);
				}
			}
		});
	});
})