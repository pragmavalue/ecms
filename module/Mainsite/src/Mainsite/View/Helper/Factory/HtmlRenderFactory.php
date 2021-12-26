<?php
namespace Mainsite\View\Helper\Factory;

use Mainsite\View\Helper\HtmlRender;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\View\Renderer\PhpRenderer;

class HtmlRenderFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $plugin = new HtmlRender();
        $plugin->setRenderer($container->get(PhpRenderer::class));
        return $plugin;
    }
}
