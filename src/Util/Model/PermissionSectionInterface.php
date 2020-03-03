<?php

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Util\Model;

interface PermissionSectionInterface
{
    /**
     * Returns the section title (which will be translated).
     */
    public function getTitle(): string;

    /**
     * Returns whether the given permission is part of this section.
     */
    public function filter(string $permission): bool;
}
