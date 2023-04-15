<?php

namespace App\Entity;

use App\Repository\LinkStatRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LinkStatRepository::class)
 * @ORM\Table(name="link_stat",indexes={
 *     @ORM\Index(name="link_stat_visit_count_index", columns={"visit_count"}),
 * })
 */
class LinkStat
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\OneToOne(targetEntity=Link::class, inversedBy="stat", cascade={"persist", "remove"})
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $link;

	/**
	 * @ORM\Column(type="integer")
	 */
	private $visit_count;

	public function __construct()
	{
		$this->visit_count = 0;
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getLink(): ?Link
	{
		return $this->link;
	}

	public function setLink( Link $link ): self
	{
		$this->link = $link;

		return $this;
	}

	public function getVisitCount(): ?int
	{
		return $this->visit_count;
	}

	public function setVisitCount( int $visit_count ): self
	{
		$this->visit_count = $visit_count;

		return $this;
	}
}
