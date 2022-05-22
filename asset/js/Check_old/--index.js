let flagRedaman = false;
let flagSpeed = false;
let okRedaman = false;
let okSpeed = false;
let loadRedaman;
let loadSpeed;
let timerWait0;
let timerWait1;

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
	$('#submit-speed').click(function(e) {
		e.preventDefault();
		$.ajax({
			method: 'post',
			dataType: 'json',
			url: site_url('Check/retrieveSpeed'),
			contentType: 'application/json',
			data: JSON.stringify($('#submit-speed').data()),
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
		url: site_url('Check/createTask'),
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
				alert('10002');
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
			success: function(response2) {
				let ip_addr = null;
				if(typeof response2.ip_addr != 'undefined') {
					ip_addr = response2.ip_addr;
					$.ajax({
						method: 'post',
						dataType: 'json',
						url: site_url('Check/saveWho'),
						data: {
							ip_addr: ip_addr, 
							success: 1,
							request: null,
							response: JSON.stringify(response2)
						},
						success: function(response3) {
							if(response3.success) {
								doNDByIP();
							}
						},
						error: function(a) {
							alert('20002');
						}
					});
				}
				else {
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
		alert('20001');
	}
}

function doNDByIP() {
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
						if(response5.success) {
							if(response5.data.nd != null) {
								clearTimeout(timerWait0);
								$('#ask-wait-0').modal('hide');
								$('#ask-ticket').addClass('hide');
								$('#show-check').removeClass('hide');
								$('#confirm-ticket').val(response5.data.ticket);
								$('#confirm-nd').val(response5.data.nd);
								timerWait1 = setTimeout(function() {
									$('#ask-wait-1').modal('show');
								}, 60000);
								doRedaman();
								doSpeed();
							}
							else {
								finish('failed');
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
		url: site_url('Check/retrieveUkur'),
		data: {},
		success: function(response1) {
			flagRedaman = true;
			$('#loader-redaman').addClass('hide');
			if(response1.success) {
				if(response1.data.redaman_passed > 0) {
					$('#confirm-redaman').val('Layak');
					okRedaman = true;
				}
				else {
					$('#confirm-redaman').val('Belum Layak');
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
						if(response2.success) {
							let checkRedaman = setInterval(function() {
								console.log('-');
								if(flagRedaman) {
									clearInterval(checkRedaman);
									console.log('x');
									//$('#ookla-test').modal('show');
									$('#confirm-speed').val('Layak');
									$('#loader-speed').addClass('hide');
									flagSpeed = true;
									okSpeed = true;
									confirmClose();
									/*
									$.ajax({
										method: 'post',
										dataType: 'json',
										url: site_url('Check/retrieveSpeed'),
										data: {},
										success: function(response3) {
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
									*/
								}
							}, 500);
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
			else {
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
		url: site_url('Check/retrieveClose'),
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
	$('.wizard').addClass('hide');
	$('.show-finish-sub').addClass('hide');
	$('#show-finish').removeClass('hide');
	$('#show-finish-' + s).removeClass('hide');
}