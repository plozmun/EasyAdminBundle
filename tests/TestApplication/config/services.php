<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use EasyCorp\Bundle\EasyAdminBundle\Tests\TestApplication\Controller\CategoryCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Tests\TestApplication\Controller\DashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Tests\TestApplication\Controller\SecureDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Tests\TestApplication\DataFixtures\AppFixtures;

return static function (ContainerConfigurator $container) {
    $container->parameters()->set('locale', 'en');

    $services = $container->services()
        ->defaults()
            ->autowire()
            ->autoconfigure()
    ;

    $services->load('EasyCorp\\Bundle\\EasyAdminBundle\\Tests\\TestApplication\\', '../src/*')
        ->exclude('../{Entity,Tests,Kernel.php}');

    $services->set(DashboardController::class)
        ->tag('controller.service_arguments')
        ->call('setContainer', [service('service_container')]);

    $services->set(SecureDashboardController::class)
        ->tag('controller.service_arguments')
        ->call('setContainer', [service('service_container')]);

    $services->set(CategoryCrudController::class)
        ->tag('controller.service_arguments')
        ->call('setContainer', [service('service_container')]);

    $services->set(AppFixtures::class)->tag('doctrine.fixture.orm');
};
