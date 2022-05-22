let obj_fup = {};
let obj_quota_yes = {};
let obj_quota_no = {};
$(function() {
	$('#btn-search').click(function(e) {
		e.preventDefault();
		$.ajax({
			method: 'post',
			contentType: "application/json",
			Accept: "application/json",
			dataType: 'json',
			url: 'Test/check/' + $('#i-ip').val(),
			data: {
				ip: $('#i-ip').val()
			},
			crossDomain: true,
			// contentType: 'application/json',
            beforeSend: function(xhr){
                xhr.withCredentials = true;
          },
			success: function(response) {
				if(response.success) {

					console.log(response.data.IPByND.status);
					
					// alert('success');
					$('#t-response tbody').empty();
					/*$('#t-response tbody').append(
						'<tr>' +
							'<td style=" width: 3px;">myIP</td>' +
							(response.data.who.status === "OK" ?
							'<td style=" width: 3px; color: #198754; font-weight: bold;">' + response.data.who.status + '</td>' 
							:
							'<td style=" width: 3px;  color: #fc0000; font-weight: bold;">' + response.data.who.status + '</td>' 
							) + 
							
							'<td style=" max-width: 40px;">' + response.data.who.success + '</td>' +
							'<td style=" max-width: 20px;">' + response.data.who.failed + '</td>' +
						'</tr>'
						+
						'<tr>' +
							'<td style=" width: 3px;">NDbyIP Radius</td>' +
							( response.data.NDbyIP.status ==="OK" ? 
							'<td style=" width: 3px; color: #198754; font-weight: bold;">' + response.data.NDbyIP.status + '</td>' 
							:
							'<td style=" width: 3px; color: #fc0000; font-weight: bold;">' + response.data.NDbyIP.status + '</td>' 
							) +
							'<td style=" max-width: 40px;">' + JSON.stringify(JSON.parse(response.data.NDbyIP.success),null,2) + '</td>' +
							'<td style=" max-width: 20px;">' + response.data.NDbyIP.failed  + '</td>' +
						'</tr>'
						+
						'<tr>' +
							'<td style=" width: 3px;">IPByND Radius</td>' +
							( response.data.IPByND.status  === "OK" ?
							'<td  style=" width: 3px; color: #198754; font-weight: bold;">' + response.data.IPByND.status + '</td>' 
							:
							'<td  style=" width: 3px; color: #fc0000; font-weight: bold;">' + response.data.IPByND.status + '</td>' 
							) + 
							'<td style=" max-width: 40px;">' + JSON.stringify(JSON.parse(response.data.IPByND.success),null,2) + '</td>' +
							'<td style=" max-width: 20px;">' + response.data.IPByND.failed  + '</td>' +
						'</tr>'
						+
						'<tr>' +
							'<td style=" width: 3px;">Token APIGW</td>' +
							( response.data.token.status ==="OK" ?
							'<td style=" width: 3px; color: #198754; font-weight: bold;">' + response.data.token.status + '</td>' 
							:
							'<td style=" width: 3px; color: #fc0000; font-weight: bold;">' + response.data.token.status + '</td>' 
							) + 
							'<td style=" max-width: 40px;">' + JSON.stringify(JSON.parse(response.data.token.success),null,2) + '</td>' +
							'<td style=" max-width: 20px;">' + response.data.token.failed  + '</td>' +
						'</tr>'
						+
						'<tr>' +
							'<td style=" width: 3px;">PCRF</td>' +
							(response.data.pcrf.status ==="OK" ? 
							'<td style=" width: 3px; color: #198754; font-weight: bold;">' + response.data.pcrf.status + '</td>' 
							:
							'<td style=" width: 3px; color: #fc0000; font-weight: bold;">' + response.data.pcrf.status + '</td>' 
							) + 
							'<td style=" max-width: 40px;">' + JSON.stringify(JSON.parse(response.data.pcrf.success),null,2) + '</td>' +
							'<td style=" max-width: 20px;">' + response.data.pcrf.failed + '</td>' +
						'</tr>'
						+
						'<tr>' +
							'<td style=" width: 3px;">Redaman iBooster</td>' +
							( response.data.redaman.status ==="OK" ?
							'<td style=" width: 3px; color: #198754; font-weight: bold;">' + response.data.redaman.status + '</td>' 
							:
							'<td style=" width: 3px; color: #198754; font-weight: bold;">' + response.data.redaman.status + '</td>' 
							) + 
							'<td style=" max-width: 40px;">' + JSON.stringify(JSON.parse(response.data.redaman.success),null,2) + '</td>' +
							'<td style=" max-width: 20px;">' + response.data.redaman.failed + '</td>' +
						'</tr>'
					);*/

					$('#t-response tbody').append(
						'<tr>' +
							'<td style=" width: 1px; font-weight: bold;">Status</td>' +
							(response.data.who.status === "OK" ?
							'<td style="color: #198754; font-weight: bold;">' + response.data.who.status + '</td>' 
							:
							'<td style="  color: #fc0000; font-weight: bold;">' + response.data.who.status + '</td>' 
							) + 
							( response.data.NDbyIP.status ==="OK" ? 
							'<td style=" color: #198754; font-weight: bold;">' + response.data.NDbyIP.status + '</td>' 
							:
							'<td style=" color: #fc0000; font-weight: bold;">' + response.data.NDbyIP.status + '</td>' 
							) +
							( response.data.IPByND.status  === "OK" ?
							'<td  style=" color: #198754; font-weight: bold;">' + response.data.IPByND.status + '</td>' 
							:
							'<td  style=" color: #fc0000; font-weight: bold;">' + response.data.IPByND.status + '</td>' 
							) + 
							( response.data.token.status ==="OK" ?
							'<td style=" color: #198754; font-weight: bold;">' + response.data.token.status + '</td>' 
							:
							'<td style=" color: #fc0000; font-weight: bold;">' + response.data.token.status + '</td>' 
							) + 
							(response.data.pcrf.status ==="OK" ? 
							'<td style=" color: #198754; font-weight: bold;">' + response.data.pcrf.status + '</td>' 
							:
							'<td style=" color: #fc0000; font-weight: bold;">' + response.data.pcrf.status + '</td>' 
							) + 
							( response.data.redaman.status ==="OK" ?
							'<td style=" color: #198754; font-weight: bold;">' + response.data.redaman.status + '</td>' 
							:
							'<td style=" color: #198754; font-weight: bold;">' + response.data.redaman.status + '</td>' 
							) + 
						'</tr>'
						+
						'<tr>' +
							'<td style=" width: 1px; font-weight: bold; vertical-align: top">Response</td>' +
							'<td style=" max-width: 40px; vertical-align: top">' + response.data.who.success + '</td>' +
							'<td style=" max-width: 30px; vertical-align: top">' + JSON.stringify(JSON.parse(response.data.NDbyIP.success),null,2) + '</td>' +
							'<td style=" max-width: 60px;  vertical-align: top">' + JSON.stringify(JSON.parse(response.data.IPByND.success),null,2) + '</td>' +
							'<td style=" max-width: 40px;  vertical-align: top">' + JSON.stringify(JSON.parse(response.data.token.success),null,2) + '</td>' +
							'<td style=" max-width: 60px; vertical-align: top">' + JSON.stringify(JSON.parse(response.data.pcrf.success),null,2) + '</td>' +
							'<td style=" max-width: 60px;  vertical-align: top">' + JSON.stringify(JSON.parse(response.data.redaman.success),null,2) + '</td>' +

						'</tr>'
						+
						'<tr>' +
							'<td style=" width: 1px; font-weight: bold;">Failed</td>' +
							'<td style=" max-width: 10px;">' + response.data.who.failed + '</td>' +
							'<td style=" max-width: 10px;">' + response.data.NDbyIP.failed  + '</td>' +
							'<td style=" max-width: 10px;">' + response.data.IPByND.failed  + '</td>' +
							'<td style=" max-width: 10px;">' + response.data.token.failed  + '</td>' +
							'<td style=" max-width: 10px;">' + response.data.pcrf.failed + '</td>' +
							'<td style=" max-width: 10px;">' + response.data.redaman.failed + '</td>' +
						'</tr>'
						// +
						// '<tr>' +
						// 	'<td style=" width: 3px;">Token APIGW</td>' +
						// 	( response.data.token.status ==="OK" ?
						// 	'<td style=" width: 3px; color: #198754; font-weight: bold;">' + response.data.token.status + '</td>' 
						// 	:
						// 	'<td style=" width: 3px; color: #fc0000; font-weight: bold;">' + response.data.token.status + '</td>' 
						// 	) + 
						// 	'<td style=" max-width: 40px;">' + JSON.stringify(JSON.parse(response.data.token.success),null,2) + '</td>' +
						// 	'<td style=" max-width: 20px;">' + response.data.token.failed  + '</td>' +
						// '</tr>'
						// +
						// '<tr>' +
						// 	'<td style=" width: 3px;">PCRF</td>' +
						// 	(response.data.pcrf.status ==="OK" ? 
						// 	'<td style=" width: 3px; color: #198754; font-weight: bold;">' + response.data.pcrf.status + '</td>' 
						// 	:
						// 	'<td style=" width: 3px; color: #fc0000; font-weight: bold;">' + response.data.pcrf.status + '</td>' 
						// 	) + 
						// 	'<td style=" max-width: 40px;">' + JSON.stringify(JSON.parse(response.data.pcrf.success),null,2) + '</td>' +
						// 	'<td style=" max-width: 20px;">' + response.data.pcrf.failed + '</td>' +
						// '</tr>'
						// +
						// '<tr>' +
						// 	'<td style=" width: 3px;">Redaman iBooster</td>' +
						// 	( response.data.redaman.status ==="OK" ?
						// 	'<td style=" width: 3px; color: #198754; font-weight: bold;">' + response.data.redaman.status + '</td>' 
						// 	:
						// 	'<td style=" width: 3px; color: #198754; font-weight: bold;">' + response.data.redaman.status + '</td>' 
						// 	) + 
						// 	'<td style=" max-width: 40px;">' + JSON.stringify(JSON.parse(response.data.redaman.success),null,2) + '</td>' +
						// 	'<td style=" max-width: 20px;">' + response.data.redaman.failed + '</td>' +
						// '</tr>'
					);
				}
			}
		});
	});
	setInterval(function() {
		$('#btn-search').click();
	}, 60000);
});


