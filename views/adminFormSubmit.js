console.log("loaded");
document.addEventListener('DOMContentLoaded', bindAjax);
function bindAjax() {

	var editButtonClickEvent = function(event){
		console.log("editButtonClickEvent");
		var id = event.target.previousSibling.value;
		event.preventDefault();
		window.location = "/edit/admin/"+id;
	}

	var deleteButtonClickEvent = function(event){

		var req = new XMLHttpRequest();
		var id = event.target.previousSibling.value;
		req.open('DELETE', '/delete_admin/'+id, true);
		event.preventDefault();
		var id = event.target.previousSibling.value;
		req.addEventListener('load',function(){
			if(req.status==200){
				var deleteIndex = event.target.parentNode.parentNode.parentNode.rowIndex;
				document.getElementById("adminUserTable").deleteRow(deleteIndex);
			}

		})
		req.send();
	}

	var editButtons = document.getElementsByClassName("editButtonClass");
	for(var i=0; i<editButtons.length; i++){
		var currentButton = editButtons[i];
		currentButton.addEventListener('click',editButtonClickEvent);

	}
	var deleteButtons = document.getElementsByClassName("deleteButtonClass");
	for(var i=0;i<deleteButtons.length;i++){
		var currentButton = deleteButtons[i];
		currentButton.addEventListener('click',deleteButtonClickEvent);
	}

}


