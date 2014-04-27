<?php

namespace ProjectManager\ParameterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PossibleValue
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ProjectManager\ParameterBundle\Entity\PossibleValueRepository")
 */
class PossibleValue
{
    /**
     * @ORM\ManyToOne(targetEntity="Parameter", inversedBy="possiblevalues")
     * @ORM\JoinColumn(nullable=false)
     **/
    private $parameter;
        
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
     * @ORM\Column(name="value", type="string", length=50)
     */
    private $value;


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
     * Set value
     *
     * @param string $value
     * @return PossibleValue
     */
    public function setValue($value)
    {
        $this->value = $value;
    
        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set parameter
     *
     * @param \ProjectManager\ParameterBundle\Entity\Parameter $parameter
     * @return PossibleValue
     */
    public function setParameter(\ProjectManager\ParameterBundle\Entity\Parameter $parameter)
    {
        $this->parameter = $parameter;
    
        return $this;
    }

    /**
     * Get parameter
     *
     * @return \ProjectManager\ParameterBundle\Entity\Parameter 
     */
    public function getParameter()
    {
        return $this->parameter;
    }
}