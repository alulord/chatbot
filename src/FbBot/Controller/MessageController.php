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

namespace ChatBot\FbBot\Controller;

use ChatBot\FbBot\Entity\FbObject;
use ChatBot\FbBot\Handler\MessageHandler;
use JMS\Serializer\Serializer;
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
     * @var Serializer
     */
    private $serializer;

    /**
     * @var MessageHandler
     */
    private $messageHandler;

    /**
     * @param Serializer $serializer
     */
    public function setSerializer(Serializer $serializer): void
    {
        $this->serializer = $serializer;
    }

    /**
     * @param MessageHandler $messageHandler
     */
    public function setMessageHandler(MessageHandler $messageHandler): void
    {
        $this->messageHandler = $messageHandler;
    }

    /**
     * There is a thing on facebook, when you don't return status code 200 for some time,
     * it will unsubscribe your webhook without letting you know. So we return some response
     *
     * @param Request $request
     *
     * @return Response
     */
    public function replyAction(Request $request): Response
    {
        $fbObject = $this->deserializeRequest($request);

        foreach ($fbObject->getEntry() as $entry) {
            $this->messageHandler->handleMessage($entry);
        }

        return new Response();
    }

    /**
     * @param Request $request
     *
     * @return FbObject
     */
    private function deserializeRequest(Request $request): FbObject
    {
        return $this->serializer->deserialize($request->getContent(), FbObject::class, 'json');
    }
}
