<?php declare(strict_types=1);
/**
 * Recruitment task for Cobiro ApS
 *
 * @author Tomasz Ksionek <dev@ksionek.com>
 */

namespace App\Domain\Menu\Exception;

/**
 * @package App\Domain\Menu\Exception
 */
class ChildrenLimitExceeded extends \DomainException implements MenuDomainException
{

    /**
     * @param $childrenLimit
     */
    public function __construct(int $childrenLimit)
    {
        parent::__construct('Children limit exceeded. Maximum children: ' . $childrenLimit);
    }
}
