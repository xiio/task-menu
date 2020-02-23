<?php declare(strict_types=1);
/**
 * Recruitment task for Cobiro ApS
 *
 * @author Tomasz Ksionek <dev@ksionek.com>
 */

namespace App\Domain\Menu\Service;

/**
 * @package App\Domain\Menu\Service
 */
interface IdentityGenerator
{
    /**
     * Generate id
     * @return mixed
     */
    public function generate();
}