function list_fup() {
	$.ajax({
		method: 'post',
		dataType: 'json',
		url: site_url('Package/jsonList_fup'),
		data: {},
		success: function(response) {
			if(response.success) {
				obj_fup = {};
				$('#t-fup tbody').empty();
				$.each(response.data, (a,b) => {
					obj_fup[b.id] = JSON.parse(JSON.stringify(b));
					if(b.speed_unit_1 == 'G') {
						b.speed_unit_1 = 'Gbps';
					}
					else if(b.speed_unit_1 == 'M') {
						b.speed_unit_1 = 'Mbps';
					}
					else {
						b.speed_unit_1 = 'Kbps';
					}
					if(b.speed_unit_2 == 'G') {
						b.speed_unit_2 = 'Gbps';
					}
					else if(b.speed_unit_2 == 'M') {
						b.speed_unit_2 = 'Mbps';
					}
					else {
						b.speed_unit_2 = 'Kbps';
					}
					if(b.speed_unit_3 == 'G') {
						b.speed_unit_3 = 'Gbps';
					}
					else if(b.speed_unit_3 == 'M') {
						b.speed_unit_3 = 'Mbps';
					}
					else {
						b.speed_unit_3 = 'Kbps';
					}
					$('#t-fup tbody').append(
						'<tr>' +
							'<td><a href="" class="a-fup" data-id="' + b.id + '">' + b.package_name + '</a></td>' +
							'<td class="al-r">' + b.speed_amount_1 +  b.speed_unit_1 + '</td>' +
							'<td class="al-r">' + b.speed_amount_2 +  b.speed_unit_2 + '</td>' +
							'<td class="al-r">' + b.speed_amount_3 +  b.speed_unit_3 + '</td>' +
							'<td class="al-r">' + b.usage_amount_2 +  b.usage_unit_2 + '</td>' +
							'<td class="al-r">' + b.usage_amount_3 +  b.usage_unit_3 + '</td>' +
						'</tr>'
					);
				});
				$('.a-fup').unbind('click');
				$('.a-fup').click(function(e) {
					e.preventDefault();
					$('#c-fup-new').addClass('hide');
					$('#c-fup-edit').removeClass('hide');
					let id = $(this).attr('data-id');
					$('#i-fup-edit-id').val(id);
					$('#i-fup-edit-package_name').val(obj_fup[id].package_name);
					$('#i-fup-edit-speed_amount_1').val(obj_fup[id].speed_amount_1);
					$('#i-fup-edit-speed_amount_2').val(obj_fup[id].speed_amount_2);
					$('#i-fup-edit-speed_amount_3').val(obj_fup[id].speed_amount_3);
					$('#i-fup-edit-speed_unit_1').val(obj_fup[id].speed_unit_1);
					$('#i-fup-edit-speed_unit_2').val(obj_fup[id].speed_unit_2);
					$('#i-fup-edit-speed_unit_3').val(obj_fup[id].speed_unit_3);
					$('#i-fup-edit-usage_amount_2').val(obj_fup[id].usage_amount_2);
					$('#i-fup-edit-usage_amount_3').val(obj_fup[id].usage_amount_3);
				});
			}
		}
	});
}

