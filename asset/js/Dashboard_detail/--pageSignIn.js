$(function() {
	$('#signin-submit').click(function(e) {
		e.preventDefault();
		console.log('asd');
		$.ajax({
			method: 'post',
			dataType: 'json',
			url: site_url('Dashboard/jsonSignIn'),
			data: {
				username: $('#signin-username').val(),
				password: $('#signin-password').val()
			},
			success: function(response) {
				if(response.success) {
					window.location.href = site_url('Dashboard');
				}
				else {
					$('#signin-username').val('');
					$('#signin-password').val('');
					alert(JSON.stringify(response.error));
				}
			}
		});
	});
});