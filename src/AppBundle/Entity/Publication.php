<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Publication
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Publication
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
	 * @ORM\Column(name="title", type="string", length=255)
	 */
	private $title;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="publicationEarliest", type="date")
	 */
	private $publicationEarliest;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="publicationLatest", type="date")
	 */
	private $publicationLatest;

	/**
	 * @ORM\ManyToOne(targetEntity="Publisher")
	 * @ORM\JoinColumn(name="publisher_id", referencedColumnName="id")
	 **/
	private $publisher;


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
	 * Set publicationEarliest
	 *
	 * @param \DateTime $publicationEarliest
	 * @return Publication
	 */
	public function setPublicationEarliest($publicationEarliest)
	{
		$this->publicationEarliest = $publicationEarliest;

		return $this;
	}

	/**
	 * Get publicationEarliest
	 *
	 * @return \DateTime 
	 */
	public function getPublicationEarliest()
	{
		return $this->publicationEarliest;
	}

	/**
	 * Set publicationLatest
	 *
	 * @param \DateTime $publicationLatest
	 * @return Publication
	 */
	public function setPublicationLatest($publicationLatest)
	{
		$this->publicationLatest = $publicationLatest;

		return $this;
	}

	/**
	 * Get publicationLatest
	 *
	 * @return \DateTime 
	 */
	public function getPublicationLatest()
	{
		return $this->publicationLatest;
	}

	/**
	 * Set publisher
	 *
	 * @param \AppBundle\Entity\Publisher $publisher
	 * @return Publication
	 */
	public function setPublisher(\AppBundle\Entity\Publisher $publisher = null)
	{
		$this->publisher = $publisher;

		return $this;
	}

	/**
	 * Get publisher
	 *
	 * @return \AppBundle\Entity\Publisher 
	 */
	public function getPublisher()
	{
		return $this->publisher;
	}

	public function getDatingString() {

		$ret = "";

		if ($this->publicationEarliest && $this->publicationLatest) {

			$earliestYear = $this->publicationEarliest->format("Y");
			$latestYear = $this->publicationLatest->format("Y");

			if ($earliestYear == $latestYear) {

				$ret = $ret.$earliestYear;

			} else {

				$ret = $ret.$earliestYear." - ".$latestYear;

			}

		}

		return $ret;

	}


	public function __toString()
	{
		if ($this->publicationEarliest) {
			return $this->title . ', ' . $this->getDatingString();
		} else if ($this->title) {
			
			return $this->title;
		}
		return "not set";
	}

	/**
	 * Set title
	 *
	 * @param string $title
	 * @return Publication
	 */
	public function setTitle($title)
	{
		$this->title = $title;

		return $this;
	}

	/**
	 * Get title
	 *
	 * @return string 
	 */
	public function getTitle()
	{
		return $this->title;
	}
}
