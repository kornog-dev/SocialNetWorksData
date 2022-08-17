<?php

namespace App\Entity;

use App\Repository\SocialNetworkDataRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SocialNetworkDataRepository::class)
 */
class SocialNetworkData
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="integer")
     */
    private $followerCount;

    /**
     * @ORM\ManyToOne(targetEntity=SocialNetwork::class, inversedBy="data")
     * @ORM\JoinColumn(nullable=false)
     */
    private $network;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getFollowerCount(): ?int
    {
        return $this->followerCount;
    }

    public function setFollowerCount(int $followerCount): self
    {
        $this->followerCount = $followerCount;

        return $this;
    }

    public function getNetwork(): ?SocialNetwork
    {
        return $this->network;
    }

    public function setNetwork(?SocialNetwork $network): self
    {
        $this->network = $network;

        return $this;
    }
}
