<?php

namespace OC\PlatformBundle\Entity;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Image
 */
class Image {
  /**
   * @var int
   */
  private $id;

  /**
   * @var string
   */
  private $url;

  /**
   * @var string
   */
  private $alt;


  /**
   * Get id.
   *
   * @return int
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Set url.
   *
   * @param string $url
   *
   * @return Image
   */
  public function setUrl($url) {
    $this->url = $url;

    return $this;
  }

  /**
   * Get url.
   *
   * @return string
   */
  public function getUrl() {
    return $this->url;
  }

  /**
   * Set alt.
   *
   * @param string $alt
   *
   * @return Image
   */
  public function setAlt($alt) {
    $this->alt = $alt;

    return $this;
  }

  /**
   * Get alt.
   *
   * @return string
   */
  public function getAlt() {
    return $this->alt;
  }

  private $file;

  private $tempFilename;

  public function getFile() {
    return $this->file;
  }

  public function setFile(UploadedFile $file) {
    $this->file = $file;

    if (NULL !== $this->url) {
      $this->tempFilename = $this->url;

      $this->url = NULL;
      $this->alt = NULL;
    }
  }

  public function preUpload() {
    if (NULL === $this->file) {
      return;
    }
    $this->url = $this->file->guessExtension();

    $this->alt = $this->file->getClientOriginalName();
  }


  public function upload() {
    if (NULL === $this->file) {
      return;
    }

    if (NULL !== $this->tempFilename) {
      $oldFile = $this->getUploadRootDir() . '/' . $this->id . '.' . $this->tempFilename;
      if (file_exists($oldFile)) {
        unlink($oldFile);
      }
    }

    $this->file->move(
      $this->getUploadRootDir(), // Le répertoire de destination
      $this->id . '.' . $this->url   // Le nom du fichier à créer, ici « id.extension »
    );
  }


  public function preRemoveUpload() {
    $this->tempFilename = $this->getUploadRootDir() . '/' . $this->id . '.' . $this->url;
  }


  public function removeUpload() {
    if (file_exists($this->tempFilename)) {
      unlink($this->tempFilename);
    }
  }

  public function getUploadDir() {
    return 'uploads/img';
  }

  protected function getUploadRootDir() {
    return __DIR__ . '/../../../../web/' . $this->getUploadDir();
  }

  public function getWebPath() {
    return $this->getUploadDir() . '/' . $this->getId() . '.' . $this->getUrl();
  }
}
