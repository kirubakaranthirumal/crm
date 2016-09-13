function fn_get_form_values(fobj,valFunc){

	var str = "";
	var valueArr = null;
	var val = "";
	var cmd = "";

	for(var i = 0;i < fobj.elements.length;i++)
	{
		switch(fobj.elements[i].type)
		{
			case "text":
				if(valFunc)
				{
					//use single quotes for argument so that the value of
					//fobj.elements[i].value is treated as a string not a literal
					cmd = valFunc + "(" +'fobj.elements[i].value' + ")";
					val = eval(cmd)
				}

				str += fobj.elements[i].name +"=" + escape(fobj.elements[i].value) + "&";

				break;

			case "password":
				if(valFunc)
				{
					//use single quotes for argument so that the value of
					//fobj.elements[i].value is treated as a string not a literal
					cmd = valFunc + "(" +'fobj.elements[i].value' + ")";
					val = eval(cmd)
				}

				str += fobj.elements[i].name +"=" + escape(fobj.elements[i].value) + "&";

				break;

			case "hidden":
				str += fobj.elements[i].name +"=" + escape(fobj.elements[i].value) + "&";
				break;


			case "select-one":

				str += fobj.elements[i].name +"=" +fobj.elements[i].options[fobj.elements[i].selectedIndex].value+ "&";
				break;

			case "radio":
				if(fobj.elements[i].checked){
					str += fobj.elements[i].name +"=" +fobj.elements[i].value+ "&";
				}
				break;

			case "checkbox":
				if(fobj.elements[i].checked){
					str += fobj.elements[i].name +"=" +fobj.elements[i].value+ "&";
				}
				break;

			case "textarea":
				str += fobj.elements[i].name +"=" +escape(fobj.elements[i].value)+ "&";
				break;

		}


	}

	str = str.substr(0,(str.length - 1));
	return str;
}


jQuery(document).ready(function(){						   		   
	//Close Popups and Fade Layer
	jQuery('a.close, #fade').live('click', function() { //When clicking on the close or fade layer...
	  	jQuery('#fade , .shipadd_popup').fadeOut(function() {
			jQuery('#fade, a.close').remove();  
	}); //fade them both out		
		//return false;
	});
	
	


	
});


//new load pop up
function load_pop_up(id,wd,topmargin,msg,auto_fade){
	
	var popID = id; //Get Popup Name
	var popWidth = 1000; //Gets the first query string value
	var top_m= topmargin;
	var html= msg;	
	var close=auto_fade;	
	if(html)
	jQuery('#' + popID).html(html);		
	jQuery('#' + popID).fadeIn().css({ 'width': 600}).prepend('<a href="#" class="close"><img src="images/closebox.png" class="btn_close" title="Click to Close Window" alt="Close" /></a>');
       	// $('#shippaddcont').fadeTo("slow",0.8);  
	 

	 var popMargTop = (Number(top_m) + 80) / 2;		
	var popMargLeft = (jQuery('#' + popID).width() + 80) / 2;

	
	jQuery('#' + popID).css({ 
		'margin-top' : -popMargTop,
		'margin-left' : -popMargLeft
	}); 
	
	

	//Fade in Background
	jQuery('body').append('<div id="fade"></div>'); //Add the fade layer to bottom of the body tag.


	jQuery('#fade').css({'filter' : 'alpha(opacity=0.8)'}).fadeIn(); //Fade in the fade layer 

}
