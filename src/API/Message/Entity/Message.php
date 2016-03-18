<?php
/**
 * Created by PhpStorm.
 * User: Marcos
 * Date: 17/03/2016
 * Time: 03:05
 */

namespace API\Message\Entity;



use Doctrine\Common\Collections\ArrayCollection;
use API\Interfaces\EntityInterface;
use API\Message\Interfaces\MessageInterface;
use Psr\Log\InvalidArgumentException;

use Doctrine\ORM\Mapping as ORM;
use Silex\Application;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;

/**
 * @ORM\Entity(repositoryClass="API\Message\Entity\MessageRepository")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="message")
 */

class Message implements EntityInterface, MessageInterface {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=140, nullable=true)
     */
    private $message;

    /**
     * @ORM\ManyToMany(targetEntity="API\Message\Entity\Tag")
     * @ORM\JoinTable(name="message_tags",
     * joinColumns={@ORM\JoinColumn(name="message_id", referencedColumnName="id", onDelete="CASCADE")},
     * inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id", onDelete="CASCADE")}
     * )
     */
    private $tags;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;


    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->tags = new ArrayCollection();
    }

    /** @ORM\PrePersist */
    public function setupDate()
    {
        $this->createdAt = new \DateTime('now');
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        if(!is_int($id))
        {
            throw new InvalidArgumentException("O ID do produto deve ser numérico!");
        }

        $this->id = $id;
    }


    /**
     * @return mixed
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param $tag
     */
    public function addTag($tag)
    {
        $this->tags->add($tag);
    }


}