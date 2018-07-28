ExtendedGeneratorBundle
=====================
 
[Getting started](getting_started.md#ExtendedGeneratorBundle)
| [Usage](usage.md#ExtendedGeneratorBundle)
| [CrudController](CrudController.md#ExtendedGeneratorBundle)
| [Router](Router.md#ExtendedGeneratorBundle)
| **AbstractVoter**
| [AbstractDatatable](AbstractDatatable.md#ExtendedGeneratorBundle)
| [TwigComponents](TwigComponents.md#ExtendedGeneratorBundle)

## AbstractVoter
When using voters, most likely you'll need to check for roles or if you're dealing with a particular user. It quickyl becomes
annoying when you need to parse the token for practically every custom method you make. 
Therefore when `vote` is being invoked using the AbstractVoter, the token will be set as class-property instead of being
passed as argument to `voteOnAttribute`. This simplifies using methods such as
`$this->isUser()` without having to pass the token object.

Additionally, some obvious methods are added:
    `isUser`, `isAdmin`, `isSuperAdmin`, `getUser`, `hasRole(string $roleName)`
