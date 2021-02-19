<?php

namespace A3020\FormsWithMopinion;

use A3020\FormsWithMopinion\Listener\PageView;
use Concrete\Core\Application\ApplicationAwareInterface;
use Concrete\Core\Application\ApplicationAwareTrait;
use Concrete\Core\Config\Repository\Repository;
use Concrete\Core\Routing\RouterInterface;

class Provider implements ApplicationAwareInterface
{
    use ApplicationAwareTrait;

    /**
     * @var Repository
     */
    protected $config;

    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(Repository $config, RouterInterface $router)
    {
        $this->config = $config;
        $this->router = $router;
    }

    public function register()
    {
        if ($this->config->get('forms_with_mopinion.enabled', false) === false) {
            return;
        }

        /** @var \Symfony\Component\EventDispatcher\EventDispatcherInterface $dispatcher */
        $dispatcher = $this->app['director'];

        $dispatcher->addListener('on_page_view', function ($event) {
            /** @var PageView $listener */
            $listener = $this->app->make(PageView::class);
            $listener->handle($event);
        });
    }
}
