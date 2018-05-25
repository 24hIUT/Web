<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $eMail;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Event", mappedBy="owner")
     */
    private $eventOwned;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Event", inversedBy="participants")
     */
    private $attendace;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $profilePicture;

    public function __construct()
    {
        $this->eventOwned = new ArrayCollection();
        $this->attendace = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getEMail(): ?string
    {
        return $this->eMail;
    }

    public function setEMail(string $eMail): self
    {
        $this->eMail = $eMail;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return Collection|Event[]
     */
    public function getEventOwned(): Collection
    {
        return $this->eventOwned;
    }

    public function addEventOwned(Event $eventOwned): self
    {
        if (!$this->eventOwned->contains($eventOwned)) {
            $this->eventOwned[] = $eventOwned;
            $eventOwned->setOwner($this);
        }

        return $this;
    }

    public function removeEventOwned(Event $eventOwned): self
    {
        if ($this->eventOwned->contains($eventOwned)) {
            $this->eventOwned->removeElement($eventOwned);
            // set the owning side to null (unless already changed)
            if ($eventOwned->getOwner() === $this) {
                $eventOwned->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Event[]
     */
    public function getAttendace(): Collection
    {
        return $this->attendace;
    }

    public function addAttendace(Event $attendace): self
    {
        if (!$this->attendace->contains($attendace)) {
            $this->attendace[] = $attendace;
        }

        return $this;
    }

    public function removeAttendace(Event $attendace): self
    {
        if ($this->attendace->contains($attendace)) {
            $this->attendace->removeElement($attendace);
        }

        return $this;
    }

    public function getProfilePicture(): ?string
    {
        return $this->profilePicture;
    }

    public function setProfilePicture(?string $profilePicture): self
    {
        $this->profilePicture = $profilePicture;

        return $this;
    }
}
