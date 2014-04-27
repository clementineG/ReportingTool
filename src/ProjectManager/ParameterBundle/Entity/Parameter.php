<?php

namespace ProjectManager\ParameterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Parameter
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ProjectManager\ParameterBundle\Entity\ParameterRepository")
 * @UniqueEntity(fields="name", message="Un autre paramètre du même nom est déjà défini.")
 */
class Parameter
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="ProjectManager\ParameterBundle\Entity\Type")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity="PossibleValue", mappedBy="parameter")     
     */
    private $possiblevalues;
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Parameter
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * Set type
     *
     * @param \ProjectManager\ParameterBundle\Entity\Type $type
     * @return Parameter
     */
    public function setType(\ProjectManager\ParameterBundle\Entity\Type $type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return \ProjectManager\ParameterBundle\Entity\Type 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->possiblevalues = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add possiblevalues
     *
     * @param \ProjectManager\ParameterBundle\Entity\PossibleValue $possiblevalues
     * @return Parameter
     */
    public function addPossiblevalue(\ProjectManager\ParameterBundle\Entity\PossibleValue $possiblevalues)
    {
        $this->possiblevalues[] = $possiblevalues;
    
        return $this;
    }

    /**
     * Remove possiblevalues
     *
     * @param \ProjectManager\ParameterBundle\Entity\PossibleValue $possiblevalues
     */
    public function removePossiblevalue(\ProjectManager\ParameterBundle\Entity\PossibleValue $possiblevalues)
    {
        $this->possiblevalues->removeElement($possiblevalues);
    }

    /**
     * Get possiblevalues
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPossiblevalues()
    {
        return $this->possiblevalues;
    }
}