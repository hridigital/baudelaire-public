<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Wiki\WikiManager;

use AppBundle\Form\SearchType;
use AppBundle\Search\Params;

class DefaultController extends Controller
{
	/**
	 * @Route("/", name="homepage")
	 * @Route("/fr", name="homepage_fr")
	 * @Route("/search", name="search")
	 */
	public function indexAction(Request $request) {

		$em = $this->getDoctrine()->getManager('wiki');

		$wiki_image_path = $this->container->getParameter('wiki_image_path');

		$wikiManager = new WikiManager($em, $this, $wiki_image_path);

		if ($request->get('_route') == 'homepage_fr') {
			$wikiManager->setPage('Songs_Fr');
		} else {
			$wikiManager->setPage('Songs');
		}

		$wikipage = $wikiManager->getPage();

		$form = $this->createForm(SearchType::class, null, array(
			'action' => $this->generateUrl('results'),
			'method' => 'GET',
			'entity_manager' => $this->getDoctrine()->getManager(),
			'csrf_protection' => false
		));

		return $this->render('AppBundle:home:index.html.twig', array(
			'wikipage' => $wikipage,
			'mode' => 'basic',
			'form' => $form->createView()
		));

	}

	public function getUrl($name, $params) {

		return $this->generateUrl($name, $params);

	}

}
