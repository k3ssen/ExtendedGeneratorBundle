<?php
declare(strict_types=1);

namespace K3ssen\ExtendedGeneratorBundle\Command;

use Symfony\Component\Finder\SplFileInfo;

class TemplatesCommand extends \K3ssen\GeneratorBundle\Command\TemplatesCommand
{
    protected static $defaultName = 'generator:extended:templates';

    protected function createContentForFile(SplFileInfo $file): string
    {
        $relativePathname = $file->getRelativePathname();

        $content = "{# @var meta_entity \K3ssen\GeneratorBundle\MetaData\MetaEntityInterface #}";
        // With the exception of the entity and repository all files should have 'generate_options'
        if (stripos($relativePathname, 'entity') === false && stripos($relativePathname, 'repository') === false) {
            $content .= "\n{# @var generate_options \K3ssen\ExtendedGeneratorBundle\Generator\CrudGenerateOptions#}";
        }

        if ($file->getFilename()[0] === '_') {
            $content .= "\n{% use '@!ExtendedGenerator/".$relativePathname."' %}";
        } else {
            $content .= "\n{% extends '@!ExtendedGenerator/".$relativePathname."' %}";
        }
        return $content;
    }

    protected function getOriginDirectory(): string
    {
        return __DIR__ . '/../Resources/views';
    }

    protected function getTargetDirectory(): string
    {
        return $this->projectDir  . '/templates/bundles/ExtendedGeneratorBundle/';
    }
}
