<?php
namespace Editiel98\Pdf;

use DateTime;
use Editiel98\Event\Emitter;
use Exception;

require_once 'fpdf.php';

class PDFCreator extends \FPDF
{
    private string $filename;
    private array $myLinks=[];
    private string $userName;

    public function __construct(string $filename, string $userName)
    {
        parent::__construct();
        $this->filename=$filename;
        $this->userName=$userName;
        $this->SetAuthor('Editiel98',true);
        $this->SetSubject('Catalogue de collection de maquettes', true);
        $this->SetCreator('Models Kit Database', true);
        $this->AddFont('Pacifico-Regular','');
        $this->CreateFirstPage();
        $this->SetFont('Times','',12);      
    }

    public function createSummaryPage()
    {
        $this->AddPage();
        $this->SetFontSize(20);
        $this->SetFont('','U');
        $this->Newcell(0,0,'Sommaire',0,0,'C');
        $this->SetFontSize(12);
        $this->SetFont('','');
        $this->setXY(0,$this->GetY()+20);
        foreach($this->myLinks as $page=>$pageInfo){
            $this->Newcell(0,10,"{$pageInfo->pageName}",10,10);
        }
    }

    public function addToSummary(int $idPage, string $pageName){
        
       $link=$this->AddLink();
       $line=(object)['numPage'=>$idPage,'link'=>$link,'pageName'=>$pageName];
       $this->myLinks[$idPage]=$line;
       
    }

    public function addPageDoc(?string $font='Times', ?int $fontSize=12)
    {
        $this->AddPage();
        $this->SetFont($font,'',$fontSize);
        $this->SetTextColor(0,0,0);
    }

    private function CreateFirstPage()
    {
       $image=dirname(dirname(dirname(__DIR__))) . '/public/assets/pictures/logo2.png';
        $this->AddPage();
       $this->Image($image,10,10,60);
       $this->SetFont('Pacifico-Regular','',48);
       $this->SetTextColor(145,44,81);
       $this->setXY(80,20);
       $this->MultiCell(0,20,'Models Kit',0,0,'C', false);
       $this->setXY(90,50);
       $this->MultiCell(0,20,'Database',0,0,'C', false);
       $this->SetTextColor(0,0,0);
       $this->SetFont('Times','',50);  
       $this->setXY(0,100);
       $this->cell(0,20,'Statistiques du stock',0,1,'C', false);
       $date=new DateTime();
       $this->SetFontSize(40);
       $this->cell(0,20,"En date du {$date->format('d/m/Y')}",0,1,'C', false);
       $this->SetFontSize(30);
       $this->Newcell(0,20,$this->userName,0,null,'C');
    }

    public function setTitlePage(string $title, int $idPage)
    {
        $this->SetFontSize(20);
        $this->SetFont('','U');
        $this->Newcell(0,0,$title,0,0,'C');
        $this->SetFontSize(12);
        $this->SetFont('','');
        $this->setXY(0,$this->GetY()+20);
        foreach($this->myLinks as $link){
            if ($idPage===$link->numPage){
                $this->SetLink($link->link,0,$this->pageNo());
            }
        }
    }

    public function Newcell(int $w, int $h=0, $txt='', ?int $offset=0,?int $space=10 ,?string $align='', ?int $border=0, ?int $ln=0,  ?bool $fill=false,?string $link='')
    {
        $ln=1;
        if($offset>0){
            parent::SetX($offset);
        }
        $translateTxt=mb_convert_encoding($txt, 'windows-1252', 'UTF-8');
        parent::Cell($w, $h,$translateTxt,$border,$ln,$align,$fill,$link);
        parent::Ln($space);
    }

    public function MultiCell($w, $h, $txt, $border = 0, $align = 'J', $fill = false)
    {
        $translateTxt=$txt;
        // $translateTxt=mb_convert_encoding($txt, 'windows-1252', 'UTF-8');
        parent::MultiCell($w, $h, $translateTxt, $border = 0, $align = 'J', $fill = false);
    }

    public function Footer()
    {
       // $nbpage=intval()$this->AliasNbPages-1;
        if($this->PageNo()!==1){
            $this->SetY(-15);
            // Police Arial italique 8
            $this->SetFont('Arial','I',8);
            // Numéro de page
            $this->Cell(0,10,'(c)2023 Editiel98 - G.Cregut' ,0,0,'L');
            $pages=$this->PageNo()-1;
            $this->Cell(0,15,$pages ,0,0,'C');
        }
    }

    public function setModelBock(object $model, string $filename)
    {
        if($this->GetY()+40>$this->GetPageHeight()){
            $this->addPageDoc();
        }
        $this->SetX(0);
        $mainOffset=10;
        $this->SetFontSize(20);
        $this->Newcell(0,0,"{$model->builderName} {$model->modelName}",$mainOffset,2,'C'); 
        $x=$this->GetX();
        $y=$this->GetY();       
        $this->SetFontSize(12);
        $this->ln(9);
        $this->Newcell(0,0,"Echelle : {$model->scaleName}",$mainOffset,2,'C' );
        $this->Newcell(0,8,"Marque : {$model->brandName}",$mainOffset,2,'C' );
        $this->Newcell(0,0,"Référence : {$model->reference}",$mainOffset,2,'C' );
        $this->Newcell(0,8,"Etat : {$model->stateName}",$mainOffset,2,'C' );
        $lastY=$this->GetY();
        $this->SetY($y);
        $this->Image($filename,null,null,40);
        $this->SetY($lastY);
        $this->ln(30);
    }

    public function storePdf(){
        try{
            $this->Output('F',$this->filename);
            return true;
        } catch(Exception $e){
            $emitter=Emitter::getInstance();
            $emitter->emit(Emitter::PDF_CREATOR,'pdf creation : ' .$e->getMessage());
            return false;
        }
    }
}