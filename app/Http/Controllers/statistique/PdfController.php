<?php

namespace App\Http\Controllers\statistique;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf;
use DateTime;
use Illuminate\Support\Facades\Date;

class PdfController extends Controller
{
    protected $fpdf;

    public function __construct()
    {

    }


    public function pdf_recap_by_agent()
    {
        $fpdf = new Fpdf;

        setlocale(LC_CTYPE, 'fr_FR');
       // $txt = iconv("UTF-8", "windows-1252", 'Quantité');
     //  $txt = utf8_decode('Quantité');
//dd($data);
$rapportGares= session('rapportGares');
$end = date_format(new DateTime(session('end')),'d-m-Y');
$start = date_format(new DateTime(session('start')),'d-m-Y');
$nomgare = session('nomgare');
//dd($start);
       // $pdf = new FPDF();
       $fpdf->AddPage();
/*output the result*/

/*set font to arial, bold, 14pt*/
$fpdf->SetFont('Arial','B',20);

/*Cell(width , height , text , border , end line , [align] )*/

$fpdf->Cell(3 ,5,'',0,0);
$fpdf->Cell(59 ,5,iconv("UTF-8", "windows-1252", "STATISTIQUE DES AGENTS PAR GARE"),0,0);
$fpdf->Cell(59 ,10,'',0,1);

$fpdf->SetFont('Arial','B',15);

$fpdf->SetFont('Arial','',10);

//$this->fpdf->Cell(130 ,5,'Near DAV',0,0);
$fpdf->Cell(25 ,5,'Du:',0,0);
$fpdf->Cell(34 ,5,$start,0,1);

//$this->fpdf->Cell(130 ,5,'Delhi, 751001',0,0);
$fpdf->Cell(25 ,5,'Au:',0,0);
$fpdf->Cell(34 ,5,$end ,0,1);

$fpdf->Cell(25 ,5,iconv("UTF-8", "windows-1252", 'Gare:'),0,0);
$fpdf->Cell(34 ,5,$nomgare,0,1);




$fpdf->Cell(50 ,10,'',0,1);

$fpdf->SetFont('Arial','B',10);
/*Heading Of the table*/
$fpdf->Cell(25 ,6,'#',1,0,'C');
$fpdf->Cell(90 ,6,iconv("UTF-8", "windows-1252", 'Agent'),1,0,'C');
$fpdf->Cell(30 ,6,iconv("UTF-8", "windows-1252", 'Quantité'),1,0,'C');
$fpdf->Cell(50 ,6,'Montant (FCFA)',1,1,'C');

$fpdf->SetFont('Arial','',10);
if(count($rapportGares)>0){
    for ($i = 0; $i < count($rapportGares); $i++) {

        //dd($data['rapportGare'][$i]->qte_bagage);
		$fpdf->Cell(25 ,6,$i+1,1,0);
		$fpdf->Cell(90 ,6,iconv("UTF-8", "windows-1252", $rapportGares[$i]->name)  ,1,0,);
		$fpdf->Cell(30 ,6,$rapportGares[$i]->qte_bagage,1,0,);
		$fpdf->Cell(50 ,6,$rapportGares[$i]->prix,1,1,);

	}

    $fpdf->Cell(120 ,6,'',0,0);
$fpdf->Cell(25 ,6,'Total montant',0,0);
$fpdf->Cell(50 ,6,$rapportGares->sum('prix'),1,1,);
}




$fpdf->Output();
exit;
    }

public function pdf_recap_by_gare()
{
    $fpdf = new Fpdf;

    setlocale(LC_CTYPE, 'fr_FR');

$rapportGares= session('rapportGares');
$end = date_format(new DateTime(session('end')),'d-m-Y');
$start = date_format(new DateTime(session('start')),'d-m-Y');
$type_bagage = session('type_bagage');

   $fpdf->AddPage();


$fpdf->SetFont('Arial','B',20);


$fpdf->Cell(3 ,5,'',0,0);
$fpdf->Cell(59 ,5,iconv("UTF-8", "windows-1252", "STATISTIQUE DES $type_bagage PAR GARE"),0,0);
$fpdf->Cell(59 ,10,'',0,1);

$fpdf->SetFont('Arial','B',15);

$fpdf->SetFont('Arial','',10);

$fpdf->Cell(25 ,5,'Du:',0,0);
$fpdf->Cell(34 ,5,$start,0,1);

$fpdf->Cell(25 ,5,'Au:',0,0);
$fpdf->Cell(34 ,5,$end ,0,1);

$fpdf->Cell(27 ,5,iconv("UTF-8", "windows-1252", 'Type de produit: '),0,0);
$fpdf->Cell(35 ,5,$type_bagage,0,1);




$fpdf->Cell(50 ,10,'',0,1);

$fpdf->SetFont('Arial','B',10);
/*Heading Of the table*/
$fpdf->Cell(25 ,6,'#',1,0,'C');
$fpdf->Cell(90 ,6,iconv("UTF-8", "windows-1252", 'Gare'),1,0,'C');
$fpdf->Cell(30 ,6,iconv("UTF-8", "windows-1252", 'Quantité'),1,0,'C');
$fpdf->Cell(50 ,6,'Montant (FCFA)',1,1,'C');

$fpdf->SetFont('Arial','',10);
if(count($rapportGares)>0){
for ($i = 0; $i < count($rapportGares); $i++) {


    $fpdf->Cell(25 ,6,$i+1,1,0);
    $fpdf->Cell(90 ,6,iconv("UTF-8", "windows-1252", $rapportGares[$i]->nom_gare)  ,1,0,);
    $fpdf->Cell(30 ,6,$rapportGares[$i]->qte_bagage,1,0,);
    $fpdf->Cell(50 ,6,$rapportGares[$i]->prix,1,1,);

}

$fpdf->Cell(120 ,6,'',0,0);
$fpdf->Cell(25 ,6,'Total montant',0,0);
$fpdf->Cell(50 ,6,$rapportGares->sum('prix'),1,1,);
}




$fpdf->Output();
exit;
}

