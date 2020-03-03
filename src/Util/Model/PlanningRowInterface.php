<?php
/**
 * Created by PhpStorm.
 * User: smartworld
 * Date: 3/3/20
 * Time: 4:33 PM.
 */

namespace App\Util\Model;

interface PlanningRowInterface
{
    /**
     * Returns the section title (which will be translated).
     */
    public function getTitle(): string;

    /**
     * Returns whether the given permission is part of this section.
     */
    public function array(string $permission): bool;
}
