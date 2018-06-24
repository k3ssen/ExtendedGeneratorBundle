ExtendedGeneratorBundle
=====================

Symfony 4 bundle for quickly generating/prototyping a CRUD application.

This bundle extends the 
[GeneratorBundle](https://github.com/k3ssen/GeneratorBundle)
and uses the [BaseAdminBundle](https://github.com/k3ssen/BaseAdminBundle):

- Generated files will make use of the BaseAdminBundle.
- CRUD generations offers an extra option for generating Datatables.
- Extra classes are generated for extending abstract classes.  
For example: the AbstractVoter in the BaseAdminBundle is extended by another
AbstractVoter which in turn is extended by the generated Voter classes.

### Getting started

Run `composer require k3ssen/extended-generator:dev-master --dev` in your console.

Symfony Flex should add the bundle automatically to your `config/bundles.php`.

If installation fails due to minumum-stability, you could add the 
following settings to your composer.json file first:
    
    "minimum-stability": "dev",
    "prefer-stable": true 

### Usage

When it comes to usage nearly the same applies as the [usage of the GeneratorBundle](https://github.com/k3ssen/GeneratorBundle/blob/master/Resources/doc/usage.md).

During crud generation (when using the `generator:crud`) command
you'll have an extra question that lets you choose if you want to use
Datatables.

The other difference is the generated output: extra template
(twig) files are used for generation.
The GeneratorBundle lets you use `generator:templates` to add twig
files to your `templates` directory.
For the ExtendedGeneratorBundle you can use `generator:extended:template`
to do the same thing.