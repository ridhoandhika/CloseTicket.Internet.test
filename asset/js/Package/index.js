let obj_fup = {};
let obj_quota_yes = {};
let obj_quota_no = {};
$(function() {
	list_fup();
	$('#b-fup-edit-cancel').click(function(e) {
		e.preventDefault();
		$('#c-fup-edit').addClass('hide');
		$('#c-fup-new').removeClass('hide');
	});
	$('#b-fup-edit-save').click(function(e) {
		e.preventDefault();
		$.ajax({
			method: 'post',
			dataType: 'json',
			url: site_url('Package/jsonUpdate_fup'),
			data: {
				id: $('#i-fup-edit-id').val(),
				package_name: $('#i-fup-edit-package_name').val(),
				speed_amount_1: $('#i-fup-edit-speed_amount_1').val(),
				speed_amount_2: $('#i-fup-edit-speed_amount_2').val(),
				speed_amount_3: $('#i-fup-edit-speed_amount_3').val(),
				speed_unit_1: $('#i-fup-edit-speed_unit_1').val(),
				speed_unit_2: $('#i-fup-edit-speed_unit_2').val(),
				speed_unit_3: $('#i-fup-edit-speed_unit_3').val(),
				usage_amount_2: $('#i-fup-edit-usage_amount_2').val(),
				usage_amount_3: $('#i-fup-edit-usage_amount_3').val(),
				usage_unit_2: $('#i-fup-edit-usage_unit_2').val(),
				usage_unit_3: $('#i-fup-edit-usage_unit_2').val()
			},
			success: function(response) {
				if(response.success) {
					alert('update success');
					list_fup();
					$('#c-fup-edit').addClass('hide');
					$('#c-fup-new').removeClass('hide');
				}
			}
		});
	});
	$('#b-fup-edit-delete').click(function(e) {
		e.preventDefault();
		r = confirm('delete ' + $('#i-fup-edit-package_name').val());
		if(r) {
			$.ajax({
				method: 'post',
				dataType: 'json',
				url: site_url('Package/jsonDelete_fup'),
				data: {
					id: $('#i-fup-edit-id').val()
				},
				success: function(response) {
					if(response.success) {
						alert('update success');
						list_fup();
						$('#c-fup-edit').addClass('hide');
						$('#c-fup-new').removeClass('hide');
					}
				}
			});
		}
	});
	$('#b-fup-new-save').click(function(e) {
		e.preventDefault();
		$.ajax({
			method: 'post',
			dataType: 'json',
			url: site_url('Package/jsonCreate_fup'),
			data: {
				package_name: $('#i-fup-new-package_name').val(),
				speed_amount_1: $('#i-fup-new-speed_amount_1').val(),
				speed_amount_2: $('#i-fup-new-speed_amount_2').val(),
				speed_amount_3: $('#i-fup-new-speed_amount_3').val(),
				speed_unit_1: $('#i-fup-new-speed_unit_1').val(),
				speed_unit_2: $('#i-fup-new-speed_unit_2').val(),
				speed_unit_3: $('#i-fup-new-speed_unit_3').val(),
				usage_amount_2: $('#i-fup-new-usage_amount_2').val(),
				usage_amount_3: $('#i-fup-new-usage_amount_3').val(),
				usage_unit_2: $('#i-fup-new-usage_unit_2').val(),
				usage_unit_3: $('#i-fup-new-usage_unit_2').val()
			},
			success: function(response) {
				if(response.success) {
					alert('update success');
					list_fup();
					$('#i-fup-new-package_name').val('');
					$('#i-fup-new-speed_amount_1').val(0);
					$('#i-fup-new-speed_amount_2').val(0);
					$('#i-fup-new-speed_amount_3').val(0);
					$('#i-fup-new-speed_unit_1').val('');
					$('#i-fup-new-speed_unit_2').val('');
					$('#i-fup-new-speed_unit_3').val('');
					$('#i-fup-new-usage_amount_2').val(0);
					$('#i-fup-new-usage_amount_3').val(0);
					$('#i-fup-new-usage_unit_2').val('');
					$('#i-fup-new-usage_unit_2').val('');
				}
			}
		});
	});
	list_quota_yes();
	$('#b-quota_yes-edit-cancel').click(function(e) {
		e.preventDefault();
		$('#c-quota_yes-edit').addClass('hide');
		$('#c-quota_yes-new').removeClass('hide');
	});
	$('#b-quota_yes-edit-save').click(function(e) {
		e.preventDefault();
		$.ajax({
			method: 'post',
			dataType: 'json',
			url: site_url('Package/jsonUpdate_quota_yes'),
			data: {
				id: $('#i-quota_yes-edit-id').val(),
				package_name: $('#i-quota_yes-edit-package_name').val(),
				quota: $('#i-quota_yes-edit-quota').val(),
				unit: $('#i-quota_yes-edit-unit').val()
			},
			success: function(response) {
				if(response.success) {
					alert('update success');
					list_quota_yes();
					$('#c-quota_yes-edit').addClass('hide');
					$('#c-quota_yes-new').removeClass('hide');
				}
			}
		});
	});
	$('#b-quota_yes-edit-delete').click(function(e) {
		e.preventDefault();
		r = confirm('delete ' + $('#i-quota_yes-edit-package_name').val());
		if(r) {
			$.ajax({
				method: 'post',
				dataType: 'json',
				url: site_url('Package/jsonDelete_quota_yes'),
				data: {
					id: $('#i-quota_yes-edit-id').val()
				},
				success: function(response) {
					if(response.success) {
						alert('update success');
						list_quota_yes();
						$('#c-quota_yes-edit').addClass('hide');
						$('#c-quota_yes-new').removeClass('hide');
					}
				}
			});
		}
	});
	$('#b-quota_yes-new-save').click(function(e) {
		e.preventDefault();
		$.ajax({
			method: 'post',
			dataType: 'json',
			url: site_url('Package/jsonCreate_quota_yes'),
			data: {
				package_name: $('#i-quota_yes-new-package_name').val(),
				quota: $('#i-quota_yes-new-quota').val(),
				unit: $('#i-quota_yes-new-unit').val()
			},
			success: function(response) {
				if(response.success) {
					alert('update success');
					list_quota_yes();
					$('#i-quota_yes-new-package_name').val('');
					$('#i-quota_yes-new-quota').val(0);
					$('#i-quota_yes-new-unit').val('');
				}
			}
		});
	});
	list_quota_no();
	$('#b-quota_no-edit-cancel').click(function(e) {
		e.preventDefault();
		$('#c-quota_no-edit').addClass('hide');
		$('#c-quota_no-new').removeClass('hide');
	});
	$('#b-quota_no-edit-save').click(function(e) {
		e.preventDefault();
		$.ajax({
			method: 'post',
			dataType: 'json',
			url: site_url('Package/jsonUpdate_quota_no'),
			data: {
				id: $('#i-quota_no-edit-id').val(),
				package_name: $('#i-quota_no-edit-package_name').val(),
				speed: $('#i-quota_no-edit-speed').val(),
				unit: $('#i-quota_no-edit-unit').val()
			},
			success: function(response) {
				if(response.success) {
					alert('update success');
					list_quota_no();
					$('#c-quota_no-edit').addClass('hide');
					$('#c-quota_no-new').removeClass('hide');
				}
			}
		});
	});
	$('#b-quota_no-edit-delete').click(function(e) {
		e.preventDefault();
		r = confirm('delete ' + $('#i-quota_no-edit-package_name').val());
		if(r) {
			$.ajax({
				method: 'post',
				dataType: 'json',
				url: site_url('Package/jsonDelete_quota_no'),
				data: {
					id: $('#i-quota_no-edit-id').val()
				},
				success: function(response) {
					if(response.success) {
						alert('update success');
						list_quota_no();
						$('#c-quota_no-edit').addClass('hide');
						$('#c-quota_no-new').removeClass('hide');
					}
				}
			});
		}
	});
	$('#b-quota_no-new-save').click(function(e) {
		e.preventDefault();
		$.ajax({
			method: 'post',
			dataType: 'json',
			url: site_url('Package/jsonCreate_quota_no'),
			data: {
				package_name: $('#i-quota_no-new-package_name').val(),
				speed: $('#i-quota_no-new-speed').val(),
				unit: $('#i-quota_no-new-unit').val()
			},
			success: function(response) {
				if(response.success) {
					alert('update success');
					list_quota_no();
					$('#i-quota_no-new-package_name').val('');
					$('#i-quota_no-new-speed').val(0);
					$('#i-quota_no-new-unit').val('');
				}
			}
		});
	});
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
							'<td><a href="" class="a-quota_no" data-id="' + b.id + '">' + b.package_name + '</a></td>' +
							'<td class="al-r">' + b.speed +  b.unit + '</td>' +
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