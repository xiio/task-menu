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
class NestingDepthLimitExceeded extends \DomainException implements MenuDomainException
{

    /**
     * @param $depthLimit
     */
    public function __construct(int $depthLimit)
    {
        parent::__construct('Nesting limit exceeded. Nesting depth limit: ' . $depthLimit);
    }
}
