$(document).ready(function() {
	var $returnMessage = $('.return-message').hide(),
	$email = $('a[itemprop=email]').text(),
	$form = $('form');
	$('.submit').on('click', function(event){
		sendEmail();
		event.preventDefault();
	});
function handleReturn(returnedObject){
		$form.fadeOut(200, function(){

		switch(returnedObject){
			case 'sent':
			$returnMessage.append('<span class="icon-ok"></span><span class="message">Message sent. I\'ll be in touch.</span>');
				break;
			case 'failed':
				$returnMessage.append('<span class="icon-remove"></span><span class="message">Sorry, the message can\'t seem to get through. <a href="mailto:'+$email +'">Try using your client?</a></span>');
				break;
			default :
				$returnMessage.append('<span class="icon-remove"></span><span class="message">'+returnedObject+'</span>');
			break;
	}
		$returnMessage.fadeIn(200);
		});

		$('.return-message').on('click', function(){

			$(this).fadeOut(200, function(){
			$(this).children().remove();
						$form.fadeIn(200);
			});

		});
}
	function sendEmail(){
		var emailid = $form.children('.email').val(),
		tempname = $form.children('.name').val(),
		tempmessage = $form.children('.message').val(),
	 data = { email: emailid,
			name : tempname,
			message : tempmessage
	};
		$.ajax({
	type: "POST",
	url: "index.php",
	data: data,
	dataType: "text",
	success: function(returnedObject){
		console.log(returnedObject);
		handleReturn(returnedObject);
	}
	});
}
});