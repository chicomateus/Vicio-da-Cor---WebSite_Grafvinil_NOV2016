var inputs = document.querySelectorAll( '.inputfile' );
Array.prototype.forEach.call( inputs, function( input )
{
	var label	 = input.nextElementSibling,
		labelVal = label.innerHTML;

	input.addEventListener( 'change', function( e )
	{
		var fileName = '';
		if( this.files && this.files.length > 1 )
			fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
		else
			fileName = e.target.value.split( '\\' ).pop();

		if( fileName )
			label.querySelector( 'span' ).innerHTML = fileName;
		else
			label.innerHTML = labelVal;
	});
});

// NAVIGATION MOBLIE  - HAMBURGER
(function() {
    $('.hamburger-menu').on('click', function() {
        $('.nav-mobile').toggleClass('open');
        $('body,header,main').toggleClass('noscroll');

        $('.bar').toggleClass('animate');
        $('.list-menu').toggleClass('overlay').fadeToggle("slow");

    });
})();




/*/////////////// AJAX FORM ----------------*/

$(function() {
// Get the form.
var form = $('#EncForm');

$(form).submit(function(event) {
// Stop the browser from submitting the form.
event.preventDefault();
var formData = new FormData($(this)[0]);

	 $.ajax({
					type: "POST",
					url: form.attr('action'),
					data: formData, // serializes the form's elements.
					async: false,
					success: function(data,status)
					{
							console.log(data);
							console.log(status);
							if(data==='1'){
								$('#EncForm').fadeOut('slow',function(){
									$('.sucess-form').fadeIn();
								});
							}else{
								alert('Aconteceu um problema com seu pedido, por favor tente outra vez');
							}
					},
					error: function (XMLHttpRequest, textStatus, errorThrown) {
        console.log('AJAX error:' + textStatus);
				alert('Aconteceu um problema com seu pedido, por favor tente outra vez');
    }
					cache: false,
					contentType: false,
					processData: false,
					xhr: function() {  // Custom XMLHttpRequest
							var myXhr = $.ajaxSettings.xhr();
							if (myXhr.upload) { // Avalia se tem suporte a propriedade upload
									myXhr.upload.addEventListener('progress', function () {
											// faz alguma coisa durante o progresso do upload
									}, false);
							}
					return myXhr;
					}
				});
			return false;
});

});
