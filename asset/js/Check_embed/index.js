let flagRedaman = false;
let flagSpeed = false;
let okRedaman = false;
let okSpeed = false;
let loadRedaman;
let loadSpeed;
let timerWait0;
let timerWait1;
let timerWait2;
let timerWait3;
let timerWait4;
let timerWait5;

$(function() {
	doOokla();
	if(window.addEventListener) {
		window.addEventListener('message', ooklaListener);
	} else if(window.attachEvent) {
		window.attachEvent('onmessage', ooklaListener);
	}
	$('#submit-ticket').click(function(e) {
		e.preventDefault();
		$('#input-ticket').val($('#input-ticket').val().toUpperCase());
		// doTask();
		if($('#input-ticket').val() != ''){
			if($('#input-nd').val() != '') {
				if($('#input-nd').val().length > 10) {
					doTask();
				}else{
					// $('#input-nd').val('');
					// $('#error-submit-ticket').removeClass('invisible');
					$('#error-nd').modal('show');
				}
			}
			else {
				// $('#input-nd').val('');
				// $('#error-submit-ticket').removeClass('invisible');
				$('#error-nd-null').modal('show');
			} 
		} else {
			$('#error-ticket').modal('show');
			$('#error-submit-ticket').removeClass('invisible');
		}
	});

	$('#submit-wait').click(function(e) {
		$('#error-nd').modal('hide');
		
	});
	$('#submit-wait-null').click(function(e) {
		$('#error-nd-null').modal('hide');
	});
	$('#submit-wait-error').click(function(e) {
		$('#error-ticket').modal('hide');
		
	});
	$('#input-ticket').focus(function() {
		$('#error-submit-ticket').addClass('invisible');
	});
	$('#retry, #retry-2').click(function(e) {
		e.preventDefault();
		window.location.href = window.location.href;
	});
	$('#submit-close-y').click(function(e) {
		// e.preventDefault();
		// sendClose(1);
		$('#show-confirm').addClass('hide');
		$('#show-eligible-close-y').addClass('hide');
		$('#show-eligible').removeClass('hide');
		$('#show-eligible-thanks').removeClass('hide');
	});
	$('#submit-close-n').click(function(e) {
		// e.preventDefault();
		// sendClose(0);
	});
	$('#submit-wait-0-y').click(function(e) {
		e.preventDefault();
		$('#ask-wait-0').modal('hide');
	});
	$('#submit-wait-0-n').click(function(e) {
		e.preventDefault();
		$('#ask-wait-0').modal('hide');
		window.location.href = window.location.href;
	});
	
	$('#submit-wait-1-n').click(function(e) {
		e.preventDefault();
		$('#ask-wait-1').modal('hide');
		window.location.href = window.location.href;
	});
	$('#submit-wait-2-y').click(function(e) {
		e.preventDefault();
		$('#ask-wait-2').modal('hide');
	});
	$('#btnhelp-home').click(function(e) {
		$('#ask-wait-2').modal('show'); //show-help-home
	});
	$('#submit-wait-2-n').click(function(e) {
		e.preventDefault();
		$('#ask-wait-2').modal('hide');
		window.location.href = window.location.href;
	});
	$('#submit-speed').click(function(e) {
		e.preventDefault();
		$.ajax({
			method: 'post',
			dataType: 'json',
			url: site_url('Check_embed/retrieveSpeed'),
			contentType: 'application/json',
			data: JSON.stringify($('#submit-speed').data()),
			success: function(response10) {
				$('#ookla-test').modal('hide');
				$('#loader-speed').addClass('hide');
				if(response10.success) {
					flagSpeed = true;
					response10.data.speed_passed = Number(response10.data.speed_passed);
					if(response10.data.speed_passed > 0) {
						$('#confirm-speed').val('Layak');
						okSpeed = true;
					}
					else {
						$('#confirm-speed').val('Belum Layak');
					}
					sendAutoClose();
					// confirmClose();
				}
				else {
					
					finish('failed');
				}
			},
			error: function(err) {
				finish('failed');
			}
		});
	});
});

function ooklaListener(ev) {
	$('#submit-speed').data(ev.data);
	$('#submit-speed').removeClass('disabled');
}

function doTask() {
	$('#input-ticket').attr('disabled', 'disabled');
	$('#submit-ticket').addClass('hide');
	$('#loader-ticket').removeClass('hide');
	$.ajax({
		method: 'post',
		dataType: 'json',
		url: site_url('Check_embed/createTask'),
		data: {
			'ticket': $('#input-ticket').val(),
			'nd': $('#input-nd').val()
		},
		success: function(response1) {
			if(response1.success) {
				$('#uid').html(response1.data.uid);
				$('#uidookla').html(response1.data.uid);
				$('#uidooklaa').html(response1.data.uid);
				timerWait0 = setTimeout(function() {
					$('#ask-ticket').addClass('hide');
					$('#show-check').addClass('hide');
					finish('failed');
				}, 60000);
				doToken1();
				
			}
			else {
				alert('10002 pastikan no ticket anda sudah benar');
				finish('failed');
			}
		},
		error: function(err) {
			alert('10001');
			finish('failed');
		}
	});
}

