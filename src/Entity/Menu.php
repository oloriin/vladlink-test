<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Menu
 *
 * @Entity(repositoryClass="App\Repository\MenuRepository")
 * @Table(name="menu")
 */
class Menu
{
    /**
     * @var int
     *
     * @Column(name="id", type="integer")
     * @Id
     */
    private $id;

    /**
     * @var string
     *
     * @Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @Column(name="alias", type="string", length=255)
     */
    private $alias;

    /**
     * @ManyToOne(targetEntity="Menu", inversedBy="children")
     * @JoinColumn(name="parent_id", referencedColumnName="id")
     */
    protected $parent;

    /**
     * @OneToMany(targetEntity="Menu", mappedBy="parent")
     */
    protected $children;

    public function __construct()
    {
        $this->children = new ArrayCollection();
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function getChildren()
    {
        return $this->children;
    }

    public function addChild(Menu $child)
    {
        $this->children[] = $child;
        $child->setParent($this);
    }

    public function setParent(Menu $parent)
    {
        $this->parent = $parent;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return static
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return static
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getAlias(): string
    {
        return $this->alias;
    }

    /**
     * @param string $alias
     * @return static
     */
    public function setAlias(string $alias): self
    {
        $this->alias = $alias;
        return $this;
    }
}
