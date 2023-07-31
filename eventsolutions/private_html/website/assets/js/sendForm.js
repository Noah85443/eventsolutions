// JavaScript Document
function sendForm()
{

	var name = document.getElementById("name").value;
	var mail = document.getElementById("email").value;
	var message = document.getElementById("message").value;

	
   $.ajax({

     type: "GET",
     url: 'contact_handler.php',
     data: "name=" + name + "&mail=" + mail + "&message=" + message,
     success: function(data) {
          $('#contactForm').html(data);
     }

   });

}