<?php

namespace App\Entity;


trait TimesTamp
{
    /**
     * @ORM\Column(type="datetime")
   */
  
    private $createdAt;

    /**
     * Get the value of createdAt
     */ 
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
        $this->createdAt = new \DateTime();
    }
}