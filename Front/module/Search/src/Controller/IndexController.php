<?php

declare(strict_types=1);

namespace Search\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Psr\Container\ContainerInterface;
use Search\Service\ELKService;

class IndexController extends AbstractActionController
{
    public function __construct(private ContainerInterface $container)
    {   
        $this->service = $this->container->get(ELKService::class);
    }

    public function indexAction()
    {
        return [];
    }
    
    public function resultAction() : ViewModel
    {
        $search = $this->getRequest()->getQuery('q');
        $data = $this->service->search(
            $search
        );

        return new ViewModel([
            'data' => $data,
            'search' => $search
        ]);
    }
    
    public function searchAction()
    {
        $q = $this->getRequest()->getQuery('q');
        echo json_encode($this->service->search($q));exit;
    }

}
