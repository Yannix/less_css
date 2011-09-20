Author : Yannick Komotir @yannixk <ykomotir@gmail.com>

eZ Publish LESS extension
==========================

This extension enables write of stylesheet with LESS rule and compile it in an usable way.

LESS ( http://lesscss.org ) is a templating stylesheet language based on top of CSS. It provides numerous enhancements and features to speed up development and make its maintenance easier like mixins, nested inheritance, accessors and rules importing.

In this project we use lessphp ( http://leafo.net/lessphp/ ) a LESS PHP compiler in order to compile css.


Requirements
============

eZ Publish >= 4.0 
PHP 5.2.0 and higher


Installation
============

 - Unpack/unzip the downloaded zip package into the 'extension' directory of your eZ Publish installation.
 - Activate the extension by using the admin interface or by editing the settings/override/site.ini.append.php file:
 - Regenerate autoload array

 
Usage
=====

This extension provide an operator "lesscss". To use it just put your css file like argument in the operator inside the head tag in you pagelayout.tpl.

a sample :
{include uri='design:page_head.tpl'}
{lesscss("csslessfile.css")}


TO DO
======

- @import directive support
- support of multiple files
- packaging
