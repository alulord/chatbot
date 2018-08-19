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

use ChatBot\FbBot\Client\ClientInterface;
use ChatBot\FbBot\Client\FbClient;
use ChatBot\FbBot\Controller\MessageController;
use ChatBot\FbBot\Handler\MessageHandler;
use ChatBot\FbBot\Handler\NlpHandler;
use ChatBot\FbBot\Provider;
use JMS\Serializer\SerializerBuilder;

return [
    '%verify_token%' => DI\env('CHATBOT_SECRET_TOKEN'),
    '%app_token%' => DI\env('CHATBOT_APP_TOKEN'),
    '%messaging_url%' => 'https://graph.facebook.com/v2.6/me/messages',
    'serializer' => function () {
        return SerializerBuilder::create()->addMetadataDir(__DIR__.'/serializer/')->build();
    },
    'ChatBot\FbBot\Provider\*NlpProviderInterface' => DI\create('ChatBot\FbBot\Provider\*NlpProvider'),
    'nlp.providers' => [
        'greetings' => \DI\create(Provider\GreetingsNlpProvider::class),
        'bye' => \DI\create(Provider\ByeNlpProvider::class),
        'product_query product' => \DI\create(Provider\ProductQueryNlpProvider::class),
        'reminder' => \DI\create(Provider\ReminderNlpProvider::class),
    ],
    NlpHandler::class => DI\create()
        ->method('setProviders', \DI\get('nlp.providers')),
    ClientInterface::class => DI\autowire(FbClient::class)
        ->constructorParameter('serializer', \DI\get('serializer'))
        ->constructorParameter('messagingUrl', \DI\get('%messaging_url%')),
    MessageHandler::class => DI\autowire()
        ->constructorParameter('appToken', \DI\get('%app_token%')),
    MessageController::class => DI\autowire()
        ->method('setSerializer', \DI\get('serializer'))
        ->method('setMessageHandler', \DI\get(MessageHandler::class)),
];
