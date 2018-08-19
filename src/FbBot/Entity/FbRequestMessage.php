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
 * Class FbRequestMessage
 *
 * @package ChatBot\FbBot\Entity
 *
 * @author Peter Simoncic <peter.simoncic@smeonline.sk>
 */
class FbRequestMessage extends Message
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
     * @return FbRequestMessage
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
     * @return FbRequestMessage
     */
    public function setSeq(int $seq): self
    {
        $this->seq = $seq;

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
     * @return FbRequestMessage
     */
    public function setNlp(Nlp $nlp): self
    {
        $this->nlp = $nlp;

        return $this;
    }
}
