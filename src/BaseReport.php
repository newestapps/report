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
     * @param bool $renderOnCreate
     */
    public function __construct($renderOnCreate = true)
    {
        if ($renderOnCreate) {
            $this->render($this->handleData());
        }
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
        $this->pdf = app('dompdf.wrapper');
        $this->pdf->loadView($this->getFullViewPath(), $data);
        $this->afterRender($this->pdf);
    }

    public function stream($filename = 'document.pdf')
    {
        return $this->pdf->stream($filename);
    }

    public function save($filename)
    {
        return $this->pdf->save($filename);
    }

    public function download($filename)
    {
        return $this->pdf->download($filename);
    }

    public function outputAsString()
    {
        return $this->pdf->output();
    }

    public function getFullViewPath()
    {
        return "{$this->view}";
    }

    protected function configurePaper(PDF $pdf)
    {
        $pdf->setPaper('A4', 'portrait');
    }

}