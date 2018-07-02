  jQuery( function() {
    jQuery( ".datepicker" ).datepicker({
           dateFormat: "yy-mm-dd",
           defaultDate: "2017-08-25",
           minDate: "2017-08-17",
           showButtonPanel: true,
           currentText: "Show Today",
           closeText: "X",
           constrainInput: true
          })
   } );

<!--For more options see http://api.jqueryui.com/datepicker/-->
<!--The selector class, datepicker, is added to form in main plugin file-->

