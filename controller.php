<?php

namespace Concrete\Package\FormsWithMopinion;

use A3020\FormsWithMopinion\Provider;
use A3020\FormsWithMopinion\Installer;
use Concrete\Core\Package\Package;

final class Controller extends Package
{
    protected $pkgHandle = 'forms_with_mopinion';
    protected $appVersionRequired = '8.0';
    protected $pkgVersion = '1.0';
    protected $pkgAutoloaderRegistries = [
        'src/FormsWithMopinion' => '\A3020\FormsWithMopinion',
    ];

    public function getPackageName()
    {
        return t('Forms with Mopinion');
    }

    public function getPackageDescription()
    {
        return t('Integration with Mopinion, a third-party service to collect website feedback.');
    }

    public function on_start()
    {
        /** @var Provider $provider */
        $provider = $this->app->make(Provider::class);
        $provider->register();
    }

    public function install()
    {
        $pkg = parent::install();

        /** @var Installer $installer */
        $installer = $this->app->make(Installer::class);
        $installer->install($pkg);
    }
}
