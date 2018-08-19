<?php
declare(strict_types=1);

namespace ChatBot\FbBot\Controller;

use DI\Container;

abstract class AbstractController
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * AbstractController constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @return Container
     */
    public function getContainer(): Container
    {
        return $this->container;
    }

}