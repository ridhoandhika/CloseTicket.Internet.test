window.chartColors = {
	red: 'rgb(255, 99, 132)',
	orange: 'rgb(255, 159, 64)',
	yellow: 'rgb(255, 205, 86)',
	green: 'rgb(75, 192, 192)',
	blue: 'rgb(54, 162, 235)',
	purple: 'rgb(153, 102, 255)',
	grey: 'rgb(201, 203, 207)'
};

var config01 = {
	type: 'doughnut',
	data: {
		datasets: [
			{
				data: [0, 0],
				backgroundColor: [window.chartColors.blue, window.chartColors.red],
				label: 'Dataset 1'
			}
		],
		labels: ['ticket ok', 'ticket not ok']
	},
	options: {
		elements:{
			arc: {
				borderWidth: 0
			}
		}, 
		cutoutPercentage: 70,
		responsive: true,
		legend: false,
		title: {
			display: false
		},
		animation: {
			animateScale: true,
			animateRotate: true
		}
	}
};

var config02 = {
	type: 'doughnut',
	data: {
		datasets: [
			{
				data: [0, 0],
				backgroundColor: [window.chartColors.blue, window.chartColors.red],
				label: 'Dataset 1'
			}
		],
		labels: ['sukses redaman', 'tidak sukses redaman']
	},
	options: {
		elements:{
			arc: {
				borderWidth: 0
			}
		}, 
		cutoutPercentage: 70,
		responsive: true,
		legend: false,
		title: {
			display: false
		},
		animation: {
			animateScale: true,
			animateRotate: true
		}
	}
};

var config03 = {
	type: 'doughnut',
	data: {
		datasets: [
			{
				data: [0, 0],
				backgroundColor: [window.chartColors.blue, window.chartColors.red],
				label: 'Dataset 1'
			}
		],
		labels: ['sukses speedtest', 'tidak sukses speedtest']
	},
	options: {
		elements:{
			arc: {
				borderWidth: 0
			}
		}, 
		cutoutPercentage: 70,
		responsive: true,
		legend: false,
		title: {
			display: false
		},
		animation: {
			animateScale: true,
			animateRotate: true
		}
	}
};

var ctx01 = null;
var	chart01 = null;

var ctx02 = null;
var	chart02 = null;

var ctx03 = null;
var	chart03 = null;


