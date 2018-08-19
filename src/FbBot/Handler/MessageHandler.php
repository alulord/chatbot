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

namespace ChatBot\FbBot\Handler;

use ChatBot\FbBot\Client\ClientInterface;
use ChatBot\FbBot\Entity\Entry;
use ChatBot\FbBot\Entity\FbReply;
use ChatBot\FbBot\Entity\FbUserInterface;
use ChatBot\FbBot\Entity\Message;

/**
 * Class MessageHandler
 *
 * @package ChatBot\FbBot\Handler
 *
 * @author Peter Simoncic <peter.simoncic@smeonline.sk>
 */
class MessageHandler
{

    /**
     * @var NlpHandler
     */
    private $nlpHandler;

    /**
     * @var string
     */
    private $appToken;

    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @param NlpHandler      $nlpHandler
     * @param ClientInterface $client
     * @param string          $appToken
     */
    public function __construct(NlpHandler $nlpHandler, ClientInterface $client, string $appToken)
    {
        $this->nlpHandler = $nlpHandler;
        $this->client = $client;
        $this->appToken = $appToken;
    }

    /**
     * @param Entry $entry
     */
    public function handleMessage(Entry $entry): void
    {
        foreach ($entry->getMessaging() as $messaging) {
            if (null === $messaging->getMessage()) {
                continue;
            }
            $replyMsg = $this->nlpHandler->handleNlp($messaging);
            $reply = $this->createReply($messaging->getSender(), $replyMsg);

            $this->client->sendReply($reply);
//            We can save message Id's
//            $response = json_decode($response->getBody()->getContents());
        }
    }

    /**
     * @param FbUserInterface $recipient
     * @param string          $replyMsg
     *
     * @return FbReply
     */
    private function createReply(FbUserInterface $recipient, string $replyMsg): FbReply
    {
        $reply = new FbReply();
        $replyMessage = new Message();
        $replyMessage->setText($replyMsg);
        $reply->setRecipient($recipient);
        $reply->setMessage($replyMessage);
        $reply->setAccessToken($this->appToken);

        return $reply;
    }
}
