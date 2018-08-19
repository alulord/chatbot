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

namespace ChatBot\FbBot\Handler;

use ChatBot\FbBot\Entity\Messaging;
use ChatBot\FbBot\Provider\NlpProviderInterface;

/**
 * Class NlpHandler
 *
 * @package ChatBot\FbBot\Handler
 *
 * @author Peter Simoncic <peter.simoncic@smeonline.sk>
 */
class NlpHandler
{

    public const NO_NLP_MESSAGE = 'I\'m really sorry, but I didn\' understand your request. Can you rephrase it for me please?';

    /**
     * @var NlpProviderInterface[]
     */
    private $providers = [];

    /**
     * @param NlpProviderInterface[] $providers
     */
    public function setProviders(array $providers): void
    {
        $this->providers = $providers;
    }

    /**
     *
     * @param Messaging $messaging
     *
     * @return array
     */
    public function handleNlp(Messaging $messaging): array
    {
        $replies = [];
        foreach ($messaging->getMessage()->getNlp()->getEntities() as $entityName => $entity) {
            if (false === isset($this->providers[$entityName])) {
                /* Maybe we want to log this? */
                continue;
            }
            $replies[] = $this->providers[$entityName]->handleEntity($entity);
        }
        if (empty($replies)) {
            $replies[] = self::NO_NLP_MESSAGE;
        }

        return $replies;
    }
}
