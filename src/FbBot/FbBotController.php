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

use ChatBot\FbBot\Entity\Entry;
use ChatBot\FbBot\Entity\FbObject;
use ChatBot\FbBot\Entity\Messaging;
use ChatBot\FbBot\Provider\ProviderInterface;
use http\Exception\InvalidArgumentException;
use JMS\Serializer\SerializerBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

/**
 * Class FbBot
 *
 * @package ChatBot
 *
 * @author Peter Simoncic <peter.simoncic@smeonline.sk>
 */
class FbBotController
{
    /**
     * This is used to verify webhook
     *
     * @var string
     */
    private $verifyToken;

    /**
     * This is used to send messages to app
     *
     * @var string
     */
    private $appToken;

    /**
     * FbBot constructor.
     *
     * @param string $verifyToken
     * @param string $appToken
     */
    public function __construct(string $verifyToken, string $appToken)
    {
        $this->verifyToken = $verifyToken;
        $this->appToken = $appToken;
    }

    /**
     * Just a simple single purpose request handling. We are not building new framework
     *
     * @param Request $request
     *
     * @return Response
     */
    public function handleRequest(Request $request): Response
    {
        switch ($request->getMethod()) {
            case 'GET':
                return $this->verifyAction($request);
                break;
            case 'POST':
                return $this->replyAction($request);
                break;
        }

        //We should never get here
        throw new MethodNotAllowedHttpException(['GET', 'POST']);
    }

    /**
     *
     * @return Response
     */
    private function verifyAction(Request $request): Response
    {
        $hub_verify_token = null;
        if (false === $request->query->has('hub_challenge')) {
            throw new \LogicException('You must send challenge');
        }
        $challenge = $request->query->get('hub_challenge');
        $hub_verify_token = $request->query->get('hub_verify_token');
        if ($hub_verify_token !== $this->verifyToken) {
            throw new InvalidArgumentException('Bad verification token');
        }

        return new Response($challenge);
    }

    private function replyAction(Request $request)
    {
        $fbObject = $this->deserializeRequest($request);

        foreach ($fbObject->getEntry() as $entry) {
            $this->handleMessage($entry);
        }

        return new Response('test');
    }

    /**
     * @param Request $request
     *
     * @return FbObject
     */
    private function deserializeRequest(Request $request): FbObject
    {
        $serializer = SerializerBuilder::create()->addMetadataDir(__DIR__.'/config/serializer/')->build();

        return $serializer->deserialize($request->getContent(), FbObject::class, 'json');
    }

    /**
     * @TODO maybe do some array caching for providers
     *
     * @param Messaging $messaging
     */
    private function handleNlp(Messaging $messaging): void
    {
        foreach ($messaging->getMessage()->getNlp()->getEntities() as $entityName => $entity) {
            $providerFQCN = 'ChatBot\\FbBot\\Provider\\'.ucfirst($entityName).'Provider';
            if (false === class_exists($providerFQCN)) {
                /* Maybe we want to log this? */
                continue;
            }
            /** @var ProviderInterface $provider */
            $provider = new $providerFQCN();
            $provider->handleEntity($entity);
        }
    }

    /**
     * @param Entry $entry
     *
     * @return array
     */
    private function handleMessage(Entry $entry): array
    {
        $replies = [];
        foreach ($entry->getMessaging() as $messaging) {
            $messaging->getRecipient()->getId();
            $messaging->getSender()->getId();
            $this->handleNlp($messaging);
        }

        return $replies;
    }
}
