<?php

namespace App\Entity;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;


/**
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks()
 */
class BaseEntity
{

     

    /**
     * @ORM\Column(name="uid", type="string", length=32)
     */
    private $uid;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreated;

    

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateModified;

    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default":1})
     */
    private $enabled = true;

    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default":0})
     */
    private $deleted = false;



    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function setDateCreated(\DateTimeInterface $dateCreated): self
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

   


    public function getDateModified(): ?\DateTimeInterface
    {
        return $this->dateModified;
    }

    public function setDateModified(\DateTimeInterface $dateModified): self
    {
        $this->dateModified = $dateModified;

        return $this;
    }

    /**
     * @ORM\PostPersist
     */
    public function onPostPersist(LifecycleEventArgs $args)
    {
    }

    /**
     * @ORM\PostRemove
     */
    public function onPostRemove(LifecycleEventArgs $args)
    {
    }

    /**
     * @ORM\PostUpdate
     */
    public function onPostUpdate(LifecycleEventArgs $args)
    {
    }

    /**
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->dateCreated = new \DateTime();
        $this->dateModified = new \DateTime();

        if (! $this->uid) {
            $this->uid = md5(uniqid() . rand(1, 999999999999999));
        }
        
    }

    /**
     * @ORM\PreRemove
     */
    public function onPreRemove(LifecycleEventArgs $args)
    {

        $this->dateModified = new \DateTime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function onPreUpdate(PreUpdateEventArgs $args)
    {

        $this->dateModified = new \DateTime();
    }

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(?bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function getDeleted(): ?bool
    {
        return $this->deleted;
    }

    public function setDeleted(?bool $deleted): self
    {
        $this->deleted = $deleted;

        return $this;
    }

    public function getUid(): ?string
    {
        return $this->uid;
    }

    public function setUid(string $uid): self
    {
        $this->uid = $uid;

        return $this;
    }

}
