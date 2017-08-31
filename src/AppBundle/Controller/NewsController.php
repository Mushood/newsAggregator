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

        $express = $repositoryNewspaper->find(1);
        $defimedia = $repositoryNewspaper->find(2);
        $mauricien = $repositoryNewspaper->find(3);

        $expresses = $repositoryNews->findBy(
          array(
            'newspaper' => $express,
          ), // Critere
          array(),        // Tri
          10,                              // Limite
          0                               // Offset
        );

        $defiMedias = $repositoryNews->findBy(
          array('newspaper' => $defimedia), // Critere
          array(),        // Tri
          10,                              // Limite
          0                               // Offset
        );

        $mauriciens = $repositoryNews->findBy(
          array('newspaper' => $mauricien), // Critere
          array(),        // Tri
          10,                              // Limite
          0                               // Offset
        );

        return $this->render('AppBundle:news:index.html.twig', array(
          'expresses' => $expresses,
          'defiMedias' => $defiMedias,
          'mauriciens' => $mauriciens,
        ));
    }
}
