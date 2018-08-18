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

use ChatBot\FbBot\FbBotController;
use Symfony\Component\HttpFoundation\Request;

ini_set('display_errors', 'Off');

require __DIR__.'/../vendor/autoload.php';
//$object = json_decode(
//    '{
//  "object": "page",
//  "entry": [
//    {
//      "id": "538226666620380",
//      "time": 1534607023336,
//      "messaging": [
//        {
//          "sender": {
//            "id": "1942519759172744"
//          },
//          "recipient": {
//            "id": "538226666620380"
//          },
//          "timestamp": 1534607022338,
//          "message": {
//            "mid": "LYb6w5PaM5uovX3mZSMC3si68T450078LUHuaNFNdc0PGtH7vrTQMV6BaWGVftdmrjaCFbi-g0K_0Fhy-XIkCw",
//            "seq": 110066,
//            "text": "hi bye",
//            "nlp": {
//              "entities": {
//                "bye": [
//                  {
//                    "confidence": 0.98290628195892,
//                    "value": "true"
//                  }
//                ],
//                "greetings": [
//                  {
//                    "confidence": 0.99952387809104,
//                    "value": "true"
//                  }
//                ]
//              }
//            }
//          }
//        }
//      ]
//    }
//  ]
//}'
//);
//foreach ($object->entry[0]->messaging[0]->message->nlp->entities as $name=>$entity) {
//    var_dump($name);
//    var_dump($entity);
//    echo '______________________________';
//}

//$hub_verify_token = null;
//if (isset($_REQUEST['hub_challenge'])) {
//    $challenge = $_REQUEST['hub_challenge'];
//    $hub_verify_token = $_REQUEST['hub_verify_token'];
//}
//if ($hub_verify_token === VERIFY_TOKEN) {
//    echo $challenge;
//}
//
//$update_response = file_get_contents("php://input");
//
////-----VERIFY LOG-----//
//$fh = fopen("log.txt", "w+");
//fwrite($fh, $update_response);
//fclose($fh);

/* @TODO get this from .env? */
define('VERIFY_TOKEN', 'ThisIsMySecretChatBotToken');
define(
    'APP_TOKEN',
    'EAAhvDfeUh2kBAI3IGxeOqbqwCAZBeEDBQ5dcBs5EQxRL2JOLGZBSzvsSRZC3WeCC4JQI1ZAJzQzHTcLROCyN1wAtmUpjPkRjyFf3l6auXi8d4SU7GVKQ6BLwyyNJLiETEEay5qeOhelGwDI1eTkt5GIjQ4t4WyRy6DVT6tjMAwZDZD'
);

$request = Request::createFromGlobals();
$fbBot = new FbBotController(VERIFY_TOKEN, APP_TOKEN);
$response = $fbBot->handleRequest($request);
$response->send();
