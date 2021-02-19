<?php

namespace Concrete\Package\FormsWithMopinion\Controller\SinglePage\Dashboard\System;

use Concrete\Core\Page\Controller\DashboardPageController;
use Concrete\Core\Routing\Redirect;

final class FormsWithMopinion extends DashboardPageController
{
    public function view()
    {
        return Redirect::to('/dashboard/system/forms_with_mopinion/settings');
    }
}
