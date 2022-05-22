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
var spt;
var rest;
var spd;
var VarSpeed;


$(function() {
	// doOokla();
	if(window.addEventListener) {
		window.addEventListener('message', ooklaListener);
	} else if(window.attachEvent) {
		window.attachEvent('onmessage', ooklaListener);
	}
	$('#submit-ticket').click(function(e) {
		e.preventDefault();
		$('#input-ticket').val($('#input-ticket').val().toUpperCase());
		if($('#input-ticket').val() != ''){
			if($('#input-ticket').val().substring(0, 2) == 'IN') {
				if($('#input-ticket').val().length > 5) {
				doTask();
				}else{
					$('#tiket-error').modal('show');
				}
			}else{
				$('#tiket-error').modal('show');
				$('#error-submit-ticket').removeClass('invisible');
				$('#input-ticket').val('');
			}
		}
		else {
			// $('#error-submit-ticket').removeClass('invisible');
			$('#error-ticket').modal('show');
		}
	});
	
	$('#submit-wait').click(function(e) {
		$('#tiket-error').modal('hide');
	});

	$('#input-ticket').focus(function() {
		$('#error-submit-ticket').addClass('invisible');
	});

	$('#submit-wait-error').click(function(e) {
		$('#error-ticket').modal('hide');
		
	});

	$('#retry, #retry-2').click(function(e) {
		e.preventDefault();
		window.location.href = window.location.href;
	});
	$('#submit-close-y').click(function(e) {
		$('#show-confirm').addClass('hide');
		$('#show-eligible-close-y').addClass('hide');
		$('#show-eligible').removeClass('hide');
		$('#show-eligible-thanks').removeClass('hide');
	});
	$('#submit-close-n').click(function(e) {
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
	$('#submit-wait-1-y').click(function(e) {
		e.preventDefault();
		$('#ask-wait-1').modal('hide');
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
		console.log(rest);
		e.preventDefault();
		$.ajax({
			method: 'post',
			dataType: 'json',
			url: site_url('Check/retrieveSpeed'),
			contentType: 'application/json',
			data: rest,
			success: function(response3) {
				$('#ookla-test').modal('hide');
				$('#loader-speed').addClass('hide');
				if(response3.success) {
					flagSpeed = true;
					response3.data.speed_passed = Number(response3.data.speed_passed);
					if(response3.data.speed_passed > 0) {
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
	spt = ev.data;
	// spd = 1;

	if(VarSpeed == 0){
		rest = spt;
		$('#submit-speed').removeClass('disabled');
		$('#submit-speed').addClass('enabled');
	}else{
		console.log('ookla');
			rest = JSON.stringify(spt);
			$('#submit-speed').removeClass('disabled');
			$('#submit-speed').addClass('enabled');
	}
}

function doTask() {
	$('#input-ticket').attr('disabled', 'disabled');
	$('#submit-ticket').addClass('hide');
	$('#loader-ticket').removeClass('hide');
	$.ajax({
		method: 'post',
		dataType: 'json',
		url: site_url('Check/createTask'),
		data: {
			'ticket': $('#input-ticket').val()
		},
		success: function(response1) {
			if(response1.success) {
				$('#uid').html(response1.data.uid);
				$('#uidookla').html(response1.data.uid);
				$('#uidooklaa').html(response1.data.uid);
				timerWait0 = setTimeout(function() {
					// alert('Output dari nossa tidak ditemukan');
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
		url: site_url('Check/retrieveToken1'),
		data: {},
		success: function(response9){
			if(response9.success){
				clearTimeout(timerWait0);
				timerWait1 = setTimeout(function() {
					// finish('failed');
					$('#show-check').addClass('hide');
					$('#show-finish-nds').removeClass('hide');
					$('#ask-ticket').addClass('hide');
				}, 60000);
				doNDByIN();
				
			}
			else {
				$('#ask-ticket').addClass('hide');
				alert('30001 tidak mendapatkan token');
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


function doNDByIN(){
	$.ajax({
		method: 'post',
		dataType: 'json',
		url: site_url('Check/retrieveNDByIN'),
		data: {},
		success: function(response9){
			if(response9.status == 200) {
				if(response9.success){
					clearTimeout(timerWait1);
					if(response9.data.nd != null){
						timerWait2 = setTimeout(function() {
							$('#show-finish-ipradius').removeClass('hide');
							$('#ask-ticket').addClass('hide');
							$('#show-check').addClass('hide');
						}, 60000);
						// doIPRadius();
						// doWho(1);
						check_package();
						}
					else {
						$('#show-finish-nd').removeClass('hide');
						$('#ask-ticket').addClass('hide');
						$('#show-check').addClass('hide');
					}
				}else{
					$('#show-finish-nds').removeClass('hide');
					$('#ask-ticket').addClass('hide');
					$('#show-check').addClass('hide');
				}
			}
			else {
				$('#show-finish-nds').removeClass('hide');
				$('#ask-ticket').addClass('hide');
				$('#show-check').addClass('hide');
			}
		},
		error: function(a) {
			alert('Nossa failed');
			finish('failed');
		}
	});
}


function check_package(){
	$.ajax({
		method: 'post',
		dataType: 'json',
		url: site_url('Check/retrievePCRF'),
		data: {},
		success: function(response21) {
			if(response21.status == 200){
				if(response21.success) {
					if(response21.data.speedtest == 0){
						VarSpeed = response21.data.speedtest;
						doIPRadius();
						doSpeedtestDBT();
						console.log('-');
						
					}else{
						doIPRadius();
						doOokla();
					}
				}
				else {
					console.log(response21);
				}							
			} else if(response21.status != 200){
				$('#show-finish-pcrf').removeClass('hide');
				$('#show-check').addClass('hide');
			}
		},
		error: function(err) {
			// clearTimeout(timerWait5);
			$('#show-finish-pcrf').removeClass('hide');
			$('#show-check').addClass('hide');
		}
	});
}




function doIPRadius() {
	//$('#loader-redaman').removeClass('hide');
	$.ajax({
		method: 'post',
		dataType: 'json',
		url: site_url('Check/retrieveIPRadius'),
		data: {},
		success: function(response14) {
			// doToken1();
			if(response14.success){
				if(response14.data.frame_ip != null) {
					clearTimeout(timerWait2);
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
				// finish('failed');
				clearTimeout(timerWait2);
				$('#show-finish-ipradius').removeClass('hide');
				$('#ask-ticket').addClass('hide');
				$('#show-check').addClass('hide');
			}
					
		},
		error: function(err) {
			clearTimeout(timerWait2);
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
			success: function(response1) {
				let ip_addr = null;
				if(typeof response1.ip_addr != 'undefined'){
					clearTimeout(timerWait3);
					ip_addr = response1.ip_addr;
					$.ajax({
						method: 'post',
						dataType: 'json',
						url: site_url('Check/saveWhoIP4'),
						data: {
							ip_addr: ip_addr,
							success: 1,
							request: null,
							response: JSON.stringify(response1)
						},
						success: function(response3) {
							// clearTimeout(timerWait1);
							if(response3.success) {
								if(response3.data.passed_ip > 0){
									$('#ask-wait-0').modal('hide');
									$('#ask-ticket').addClass('hide');
									$('#show-check').removeClass('hide');
									$('#confirm-ticket').val(response3.data.ticket);
									$('#confirm-nd').val(response3.data.nd);
									$('#confirm-ts').text(response3.data.ts + " WIB");
									timerWait4 = setTimeout(function() {
										$('#show-finish-rdm').removeClass('hide');
										$('#ask-ticket').addClass('hide');
										$('#show-check').addClass('hide');
									}, 60000);

									doRedaman();
									// doSpeed();
									doSpeedAcsis();

								}else {
									$('#show-finish-ip').removeClass('hide');
									$('#ask-ticket').addClass('hide');
									$('#show-check').addClass('hide');
								}
							}else{
								$('#show-finish-myip').removeClass('hide');
								$('#ask-ticket').addClass('hide');
								$('#show-check').addClass('hide');
							}
						},
						error: function(a) {
							// clearTimeout(timerWait2);
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
		// clearTimeout(timerWait2);
		$('#show-finish-myip').removeClass('hide');
		$('#ask-ticket').addClass('hide');
	}
}




/*function doNDByIP() {
	$.ajax({
		method: 'post',
		dataType: 'json',
		url: site_url('Check/retrieveToken1'),
		data: {},
		success: function(response4) {
			if(response4.success) {
				$.ajax({
					method: 'post',
					dataType: 'json',
					url: site_url('Check/retrieveNDByIP'),
					data: {},
					success: function(response5) {
						clearTimeout(timerWait1);
						if(response5.status == 200) {
							if(response5.success) {
								if(response5.data.nd != null) {
									
									$('#ask-wait-0').modal('hide');
									$('#ask-ticket').addClass('hide');
									$('#show-check').removeClass('hide');
									$('#confirm-ticket').val(response5.data.ticket);
									$('#confirm-nd').val(response5.data.nd);
									$('#confirm-ts').text(response5.data.ts + " WIB");

									timerWait2 = setTimeout(function() {
									 	$('#show-finish-rdm').removeClass('hide');
										$('#ask-ticket').addClass('hide');
									 	$('#show-check').addClass('hide');
									 }, 60000);

									doRedaman();
									doSpeed();
									doSpeedAcsis();
											
								}else {
								
									$('#show-finish-nd').removeClass('hide');
									$('#ask-ticket').addClass('hide');
									$('#show-check').addClass('hide');
								}
							}
							else if(response5.nd == null) {
								$('#show-finish-nd').removeClass('hide');
								$('#ask-ticket').addClass('hide');
								$('#show-check').addClass('hide');
								
								//console.log('nd');
							}
						}else if(response5.status != 200){
							
							$('#show-finish-nde').removeClass('hide');
							$('#ask-ticket').addClass('hide');
							$('show-check').addClass('hide');
						}
					},
					error: function(err) {
						clearTimeout(timerWait1);
						$('#show-finish-nde').removeClass('hide');
						$('#ask-ticket').addClass('hide');
						$('#show-check').addClass('hide');
					}
				});
			}
			else {
				alert('30001 tidak mendapatkan token')
				finish('failed');
			}
		},
		error: function(err) {
			alert('30002 tidak mendapatkan output dari APIM');
			finish('failed');
		}
	});
}*/


function doOokla(){
	$.ajax({
		method: 'post',
		dataType: 'json',
		url: site_url('Check/retrieveSpeedOokla'),
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
				document.getElementById('ookla').src = 'https://test-inf-2.speedtestcustom.com';			
			}
		},
		error: function(a) {
			//document.getElementById('ookla').src = 'https://test-inf-2.speedtestcustom.com';
			alert('40003 please Check your connection');
			finish('failed');
		}
	});
}


function doSpeedtestDBT(){
	$.ajax({
		method: 'post',
		dataType: 'json',
		url: site_url('Check/speed'),
		data: {},
		success: function(response15){
			if(response15.success){
				document.getElementById('ookla').src = 'https://speedtest.mysiis.io/?query='+response15.data.param;
			}
		},
		error: function(a) {
			//document.getElementById('ookla').src = 'https://test-inf-2.speedtestcustom.com';
			alert('40003 please Check your connection');
			finish('failed');
		}
	});
}

function doSpeedAcsis() {
	$('#loader-speed-acsis').removeClass('hide');
	$.ajax({
		method: 'post',
		dataType: 'json',
		url: site_url('Check/retrieveSpeedAcsis'),
		data: {},
		success: function(response3) {
			$('#loader-speed-acsis').addClass('hide');
			if(response3.success) {
				if(response3.data.speed != 0){
					$('#confirm-speed-acsis').val(response3.data.speed);
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
	//console.log('redaman');
	$('#loader-redaman').removeClass('hide');
	$.ajax({
		method: 'post',
		dataType: 'json',
		url: site_url('Check/retrieveUkur'),
		data: {},
		success: function(response1) {
			
			flagRedaman = true;
			$('#loader-redaman').addClass('hide');
		
			if(response1.status == 200) {
				clearTimeout(timerWait4);
				if(response1.success) {
					if(response1.data.redaman_passed == 1) {
						$('#confirm-redaman').val('Layak');
						okRedaman = true;
						$('#loader-redaman').addClass('hide');
						$('#ookla-test').modal('show');
					}
					else if(response1.data.redaman_passed == 0)  {
						$('#confirm-redaman').val('Belum Layak');
						$('#loader-redaman').addClass('hide');
						$('#ookla-test').modal('show');
					} 
					else if(response1.data.redaman_passed == null)  {
						$('#confirm-redaman').val('Belum Layak');
						$('#loader-redaman').addClass('hide');
						$('#ookla-test').modal('show');
					}
					timerWait5 = setTimeout(function() {
						$('#show-finish-pcrf').removeClass('hide');
						$('#show-check').addClass('hide');
					}, 60000);
					
					//doSpeed();
	 				//doSpeedAcsis();
				} else {
					
					$('#show-finish-rdmn').removeClass('hide');
					$('#show-check').addClass('hide');
				}

			}else if(response1.status != 200) {
				$('#show-finish-rdm').removeClass('hide');
				$('#show-check').addClass('hide');
			}
		},
		error: function(err) {
			clearTimeout(timerWait4);
			finish('failed');
		}
	});
}


function doSpeed() {
	$('#loader-speed').removeClass('hide');
	$.ajax({
		method: 'post',
		dataType: 'json',
		url: site_url('Check/retrieveToken2'),
		data: {},
		success: function(response1) {
			if(response1.success) {
				$.ajax({
					method: 'post',
					dataType: 'json',
					url: site_url('Check/retrievePCRF'),
					data: {},
					success: function(response2) {
						
						$('#loader-redaman').addClass('hide');
						if(response2.status == 200){
							clearTimeout(timerWait5);
							if(response2.success) {
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
						} else if(response2.status != 200){
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
				alert('30001 tidak mendapatkan token');
				finish('failed');
			}
		},
		error: function(err) {
			$('#retrieve-token2 .log').html('error');
		}
	});
}

function sendAutoClose(){
	$.ajax({
		method: 'post',
		dataType: 'json',
		url: site_url('Check/retrieveCloseAuto'),
		data: {},
		success: function(response1) {
			if(response1.success) {
				if((response1.data.close) > 0) {
					 $('#show-eligible-close-y').removeClass('hide');
				}
				else {
					$('#show-eligible-close-y').addClass('hide');
					$('#show-eligible-close-n').removeClass('hide');
				}
			}
			else {
				alert('Silahkan lakukan clear cache pada browser anda');
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