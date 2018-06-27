<?php
declare(strict_types=1);

namespace K3ssen\ExtendedGeneratorBundle\DependencyInjection;

use K3ssen\BaseAdminBundle\Model\BlameableEntityInterface;
use K3ssen\BaseAdminBundle\Model\BlameableEntityTrait;
use K3ssen\BaseAdminBundle\Model\SoftDeleteableEntityTrait;
use K3ssen\BaseAdminBundle\Model\SoftDeleteableInterface;
use K3ssen\BaseAdminBundle\Model\TimestampableEntityTrait;
use K3ssen\BaseAdminBundle\Model\TimestampableInterface;
use K3ssen\ExtendedGeneratorBundle\Command\AttributeQuestion\IdAttributeQuestion;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\Security\Core\User\UserInterface;

class ExtendedGeneratorExtension extends Extension implements PrependExtensionInterface
{
    public function prepend(ContainerBuilder $container)
    {
        $prependConfig = [
            'attributes' => [
                'id' => [
                    'question' => IdAttributeQuestion::class,
                ],
            ],
            'trait_options' => [
                'SoftDeleteable' => [
                    'namespace' => SoftDeleteableEntityTrait::class,
                    'interface_namespace' => SoftDeleteableInterface::class,
                ],
                'Timestampable' => [
                    'namespace' => TimestampableEntityTrait::class,
                    'interface_namespace' => TimestampableInterface::class,
                ],
            ],
        ];
        if (is_subclass_of('\App\Entity\User', UserInterface::class)) {
            $prependConfig['trait_options']['Blameable'] = [
                'namespace' => BlameableEntityTrait::class,
                'interface_namespace' => BlameableEntityInterface::class,
            ];
        }
        foreach ($container->getExtensionConfig('generator') as $config) {
            //If there already is a config that (un)sets the question, then no attributes need to be prepended
            if (isset($config['attributes']['id']) && array_key_exists('question', $config['attributes']['id'])) {
                unset($prependConfig['attributes']);
            }
            if (isset($config['trait_options']) && array_key_exists('Timestampable', $config['trait_options'])) {
                unset($prependConfig['trait_options']['Timestampable']);
            }
            if (isset($config['trait_options']) && array_key_exists('Blameable', $config['trait_options'])) {
                unset($prependConfig['trait_options']['Blameable']);
            }
            if (isset($config['trait_options']) && array_key_exists('SoftDeleteable', $config['trait_options'])) {
                unset($prependConfig['trait_options']['SoftDeleteable']);
            }
        }

        $container->prependExtensionConfig('generator', $prependConfig);
    }

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');

        foreach ($config as $key => $value) {
            $container->setParameter('extended_generator.'.$key, $value);
        }
    }
}
