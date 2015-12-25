(function($,W,D)
{
    var JQUERY4U = {};

    JQUERY4U.UTIL =
    {
        setupFormValidation: function()
        {
			$("#signup_form").validate({
                rules: {
                    fname: {
						required: true,
						//lettersonly: true
						},
                    lname: {
						required: true,
						//lettersonly: true
						},
					address: {
						required: true,
						//lettersonly: true
						},
					//apartment: "required",
					city: "required",
					state: "required",
					country: "required",
					zip: "required",
					
					username: {
						required: true,
						//lettersonly: true
						},
					email: {
                        required: true,
                        email: true
                    	},

				password: {
                minlength: 6,
				required: true
            },
            repeat_password: {
				 required: true,
                minlength: 6,
                equalTo: "#password"
            },
					payment_head: {
               required: function () {
                   if ($("#payment_head option[value='']")) {
                       return true;
                   } else {
                       return false;
                   }
               }
           },
			
					//paypal: "required",
					//paypale_name: "required",
					//check: "required",
					
				},
              messages: {
                    fname: "Enter your First Name ",
					lname: "Enter your Last Name ",
					address: "Enter your Address ",
					//apartment: "Enter your Apartment ",
					city: "Enter your City ",
					state: "Select your State ",
					country: "Select your Country",
					zip: "Enter your Zip-Code ",
                    email: "Enter a valid email address",
					username: "Enter your Username",
					password: "Enter your Password With Minimum 6 Characters",
					repeat_password: "Enter your Repeat Password Correctly",
					//paypal: "Paypal Information Required",
					//paypale_name: "Payment Name Information Required",
					payment_head: "Please Select The Payment Option",
                  },
				 //submitHandler: function(form) {
//                    form.submit();
//                }
               
            });
			// for login form validation
			$("#login_form").validate({
                rules: {
                    username_log: {
						required: true,
						//lettersonly: true
						},
				password_log: {
                minlength: 6,
				required: true
            },
				},
              messages: {
                    username_log: "Enter your Username ",
					password_log: "Enter your Password",
                  },
				 //submitHandler: function(form) {
//                    form.submit();
//                }
               
            });
			// forgot password validation
			$("#forget_form").validate({
                rules: {
                    email_forgot: {
                        required: true,
                        email: true
                    	},
				},
              messages: {
                    email_forgot: "Enter a valid email address"
                  },
				 //submitHandler: function(form) {
//                    form.submit();
//                }
               
            });
			
			//for Update form
			$("#edit_data").validate({
                rules: {
					fname_update: "required",
					lname_update: "required",
					address_update: "required",
					//apartment_update: "required",
					city_update: "required",
					state: "required",
					country: "required",
					zip_update: "required",
					email_update: "required",
					email_conf_update: {
				 required: true,
                equalTo: "#email_update"
            },
			    password_update: {
                minlength: 6,
				//required: true
            },
            repeat_password_update: {
				 //required: true,
                minlength: 6,
                equalTo: "#password_update"
            },
					
					//paypal_update: "required",
					//paypale_name_update: "required",
					//check_update: "required"
				},
              messages: {
                    fname_update: "Enter Your Name To Update",
					lname_update: "required",
					address_update: "Enter Your Address To Update",
					//apartment_update: "Enter Your Apartment To Update",
					city_update: "Enter Your City To Update",
					country: "Select Your Country To Update",
					state: "Select Your State To Update",
					zip_update: "Enter Your Zip-Code To Update",
					email_update: "Enter Your Email To Update",
					email_conf_update: "Enter Your Confirm Email Correctly To Update",
					password_update: "Enter your Password With Minimum Having 6 characters",
					repeat_password_update: "Enter your confirm Password Correctly",
					//paypal_update: "Enter Your Paypal Information To Update",
					//paypale_name_update: "Enter Your Paypal Name To Update",
                  },
				 //submitHandler: function(form) {
                 //form.submit();
                //}
               
            });
        }
    }
	//when the dom has loaded setup form validation rules
    $(D).ready(function($) {
        JQUERY4U.UTIL.setupFormValidation();
    });

 })(jQuery, window, document);
