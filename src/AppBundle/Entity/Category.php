<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoryRepository")
 */
class Category
{
    use TimestampableEntity;
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
    * @ORM\OneToMany(targetEntity="AppBundle\Entity\News", mappedBy="category")
    */
    private $news;

    /**
    * @ORM\OneToMany(targetEntity="AppBundle\Entity\Crawler", mappedBy="category")
    */
    private $crawler;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->news = new \Doctrine\Common\Collections\ArrayCollection();
        $this->crawler = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add news
     *
     * @param \AppBundle\Entity\News $news
     *
     * @return Category
     */
    public function addNews(\AppBundle\Entity\News $news)
    {
        $this->news[] = $news;

        return $this;
    }

    /**
     * Remove news
     *
     * @param \AppBundle\Entity\News $news
     */
    public function removeNews(\AppBundle\Entity\News $news)
    {
        $this->news->removeElement($news);
    }

    /**
     * Get news
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNews()
    {
        return $this->news;
    }

    /**
     * Add crawler
     *
     * @param \AppBundle\Entity\Crawler $crawler
     *
     * @return Category
     */
    public function addCrawler(\AppBundle\Entity\Crawler $crawler)
    {
        $this->crawler[] = $crawler;

        return $this;
    }

    /**
     * Remove crawler
     *
     * @param \AppBundle\Entity\Crawler $crawler
     */
    public function removeCrawler(\AppBundle\Entity\Crawler $crawler)
    {
        $this->crawler->removeElement($crawler);
    }

    /**
     * Get crawler
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCrawler()
    {
        return $this->crawler;
    }
}
