<?php

include('fpdf/fpdf.php');
//Connect to your database
include("db_config.php");
$team_id=$_REQUEST['TM'];
$students=mysql_query('select UR.UR_FirstName,UR.UR_MiddleName,UR.UR_LastName,UR.UR_Emailid,UR_EmailidDomain,IT.IT_name,PG.PG_Name FROM Users AS UR,Institutes AS IT,Programs AS PG  WHERE IT.IT_id=UR.IT_id AND PG.PG_id =UR.PG_id AND UR.TM_id='.$team_id.' AND UR.UR_Type="S"');
$data=array();
while($studentrows=  mysql_fetch_row($students)){
    array_push($data, $studentrows);
    
}
$milestones=mysql_query('SELECT PD.PD_MRating,AL.AL_Desc FROM Project_Documents as PD,Access_Level as AL WHERE PD_Status="A" AND PD.TM_id='.$team_id.' AND PD.AL_id=AL.AL_id GROUP BY PD.AL_id');
$Milestone=array();
while($milestonerows=  mysql_fetch_row($milestones)){
    array_push($Milestone, $milestonerows);
    
}
$studentmark=mysql_query('SELECT  ST.ST_Marks,UR.UR_FirstName,UR.UR_MiddleName,UR.UR_LastName FROM  Student_Results AS ST ,Users AS UR  WHERE ST.UR_Student=UR.UR_id AND ST.TM_id='.$team_id.'');
$Studentmarks=array();
while($Studentmarkrows=  mysql_fetch_row($studentmark)){
    array_push($Studentmarks, $Studentmarkrows);
    
}
$smark= mysql_num_rows($studentmark);

