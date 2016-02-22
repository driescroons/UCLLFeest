<?php
/**
 * Created by PhpStorm.
 * User: sven smets
 * Date: 11-2-2016
 * Time: 16:46
 */

//src/AppBundle/Entity/Event.php
namespace AppBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 *@ORM\Entity
 *@ORM\Entity(repositoryClass="AppBundle\Entity\EventRepository")
 *@ORM\Table(name="app_events")
 */
class Event
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string",length=100)
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @ORM\Column(type="string",length=60)
     * @Assert\NotBlank
     */
    private $adress;

    /**
     * @ORM\Column(type="string",length=50)
     * @Assert\NotBlank
     */
    private $city;

    /**
     * @ORM\Column(type="string",length=4)
     * @Assert\Length(min = 4, max=4, minMessage = "The Postal code needs to be four numbers")
     * @Assert\Type(type="integer")
     * @Assert\NotBlank
     */
    private $postalCode;

    /**
     * @ORM\Column(type="decimal",scale=2)
     * @Assert\NotBlank
     */
    private $price;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank
     */
    private $date;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $capacity;

    /**
     * @ORM\ManyToOne(targetEntity="User",inversedBy="events")
     * @ORM\JoinColumn(name="creator_id", referencedColumnName="id")
     */
    private $creator;

    /**
     * @ORM\OneToOne(targetEntity="Foto", mappedBy="event")
     * @ORM\JoinColumn(name="foto_id", referencedColumnName="id", nullable=true)
     */
    private $foto;


    /**
     * @ORM\OneToMany(targetEntity="Ticket", mappedBy="event")
     */
    private $tickets;

    /**
     * @ORM\ManyToOne(targetEntity="Venue",inversedBy="events")
     * @ORM\JoinColumn(name="venue_id", referencedColumnName="id", nullable=true)
     */
    private $venue;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tickets = new ArrayCollection();
    }

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
     * @return Event
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
     * Set Adress
     *
     * @param string $adress
     * @return Event
     */
    public function setAdress($adress)
    {
        $this->adress = $adress;

        return $this;
    }

    /**
     * Get Adress
     *
     * @return string 
     */
    public function getAdress()
    {
        return $this->adress;
    }

    /**
     * Set City
     *
     * @param string $city
     * @return Event
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get City
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set PostalCode
     *
     * @param string $postalCode
     * @return Event
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * Get PostalCode
     *
     * @return string 
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    public function getFullAdress()
    {
        return $this->getAdress() . ", " . $this->getPostalCode() . " " . $this->getCity();
    }

    /**
     * Set Price
     *
     * @param string $price
     * @return Event
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get Price
     *
     * @return string 
     */
    public function getPrice()
    {
        return $this->price;
    }


    /**
     * Set Description
     *
     * @param string $description
     * @return Event
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get Description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set creator
     *
     * @param User $creator
     * @return Event
     */
    public function setCreator(User $creator = null)
    {
        $this->creator = $creator;

        return $this;
    }

    /**
     * Get creator
     *
     * @return User
     */
    public function getCreator()
    {
        return $this->creator;
    }


    /**
     * Set foto
     *
     * @param Foto $foto
     * @return Event
     */
    public function setFoto(Foto $foto = null)
    {
        $this->foto = $foto;

        return $this;
    }

    /**
     * Get foto
     *
     * @return Foto
     */
    public function getFoto()
    {
        return $this->foto;
    }



    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Event
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set capacity
     *
     * @param integer $capacity
     * @return Event
     */
    public function setCapacity($capacity)
    {
        $this->capacity = $capacity;

        return $this;
    }

    /**
     * Get capacity
     *
     * @return integer 
     */
    public function getCapacity()
    {
        return $this->capacity;
    }

    /**
     * Add ticket
     *
     * @param Ticket $ticket
     * @return Event
     */
    public function addTicket(Ticket $ticket)
    {
        $this->tickets->add($ticket);

        return $this;
    }

    /**
     * Remove ticket
     *
     * @param Ticket $ticket
     */
    public function removeTicket(Ticket $ticket)
    {
        $this->tickets->removeElement($ticket);
    }

    /**
     * Get tickets
     *
     * @return ArrayCollection
     */
    public function getTickets()
    {
        return $this->tickets;
    }

    /**
     * Set venue
     *
     * @param \AppBundle\Entity\Venue $venue
     * @return Event
     */
    public function setVenue(\AppBundle\Entity\Venue $venue = null)
    {
        $this->venue = $venue;

        return $this;
    }

    /**
     * Get venue
     *
     * @return \AppBundle\Entity\Venue 
     */
    public function getVenue()
    {
        return $this->venue;
    }
}