function list_quota_yes() {
	$.ajax({
		method: 'post',
		dataType: 'json',
		url: site_url('Package/jsonList_quota_yes'),
		data: {},
		success: function(response) {
			if(response.success) {
				obj_quota_yes = {};
				$('#t-quota_yes tbody').empty();
				$.each(response.data, (a,b) => {
					obj_quota_yes[b.id] = JSON.parse(JSON.stringify(b));
					$('#t-quota_yes tbody').append(
						'<tr>' +
							'<td><a href="" class="a-quota_yes" data-id="' + b.id + '">' + b.package_name + '</a></td>' +
							'<td class="al-r">' + b.quota +  b.unit + '</td>' +
						'</tr>'
					);
				});
				$('.a-quota_yes').unbind('click');
				$('.a-quota_yes').click(function(e) {
					e.preventDefault();
					$('#c-quota_yes-new').addClass('hide');
					$('#c-quota_yes-edit').removeClass('hide');
					let id = $(this).attr('data-id');
					$('#i-quota_yes-edit-id').val(id);
					$('#i-quota_yes-edit-package_name').val(obj_quota_yes[id].package_name);
					$('#i-quota_yes-edit-quota').val(obj_quota_yes[id].quota);
					$('#i-quota_yes-edit-unit').val(obj_quota_yes[id].unit);
				});
			}
		}
	});
}

