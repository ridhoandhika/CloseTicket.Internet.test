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
		labels: ['complete', 'incomplete']
	},
	options: {
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
		labels: ['success', 'fail']
	},
	options: {
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
		labels: ['close', 'repen']
	},
	options: {
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

var config04 = {
	type: 'doughnut',
	data: {
		datasets: [
			{
				data: [0, 0],
				backgroundColor: [window.chartColors.blue, window.chartColors.red],
				label: 'Dataset 1'
			}
		],
		labels: ['redaman', 'speedtest']
	},
	options: {
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

var ctx04 = null;
var	chart04 = null;


$(function() {
	ctx01 = $('#chart-area-01')[0].getContext('2d');
	chart01 = new Chart(ctx01, config01);
	
	ctx02 = $('#chart-area-02')[0].getContext('2d');
	chart02 = new Chart(ctx02, config02);
	
	ctx03 = $('#chart-area-03')[0].getContext('2d');
	chart03 = new Chart(ctx03, config03);
	
	ctx04 = $('#chart-area-04')[0].getContext('2d');
	chart04 = new Chart(ctx04, config04);
	
	$('#filter-submit').click(function(e) {
		e.preventDefault();
		$('#selected-start').val($('#filter-start').val());
		$('#selected-finish').val($('#filter-finish').val());
		loadOverviewList();
	})
	.trigger('click');
	
	setInterval(function() {
		loadOverviewList();
	}, 60000);
});

function loadOverviewList() {	
	$('#list-overview tbody').empty();
	config01.data.datasets[0].data[0] = 0;
	config01.data.datasets[0].data[1] = 0;
	config02.data.datasets[0].data[0] = 0;
	config02.data.datasets[0].data[1] = 0
	config03.data.datasets[0].data[0] = 0;
	config03.data.datasets[0].data[1] = 0;
	config04.data.datasets[0].data[0] = 0;
	config04.data.datasets[0].data[1] = 0;
	$.ajax({
		method: 'post',
		dataType: 'json',
		url: site_url('Dashboard/jOverviewList'),
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
				&& typeof response['data']['chart']['04'] != 'undefined'
			) {
					
				config01.data.datasets[0].data[0] = response['data']['chart']['01']['complete'];
				config01.data.datasets[0].data[1] = response['data']['chart']['01']['incomplete'];
				config02.data.datasets[0].data[0] = response['data']['chart']['02']['success'];
				config02.data.datasets[0].data[1] = response['data']['chart']['02']['fail'];
				config03.data.datasets[0].data[0] = response['data']['chart']['03']['close'];
				config03.data.datasets[0].data[1] = response['data']['chart']['03']['reopen'];
				config04.data.datasets[0].data[0] = response['data']['chart']['04']['redaman'];
				config04.data.datasets[0].data[1] = response['data']['chart']['04']['speedtest'];
				$.each(response['data']['list'], function(a, b) {
					bInc = 0;
					$.each(b, function(c, d) {
						var htmlRow = '<tr>';
						if(bInc  == 0) {
							var splitDateLabel = a.split('-');
							htmlRow += '<td rowspan="24" class="rotate-date"><div class="rotate-out"><div class="rotate-in">' + splitDateLabel[0] + ' - ' + splitDateLabel[1] + ' - ' + splitDateLabel[2] + '</div></div></td>';
						}
						htmlRow += '<td>' + c + '</td>';
						htmlRow += '<td class="n"><a href="#" class="link-detail" data-detail-tick="' + d['tick'] + '" data-detail-field="success_close">' + d['success_close'] + '</a></td>';
						htmlRow += '<td class="n"><a href="#" class="link-detail" data-detail-tick="' + d['tick'] + '" data-detail-field="success_reopen">' + d['success_reopen'] + '</a></td>';
						htmlRow += '<td class="n"><a href="#" class="link-detail" data-detail-tick="' + d['tick'] + '" data-detail-field="fail_redaman">' + d['fail_redaman'] + '</a></td>';
						htmlRow += '<td class="n"><a href="#" class="link-detail" data-detail-tick="' + d['tick'] + '" data-detail-field="fail_speedtest">' + d['fail_speedtest'] + '</a></td>';
						htmlRow += '<td class="n"><a href="#" class="link-detail" data-detail-tick="' + d['tick'] + '" data-detail-field="incomplete">' + d['incomplete'] + '</a></td>';
						$('#list-overview tbody').append(htmlRow);
						bInc++;
					});
				});
				rebindLinkDetail();
			}
			chart01.update();
			chart02.update();
			chart03.update();
			chart04.update();
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
		$('#card-detail tbody').empty();
		$('#modal-overview-detail .modal-title').html($(this).attr('data-name-field'));
		$.ajax({
			method: 'post',
			dataType: 'json',
			url: site_url('Dashboard/jOverviewDetail'),
			data: {
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
								'<td>' + b['ts'] + '</td>' +
								'<td>' + b['remote_addr'] + '</td>' +
								'<td>' + b['ticket'] + '</td>' +
								'<td>' + b['session_id'] + '</td>' +
								'<td>' + b['decrypted_userid'] + '</td>' +
								'<td>' + b['onu_rx_pwr'] + '</td>' +
								'<td>' + b['redaman_passed'] + '</td>' +
								'<td>' + b['package_name'] + '</td>' +
								'<td>' + b['quota_used'] + '</td>' +
								'<td>' + b['speed_test'] + '</td>' +
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