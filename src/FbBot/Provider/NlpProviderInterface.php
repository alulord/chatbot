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
 * Interface NlpProviderInterface
 * To activate new provider, just add as service for nlp.providers e.g.:
 *     'nlp.providers' => [
 *          'greetings' => \DI\create(Provider\GreetingsNlpProvider::class),
 *          'bye' => \DI\create(Provider\ByeNlpProvider::class),
 *          'product_query product' => \DI\create(Provider\ProductQueryNlpProvider::class),
 *          'reminder' => \DI\create(Provider\ReminderNlpProvider::class),
 *     ],
 *
 * @package ChatBot\FbBot\Provider
 */
interface NlpProviderInterface
{
    /**
     * @param array $entities
     *
     * @return string
     */
    public function handleEntities(array $entities): string;
}
