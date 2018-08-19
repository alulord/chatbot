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

class Messaging
{

    /**
     * @var Sender
     */
    private $sender;

    /**
     * @var Recipient
     */
    private $recipient;

    /**
     * @var int
     */
    private $timestamp;

    /**
     * @var FbRequestMessage
     */
    private $message;

    /**
     * @return Sender
     */
    public function getSender(): Sender
    {
        return $this->sender;
    }

    /**
     * @param Sender $sender
     *
     * @return Messaging
     */
    public function setSender(Sender $sender): self
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * @return Recipient
     */
    public function getRecipient(): Recipient
    {
        return $this->recipient;
    }

    /**
     * @param Recipient $recipient
     *
     * @return Messaging
     */
    public function setRecipient(Recipient $recipient): self
    {
        $this->recipient = $recipient;

        return $this;
    }

    /**
     * @return int
     */
    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    /**
     * @param int $timestamp
     *
     * @return Messaging
     */
    public function setTimestamp(int $timestamp): self
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * @return FbRequestMessage
     */
    public function getMessage(): FbRequestMessage
    {
        return $this->message;
    }

    /**
     * @param FbRequestMessage $message
     *
     * @return Messaging
     */
    public function setMessage(FbRequestMessage $message): self
    {
        $this->message = $message;

        return $this;
    }
}
