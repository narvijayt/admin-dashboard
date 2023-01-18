jQuery(document).ready(function ($) {
	$('.table').DataTable();

	$(document).on("click", ".duplicate-survey", function(){
		showConfirmModal("Are you sure?", "This action will create new survey same as of the selected Survey. Confirm to proceed!", $(this));
	});
	
	$(document).on("click", ".delete-survey", function(){
		showConfirmModal("Are you sure?", "This action will remove this Survey completely. Will you like to proceed?", $(this));
	});
	
	/*$(document).on("click", ".publish-survey", function(){
		showConfirmModal("Are You Sure?", "Do you really want to publish this Survey?", $(this));
	});*/
});

function showConfirmModal($title, $text, element){
	swal({
		title: $title,
		text: $text,
		icon: "warning",
		buttons: true,
		dangerMode: true,
	}).then((confirmed) => {
		if (confirmed) {
			window.location = element.data("href");
		}else{
			// nothing to do
		}
	});
}
