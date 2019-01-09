<?php

namespace OC\PlatformBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Advert
 *
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



  private $image;


  private $categories;


  public function __construct() {
    $this->date = new \Datetime();
    $this->categories = new ArrayCollection();
    $this->applications = new ArrayCollection();

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


  /**
   * Set image.
   *
   * @param \OC\PlatformBundle\Entity\Image|null $image
   *
   * @return Advert
   */
  public function setImage(\OC\PlatformBundle\Entity\Image $image = NULL) {
    $this->image = $image;

    return $this;
  }

  /**
   * Get image.
   *
   * @return \OC\PlatformBundle\Entity\Image|null
   */
  public function getImage() {
    return $this->image;
  }


  /**
   * Add category.
   *
   * @param \OC\PlatformBundle\Entity\Category $category
   *
   * @return Advert
   */
  public function addCategory(\OC\PlatformBundle\Entity\Category $category) {
    $this->categories[] = $category;

    return $this;
  }

  /**
   * Remove category.
   *
   * @param \OC\PlatformBundle\Entity\Category $category
   *
   * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
   */
  public function removeCategory(\OC\PlatformBundle\Entity\Category $category) {
    return $this->categories->removeElement($category);
  }

  /**
   * Get categories.
   *
   * @return \Doctrine\Common\Collections\Collection
   */
  public function getCategories() {
    return $this->categories;
  }

  /**
   * @var \Doctrine\Common\Collections\Collection
   */
  private $applications;


  /**
   * Add application.
   *
   * @param \OC\PlatformBundle\Entity\Application $application
   *
   * @return Advert
   */
  public function addApplication(\OC\PlatformBundle\Entity\Application $application) {
    $this->applications[] = $application;
    $application->setAdvert($this);
    return $this;
  }

  /**
   * Remove application.
   *
   * @param \OC\PlatformBundle\Entity\Application $application
   *
   * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
   */
  public function removeApplication(\OC\PlatformBundle\Entity\Application $application) {
    return $this->applications->removeElement($application);
  }

  /**
   * Get applications.
   *
   * @return \Doctrine\Common\Collections\Collection
   */
  public function getApplications() {
    return $this->applications;
  }

  /**
   * @var \DateTime|null
   */
  private $updateAt;


  /**
   * Set updateAt.
   *
   * @param \DateTime|null $updateAt
   *
   * @return Advert
   */
  public function setUpdateAt($updateAt = NULL) {
    $this->updateAt = $updateAt;

    return $this;
  }

  /**
   * Get updateAt.
   *
   * @return \DateTime|null
   */
  public function getUpdateAt() {
    return $this->updateAt;
  }

  public function preUpdate() {
    $this->setUpdateAt(new \Datetime());
  }

  /**
   * @var int
   */
  private $nbApplications = 0;


  /**
   * Set nbApplications.
   *
   * @param int $nbApplications
   *
   * @return Advert
   */
  public function setNbApplications($nbApplications) {
    $this->nbApplications = $nbApplications;

    return $this;
  }

  /**
   * Get nbApplications.
   *
   * @return int
   */
  public function getNbApplications() {
    return $this->nbApplications;
  }

  public function increaseApplication() {
    $this->nbApplications++;
  }

  public function decreaseApplication() {
    $this->nbApplications--;
  }
    /**
     * @var string
     */
    private $slug;


    /**
     * Set slug.
     *
     * @param string $slug
     *
     * @return Advert
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
}
