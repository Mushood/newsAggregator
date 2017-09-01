<?php

namespace AppBundle\Services;

use Symfony\Component\DomCrawler\Crawler;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Crawler as NewsCrawler;
use AppBundle\Entity\News;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PriceUpdater
 * @package AppBundle\Services
 */
class NewsUpdater
{

    /**
     * @var EntityManager
     */
  protected $em;

    /**
     * PriceUpdater constructor.
     * @param EntityManager $entityManager
     */
  public function __construct(EntityManager $entityManager)
  {
      $this->em = $entityManager;
  }

    /**
     * @param ProduitHasBoutique $produitHasBoutique
     * @return bool
     */
  public function updateNews(NewsCrawler $newsCrawler){

    $url = $newsCrawler->getLink();
    $cssNews = $newsCrawler->getCss();
    $status = 200;
/* disabling curl check
    $status = $this->checkUrlByCurl($url);
    dump($url  );
    dump($status  );
    if($status === Response::HTTP_OK){
*/      $html = file_get_contents($url);
        $crawler  = new Crawler($html);
        try{
          for($i=0; $i<10; $i++){
            $title = $crawler->filter($cssNews)->eq($i)->text();
            $title = trim($title);
            $link = $crawler->filter($cssNews)->eq($i)->attr('href');

            $news = new News();
            $news->setCategory($newsCrawler->getCategory());
            $news->setNewspaper($newsCrawler->getNewspaper());
            $news->setTitle($title);
            if (strpos($link, "http") === false){
              $news->setLink($url.$link);
            } else {
              $news->setLink($link);
            }

            $this->em->persist($news);
          }
        } catch (\InvalidArgumentException $notFoundException){
            $status = 100;
        }
  //  }



    $newsCrawler->setStatus($status);
    $this->em->persist($newsCrawler);

    $this->em->flush();

    return TRUE;
  }

    //code from
    //https://stackoverflow.com/questions/408405/easy-way-to-test-a-url-for-404-in-php
    /**
     * Perform a curl on the URL
     * @param $url
     * @return bool|mixed
     */
  private function checkUrlByCurl($url) {
	    if (!$url) { return 404; }
        dump($url  );
	    $curl_resource = curl_init($url);
  dump($curl_resource  );
	    curl_setopt($curl_resource, CURLOPT_RETURNTRANSFER, true);
	    curl_exec($curl_resource);

      $responseCode = curl_getinfo($curl_resource, CURLINFO_HTTP_CODE);
dump($responseCode  );
      return $responseCode;
	}

}
