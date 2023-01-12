var studiekort;

function displayFlash(resp) {
	$('.error-div').html(resp).slideDown(500).delay(1400).slideUp(500);
}

$('form[name="studiekort-login-form"]').on('submit', function() {
	studiekort = $('#studiekort');
	if(studiekort.val() == '' || true) return false;
	var resp = $.ajax({
		url: '/',
		method: 'POST',
		data: {
			studiekort: studiekort.val()
		}
	}).done(function(resp) {
		if(resp.indexOf('Instruktør') != -1) {
			window.location = "/admin/dashboard.php";
		} else {
			displayFlash(resp);
			studiekort.val('');
		}
	}).fail(function(data) {
		console.log('Ohh no :( Something happened.');
		if(data) displayFlash(data);
		console.log(data);
	});
});