<?php

namespace App\Entity;

use App\Repository\SocialNetworkRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SocialNetworkRepository::class)
 */
class SocialNetwork
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $logoUrl;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $profileUrl;

    /**
     * @ORM\OneToMany(targetEntity=SocialNetworkData::class, mappedBy="network")
     */
    private $data;

    public function __construct()
    {
        $this->data = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLogoUrl(): ?string
    {
        return $this->logoUrl;
    }

    public function setLogoUrl(?string $logoUrl): self
    {
        $this->logoUrl = $logoUrl;

        return $this;
    }

    public function getProfileUrl(): ?string
    {
        return $this->profileUrl;
    }

    public function setProfileUrl(string $profileUrl): self
    {
        $this->profileUrl = $profileUrl;

        return $this;
    }

    /**
     * @return Collection<int, SocialNetworkData>
     */
    public function getData(): Collection
    {
        return $this->data;
    }

    public function addData(SocialNetworkData $data): self
    {
        if (!$this->data->contains($data)) {
            $this->data[] = $data;
            $data->setManyToOne($this);
        }

        return $this;
    }

    public function removeData(SocialNetworkData $data): self
    {
        if ($this->data->removeElement($data)) {
            // set the owning side to null (unless already changed)
            if ($data->getManyToOne() === $this) {
                $data->setManyToOne(null);
            }
        }

        return $this;
    }
}
