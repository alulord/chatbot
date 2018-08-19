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

use ChatBot\FbBot\FbBot;
use Symfony\Component\HttpFoundation\Request;

ini_set('display_errors', 'Off');

require __DIR__.'/../vendor/autoload.php';

$request = Request::createFromGlobals();
$fbBot = new FbBot();
$response = $fbBot->handleRequest($request);
$response->send();
