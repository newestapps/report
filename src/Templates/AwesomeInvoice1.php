<?php
/**
 * Created by rodrigobrun
 *   with PhpStorm
 */

namespace Newestapps\Report\Templates;

class AwesomeInvoice1 extends BasicInvoice1
{

    protected $color = '#D22424';

    protected $view = 'nw-report::templates.awesome-invoice-1.awesome-invoice-1';

    public function useNewestappsLogo()
    {
        $this->logoUrl = __DIR__.'/../../resources/images/newestapps-logo-invoice-colored.png';

        return $this;
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * @param string $color
     * @return mixed
     */
    public function setColor(string $color)
    {
        $this->color = $color;

        return $this;
    }

    protected function handleData()
    {
        return array_merge([
            'color' => $this->color,
        ], parent::handleData());
    }

}