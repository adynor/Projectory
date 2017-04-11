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
.badge {
    display: inline-block;
    min-width: 10px;
    padding: 5px 9px;
    margin-right: 3px;
    font-size: 14px;
    font-weight: 7000;
    line-height: 1;
    color: #e9eef3;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    background-color: rgba(38, 162, 7, 0.86);
    border-radius: 10px;
}
.modal-body {
   overflow: auto;
  max-height: calc(100vh - 60px);
}

.modal-header, .modal-footer {
 flex-grow: 1;
 flex-shrink: 0;
 flex-basis: auto;
}
.ng-cloak { display:none; }
a{cursor: pointer;}

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
            <table class="ady-table-content" border="1" style="width:100%">
                <thead>
                    <tr>
                        <th>Team Name</th>
                        <th>Name</th>
                        <th>Relation</th>
                    </tr>
                </thead>
  <tbody >
  <tr style="width:100%; border: 1px solid darkorange;" ng-repeat="value in data | filter:searchFilter">          
      <td><a data-toggle="modal" data-target="#myModal" ng-click="showdetails(value.PR_id,value.TM_id,value.TM_Name);" ng-if="value.UR_Type=='G'" >{{value.TM_Name}}</a></td>
      <td >{{value.UR_FirstName}}</td>
      <td><span class="btn btn-default btn-xs" ng-if="value.UR_Type=='M'">Mentor</span><span  class="btn btn-default btn-xs" ng-if="value.UR_Type=='G'">Guide</span></td>
      </tr>        
  </tbody>
            </table>
            
            <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" ng-model="teamname">{{teamname}}Details </h4>
        </div>
        <div class="modal-body">
 <table class="ady-table-content" border="1" style="width:100%" >
 <thead>
                    <tr style="width:100%; border: 1px solid darkorange;">
                        <th >Project Name</th><td ng-repeat="m in members |limitTo:1">{{m.PR_Name}}</td> 
                    </tr>
                   <tr style="width:100%; border: 1px solid darkorange;">
                        <th>Team Members Name</th><td><span class="badge" ng-repeat="m in members">{{m.UR_FirstName}}</span></td> 
                        
                   </tr>
                </thead>

 </table><hr>       
          <table class="ady-table-content" border="1" style="width:100%">
          <thead>
                    <tr style="width:100%; border: 1px solid darkorange;">
                        <th>Document Name</th>
                        <th>Submition Date</th>
                        <th>Guide Feedback</th>
                        <th>Guide Feedback Date</th>
                        <th>Guide Rating</th>
                        <th>Mentor Feedback </th>
                        <th>Mentor Date</th>
                        <th>Mentor Rating</th>
                        <th>Status</th>
                        
                    </tr>
                </thead>
<tbody >
          <tr style="width:100%; border: 1px solid darkorange;" ng-repeat="d in details">
       <td>{{d.AL_Desc}}</td>
             <td>{{d.PD_SubmissionDate}}</td>
             <td >{{d.PD_Feedback}}<span ng-if="!d.PD_Feedback">Pending</span></td>
             <td>{{d.PD_FeedbackDate}}<span ng-if="!d.PD_FeedbackDate">Pending</span></td>
              <td>{{d.PD_Rating}}<span ng-if="!d.PD_Rating">Pending</span></td>
               <td>{{d.PD_MFeedback}}<span ng-if="!d.PD_MFeedback">Pending</span></td>
                <td>{{d.PD_MFeedbackDate}}<span ng-if="!d.PD_MFeedbackDate">Pending</span></td>
                 <td>{{d.PD_MRating}}<span ng-if="!d.PD_MRating">Pending</span></td>
            <td ><span style="color: #3eaa27;" ng-if="d.PD_Status=='A'">Accepted</span><span style="color:orange" ng-if="d.PD_Status=='R'">Rejected</span><span ng-if="d.PD_Status=='P'">Pending</span></td>
       </tr>
          </tbody>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>
            
            
          </div>
        </div>
      </div>

</div> 
<script>
  var fetch = angular.module('fetch', []);
        fetch.controller('dbCtrl', ['$scope', '$http', function ($scope, $http) {
    $scope.url1 = 'allteams.php';
      $scope.url2 = 'teamdocstatus.php';
      $scope.url3 = 'teammembers.php';
      $scope.getlist = function(dc) {
       // alert(a+'='+b);
        $scope.teamname=c;
        $scope.prid=a;
        $scope.tmid=b;
            $http.post($scope.url2,{"tmid":$scope.tmid,"prid":$scope.prid}).
                        success(function(data,status) {
                     $scope.details=data;
   })
      };
      
      $scope.showdetails = function(a,b,c) {
       $scope.details="";
       $scope.members="";
        $scope.teamname=c;
        $scope.prid=a;
        $scope.tmid=b;
            $http.post($scope.url2,{"tmid":$scope.tmid,"prid":$scope.prid}).
                        success(function(data,status) {
                     $scope.details=data;
   });
      
      $http.post($scope.url3,{"tmid":$scope.tmid,"prid":$scope.prid}).
                        success(function(data,status) {
                  $scope.members=data;
                     });
      
      };
          
         $http.post($scope.url1)
                .success(function(data){
                 $scope.data = data;
                    console.log($scope.data);
                })
                .error(function() {
                    $scope.data = "error in fetching data";
                });
        }]);

    </script>
<script>
$(document).ready(function(){
    $('[data-toggle="popover"]').popover();   
});
</script>
<?php include('footer.php')?>