/****************************************************************************
 * UP Cookie Consent - v1.1.0
 * Copyright 2024 | UP Hotel Agency | https://uphotel.agency
 * 
 * This code provides functionality to the UP Cookie Consent plugin
 * 
/****************************************************************************/

// Define Variables
let upcc_options = document.querySelector('.js-upcc-view-upcc-cookie-options');
let upcc_options_revisit = document.querySelector('.js-upcc-view-upcc-cookie-options-revisit');
let upcc_options_accept_all = document.querySelector('.upcc-cookie-accept');
let upcc_options_reject_all = document.querySelectorAll('.upcc-cookie-reject-all');
let upcc_options_read_more = document.querySelector(".upcc-cookie-modal-view-more");
let upcc_options_selectable = document.querySelector('.upcc-cookie-accept.upcc-selectable');
let upcc_options_selected = document.querySelector('.upcc-selected-cookies');
let upcc_options_modal_close = document.querySelector('.upcc-cookie-modal-close');

// Widget & Manager
let upcc_cookie_widget = document.querySelector('.upcc-cookie-widget');
let upcc_cookie_manager =  document.querySelector('.upcc-cookie-modal-container');

// Map out consent categories based on Consent Mode V2
let upcc_consent_mode_map = [
	["ad_storage", "advertisement_targeting"],
	["ad_user_data", "advertisement_targeting"],
	["ad_personalization", "advertisement_targeting"],
	["analytics_storage", "performance_analytics"],
	["functionality_storage", "functional"],
	["personalization_storage", "functional"],
	["security_storage", "functional"]
]; 

// Handles Content Mode V2 & datalayer events
function upConsentMode(consent = [], stage = 'default'){
	let consentModeOptions = [];
	
	if(stage == "default"){

		// Set Consent Mode V2 (default)
		for(let i = 0; i < upcc_consent_mode_map.length; i++) {
			consentModeOptions[upcc_consent_mode_map[i][0]] = "denied";
		}

		// Update Content Mode V2
		gtag('consent', stage, consentModeOptions);

	}else{

		// Check which types are consented
		for(let i = 0; i < upcc_consent_mode_map.length; i++) {
			if(consent.includes(upcc_consent_mode_map[i][1])){
				consentModeOptions[upcc_consent_mode_map[i][0]] = "granted";
			}else{
				consentModeOptions[upcc_consent_mode_map[i][0]] = "denied";
			}
		}

		// Update Content Mode V2
		gtag('consent', stage, consentModeOptions);

		// Fire additional datalayer events
		if(consent.length){	
			window.dataLayer.push({'event': 'cookie_consent_update'});
			for(let i = 0; i < consent.length; i++) {
				window.dataLayer.push({'event': 'cookie_consent_'+consent[i]});
			}
		}
	}
}

// Define first load of document
let firstLoad = true; 

// Check if browser supports Popover API
function supportsPopover() {
	return HTMLElement.prototype.hasOwnProperty("popover");
}

// Add popover fallback class when not supported 
function upPopoverFallback(){
	if(!supportsPopover()){
		if(upcc_cookie_widget && upcc_cookie_manager){
			upcc_cookie_widget.classList.add("upcc-popover-fallback");
			upcc_cookie_manager.classList.add("upcc-popover-fallback");
		}
	}
}

// Popover API (function & fallback) - Open
function upShowPopover(target){
	if(target){
		if(supportsPopover()){
			target.showPopover();
		}else{
			target.classList.add("upcc-widget-open");
		}
	}
}

// Popover API (function & fallback) - Close
function upHidePopover(target){
	if(target){
		if(supportsPopover()){
			target.hidePopover();
		}else{
			target.classList.remove("upcc-widget-open");
		}
	}
}

// Testing mode function

function notInTestingMode(){
	const queryString = window.location.search;
	const urlParams = new URLSearchParams(queryString);
	if(urlParams.get('upcc-cookie-test')){
		return false;
	}else{
		return true;
	}
}

// Define dataLayer and the gtag function. (Google Consent Mode V2)
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}

String.prototype.stripSlashes = function(){
	return this.replace(/\\(.)/mg, "$1");
}

// Function to set cookies 
function setCookie(cname, cvalue, exdays) {
	const d = new Date();
	d.setTime(d.getTime() + (exdays*24*60*60*1000));
	let expires = "expires="+ d.toUTCString();
	// Secure attribute requires HTTPS
	let secure = (location.protocol === 'https:') ? 'Secure;SameSite=None' : '';
	document.cookie = `${cname}=${cvalue};${expires};path=/;${secure}`
}

// Function to remove cookies
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

