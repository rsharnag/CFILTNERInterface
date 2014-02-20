function GetSelectedText(){ // FOR COPYING THE SELECTION IN TEXTAREA TO DICITONARY BELOW
				var userSelection, ta;
  				if (window.getSelection && document.activeElement){
    				if (document.activeElement.nodeName == "TEXTAREA" ||
        				(document.activeElement.nodeName == "INPUT" && 
        				document.activeElement.getAttribute("type").toLowerCase() == "text")){
      					
						ta = document.activeElement;
      					userSelection = ta.value.substring(ta.selectionStart, ta.selectionEnd);
    				} else {
      						userSelection = window.getSelection();
					}
					if(userSelection.toString().trim()==""){
						bootbox.alert("Please Select a Word first!");
					}
					else{
						document.form1.transWord.value = userSelection.toString().trim();
					}
  				} else {
    				// all browsers, except IE before version 9
    				if (document.getSelection){       
        				userSelection = document.getSelection();
        				if(userSelection.toString().trim()==""){
							bootbox.alert("Please Select a Word first!");
						}
						else{
							document.form1.transWord.value = userSelection.toString().trim();
						}
    				}
    				// IE below version 9
    				else if (document.selection){
    					userSelection = document.selection.createRange();
    					if(userSelection.toString().trim()==""){
							bootbox.alert("Please Select a Word first!");
						}
						else{
							document.form1.transWord.value = userSelection.text;
						}
    				}
  				}
			}
			
			
//<!--SCRIPT TO SHOW TRANSLATION RESULTS-->

function showtransresults(){
			var xmlhttp;
			if (window.XMLHttpRequest){
  				xmlhttp=new XMLHttpRequest(); // code for IE7+, Firefox, Chrome, Opera, Safari
  			}
			else{
  				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); // code for IE6, IE5
  			}

			xmlhttp.onreadystatechange=function(){
  				if (xmlhttp.readyState==4 && xmlhttp.status==200){
    				document.getElementById("transresults").innerHTML=xmlhttp.responseText;
    			}
  			}
			xmlhttp.open("GET","translate.php?transWord="+ document.forms["form1"]["transWord"].value +"&submit=Search&start=0" ,true);
			xmlhttp.send();	
			if(!$("#transresults").is(':visible')){
				$('#transresults').toggle('show');
			}
		}

function GetWordnetWord(){ // TO GET WORD TO BE SEARCHED IN HINDI WORDNET
				var userSelection, ta;
  				if (window.getSelection && document.activeElement){
    				if (document.activeElement.nodeName == "TEXTAREA" ||
        				(document.activeElement.nodeName == "INPUT" && 
        				document.activeElement.getAttribute("type").toLowerCase() == "text")){
      					
						ta = document.activeElement;
      					userSelection = ta.value.substring(ta.selectionStart, ta.selectionEnd);
    				} else {
      						userSelection = window.getSelection();
					}
					if(userSelection.toString().trim()==""){
						bootbox.alert("Please Select a Word first!");
					}
					else{
						wordnetWord = userSelection.toString().trim();
					}
  				} else {
    				// all browsers, except IE before version 9
    				if (document.getSelection){       
        				userSelection = document.getSelection();
        				if(userSelection.toString().trim()==""){
							bootbox.alert("Please Select a Word first!");
						}
						else{
							wordnetWord = userSelection.toString().trim();
						}
    				}
    				// IE below version 9
    				else if (document.selection){
    					userSelection = document.selection.createRange();
    					if(userSelection.text==""){
							bootbox.alert("Please Select a Word first!");
						}
						else{
							wordnetWord = userSelection.text;
						}
    				}
  				}
			}
			function HWordnetSearch(){ // SEARCH IN HINDI WORDNET
				window.open('http://www.cfilt.iitb.ac.in/wordnet/webhwn/wn.php?nomorph=true&hwd='+wordnetWord,'_blank');
			}
			function EWordnetSearch(){ // SEARCH IN ENGLISH WORDNET
				window.open('http://wordnetweb.princeton.edu/perl/webwn?s='+wordnetWord,'_blank');
			}
			function shabdkoshSearch(){ // SEARCH IN SHABDKOSH
				window.open('http://www.shabdkosh.com/hi/translate?e='+wordnetWord+'+&l=hi','_blank');
			}
			function MWordnetSearch(){ // SEARCH IN MARATHI WORDNET
				window.open('http://www.cfilt.iitb.ac.in/wordnet/webmwn/wn.php?hwd='+wordnetWord,'_blank');
			}
			function GoogleSearch(){ // SEARCH ON GOOGLE
				var googleuri = 'http://www.google.co.in/search?q='+wordnetWord;
				var googleurl = encodeURI(googleuri);
				window.open(googleurl,'_blank');
			}
			function GoogleTranslateSearchENHI(){ // SEARCH ON GOOGLE ENGLISH TO HINDI
				var googletransuri = 'http://translate.google.co.in/#en/hi/'+wordnetWord;
				var googletransurl = encodeURI(googletransuri);
				window.open(googletransurl,'_blank');
			}
			function GoogleTranslateSearchAUTOEN(){ // SEARCH ON GOOGLE AUTOMATIC LANGUAGE DETECT TO ENGLISH
				var googletransuri = 'http://translate.google.co.in/#auto/en/'+wordnetWord;
				var googletransurl = encodeURI(googletransuri);
				window.open(googletransurl,'_blank');
			}
			function WikipediaSearch(){ // SEARCH ON GOOGLE
				
				var wikiuri = 'http://en.wikipedia.org/wiki/'+wordnetWord;
				var wikiurl = encodeURI(wikiuri);
				window.open(wikiurl,'_blank');
			}
			function WikitionarySearch(){ // SEARCH ON GOOGLE
				var wikitionaryuri = 'http://en.wiktionary.org/wiki/'+wordnetWord;
				var wikitionaryurl = encodeURI(wikitionaryuri);
				window.open(wikitionaryurl,'_blank');
			}