function doToken1() {
	$.ajax({
		method: 'post',
		dataType: 'json',
		url: site_url('Check_embed/retrieveToken1'),
		data: {},
		success: function(response2){
			if(response2.success){
				clearTimeout(timerWait0);
				timerWait1 = setTimeout(function() {
					$('#show-finish-ipradius').removeClass('hide');
					$('#ask-ticket').addClass('hide');
					$('#show-check').addClass('hide');
				}, 60000);
				doIPRadius();
			}
			else {
				alert('30001 tidak mendapatkan token');
				$('#ask-ticket').addClass('hide');
				finish('failed');
			}
		},
		error: function(a) {
			clearTimeout(timerWait0);
			alert('30002 tidak mendapatkan output dari APIM');
			finish('failed');
		}
	});
}

function doIPRadius() {
	//$('#loader-redaman').removeClass('hide');
	$.ajax({
		method: 'post',
		dataType: 'json',
		url: site_url('Check_embed/retrieveIPRadius'),
		data: {},
		success: function(response5) {
			if(response5.success){
				clearTimeout(timerWait1);
				if(response5.data.frame_ip != null) {
					timerWait3 = setTimeout(function() {
						$('#show-finish-myip').removeClass('hide');
						$('#show-check').addClass('hide');
						$('#ask-ticket').addClass('hide');
				   }, 60000);
					doWho(1);					
				}
				else {
					$('#show-finish-ipradius').removeClass('hide');
					$('#ask-ticket').addClass('hide');
					$('#show-check').addClass('hide');
				}
			}else {
				clearTimeout(timerWait1);
				$('#show-finish-ipradius').removeClass('hide');
				$('#ask-ticket').addClass('hide');
				$('#show-check').addClass('hide');
			}
					
		},
		error: function(err) {
			clearTimeout(timerWait1);
			finish('failed');
		}
	});
}

function doWho(attempt) {
	if(attempt < 4) {
		$.ajax({
			method: 'get',
			dataType: 'json',
			url: 'https://myip.indihome.co.id',
			//url: 'https://test.indihome.co.id/CloseTicket.Internet/Test/myip/4',
			success: function(response3) {
				let ip_addr = null;
				if(typeof response3.ip_addr != 'undefined'){
					clearTimeout(timerWait3);
					ip_addr = response3.ip_addr;
					$.ajax({
						method: 'post',
						dataType: 'json',
						url: site_url('Check_embed/saveWhoIP4'),
						data: {
							ip_addr: ip_addr,
							success: 1,
							request: null,
							response: JSON.stringify(response3)
						},
						success: function(response4) {
							if(response4.success) {
								if(response4.data.passed_ip > 0){
									
									$('#ask-wait-0').modal('hide');
									$('#ask-ticket').addClass('hide');
									$('#show-check').removeClass('hide');
									$('#confirm-ticket').val(response4.data.ticket);
									$('#confirm-nd').val(response4.data.nd);
									$('#confirm-ts').text(response4.data.ts + " WIB");
									timerWait4 = setTimeout(function() {
										$('#show-finish-rdm').removeClass('hide');
										$('#ask-ticket').addClass('hide');
										$('#show-check').addClass('hide');
								}, 60000);
									doRedaman();
									doSpeed();
									doSpeedAcsis();
								}else {
									$('#show-finish-ip').removeClass('hide');
									$('#ask-ticket').addClass('hide');
									$('#show-check').addClass('hide');
								}
							}else {
								$('#show-finish-myip').removeClass('hide');
								$('#ask-ticket').addClass('hide');
								$('#show-check').addClass('hide');
							}
						},
						error: function(a) {
							alert('20002 Please Clear cache from your Device OR Browser');
						}
					});
				}else {
					doWho(attempt + 1);
				}
			},
			error: function(a, b, c) {

				console.log(a.status, b, c);
				doWho(attempt + 1);
			}
		});
	}
	else {
		alert('20001 please test https://myip.indihome.co.id');
		// clearTimeout(timerWait1);
		$('#show-finish-myip').removeClass('hide');
		$('#ask-ticket').addClass('hide');
	}
}

function doOokla(){
	$.ajax({
		method: 'post',
		dataType: 'json',
		url: site_url('Check_embed/retrieveSpeedOokla'),
		data: {},
		success: function(response11){
			if(response11.success){
				if(response11.data.speedtest == 1){
					document.getElementById('ookla').src = 'https://test-inf-1.speedtestcustom.com';

				} 
				else if(response11.data.speedtest == 2){
					document.getElementById('ookla').src = 'https://test-inf-2.speedtestcustom.com';
				
				} 
				else{ 
					document.getElementById('ookla').src = 'https://test-inf-2.speedtestcustom.com';
				} 
			}
			else {
				document.getElementById('ookla').src = 'https://test-inf-2.speedtestcustom.com';			}
		},
		error: function(a) {
			document.getElementById('ookla').src = 'https://test-inf-2.speedtestcustom.com';
			// alert('40003 please Check your server service');
			finish('failed');
		}
	});
}