// Add passed scripts to header after load
function addHeadScripts(script){
	// Add into DOM Header
	setTimeout(() => {
		var str = script.stripSlashes();
		
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
}

// Add passed scripts to body after load
function addBodyScripts(script){
	// Add into DOM Body
	setTimeout(() => {
		var str = script.stripSlashes();;
		
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
}


// Check cookies that don't required consent
function preCheckCookie(){
	var cookieScriptsHeader = Object.entries(frontend_up_cookie_consent.header);
	var cookieScriptsBody = Object.entries(frontend_up_cookie_consent.body);
	var gtm_connect = frontend_up_cookie_consent.gtm_connect;
	var readyToAddHeader_pre_consent = "";
	var readyToAddBody_pre_consent = "";

	// Google Tag Manager (Integrated Check)
	if(gtm_connect){
		readyToAddHeader_pre_consent += "<!-- Google Tag Manager --><script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','"+gtm_connect+"');</script><!-- End Google Tag Manager -->";
		readyToAddBody_pre_consent += '<!-- Google Tag Manager (noscript) --><noscript><iframe src="https://www.googletagmanager.com/ns.html?id='+gtm_connect+'"height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript><!-- End Google Tag Manager (noscript) -->';
	}


	// First check if any scripts are required to load before consent (HEADER)
	for(let i = 0; i < cookieScriptsHeader.length; i++) {
		if(cookieScriptsHeader[i][1].length){
			for(let e = 0; e < cookieScriptsHeader[i][1].length; e++) {
				if(cookieScriptsHeader[i][1][e][2] == "on"){
					readyToAddHeader_pre_consent += cookieScriptsHeader[i][1][e][1];
				}
			};
		}
	}

	// First check if any scripts are required to load before consent (FOOTER)
	for(let i = 0; i < cookieScriptsBody.length; i++) {
		if(cookieScriptsBody[i][1].length){
			for(let e = 0; e < cookieScriptsBody[i][1].length; e++) {
				if(cookieScriptsBody[i][1][e][2] == "on"){
					readyToAddBody_pre_consent += cookieScriptsBody[i][1][e][1];
				}
			};
		}
	}

	// Load these scripts first (they are required before consent)
	if(readyToAddHeader_pre_consent.length){
		addHeadScripts(readyToAddHeader_pre_consent);
	}
	if(readyToAddBody_pre_consent.length){
		addHeadScripts(readyToAddBody_pre_consent);
	}
}
if(notInTestingMode()){
	preCheckCookie();
}

// Check if cookies already accepted
function checkCookie() {

	// Get required data and set variables
	var cookieScriptsHeader = Object.entries(frontend_up_cookie_consent.header);
	var cookieScriptsBody = Object.entries(frontend_up_cookie_consent.body);
	var cookieScriptsAutoload = Object.entries(frontend_up_cookie_consent.autoload_script);
	var cookiesVersion = Object.entries(frontend_up_cookie_consent.version_number);
	var requireVersion = frontend_up_cookie_consent.require_version;
	var cookieStatus = getCookie("up-cookie-consent");

	// Cookie policy version checks
	if(cookiesVersion == "on"){
		if(getCookie("up-cookie-consent-version")){
			if(cookiesVersion[0][1]){
				if(cookiesVersion[0][1] > getCookie("up-cookie-consent-version")){
					if(requireVersion == "on"){
						cookieStatus = false;
					}
				}
			}
		}else{
			//Not yet set - require re-consent
			cookieStatus = false;
		}
	}

	if(firstLoad){
		// Set default consent to 'denied' as a placeholder
		upConsentMode([],'default');
	}

	if (cookieStatus == "true") {
		if(firstLoad == true){
			firstLoad = false;
		}else{
			location.reload(); // reload page now to remove any previously accepted cookies
		}

		var acceptedCookies = JSON.parse(getCookie("up-cookie-consent-options"));
		var readyToAddHeader_after_consent = "";
		var readyToAddBody_after_consent = "";
		for(let x = 0; x < acceptedCookies.length; x++) {
	
			// check if header
			for(let i = 0; i < cookieScriptsHeader.length; i++) {
				if( cookieScriptsHeader[i][0] == acceptedCookies[x] && cookieScriptsHeader[i][1].length){
					for(let e = 0; e < cookieScriptsHeader[i][1].length; e++) {
						if(cookieScriptsHeader[i][1][e][2] == false){
							readyToAddHeader_after_consent += cookieScriptsHeader[i][1][e][1];
						}
					};
				}
			}

			// check if body
			for(let i = 0; i < cookieScriptsBody.length; i++) {
				if( cookieScriptsBody[i][0] == acceptedCookies[x] && cookieScriptsBody[i][1].length){
					for(let e = 0; e < cookieScriptsBody[i][1].length; e++) {
						if(cookieScriptsBody[i][1][e][2] == false){
							readyToAddBody_after_consent += cookieScriptsBody[i][1][e][1];
						}
					};
				}
			}

			// check if autoload (used for updating a preloaded script that doesn't require consent)
			for(let i = 0; i < cookieScriptsAutoload.length; i++) {
				if( cookieScriptsAutoload[i][0] == acceptedCookies[x] && cookieScriptsAutoload[i][1].length){
					for(let e = 0; e < cookieScriptsAutoload[i][1].length; e++) {
						if(cookieScriptsAutoload[i][1][e][2] == "on"){
							readyToAddBody_after_consent += cookieScriptsAutoload[i][1][e][1];
						}
					};
				}
			}
		}

		upConsentMode(acceptedCookies, 'update');

		if(notInTestingMode()){
			addHeadScripts(readyToAddHeader_after_consent);
			addBodyScripts(readyToAddBody_after_consent);
		};
	} else {
		upShowPopover(upcc_cookie_widget);	
		setCookie("up-cookie-consent", false, 365);
		setCookie("up-cookie-consent-options", '[]', 365);
	}
}

// Set cookies on widget interaction
function setCookieConsent(accepted){
	// Grab which cookies have been accepted
	var cookiesVersion = Object.entries(frontend_up_cookie_consent.version_number);
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
	//Update policy version
	if(cookiesVersion[0][1]){
		setCookie("up-cookie-consent-version", cookiesVersion[0][1], 365);
	}else{
		setCookie("up-cookie-consent-version", 0, 365);
	}
	checkCookie();
}

// This section of JS provide functions for each widget control. 

// JS for accordian
const sections = document.querySelectorAll(".upcc-cookie-modal-accordian-section"); 
sections.forEach(section =>{
let btn = section.querySelector('.upcc-cookie-accordian-open-button');
let icon = window.getComputedStyle(btn, "::before");
	btn.addEventListener('click', ()=>{
		section.classList.toggle('upcc-modal-open');
	})
});

// JS for select all checkbox
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

// JS for Checkbox annotations
const checkbox = document.querySelectorAll(".upcc-cookie-modal input[type=checkbox]");
for(let i = 0; i < checkbox.length; i++) {
	checkbox[i].addEventListener('change', function(){
		if(checkbox[i].checked == true){
			checkbox[i].parentElement.classList.add("upcc-toggle-on");
		}else{
			checkbox[i].parentElement.classList.remove("upcc-toggle-on");
			document.getElementById('select-all').checked = false;
		}
	});
}

// JS for Readmore 
if(upcc_options_read_more !== null){
	upcc_options_read_more.onclick = function(e){
	e.preventDefault();
	let readMore = document.querySelector(".upcc-cookie-modal-details");
	readMore.classList.toggle("upcc-open");
		if(this.classList.contains("upcc-toggle-collapse")){
			this.classList.remove("upcc-toggle-collapse")
		} else {
			this.classList.add("upcc-toggle-collapse")
		}
	}
}

// Main Modal Close
if(upcc_options_modal_close !== null){
	upcc_options_modal_close.onclick = function(e){
		e.preventDefault();
		upHidePopover(upcc_cookie_manager);
		if(getCookie("up-cookie-consent") != "true"){
			upShowPopover(upcc_cookie_widget);
		}
	}
}

// Widget View Options
if(upcc_options !== null){
	upcc_options.onclick = function(e){
		e.preventDefault();
		upShowPopover(upcc_cookie_manager);
		upHidePopover(upcc_cookie_widget);
	}
}

// Revisit Content Options
if(upcc_options_revisit !== null){
	upcc_options_revisit.onclick = function(e){
		e.preventDefault();
		upShowPopover(upcc_cookie_manager);
	}
}

// Cookie Banner interaction (Accept All)
if(upcc_options_accept_all !== null){
	upcc_options_accept_all.onclick = function(e){
		e.preventDefault();
		upHidePopover(upcc_cookie_widget);
		setCookieConsent("all");
	}
}

// Cookie Banner interaction (Reject All)
if(upcc_options_reject_all !== null){
	upcc_options_reject_all.forEach(rejectButton =>{
		rejectButton.onclick = function(e){
			e.preventDefault();
			upHidePopover(upcc_cookie_manager);  
			upHidePopover(upcc_cookie_widget);
			setCookieConsent("none");
		}
	});
}

// Cookie Banner interaction (Accept Selectable)
if(upcc_options_selectable !== null){
	upcc_options_selectable.onclick = function(e){
		e.preventDefault();
		// Get currently selected 
		const selectedCookies = document.querySelectorAll(".upcc-selected-cookies");
		var accepted = [];
		accepted.push('strictly_necessary'); // this is always enabled 
		for(let i = 0; i < selectedCookies.length; i++) {
			if(selectedCookies[i].checked){
				accepted.push(selectedCookies[i].getAttribute("name"));
			}
		}
		upHidePopover(upcc_cookie_manager);
		setCookieConsent(accepted);
	}
}


// Call start cookie check
if(document.querySelector('.upcc-cookie-widget') !== null){
	upPopoverFallback();
	checkCookie();
}

