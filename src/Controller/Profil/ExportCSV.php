<?php

namespace App\Controller\Profil;

use Editiel98\App;
use Editiel98\Manager\ModelManager;
use Editiel98\Router\Controller;
use Exception;

class ExportCSV extends Controller
{
    public function render()
    {
        if ($_SERVER['REQUEST_METHOD']==='POST') {
            $this->usePost();
        }
        $this->displayPage();
    }

    private function displayPage()
    {
        $this->smarty->assign('profil', true);
        $this->smarty->assign('csv_menu', true);
        $this->smarty->display('profil/statscsv.tpl');
    }

    private function usePost(): void
    {
        $includesState = [];
        $separatorChoice = intval($_POST['separator']);
        $separator = ';';
        if ($separatorChoice === 1) {
            $separator = ',';
        }
        $orderChoice = intval($_POST['order']);
        switch ($orderChoice) {
            case 1: $order='brandName';
                break;
            case 2:  $order='builderName';
                break;
            case 3:  $order='ScaleName';
                break;
            case 4:  $order='categoryName';
                break;
            case 5:  $order='countryName';
                break;
            case 6:  $order='periodName';
                break;
            default:  $order='brandName';

        }
        if (isset($_POST['cb_finished'])) {
            $includesState[] = App::STATE_FINISHED;
        }
        if (isset($_POST['cb_like'])) {
            $includesState[] = App::STATE_LIKED;
        }
        if (isset($_POST['cb_order'])) {
            $includesState[] = App::STATE_BUY;
        }
        if (isset($_POST['cb_stock'])) {
            $includesState[] = App::STATE_STOCK;
        }
        if (isset($_POST['cb_wip'])) {
            $includesState[] = App::STATE_WIP;
        }
        $modelModel=new ModelManager($this->dbConnection);
        try {
            //Create file
            $dirname=dirname(dirname(dirname(__DIR__))) . '/public/assets/uploads/users/'. $this->userId . '/';
            $filename=$dirname . 'export.csv';
            $file=fopen($filename,'w');
            $header=[
                'Position',
                'Nom',
                'Marque',
                'Référence',
                'Catégorie',
                'Pays',
                'Echelle',
                'Période',
                'Lien scalemates',
                'Fournisseur',
                'Prix',
            ];
            fputcsv($file, $header,$separator,"\"","\\","\n");
            //Insert header in file
            foreach ($includesState as $state) {
                //get item
                $items=$modelModel->getUserItemForCSV($state,$order,$this->userId);
                //for each item insert item
                foreach($items as $item) {
                    $itemArray=[];
                    $itemArray[]=$item->stateName;
                    $itemArray[]=$item->builderName . ' '.$item->modelName;
                    $itemArray[]=$item->brandName;
                    $itemArray[]=$item->reference;
                    $itemArray[]=$item->categoryName;
                    $itemArray[]=$item->countryName;
                    $itemArray[]=$item->scaleName;
                    $itemArray[]=$item->periodName;
                    $itemArray[]=$item->scalemates ?? '-';
                    $itemArray[]=$item->providerName ?? '-';
                    $itemArray[]=$item->price ?? '-';
                    fputcsv($file, $itemArray,$separator,"\"","\\","\n");
                }
            }
            if (file_exists($filename)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename='.basename($filename));
                header('Content-Transfer-Encoding: binary');
                header('Expires: 0');
                header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                header('Pragma: public');
                header('Content-Length: ' . filesize($filename));
                ob_clean();
                flush();
                readfile($filename);
                exit;
            }
        } catch (Exception $e) {
           
        } finally{
            fclose($file);
        }
    }
}
