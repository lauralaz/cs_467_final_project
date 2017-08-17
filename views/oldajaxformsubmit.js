console.log("loaded");
document.addEventListener('DOMContentLoaded', bindAjax);
function bindAjax() {

	var editButtonClickEvent = function(event){
		console.log("editButtonClickEvent");
		var id = event.target.previousSibling.value;
		event.preventDefault();
		window.location = "/edit/"+id;

	}

	var deleteButtonClickEvent = function(event){

		var req = new XMLHttpRequest();
		var id = event.target.previousSibling.value;
		req.open('DELETE', '/delete/'+id, true);
		event.preventDefault();
		var id = event.target.previousSibling.value;
		req.addEventListener('load',function(){
			if(req.status==200){
				var deleteIndex = event.target.parentNode.parentNode.parentNode.rowIndex;
				document.getElementById("exerciseTable").deleteRow(deleteIndex);
			}

		})
		req.send();
		


	}
	document.getElementById('postFormSubmit').addEventListener('click', function(event){
		var req = new XMLHttpRequest();
		console.log(document.getElementById("exerciseForm"));
		var exerciseName = document.getElementById('exerciseName').value;
		var numberOfReps = document.getElementById('numberOfReps').value;
		var weight = document.getElementById('weight').value;
		var date = document.getElementById('date').value;
		var lbs = document.getElementById('lbs').checked;
		req.open('POST', '/insert', true);
		req.addEventListener('load',function (){

			if(req.status!=200){
				return;
			}
			//document.getElementById('postFormResults').textContent = req.response;
			var table = document.getElementById("exerciseTable");
			var row = table.insertRow(-1);
			var exerciseNameCell =  row.insertCell(0);
			var repsCell = row.insertCell(1);
			var weightCell = row.insertCell(2);
			var dateCell = row.insertCell(3);
			var lbsCell = row.insertCell(4);
			var editCell = row.insertCell(5);
			var deleteCell = row.insertCell(6);


			exerciseNameCell.innerHTML = exerciseName;
			repsCell.innerHTML = numberOfReps;
			weightCell.innerHTML = weight;
			dateCell.innerHTML = date;
			lbsCell.innerHTML = lbs ? "Lbs":"Kgs";

			var editButtonForm = document.createElement("form");
			var editFormInput = document.createElement("input");
			editFormInput.value = JSON.parse(req.response).id;
			editFormInput.type="hidden";
			editButtonForm.appendChild(editFormInput);

			var editButton = document.createElement("button");
			editButton.className = "editButtonClass";
			editButton.innerHTML = "Edit Row";
			editCell.appendChild(editButtonForm);
			editButtonForm.appendChild(editButton);
			editButton.addEventListener('click',editButtonClickEvent);

			var deleteButtonForm = document.createElement("form");
			var deleteFormInput = document.createElement("input");
			deleteFormInput.value = JSON.parse(req.response).id;
			deleteFormInput.type = "hidden";
			deleteButtonForm.appendChild(deleteFormInput);

			var deleteButton = document.createElement("button");
			deleteButton.className = "deleteButtonClass";
			deleteButton.innerHTML = "Delete Row";
			deleteCell.appendChild(deleteButtonForm);
			deleteButtonForm.appendChild(deleteButton);
			deleteButton.addEventListener('click',deleteButtonClickEvent);


			console.log(exerciseName);
			console.log(req.response);
		});
		req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		req.send("exerciseName="+exerciseName+"&numberOfReps="+numberOfReps+"&weight="+weight+"&date="+date+"&lbs="+lbs);
		event.preventDefault();
	});

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


