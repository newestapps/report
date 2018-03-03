<?php
/**
 * Created by rodrigobrun
 *   with PhpStorm
 */

namespace Newestapps\Report\Templates;

use Carbon\Carbon;
use Newestapps\Report\BaseReport;
use Picqer\Barcode\BarcodeGenerator;

class BasicInvoice1 extends BaseReport
{

    private $customer = [];

    private $items = [];

    private $totalAmount = 0;

    private $title = 'Invoice';

    private $logoUrl = null;

    private $createdAt = null;

    private $finishedAt = null;

    private $reference = null;

    private $attachBarcode = false;

    private $barcodeType = BarcodeGenerator::TYPE_CODE_128;

    private $extraFees = 0;

    private $notes = null;

    protected $view = 'nw-report::templates.basic-invoice-1.basic-invoice-1';

    private $id;

    /**
     * BasicInvoice1Report constructor.
     * @param bool $id
     * @param array $items
     * @param array $customer
     */
    public function __construct($id, $items = [], $customer = [])
    {
        $this->id = $id;
        $this->items = $items;
        $this->customer = $customer;
        $this->createdAt = Carbon::now();

        parent::__construct(false);
    }

    public function addItem($id, $name = null, $value = 0, $quantity = 1)
    {
        if (is_array($id)) {
            $this->items[] = [
                'id' => (isset($id['id']) ? ($id['id']) : null),
                'name' => (isset($id['name']) ? ($id['name']) : null),
                'value' => (isset($id['value']) ? ($id['value']) : 0),
                'quantity' => (isset($id['quantity']) ? ($id['quantity']) : 1),
            ];

            $this->totalAmount += ((isset($id['value']) ? ($id['value']) : 0))
                * (isset($id['quantity']) ? ($id['quantity']) : 1);

        } else {
            $this->items[] = [
                'id' => $id,
                'name' => $name,
                'value' => $value,
                'quantity' => $quantity,
            ];

            $this->totalAmount += $value * $quantity;
        }


        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return null
     */
    public function getLogo()
    {
        return $this->logoUrl;
    }

    /**
     * @param null $logoUrl
     * @return $this
     */
    public function setLogo($logoUrl)
    {
        if (filter_var($logoUrl, FILTER_VALIDATE_URL)) {
            $this->logoUrl = $logoUrl;
        } else {
            $this->logoUrl = asset($logoUrl);
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getTotalAmount(): int
    {
        return $this->totalAmount;
    }

    /**
     * @param int $totalAmount
     * @return $this
     */
    public function setTotalAmount(int $totalAmount)
    {
        $this->totalAmount = $totalAmount;

        return $this;
    }

    /**
     * @param \DateTime|null|static $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt = null)
    {
        $this->createdAt = ($createdAt === null) ? (Carbon::now()) : ($createdAt);
    }

    /**
     * @return null
     */
    public function getFinishedAt()
    {
        return $this->finishedAt;
    }

    /**
     * @param \DateTime|null $finishedAt
     * @return $this
     */
    public function setFinishedAt(\DateTime $finishedAt = null)
    {
        $this->finishedAt = $finishedAt;

        return $this;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param array $items
     * @return $this
     */
    public function setItems(array $items = [])
    {
        $this->items = $items;

        return $this;
    }

    /**
     * @return array
     */
    public function getCustomer(): array
    {
        return $this->customer;
    }

    /**
     * @param int|array $id
     * @param null $name
     * @param null $email
     * @param null $address
     * @return $this
     * @internal param array $customer
     */
    public function setCustomer($id, $name = null, $email = null, $address = null)
    {
        if (is_array($id)) {
            $this->customer = [
                'id' => (isset($id['id']) ? ($id['id']) : null),
                'name' => (isset($id['name']) ? ($id['name']) : null),
                'email' => (isset($id['email']) ? ($id['email']) : null),
                'address' => (isset($id['address']) ? ($id['address']) : null),
            ];
        } else {
            $this->customer = [
                'id' => $id,
                'name' => $name,
                'email' => $email,
                'address' => $address,
            ];
        }

        return $this;
    }

    public function renderInvoice()
    {
        $this->render($this->handleData());

        return $this;
    }

    /**
     * @return null
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param null $reference
     * @param bool $attachBarcode
     * @param string $barcodeType
     * @return $this
     */
    public function setReference($reference, $attachBarcode = false, $barcodeType = BarcodeGenerator::TYPE_CODE_128)
    {
        $this->reference = $reference;
        $this->attachBarcode = $attachBarcode;
        $this->barcodeType = $barcodeType;

        return $this;
    }

    /**
     * @return null
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @param null $notes
     * @return $this
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param bool $id
     * @return $this
     */
    public function setId(bool $id)
    {
        $this->id = $id;

        return $this;
    }

    public function useNewestappsLogo()
    {
        $this->logoUrl = __DIR__.'/../../resources/images/newestapps-logo-invoice.png';
    }

    /**
     * Manipulate data before render
     *
     * @return array
     */
    protected function handleData()
    {
        return [
            'id' => $this->id,
            'reference' => $this->reference,
            'title' => $this->title,
            'customer' => $this->customer,
            'items' => $this->items,
            'logoUrl' => $this->logoUrl,
            'createdAt' => $this->createdAt,
            'finishedAt' => $this->finishedAt,
            'notes' => $this->notes,
            'attachBarcode' => $this->attachBarcode,
            'barcodeType' => $this->barcodeType,
            'extraFees' => (!is_numeric($this->extraFees)) ? (0) : ($this->extraFees),
            'totalAmount' => (!is_numeric($this->totalAmount)) ? (0) : ($this->totalAmount),
        ];
    }
}