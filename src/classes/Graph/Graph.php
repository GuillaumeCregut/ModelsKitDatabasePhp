<?php

namespace Editiel98\Graph;

use Exception;

require_once('lib/jpgraph.php');
require_once('lib/jpgraph_pie.php');

/**
 * Create a pie graph and save it to file
 */
class Graph 
{
    /**
     * filename : Name and path of file to save
     *
     * @var string
     */
    private string $filename;

    /**
     * Width : Width of picture. Default 400px
     *
     * @var integer
     */
    private int $width;

    /**
     * Height of picture. Default 200px
     *
     * @var integer
     */
    private int $height;
    private \PieGraph $graph;

    /**
     * __Construct
     *
     * @param string $filename : path for file
     * @param integer|null $width : width of picture
     * @param integer|null $height : height of picture
     */
    public function __construct(string $filename, ?int $width=400, ?int $height=200)
    {
        $this->height=$height;
        $this->width=$width;
        $this->filename=$filename;
        $graph = new \PieGraph($this->width, $this->height, 'auto');
        $graph->clearTheme();
        $graph->SetAlphaBlending();
        $graph->SetMarginColor('white@0.99');
        $this->graph=$graph;
    }

    /**
     * Draw a pie chart with supplied datas and save it to file
     *
     * @param array $datas array of datas, [title=>value]
     * @param string $title title of the pie
     * @return void
     */
    public function draw(array $datas, string $title)
    {
        try{
            $pie=$this->drawPie($datas, $title);
            $this->graph->Add($pie);
            return $this->graph->Stroke($this->filename);
        }catch(\JpGraphExceptionL $e){
            throw new Exception($e->getMessage());
        }catch(\JpGraphException $e){
            throw new Exception($e->getMessage());
        }
    }

    /**
     * draw a pie
     *
     * @param array $DataValues : datas to draw;
     * @param string $title : title of the pie
     * @param float|null $size : size of the pie (0-1) or in pixel
     * @param float|null $x : horizontal position of the pie in the picture
     * @param float|null $y : vertical position of the pie in the picture
     * @return \PiePlot : object representing the drawn pie
     */
    private function drawPie(array $DataValues, string $title, ?float $size=0.3, ?float $x=0.3, ?float $y=0.5): \PiePlot
    {
        $values=[];
        $names=[];
        
        foreach($DataValues as $k=>$v){
            $names[]=$k;
            $values[]=$v;
        } 
        $p1 = new \PiePlot($values);
        $p1->SetSize($size);
        $p1->SetCenter($x,$y);
        $p1->SetLegends($names);
        $p1->title->Set($title);
        return $p1;
    }
}
