<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Form\SearchType;
use AppBundle\Entity\DboDocuments;
use AppBundle\Search\Search;
#use AppBundle\Wiki\WikiManager;

use AppBundle\Search\Params;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends Controller
{

	/**
	 * @Route("/advanced", name="advanced")
	 */
	public function advancedAction(Request $request)
	{
		
		#$em = $this->getDoctrine()->getManager('wiki');

		#$wiki_image_path = $this->container->getParameter('wiki_image_path');

		#$wikiManager = new WikiManager($em, $this, $wiki_image_path);
		#$wikiManager->setPage('Songs');

		#$wikipage = $wikiManager->getPage();

		$form = $this->createForm(SearchType::class, null, array(
			'action' => $this->generateUrl('advanced_results'),
			'method' => 'GET',
			'entity_manager' => $this->getDoctrine()->getManager(),
			'csrf_protection' => false
		));

		$form->handleRequest($request);

		#if ($form->isSubmitted()) {

		#	$search = new Search();
		#	$search->setRequest($request);
		#	$search->setForm($form);
		#	$search->setPerPage(10);
		#	$search->setController($this);
		#	$search->setFinder($this->container->get('fos_elastica.finder.app.song'));
		#	$pagination = $search->search()->getResults();

		#	$aggs = $pagination->getCustomParameters()['aggregations'];

		#	return $this->render('AppBundle:search:results.html.twig', array(
		#		'pagination' => $pagination,
		#		'mode' => 'advanced',
		#		'form' => $form->createView(),
		#		'aggs' => $aggs,
		#	));
		#}

		return $this->render('AppBundle:home:index.html.twig', array(
			'form' => $form->createView(),
			'mode' => 'advanced',
			#'wikipage' => $wikipage,
		));
	}

	/**
	 * @Route("/results", name="results")
	 * @Route("/advanced-results", name="advanced_results")
	 */
	public function indexAction(Request $request)
	{
		$routeName = $request->get('_route');

		$mode = 'basic';

		if ($routeName == 'advanced_results') { $mode = 'advanced'; }

		$form = $this->createForm(SearchType::class, null, array(
			'action' => $this->generateUrl('results'),
			'method' => 'GET',
			'entity_manager' => $this->getDoctrine()->getManager(),
			'csrf_protection' => false
		));

		$form->handleRequest($request);

		//if ($form->isSubmitted()) {

			$search = new Search();
			$search->setRequest($request);
			$search->setForm($form);
			$search->setPerPage(10);
			$search->setController($this);
			$search->setFinder($this->container->get('fos_elastica.finder.app.song'));
			$pagination = $search->search()->getResults();

			$aggs = $pagination->getCustomParameters()['aggregations'];

			$summary = $search->getSummary();
			$sort = $search->getSort();

			$em = $this->getDoctrine()->getManager();
			
			return $this->render('AppBundle:search:results.html.twig', array(
				'pagination' => $pagination,
				'mode' => $mode,
				'form' => $form->createView(),
				'aggs' => $aggs,
				'summary' => $summary,
				'sort' => $sort
			));

		//}

		#return $this->render('AppBundle:home:index.html.twig', array(
		#	'form' => $form->createView()
		#));
	}

	public function getPaginator() {
		return $this->get('knp_paginator');
	}

}
