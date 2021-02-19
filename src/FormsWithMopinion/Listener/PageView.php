<?php

namespace A3020\FormsWithMopinion\Listener;

use Concrete\Core\Application\ApplicationAwareInterface;
use Concrete\Core\Application\ApplicationAwareTrait;
use Concrete\Core\Config\Repository\Repository;
use Concrete\Core\Http\Request;
use Concrete\Core\Http\ResponseAssetGroup;
use Concrete\Core\Page\Event;
use Concrete\Core\Page\Page;
use Concrete\Core\User\User;

class PageView implements ApplicationAwareInterface
{
    use ApplicationAwareTrait;

    /**
     * @var Repository
     */
    protected $config;

    /**
     * @var Request
     */
    private $request;

    public function __construct(Repository $config, Request $request)
    {
        $this->config = $config;
        $this->request = $request;
    }

    /**
     * When a page is viewed, inject the embed code
     *
     * @param Event $event
     */
    public function handle(Event $event)
    {
        $jsCode = $this->config->get('forms_with_mopinion.default_code', false);
        if (empty($jsCode)) {
            return;
        }

        if ($this->disableForCurrentRequest($event->getPageObject())) {
            return;
        }

        if ($this->disableForCurrentUser()) {
            return;
        }

        $r = ResponseAssetGroup::get();
        $r->addFooterAsset($jsCode);
    }

    /**
     * Should Forms with Mopinion be disabled for the current request?
     *
     * @param \Concrete\Core\Page\Page $page
     *
     * @return bool
     */
    private function disableForCurrentRequest(Page $page)
    {
        // Disable in admin area
        if ($page->isAdminArea()) {
            return true;
        }

        // Disable in edit mode
        if ($page->isEditMode()) {
            return true;
        }

        // Disable for AJAX requests
        if ($this->request->isXmlHttpRequest()) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    private function disableForCurrentUser()
    {
        // Don't disable if no user groups have been selected
        $disabledUserGroups = $this->config->get('forms_with_mopinion.disable_for_user_groups', []);
        if (count($disabledUserGroups) === 0) {
            return false;
        }

        // Disable if at least one of the user's user groups is selected
        return (bool) count(array_intersect(
            (new User())->getUserGroups(), $disabledUserGroups)
        );
    }
}