
	 $("select").selectBoxIt({
	 	autoWidth : false
	 });


	$('.confirm').click(function () {
		
		return confirm('Are You Sure?');

	});

// Get the modal
var modalEdt = document.getElementById("EditModel");

// Get the button that opens the modal
var btnEdt = document.getElementById("EditBtn");

// Get the <span> element that closes the modal
var spanEdt = document.getElementById("ClEd");

// When the user clicks on the button, open the modal
btnEdt.onclick = function() {
  modalEdt.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
spanEdt.onclick = function() {
  modalEdt.style.display = "none";
}





// Get the modal
var modalPof = document.getElementById("ProfileModel");

// Get the button that opens the modal
var btnProf = document.getElementById("profileBtn");

// Get the <span> element that closes the modal
var spanProf = document.getElementById("ClProf");

// When the user clicks on the button, open the modal
btnProf.onclick = function() {
  modalPof.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
spanProf.onclick = function() {
  modalPof.style.display = "none";
}

