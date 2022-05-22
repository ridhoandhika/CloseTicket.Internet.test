let attempt = 0;

$(function() {
	$('#wizard-start').click(function(e) {
		e.preventDefault();
		$('#ask').addClass('hide');
		$('#create-task').removeClass('hide');
		uid = null;
		createTask();
	});
	$('#wizard-confirm-y').click(function(e) {
		e.preventDefault();
		retrieveUkur();
	});
	$('#wizard-retrieve-token2').click(function(e) {
		e.preventDefault();
		retrieveToken2();
	});
	$('.wizard-close-ticket').click(function(e) {
		e.preventDefault();
		retrieveClose($(this).attr('data-close'));
	});
});

function createTask() {
	$('#create-task .log').html('loading...');
	$.ajax({
		method: 'post',
		dataType: 'json',
		url: site_url('Main/createTask'),
		data: {
			'ticket': $('#ticket').val()
		},
		success: function(response) {
			$('#create-task .log').html(JSON.stringify(response, null, "\t"));
			if(response.success) {
				$('#uid').html(response.data.uid);
				//retrieveSession(response.data.uid);
				retrieveWho();
			}
			else {
				
			}
		},
		error: function(err) {
			$('#create-task .log').html('error');
		}
	});
}

function retrieveWho() {
	$('#create-task').addClass('hide');
	$('#retrieve-who').removeClass('hide');
	$('#retrieve-who .log').html('loading...');
	$.ajax({
		method: 'get',
		dataType: 'json',
		url: site_url('who.php'),
		success: function(response) {
			$('#retrieve-who .log').html(JSON.stringify(response, null, "\t"));
			let ip_addr = null;
			if(typeof response.ip_addr != 'undefined') {
				ip_addr = response.ip_addr;
			}
			$.ajax({
				method: 'post',
				dataType: 'json',
				url: site_url('Main/saveWho'),
				data: {
					ip_addr: ip_addr, 
					success: 1,
					request: null,
					response: JSON.stringify(response)
				},
				success: function(response) {
					if(response.success) {
						retrieveToken1();
					}
				}
			});
		},
		error: function(err) {
			$('#retrieve-who .log').html('error');
		}
	});
}

function retrieveToken1() {
	$('#retrieve-who').addClass('hide');
	$('#retrieve-token1').removeClass('hide');
	$('#retrieve-token1 .log').html('loading...');
	$.ajax({
		method: 'post',
		dataType: 'json',
		url: site_url('Main/retrieveToken1'),
		data: {},
		success: function(response) {
			$('#retrieve-token1 .log').html(JSON.stringify(response, null, "\t"));
			if(response.success) {
				retrieveNDByIP();
			}
			else {
				
			}
		},
		error: function(err) {
			$('#retrieve-token1 .log').html('error');
		}
	});
}

function retrieveNDByIP() {
	$('#retrieve-token1').addClass('hide');
	$('#retrieve-ndbyip').removeClass('hide');
	$('#retrieve-ndbyip .log').html('loading...');
	$('#confirm-ticket').html('');
	$('#confirm-ipaddr').val('');
	$('#confirm-userid').val('');
	let xhardcode = '';
	if(typeof hardcode != 'undefined') {
		xhardcode = '?hardcode='+hardcode;
	}
	$.ajax({
		method: 'post',
		dataType: 'json',
		url: site_url('Main/retrieveNDByIP' + xhardcode),
		data: {},
		success: function(response) {
			$('#retrieve-ndbyip .log').html(JSON.stringify(response, null, "\t"));
			if(response.success) {
				$('#confirm-ticket').html(response.data.ticket);
				$('#confirm-ipaddr').val(response.data.ipaddr);
				$('#confirm-userid').val(response.data.userid);
				showConfirm();
			}
			else {
				
			}
		},
		error: function(err) {
			$('#retrieve-ndbyip .log').html('error');
		}
	});
	
}

function showConfirm() {
	$('#retrieve-ndbyip').addClass('hide');
	$('#confirm').removeClass('hide');
	
}

