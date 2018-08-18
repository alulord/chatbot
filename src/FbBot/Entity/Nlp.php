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
 * Class Nlp
 *
 * @package ChatBot\FbBot\Entity
 *
 * @author Peter Simoncic <peter.simoncic@smeonline.sk>
 */
class Nlp
{
    /**
     * @var array
     */
    private $entities;

    /**
     * @return array
     */
    public function getEntities(): array
    {
        return $this->entities;
    }

    /**
     * @param array $entities
     *
     * @return Nlp
     */
    public function setEntities(array $entities): self
    {
        $this->entities = $entities;

        return $this;
    }
}
