<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\HasLifecycleCallbacks
 */
trait TimestampableTrait
{
    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps(): void
    {
        $dateTimeNow = new \DateTime('now');

        if ($this->getCreatedAt() === null) {
            $this->setCreatedAt($dateTimeNow);
        }

        $this->setUpdatedAt($dateTimeNow);
    }

    /**
     * getCreatedAt
     *
     * @access public
     * @return ?\DateTimeInterface
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    } // End function getCreatedAt

    /**
     * setCreatedAt
     *
     * @param ?\DateTimeInterface $createdAt
     * @access public
     * @return self
     */
    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    } // End function setCreatedAt

    /**
     * getUpdatedAt
     *
     * @access public
     * @return ?\DateTimeInterface
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    } // End function getUpdatedAt

    /**
     * setUpdatedAt
     *
     * @param ?\DateTimeInterface $createdAt
     * @access public
     * @return self
     */
    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    } // End function setUpdatedAt
}