function retrieveUkur() {
	$('#confirm').addClass('hide');
	$('#retrieve-ukur').removeClass('hide');
	$('#retrieve-ukur .log').html('loading...');
	$.ajax({
		method: 'post',
		dataType: 'json',
		url: site_url('Main/retrieveUkur'),
		data: {},
		success: function(response) {
			$('#retrieve-ukur .log').html(JSON.stringify(response, null, "\t"));
			if(response.success) {
				$('.redaman-passed').addClass('hide');
				$('.redaman-passed[data-passed="' + response.data.redaman_passed + '"]').removeClass('hide');
				$('#retrieve-ukur').addClass('hide');
				$('#stop-ukur').removeClass('hide');
				attempt = 0;
			}
			else {
				$('#retrieve-ukur').addClass('hide');
				retry(() => {
					retrieveUkur();
				});
			}
		},
		error: function(err) {
			$('#retrieve-ukur .log').html('error');
		}
	});
}

function retrieveToken2() {
	$('#stop-ukur').addClass('hide');
	$('#retrieve-token2').removeClass('hide');
	$('#retrieve-token2 .log').html('loading...');
	$.ajax({
		method: 'post',
		dataType: 'json',
		url: site_url('Main/retrieveToken2'),
		data: {},
		success: function(response) {
			$('#retrieve-token2 .log').html(JSON.stringify(response, null, "\t"));
			if(response.success) {
				retrievePCRF();
			}
			else {
				$('#retrieve-token2').addClass('hide');
				retry(() => {
					retrieveToken2();
				});
			}
		},
		error: function(err) {
			$('#retrieve-token2 .log').html('error');
		}
	});
}

function retrievePCRF() {
	$('#retrieve-token2').addClass('hide');
	$('#retrieve-pcrf').removeClass('hide');
	$('#retrieve-pcrf .log').html('loading...');
	$.ajax({
		method: 'post',
		dataType: 'json',
		url: site_url('Main/retrievePCRF'),
		data: {},
		success: function(response) {
			$('#retrieve-pcrf .log').html(JSON.stringify(response, null, "\t"));
			if(response.success) {
				retrieveSpeed();
			}
			else {
				$('#retrieve-pcrf').addClass('hide');
				retry(() => {
					retrievePCRF();
				});
			}
		},
		error: function(err) {
			$('#retrieve-pcrf .log').html('error');
		}
	});
}

function retrieveSpeed() {
	$('#retrieve-pcrf').addClass('hide');
	$('#retrieve-speed').removeClass('hide');
	$('#retrieve-speed .log').html('loading...');
	$.ajax({
		method: 'post',
		dataType: 'json',
		url: site_url('Main/retrieveSpeed'),
		data: {},
		success: function(response) {
			$('#retrieve-speed .log').html(JSON.stringify(response, null, "\t"));
			if(response.success) {
				response.data.speed_passed = Number(response.data.speed_passed);
				if(response.data.speed_passed > 0) {
					$('.speed-passed').addClass('hide');
					$('.speed-passed[data-passed="' + response.data.speed_passed + '"]').removeClass('hide');
					$('#retrieve-speed').addClass('hide');
					$('#stop-speed').removeClass('hide');
				}
				else {
					showFinish('Silahkan test ulang (3x)');
				}
			}
			else {
				$('#retrieve-speed').addClass('hide');
				retry(() => {
					retrieveSpeed();
				});
			}
		},
		error: function(err) {
			$('#retrieve-speed .log').html('error');
		}
	});
}

function retrieveClose(close) {
	$('#stop-speed').addClass('hide');
	$('#retrieve-close').removeClass('hide');
	$('#retrieve-close .log').html('loading...');
	$.ajax({
		method: 'post',
		dataType: 'json',
		url: site_url('Main/retrieveClose'),
		data: {
			close: close
		},
		success: function(response) {
			$('#retrieve-close .log').html(JSON.stringify(response, null, "\t"));
			if(response.success) {
				if(Number(response.data.close) > 0) {
					showFinish('Terima kasih atas kepercayaan anda menggunakan layanan Indihome');
				}
				else {
					showFinish('Anda memilih untuk tidak menutup laporan gangguan');
				}
			}
			else {
				$('#retrieve-close').addClass('hide');
				retry(() => {
					retrieveClose(close);
				});
			}
		},
		error: function(err) {
			$('#retrieve-speed .log').html('error');
		}
	});
}

