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
 * Class GreetingsProvider
 *
 * @package ChatBot\FbBot\Provider
 *
 * @author Peter Simoncic <peter.simoncic@smeonline.sk>
 */
class GreetingsProvider implements ProviderInterface
{
//
//    public function getNlpEntityName(): string
//    {
//        return 'greetings';
//    }

    public function handleEntity(array $entity): void
    {
        dump($entity);
    }
}
