<?php

namespace A3020\FormsWithMopinion;

use Concrete\Core\Page\Page;
use Concrete\Core\Page\Single;

class Installer
{
    /**
     * @param \Concrete\Core\Package\Package $pkg
     */
    public function install($pkg)
    {
        $pages = [
            '/dashboard/system/forms_with_mopinion' => t('Forms with Mopinion'),
            '/dashboard/system/forms_with_mopinion/settings' => t('Settings'),
        ];

        foreach ($pages as $path => $name) {
            /** @var Page $page */
            $page = Page::getByPath($path);
            if ($page && !$page->isError()) {
                continue;
            }

            $singlePage = Single::add($path, $pkg);
            $singlePage->update([
                'cName' => $name,
            ]);
        }
    }
}
