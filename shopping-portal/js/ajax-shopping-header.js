var j = jQuery.noConflict();
var k = jQuery.noConflict();
j(document).ready(function() {
		var site_home_url = home_url_object.home_url; // alerts 'Some string to translate'
		var ajax_file_url_value = ajax_file_url_object.ajax_file_url; // alerts 'Some string to translate'

		// for country selectiom start
		k("select#country").change(function(){
			var id1 = k(this).val();
			//alert(k(this).val());
			if(id1 == ''){
			k("#state").attr('disabled', 'disabled');
			}else{
			k("#state").removeAttr("disabled");
			}
			k.getJSON(ajax_file_url_value+"/shopping-select.php",{id: k(this).val()}, function(j){
			
				var options = '';
				for (var i = 0; i < j.length; i++) {
					options += '<option value="' + j[i].optionValue + '">' + j[i].optionDisplay + '</option>';
				}
				k("#state").html(options);
				k('#state option:first').attr('selected', 'selected');
			})
		})		
	
		   
	   //Password section empty while loading from cookies or browser cache //1,000 milliseconds = 1 second
	   setTimeout(	function() { j(':password').val(''); },	1000 );
		
		// Registration hide
		j( "#Paypal" ).click(function() {
			j( ".show_details" ).fadeIn( "slow" );
			j( ".show_details1" ).fadeOut( "slow" );
		});
		
		
		j( "#Check" ).click(function() {
			j( ".show_details1" ).fadeIn( "slow" );
			j( ".show_details" ).fadeOut( "slow" );
		});
		// update hide
		j( "#Paypal" ).click(function() {
			j( ".update_hide_paypal" ).fadeIn( "slow" );
			j( ".update_hide_check" ).fadeOut( "slow" );
		});
		
		
		j( "#Check" ).click(function() {
			j( ".update_hide_check" ).fadeIn( "slow" );
			j( ".update_hide_paypal" ).fadeOut( "slow" );
		});

		j(".accordion").on("click", function () {
			j(this).find(".accrod_arrow").toggleClass("rotate");
		});

		//add to favourite store section
		j( ".favourite_check" ).change(function() {
		//alert('hai');
		var favourite_check_post = this.id;
		//alert(favourite_check_post);
		j.post(ajax_file_url_value+"/shopping-ajax.php", { 
		a_favourite_check_post: favourite_check_post, 
   		action: 'add_favourite_company_user_store'},function(data) { 
		//alert(data);
		var trimmed_value = j.trim(data);
			if(trimmed_value == 'success'){
			j('.'+favourite_check_post+'_notification').html("Added To your Favourites");
			j('.'+favourite_check_post+'_notification').fadeOut(5000);
			//location.reload();
			setTimeout(function (){	location.reload(); }, 1000); 
			} else {
			j('.'+favourite_check_post+'_notification').html("Removed From your Favourites");
			j('.'+favourite_check_post+'_notification').fadeOut(5000);
			setTimeout(function (){	location.reload(); }, 1000);
			}
  		 });
		
	});
	
		//ONCLICK SELECT CHANGE
		j("#payment_head").change(function(){
			j( "#payment_head option:selected").each(function(){
				if(j(this).attr("value")=="Paypal"){
					j("#check_show").hide();
					j("#paypal_show").fadeIn();
				}
				if(j(this).attr("value")=="Check"){
					j("#paypal_show").hide();
					j("#check_show").fadeIn();
				}
			});
		}).change();
		
		//update User Data
		 j( "#edit_button" ).click(function() {
			if(	j("#edit_data").valid()){
			var f_fname_update = j('#fname_update').val();
			var f_lname_update = j('#lname_update').val();
			var f_address_update = j('#address_update').val();
			var f_apartment_update = j('#apartment_update').val();
			var f_city_update = j('#city_update').val();
			
			var f_country_update = j('#country').val();
			
			var f_state_update = j('#state').val();
			var f_zip_update = j('#zip_update').val();
			
			var f_email_conf_update = j('#email_conf_update').val();
			
			var f_paypal_id_update = j('#paypal_id_update').val();
			var f_repeat_password_update = j('#repeat_password_update').val();
			var f_paypal_check_select = j("#payment_head").val();
			//alert(f_paypal_check_select);
			j.post(ajax_file_url_value+"/shopping-ajax.php", { 
			a_fname_updatee: f_fname_update,
			a_lname_update: f_lname_update, 
			a_address_update: f_address_update,
			a_apartment_update: f_apartment_update,
			a_city_update: f_city_update,
			a_country_update: f_country_update,
			a_state_update: f_state_update,
			a_zip_update: f_zip_update,
			
			a_email_conf_update: f_email_conf_update,
			a_paypal_check_select_update: f_paypal_check_select,
			a_repeat_password_update: f_repeat_password_update,
			a_paypal_id_update: f_paypal_id_update, 
			action: 'user_update_post_values'},function(data) { 
			var trimmed_value = j.trim(data);
			if(trimmed_value !='success'){
			alert(data);
			j(".notification").html("Error Updating User Details");
			} else {
				j(".notification").html("Updated Successfully");
				j(".notification").fadeOut(5000);
				 // Delaying one function for some time
				setTimeout(function (){	window.location.href = site_home_url+'/member-information/';}, 1000); 
				}
		   });
		 }
			});	

	//login
	
	 j( "#login_button" ).click(function() {
										 
		if(	j("#login_form").valid()){
		var f_user_name = j('#username_log').val();
		var f_password_login = j('#password_log').val();
		j.post(ajax_file_url_value+"/shopping-ajax.php", { 
		a_username: f_user_name, 
		a_password_login: f_password_login, 
		action: 'user_login_post_values'},function(data) { 
		var trimmed_value = j.trim(data);
		if(trimmed_value !='success'){
		//alert(data);
		j(".notification").html(trimmed_value);
		j(".notification").fadeOut(5000);
		//setTimeout(function (){	window.location.href = site_home_url+'/shopping-portal-page/'; }, 1000); 
		} else {
			//alert("redirect");
			j(".notification").html("Logged In Successfully");
			j(".notification").fadeOut(50000);
			 // Delaying one function for some time
			setTimeout(function (){	window.location.href = site_home_url+'/shopping-portal-page/'; }, 1000); 
			}
	   });
	 }
		});	
	 
	// for signup
	   j( "#signup_button" ).click(function() {
		if(	j("#signup_form").valid()){
	var f_first_name = j('#fname').val();
	var f_last_name = j('#lname').val();
	var f_address = j('#address').val();
	var f_apartment = j('#apartment').val();
	var f_city = j('#city').val();
	
	var f_city = j('#city').val();
	
	var f_country = j('#country').val();
	
	var f_state = j('#state').val();
	var f_zip = j('#zip').val();
	
	var f_email = j('#email').val();
	var f_repeat_password = j('#repeat_password').val();
	var f_username = j('#username').val();
	
	var f_paypal_check_select = j("#payment_head").val();
	var f_paypal = j('#paypal').val();
	var f_check = j('#check').val();

	j.post(ajax_file_url_value+"/shopping-ajax.php", { 
	a_firstname: f_first_name, 
	a_last_name: f_last_name, 
	a_address: f_address, 
	a_apartment: f_apartment, 
	a_city: f_city, 
	a_country: f_country, 
	a_state: f_state, 
	a_zip: f_zip, 
	a_email: f_email,
	a_repeat_password: f_repeat_password, 
	a_username: f_username,
	 
	a_paypal_check_select: f_paypal_check_select, 
	a_paypal: f_paypal, 
	a_check: f_check,
   	action: 'user_signup_post_values'},function(data) {
		var trimmed_value = j.trim(data);
	if(trimmed_value=='success'){
	j(".notification").html("Successfully Registered");
	j(".notification").fadeOut(10000);
	
	// Delaying one function for some time
	setTimeout(function (){	window.location.href = site_home_url; }, 1000); 
	
	} else {
	j(".notification").html(trimmed_value);
	j(".notification").fadeIn(5000);
	}
   });
 }
	});

	//forget hide/show
	
	 j('#forgot_hideshow').click(function() {
                j('.form_content1').fadeIn();
				 j('.form_content').hide();
       });

	// forget password
	
	j( "#forget_button" ).click(function() {
	if(	j("#forget_form").valid()){
	var forgot_email = j('#email_forgot').val();
	j.post(ajax_file_url_value+"/shopping-ajax.php", { 
	a_forgot_email: forgot_email, 
   	action: 'user_forgot_post_values'},function(data) {
		var trimmed_value = j.trim(data);
	if(trimmed_value =='Success'){
	j(".notification").html("Password Changed Successfully..! Please Check Your Mail and Login With New Password Details.");
	j(".notification").fadeOut(5000);
	
	// Delaying one function for some time
	setTimeout(function (){	window.location.href = site_home_url+'/login/'; }, 3000); 
	
	} else {
	j(".forget_notify").html(trimmed_value);
	j(".forget_notify").fadeOut(5000);
		}
  	 });
	}
   });
		
 });
