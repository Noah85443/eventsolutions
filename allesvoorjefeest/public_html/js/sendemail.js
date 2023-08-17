$(document).ready(function(){
$("#contactform").submit(function(event){
	event.preventDefault(); //prevent default action 
	var post_url = $(this).attr("action"); //get form action url
        
        var voornaam= $(this).find('#voornaam').val();
        var achternaam= $(this).find('#achternaam').val();
        var telefoon= $(this).find('#telefoon').val();
        var email= $(this).find('#email').val();
        var onderwerp= $(this).find('#onderwerp').val();
        var bericht= $(this).find('#bericht').val();
        
	
	$.ajax({
		url : post_url,
		type: "POST",
		data : {voornaam:voornaam, achternaam:achternaam, telefoon:telefoon, email:email, onderwerp:onderwerp, bericht:bericht}
	}).done(function(response){ //
		$("#info").html(response);
                $("#contactform").css("display","none");
	});
});
    });