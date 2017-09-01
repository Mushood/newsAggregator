<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\DateType;

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

        $form = $this->createFormBuilder()
          ->add('date', DateType::class, array(
              'widget' => 'single_text',
          ))
          ->getForm();

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            $date = $request->get('form')['date'];

            //get date which is end of date of today
            $date = new \DateTime($date);
            $date->add(new \DateInterval('P1D'));
        }
        else {
            $date = new \DateTime();
        }

        $expresses = $repositoryNews->getNewsByCategoryAndNewspaper(1,1,$date->format('Y-m-d H:i:s'));
        $defiMedias = $repositoryNews->getNewsByCategoryAndNewspaper(1,2,$date->format('Y-m-d H:i:s'));
        $mauriciens = $repositoryNews->getNewsByCategoryAndNewspaper(1,3,$date->format('Y-m-d H:i:s'));

        if ($request->isMethod('POST')) {
        //sub date to get today's date
        $date->sub(new \DateInterval('P1D'));
        }
        
        return $this->render('AppBundle:news:index.html.twig', array(
          'expresses' => $expresses,
          'defiMedias' => $defiMedias,
          'mauriciens' => $mauriciens,
          'date' => $date->format('Y-m-d'),
          'form' => $form->createView()
        ));
    }
}
