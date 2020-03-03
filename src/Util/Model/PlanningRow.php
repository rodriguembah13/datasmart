<?php
/**
 * Created by PhpStorm.
 * User: smartworld
 * Date: 3/3/20
 * Time: 4:30 PM.
 */

namespace App\Util\Model;

class PlanningRow implements PlanningRowInterface
{
    /**
     * @var string
     */
    private $title;
    /**
     * @var string
     */
    private $array = [];

    /**
     * Returns the section title (which will be translated).
     */
    public function getTitle(): string
    {
        // TODO: Implement getTitle() method.
    }

    /**
     * Returns whether the given permission is part of this section.
     */
    public function array(string $permission): bool
    {
        // TODO: Implement array() method.
    }
}