function doSpeedAcsis() {
	$('#loader-speed-acsis').removeClass('hide');
	$.ajax({
		method: 'post',
		dataType: 'json',
		url: site_url('Check_embed/retrieveSpeedAcsis'),
		data: {},
		success: function(response6) {
			$('#loader-speed-acsis').addClass('hide');
			if(response6.success) {
				if(response6.data.speed != 0){
					$('#confirm-speed-acsis').val(response6.data.speed);
				}else{
					$('#confirm-speed-acsis').val('-');
				}
			}
			else {
				finish('failed');
			}
		},
		error: function(err) {
			finish('failed');
		}
	});
}

function doRedaman() {
	$('#loader-redaman').removeClass('hide');
	$.ajax({
		method: 'post',
		dataType: 'json',
		url: site_url('Check_embed/retrieveUkur'),
		data: {},
		success: function(response7) {
			
			flagRedaman = true;
			$('#loader-redaman').addClass('hide');

			if(response7.status == 200) {
				clearTimeout(timerWait4);
				if(response7.success) {
					if(response7.data.redaman_passed == 1) {
						$('#confirm-redaman').val('Layak');
						okRedaman = true;
					}
					else if(response7.data.redaman_passed == 0)  {
						$('#confirm-redaman').val('Belum Layak');
					} 
					else if(response7.data.redaman_passed == null)  {
						$('#confirm-redaman').val('Belum Layak');
					}
					timerWait5 = setTimeout(function() {
						$('#show-finish-pcrf').removeClass('hide');
						$('#ask-ticket').addClass('hide');
						$('#show-check').addClass('hide');
					}, 60000);

				} else {
					clearTimeout(timerWait4);
					$('#show-finish-rdmn').removeClass('hide');
					$('#ask-ticket').addClass('hide');
					$('#show-check').addClass('hide');
				}
			}else if(response7.status != 200) {
				clearTimeout(timerWait3);
				$('#show-finish-rdm').removeClass('hide');
				$('#ask-ticket').addClass('hide');
				$('#show-check').addClass('hide');
			}

		},
		error: function(err) {
			clearTimeout(timerWait3);
			finish('failed');
		}
	});
}

function doSpeed() {
	$('#loader-speed').removeClass('hide');
	$.ajax({
		method: 'post',
		dataType: 'json',
		url: site_url('Check_embed/retrieveToken2'),
		data: {},
		success: function(response8) {
			if(response8.success) {
				$.ajax({
					method: 'post',
					dataType: 'json',
					url: site_url('Check_embed/retrievePCRF'),
					data: {},
					success: function(response9) {
						
						$('#loader-redaman').addClass('hide');
						if(response9.status == 200){
							clearTimeout(timerWait5);
							if(response9.success) {
								let checkRedaman = setInterval(function() {
									console.log('-');
									if(flagRedaman) {
										clearInterval(checkRedaman);
										console.log('x');
									$('#ookla-test').modal('show');
									}
								}, 500);
							}
							else {
								$('#ookla-test').modal('show');
							}
						} else if(response9.status != 200){
							$('#show-finish-pcrf').removeClass('hide');
							$('#show-check').addClass('hide');
						}
					},
					error: function(err) {
						clearTimeout(timerWait5);
						$('#show-finish-pcrf').removeClass('hide');
						$('#show-check').addClass('hide');

					}
				});
			}
			else {
				finish('failed');
				clearTimeout(timerWait4);
			}
		},
		error: function(err) {
			clearTimeout(timerWait4);
			$('#retrieve-token2 .log').html('error');
		}
	});
}

function sendAutoClose(){
	$.ajax({
		method: 'post',
		dataType: 'json',
		url: site_url('Check_embed/retrieveCloseAuto'),
		data: {
			// close: close
		},
		success: function(response12) {
			if(response12.success) {
				if(response12.data.close == 1) {
					 $('#show-eligible-close-y').removeClass('hide');
				}
				else {
					$('#show-eligible-close-y').addClass('hide');
					$('#show-eligible-close-n').removeClass('hide');
				}
			}
			else {
				finish('failed');
			}
		},
		error: function(err) {
			finish('failed');
		}
	});
}



function finish(s) {
	clearTimeout(timerWait0);
	$('#ask-wait-0').modal('hide');
	clearTimeout(timerWait1);
	clearTimeout(timerWait2);
	clearTimeout(timerWait3);
	clearTimeout(timerWait4);
	clearTimeout(timerWait5);
	$('#ask-wait-1').modal('hide');
	$('#ask-wait-2').modal('hide');
	$('.wizard').addClass('hide');
	$('.show-finish-sub').addClass('hide');
	$('#show-finish').removeClass('hide');
	$('#show-finish-' + s).removeClass('hide');
}