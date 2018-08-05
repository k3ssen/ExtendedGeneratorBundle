<?php
declare(strict_types = 1);

namespace App\Twig;

use Doctrine\Common\Inflector\Inflector;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouterInterface;

class ComponentsExtension extends \Twig_Extension
{
    /**
     * @var Route
     */
    protected $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }
    public function getTokenParsers()
    {
        return [
            new EmbedParser(),
        ];
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('tableize', [$this, 'tableize']),
        ];
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('class_name', [$this, 'getClassShortName']),
            new \Twig_SimpleFunction('index_routes', [$this, 'getIndexRoutes']),
            new \Twig_SimpleFunction('static_field_row', [$this, 'getStaticFieldRow'], ['needs_environment' => true, 'is_safe' => ['html']]),
        ];
    }

    public function tableize($word)
    {
        return Inflector::tableize($word);
    }

    public function getClassShortName($object)
    {
        return (new \ReflectionClass($object))->getShortName();
    }

    /**
     * @return array|Route[]
     */
    public function getIndexRoutes()
    {
        $indexRoutes = [];
        foreach ($this->router->getRouteCollection() as $routeName => $route) {
            if (stripos($routeName, '_index') !== false) {
                $indexRoutes[str_replace('_index', '', $routeName)] = $route;
            }
        }
        return $indexRoutes;
    }

    public function getStaticFieldRow(\Twig_Environment $environment, $label, $value)
    {
        return $environment->render('components/static_field_row.twig', [
            'label' => $label,
            'value' => $value,
        ]);
    }
}
