<?php
namespace Mainsite\View\Helper;

use Zend\ServiceManager\AbstractPluginManager;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\View\Renderer\RendererInterface;
use Zend\View\Helper\AbstractHelper;

class HtmlRender extends AbstractPlugin
{
    /**
     * @var \Zend\View\Renderer\PhpRenderer
     * @var \Zend\ServiceManager\AbstractPluginManager;
     */
    protected $renderer;
    public $HtmlRender;
    /**
     * @param  string|\Zend\View\Model\ModelInterface $nameOrModel
     * @param  null|array|\Traversable $values
     * @param  string|bool|\Zend\View\Model\ModelInterface $layout
     * @return string
     */
    public function __construct()
    {
        $HtmlRender = $this->renderer;
    }

    public function __invoke($nameOrModel, $values = null, $layout = false)
    {
        $content = $this->getRenderer()->render($nameOrModel, $values);
        if (!$layout) {
            return $content;
        }

        if (true === $layout) {
            $layout = 'layout/layout';
        }
        return $this->getRenderer()->render($layout, [
            'content' => $content,
        ]);

    }

    /**
     * @return \Zend\View\Renderer\PhpRenderer
     */
    public function getRenderer()
    {

        $HtmlRender = $this->getView()->plugin('HtmlRender');

        return $this->renderer;
    }

    /**
     * @param  \Zend\View\Renderer\PhpRenderer|RendererInterface $renderer
     * @return self
     */
    public function setRenderer(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
        return $this;
    }
}