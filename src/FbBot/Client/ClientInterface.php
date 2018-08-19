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
use Psr\Http\Message\ResponseInterface;

/**
 * Interface ClientInterface
 * We don't need this right now, because we have only one client, but just for soLid sake
 *
 * @package ChatBot\FbBot\Client
 */
interface ClientInterface
{

    /**
     * @param FbReply $reply
     *
     * @return ResponseInterface
     */
    public function sendReply(FbReply $reply): ResponseInterface;
}
