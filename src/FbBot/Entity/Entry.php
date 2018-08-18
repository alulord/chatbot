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
 * Class Entry
 *
 * @package ChatBot\FbBot\Entity
 *
 * @author Peter Simoncic <peter.simoncic@smeonline.sk>
 */
class Entry
{

    /**
     * @var string
     */
    private $id;

    /**
     * @var int
     */
    private $time;

    /**
     * @var Messaging[]
     */
    private $messaging = [];

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return Entry
     */
    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getTime(): int
    {
        return $this->time;
    }

    /**
     * @param int $time
     *
     * @return Entry
     */
    public function setTime(int $time): self
    {
        $this->time = $time;

        return $this;
    }

    /**
     * @return Messaging[]
     */
    public function getMessaging(): array
    {
        return $this->messaging;
    }

    /**
     * @param Messaging[] $messaging
     *
     * @return Entry
     */
    public function setMessaging(array $messaging): self
    {
        $this->messaging = $messaging;

        return $this;
    }
}
