<?php

namespace Newestapps\Report;

use Barryvdh\DomPDF\PDF;

abstract class BaseReport
{

    const DOC_ID = 'report';

    /** @var string */
    protected $view = '';

    /** @var array */
    protected $data = [];

    /** @var PDF */
    private $pdf = null;

    /**
     * Report constructor.
     */
    public function __construct()
    {
        $this->render($this->handleData());
    }

    /**
     * Manipulate data before render
     *
     * @return array
     */
    protected abstract function handleData();

    /** Called before loadView
     *
     * @param PDF $pdf
     */
    protected function afterRender(PDF $pdf)
    {
        $this->configurePaper($pdf);
    }

    /**
     * @param $data
     */
    protected function render($data)
    {
        $this->pdf = App::make('dompdf.wrapper');
        $this->pdf->loadView($this->getFullViewPath(), $data);
        $this->afterRender($this->pdf);
    }

    public function stream()
    {
        return $this->pdf->stream();
    }

    public function getFullViewPath()
    {
        return "reports.{$this->view}";
    }

    private function configurePaper(PDF $pdf)
    {
        $pdf->setOrientation('portrait');
        $pdf->setPaper('a4');
    }

}