<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class NewsController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $repositoryNews = $this->container->get('doctrine')
          ->getManager()
          ->getRepository('AppBundle:News')
        ;

        $repositoryNewspaper = $this->container->get('doctrine')
          ->getManager()
          ->getRepository('AppBundle:Newspaper')
        ;

        $expresses = $repositoryNews->getNewsByCategoryAndNewspaper(1,1);
        $defiMedias = $repositoryNews->getNewsByCategoryAndNewspaper(1,2);
        $mauriciens = $repositoryNews->getNewsByCategoryAndNewspaper(1,3);

        return $this->render('AppBundle:news:index.html.twig', array(
          'expresses' => $expresses,
          'defiMedias' => $defiMedias,
          'mauriciens' => $mauriciens,
        ));
    }

    /**
     * @Route("/date", name="date")
     */
    public function dateAction(Request $request)
    {
        $repositoryNews = $this->container->get('doctrine')
          ->getManager()
          ->getRepository('AppBundle:News')
        ;

        $repositoryNewspaper = $this->container->get('doctrine')
          ->getManager()
          ->getRepository('AppBundle:Newspaper')
        ;

        $date = new \DateTime();
        $date->sub(new \DateInterval('P1D'));

        $expresses = $repositoryNews->getNewsByCategoryAndNewspaper(1,1,$date->format('Y-m-d H:i:s'));
        $defiMedias = $repositoryNews->getNewsByCategoryAndNewspaper(1,2,$date->format('Y-m-d H:i:s'));
        $mauriciens = $repositoryNews->getNewsByCategoryAndNewspaper(1,3,$date->format('Y-m-d H:i:s'));

        return $this->render('AppBundle:news:index.html.twig', array(
          'expresses' => $expresses,
          'defiMedias' => $defiMedias,
          'mauriciens' => $mauriciens,
        ));
    }
}
