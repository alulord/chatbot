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

namespace ChatBot\FbBot\Client;

use ChatBot\FbBot\Entity\FbReply;
use GuzzleHttp\Client;
use JMS\Serializer\Serializer;
use Psr\Http\Message\ResponseInterface;

/**
 * Class FbClient
 *
 * @package ChatBot\FbBot\Client
 *
 * @author Peter Simoncic <peter.simoncic@smeonline.sk>
 */
class FbClient implements ClientInterface
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var string
     */
    private $messagingUrl;

    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * FbClient constructor.
     *
     * @param Client     $client
     * @param Serializer $serializer
     * @param string     $messagingUrl
     */
    public function __construct(Client $client, Serializer $serializer, string $messagingUrl)
    {
        $this->client = $client;
        $this->messagingUrl = $messagingUrl;
        $this->serializer = $serializer;
    }

    /**
     * @param FbReply $reply
     *
     * @return ResponseInterface
     */
    public function sendReply(FbReply $reply): ResponseInterface
    {
        $serializedReply = $this->serializer->serialize($reply, 'json');
        $requestData = [
            'query' => ['access_token' => $reply->getAccessToken()],
            'body' => $serializedReply,
            'headers' => ['content-type' => 'application/json'],
        ];

        return $this->client->post($this->messagingUrl, $requestData);
    }
}
