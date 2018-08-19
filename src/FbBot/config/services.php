<?php
declare(strict_types=1);

use ChatBot\FbBot\Controller\VerifyController;

/* @TODO get tokens from .env? */
return [
    '%verify_token%' => 'ThisIsMySecretChatBotToken',
    '%app_token%' => 'EAAhvDfeUh2kBAI3IGxeOqbqwCAZBeEDBQ5dcBs5EQxRL2JOLGZBSzvsSRZC3WeCC4JQI1ZAJzQzHTcLROCyN1wAtmUpjPkRjyFf3l6auXi8d4SU7GVKQ6BLwyyNJLiETEEay5qeOhelGwDI1eTkt5GIjQ4t4WyRy6DVT6tjMAwZDZD',
    VerifyController::class => DI\autowire(),
];