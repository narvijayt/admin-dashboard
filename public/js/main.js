jQuery(document).ready(function ($) {
	$('.table').DataTable();

	$(document).on("click", ".duplicate-survey", function(){
		swal({
			title: "Are you sure?",
			text: "This will create new survey same as of the selected Survey. Confirm to proceed!",
			icon: "warning",
			buttons: true,
			dangerMode: true,
		}).then((confirmed) => {
			if (confirmed) {
				window.location = $(this).data("href");
			}else{
				// nothing to do
			}
		});
	});
});
