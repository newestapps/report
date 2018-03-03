# Template: Basic Invoice 1 

Template for generating basic invoices with a list of items.

OSB: *All options are optional, the template will adjust among all this properties. All available properties are listed below, with examples.*

```php
    $id = 123456;

    $invoice = new \Newestapps\Report\Templates\BasicInvoice1( $id );
    $invoice->useNewestappsLogo(); // To use Newestapps Logo..
    
    // Or specify a custom image Path or Url, to use as logo.
    // $invoice->setLogo('https://99designs-blog.imgix.net/blog/wp-content/uploads/2016/07/logo-2.png?auto=format&q=60&fit=max&w=930');
    
    // Set a reference code for this invoice, this can be another code (or your ID again)
    // The second parameter, is a boolean indicating if you want to print a Barcode with this reference code on 
    // invoice footer
    // The third parameter, is the Barcode type (default is: CODE 128).
    $report->setReference('98231879312789123', true);

    $invoice->setCreatedAt(\Carbon\Carbon::now()->subDays(10));
    
    $invoice->setFinishedAt(\Carbon\Carbon::now()->subDays(4));

    $invoice->setCustomer([
        'id' => 12312,
        'name' => 'Rodrigo Brun',
        'email' => 'myemail@something.com',
        'address' => 'My amazing street of packages - n1234 - Brazil'
    ]);
    
    // Or set customer via params  ( $id, $name = null, $email = null, $address = null )
    // $this->setCustomer(12345, 'Rodrigo Brun', 'myemail@something.com', 'My amazing street of packages - n1234 - Brazil');
    
    
    // Add a invoice items...
    $invoice->addItem([
        'id' => 1,
        'name' => 'Hospedagem de site #1',
        'value' => 55.9,
        'quantity' => 1,
    ]);
    
    // Or also via params ( $id, $name = null, $value = 0, $quantity = 1 )
    // $invoice->addItem(1, 'Hospedagem de site #1', 55.9, 1);
    
    // OBS: Total Amount, Sub Total are calculated automatically when you add items to your invoice, but, you can override
    // this values, just using their set methods. ( $invoice->setTotalAmount(1234) )
    
    // Add a free content here for section 'Observações'
    $invoice->setNotes('<p>Anything here</p> (Supports HTML) ');
    
    // Render your Invoice
    $renderedInvoice = $invoice->renderInvoice();
  
    // Output Types
    
    $renderedInvoice->stream($filename = 'my-invoice.pdf');  // Returns your PDF as a page content, with all proper header settings (your browser will display the document)  
    // $renderedInvoice->download($filename = 'my-invoice.pdf');  // Forces download of your PDF document, named with your '$filename'  
    // $renderedInvoice->outputAsString();  // Gets a full string of your PDF (ideal for directly email attachments, for example)  
    // $renderedInvoice->save($filename = 'invoices/my-invoice.pdf');  // Save your invoice as a file in your '$filename' location, (you can specify a full path for somewhere in your disk)  
```
