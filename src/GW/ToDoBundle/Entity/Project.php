<?php

namespace GW\ToDoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Project
 *
 * @ORM\Table(name="project")
 * @ORM\Entity(repositoryClass="GW\ToDoBundle\Repository\ProjectRepository")
 */
class Project
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
     * @ORM\Column(name="Title", type="string", length=255)
     * @Assert\NotNull( message = "Veuillez donner un titre à votre Projet" )
     */
    private $title;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="GW\ToDoBundle\Entity\ToDo", mappedBy="project", cascade={"persist","remove"})
     */
    private $todos;

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
     * @return Project
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
     * Add one todo
     *
     * @param \GW\ToDoBundle\Entity\ToDo $todo
     * @return Project
     */
    public function addToDo(\GW\ToDoBundle\Entity\ToDo $todo)
    {
        $this->todos[] = $todo;

        $todo->setProject($this);

        return $this;
    }

    /**
     * Add todos
     *
     * @param $todos
     * @return Project
     */
    public function addToDos($todos)
    {
      if(is_array($todos)){
        foreach ($todos as $todo) {
          $this->addToDo($todo);
        }
      }

      return $this;
    }

    /**
     * Remove todo
     *
     * @param \GW\ToDoBundle\Entity\ToDo $todo
     */
    public function removeToDo(\GW\ToDoBundle\Entity\ToDo $todo)
    {
        $this->members->removeElement($todo);
    }

    /**
     * Get todos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getToDos()
    {
        return $this->todos;
    }


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->todos = new \Doctrine\Common\Collections\ArrayCollection();
    }
}
