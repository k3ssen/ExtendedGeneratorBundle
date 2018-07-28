<?php
declare(strict_types=1);

namespace K3ssen\ExtendedGeneratorBundle\Generator;

use K3ssen\GeneratorBundle\MetaData\MetaEntityInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class CrudGenerator extends \K3ssen\GeneratorBundle\Generator\CrudGenerator
{
    /** @var CrudGenerateOptions */
    protected $generateOptions;

    /**
     * @required
     */
    public function setGenerateOptions(CrudGenerateOptions $generateOptions)
    {
        $this->generateOptions = $generateOptions;
    }

    public function createCrud(MetaEntityInterface $metaEntity): array
    {
        $files = parent::createCrud($metaEntity);
        $files[] = $this->createBaseClassIfMissing('Controller', 'CrudController');
        if ($this->generateOptions->getUseVoter()) {
            $files[] = $this->createBaseClassIfMissing('Security', 'AbstractVoter');
        }
        if ($this->generateOptions->getUseDatatable()) {
            $files[] = $this->createBaseClassIfMissing('Datatable', 'AbstractDatatable');
            $files[] = $this->createFile($metaEntity,'Datatable', 'Datatable');
        }
        $files = array_merge($files, $this->generateComponentExtensionFiles());
        return array_filter($files);
    }

    protected function createBaseClassIfMissing(string $dirName, string $fileSuffixName): ?string
    {
        $defaultBundlePath = $this->bundleProvider->getDefaultBundlePath();
        $targetFile = $defaultBundlePath.'/'.$dirName.'/'.$fileSuffixName.'.php';
        if ($this->getFileSystem()->exists($targetFile)) {
            return null;
        }
        $fileContent = $this->twig->render('@ExtendedGenerator/skeleton/'.strtolower($dirName).'/'.$fileSuffixName.'.php.twig', [
            'generate_options' => $this->generateOptions,
        ]);
        $this->getFileSystem()->dumpFile($targetFile, $fileContent);
        return $targetFile;
    }

    protected function render($skeletonTwigFile, MetaEntityInterface $metaEntity, array $params = [])
    {
        return $this->twig->render('@ExtendedGenerator/skeleton/'.$skeletonTwigFile, array_merge([
            'meta_entity' => $metaEntity,
            'generate_options' => $this->generateOptions,
        ], $params));
    }

    protected function generateComponentExtensionFiles()
    {
        $originDir = __DIR__ . '/../Resources/views/components';
        $targetDir = $this->projectDir  . '/templates/components/';

        $finder = new Finder();
        $finder->files()->in($originDir);

        $fs = new Filesystem();
        $files = [];

        foreach ($finder as $file) {
            $relativePathname = $file->getRelativePathname();

            $targetPath = $targetDir.$relativePathname;
            if ($fs->exists($targetPath)) {
            } else {
                $fs->dumpFile($targetPath, "{% extends '@!ExtendedGenerator/components/".$relativePathname."' %}");
                $files[] = $targetPath;
            }
        }
        return $files;
    }
}