$(document).ready(function() {
            $("#ssentence").ContextMenu("context-menu-1");
            $("#tsentence").ContextMenu("context-menu-2");
         });
$(document).ready(function(){
			$(document).on('click',"#hideshow", function(event) {        
				$('#transresults').toggle('show');
			});
		});
function openwindow (url) {
   var win = window.open(url, "window1", "width=800,height=400,status=yes,scrollbars=yes,resizable=yes");
   win.focus();
}

$(document).ready(function(){
			$(document).on('click', '#gotoSentence', function(event) {      
				bootbox.prompt("Please enter sentence number: ", function(result) {
				if (result === null || result === '') {//do nothing					
				} else {
					window.location = '?offset=' + result;
				}
			});
		});
	});
$(document).ready(function(){
			$(document).on('click', '#gotoWord', function(event) {      
				bootbox.prompt("Please enter phrase or word: ", function(result) {
				if (result === null || result === '') {//do nothing					
				} else {
					window.location = '?word=' + result;
				}
			});
		});
	});	
$(document).ready(function(){
			$(document).on('click', '#Next', function(event) {     
				event.preventDefault();   
				var nextval = $("#nextval").val();
				window.location = '?offset=' + nextval;
			});
		});
$(document).ready(function(){
			$(document).on('click', '#Next2', function(event) {        
				event.preventDefault();
				var nextval = $("#nextval").val();
				window.location = '?offset=' + nextval;
			});
		});
$(document).ready(function(){
			$(document).on('click', '#Prev', function(event) {        
				event.preventDefault();
				var prevval = $("#prevval").val();
				window.location = '?offset=' + prevval;
			});
		});				
$(document).ready(function(){
			$(document).on('click', '#Prev2', function(event) {        
				event.preventDefault();
				var prevval = $("#prevval").val();
				window.location = '?offset=' + prevval;
			});
		});		
$(document).ready(function(){
			$(document).on('click', '#first', function(event) {        
				event.preventDefault();
				window.location = '?offset=1';
			});
		});	
$(document).ready(function(){
			$(document).on('click',"#skippedFirst", function(event) {        
				event.preventDefault();
				window.location = '?offset=0';
			});
		});
$(document).ready(function(){
			$(document).on('click', '#lastSentence',function(event) {        
				event.preventDefault();
				var sentencecount = $("#sentencecount").val();
				window.location = '?offset=' + sentencecount;
			});
		});				
$(document).ready(function(){
			$(document).on('click', '#skippedPrev', function(event) {        
				event.preventDefault();
				var prevval = $("#prevval").val();
				window.location = '?offset=' + prevval;
			});
		});		
$(document).ready(function(){
			$(document).on('click', '#skippedPrev2', function(event) {        
				event.preventDefault();
				var prevval = $("#prevval").val();
				window.location = '?offset=' + prevval;
			});
		});			
$(document).ready(function(){
			$(document).on('click', '#skippedNext', function(event) {        
				event.preventDefault();
				var skipnextval = $("#skipnextval").val();
				window.location = '?offset=' + skipnextval;
			});
		});
$(document).ready(function(){
			$(document).on('click', '#skippedNext2', function(event) {        
				event.preventDefault();
				var skipnextval = $("#skipnextval").val();
				window.location = '?offset=' + skipnextval;
			});
		});			
$(document).ready(function(){
            $(document).on('click','#TagSent',function(event){
                event.preventDefault();
                var sent = $("#ssentence").val();
                //Implement a ajax call to the desired service
                $("#tsentence").text(sent);
            });
});
		/*$(document).ready(function(){ //THIS JQUERY FUNCTION WAS PREVIOUSLY BEING USED FOR SUBMIT CLICK IN DICTIONARY, 
			jQuery('#submit').live('click', function(event) { // TO TOGGLE THE VISIBILITY OF transresults DIV IN CASE ITS HIDDEN.
				if(!$("#transresults").is(':visible')){ // BUT NOW THE FUNCTION showtransresults CHECK THIS IN ITSELF, DO NOT DELETE, FOR REFERENCE
					jQuery('#transresults').toggle('show');
				}
			});
		});*/
