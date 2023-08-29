(function( $ ) {
	'use strict';

	$(function() {

	String.prototype.stripSlashes = function(){
		return this.replace(/\\(.)/mg, "$1");
	}

	function setCookie(cname, cvalue, exdays) {
		const d = new Date();
		d.setTime(d.getTime() + (exdays*24*60*60*1000));
		let expires = "expires="+ d.toUTCString();
		document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
	}

	function getCookie(cname) {
		let name = cname + "=";
		let decodedCookie = decodeURIComponent(document.cookie);
		let ca = decodedCookie.split(';');
		for(let i = 0; i <ca.length; i++) {
		  let c = ca[i];
		  while (c.charAt(0) == ' ') {
			c = c.substring(1);
		  }
		  if (c.indexOf(name) == 0) {
			return c.substring(name.length, c.length);
		  }
		}
		return "";
	
	}

	//First load of document 
	let firstLoad = true;

	//Check if cookies already accepted
	function checkCookie() {
		var cookieStatus = getCookie("up-cookie-consent");
		if (cookieStatus == "true") {
			if(firstLoad == true){
				firstLoad = false;
			}else{
				location.reload(); //reload page now to remove any previously accepted cookies
			}

			var acceptedCookies = JSON.parse(getCookie("up-cookie-consent-options"));
			var cookieScriptsHeader = frontend_up_cookie_consent.header;
			var cookieScriptsBody = frontend_up_cookie_consent.body;
			var readyToAddHeader = "";
			var readyToAddBody = "";

			for(let i = 0; i < acceptedCookies.length; i++) {
				//check if header
				var key = cookieScriptsHeader.findIndex(subArray => subArray[0] === acceptedCookies[i]);
				if(key != -1){
					readyToAddHeader += cookieScriptsHeader[key][1];
				}
				//check if body
				var key = cookieScriptsBody.findIndex(subArray => subArray[0] === acceptedCookies[i]);
				if(key != -1){
					readyToAddBody += cookieScriptsBody[key][1];
				}
			}

			readyToAddHeader = readyToAddHeader.stripSlashes();
			readyToAddBody= readyToAddBody.stripSlashes();

			//Add into DOM Header
			setTimeout(() => {
				const str = readyToAddHeader;
			  
				// Create an element outside the document to parse the string with
				const head = document.createElement("head");
			  
				// Parse the string
				head.innerHTML = str;
			  
				// Copy those nodes to the real `head`, duplicating script elements so
				// they get processed
				let node = head.firstChild;
				while (node) {
				  const next = node.nextSibling;
				  if (node.tagName === "SCRIPT") {
					// Just appending this element wouldn't run it, we have to make a fresh copy
					const newNode = document.createElement("script");
					if (node.src) {
					  newNode.src = node.src;
					}
					while (node.firstChild) {
					  // Note we have to clone these nodes
					  newNode.appendChild(node.firstChild.cloneNode(true));
					  node.removeChild(node.firstChild);
					}
					node = newNode;
				  }
				  document.head.appendChild(node);
				  node = next;
				}
			  }, 800);

			//Add into DOM Body
			setTimeout(() => {
				const str = readyToAddBody;
			  
				// Create an element outside the document to parse the string with
				const body = document.createElement("body");
			  
				// Parse the string
				body.innerHTML = str;
			  
				// Copy those nodes to the real `head`, duplicating script elements so
				// they get processed
				let nodeBody = body.firstChild;
				while (nodeBody) {
				  const next = nodeBody.nextSibling;
				  if (nodeBody.tagName === "SCRIPT") {
					// Just appending this element wouldn't run it, we have to make a fresh copy
					const newNode = document.createElement("script");
					if (nodeBody.src) {
					  newNode.src = nodeBody.src;
					}
					while (nodeBody.firstChild) {
					  // Note we have to clone these nodes
					  newNode.appendChild(nodeBody.firstChild.cloneNode(true));
					  nodeBody.removeChild(nodeBody.firstChild);
					}
					nodeBody = newNode;
				  }
				  document.body.insertBefore(nodeBody, document.body.firstChild);
				  nodeBody = next;
				}
			  }, 800);

			
		} else {
			showCookieBanner();
			setCookie("up-cookie-consent", false, 365);
		}
	}

	//Set cookies on widget interaction
	function setCookieConsent(accepted){
		//Grab which cookies have been accepted
		if(accepted == "all"){
			accepted = [
				'strictly_necessary', 'functional', 'performance_analytics', 'advertisement_targeting'
			];
		}
		if(accepted == "none"){
			accepted = ['strictly_necessary'];
		}
		setCookie("up-cookie-consent-options", JSON.stringify(accepted), 365);
		setCookie("up-cookie-consent", true, 365);
		checkCookie();
	}

	//Activate cookie banner display
	function showCookieBanner() {
		document.querySelector(".up-cookie-widget").classList.add("up-widget-open");
	}

	// JS for accordian
	const sections = document.querySelectorAll(".cookie-modal-accordian-section"); 

	sections.forEach(section =>{
	let btn = section.querySelector('.cookie-accordian-open-button');
	let icon = window.getComputedStyle(btn, "::before");
		btn.addEventListener('click', ()=>{
		section.classList.toggle('up-modal-open');
		})
	});

	//JS for select all checkbox
	if(document.getElementById('select-all') !== null){
		document.getElementById('select-all').onclick = function() {
			let checkboxes = document.querySelectorAll('input[type="checkbox"]');
			for (let checkbox of checkboxes) {
				checkbox.checked = this.checked;
				// Create a new event
				var event = new Event("change");
				// Dispatch the event
				checkbox.dispatchEvent(event);
			}
		}
	}

	//JS for Checkbox annotations
	const checkbox = document.querySelectorAll(".cookie-modal input[type=checkbox]");

	for(let i = 0; i < checkbox.length; i++) {
		checkbox[i].addEventListener('change', function(){
			if(checkbox[i].checked == true){
				checkbox[i].parentElement.classList.add("toggle-on");
			}else{
				checkbox[i].parentElement.classList.remove("toggle-on");
			}
		});
	}

	//Js for Readmore 
	if(document.querySelector(".cookie-modal-view-more") !== null){
		const readMore = document.querySelector(".cookie-modal-view-more");

		document.querySelector(".cookie-modal-view-more").onclick = function(e){
		e.preventDefault();
		let readMore = document.querySelector(".cookie-modal-details");
		readMore.classList.toggle("open");
			if(this.classList.contains("up-toggle-collapse")){
				this.classList.remove("up-toggle-collapse")
			} else {
				this.classList.add("up-toggle-collapse")
			}
		}
	}
	// Main Modal 
	if(document.querySelector('.up-cookie-modal-close') !== null){
		document.querySelector('.up-cookie-modal-close').onclick = function(e){
		e.preventDefault();
			this.closest(".up-cookie-modal-container").classList.remove("up-cookie-modal-open");
			var cookieStatus = getCookie("up-cookie-consent");
			if(cookieStatus != "true"){
				document.querySelector(".up-cookie-widget").classList.add("up-widget-open");
			}
		}
	}

	// Widget View Options
	if(document.querySelector('.js-up-view-cookie-options') !== null){
		document.querySelector('.js-up-view-cookie-options').onclick = function(e){
			e.preventDefault();
			document.querySelector(".up-cookie-modal-container").classList.add("up-cookie-modal-open");
			this.closest(".up-cookie-widget").classList.remove("up-widget-open");
		}
	}

	// Revisit Content Options
	if(document.querySelector('.js-up-view-cookie-options-revisit') !== null){
		document.querySelector('.js-up-view-cookie-options-revisit').onclick = function(e){
			e.preventDefault();
			document.querySelector(".up-cookie-modal-container").classList.add("up-cookie-modal-open");
		}
	}

	// Cookie Banner interaction (Accept All)
	if(document.querySelector('.up-cookie-accept') !== null){
		document.querySelector('.up-cookie-accept').onclick = function(e){
			e.preventDefault();
			this.closest(".up-cookie-widget").classList.remove("up-widget-open"); //Close widget 
			setCookieConsent("all");
		}
	}

	// Cookie Banner interaction (Reject All)
	if(document.querySelector('.up-cookie-reject-all') !== null){
		document.querySelector('.up-cookie-reject-all').onclick = function(e){
			e.preventDefault();
			this.closest(".up-cookie-modal-container").classList.remove("up-cookie-modal-open"); //Close widget 
			setCookieConsent("none");
		}
	}

	// Cookie Banner interaction (Accept Selectable)
	if(document.querySelector('.up-cookie-accept.up-selectable') !== null){
		document.querySelector('.up-cookie-accept.up-selectable').onclick = function(e){
			e.preventDefault();
			// Get currently selected 
			const selectedCookies = document.querySelectorAll(".up-selected-cookies");
			var accepted = [];
			accepted.push('strictly_necessary'); //this is always enabled 

			for(let i = 0; i < selectedCookies.length; i++) {
				if(selectedCookies[i].checked){
					accepted.push(selectedCookies[i].getAttribute("name"));
				}
			}
			this.closest(".up-cookie-modal-container").classList.remove("up-cookie-modal-open"); //Close widget 
			setCookieConsent(accepted);
		}
	}


	//Call start function
	if(document.querySelector('.up-cookie-widget') !== null){
	checkCookie();
	}

});

})( jQuery );