    public function pdf_recap_by_journalier()
    {


        $fpdf = new Fpdf;

        setlocale(LC_CTYPE, 'fr_FR');

    $rapportGares= session('rapportGares');
    $end = date_format(new DateTime(session('end')),'d-m-Y');
    $start = date_format(new DateTime(session('start')),'d-m-Y');
    $nomgare = session('nomgare');

       $fpdf->AddPage();


    $fpdf->SetFont('Arial','B',20);


    $fpdf->Cell(3 ,5,'',0,0);
    $fpdf->Cell(59 ,5,iconv("UTF-8", "windows-1252", "STATISTIQUE JOURNALIER DE BAGAGE PAR GARE"),0,0);
    $fpdf->Cell(59 ,10,'',0,1);

    $fpdf->SetFont('Arial','B',15);

    $fpdf->SetFont('Arial','',10);

    $fpdf->Cell(25 ,5,'Du:',0,0);
    $fpdf->Cell(34 ,5,$start,0,1);

    $fpdf->Cell(25 ,5,'Au:',0,0);
    $fpdf->Cell(34 ,5,$end ,0,1);

    $fpdf->Cell(27 ,5,iconv("UTF-8", "windows-1252", 'Gare: '),0,0);
    $fpdf->Cell(35 ,5,$nomgare,0,1);




    $fpdf->Cell(50 ,10,'',0,1);

    $fpdf->SetFont('Arial','B',10);
    /*Heading Of the table*/
    $fpdf->Cell(25 ,6,'#',1,0,'C');
    $fpdf->Cell(70 ,6,iconv("UTF-8", "windows-1252", 'Gare'),1,0,'C');
    $fpdf->Cell(60 ,6,iconv("UTF-8", "windows-1252", 'Type de bagage'),1,0,'C');
    $fpdf->Cell(40 ,6,utf8_decode('Quantité'),1,1,'C');

    $fpdf->SetFont('Arial','',10);
    if(count($rapportGares)>0){
    for ($i = 0; $i < count($rapportGares); $i++) {


        $fpdf->Cell(25 ,6,$i+1,1,0);
        $fpdf->Cell(70 ,6, utf8_decode( $rapportGares[$i]->nom_gare)  ,1,0);
        $fpdf->Cell(60 ,6, utf8_decode($rapportGares[$i]->type_bagage) ,1,0);
        $fpdf->Cell(40 ,6,$rapportGares[$i]->qte_bagage,1,1);

    }

    $fpdf->Cell(120 ,6,'',0,0);
    $fpdf->Cell(35 ,6,'Total ',0,0);
    $fpdf->Cell(40 ,6,$rapportGares->sum('qte_bagage'),1,1);
    }




    $fpdf->Output();
    exit;


    }