$(function() {
	ctx01 = $('#chart-area-01')[0].getContext('2d');
	chart01 = new Chart(ctx01, config01);
	
	ctx02 = $('#chart-area-02')[0].getContext('2d');
	chart02 = new Chart(ctx02, config02);
	
	ctx03 = $('#chart-area-03')[0].getContext('2d');
	chart03 = new Chart(ctx03, config03);
	
	$('#filter-submit-1').click(function(e) {
		e.preventDefault();
		$('#card-list-1').removeClass('hide');
		$('#card-list-2').addClass('hide');
		$('#selected-start').val($('#filter-start').val());
		$('#selected-finish').val($('#filter-finish').val());
		loadOverviewList();
	});
	$('#filter-submit-2').click(function(e) {
		e.preventDefault();
		$('#card-list-2').removeClass('hide');
		$('#card-list-1').addClass('hide');
		$('#selected-start').val($('#filter-start').val());
		$('#selected-finish').val($('#filter-finish').val());
		loadOverviewList();
	});
	$('#filter-submit-1').trigger('click');
	
	$('#ticket-search-submit').click(function(e) {
		e.preventDefault();
		$('#ticket-search-result tbody').empty();
		if($('#ticket-search-ticket').val()){
		$.ajax({
			method: 'post',
			dataType: 'json',
			url: site_url('Dashboard_old/jSearchTicket'),
			data: {
				'ticket': $('#ticket-search-ticket').val()
			},
			success: function(response) {
				if(typeof response['success'] != 'undefined' && response['success'] && typeof response['data'] != 'undefined' && typeof response['data']['detail'] != 'undefined') {
					i = 0;
					$.each(response['data']['detail'], function(a, b) {
						i++;
						$('#ticket-search-result tbody').append(
							'<tr>' +
								'<td>' + i + '</td>' +
								'<td>' + b['ts'] + '</td>' +
								'<td>' + b['ts_finish'] + '</td>' +
								'<td>' + b['ticket'] + '</td>' +
								'<td>' + b['nd'] + '</td>' +
								'<td>' + b['close'] + '</td>' +
								'<td>' + b['onu_rx_pwr'] + '</td>' +
								'<td>' + b['redaman_passed'] + '</td>' +
								'<td>' + b['speedtest_download'] + ' ' + b['speedtest_units'] + '</td>' +
								'<td>' + b['speedtest_upload'] + ' ' + b['speedtest_units'] + '</td>' +
								'<td>' + b['speed_passed'] + '</td>' +
								'<td>' + b['package_name'] + '</td>' +
								'<td>' + b['quota_used'] + '</td>' +
								'<td>' + b['remote_addr'] + '</td>' +
								'<td>' + b['bras'] + '</td>' +
								'<td>' + b['ip_addr'] + '</td>' +
								'<td>' + b['reg_type'] + '</td>' +
								'<td>' + b['version_id'] + '</td>' +
								'<td>' + b['identifier'] + '</td>' +
								'<td>' + b['speedtest_latency_minimum'] + '</td>' +
								'<td>' + b['speedtest_latency_jitter'] + '</td>' +
								'<td>' + b['token1_log_total_time'] + ' ms' + '</td>' +
								'<td>' + b['ndbyip_log_total_time'] + ' ms' + '</td>' +								
								'<td>' + b['redaman_log_total_time'] + ' ms' + '</td>' +	
								'<td>' + b['token2_log_total_time'] + ' ms' + '</td>' +
								'<td>' + b['pcrf_log_total_time'] + ' ms' + '</td>' +								
								'<td>' + b['uid'] + '</td>' +
							'</tr>'
						);
					});
					$('#modal-ticket-search').modal('show');
				}
			}
		}); 
		} else {
		$.ajax({
			method: 'post',
			dataType: 'json',
			url: site_url('Dashboard_old/jSearchTicket'),
			data: {
				'ticket': $('#ticket-search-ticket-adm').val()
			},
			success: function(response) {
				if(typeof response['success'] != 'undefined' && response['success'] && typeof response['data'] != 'undefined' && typeof response['data']['detail'] != 'undefined') {
					i = 0;
					$.each(response['data']['detail'], function(a, b) {
						i++;
						$('#ticket-search-result tbody').append(
							'<tr>' +
								'<td>' + i + '</td>' +
								'<td>' + b['uid'] + '</td>' +
								'<td>' + b['ts'] + '</td>' +
								'<td>' + b['ts_finish'] + '</td>' +
								'<td>' + b['remote_addr'] + '</td>' +
								'<td>' + b['bras'] + '</td>' +
								'<td>' + b['ip_addr'] + '</td>' +
								'<td>' + b['ticket'] + '</td>' +
								'<td>' + b['token1_log_total_time'] + ' ms' + '</td>' +
								'<td>' + b['ndbyip_log_total_time'] + ' ms' + '</td>' +
								'<td>' + b['nd'] + '</td>' +
								'<td>' + b['onu_rx_pwr'] + '</td>' +
								'<td>' + b['reg_type'] + '</td>' +
								'<td>' + b['version_id'] + '</td>' +
								'<td>' + b['identifier'] + '</td>' +
								'<td>' + b['redaman_log_total_time'] + ' ms' + '</td>' +
								'<td>' + b['redaman_passed'] + '</td>' +								
								'<td>' + b['token2_log_total_time'] + ' ms' + '</td>' +
								'<td>' + b['pcrf_log_total_time'] + ' ms' + '</td>' +	
								'<td>' + b['package_name'] + '</td>' +
								'<td>' + b['quota_used'] + '</td>' +
								'<td>' + b['speedtest_download'] + ' ' + b['speedtest_units'] + '</td>' +
								'<td>' + b['speedtest_upload'] + ' ' + b['speedtest_units'] + '</td>' +
								'<td>' + b['speedtest_latency_minimum'] + '</td>' +
								'<td>' + b['speedtest_latency_jitter'] + '</td>' +
								'<td>' + b['speed_passed'] + '</td>' +						
								'<td>' + b['close'] + '</td>' +
							'</tr>'
						);
					});
					$('#modal-ticket-search').modal('show');
				}
			}
		});

		}


	});
	
	$('#nd-search-submit').click(function(e) {
		e.preventDefault();
		$('#nd-search-result tbody').empty();
		$.ajax({
			method: 'post',
			dataType: 'json',
			url: site_url('Dashboard_old/jSearchND'),
			data: {
				'nd': $('#search-nd').val()
			},
			success: function(response) {
				if(typeof response['success'] != 'undefined' && response['success'] && typeof response['data'] != 'undefined' && typeof response['data']['detail'] != 'undefined') {
					i = 0;
					$.each(response['data']['detail'], function(a, b) {
						i++;
						$('#nd-search-result tbody').append(
							'<tr>' +
								'<td>' + i + '</td>' +
								'<td>' + b['uid'] + '</td>' +
								'<td>' + b['ts'] + '</td>' +
								'<td>' + b['ts_finish'] + '</td>' +
								'<td>' + b['remote_addr'] + '</td>' +
								'<td>' + b['bras'] + '</td>' +
								'<td>' + b['ip_addr'] + '</td>' +
								'<td>' + b['ticket'] + '</td>' +
								'<td>' + b['token1_log_total_time'] + ' ms' + '</td>' +
								'<td>' + b['ndbyip_log_total_time'] + ' ms' + '</td>' +
								'<td>' + b['nd'] + '</td>' +
								'<td>' + b['onu_rx_pwr'] + '</td>' +
								'<td>' + b['reg_type'] + '</td>' +
								'<td>' + b['version_id'] + '</td>' +
								'<td>' + b['identifier'] + '</td>' +
								'<td>' + b['redaman_log_total_time'] + ' ms' + '</td>' +
								'<td>' + b['redaman_passed'] + '</td>' +								
								'<td>' + b['token2_log_total_time'] + ' ms' + '</td>' +
								'<td>' + b['pcrf_log_total_time'] + ' ms' + '</td>' +	
								'<td>' + b['package_name'] + '</td>' +
								'<td>' + b['quota_used'] + '</td>' +
								'<td>' + b['speedtest_download'] + ' ' + b['speedtest_units'] + '</td>' +
								'<td>' + b['speedtest_upload'] + ' ' + b['speedtest_units'] + '</td>' +
								'<td>' + b['speedtest_latency_minimum'] + '</td>' +
								'<td>' + b['speedtest_latency_jitter'] + '</td>' +
								'<td>' + b['speed_passed'] + '</td>' +						
								'<td>' + b['close'] + '</td>' +
							'</tr>'
						);
					});
					$('#modal-nd-search').modal('show');
				}
			}
		});
	});
	
	$('#filter-start').change(function(){
		$('#xls-filter-start').val($(this).val());
	});
	
	$('#xls-submit').click(function(e){
		e.preventDefault();
		$('#xls-form').submit();
	});
	
	$('#xls-submit2').click(function(e){
		e.preventDefault();
		$('#xls-form2').submit();
	});
	
	
	setInterval(function() {
		loadOverviewList();
	}, 300000);
});




