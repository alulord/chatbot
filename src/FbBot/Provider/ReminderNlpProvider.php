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
 * Class ReminderNlpProvider
 *
 * @package ChatBot\FbBot\Provider
 *
 * @author Peter Simoncic <peter.simoncic@smeonline.sk>
 */
class ReminderNlpProvider implements NlpProviderInterface
{
    public const REMINDER_REPLY_TEMPLATE = 'Don\'t worry, I will remind you to "%s"';

    public const BAD_DATE_REPLY_TEMPLATE = ', but you have to specify time more precisely';

    /**
     * @param array $entities
     *
     * @return string
     */
    public function handleEntities(array $entities): string
    {
        $reminders = array_map(
            function ($reminder) {
                return $reminder['value'];
            },
            $entities['reminder']
        );

        $message = sprintf(self::REMINDER_REPLY_TEMPLATE, implode('", "', $reminders));
        return $this->addDate($entities, $message);
    }

    /**
     * @param array  $entities
     * @param string $message
     *
     * @return string
     */
    private function addDate(array $entities, string $message): string
    {
        if (false === isset($entities['datetime'])) {
            return $message;
        }
        // we only support concrete date/time format, no ranges
        if (false === isset($entities['datetime'][0]['values'][0])
            || false === isset($entities['datetime'][0]['values'][0]['value'])) {
            return $message.self::BAD_DATE_REPLY_TEMPLATE;
        }
        $dateTime = new \DateTime($entities['datetime'][0]['values'][0]['value']);
        if (false !== $dateTime) {
            $message .= ' '.$dateTime->format('d.m.Y \a\t H:i');
        }

        return $message;
    }
}