    public function pdf_recap_by_general()
    {

        $fpdf = new Fpdf;

        setlocale(LC_CTYPE, 'fr_FR');

    $rapportGares= session('rapportGares');
    $end = date_format(new DateTime(session('end')),'d-m-Y');
    $start = date_format(new DateTime(session('start')),'d-m-Y');
    $nomgare = session('nomgare');
    $nomuser = session('nomuser');
    $type_bagage = session('type_bagage');

       $fpdf->AddPage();


    $fpdf->SetFont('Arial','B',20);


    $fpdf->Cell(3 ,5,'',0,0);
    $fpdf->Cell(59 ,5,iconv("UTF-8", "windows-1252", "GENERAL DES AGENTS PAR GARE EN BAGAGE"),0,0);
    $fpdf->Cell(59 ,10,'',0,1);

    $fpdf->SetFont('Arial','B',15);

    $fpdf->SetFont('Arial','',10);

    $fpdf->Cell(25 ,5,'Du:',0,0);
    $fpdf->Cell(34 ,5,$start,0,1);

    $fpdf->Cell(25 ,5,'Au:',0,0);
    $fpdf->Cell(34 ,5,$end ,0,1);

    $fpdf->Cell(27 ,5,iconv("UTF-8", "windows-1252", 'Gare: '),0,0);
    $fpdf->Cell(35 ,5,$nomgare,0,1);

    $fpdf->Cell(27 ,5,iconv("UTF-8", "windows-1252", 'Agent: '),0,0);
    $fpdf->Cell(35 ,5,$nomuser,0,1);

    $fpdf->Cell(27 ,5,iconv("UTF-8", "windows-1252", 'Type de bagage: '),0,0);
    $fpdf->Cell(35 ,5,$type_bagage,0,1);



    $fpdf->Cell(50 ,10,'',0,1);

    $fpdf->SetFont('Arial','B',10);
    /*Heading Of the table*/
   // $fpdf->Cell(15 ,6,'#',1,0,'C');
    $fpdf->Cell(40 ,6,iconv("UTF-8", "windows-1252", 'Gare'),1,0,'C');
    $fpdf->Cell(60 ,6,iconv("UTF-8", "windows-1252", 'Agent'),1,0,'C');
    $fpdf->Cell(60 ,6,iconv("UTF-8", "windows-1252", 'Type de bagage'),1,0,'C');
    $fpdf->Cell(15 ,6,utf8_decode('Quantité'),1,0,'C');
    $fpdf->Cell(20 ,6,utf8_decode('Montant (FCFA)'),1,1,'C');

    $fpdf->SetFont('Arial','',10);
    if(count($rapportGares)>0){
    for ($i = 0; $i < count($rapportGares); $i++) {


    //    $fpdf->Cell(15 ,6,$i,1,0);
        $fpdf->Cell(40 ,6, utf8_decode( $rapportGares[$i]->nom_gare)  ,1,0);
        $fpdf->Cell(60 ,6, utf8_decode($rapportGares[$i]->name) ,1,0);
        $fpdf->Cell(60 ,6, utf8_decode($rapportGares[$i]->type_bagage) ,1,0);
        $fpdf->Cell(15 ,6,$rapportGares[$i]->qte_bagage,1,0);
        $fpdf->Cell(20 ,6,$rapportGares[$i]->prix,1,1);

    }

    $fpdf->Cell(125 ,6,'',0,0);
    $fpdf->Cell(35 ,6,'Total ',0,0);
    $fpdf->Cell(15 ,6,$rapportGares->sum('qte_bagage'),1,0);
    $fpdf->Cell(20 ,6,$rapportGares->sum('prix'),1,1);
    }




    $fpdf->Output();
    exit;


    }

