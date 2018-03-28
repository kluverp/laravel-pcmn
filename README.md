# laravel-pcmn
laravel-pcmn is a simple yet powerful CMS you can use to manage your sites' content.
The CMS is a 'programmers' CMS, which means you have to build your site yourself using your favorite framework: Laravel.
The content however can easily be managed with this CMS. 

All you need to do is focus on your application, the hassle of managing the content is done by PCMN!

PCMN is designed to be as invisible as possible, meaning it won't interfere with the way you build your site or application.


## Installation

Require this package with composer. It is recommended to only require the package for development.

```shell
Composer require "kluverp/laravel-pcmn": "dev-master"
```

```shell
Add the following to youer composer.json:
"repositories": [
    {
        "type": "vcs",
        "url": "git://github.com/kluverp/laravel-pcmn.git"
    }
]
```

Add the ServiceProvider to the providers array in config/app.php

```php
'pcmn' => \Kluverp\Pcmn\Providers\PcmnServiceProvider::class
```

Add the Pcmn Middleware the the /app/Http/Kernel.php file in the $routeMiddleware array:
```php
'pcmn' => \Kluverp\Pcmn\Middleware\Pcmn::class
```

Publish the assets

```shell
php artisan vendor:publish --provider="Kluverp\Pcmn\Providers\PcmnServiceProvider" --tag=public
```

Run the migrations
```shell
php artisan migrate
```

## Configuration 

### Table config

### Title
The title field consists of two entries *singular* and *plural*. The plural version is shown on index pages. This page consists of a datatable with an overview of all underlying records. Hence the plural form.
The singular field is used on a single record, when editing a record. This screen is shown as a form.

### Description
The description field is used to show a descriptive text above the datatable and the form. This should be a short text informing the user at what data he is looking. 

### Permissions
These are boolean values indicating what CRUD actions are allowed and what actions are not. 
Sometimes you do not want a user to be able to remove a record. For instance when a records holds the texts for a 'homepage', you do not want the user to be able to remove this record

### Index
This array holds the fieldnames you want to show in the datatable view (the overview). Each field will represent a column.
The order of the fields given, is the order of the columns shown.
Each field has 3 options:

#### Sortable (boolean)
True, if this field is sortable. When sortable the column header will be clickable and the datatable can be sorted on this column.

#### Searchable (boolean)
When true, the colum will be searchable throught the search box. 

#### Presenter (string)
The presenter will format the column in a certain way for better representation.
The following presenters can be used:

```boolean``` - The value will be shown as true (green) or false (red) and in readable format. 

```text``` - The field contains a text and will be cut-off at 50 chars. This will be clear by the ellipsis at the end of the text. 

### Fields

Basic types:
- hidden
- text
- textarea
- select
- radio
- checkbox
- date
- date-time

##### hidden
A hidden field. Does not show up in form, but can be used to have the ID column show up in datatable.

##### text
A basic text input field.

#### textarea
A textarea for writing large pieces of plain text.

#### select
A dropdown select box.

Extended types:
- slug (title input that also translates to a 'title_slug' field)
- datepicker (a jQuery UI datepicker)
- integer (a select box with integers, range can be given.
- boolean (radio with yes/no options. Loads the Boolean presenter by default.)
- editor (a WYSIWYG editor).

