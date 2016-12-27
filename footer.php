        <script>
    $(".current_project_details").hide();
    $(".current_project").on('click',function(){
<<<<<<< HEAD
         $( ".current_project" ).css('width','300px');
=======
>>>>>>> 40f4b6de6733a4252df2a8fc67e6dfbdbf3e99ac
         $(".current_project_details").toggle(function(){
                $.post( "current_projects.php", function( data ) {
                    var obj = jQuery.parseJSON(data);
                     if( obj.Project_name == null){
                          $( ".current_project_details" ).css('height','40px');
<<<<<<< HEAD
                          $( ".current_project_details" ).html('No current project to be shown');
=======
                          $( ".current_project_details" ).html('you are not performing ');
>>>>>>> 40f4b6de6733a4252df2a8fc67e6dfbdbf3e99ac
                         
                     }else{
                         $( ".current_project_details" ).css('height','300px');
                      $( ".current_project_details" ).html('<strong><a href="SHome.php">'+obj.Project_name+'</a></strong>' +'<hr>'+'Project Description:<br><p style="color:#666666">'+obj.Project_Des+'</p>');
                  }
               });
            });  
    });
<<<<<<< HEAD
    
    
    $(document).ready(function() {
    $('table.display').DataTable();
} );
=======
>>>>>>> 40f4b6de6733a4252df2a8fc67e6dfbdbf3e99ac
</script>

        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="<?php echo  $l_filehomepath; ?>/assets/js/bootstrap.min.js"></script>
       <!-- <script src="assets/js/bootstrap-select.min.js"></script>-->
<<<<<<< HEAD
    <script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
=======

>>>>>>> 40f4b6de6733a4252df2a8fc67e6dfbdbf3e99ac
        <script src="<?php echo  $l_filehomepath; ?>/assets/js/master.js"></script>
    
    </body>
</html> 