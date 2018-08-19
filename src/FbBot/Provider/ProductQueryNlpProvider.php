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

use ChatBot\FbBot\Exception\BadProviderChosenException;

/**
 * Class ProductQueryNlpProvider
 *
 * @package ChatBot\FbBot\Provider
 *
 * @author Peter Simoncic <peter.simoncic@smeonline.sk>
 */
class ProductQueryNlpProvider implements NlpProviderInterface
{
    public const GOOD_REPLY_TEMPLATE = '%s costs %s';

    public const MISSING_PRODUCT_TEMPLATE = 'I don\'t have info about %s';

    public const BAD_REPLY_TEMPLATE = 'Sorry I don\'t have info about that product';

    /**
     * @var array
     */
    private $products = [
        'table' => '$10',
        'chair' => '$15',
        'pc' => '$1500',
    ];

    /**
     * @param array $entities
     *
     * @return string
     */
    public function handleEntities(array $entities): string
    {
        if (false === isset($entities['product'])) {
            throw new BadProviderChosenException();
        }
        $replies = [];
        foreach ($entities['product'] as $productArray) {
            $productName = mb_strtolower($productArray['value']);
            if (false !== isset($this->products[$productName])) {
                $replies[] = sprintf(self::GOOD_REPLY_TEMPLATE, ucfirst($productName), $this->products[$productName]);
            } else {
                $replies[] = sprintf(self::MISSING_PRODUCT_TEMPLATE, ucfirst($productName));
            }
        }
        if (empty($replies)) {
            $replies[] = sprintf(self::BAD_REPLY_TEMPLATE);
        }

        return implode('. ', $replies);
    }
}
