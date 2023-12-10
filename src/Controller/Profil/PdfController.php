<?php
namespace App\Controller\Profil;

use Editiel98\Graph\Graph;
use Editiel98\Manager\StatsManager;
use Editiel98\Pdf\PDFCreator;
use Editiel98\Router\Controller;
use Editiel98\Session;
use Exception;

class PdfController extends Controller
{
    const LIMIT_NUMBER = 5;
    private PDFCreator $pdf;
    private string $subDir;

    public function render()
    {
        if(!$this->isConnected){
        //Render antoher page and die
            $this->smarty->assign('profil','profil');
            $this->smarty->display('profil/notconnected.tpl');
            die();
        }
        $baseDir=dirname(dirname(dirname(__DIR__)));
        $subDir=$baseDir . '/public/assets/uploads/users/' . $this->userId .'/stats/';
        $this->subDir=$subDir;
        $this->manageDir();
        //Get Datas
        $statsManager=new StatsManager($this->dbConnection);
        $periods=$statsManager->getStatPeriod($this->userId);
        $statsStock=$statsManager->getStatState($this->userId);
        $categories=$statsManager->getStatCategory($this->userId);
        $providers=$statsManager->getStatProvider($this->userId);
        $providersUpdate=[];
        foreach($providers as $p){
            if (is_null($p->name)){
                $p->name='non renseignés';
            }
            $providersUpdate[]=$p;
        }
        $scales=$statsManager->getStatScale($this->userId);
        $brands=$statsManager->getStatBrand($this->userId);
        $brandsReduced=$this->reduceArray($brands);
        $models=$statsManager->getStatModels($this->userId);

        //Generate graph
        $isPeriod=$this->drawGraph($periods, 'Répartition par périodes', 'periodgraph');
        $isCategory=$this->drawGraph($categories, 'Répartition par catégories', 'categorygraph');
        $isProvider=$this->drawGraph($providers, 'Répartition par fournisseurs', 'providergraph');
        $isScale=$this->drawGraph($scales, 'Répartition par échelles', 'scalegraph');
        $isBrand=$this->drawGraph($brandsReduced, 'Répartition par marques', 'brandgraph');
        $isStock=$this->drawGraph($statsStock, 'Répartition par état', 'stategraph');

        $fullname= $this->session->getKey(Session::SESSION_FULLNAME);
        $this->pdf= new PDFCreator($this->subDir . 'stats.pdf',$fullname);
        $this->pdf->AliasNbPages();
        $this->pdf->addToSummary(1,'Données chiffrées');
        $this->pdf->addToSummary(2,'Liste des modèles');
        $this->pdf->addToSummary(3,'Statistiques graphiques');

        $this->pdf->createSummaryPage();
        
        $this->pdf->addPageDoc();
        $this->pdf->setTitlePage("Données chiffrées", 1);
        $this->pdf->Newcell(0,0,"Données référencées : ",15);
        $this->pdf->SetFont('','');
        foreach($statsStock as $v){
            $this->pdf->Newcell(0,0,"Kit {$v->name} : {$v->count}",25,5);
        }
        $this->pdf->setY($this->pdf->GetY()+15);
        $this->pdf->Newcell(0,0,"Répartition du stock par critères");
        //Periods
        
        $this->addBlocs($periods,"Répartition par périodes");
        
        $this->addBlocs($categories,"Répartition par catégories");
       
        $this->addBlocs($providersUpdate,"Répartition par fournisseurs");
       
        $this->addBlocs($scales,"Répartition par échelles");
        
        $this->addBlocs($brands,"Répartition par marques");
        $price=$statsManager->getStatPrice($this->userId);
        $this->pdf->Newcell(0,0,"Coût total du stock (suivant les informations fournies) {$price[0]->sum} euros");
        $this->pdf->addPageDoc();
        $this->pdf->setTitlePage("Liste des modèles",2);
       
        foreach($models as $model){
            $this->AddModelBoc($model);
        }
        //Camemberts
        $this->pdf->addPageDoc();
        $this->pdf->setTitlePage("Statistiques graphiques",3);
        
        if ($isPeriod) {
            while(!file_exists($this->subDir . 'periodgraph.png'));
            $this->addStatraph('periodgraph');
        }
        if ($isCategory) {
            while(!file_exists($this->subDir . 'categorygraph.png'));
            $this->addStatraph('categorygraph');
        }
        if ($isProvider) {
            while(!file_exists($this->subDir . 'providergraph.png'));
            $this->addStatraph('providergraph');
        }        
        if ($isScale) {
            while(!file_exists($this->subDir . 'scalegraph.png'));
            $this->addStatraph('scalegraph');
        }        
        if ($isBrand) {
            while(!file_exists($this->subDir . 'brandgraph.png'));
            $this->addStatraph('brandgraph');
        }        
        if ($isStock) {
            while(!file_exists($this->subDir . 'stategraph.png'));
            $this->addStatraph('stategraph');
        }        
        //ouput
        $result=$this->pdf->storePdf();
        if($result){
            $this->displayPage('assets/uploads/users/' . $this->userId .'/stats/stats.pdf');
        }else{
            $this->displayPage('');
        }
    }

    private function addBlocs(array $infos, string $title)
    {
        $this->pdf->SetFont('','U');
        $this->pdf->Newcell(0,0,$title,15,7);
        $this->pdf->SetFont('','');
        foreach($infos as $p){
            $this->pdf->Newcell(0,0,"{$p->name} : {$p->count}",25,5);
        }
        $this->pdf->setY($this->pdf->GetY()+10);
    }

    private function AddModelBoc(object $model)
    {
        $baseDir=dirname(dirname(dirname(__DIR__)));
        $subDir=$baseDir . '/public/assets/uploads/models/';
        if (is_null($model->boxPicture) || $model->boxPicture===''){
            $pictureDir=$subDir . 'no_image.jpg';
        } else{
            $pictureDir=$baseDir .'/public/' .$model->boxPicture;
        }
        $this->pdf->setModelBock($model,$pictureDir);
    }

    public function addStatraph(string $filename)
    {
        $file=$this->subDir.$filename . '.png';
        $this->pdf->Image($file,15,null,140);
        $this->pdf->Ln(20);

    }

    private function drawGraph(array $stat, string $title, string $filename): bool
    {
        $file=$this->subDir.$filename . '.png';
        if (empty($stat)) {
            return false;
        }
        $values = [];
        foreach ($stat as $v) {
            $name = $v->name;
            if (is_null($name)) {
                $name = 'autres';
            }
            $values[$name] = $v->count;
        }
        try {
            $graph = new Graph($file,400,200,false);
            $graph->draw($values, $title);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    private function reduceArray(array $array): array
    {
        $tempArray = [];
        $count = 0;
        foreach ($array as $v) {
            if ($v->count < self::LIMIT_NUMBER) {
                $count += $v->count;
            } else {
                $tempArray[]=$v;
            }
        }
        $tempArray[]=(object)['count'=>$count,'name'=>'autres'];
        return $tempArray;
    }

    private function manageDir()
    {
        $folder =$this->subDir;
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        } else {
            $files = glob($folder . '*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                }
            }
        }
    }

    private function displayPage($filename){
        $this->smarty->assign('profil',true);
        $this->smarty->assign('pdf_menu',true);
        if($filename!==''){
            $this->smarty->assign('filepath',$filename);
        }
        $this->smarty->display('profil/statspdf.tpl');
    }
}