$(function() {
	if(whitelist > 0) {
		$('#check-ip-forbidden').addClass('hide');
		$('#check-ip-allowed').removeClass('hide');
		let iMax = 10;
		let iTimer = 0;
		$('#check-ip-timer').html(iMax + ' detik');
		let oTimer = setInterval(function() {
			if(iTimer == iMax) {
				clearInterval(oTimer);
				window.location.href = site_url('Check');
							}
			else {
				iTimer++;
				$('#check-ip-timer').html((iMax - iTimer) + ' detik');
			}
		}, 1000);
	}
	else {
		$('#check-ip-allowed').addClass('hide');
		$('#check-ip-forbidden').removeClass('hide');
	}
});
