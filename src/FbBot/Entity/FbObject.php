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
 * Class FbObject
 *
 * @package ChatBot\FbBot\Entity
 *
 * @author Peter Simoncic <peter.simoncic@smeonline.sk>
 */
class FbObject
{
    /**
     * @var string
     */
    private $object;

    /**
     * @var Entry[]
     */
    private $entry;

    /**
     * @return string
     */
    public function getObject(): string
    {
        return $this->object;
    }

    /**
     * @param string $object
     *
     * @return FbObject
     */
    public function setObject(string $object): self
    {
        $this->object = $object;

        return $this;
    }

    /**
     * @return Entry[]
     */
    public function getEntry(): array
    {
        return $this->entry;
    }

    /**
     * @param Entry[] $entry
     *
     * @return FbObject
     */
    public function setEntry(array $entry): self
    {
        $this->entry = $entry;

        return $this;
    }
}