function showFinish(message) {
	$('.wizard').addClass('hide');
	$('#stop-finish').removeClass('hide');
	$('#stop-finish .message').html(message);
}

function retry(cb) {
	attempt++;
	$('#retry').removeClass('hide');
	if(attempt < 5) {
		$('#retry-attempt').html(attempt);
		$('#retry .message.restart').addClass('hide');
		$('#retry .message.retry').removeClass('hide');
		let iMax = 3;
		let iTimer = 0;
		$('#retry-timer').html((iMax - iTimer) + ' detik');
		let oTimer = setInterval(function() {
			if(iTimer == iMax) {
				clearInterval(oTimer);
				$('#retry').addClass('hide');
				cb();
			}
			else {
				iTimer++;
				$('#retry-timer').html((iMax - iTimer) + ' detik');
			}
		}, 1);
	}
	else {
		$('#retry .message.retry').addClass('hide');
		$('#retry .message.restart').removeClass('hide');
	}
}




/*
function retrieveSession() {
	$('#create-task').addClass('hide');
	$('#retrieve-session').removeClass('hide');
	$('#retrieve-session .log').html('loading...');
	$.ajax({
		method: 'get',
		dataType: 'json',
		url: 'https://mysession.telkom.co.id/getSession.php?appsid=INFCloseInet',
		success: function(response) {
			$('#retrieve-session .log').html(JSON.stringify(response, null, "\t"));
			let session_id = null;
			if(typeof response.id != 'undefined') {
				session_id = response.id;
				retrieveAttribute(response.id);
			}
			$.ajax({
				method: 'post',
				dataType: 'json',
				url: site_url('Main/saveSession'),
				data: {
					session_id: session_id, 
					success: 1,
					request: null,
					response: JSON.stringify(response)
				},
				success: function() {
					
				}
			});
		},
		error: function(err) {
			$('#retrieve-session .log').html('error');
		}
	});
}

function retrieveAttribute(session_id) {
	$('#retrieve-session').addClass('hide');
	$('#retrieve-attribute').removeClass('hide');
	$('#retrieve-attribute .log').html('loading...');
	$.ajax({
		method: 'get',
		dataType: 'json',
		url: 'https://mysession.telkom.co.id/getSessionAttr.php?id='+session_id,
		success: function(response) {
			$('#retrieve-attribute .log').html(JSON.stringify(response, null, "\t"));
			if(typeof response.data != 'undefined') {
				decryptAttribute(session_id, response.data);
			}
			$.ajax({
				method: 'post',
				dataType: 'json',
				url: site_url('Main/saveAttribute'),
				data: {
					success: 1,
					request: null,
					response: JSON.stringify(response)
				},
				success: function() {
					
				}
			});
		},
		error: function(err) {
			$('#retrieve-attribute .log').html('error');
		}
	});
}

function decryptAttribute(session_id, encrypted_data) {
	$('#retrieve-attribute').addClass('hide');
	$('#retrieve-decrypt').removeClass('hide');
	$('#retrieve-decrypt .log').html('loading...');
	$('#confirm-ticket').html('');
	$('#confirm-ipaddr').val('');
	$('#confirm-userid').val('');
	$('#confirm-encrypted_data').val(encrypted_data);
	$.ajax({
		method: 'post',
		dataType: 'json',
		url: site_url('Main/decryptAttribute'),
		data: {
			'session_id': session_id,
			'encrypted_data': encrypted_data
		},
		success: function(response) {
			$('#retrieve-decrypt .log').html(JSON.stringify(response, null, "\t"));
			if(response.success) {
				$('#confirm-ticket').html(response.data.ticket);
				$('#confirm-ipaddr').val(response.data.ipaddr);
				$('#confirm-userid').val(response.data.userid);
				showConfirm();
			}
			else {
				
			}
		},
		error: function(err) {
			$('#retrieve-decrypt .log').html('error');
		}
	});
	
}
*/