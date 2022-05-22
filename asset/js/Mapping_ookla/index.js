let obj_fup = {};
let obj_quota_yes = {};
let obj_quota_no = {};

let flagsearch = false;

$(function() {
	list_fup();
	// show("8","0");

// $(".prev-btn").on("click", function(){
// 	if(page > 1){
// 		page--;
// 		list_fup()
// 	}
// 	console.log("Prev Page: " + page)
// });
// $(".next-btn").on("click", function(){
// 	if(page * pagelimit < totalrecord){
// 		page++;
// 		list_fup()
// 	}
// 	console.log("Next Page: " + page)
// });

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
			url: site_url('Mapping_ookla/jsonUpdate_fup'),
			data: {
				id: $('#i-edit-id').val(),
				Subnet: $('#i-edit-Subnet').val(),
				bras_id: $('#i-edit-bras_id').val(),
				speedtest: $('#i-edit-speedtest').val(),
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
				url: site_url('Mapping_ookla/jsonDelete_fup'),
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
			url: site_url('Mapping_ookla/jsonCreate_fup'),
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
	
	$('#btn-search').click(function(e) {
		$('#btn-search').val('Search');
		serachMapping();
	});
});





function list_fup() {
	$.ajax({
		method: 'post',
		dataType: 'json',
		url: site_url('Mapping_ookla/jsonList_mapping'),
		data: {},
		success: function(response) {
			if(response.success) {
				totalrecord = (response.data).length;
				console.log(totalrecord);
				obj_fup = {};
				$('#t-fup tbody').empty();
				$("#t-fup tbody").html("");
				$.each(response.data, (a,b) => {
					obj_fup[b.id] = JSON.parse(JSON.stringify(b));
					$("#t-fup tbody").append('<tr>'+
						'<td><a href="" class="a-fup" data-id="' + b.id + '">' + b.ip_bras + '</a></td>' +
						'<td class="al-r">' + b.bras + '</td>' +
						'<td class="al-r">' + b.speedtest +'</td>' +
						'</tr>'
					);
				});
				$('.a-fup').unbind('click');
				$('.a-fup').click(function(e) {
					e.preventDefault();
					$('#c-fup-new').addClass('hide');
					$('#c-fup-edit').removeClass('hide');
					let id = $(this).attr('data-id');
					$('#i-edit-id').val(id);
					$('#i-edit-Subnet').val(obj_fup[id].ip_bras);
					$('#i-edit-bras_id').val(obj_fup[id].bras);
					$('#i-edit-speedtest').val(obj_fup[id].speedtest);

				});
			}
		}
	});
}

function serachMapping() {
	$.ajax({
		method: 'post',
		dataType: 'json',
		url: site_url('Mapping_ookla/jsonSearch_mapping'),
		data: {
			ip_bras: $('#search').val()
		},
		success: function(response) {
			if(response.success) {
				totalrecord = (response.data).length;
				console.log(totalrecord);
				obj_fup = {};
				$('#t-fup tbody').empty();
				$("#t-fup tbody").html("");
				$.each(response.data, (a,b) => {
					obj_fup[b.id] = JSON.parse(JSON.stringify(b));
					$("#t-fup tbody").append('<tr>'+
						'<td><a href="" class="a-fup" data-id="' + b.id + '">' + b.ip_bras + '</a></td>' +
						'<td class="al-r">' + b.bras + '</td>' +
						'<td class="al-r">' + b.speedtest +'</td>' +
						'</tr>'
					);
				});
				$('.a-fup').unbind('click');
				$('.a-fup').click(function(e) {
					e.preventDefault();
					$('#c-fup-new').addClass('hide');
					$('#c-fup-edit').removeClass('hide');
					let id = $(this).attr('data-id');
					$('#i-edit-id').val(id);
					$('#i-edit-Subnet').val(obj_fup[id].ip_bras);
					$('#i-edit-bras_id').val(obj_fup[id].bras);
					$('#i-edit-speedtest').val(obj_fup[id].speedtest);

				});
			}
		}
	});
}

