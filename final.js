var myJSONobj;

function makeRequest() {
	if (window.XMLHttpRequest) { // Mozilla, Safari, ...
		httpRequest = new XMLHttpRequest();	
	} else if (window.ActiveXObject) { // IE
		try {
			httpRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} 
		catch (e) {
			try {
				httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} 
		catch (e) {}
		}
	}
	if (!httpRequest) {
		alert('Giving up :( Cannot create an XMLHTTP instance');
		return false;
	}
		var url1 = 'http://www.reddit.com/.json?'
		httpRequest.onreadystatechange = getContents;
		httpRequest.open('GET', url1);
		httpRequest.send();
}

function getContents() {
	if (this.readyState === 4) {
		if (this.status === 200) {
			myJSONobj = JSON.parse(this.responseText);
		} else {	
			alert('There was a problem with the AJAX request.');
		}		
	}
}

window.onload = function(){
	makeRequest();
}
