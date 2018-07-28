ExtendedGeneratorBundle
=====================

[Getting started](getting_started.md#ExtendedGeneratorBundle)
| **Usage**
| [CrudController](CrudController.md#ExtendedGeneratorBundle)
| [Router](Router.md#ExtendedGeneratorBundle)
| [AbstractVoter](AbstractVoter.md#ExtendedGeneratorBundle)
| [AbstractDatatable](AbstractDatatable.md#ExtendedGeneratorBundle)
| [TwigComponents](TwigComponents.md#ExtendedGeneratorBundle)

## Usage

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