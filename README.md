# Newestapps Report Generator

A package for generating reports in PDF, from blade view files, like you already do with your controllers.

A series of pre-defined templates are available, with all logic for data fill, to generate fast-ready reports, like Invoices, Letters, etc. (see below)

# List of templates built-in

- [Basic Invoice #1](docs/basic-invoice-1.md)

# Creating custom template

You can create your own templates, just creating a view, like you usually do in your laravel controllers. 

Just create your own class that extends from `Newestapps\Report\BaseReport`, and override the field `protected $view = 'your view name in your resources folder'`;

We also provide a basic structure for you to create custom templates (all built-in templates are built in front of this structure). In your view, just extend from our base template `nw-report::layouts.base`, and create a section `content` with your report content. See an example below, with all available formatting settings.

```
@extends('nw-report::layouts.base', [
    // Margins for the document
    'marginLeft' => '20px',
    'marginTop' => '20px',
    'marginRight' => '20px',
    'marginBottom' => '20px',
    
    // Full page background (all pages, support image background also)
    'pageBackground' => 'blue',
    
    // Global style for all pages, a list of CSS attributes to apply to your body tag
    'bodyStyle' => [
        'color' => 'white',
        // Any key-pair of CSS here
    ]
])

{{--Page title, if you want to display your report as HTML--}}
@section('title', 'Hello World Report')

{{--Your content section--}}
@section('content')

    Your report contents goes here

@endsection
```