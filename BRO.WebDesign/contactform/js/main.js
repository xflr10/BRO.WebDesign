(function ($) {

	"use strict";


	// Form
	var contactForm = function () {
		if ($('#contactForm').length > 0) {
			$("#contactForm").validate({
				rules: {
					name: "required",
					subject: "required",
					email: {
						required: true,
						email: true
					},
					message: {
						required: true,
						minlength: 5
					}
				},
				messages: {
					name: "Vă rugăm să introduceți numele dvs.",
					subject: "Vă rugăm să introduceți un subiect",
					email: "Vă rugăm să introduceți o adresă de e-mail validă",
					message: "Vă rugăm să introduceți un mesaj"
				},
				/* submit via ajax */

				submitHandler: function (form) {
					var $submit = $('.submitting'),
						waitText = 'Se trimite...';

					$.ajax({
						type: "POST",
						url: "php/sendEmail.php",
						data: $(form).serialize(),

						beforeSend: function () {
							$submit.css('display', 'block').text(waitText);
						},
						success: function (msg) {
							if (msg == 'OK') {
								$('#form-message-warning').hide();
								setTimeout(function () {
									$('#contactForm').fadeIn();
								}, 1000);
								setTimeout(function () {
									$('#form-message-success').fadeIn();
								}, 1400);

								setTimeout(function () {
									$('#form-message-success').fadeOut();
								}, 8000);

								setTimeout(function () {
									$submit.css('display', 'none').text(waitText);
								}, 1400);

								setTimeout(function () {
									$('#contactForm').each(function () {
										this.reset();
									});
								}, 1400);

							} else {
								$('#form-message-warning').html(msg);
								$('#form-message-warning').fadeIn();
								$submit.css('display', 'none');
							}
						},
						error: function () {
							$('#form-message-warning').html("S-a produs o eroare. Vă rugăm să încercați din nou.");
							$('#form-message-warning').fadeIn();
							$submit.css('display', 'none');
						}
					});
				} // end submitHandler

			});
		}
	};
	contactForm();

})(jQuery);
