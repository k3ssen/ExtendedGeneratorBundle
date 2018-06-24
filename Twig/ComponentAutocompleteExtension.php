<?php
declare(strict_types = 1);

namespace K3ssen\ExtendedGeneratorBundle\Twig;

use K3ssen\BaseAdminBundle\Twig\ComponentsAsMethods;

class ComponentAutocompleteExtension extends \Twig_Extension implements \Twig_Extension_GlobalsInterface
{
    /**
     * Using the Symfony-plugin, these globals will help provide autocompletion for components:
     * {% include box --> no autocompletion
     * {% include.box -> will provide autocompletion, since the IDE-plugin recognizes the include as an variable/object.
     *
     * The reason for not using these globals in the BaseAdminBundle itself is because these globals aren't needed
     * in production: they are merely intended for autocompletion.
     *
     * TODO: figure out how to achieve this autocompletion with IDE only
     *
     * @return array
     */
    public function getGlobals()
    {
        return [
            'include' => new ComponentsAsMethods(),
            'embed' => new ComponentsAsMethods(),
        ];
    }
}
