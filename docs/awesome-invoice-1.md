# Template: Awesome Invoice #1 

Template for generating a very stylized look Invoice.

OSB: *All options are optional, the template will adjust among all this properties. All available properties are listed below, with examples.*

```php

    $id = 123456;

    $invoice = new \Newestapps\Report\Templates\AwesomeInvoice1($id);
//    $invoice->useNewestappsLogo(); // To use Newestapps Logo..

    $invoice->setColor('#0073ea');

    // Or specify a custom image Path or Url, to use as logo.
    $invoice->setLogo(public_path('arrumai.png'));

    // Set a reference code for this invoice, this can be another code (or your ID again)
    // The second parameter, is a boolean indicating if you want to print a Barcode with this reference code on
    // invoice footer
    // The third parameter, is the Barcode type (default is: CODE 128).
    $invoice->setReference('123123124151', true);

    $invoice->setCreatedAt(\Carbon\Carbon::create(2015, 8, 12));

    $invoice->setFinishedAt(\Carbon\Carbon::create(2018, 12, 12));

    $invoice->setCustomer([
        'id' => 8762,
        'name' => 'Mecânica Potiguar',
        'email' => 'potiguar@mecanica.com',
        'address' => 'R. das Missões, 920 - Foz do Iguaçu - PR, 85851-240',
    ]);

    // Or set customer via params  ( $id, $name = null, $email = null, $address = null )
    // $this->setCustomer(12345, 'Rodrigo Brun', 'myemail@something.com', 'My amazing street of packages - n1234 - Brazil');

    $invoice->setCompany([
        'name' => 'Arrumaí',
        'email' => 'contato@arrumai.com.br',
        'website' => 'www.arrumai.com.br',
        'phone' => '+55 45 99909-5136',
    ]);

    // Or set via params ( $name = null, $email = null, $address = null, $website = null, $phone = null )
    // $this->setCompany('Arrumaí', 'contato@arrumai.com.br', 'www.arrumai.com.br', 'Your office address here', '+55 45 99909-5136');

    // Add a invoice items...
    for ($i = 0; $i <= 5; $i++) {

        $invoice->addItem([
            'id' => 1,
            'name' => 'Plano latão',
            'value' => 55.9,
            'quantity' => 1,
        ]);

    }

    // Or also via params ( $id, $name = null, $value = 0, $quantity = 1 )
    // $invoice->addItem(1, 'Hospedagem de site #1', 55.9, 1);

    // OBS: Total Amount, Sub Total are calculated automatically when you add items to your invoice, but, you can override
    // this values, just using their set methods. ( $invoice->setTotalAmount(1234) )

    // Add a free content here for section 'Observações'
    $invoice->setNotes('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt uion ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');

    // Render your Invoice
    $renderedInvoice = $invoice->renderInvoice();

    // Output Types

    return $renderedInvoice->stream($filename = 'my-invoice.pdf');  // Returns your PDF as a page content, with all proper header settings (your browser will display the document)
    // $renderedInvoice->download($filename = 'my-invoice.pdf');  // Forces download of your PDF document, named with your '$filename'
    // $renderedInvoice->outputAsString();  // Gets a full string of your PDF (ideal for directly email attachments, for example)
    // $renderedInvoice->save($filename = 'invoices/my-invoice.pdf');  // Save your invoice as a file in your '$filename' location, (you can specify a full path for somewhere in your disk)
  
```

# Demo

![Demo Awesome Invoice #1](awesome-invoice-1-demo.png)