function loadOverviewList() {	
	$('#list-overview-1 tbody').empty();
	$('#list-overview-2 tbody').empty();
	config01.data.datasets[0].data[0] = 0;
	config01.data.datasets[0].data[1] = 0;
	config02.data.datasets[0].data[0] = 0;
	config02.data.datasets[0].data[1] = 0
	config03.data.datasets[0].data[0] = 0;
	config03.data.datasets[0].data[1] = 0;
	$.ajax({
		method: 'post',
		dataType: 'json',
		url: site_url('Dashboard_old/jOverviewList'),
		data: {
			'filter-start': $('#selected-start').val(),
			'filter-finish': $('#selected-finish').val()
		},
		success: function(response) {
			if(
				typeof response['success'] != 'undefined' 
				&& response['success'] 
				&& typeof response['data'] != 'undefined' 
				&& typeof response['data']['list'] != 'undefined'
				&& typeof response['data']['chart'] != 'undefined'
				&& typeof response['data']['chart']['01'] != 'undefined'
				&& typeof response['data']['chart']['02'] != 'undefined'
				&& typeof response['data']['chart']['03'] != 'undefined'
			) {
					
				config01.data.datasets[0].data[0] = response['data']['chart']['01']['close'];
				config01.data.datasets[0].data[1] = response['data']['chart']['01']['reopen'];
				config02.data.datasets[0].data[0] = response['data']['chart']['02']['success_redaman'];
				config02.data.datasets[0].data[1] = response['data']['chart']['02']['fail_redaman'];
				config03.data.datasets[0].data[0] = response['data']['chart']['03']['success_speedtest'];
				config03.data.datasets[0].data[1] = response['data']['chart']['03']['fail_speedtest'];
				let total = {
					whitelist: 0,
					blacklist: 0,
					who_success: 0,
					who_failed: 0,
					token_1_success: 0,
					token_1_failed: 0,
					nd_success: 0,
					nd_failed: 0,
					redaman_success_spec: 0,
					redaman_success_unspec: 0,
					redaman_failed: 0,
					pcrf_success: 0,
					pcrf_failed: 0,
					speedtest_success_passed_1: 0,
					speedtest_success_passed_0: 0,
					speedtest_failed: 0,
					close_1: 0,
					close_0: 0
				};
				$.each(response['data']['list'], function(a, b) {
					bInc = 0;
					let dateTotal = {
						whitelist: 0,
						blacklist: 0,
						who_success: 0,
						who_failed: 0,
						token_1_success: 0,
						token_1_failed: 0,
						nd_success: 0,
						nd_failed: 0,
						redaman_success_spec: 0,
						redaman_success_unspec: 0,
						redaman_failed: 0,
						pcrf_success: 0,
						pcrf_failed: 0,
						speedtest_success_passed_1: 0,
						speedtest_success_passed_0: 0,
						speedtest_failed: 0,
						close_1: 0,
						close_0: 0
					}
					$.each(b, function(c, d) {
						var htmlRowHour = '<tr>';
						if(bInc  == 0) {
							var splitDateLabel = a.split('-');
							htmlRowHour += '<td rowspan="24" class="rotate-date"><div class="rotate-out"><div class="rotate-in">' + splitDateLabel[0] + ' - ' + splitDateLabel[1] + ' - ' + splitDateLabel[2] + '</div></div></td>';
						}
						
						htmlRowHour += '<td>' + c + '</td>';
						htmlRowHour += '<td class="n">' + d['whitelist'] + '</td>';
						htmlRowHour += '<td class="n">' + d['blacklist'] + '</td>';
						htmlRowHour += '<td class="n"><a href="#" class="link-detail" data-detail-type="hour" data-detail-tick="' + d['tick'] + '" data-detail-field="who_success">' + d['who_success'] + '</a></td>';
						htmlRowHour += '<td class="n"><a href="#" class="link-detail" data-detail-type="hour" data-detail-tick="' + d['tick'] + '" data-detail-field="who_failed">' + d['who_failed'] + '</a></td>';
						htmlRowHour += '<td class="n"><a href="#" class="link-detail" data-detail-type="hour" data-detail-tick="' + d['tick'] + '" data-detail-field="token_1_success">' + d['token_1_success'] + '</a></td>';
						htmlRowHour += '<td class="n"><a href="#" class="link-detail" data-detail-type="hour" data-detail-tick="' + d['tick'] + '" data-detail-field="token_1_failed">' + d['token_1_failed'] + '</a></td>';
						htmlRowHour += '<td class="n"><a href="#" class="link-detail" data-detail-type="hour" data-detail-tick="' + d['tick'] + '" data-detail-field="nd_success">' + d['nd_success'] + '</a></td>';
						htmlRowHour += '<td class="n"><a href="#" class="link-detail" data-detail-type="hour" data-detail-tick="' + d['tick'] + '" data-detail-field="nd_failed">' + d['nd_failed'] + '</a></td>';
						htmlRowHour += '<td class="n"><a href="#" class="link-detail" data-detail-type="hour" data-detail-tick="' + d['tick'] + '" data-detail-field="redaman_success_spec">' + d['redaman_success_spec'] + '</a></td>';
						htmlRowHour += '<td class="n"><a href="#" class="link-detail" data-detail-type="hour" data-detail-tick="' + d['tick'] + '" data-detail-field="redaman_success_unspec">' + d['redaman_success_unspec'] + '</a></td>';
						htmlRowHour += '<td class="n"><a href="#" class="link-detail" data-detail-type="hour" data-detail-tick="' + d['tick'] + '" data-detail-field="redaman_failed">' + d['redaman_failed'] + '</a></td>';
						htmlRowHour += '<td class="n"><a href="#" class="link-detail" data-detail-type="hour" data-detail-tick="' + d['tick'] + '" data-detail-field="pcrf_success">' + d['pcrf_success'] + '</a></td>';
						htmlRowHour += '<td class="n"><a href="#" class="link-detail" data-detail-type="hour" data-detail-tick="' + d['tick'] + '" data-detail-field="pcrf_failed">' + d['pcrf_failed'] + '</a></td>';
						htmlRowHour += '<td class="n"><a href="#" class="link-detail" data-detail-type="hour" data-detail-tick="' + d['tick'] + '" data-detail-field="speedtest_success_passed_1">' + d['speedtest_success_passed_1'] + '</a></td>';
						htmlRowHour += '<td class="n"><a href="#" class="link-detail" data-detail-type="hour" data-detail-tick="' + d['tick'] + '" data-detail-field="speedtest_success_passed_0">' + d['speedtest_success_passed_0'] + '</a></td>';
						htmlRowHour += '<td class="n"><a href="#" class="link-detail" data-detail-type="hour" data-detail-tick="' + d['tick'] + '" data-detail-field="speedtest_failed">' + d['speedtest_failed'] + '</a></td>';
						htmlRowHour += '<td class="n"><a href="#" class="link-detail" data-detail-type="hour" data-detail-tick="' + d['tick'] + '" data-detail-field="close_1">' + d['close_1'] + '</a></td>';
						htmlRowHour += '<td class="n"><a href="#" class="link-detail" data-detail-type="hour" data-detail-tick="' + d['tick'] + '" data-detail-field="close_0">' + d['close_0'] + '</a></td>';
						$('#list-overview-1 tbody').append(htmlRowHour);
						
						dateTotal['whitelist'] += Number(d['whitelist']);
						dateTotal['blacklist'] += Number(d['blacklist']);
						dateTotal['who_success'] += Number(d['who_success']);
						dateTotal['who_failed'] += Number(d['who_failed']);
						dateTotal['token_1_success'] += Number(d['token_1_success']);
						dateTotal['token_1_failed'] += Number(d['token_1_failed']);
						dateTotal['nd_success'] += Number(d['nd_success']);
						dateTotal['nd_failed'] += Number(d['nd_failed']);
						dateTotal['redaman_success_spec'] += Number(d['redaman_success_spec']);
						dateTotal['redaman_success_unspec'] += Number(d['redaman_success_unspec']);
						dateTotal['redaman_failed'] += Number(d['redaman_failed']);
						dateTotal['pcrf_success'] += Number(d['pcrf_success']);
						dateTotal['pcrf_failed'] += Number(d['pcrf_failed']);
						dateTotal['speedtest_success_passed_1'] += Number(d['speedtest_success_passed_1']);
						dateTotal['speedtest_success_passed_0'] += Number(d['speedtest_success_passed_0']);
						dateTotal['speedtest_failed'] += Number(d['speedtest_failed']);
						dateTotal['close_1'] += Number(d['close_1']);
						dateTotal['close_0'] += Number(d['close_0']);
						
						total['whitelist'] += Number(d['whitelist']);
						total['blacklist'] += Number(d['blacklist']);
						total['who_success'] += Number(d['who_success']);
						total['who_failed'] += Number(d['who_failed']);
						total['token_1_success'] += Number(d['token_1_success']);
						total['token_1_failed'] += Number(d['token_1_failed']);
						total['nd_success'] += Number(d['nd_success']);
						total['nd_failed'] += Number(d['nd_failed']);
						total['redaman_success_spec'] += Number(d['redaman_success_spec']);
						total['redaman_success_unspec'] += Number(d['redaman_success_unspec']);
						total['redaman_failed'] += Number(d['redaman_failed']);
						total['pcrf_success'] += Number(d['pcrf_success']);
						total['pcrf_failed'] += Number(d['pcrf_failed']);
						total['speedtest_success_passed_1'] += Number(d['speedtest_success_passed_1']);
						total['speedtest_success_passed_0'] += Number(d['speedtest_success_passed_0']);
						total['speedtest_failed'] += Number(d['speedtest_failed']);
						total['close_1'] += Number(d['close_1']);
						total['close_0'] += Number(d['close_0']);
						bInc++;
					});
					
					htmlRowDate = '';
					htmlRowDate += '<td colspan="2">' + a + '</td>';
					htmlRowDate += '<td class="n">' + dateTotal['whitelist'] + '</td>';
					htmlRowDate += '<td class="n">' + dateTotal['blacklist'] + '</td>';
					htmlRowDate += '<td class="n"><a href="#" class="link-detail" data-detail-type="date" data-detail-tick="' + a + '" data-detail-field="who_success">' + dateTotal['who_success'] + '</a></td>';
					htmlRowDate += '<td class="n"><a href="#" class="link-detail" data-detail-type="date" data-detail-tick="' + a + '" data-detail-field="who_failed">' + dateTotal['who_failed'] + '</a></td>';
					htmlRowDate += '<td class="n"><a href="#" class="link-detail" data-detail-type="date" data-detail-tick="' + a + '" data-detail-field="token_1_success">' + dateTotal['token_1_success'] + '</a></td>';
					htmlRowDate += '<td class="n"><a href="#" class="link-detail" data-detail-type="date" data-detail-tick="' + a + '" data-detail-field="token_1_failed">' + dateTotal['token_1_failed'] + '</a></td>';
					htmlRowDate += '<td class="n"><a href="#" class="link-detail" data-detail-type="date" data-detail-tick="' + a + '" data-detail-field="nd_success">' + dateTotal['nd_success'] + '</a></td>';
					htmlRowDate += '<td class="n"><a href="#" class="link-detail" data-detail-type="date" data-detail-tick="' + a + '" data-detail-field="nd_failed">' + dateTotal['nd_failed'] + '</a></td>';
					htmlRowDate += '<td class="n"><a href="#" class="link-detail" data-detail-type="date" data-detail-tick="' + a + '" data-detail-field="redaman_success_spec">' + dateTotal['redaman_success_spec'] + '</a></td>';
					htmlRowDate += '<td class="n"><a href="#" class="link-detail" data-detail-type="date" data-detail-tick="' + a + '" data-detail-field="redaman_success_unspec">' + dateTotal['redaman_success_unspec'] + '</a></td>';
					htmlRowDate += '<td class="n"><a href="#" class="link-detail" data-detail-type="date" data-detail-tick="' + a + '" data-detail-field="redaman_failed">' + dateTotal['redaman_failed'] + '</a></td>';
					htmlRowDate += '<td class="n"><a href="#" class="link-detail" data-detail-type="date" data-detail-tick="' + a + '" data-detail-field="pcrf_success">' + dateTotal['pcrf_success'] + '</a></td>';
					htmlRowDate += '<td class="n"><a href="#" class="link-detail" data-detail-type="date" data-detail-tick="' + a + '" data-detail-field="pcrf_failed">' + dateTotal['pcrf_failed'] + '</a></td>';
					htmlRowDate += '<td class="n"><a href="#" class="link-detail" data-detail-type="date" data-detail-tick="' + a + '" data-detail-field="speedtest_success_passed_1">' + dateTotal['speedtest_success_passed_1'] + '</a></td>';
					htmlRowDate += '<td class="n"><a href="#" class="link-detail" data-detail-type="date" data-detail-tick="' + a + '" data-detail-field="speedtest_success_passed_0">' + dateTotal['speedtest_success_passed_0'] + '</a></td>';
					htmlRowDate += '<td class="n"><a href="#" class="link-detail" data-detail-type="date" data-detail-tick="' + a + '" data-detail-field="speedtest_failed">' + dateTotal['speedtest_failed'] + '</a></td>';
					htmlRowDate += '<td class="n"><a href="#" class="link-detail" data-detail-type="date" data-detail-tick="' + a + '" data-detail-field="close_1">' + dateTotal['close_1'] + '</a></td>';
					htmlRowDate += '<td class="n"><a href="#" class="link-detail" data-detail-type="date" data-detail-tick="' + a + '" data-detail-field="close_0">' + dateTotal['close_0'] + '</a></td>';
					htmlRowDate = '<tr>'+htmlRowDate+'</tr>';
					$('#list-overview-2 tbody').append(htmlRowDate);
					
				});
				$('.foot-whitelist').html(total['whitelist']);
				$('.foot-blacklist').html(total['blacklist']);
				$('.foot-who_success').html(total['who_success']);
				$('.foot-who_failed').html(total['who_failed']);
				$('.foot-token_1_success').html(total['token_1_success']);
				$('.foot-token_1_failed').html(total['token_1_failed']);
				$('.foot-nd_success').html(total['nd_success']);
				$('.foot-nd_failed').html(total['nd_failed']);
				$('.foot-redaman_success_spec').html(total['redaman_success_spec']);
				$('.foot-redaman_success_unspec').html(total['redaman_success_unspec']);
				$('.foot-redaman_failed').html(total['redaman_failed']);
				$('.foot-pcrf_success').html(total['pcrf_success']);
				$('.foot-pcrf_failed').html(total['pcrf_failed']);
				$('.foot-speedtest_success_passed_1').html(total['speedtest_success_passed_1']);
				$('.foot-speedtest_success_passed_0').html(total['speedtest_success_passed_0']);
				$('.foot-speedtest_failed').html(total['speedtest_failed']);
				$('.foot-close_1').html(total['close_1']);
				$('.foot-close_0').html(total['close_0']);
				rebindLinkDetail();
			}
			chart01.update();
			chart02.update();
			chart03.update();
		}
	});
}



