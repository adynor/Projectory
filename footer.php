        <script>
    $(".current_project_details").hide();
    $(".current_project").on('click',function(){
         $(".current_project_details").toggle(function(){
                $.post( "current_projects.php", function( data ) {
                    var obj = jQuery.parseJSON(data);
                     if( obj.Project_name == null){
                          $( ".current_project_details" ).css('height','40px');
                          $( ".current_project_details" ).html('you are not performing ');
                         
                     }else{
                         $( ".current_project_details" ).css('height','300px');
                      $( ".current_project_details" ).html('<strong><a href="SHome.php">'+obj.Project_name+'</a></strong>' +'<hr>'+'Project Description:<br><p style="color:#666666">'+obj.Project_Des+'</p>');
                  }
               });
            });  
    });
</script>

        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="<?php echo  $l_filehomepath; ?>/assets/js/bootstrap.min.js"></script>
       <!-- <script src="assets/js/bootstrap-select.min.js"></script>-->

        <script src="<?php echo  $l_filehomepath; ?>/assets/js/master.js"></script>
    
    </body>
</html> 