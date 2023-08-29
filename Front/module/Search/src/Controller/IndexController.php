<?php

declare(strict_types=1);

namespace Search\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;
use Laminas\View\Model\ViewModel;
use Psr\Container\ContainerInterface;
use Search\Service\ELKService;

class IndexController extends AbstractActionController
{
    // public function __construct(private ContainerInterface $container)
    // {   
    //     $this->service = $this->container->get(ELKService::class);
    // }

    public function indexAction()
    {
        return [];
    }
    
    public function resultAction()
    {
        return [];
    }
        
    public function searchAction() : JsonModel
    {
        return new JsonModel([]);   
    }

}
