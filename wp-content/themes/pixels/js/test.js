$(document).ready(function(){
	
	console.log("ready");
	
	window.onscroll = function(){console.log("derp")};
	window.addEventListener('DOMMouseScroll', function(){console.log("derp")}, false)
});