<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Wiki\WikiManager;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request) {
    	
        $em = $this->getDoctrine()->getManager('wiki');

    	$wiki_image_path = $this->container->getParameter('wiki_image_path');

    	$wikiManager = new WikiManager($em, $this, $wiki_image_path);
    	//$wikiManager->setSidebarPage('Homepage');
    	$wikiManager->setPage('Homepage');

    	$page = $wikiManager->getPage();

        return $this->render('AppBundle:wiki:index.html.twig', array(
		/*'sidebar_page' => $wikiManager->getSidebarPage(),*/
        	'page' => $page,
        	'metaTitle' => 'Background Essays',
        	'slug' => 'Homepage'
        ));

    }

    public function getUrl($name, $params) {

        return $this->generateUrl($name, $params);

    }

}