    public function pdf_recap_colis_by_general()
    {

        $fpdf = new Fpdf;

        setlocale(LC_CTYPE, 'fr_FR');

    $rapportColis= session('rapportColis');
    $end = date_format(new DateTime(session('end')),'d-m-Y');
    $start = date_format(new DateTime(session('start')),'d-m-Y');
    $nomgare = session('nomgare');
    $nomuser = session('nomuser');
    // $type_bagage = session('type_bagage');

       $fpdf->AddPage();


    $fpdf->SetFont('Arial','B',20);


    $fpdf->Cell(3 ,5,'',0,0);
    $fpdf->Cell(59 ,5,iconv("UTF-8", "windows-1252", "GENERAL DES AGENTS PAR GARE EN COLIS"),0,0);
    $fpdf->Cell(59 ,10,'',0,1);

    $fpdf->SetFont('Arial','B',15);

    $fpdf->SetFont('Arial','',10);

    $fpdf->Cell(25 ,5,'Du:',0,0);
    $fpdf->Cell(34 ,5,$start,0,1);

    $fpdf->Cell(25 ,5,'Au:',0,0);
    $fpdf->Cell(34 ,5,$end ,0,1);

    $fpdf->Cell(27 ,5,iconv("UTF-8", "windows-1252", 'Gare: '),0,0);
    $fpdf->Cell(35 ,5,$nomgare,0,1);

    $fpdf->Cell(27 ,5,iconv("UTF-8", "windows-1252", 'Agent: '),0,0);
    $fpdf->Cell(35 ,5,$nomuser,0,1);

    $fpdf->Cell(27 ,5,iconv("UTF-8", "windows-1252", 'Nombre: '),0,0);
    $fpdf->Cell(35 ,5,$nomuser,0,1);

    $fpdf->Cell(27 ,5,iconv("UTF-8", "windows-1252", 'Montant: '),0,0);
    $fpdf->Cell(35 ,$rapportColis->sum('prix'),5,0,1);



    $fpdf->Cell(50 ,10,'',0,1);

    $fpdf->SetFont('Arial','B',10);
    /*Heading Of the table*/
   // $fpdf->Cell(15 ,6,'#',1,0,'C');
    $fpdf->Cell(40 ,6,iconv("UTF-8", "windows-1252", 'Gare'),1,0,'C');
    $fpdf->Cell(60 ,6,iconv("UTF-8", "windows-1252", 'Agent'),1,0,'C');
    $fpdf->Cell(15 ,6,utf8_decode('Quantité'),1,0,'C');
    $fpdf->Cell(20 ,6,utf8_decode('Montant (FCFA)'),1,1,'C');

    $fpdf->SetFont('Arial','',10);
    if(count($rapportColis)>0){
    for ($i = 0; $i < count($rapportColis); $i++) {


    //    $fpdf->Cell(15 ,6,$i,1,0);
        $fpdf->Cell(40 ,6, utf8_decode( $rapportColis[$i]->nom_gare)  ,1,0);
        $fpdf->Cell(60 ,6, utf8_decode($rapportColis[$i]->name) ,1,0);
        $fpdf->Cell(15 ,6,$rapportColis[$i]->qte_colis,1,0);
        $fpdf->Cell(20 ,6,$rapportColis[$i]->prix,1,1);

    }

    $fpdf->Cell(125 ,6,'',0,0);
    $fpdf->Cell(35 ,6,'Total ',0,0);
    $fpdf->Cell(15 ,6,$rapportColis->sum('qte_colis'),1,0);
    $fpdf->Cell(20 ,6,$rapportColis->sum('prix'),1,1);
    }

    $fpdf->Output();
    exit;


    }




