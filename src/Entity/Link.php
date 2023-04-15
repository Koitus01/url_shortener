<?php

namespace App\Entity;

use App\Repository\LinkRepository;
use App\ValueObject\Url;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LinkRepository::class)
 * @ORM\Table(name="link",indexes={
 *     @ORM\Index(name="link_hash_index", columns={"hash"}),
 *     @ORM\Index(name="link_created_at_index", columns={"created_at"}),
 *     @ORM\Index(name="link_deleted_at_index", columns={"deleted_at"}),
 *     @ORM\Index(name="link_host_index", columns={"host"}),
 * })
 */
class Link
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * TODO: change to UrlType?
	 * @ORM\Column(type="text")
	 */
	private $url;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $hash;

	/**
	 * @ORM\Column(type="datetime_immutable")
	 */
	private $created_at;

	/**
	 * @ORM\OneToOne(targetEntity=LinkStat::class, mappedBy="link", cascade={"persist", "remove"})
	 */
	private $stat;

	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	private $deleted_at;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private $host;

	public function __construct()
	{
		$this->created_at = new DateTimeImmutable( 'now' );
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getUrl(): Url
	{
		return Url::fromString( $this->url, false );
	}

	public function setUrl( Url $url ): self
	{
		$this->url = $url->value();

		return $this;
	}

	public function getHash(): string
	{
		return $this->hash;
	}

	public function setHash( string $hash ): self
	{
		$this->hash = $hash;

		return $this;
	}

	public function getCreatedAt(): \DateTimeImmutable
	{
		return $this->created_at;
	}

	public function setCreatedAt( \DateTimeImmutable $created_at ): self
	{
		$this->created_at = $created_at;

		return $this;
	}

	public function getStat(): ?LinkStat
	{
		return $this->stat;
	}

	public function setStat( LinkStat $stat ): self
	{
		// set the owning side of the relation if necessary
		if ( $stat->getLink() !== $this ) {
			$stat->setLink( $this );
		}

		$this->stat = $stat;

		return $this;
	}

	public function getDeletedAt(): ?\DateTimeInterface
	{
		return $this->deleted_at;
	}

	public function setDeletedAt( ?\DateTimeInterface $deleted_at ): self
	{
		$this->deleted_at = $deleted_at;

		return $this;
	}

	public function getHost(): Url
	{
		return Url::fromString( $this->url, false );
	}

	public function setHost( Url $url ): self
	{
		$this->host = $url->host();

		return $this;
	}
}
