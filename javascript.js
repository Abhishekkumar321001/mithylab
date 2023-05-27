canvas 			 = document.getElementById("mycanvas");
context	    	 = canvas.getContext("2d");
with(context) {

	font		 = "italic 200px Times";
	textBaseline = "top"; 

	gradient	 = createLinearGradient(165, 0, 1220, 0);
	gradient.addColorStop(0.00, "red");
	gradient.addColorStop(0.25, "orange");
	gradient.addColorStop(0.50, "green");
	gradient.addColorStop(0.75, "blue");

	fillStyle	 = gradient;
	fillText("Honey Comb", 165, 22);
	strokeText("Honey Comb", 165, 22);

}