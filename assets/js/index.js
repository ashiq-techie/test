jQuery(document).ready(function($) { 
	console.log(weblink);
	$('#check').click(function(event) {
		event.preventDefault();
		var formData = $('#detailsForm').serialize();
		$.ajax({
			url: weblink+'base/insert',
			type: 'POST',
			dataType: 'json',
			data: formData,
		})
		.done(function(data) {
			if (data.status == 'error') {
				$('#insertError').text(data.insert);
			} else {
				location.reload();
			};
			
		})
		.fail(function() {
			console.log("error");
		});
		
	});

	$(document).on('focusout', '.list input[type=text]', function(event) {
		event.preventDefault();
		var value = $(this).val();
		var name = $(this).attr('name');
		var refThis = $(this)
		/* Act on the event */
		$.ajax({
			url: 'base/update',
			type: 'POST',
			dataType: 'json',
			data: {
				name: name,
				value: value
			},
		})
		.done(function(data) {
			if (data.status == 'error') {
				refThis.val('');
				refThis.focus();
				refThis.closest('tr').find('span').text(data.update);
			}else{
				refThis.closest('tr').find('span').text('');
			};
			console.log("success");
		})
		.fail(function() {
			console.log("error");
		});
		
	});

	$(document).on('click', 'input[type=checkbox]', function(event) {
		event.preventDefault();
		if (confirm('Are you sure?')) {
			$.ajax({
				url: 'base/delete',
				type: 'POST',
				dataType: 'json',
				data: {emp_id: $(this).val()},
			})
			.done(function() {
				location.reload(true);
			})
			.fail(function() {
				console.log("error");
			});
			
		};
	});
});