<?php declare(strict_types=1);
/**
 * Recruitment task for Cobiro ApS
 *
 * @author Tomasz Ksionek <dev@ksionek.com>
 */

namespace App\Domain\Menu\Entity;

use App\Domain\Menu\Exception\ValidationFailed;

/**
 * @package App\Domain\Menu\Entity
 */
class Menu
{

    /**
     * @var mixed
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $maxDepth;

    /**
     * @var int
     */
    private $maxChildren;

    /**
     * @var Item[]
     */
    private $children;

    /**
     * @param $id
     * @param string $name
     * @param int $maxDepth
     * @param int $maxChildren
     */
    public function __construct($id, string $name, int $maxDepth, ?int $maxChildren)
    {
        $this->validate($id, $name, $maxDepth, $maxChildren);

        $this->id = $id;
        $this->name = $name;
        $this->maxDepth = $maxDepth;
        $this->maxChildren = $maxChildren;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getMaxDepth(): ?int
    {
        return $this->maxDepth;
    }

    /**
     * @return int
     */
    public function getMaxChildren(): ?int
    {
        return $this->maxChildren;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param int $maxDepth
     */
    public function setMaxDepth(int $maxDepth): void
    {
        $this->maxDepth = $maxDepth;
    }

    /**
     * @param int $maxChildren
     */
    public function setMaxChildren(int $maxChildren): void
    {
        $this->maxChildren = $maxChildren;
    }

    /**
     * @param $id
     * @param string $name
     * @param int|null $maxDepth
     * @param int|null $maxChildrenInNode
     * @throws ValidationFailed
     */
    private function validate($id, string $name, ?int $maxDepth, ?int $maxChildrenInNode)
    {
        $validationException = new ValidationFailed("Validation errors");
        $error = false;
        if ($id === false || $id === null) {
            $error = true;
            $validationException->addError('id', 'Id cannot be null or false.', $id);
        }

        if (strlen($name) === 0) {
            $error = true;
            $validationException->addError('name', 'Name cannot be empty.', $name);
        }

        if ($maxDepth < 0) {
            $error = true;
            $validationException->addError('maxDepth', 'Max depth cannot be less than 0.', $maxDepth);
        }

        if ($maxChildrenInNode < 0) {
            $error = true;
            $validationException->addError('maxChildren', 'Max children cannot be less than 0.', $maxChildrenInNode);
        }

        if ($error) {
            throw $validationException;
        }
    }
}