function rebindLinkDetail() {
	$('.link-detail')
	.unbind('click')
	.click(function(e) {
		e.preventDefault();
		var detailField = $(this).attr('data-detail-field');
		var detailTick = $(this).attr('data-detail-tick');
		var detailType = $(this).attr('data-detail-type');
		$('#card-detail tbody').empty();
		$('#modal-overview-detail .modal-title').html($(this).attr('data-name-field'));
		$.ajax({
			method: 'post',
			dataType: 'json',
			url: site_url('Dashboard_old/jOverviewDetail'),
			data: {
				'detail-type': detailType,
				'detail-tick': detailTick,
				'detail-field': detailField
			},
			success: function(response) {
				if(typeof response['success'] != 'undefined' && response['success'] && typeof response['data'] != 'undefined' && typeof response['data']['detail'] != 'undefined') {
					i = 0;
					$.each(response['data']['detail'], function(a, b) {
						i++;
						$('#card-detail tbody').append(
							'<tr>' +
								'<td>' + i + '</td>' +
								'<td>' + b['uid'] + '</td>' +
								'<td>' + b['ts'] + '</td>' +
								'<td>' + b['ts_finish'] + '</td>' +
								'<td>' + b['remote_addr'] + '</td>' +
								'<td>' + b['bras'] + '</td>' +
								'<td>' + b['ip_addr'] + '</td>' +
								'<td>' + b['ticket'] + '</td>' +
								'<td>' + b['token1_log_total_time'] + ' ms' + '</td>' +
								'<td>' + b['ndbyip_log_total_time'] + ' ms' + '</td>' +
								'<td>' + b['nd'] + '</td>' +
								'<td>' + b['onu_rx_pwr'] + '</td>' +
								'<td>' + b['reg_type'] + '</td>' +
								'<td>' + b['version_id'] + '</td>' +
								'<td>' + b['identifier'] + '</td>' +
								'<td>' + b['redaman_log_total_time'] + ' ms' + '</td>' +
								'<td>' + b['redaman_passed'] + '</td>' +								
								'<td>' + b['token2_log_total_time'] + ' ms' + '</td>' +
								'<td>' + b['pcrf_log_total_time'] + ' ms' + '</td>' +	
								'<td>' + b['package_name'] + '</td>' +
								'<td>' + b['quota_used'] + '</td>' +
								'<td>' + b['speedtest_download'] + ' ' + b['speedtest_units'] + '</td>' +
								'<td>' + b['speedtest_upload'] + ' ' + b['speedtest_units'] + '</td>' +
								'<td>' + b['speedtest_latency_minimum'] + '</td>' +
								'<td>' + b['speedtest_latency_jitter'] + '</td>' +
								'<td>' + b['speed_passed'] + '</td>' +						
								'<td>' + b['close'] + '</td>' +
							'</tr>'
						);
					});
					$('#modal-overview-detail').modal('show');
				}
			}
		});
	});
	
}