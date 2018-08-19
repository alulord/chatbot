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

namespace ChatBot\FbBot\Entity;

/**
 * Class FbReply
 *
 * @package ChatBot\FbBot\Entity
 *
 * @author Peter Simoncic <peter.simoncic@smeonline.sk>
 */
class FbReply
{

    /**
     * @var FbUserInterface
     */
    private $recipient;

    /**
     * @var Message
     */
    private $message;

    /**
     * @var string
     */
    private $accessToken;

    /**
     * @return FbUserInterface
     */
    public function getRecipient(): FbUserInterface
    {
        return $this->recipient;
    }

    /**
     * @param FbUserInterface $recipient
     *
     * @return FbReply
     */
    public function setRecipient(FbUserInterface $recipient): self
    {
        $this->recipient = $recipient;

        return $this;
    }

    /**
     * @return Message
     */
    public function getMessage(): Message
    {
        return $this->message;
    }

    /**
     * @param Message $message
     *
     * @return FbReply
     */
    public function setMessage(Message $message): self
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    /**
     * @param string $accessToken
     *
     * @return FbReply
     */
    public function setAccessToken(string $accessToken): self
    {
        $this->accessToken = $accessToken;

        return $this;
    }
}
