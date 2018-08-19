<?php
declare(strict_types=1);

namespace ChatBot\FbBot\Controller;

use ChatBot\FbBot\Entity\Entry;
use ChatBot\FbBot\Entity\FbObject;
use ChatBot\FbBot\Entity\Messaging;
use ChatBot\FbBot\Provider\ProviderInterface;
use JMS\Serializer\SerializerBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class MessageController
 *
 * @package ChatBot\FbBot\Controller
 *
 * @author Peter Simoncic <peter.simoncic@smeonline.sk>
 */
class MessageController extends AbstractController
{

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function replyAction(Request $request): Response
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

}