    public function pdf_stat_client()
    {


        $fpdf = new Fpdf;

        setlocale(LC_CTYPE, 'fr_FR');

    $rapportGares= session('rapportGares');
    $end = date_format(new DateTime(session('end')),'d-m-Y')  ;

    $start = date_format(new DateTime(session('start')),'d-m-Y');
    $nomgare = session('nomgare');

       $fpdf->AddPage();


    $fpdf->SetFont('Arial','B',20);


    $fpdf->Cell(3 ,5,'',0,0);
    $fpdf->Cell(59 ,5,iconv("UTF-8", "windows-1252", "RAPPORT RECAPITULATIF PAR CLIENT"),0,0);
    $fpdf->Cell(59 ,10,'',0,1);

    $fpdf->SetFont('Arial','B',15);

    $fpdf->SetFont('Arial','',10);

    $fpdf->Cell(25 ,5,'Du:',0,0);
    $fpdf->Cell(34 ,5,$start,0,1);

    $fpdf->Cell(25 ,5,'Au:',0,0);
    $fpdf->Cell(34 ,5,$end,0,1);

    $fpdf->Cell(27 ,5,iconv("UTF-8", "windows-1252", 'Gare: '),0,0);
    $fpdf->Cell(35 ,5,$nomgare,0,1);




    $fpdf->Cell(50 ,10,'',0,1);

    $fpdf->SetFont('Arial','B',10);
    /*Heading Of the table*/
    $fpdf->Cell(25 ,6,'#',1,0,'C');
    $fpdf->Cell(70 ,6,iconv("UTF-8", "windows-1252", 'Client'),1,0,'C');
    $fpdf->Cell(60 ,6,iconv("UTF-8", "windows-1252", 'Téléphone'),1,0,'C');
    $fpdf->Cell(40 ,6,utf8_decode('Quantité'),1,1,'C');

    $fpdf->SetFont('Arial','',10);
    if(count($rapportGares)>0){
    for ($i = 0; $i < count($rapportGares); $i++) {


        $fpdf->Cell(25 ,6,$i+1,1,0);
        $fpdf->Cell(70 ,6, utf8_decode( $rapportGares[$i]->name_passager)  ,1,0);
        $fpdf->Cell(60 ,6, utf8_decode($rapportGares[$i]->phone_passager) ,1,0);
        $fpdf->Cell(40 ,6,$rapportGares[$i]->qte_bagage,1,1);

    }

    $fpdf->Cell(120 ,6,'',0,0);
    $fpdf->Cell(35 ,6,'Total ',0,0);
    $fpdf->Cell(40 ,6,$rapportGares->sum('qte_bagage'),1,1);
    }




    $fpdf->Output();
    exit;


    }


