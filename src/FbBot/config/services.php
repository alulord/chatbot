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

use ChatBot\FbBot\Client\FbClient;
use ChatBot\FbBot\Controller\MessageController;
use ChatBot\FbBot\Handler\MessageHandler;
use ChatBot\FbBot\Handler\NlpHandler;
use JMS\Serializer\SerializerBuilder;

return [
    '%verify_token%' => 'ThisIsMySecretChatBotToken',
    '%messaging_url%' => 'https://graph.facebook.com/v2.6/me/messages',
    '%app_token%' => 'EAAhvDfeUh2kBAI3IGxeOqbqwCAZBeEDBQ5dcBs5EQxRL2JOLGZBSzvsSRZC3WeCC4JQI1ZAJzQzHTcLROCyN1wAtmUpjPkRjyFf3l6auXi8d4SU7GVKQ6BLwyyNJLiETEEay5qeOhelGwDI1eTkt5GIjQ4t4WyRy6DVT6tjMAwZDZD',
    'serializer' => function () {
        return SerializerBuilder::create()->addMetadataDir(__DIR__.'/serializer/')->build();
    },
    'ChatBot\FbBot\Provider\*NlpProviderInterface' => DI\create('ChatBot\FbBot\Provider\*NlpProvider'),
    'nlp.providers' => [
        'greetings' => \DI\create(\ChatBot\FbBot\Provider\GreetingsNlpProvider::class),
    ],
    NlpHandler::class => DI\create()
        ->method('setProviders', \DI\get('nlp.providers')),
    FbClient::class => DI\autowire()
        ->constructorParameter('serializer', \DI\get('serializer'))
        ->constructorParameter('messagingUrl', \DI\get('%messaging_url%')),
    MessageHandler::class => DI\autowire()
        ->constructorParameter('appToken', \DI\get('%app_token%')),
    MessageController::class => DI\autowire()
        ->method('setSerializer', \DI\get('serializer'))
        ->method('setMessageHandler', \DI\get(MessageHandler::class)),
];
