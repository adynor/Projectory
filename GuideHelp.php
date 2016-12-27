<?php
    
    include ('db_config.php');
    include ('header.php');
    ?>

<div class="row" style="padding:20px"></div>
<div class="container" >

<?php
    $l_UR_id = $_SESSION['g_UR_id'];
    $l_UR_Type = $_SESSION['g_UR_Type'];
    
    if(is_null($l_UR_id) || $l_UR_Type!='G')
    {
        $l_alert_statement =  ' <script type="text/javascript">
        window.alert("You have not logged in as a student. Please login correctly")
        window.location.href="login.php"; </script> ';
        
        print($l_alert_statement );
    }
    
          
    ?>

<center><h2>Welcome to Projectory!!</h2><br/></center>
<center><h2>Guide Help</h2></center><br/>

<p>A guide is a professor or a lecturer who will help the students guide through the project during the course of their project as part of their curriculum.</p><br/>

<a href="#home"> 1. Home </a><br/>
<a href="#addproject"> 2. Add a project </a><br/>
<a href="#viewteams"> 3. View Teams under you  </a><br/>
<a href="#viewdoc"> 3. View Teams' Documents  </a><br/>
<a href="#viewfeedback"> 4. View Teams' Feedbacks </a><br/>
<a href="#givemarks"> 5. Give Marks </a><br/>
<a href="#viewproject"> 6. View your Projects </a><br/>
<a href="#pendingreq"> 7. Pending Requests </a><br/>


<br/><br/>
<a name="home"></a>
<h2> 1. Home - </h2>
<p> This will show you the details of the teams that are under you and has the navigations to guide the project. When a team sends you a request to add you as a guide, it will be shown as a notification on the top which will navigate you to the "Pending Request" tab. The dashboard shows the brief team details along with your stream and institute details.</p>

<br/><br/>
<a name="addproject"></a>
<h2> 2. Add a Project - </h2>

<p>This will help you in adding a project Which you would like to float in Projectory for the student to perform. You have to fill up the following information to add the project -</p>
<br/>
(a) Project Name - Name of the Project<br/>
(b) Project Description - Short description of the project<br/>
(c) Project Duration - How long will the project will take by a team of students.<br/>
(d) Project Start Date - This is the date when the project will be visible in the portal.<br/>
(e) Project Expiry Date - This is the date after which the project will not be visible in the portal.<br/>
(f) Project Synopsis - This is a synopsis of the project to be attached (Preferably as a pdf).<br/>
(g) Set of Documents to be submitted - You will be asked for the types of documents the student teams will submit during the duration of the project. If you do not see the options that you require in the list, please send a list of the documents to be added in the list to "support@adynor.com". We will add the same.<br/>
(h) Select Programs - Please check those branches/programs for whom the project should be visible. If you do not view the branches/programs, please send a list of the same to "support@adynor.com". We will ensure that they are added before you upload the project.<br/>
(i) Select Technologies - Please check the technologies which will be used for the projects. If you do not see the technologies, please send a list of the domains and subdomains to "support@adynor.com". We will ensure that they are added and you can add the project.


<br/><br/>
<a name="viewteams"></a>
<h2> 3. View Teams under you  - </h2>
<p>This will help you give the details of the teams under you. They are categorised in 2 - </p>
<p>(I) Teams currently under you <br/>
(II) Teams that were under you<br/>
</p>
<p>The Teams' details will consist of the project name, the students details like USN, contact details and Last login details for each individual students in the team.</p>

<br/><br/>
<a name="viewdoc"></a>
<h2> 4. View Teams' Documents  - </h2>
<p>You can view the documents that are submitted by the teams that are currently under you. This way you can view which team has submitted the document, view the document by downloading it and give the feedback on it. The feedback you give to each document will have 3 information to fill up - <br/>
(I) Document Rating : Rating from 1 to 5 based on the performance of the team on the document<br/>
(II) Document Status : This will allow you the accept or reject the document submitted. The teams can only move to the next stage of document only if the current document is accepted.<br/>
(III) Document Feedback : This is the feedback on the document. This can include any comments on either improvement on a particular part of documents or good feedback on the teams work.<br/><br/>
You can view all the feedback you give for each team in <a href="#viewfeedback">"View Teams' Feedback"</a> tab.

<br/><br/>
<a name="viewfeedback"></a>
<h2> 5. View Teams' Feedback  -</h2>
<p>You can view all the feedback that are given by you. The first screen will show you which the list of teams. Once you click on the team, you will get the required information based on that team. The information will consist of :<br/>
(I) Document Name  <br/>
(II) Download link <br/>
(III) Document Type <br/>
(IV) Submission Date <br/>
(V) Document Status <br/>
(VI) Your Feedback <br/>
(VII) Your Feedback Date <br/>
(VIII) Your Feedback Rating <br/>
(IX) Mentor Feedback <br/>
(X) Mentor Feedback Date <br/>
(XI) Mentor Feedback Rating <br/>
</p>

<br/><br/>
<a name="givemarks"></a>
<h2> 5. Give Marks - </h2>
<p>This will help you give marks to the students on an individual basis based on their performance in the team during the course of their project. These marks should be given once the project is completed.</p>

<br/><br/>
<a name="viewproject"></a>
<h2> 6. View your Projects - </h2>
<p>You can view the details of the projects which you have uploaded in Projectory. You can also edit certain information of the project.</p>

<br/><br/>
<a name="pendingreq"></a>
<h2> 7. Pending Requests - </h2>
<p>You can view the guide requests that are sent by the teams of students. You can choose to accept or reject them. Once you accept, they will automatically be a team that is working under your guidance.</p>


</div>