<?php

/*
 |--------------------------------------------------------------------------
 | Cross-references
 |--------------------------------------------------------------------------
 |
 | Define the table cross-references here. You define tables you want to
 | appear as 'children' under the records of the given parent table.
 |
 | Make sure you have a table config file created, for each of the cross-referenced
 | table(s) just like you do for any other table.
 |
 | To illustrate:
 | Suppose you have a table 'pages', and 'persons'. Both have 'images'. You then
 | add the 'images' table as a x-ref to the 'pages' and 'persons' table like so:
 |
 | [
 |   'pages' => ['images'],
 |   'persons' => ['images']
 | ]
 |
 | Another example: you have 'downloads' under 'pages':
 |
 | [
 |   'pages' => ['images', 'downloads'],
 |   'persons' => ['images']
 | ]
 |
 */
return [

    'my_table' => ['example_table', 'example_table_2'],
    'foo_table' => ['example_table']

];
