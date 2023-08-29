<?php
declare(strict_types=1);

namespace Application\ServiceManager\Traits;

use Interop\Container\ContainerInterface;
use Mezzio\Exception\InvalidArgumentException;

trait ContainerTrait
{

    /**
     *
     * @return ContainerInterface
     * @throws InvalidArgumentException
     */
    public function getContainer(): ContainerInterface
    {
        if (!$this->container) {
            throw new InvalidArgumentException('Undefined container in '.__CLASS__);
        }
        return $this->container;
    }

    /**
     *
     * @param string $className
     * @return mixed
     * @throws Exception\InvalidArgumentException
     */
    public function container(string $className)
    {
        return $this->getContainer()->get($className);
    }
}
