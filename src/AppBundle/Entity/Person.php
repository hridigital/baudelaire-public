<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Person
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Person
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
     * @ORM\Column(name="given", type="string", length=255)
     */
    private $given;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=255)
     */
    private $surname;
    
   /**
     * @ORM\ManyToMany(targetEntity="Country")
     * @ORM\JoinTable(name="persons_countrys",
     *      joinColumns={@ORM\JoinColumn(name="person_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="country_id", referencedColumnName="id")}
     *      )
     **/
    private $countrys;
    
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
     * Set given
     *
     * @param string $given
     * @return Person
     */
    public function setGiven($given)
    {
        $this->given = $given;

        return $this;
    }

    /**
     * Get given
     *
     * @return string 
     */
    public function getGiven()
    {
        return $this->given;
    }

    /**
     * Set surname
     *
     * @param string $surname
     * @return Person
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string 
     */
    public function getSurname()
    {
        return $this->surname;
    }
    
    public function __toString()
	{
		return $this->given . ' ' . $this->surname;
	}
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->countrys = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add countrys
     *
     * @param \AppBundle\Entity\Country $countrys
     * @return Person
     */
    public function addCountry(\AppBundle\Entity\Country $countrys)
    {
        $this->countrys[] = $countrys;

        return $this;
    }

    /**
     * Remove countrys
     *
     * @param \AppBundle\Entity\Country $countrys
     */
    public function removeCountry(\AppBundle\Entity\Country $countrys)
    {
        $this->countrys->removeElement($countrys);
    }

    /**
     * Get countrys
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCountrys()
    {
        return $this->countrys;
    }
}