    public function pdf_stat_vehicule()
    {


        $fpdf = new Fpdf;

        setlocale(LC_CTYPE, 'fr_FR');

    $rapportGares= session('rapportGares');

   $end = date_format(new DateTime(session('end')),'d-m-Y')  ;

    $start = date_format(new DateTime(session('start')),'d-m-Y');
    $bagage_fret = session('bagage_fret');

       $fpdf->AddPage();


    $fpdf->SetFont('Arial','B',20);


    $fpdf->Cell(3 ,5,'',0,0);
    $fpdf->Cell(59 ,5,iconv("UTF-8", "windows-1252", "RAPPORT RECAPITULATIF PAR VEHICULE"),0,0);
    $fpdf->Cell(59 ,10,'',0,1);

    $fpdf->SetFont('Arial','B',15);

    $fpdf->SetFont('Arial','',10);

    $fpdf->Cell(25 ,5,'Du:',0,0);
    $fpdf->Cell(34 ,5,$start,0,1);

    $fpdf->Cell(25 ,5,'Au:',0,0);
    $fpdf->Cell(34 ,5,$end ,0,1);

    $fpdf->Cell(27 ,5,iconv("UTF-8", "windows-1252", 'Bagage/Fret: '),0,0);
    $fpdf->Cell(35 ,5,$bagage_fret,0,1);




    $fpdf->Cell(50 ,10,'',0,1);

    $fpdf->SetFont('Arial','B',10);
    /*Heading Of the table*/
    $fpdf->Cell(15 ,6,'#',1,0,'C');
    $fpdf->Cell(50 ,6,iconv("UTF-8", "windows-1252", 'Nom du véhicule '),1,0,'C');
    $fpdf->Cell(50 ,6,iconv("UTF-8", "windows-1252", 'Matricule du véhicule '),1,0,'C');
    $fpdf->Cell(40 ,6,iconv("UTF-8", "windows-1252", 'Quantité'),1,0,'C');
    $fpdf->Cell(40 ,6,utf8_decode('Montant (FCFA)'),1,1,'C');

    $fpdf->SetFont('Arial','',10);
    if(count($rapportGares)>0){
    for ($i = 0; $i < count($rapportGares); $i++) {


        $fpdf->Cell(15 ,6,$i+1,1,0);
        $fpdf->Cell(50 ,6, utf8_decode( $rapportGares[$i]->NOM_DU_VEHICULE)  ,1,0);
        $fpdf->Cell(50 ,6, utf8_decode($rapportGares[$i]->numero_vehicule) ,1,0);
        $fpdf->Cell(40 ,6, utf8_decode($rapportGares[$i]->NOMBRE_TOTAL_BAGAGE) ,1,0);
        $fpdf->Cell(40 ,6,$rapportGares[$i]->PRIX_TOTAL_BAGAGE,1,1);

    }

    $fpdf->Cell(65 ,6,'',0,0);
    $fpdf->Cell(50 ,6,'Total ',1,0);
    $fpdf->Cell(40 ,6,$rapportGares->sum('NOMBRE_TOTAL_BAGAGE'),1,0);
    $fpdf->Cell(40 ,6,$rapportGares->sum('PRIX_TOTAL_BAGAGE'),1,1);
    }




    $fpdf->Output();
    exit;


    }


public function pdf_ticket(){

    $fpdf = new Fpdf;
    setlocale(LC_CTYPE, 'fr_FR');
    $ticket = session('tickets');
    $ticketsGroupedByCreatedAt = session('ticketsGroupedByCreatedAt');
    $end = date_format(new DateTime(session('end')),'d-m-Y')  ;

    $start = date_format(new DateTime(session('start')),'d-m-Y');

    $fpdf->AddPage();


    $fpdf->SetFont('Arial','B',20);


    $fpdf->Cell(3 ,5,'',0,0);
    $fpdf->Cell(200 ,5,iconv("UTF-8", "windows-1252", "RAPPORT DES TICKETS "),0,0,'C');
    $fpdf->Cell(59 ,10,'',0,1);

    $fpdf->SetFont('Arial','B',15);

    $fpdf->SetFont('Arial','',10);

    $fpdf->Cell(25 ,5,'Du:',0,0);
    $fpdf->Cell(34 ,5,$start,0,1);

    $fpdf->Cell(25 ,5,'Au:',0,0);
    $fpdf->Cell(34 ,5,$end ,0,1);

    $fpdf->Cell(27 ,5,iconv("UTF-8", "windows-1252", 'Nombre  ticket: '),0,0);
  $fpdf->Cell(35 ,5,$ticket->count(),0,1);

  $fpdf->Cell(27 ,5,iconv("UTF-8", "windows-1252", 'Montant total: '),0,0);
  $fpdf->Cell(35 ,5,$ticket->sum('prix').' FCFA',0,1);


  $fpdf->Cell(50 ,10,'',0,1);

  $fpdf->SetFont('Arial','B',10);
  /*Heading Of the table*/
  $fpdf->Cell(20 ,6,'#',1,0,'C');
  $fpdf->Cell(60 ,6,iconv("UTF-8", "windows-1252", 'JOUR '),1,0,'C');
  $fpdf->Cell(60 ,6,iconv("UTF-8", "windows-1252", 'QTE TICKET'),1,0,'C');
  //$fpdf->Cell(40 ,6,iconv("UTF-8", "windows-1252", 'Quantité'),1,0,'C');
  $fpdf->Cell(50 ,6,utf8_decode('MONTANT (FCFA)'),1,1,'C');

  $fpdf->SetFont('Arial','',10);
  if(count($ticketsGroupedByCreatedAt)>0){
  for ($i = 0; $i < count($ticketsGroupedByCreatedAt); $i++) {


      $fpdf->Cell(20 ,6,$i+1,1,0);
      $fpdf->Cell(60 ,6, date('d/m/Y', strtotime($ticketsGroupedByCreatedAt[$i]->date))  ,1,0,'C');
      $fpdf->Cell(60 ,6, utf8_decode($ticketsGroupedByCreatedAt[$i]->nbr_tickets) ,1,0,'C');
    //  $fpdf->Cell(40 ,6, utf8_decode($ticketsGroupedByCreatedAt[$i]->NOMBRE_TOTAL_BAGAGE) ,1,0);
      $fpdf->Cell(50 ,6,$ticketsGroupedByCreatedAt[$i]->prix,1,1,'C');

  }
  $fpdf->SetFont('Arial','B',10);
  $fpdf->Cell(20 ,10,'',0,0);
  $fpdf->Cell(60 ,10,'Total ',1,0);
  $fpdf->Cell(60 ,10,$ticketsGroupedByCreatedAt->sum('nbr_tickets'),1,0,'C');
  $fpdf->Cell(50 ,10,$ticketsGroupedByCreatedAt->sum('prix'),1,1,'C');
  }



    $fpdf->Output();
    exit;
}

public function ImpressionTicket()
{
    $Infobagagepayes = session('Infobagagepayes');
    dd($Infobagagepayes);
}




}
