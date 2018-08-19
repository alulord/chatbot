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
use ChatBot\FbBot\Exception\BadProviderChosenException;
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
     * @return string
     */
    public function handleNlp(Messaging $messaging): string
    {
        $entityNames = $this->getMessageEntityNames($messaging);
        $providers = $this->getBestMatchingProvider($entityNames);
        $message = self::NO_NLP_MESSAGE;

        // we get the first one working
        foreach ($providers as $provider) {
            try {
                return $provider->handleEntities($messaging->getMessage()->getNlp()->getEntities());
            } catch (BadProviderChosenException $e) {
//                Maybe log this so we can improve next matches?
            }
        }

        return $message;
    }

    /**
     * @param Messaging $messaging
     *
     * @return array
     */
    private function getMessageEntityNames(Messaging $messaging): array
    {
        return array_keys($messaging->getMessage()->getNlp()->getEntities());
    }

    /**
     * This will choose best maching provider based on how many entity names it contains
     *
     * @param array $entityNames
     *
     * @return NlpProviderInterface[]
     */
    private function getBestMatchingProvider(array $entityNames): array
    {
        $max = 0;
        $bestProviders = [];
        foreach ($this->providers as $providerKey => $provider) {
            $intersect = array_intersect($entityNames, explode(' ', $providerKey));
            $intersectCount = count($intersect);
            if ($intersectCount > 0 && $intersectCount >= $max) {
                $max = $intersectCount;
                $bestProviders[] = $provider;
            }
        }

        return array_reverse($bestProviders);
    }
}
