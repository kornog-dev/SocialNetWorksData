<?php

namespace App\Entity;

use App\Repository\PostDataRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PostDataRepository::class)
 */
class PostData
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Post::class, inversedBy="data")
     * @ORM\JoinColumn(nullable=false)
     */
    private $post;

    /**
     * @ORM\ManyToOne(targetEntity=SocialNetwork::class, inversedBy="postData")
     * @ORM\JoinColumn(nullable=false)
     */
    private $network;

    /**
     * @ORM\Column(type="integer")
     */
    private $likes;

    /**
     * @ORM\Column(type="integer")
     */
    private $engagement;

    /**
     * @ORM\Column(type="integer")
     */
    private $cover;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPost(): ?Post
    {
        return $this->post;
    }

    public function setPost(?Post $post): self
    {
        $this->post = $post;

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

    public function getLikes(): ?int
    {
        return $this->likes;
    }

    public function setLikes(int $likes): self
    {
        $this->likes = $likes;

        return $this;
    }

    public function getEngagement(): ?int
    {
        return $this->engagement;
    }

    public function setEngagement(int $engagement): self
    {
        $this->engagement = $engagement;

        return $this;
    }

    public function getCover(): ?int
    {
        return $this->cover;
    }

    public function setCover(int $cover): self
    {
        $this->cover = $cover;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $date): self
    {
        $this->createdAt = $date;

        return $this;
    }
}
