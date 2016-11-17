//var=ads


// NAVIGATION MOBLIE  - HAMBURGER
(function () {
	$('.hamburger-menu').on('click', function() {
		$('.nav-mobile').toggleClass('open');
		$('body,header,main').toggleClass('noscroll');

		$('.bar').toggleClass('animate');
		$('.list-menu').toggleClass('overlay').fadeToggle( "slow" );

	});
})();