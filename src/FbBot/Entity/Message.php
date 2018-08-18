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
 * Class Message
 *
 * @package ChatBot\FbBot\Entity
 *
 * @author Peter Simoncic <peter.simoncic@smeonline.sk>
 */
class Message
{

    /**
     * @var string
     */
    private $mid;

    /**
     * @var int
     */
    private $seq;

    /**
     * @var string
     */
    private $text;

    /**
     * @var Nlp
     */
    private $nlp;

    /**
     * @return string
     */
    public function getMid(): string
    {
        return $this->mid;
    }

    /**
     * @param string $mid
     *
     * @return Message
     */
    public function setMid(string $mid): self
    {
        $this->mid = $mid;

        return $this;
    }

    /**
     * @return int
     */
    public function getSeq(): int
    {
        return $this->seq;
    }

    /**
     * @param int $seq
     *
     * @return Message
     */
    public function setSeq(int $seq): self
    {
        $this->seq = $seq;

        return $this;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     *
     * @return Message
     */
    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return Nlp
     */
    public function getNlp(): Nlp
    {
        return $this->nlp;
    }

    /**
     * @param Nlp $nlp
     *
     * @return Message
     */
    public function setNlp(Nlp $nlp): self
    {
        $this->nlp = $nlp;

        return $this;
    }
}
