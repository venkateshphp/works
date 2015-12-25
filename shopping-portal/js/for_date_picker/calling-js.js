  $(function() {
    $( "#store_offer_start" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 1,
	   minDate: 0,
      onClose: function( selectedDate ) {
        $( "#store_offer_end" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    $( "#store_offer_end" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 1,
      onClose: function( selectedDate ) {
        $( "#store_offer_start" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
	// for check box valid
$('input.sample_check').on('change', function() {
	var favourite_check_post_id = this.id;
	//j('.'+favourite_check_post+'_notification').html("Removed From your Favourites");
    $('.'+favourite_check_post_id+'_featured_checkbox1').not(this).prop('checked', false);  
});	
  });
