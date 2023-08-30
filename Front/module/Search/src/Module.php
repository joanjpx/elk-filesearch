<?php

declare(strict_types=1);

namespace Search;

use Laminas\Mvc\MvcEvent;
use Laminas\View\Model\ViewModel;

class Module
{

    // public function onBootstrap(MvcEvent $event)
    // {
    //     $application = $event->getApplication();
    //     $serviceManager = $application->getServiceManager();
    //     $eventManager = $application->getEventManager();
    //     $sharedEventManager = $eventManager->getSharedManager();

    //     // Configura el layout por defecto para este módulo
    //     $viewModel = $serviceManager->get(ViewModel::class);
    //     $viewModel->setTemplate('layout/layout');
    // }
    
    public function getConfig(): array
    {
        /** @var array $config */
        $config = include __DIR__ . '/../config/module.config.php';
        return $config;
    }
}
