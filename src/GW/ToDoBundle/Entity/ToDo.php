<?php

namespace GW\ToDoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ToDo
 *
 * @ORM\Table(name="to_do")
 * @ORM\Entity(repositoryClass="GW\ToDoBundle\Repository\ToDoRepository")
 */
class ToDo
{
    /**
     * @var int
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
     * @Assert\NotNull( message = "Veuillez donner un titre à votre ToDo" )
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     * @Assert\NotNull( message = "Veuillez donner un contenue à votre ToDo" )
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expiration", type="datetime")
     * @Assert\NotNull( message = "Veuillez donner une date d'expiration à votre ToDo" )
     * @Assert\Range( min = "now" , minMessage = "La date d'expiration ne peut pas être inferieur a la date d'aujourd'hui")
     */
    private $expiration;

    /**
     * @ORM\ManyToOne(targetEntity="GW\ToDoBundle\Entity\Project", inversedBy="todos")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull( message = "Veuillez assigné un projet à votre ToDo" )
     * @Assert\Valid()
     */
    private $project;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return ToDo
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

    /**
     * Set content
     *
     * @param string $content
     *
     * @return ToDo
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set expiration
     *
     * @param \DateTime $expiration
     *
     * @return ToDo
     */
    public function setExpiration($expiration)
    {
        $this->expiration = $expiration;

        return $this;
    }

    /**
     * Get expiration
     *
     * @return \DateTime
     */
    public function getExpiration()
    {
        return $this->expiration;
    }

    /**
     * Set Project
     *
     * @param \GW\ToDoBundle\Entity\Project $project
     * @return ToDo
     */
    public function setProject(\GW\ToDoBundle\Entity\Project $project)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get Project
     *
     * @return \GW\ToDoBundle\Entity\Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
    * constructor
    *
    * @return \DateTime
    */
    public function __construct()
    {
      $this->expiration = new \Datetime('tomorrow');
    }

}
