<?php

    //////////////////////////////////////////////
    // Name            : AHome
    // Project         : Projectory
    // Purpose         : College admin will insert the semester
    // Called By       : login01
    // Calls           :  Aview_SPayments01, aview_newstudent, aview_newGuide, AStudentResults
    // Mod history:
    //////////////////////////////////////////////
    
include ('db_config.php');
include ('header.php');  
?>
 <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.24/angular.min.js"></script>
<style>
.ng-cloak { display:none; }
</style>
<div class="row" style="padding:10px"></div>
<div class="row" style="padding:10px"></div>
<div class="container" ng-app="fetch">
    <?php
    //session id to local variables
    $l_UR_id                     = $_SESSION['g_UR_id'];  // For the Communications table we need the from id
    $l_IT_id                      = $_SESSION['g_IT_id'];
    $l_UR_Type                     = $_SESSION['g_UR_Type'];
    
    //check if the user is logged in and is a college admin
    if(is_null($l_UR_id) || $l_UR_Type!='A')
    {
        $l_alert_statement =  ' <script type="text/javascript">
        window.alert("You have not logged in as the college admin. Please login correctly")
        window.location.href="Signout.php"; </script> ';
        
        print($l_alert_statement );
    }
    
 
    // get the last login date and time
    $l_LastLoginDate_query = 'select  UR_LastLogin from Users where UR_id = "'.$l_UR_id.'" and Org_id="'.$_SESSION['g_Org_id'].'"';
    $l_LastLoginDate = mysql_query($l_LastLoginDate_query) or die(mysql_error());
    $l_Date=mysql_fetch_row($l_LastLoginDate);
    $l_LoginDate_res=$l_Date[0];
    
    $l_LoginDate_res= date("d-M-Y h:i A", strtotime($l_LoginDate_res));
    
    //display the last login date and time
    print('<div class="alert alert-info"><h5 style="text-align:right">logged in at ' .$l_LoginDate_res. '</h5></div>');
?>
   <br>
      <div class="row ng-cloak">
        <div class="container">
           <div ng-controller="dbCtrl">
          <input type="text" ng-model="searchFilter" class="form-control">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Team Name</th>
                        <th>Roll No</th>
                    </tr>
                </thead>
  <tbody ng-repeat="students in data | filter:searchFilter">
  <tr>          
      <td>{{students.TM_Name}}</td>
      <td>{{students.PR_id}}</td>
  </tr>        
  </tbody>
            </table>
          </div>
        </div>
      </div>

  
    

</div> 
<script>
        var fetch = angular.module('fetch', []);

        fetch.controller('dbCtrl', ['$scope', '$http', function ($scope, $http) {
            $http.get("allteams.php")
                .success(function(data){
                    $scope.data = data;
                })
                .error(function() {
                    $scope.data = "error in fetching data";
                });
        }]);

    </script>

<?php include('footer.php')?>