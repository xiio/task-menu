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
class ValidationFailed extends \DomainException implements MenuDomainException
{
    private $errors = [];

    /**
     * @param string $fieldName
     * @param string $errorMessage
     * @param $invalidValue
     */
    public function addError(string $fieldName, string $errorMessage, $invalidValue)
    {
        $this->errors[] = [
            'field' => $fieldName,
            'error' => $errorMessage,
            'invalidValue' => $invalidValue
        ];
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
