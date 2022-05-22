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

$(function() {
	if(window.addEventListener) {
		window.addEventListener('message', ooklaListener);
	} else if(window.attachEvent) {
		window.attachEvent('onmessage', ooklaListener);
	}
	$('#submit-ticket').click(function(e) {
		e.preventDefault();
		$('#input-ticket').val($('#input-ticket').val().toUpperCase());
		if($('#input-ticket').val().substring(0, 2) == 'IN') {
			doTask();
		}
		else {
			$('#input-ticket').val('');
			$('#error-submit-ticket').removeClass('invisible');
		}
	});
	$('#input-ticket').focus(function() {
		$('#error-submit-ticket').addClass('invisible');
	});
	$('#retry, #retry-2').click(function(e) {
		e.preventDefault();
		window.location.href = window.location.href;
	});
	$('#submit-close-y').click(function(e) {
		e.preventDefault();
		sendClose(1);
	});
	$('#submit-close-n').click(function(e) {
		e.preventDefault();
		sendClose(0);
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
			url: site_url('Check_devookla/retrieveSpeed'),
			contentType: 'application/json',
			data: JSON.stringify($('#submit-speed').data()),
			success: function(response3) {
				//$('#okkla2').addClass('hide');
				//$('#okkla1').addClass('hide');
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
					confirmClose();
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
	timerWait0 = setTimeout(function() {
		$('#ask-wait-0').modal('show');
	}, 60000);
	$('#input-ticket').attr('disabled', 'disabled');
	$('#submit-ticket').addClass('hide');
	$('#loader-ticket').removeClass('hide');
	$.ajax({
		method: 'post',
		dataType: 'json',
		url: site_url('Check_devookla/createTask'),
		data: {
			'ticket': $('#input-ticket').val()
		},
		success: function(response1) {
			if(response1.success) {
				$('#uid').html(response1.data.uid);
				$('#uidookla').html(response1.data.uid);
				$('#uidooklaa').html(response1.data.uid);
				doWho(1);
			}
			else {
				alert('10002 pastikan no ticket anda sudah benar');
			}
		},
		error: function(err) {
			alert('10001');
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
				let username = null;
				let ip_nas = null;
				if(typeof response1.ip_addr != 'undefined'  && typeof response1.username !='undefined' && ip_nas !='undefined') {
					ip_addr = response1.ip_addr;
					username = response1.username;
					ip_nas = response1.ip_nas;
					$.ajax({
						method: 'post',
						dataType: 'json',
						url: site_url('Check_devookla/saveWhoIP6'),
						data: {
							ip_addr: ip_addr,
							username: username, 
							ip_nas: ip_nas,
							success: 1,
							request: null,
							response: JSON.stringify(response1)
						},
						success: function(response2) {
							if(response2.success) {
								if(response2.data.nd != '') {
									clearTimeout(timerWait0);
									$('#ask-wait-0').modal('hide');
									$('#ask-ticket').addClass('hide');
									$('#show-check').removeClass('hide');
									$('#confirm-ticket').val(response2.data.ticket);
									$('#confirm-nd').val(response2.data.nd);
									timerWait1 = setTimeout(function() {
										$('#ask-wait-1').modal('show');
									}, 60000);
									doOokla();
									doToken1();
								}
							}
						},
						error: function(a) {
							alert('20002 Please Clear cache from your Device OR Browser');
						}
					});
				}
				else if(typeof response1.ip_addr != 'undefined' && ip_nas !='undefined'){
					ip_addr = response1.ip_addr;
					ip_nas = response1.ip_nas;
					$.ajax({
						method: 'post',
						dataType: 'json',
						url: site_url('Check_devookla/saveWhoIP4'),
						data: {
							ip_addr: ip_addr,
							ip_nas: ip_nas,
							success: 1,
							request: null,
							response: JSON.stringify(response1)
						},
						success: function(response3) {
							if(response3.success) {
								doOokla();
								doNDByIP();
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
		
		alert('20001 please test myip.indihome.co.id');
		clearTimeout(timerWait0);
		$('#show-finish-myip').removeClass('hide');
		$('#ask-ticket').addClass('hide');
		//finish('failed');
	}
}


function doNDByIP() {
	$.ajax({
		method: 'post',
		dataType: 'json',
		url: site_url('Check_devookla/retrieveToken1'),
		data: {},
		success: function(response4) {
			if(response4.success) {
				$.ajax({
					method: 'post',
					dataType: 'json',
					url: site_url('Check_devookla/retrieveNDByIP'),
					data: {},
					success: function(response5) {
						if(response5.status == 200) {
							if(response5.success) {
								if(response5.data.nd != null) {
									clearTimeout(timerWait0);
									$('#ask-wait-0').modal('hide');
									$('#ask-ticket').addClass('hide');
									$('#show-check').removeClass('hide');
									$('#confirm-ticket').val(response5.data.ticket);
									$('#confirm-nd').val(response5.data.nd);
									 timerWait1 = setTimeout(function() {
										//$('#ask-wait-1').modal('show');
									 	$('#show-confirm').addClass('hide');
									 	$('#show-finish-rdm').removeClass('hide');
									 	$('#ask-ticket').addClass('hide');
									 }, 60000);
									doRedaman();
											
								}else {
									$('#show-finish-nd').removeClass('hide');
									$('#ask-ticket').addClass('hide');
								}
							}
							else if(response5.nd == null) {
								clearTimeout(timerWait0);
								//alert(response5.status);
								$('#show-finish-nd').removeClass('hide');
								$('#ask-ticket').addClass('hide');
								
								//console.log('nd');
							}
						}else if(response5.status != 200){
							clearTimeout(timerWait0);
							$('#show-finish-nde').removeClass('hide');
							$('#ask-ticket').addClass('hide');
						}
					},
					error: function(err) {
						$('#show-finish-nde').removeClass('hide');
						$('#ask-ticket').addClass('hide');
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
}

function doToken1() {
	$.ajax({
		method: 'post',
		dataType: 'json',
		url: site_url('Check_devookla/retrieveToken1'),
		data: {},
		success: function(response9){
			if(response9.success){
				timerWait3 = setTimeout(function() {
					//$('#ask-wait-1').modal('show');
					$('#show-confirm').addClass('hide');
					$('#show-finish-rdm').removeClass('hide');
					$('#ask-ticket').addClass('hide');
				}, 60000);
	
				doRedaman();
				//doSpeed();
				//doSpeedAcsis();
			}
			else {
				clearTimeout(timerWait3);
				alert('30001 tidak mendapatkan token');
				finish('failed');
			}
		},
		error: function(a) {
			alert('30002 tidak mendapatkan output dari APIM');
			finish('failed');
		}
	});
}
function doOokla(){
	$.ajax({
		method: 'post',
		dataType: 'json',
		url: site_url('Check_devookla/retrieveSpeedOokla'),
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
					alert('40001 Mapping Ookla tidak di temukan');
			 		finish('failed');
				} 
			}
			else {
				document.getElementById('ookla').src = 'https://test-inf-2.speedtestcustom.com';			}
		},
		error: function(a) {
			alert('40003 please Check your server service');
			finish('failed');
		}
	});
}

function doSpeedAcsis() {
	$('#loader-speed-acsis').removeClass('hide');
	$.ajax({
		method: 'post',
		dataType: 'json',
		url: site_url('Check_devookla/retrieveSpeedAcsis'),
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
	console.log('redaman');
	$('#loader-redaman').removeClass('hide');
	$.ajax({
		method: 'post',
		dataType: 'json',
		url: site_url('Check_devookla/retrieveUkur'),
		data: {},
		success: function(response1) {
			clearTimeout(timerWait1);
			clearTimeout(timerWait3);
			flagRedaman = true;
			$('#loader-redaman').addClass('hide');
		
			if(response1.status == 200) {
				if(response1.success) {
					if(response1.data.redaman_passed == 1) {
						$('#confirm-redaman').val('Layak');
						okRedaman = true;
					}
					else if(response1.data.redaman_passed == 0)  {
						$('#confirm-redaman').val('Belum Layak');
					} 
					else if(response1.data.redaman_passed == null)  {
						$('#confirm-redaman').val('Belum Layak');
					}
					timerWait2 = setTimeout(function() {
						$('#show-confirm').addClass('hide');
						$('#show-finish-pcrf').removeClass('hide');
						$('#ask-ticket').addClass('hide');
					}, 60000);
					
					doSpeed();
	 				doSpeedAcsis();
				} else {
					clearTimeout(timerWait1);
					clearTimeout(timerWait3);
					$('#show-confirm').addClass('hide');
					$('#show-finish-rdmn').removeClass('hide');
					$('#ask-ticket').addClass('hide');
				}

			}else if(response1.status != 200) {
				clearTimeout(timerWait1);
				clearTimeout(timerWait3);
				$('#show-confirm').addClass('hide');
				$('#show-finish-rdm').removeClass('hide');
				$('#ask-ticket').addClass('hide');
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
		url: site_url('Check_devookla/retrieveToken2'),
		data: {},
		success: function(response1) {
			if(response1.success) {
				$.ajax({
					method: 'post',
					dataType: 'json',
					url: site_url('Check_devookla/retrievePCRF'),
					data: {},
					success: function(response2) {
						clearTimeout(timerWait2);
						$('#loader-redaman').addClass('hide');
						if(response2.status == 200){
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
							clearTimeout(timerWait2);
							$('#show-confirm').addClass('hide');
							$('#show-finish-pcrf').removeClass('hide');
							$('#ask-ticket').addClass('hide');
						}
					},
					error: function(err) {
						clearTimeout(timerWait2);
						$('#show-confirm').addClass('hide');
						$('#show-finish-pcrf').removeClass('hide');
						$('#ask-ticket').addClass('hide');
					}
				});
			}
			else {
				finish('30001 tidak mendapatkan token');
				finish('failed');
			}
		},
		error: function(err) {
			$('#retrieve-token2 .log').html('error');
		}
	});
}

function confirmClose() {
	clearTimeout(timerWait1);
	$('#ask-wait-1').modal('hide');
	if(flagRedaman && flagSpeed) {
		if(okRedaman && okSpeed) {
			$('#show-eligible-close-y').removeClass('hide');
		}
		else {
			$('#show-eligible-close-n').removeClass('hide');
		}
	}
}

function sendClose(close) {
	
	$.ajax({
		method: 'post',
		dataType: 'json',
		url: site_url('Check_devookla/retrieveClose'),
		data: {
			close: close
		},
		success: function(response1) {
			if(response1.success) {
				$('#show-confirm').addClass('hide');
				if(Number(response1.data.close) > 0) {
					$('#show-eligible-close-n').addClass('hide');
					$('#show-eligible-close-y').addClass('hide');
					$('#show-eligible-thanks').removeClass('hide');
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
	$('#ask-wait-1').modal('hide');
	$('#ask-wait-2').modal('hide');
	$('.wizard').addClass('hide');
	$('.show-finish-sub').addClass('hide');
	$('#show-finish').removeClass('hide');
	$('#show-finish-' + s).removeClass('hide');
}