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

namespace ChatBot\FbBot\Provider;

/**
 * Class ByeNlpProvider
 *
 * @package ChatBot\FbBot\Provider
 *
 * @author Peter Simoncic <peter.simoncic@smeonline.sk>
 */
class ByeNlpProvider implements NlpProviderInterface
{

    /**
     * @var array
     */
    private $replies = [
        'Bye',
        'See you',
        'Adios',
        'It was nice having you',
    ];

    /**
     * @param array $entities
     *
     * @return string
     */
    public function handleEntities(array $entities): string
    {
        return $this->replies[array_rand($this->replies)];
    }
}
