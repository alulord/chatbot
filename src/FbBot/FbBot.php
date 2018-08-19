<?php
declare(strict_types=1);

/**
 * PHP version 7.1.17
 * This file is part of ChatBot project.
 *
 * @author  Peter Simoncic <alulord@gmail.com>
 * @license GNU AGPLv3
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ChatBot\FbBot;

use ChatBot\FbBot\Controller\AbstractController;
use DI\Container;
use DI\ContainerBuilder;
use DI\Definition\Reference;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Loader\XmlFileLoader;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

/**
 * Class FbBot
 *
 * @package ChatBot
 *
 * @author Peter Simoncic <peter.simoncic@smeonline.sk>
 */
class FbBot
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @param Request $request
     *
     * @throws \ReflectionException
     * @return Response
     */
    public function handleRequest(Request $request): Response
    {
        $builder = new ContainerBuilder();
        $builder->addDefinitions(__DIR__.'/config/services.php');
        $this->container = $builder->build();
        $this->container->set(Request::class, $request);
        $matcher = $this->getRouteMatcher($request);

        try {
            $attributes = $matcher->match($request->getPathInfo());
            $controllerParts = $this->getControllerParts($attributes);
            $controller = $this->getController($controllerParts);
            $controllerMethod = $this->getControllerMethod($attributes);
            $parameters = $this->getControllerMethodParameters($controller, $attributes);
            $response = \call_user_func_array([$controller, $controllerMethod], $parameters);
        } catch (ResourceNotFoundException $exception) {
            $response = new Response('Not Found', 404);
        }

        return $response;
    }

    /**
     * @param array $attributes
     *
     * @return array[string]
     */
    private function getControllerParts(array $attributes): array
    {
        if (!isset($attributes['_controller'])) {
            throw new \LogicException('Route definition must have parameter "_controller" set');
        }
        if (false === mb_strpos($attributes['_controller'], '::')) {
            throw new \LogicException(
                'Route "_controller" definition must be in form "Controller\FQCN::controllerAction"'
            );
        }

        return explode('::', $attributes['_controller']);
    }

    /**
     * @param array $controllerParts
     *
     * @return AbstractController
     */
    private function getController(array $controllerParts): AbstractController
    {
        return \DI\get($controllerParts[0])->resolve($this->container);
    }

    /**
     * @param array $attributes
     *
     * @return string
     */
    private function getControllerMethod(array $attributes): string
    {
        return $this->getControllerParts($attributes)[1];
    }

    /**
     * @param AbstractController $controller
     * @param array              $attributes
     *
     * @throws \ReflectionException
     * @return array
     */
    private function getControllerMethodParameters(AbstractController $controller, array $attributes): array
    {
        $controllerReflection = new \ReflectionClass($controller);
        $methodParameters = $controllerReflection->getMethod($this->getControllerMethod($attributes))->getParameters();
        $parameters = [];
        foreach ($methodParameters as $parameter) {
            if ($parameter->hasType()) {
                $parameters[$parameter->getName()] = $this->getServiceDefinition($parameter)->resolve($this->container);
                continue;
            }
            $parameters[$parameter->getName()] = $this->wireAttribute($parameter, $attributes);
        }

        return $parameters;
    }

    /**
     * @param Request $request
     *
     * @return UrlMatcher
     */
    private function getRouteMatcher(Request $request): UrlMatcher
    {
        $routeLoader = new XmlFileLoader(new FileLocator(__DIR__.'/config'));
        $routes = $routeLoader->load('routing.xml');

        $context = new RequestContext();
        $context->fromRequest($request);

        return new UrlMatcher($routes, $context);
    }

    /**
     * @param \ReflectionParameter $parameter
     *
     * @return Reference
     */
    private function getServiceDefinition(\ReflectionParameter $parameter): Reference
    {
        return \DI\get($parameter->getType()->getName());
    }

    /**
     * @param \ReflectionParameter $parameter
     * @param array                $attributes
     *
     * @return mixed
     */
    private function wireAttribute(\ReflectionParameter $parameter, array $attributes)
    {
        if (!isset($attributes[$parameter->getName()])) {
            throw new \UnexpectedValueException('You must provide attribute in you routing');
        }

        return $attributes[$parameter->getName()];
    }
}
