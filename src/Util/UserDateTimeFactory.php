<?php

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Util;

use App\Entity\User;
use Symfony\Component\Security\Core\Security;

class UserDateTimeFactory
{
    /**
     * @var \DateTimeZone
     */
    protected $timezone;

    public function __construct(Security $user)
    {
        $timezone = date_default_timezone_get();

        $user = $user->getUser();
        if ($user instanceof User) {
            //$timezone = $user->getTimezone();
        }

        $this->timezone = new \DateTimeZone($timezone);
    }

    public function getTimezone(): \DateTimeZone
    {
        return $this->timezone;
    }

    public function getStartOfMonth(): \DateTime
    {
        $date = $this->createDateTime('first day of this month');
        $date->setTime(0, 0, 0);

        return $date;
    }

    public function getEndOfMonth(): \DateTime
    {
        $date = $this->createDateTime('last day of this month');
        $date->setTime(23, 59, 59);

        return $date;
    }

    public function createDateTime(string $datetime = 'now'): \DateTime
    {
        $date = new \DateTime($datetime, $this->timezone);

        return $date;
    }

    /**
     * @param string $format
     * @param null|string $datetime
     * @return bool|\DateTime
     */
    public function createDateTimeFromFormat(string $format, ?string $datetime = 'now')
    {
        $date = \DateTime::createFromFormat($format, $datetime, $this->timezone);

        return $date;
    }
}
