<?php

namespace Arrumai\Reports;

use Newestapps\Report\BaseReport;

class MechanicCustomersRelationListReport extends BaseReport {

    const DOC_ID = 'mechanic_customer_relation_list';

    /** @var string */
    protected $view = self::DOC_ID;

    /** @var Mechanic */
    private $mechanic;

    /** @var int */
    private $month;

    /** @var int */
    private $year;

    /**
     * MechanicCustomersRelationList constructor.
     * @param Mechanic $mechanic
     * @param null $baseMonth
     */
    public function __construct(Mechanic $mechanic, $baseMonth = null) {
        $this->mechanic = $mechanic;

        if ($baseMonth === null) {
            $this->month = date('m');
        }else{
            $this->month = $baseMonth;
        }

        $this->year = date('Y');

        parent::__construct();
    }

    /**
     * Manipulate data before render
     *
     * @return array
     * @throws \InvalidArgumentException
     */
    protected function handleData() {
        $data = [
            'mechanic' => $this->mechanic,
            'month' => $this->month,
            'year' => $this->year,
        ];

        // Find all NEW customers for mechanic.
        $data['newCustomers'] = Customer::whereMechanic($this->mechanic->id)
            ->whereBetween('created_at', [
                "{$this->year}-{$this->month}-01 00:00:00",
                "{$this->year}-{$this->month}-31 23:59:59"
            ])
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        // Obtem a lista de todos os clientes, exceto os deste mês (por que estão em "Novos Clientes")
        $data['oldCustomers'] = Customer::whereMechanic($this->mechanic->id)
            ->where('created_at', '<=', "{$this->year}-{$this->month}-01 00:00:00")
            ->orderBy('created_at', 'desc')
            ->with('user')
            ->get();

        $data['hasOldCustomers'] = count($data['oldCustomers']);
        $data['hasNewCustomers'] = count($data['newCustomers']);

        return $data;
    }

}