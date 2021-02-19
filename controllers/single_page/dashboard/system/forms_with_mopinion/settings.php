<?php

namespace Concrete\Package\FormsWithMopinion\Controller\SinglePage\Dashboard\System\FormsWithMopinion;

use Concrete\Core\Config\Repository\Repository;
use Concrete\Core\Http\ResponseAssetGroup;
use Concrete\Core\Page\Controller\DashboardPageController;
use Concrete\Core\Routing\Redirect;
use Concrete\Core\User\Group\GroupList;

final class Settings extends DashboardPageController
{
    public function on_before_render()
    {
        $rag = ResponseAssetGroup::get();
        $rag->requireAsset('select2');

        parent::on_before_render();
    }

    public function view()
    {
        /** @var Repository $config */
        $config = $this->app->make(Repository::class);

        $this->set('isEnabled', (bool) $config->get('forms_with_mopinion.enabled', true));
        $this->set('defaultCode', $config->get('forms_with_mopinion.default_code'));
        $this->set('userGroupOptions', $this->getUserGroupOptions());
        $this->set('disableForUserGroups', $config->get('forms_with_mopinion.disable_for_user_groups', []));
    }

    public function save()
    {
        if (!$this->token->validate('a3020.forms_with_mopinion.settings')) {
            $this->flash('error', $this->token->getErrorMessage());

            return Redirect::to('/dashboard/system/forms_with_mopinion/settings');
        }

        /** @var Repository $config */
        $config = $this->app->make(Repository::class);
        $config->save('forms_with_mopinion.enabled', (bool) $this->post('isEnabled'));
        $config->save('forms_with_mopinion.default_code', $this->post('defaultCode'));
        $config->save('forms_with_mopinion.disable_for_user_groups', $this->post('disableForUserGroups', []));

        $this->flash('success', t('Your settings have been saved.'));

        return Redirect::to('/dashboard/system/forms_with_mopinion/settings');
    }

    /**
     * @return array
     */
    private function getUserGroupOptions()
    {
        $options = [];

        $list = new GroupList();
        $list->includeAllGroups();

        foreach ($list->getResults() as $group) {
            // It makes no sense to include the 'Guest' group
            if ($group->getGroupID() == GUEST_GROUP_ID) {
                continue;
            }

            $options[$group->getGroupID()] = $group->getGroupName();
        }

        return $options;
    }
}
