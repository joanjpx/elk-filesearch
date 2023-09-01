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
    public function __construct(private ContainerInterface $container)
    {
        $this->service = $this->container->get(ELKService::class);
    }

    public function indexAction()
    {
        return [];
    }

    public function resultAction(): ViewModel
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
        echo json_encode($this->service->search($q));
        exit;
    }


    public function addPathAction()
    {
        // Get the request object
        $request = $this->getRequest();

        // Check if the request has JSON content
        //   if (!$request->isPost() || !$request->isXmlHttpRequest()) {
        //       return new JsonModel(['error' => 'Invalid request']);
        //   }

        // Get the JSON payload
        $payload = $this->getRequest()->getContent();

        // Attempt to decode the JSON data
        $data = json_decode($payload, true);

        //   if ($data === null) {
        //       return new JsonModel(['error' => 'Invalid JSON payload']);
        //   }

        // Now you can work with the decoded data
        $path = $data['path'];

        echo json_encode($this->service->addUrl($path));
        exit;
    }

    public function removePathAction()
    {
        // Get the request object
        $request = $this->getRequest();

        // Check if the request has JSON content
        //   if (!$request->isPost() || !$request->isXmlHttpRequest()) {
        //       return new JsonModel(['error' => 'Invalid request']);
        //   }

        // Get the JSON payload
        $payload = $this->getRequest()->getContent();

        // Attempt to decode the JSON data
        $data = json_decode($payload, true);

        //   if ($data === null) {
        //       return new JsonModel(['error' => 'Invalid JSON payload']);
        //   }

        // Now you can work with the decoded data
        $path = $data['path'];

        echo json_encode($this->service->deleteUrl($path));
        exit;
    }

    public function showPathsAction()
    {
        echo json_encode($this->service->readUrls());
        exit;
    }
}
