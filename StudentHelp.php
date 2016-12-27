<?php



include ('header.php');
    ?>

    <div class="row" style="padding:20px"></div>
    <div class="container" >

<?php
    $l_UR_id = $_SESSION['g_UR_id'];
    $l_UR_Type = $_SESSION['g_UR_Type'];

if(is_null($l_UR_id) || $l_UR_Type!='S')
{
        $l_alert_statement =  ' <script type="text/javascript">
        window.alert("You have not logged in as a student. Please login correctly")
        window.location.href="login.php"; </script> ';

        print($l_alert_statement );
}


?>

<center><h2>Welcome to Projectory!!</h2><br/></center>
<center><h2>Student Help</h2></center><br/>

<a href="#home"> 1. Home </a><br/>
<a href="#synopsis"> 2. View Synopsis </a><br/>
<a href="#team"> 3. Add a Teammate </a><br/>
<a href="#guide"> 4. Add a Guide </a><br/>
<a href="#mentor"> 5. Add a Mentor </a><br/>
<a href="#submitdoc"> 6. Submit a Document </a><br/>
<a href="#viewdoc"> 7. View your Teams Documents and Feedbacks </a><br/>


<br/><br/>
<a name="home"></a> 
<h2> 1. Home - </h2>
<p> This will show you the details of your project and has the navigations to carry out the project. This page also shows the progress bar of the project based on its completion. When your friend/teammate sends you a request to add you as a team member, it will be shown on the top with details of the member who sent you the request. You can accept or reject the request sent to you. The dashboard shows the project details and the team details along with guide and mentor details.</p>

<br/><br/>
<a name="synopsis"></a>
<h2> 2. View Synopsis - </h2>
<p> This allows you to view the synosis of the project that you have selected to perform. It has details of what should be done through the course of project.</p>



<br/><br/>
<a name="team"></a> 
<h2> 3. Add a Teammate - </h2>
<p>Before you can start a project, you need to decide whether you want to do this project alone or with a team. If you wish to do it in a team form, you need to navigate to this page and send request to your teammates listed. Once you send the request, you will have to request your friends/teammates to respond to form a team. After the team is formed, you need to go ahead and navigate to <a href="#guide"> "Add a Guide"</a> option.</p>
<p>If you wish to do the project alone, then you can directly navigate to the "Select the Guide" option</p>

<br/><br/>
<a name="guide"></a> 
<h2> 4. Add a Guide - </h2>
<p>A Guide is a professor or lecturer from your college or institute who will guide and eventually give marks on you on the projects. There are 2 scenarios where this page will be viewed - </p>
<p>1. If you come as a lone wolf(alone) to do the project, you will be asked initially whether you want to do the project alone. Once you accept, then you will be shown the list of guides from your institution who you can request to guide you through your project. You can request only one guide at a time. Once requested, you should wait or request your guide to respond to your request.</p>
<p>2. If you come as a team, then you will be shown the list of guides from your institution who you can request to guide you through your project. You can request only one guide at a time. Once requested, you should wait or request your guide to respond to your request.</p>

<br/><br/>
<a name="mentor"></a> 
<h2> 5. Add a Mentor - </h2>
<p>A Mentor is a professional from a company, who will guide on how the project is carried out at a company. You will be shown the list of mentors who you can request to mentor you through your project. You can request only one mentor at a time. Once requested, you should wait or request your mentor to respond to your request.</p>

<br/><br/>
<a name="submitdoc"></a> 
<h2> 6. Submit a document - </h2>
<p>Once the team is formed along with the selection of guides and mentors, the project is carried out by submission of documents. You can upload your documents by clicking on the browse button. You also should check which kind of document you are submitting. The list of documents will increase once the documents are approved by the guides. You can view the feedback of each document at the <a href="#viewdoc">"View your Teams Documents and Feedbacks"</a> tab</p>

<br/><br/>
<a name="viewdoc"></a> 
<h2> 7. View your Teams Documents and Feedbacks - </h2>
<p>Once your team submits a document, you can view the feedback from both your Guide as well as Mentor. The status of the document will also be shown whether the document is Approved or Rejected. If the document is Approved, you will have to continue with the next stage of documents. If you wish to improve upon the old documents, you can do so by submitting the same in the "Submit Document" tab. However, if the document is Rejected, you will have to resubmit the same type of document in the "Submit Document" tab before moving to the next stage.</p>



</div>