function list_quota_no() {
	$.ajax({
		method: 'post',
		dataType: 'json',
		url: site_url('Package/jsonList_quota_no'),
		data: {},
		success: function(response) {
			if(response.success) {
				obj_quota_no = {};
				$('#t-quota_no tbody').empty();
				$.each(response.data, (a,b) => {
					obj_quota_no[b.id] = JSON.parse(JSON.stringify(b));
					$('#t-quota_no tbody').append(
						'<tr>' +
							'<td><a href="" class="a-quota_no" data-id="' + b.id + '">' + b.package_name + '</a></td>' + '<td class="al-r">' + b.speed +  b.unit + '</td>' +
						'</tr>'
					);
				});
				$('.a-quota_no').unbind('click');
				$('.a-quota_no').click(function(e) {
					e.preventDefault();
					$('#c-quota_no-new').addClass('hide');
					$('#c-quota_no-edit').removeClass('hide');
					let id = $(this).attr('data-id');
					$('#i-quota_no-edit-id').val(id);
					$('#i-quota_no-edit-package_name').val(obj_quota_no[id].package_name);
					$('#i-quota_no-edit-speed').val(obj_quota_no[id].speed);
					$('#i-quota_no-edit-unit').val(obj_quota_no[id].unit);
				});
			}
		}
	});
}
