<?php

namespace OC\PlatformBundle\Entity;

/**
 * Advert
 *
 * @ORM\Table(name="advert")
 * @ORM\Entity(repositoryClass="OC\PlatformBundle\Entity\AdvertRepository")
 */
class Advert {


  /**
   * @var int
   */
  private $id;

  /**
   * @var string
   */
  private $title;

  /**
   * @var string
   */
  private $author;

  /**
   * @var \DateTime
   */
  private $date;

  /**
   * @var string
   */
  private $content;

  /**
   * @var boolean
   */
  private $published = TRUE;


  /**
   * @ORM\OneToOne(targetEntity="OC\PlatformBundle\Entity\Image", cascade={"persist"})
   */
  private $image;


  public function __construct() {
    $this->date = new \Datetime();
  }

  /**
   * Get id.
   *
   * @return int
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Set title.
   *
   * @param string $title
   *
   * @return Advert
   */
  public function setTitle($title) {
    $this->title = $title;

    return $this;
  }

  /**
   * Get title.
   *
   * @return string
   */
  public function getTitle() {
    return $this->title;
  }

  /**
   * Set author.
   *
   * @param string $author
   *
   * @return Advert
   */
  public function setAuthor($author) {
    $this->author = $author;

    return $this;
  }

  /**
   * Get author.
   *
   * @return string
   */
  public function getAuthor() {
    return $this->author;
  }

  /**
   * Set date.
   *
   * @param \DateTime $date
   *
   * @return Advert
   */
  public function setDate($date) {
    $this->date = $date;

    return $this;
  }

  /**
   * Get date.
   *
   * @return \DateTime
   */
  public function getDate() {
    return $this->date;
  }

  /**
   * Set content.
   *
   * @param string $content
   *
   * @return Advert
   */
  public function setContent($content) {
    $this->content = $content;

    return $this;
  }

  /**
   * Get content.
   *
   * @return string
   */
  public function getContent() {
    return $this->content;
  }

  /**
   * Set published.
   *
   * @param bool $published
   *
   * @return Advert
   */
  public function setPublished($published) {
    $this->published = $published;

    return $this;
  }

  /**
   * Get published.
   *
   * @return bool
   */
  public function getPublished() {
    return $this->published;
  }


  public function setImage(Image $image = NULL) {
    $this->image = $image;
  }

  public function getImage() {
    return $this->image;
  }
}