class PDF extends FPDF
{
    function LoadData($file)
{
    // Read file lines
    $lines = file($file);
    $data = array();
    foreach($lines as $line)
        $data[] = explode(';',trim($line));
    return $data;
}
// Page header
function Header()
{
    // Logo
    $this->Image('assets/images/Projectory_B1_Blue.png',10,6,30);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Move to the right
 $this->Cell(100);
    // Title
    $this->SetTextColor(70,130,180);
    $this->Cell(10,10,'REPORT',6,0,'R');
    // Line break
    $this->Ln(30);
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
function MilestoneTable($Milestoneheader, $Milestone)
{
    // Colors, line width and bold font

    $this->SetTextColor(255);
    $this->SetDrawColor(70,130,180);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    // Header
    $this->SetTextColor(255);
    $this->SetFillColor(70,130,180);
   $this->Cell(190,7,'Milestone',1,0,'C',true);
   $this->SetFillColor(128,128,128);
   $this->ln();
    $w = array(95, 95);
    for($i=0;$i<count($Milestoneheader);$i++)
        $this->Cell($w[$i],7,$Milestoneheader[$i],1,0,'C',true);
    $this->Ln();
    // Color and font restoration
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Data
    $fill = false;
    foreach($Milestone as $row)
    {
        $this->Cell($w[0],6,$row[1],'LR',0,'L',$fill);
        $this->Cell($w[1],6,$row[0],'LR',0,'L',$fill);
        
        $this->Ln();
        $fill = !$fill;
    }
    // Closing line
    $this->Cell(array_sum($w),0,'','T');
}

function StudentMarks($StudentMarkHeader,$Studentmarks)
{
    // Colors, line width and bold font

    $this->SetTextColor(255);
    $this->SetDrawColor(70,130,180);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    // Header
    $this->SetTextColor(255);
    $this->SetFillColor(70,130,180);
   $this->Cell(190,7,'Marks',1,0,'C',true);
   $this->SetFillColor(128,128,128);
   $this->ln();
    $w = array(95, 95);
    for($i=0;$i<count($StudentMarkHeader);$i++)
        $this->Cell($w[$i],7,$StudentMarkHeader[$i],1,0,'C',true);
    $this->Ln();
    // Color and font restoration
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Data
    $fill = false;
    foreach($Studentmarks as $row)
    {
        $this->Cell($w[0],6,$row[1].' '.$row[2].' '.$row[3],'LR',0,'L',$fill);
        $this->Cell($w[1],6,$row[0],'LR',0,'C',$fill);
        
        $this->Ln();
        $fill = !$fill;
    }
    // Closing line
    $this->Cell(array_sum($w),0,'','T');
}


function FancyTable($header,$data)
{
//Colors, line width and bold font

$this->SetFillColor(70,130,180);
$this->SetDrawColor(70,130,180);
$this->SetLineWidth(.3);
$this->SetFont('','B');
//Header
$this->SetTextColor(255);
$this->Cell(190,7,'Team Members',1,0,'C',true);
$this->Ln();
$this->SetFillColor(128,128,128);
$this->SetTextColor(255);
$w=array(55,55,40,40);
for($i=0;$i<count($header);$i++)
$this->Cell($w[$i],7,$header[$i],1,0,'C',true);
$this->Ln();
//Color and font restoration
$this->SetFillColor(224,235,255);
$this->SetTextColor(0);
$this->SetFont('');
//Data
$fill=false;

$i = 0;


$x0=$x = $this->GetX();
$y = $this->GetY();
foreach($data as $row)
{

for ($i=0; $i<6; $i++) //Avoid very lengthy texts

{ 

$row[$i]=substr($row[$i],0,160);

}

$yH=25; //height of the row
$this->SetXY($x, $y);
$this->Cell($w[0], $yH, "", 'LRB',0,'',$fill);
$this->SetXY($x, $y);
$this->MultiCell($w[0],6,$row[0].' '.$row[1].' '.$row[2],0,'L'); 


$this->SetXY($x + $w[0], $y);
$this->Cell($w[1], $yH, "", 'LRB',0,'',$fill); 
$this->SetXY($x + $w[0], $y);
$this->MultiCell($w[1],6,$row[3].'@'.$row[4],0,'L'); 


$x =$x+$w[0];
$this->SetXY($x + $w[1], $y);
$this->Cell($w[2], $yH, "", 'LRB',0,'',$fill); 
$this->SetXY($x + $w[1], $y);
$this->MultiCell($w[2],6,$row[5],0,'L'); 

$x =$x+$w[1];
$this->SetXY($x + $w[2], $y);
$this->Cell($w[3], $yH, "", 'LRB',0,'',$fill); 
$this->SetXY($x + $w[2], $y); 
$this->MultiCell($w[3],6,$row[6],0,'L'); 



$y=$y+$yH; //move to next row
$x=$x0; //start from firt column
$fill=!$fill;
}

}

}

// Instanciation of inherited class
$result=mysql_query('select TM.TM_id,TM.TM_Name,PR.PR_Name,PR.PR_Desc FROM Teams AS TM,Projects AS PR WHERE TM.PR_id=PR.PR_id and TM_id='.$team_id.'');
$Teamrows=  mysql_fetch_row($result);
$students=mysql_query('select UR.UR_FirstName,UR.UR_Emailid FROM Users AS UR WHERE UR.TM_id='.$team_id.' AND UR.UR_Type="S"');
$studentrows=  mysql_fetch_row($students);
$TeamName=$Teamrows[1];
$ProjectName=$Teamrows[2];
$PrjectDescription=strip_tags(htmlspecialchars_decode($Teamrows[3]));
$header = array('Name', 'Email id', 'Institute', 'Branch');
$Milestoneheader=array('Milestone','Rating(/5)');
$StudentMarkHeader=array('Name','Mark');
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->SetFont('Times','',12);
$pdf->AddPage();
//$pdf->Cell(190,10,$TeamName,0,1);
//$pdf->Cell(190,10,$ProjectName,0,1);
//$pdf->Cell(190,10,$PrjectDescription,0,1);
$pdf->SetFont('Arial','I',12);
$pdf->Cell(60,6,'Team Name',0,'L');
$pdf->SetFont('');
$pdf->Cell(60,6,':-'.$TeamName,0,'C');
$pdf->ln();
$pdf->SetFont('Arial','I',12);
$pdf->Cell(60,6,'Project Name',0,'L');
$pdf->SetFont('');
$pdf->Cell(60,6,':-'.$ProjectName,0,'C');
$pdf->ln();
$pdf->SetFont('Arial','I',12);
$pdf->Cell(60,6,'Project Description',0,'L');
$pdf->SetFont('');
$pdf->MultiCell(130,6,':-'.$PrjectDescription,0,'C');
$pdf->ln();
$pdf->ln();
$pdf->SetFont('');
$pdf->FancyTable($header,$data);
$pdf->ln(20);
$pdf->MilestoneTable($Milestoneheader, $Milestone);

if($smark > 0){
$pdf->ln(6);
$pdf->AddPage();
$pdf->StudentMarks($StudentMarkHeader,$Studentmarks);
}
$pdf->Output($TeamName.'Report.pdf', 'D');
//$pdf->Output();
?>