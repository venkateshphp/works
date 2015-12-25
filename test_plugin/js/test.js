$.noConflict();
jQuery( document ).ready(function( $ ) {
								/*  alert('check');*/
$("#btn1").click(function() {
 var ext = $('#favicon_img').val().split('.').pop().toLowerCase();
if($.inArray(ext, ['jpg']) == -1) {
    alert('invalid extension!');
	return false;
}else {
    alert('success!');
	
	//	 var a=$('input[type=file]').val();
//		 alert(a);
//		 var type=0;
//		 var user_id=0;
//		var param = 'type=' + type + '&user_id=' + user_id;
// 
//$.ajax({
//  url: '../ajax/ajax.php',
//  data: param, 
//  success: function(result) {
//      alert('SUCCESS');
//	 
//  }
//});



/*var formData = new FormData();
formData.append('file', $('input[type=file]')[0].files[0]);
<!-- var formData = new FormData($("#fav_icon_form"));-->
     $.ajax({
        type: 'POST',
       url: '../ajax/ajax.php',
        data: formData,
         success: function (data) {
           alert(data)
         },
      });
*/










	return true;

}
});

$( "#social_btn" ).click(function() {
  $( ".social_tab" ).show();
  $( ".favicon_tab" ).hide();
   $( ".custom_css_tab" ).hide();
   
});

$( "#favicon_btn" ).click(function() {
  $( ".favicon_tab" ).show();
   $( ".social_tab" ).hide();
   $( ".custom_css_tab" ).hide();
  
});

$( "#custom_css_btn" ).click(function() {
  $( ".custom_css_tab" ).show();
   $( ".social_tab" ).hide();
    $( ".favicon_tab" ).hide();
  
});








 	
});





function showMyImage(fileInput) {
document.getElementById("thumbnil").style.display = 'block';
		/// alert('cheks');
        var files = fileInput.files;
        for (var i = 0; i < files.length; i++) {           
            var file = files[i];
            var imageType = /image.*/;     
            if (!file.type.match(imageType)) {
                continue;
            }           
            var img=document.getElementById("thumbnil");            
            img.file = file;    
            var reader = new FileReader();
            reader.onload = (function(aImg) { 
                return function(e) { 
                    aImg.src = e.target.result; 
                }; 
            })(img);
            reader.readAsDataURL(file);
        }    
    }
	
	function showMyImageNew(fileInput,idvalue) {
	
	 var item = idvalue;
var lastItem = item.split("-").pop(-1);
		 alert(lastItem);
		 
		 $( "#thumbnail-"+lastItem ).show();
		
	
		/// alert('cheks');
        var files = fileInput.files;
        for (var i = 0; i < files.length; i++) {           
            var file = files[i];
            var imageType = /image.*/;     
            if (!file.type.match(imageType)) {
                continue;
            }      
            var img=document.getElementById("thumbnail-"+lastItem);            

         //   var img=document.getElementById("thumbnil");            
            img.file = file;    
            var reader = new FileReader();
            reader.onload = (function(aImg) { 
                return function(e) { 
                    aImg.src = e.target.result; 
                }; 
            })(img);
            reader.readAsDataURL(file);
        }    
    }
	