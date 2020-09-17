<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Wiki\WikiManager;

class WikiController extends Controller
{

    /**
     * @Route("/{slug}", name="wiki")
     */
    public function pageAction($slug)
    {

	$em = $this->getDoctrine()->getManager('wiki');

    	$wiki_image_path = $this->container->getParameter('wiki_image_path');

    	$wikiManager = new WikiManager($em, $this, $wiki_image_path);

    	//$wikiManager->setSidebarPage($slug);
        if ($slug == "Background_Essays") { $wikiManager->setSidebarPage("Sidebar"); }

    	$wikiManager->setPage($slug);

    	$page = $wikiManager->getPage();

        return $this->render('AppBundle:wiki:index.html.twig', array(
            //'sidebar_page' => $wikiManager->getSidebarPage(),
            'page' => $page,
            'metaTitle' => 'Background Essays - '.$page['title'],
        	'slug' => $slug
        ));

	/*
    	$em = $this->getDoctrine()->getManager('wiki');

    	$wikiManager = new WikiManager($em, $this);
    	$wikiManager->setSidebarPage($slug);
    	$wikiManager->setPage($slug);

        return $this->render('AppBundle:wiki:index.html.twig', array(
        	'sidebar_page' => $wikiManager->getSidebarPage(),
            'page' => $wikiManager->getPage(),
        	'slug' => $slug
        ));
	*/
    }

    public function getUrl($name, $params) {

        return $this->generateUrl($name, $params);

    }
 
}
