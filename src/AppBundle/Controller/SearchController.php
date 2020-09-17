<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Form\AdvancedSearchType;
use AppBundle\Form\SearchType;
use AppBundle\Entity\DboDocuments;
use AppBundle\Search\Search;

use AppBundle\Search\Params;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends Controller
{
    /**
     * @Route("/search", name="search")
     */
    public function indexAction(Request $request)
    {
    	$params = new Params();

    	$form = $this->createForm(SearchType::class, $params, array(
            'action' => $this->generateUrl('search'),
            'method' => 'GET',
            'entity_manager' => $this->getDoctrine()->getManager()
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
        	
	    $search = new Search();
            $search->setRequest($request);
            $search->setForm($form);
            $search->setPerPage(10);
            $search->setController($this);
            $search->setFinder($this->container->get('fos_elastica.finder.app.song'));
        	$pagination = $search->basicSearch()->getResults();

            $em = $this->getDoctrine()->getManager();
	    foreach ($pagination as $item) {
		#if ($item->getForeignkeyreference() != null && $item->getCatrefitem() != null) {
			#$item->images = $em->getRepository('AppBundle:ImageLookup')->findDocumentImages( $item->getForeignkeyreference()->getDescribfulltext(), $item->getCatrefitem());
		#}
            }

	        return $this->render('AppBundle:search:results.html.twig', array(
	        	"pagination" => $pagination,
                "mode" => 'basic'
	        ));
        }

        return $this->render('AppBundle:search:index.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/advanced-search", name="advanced_search")
     */
    public function advancedAction(Request $request)
    {
    	$params = new Params();

    	$form = $this->createForm(AdvancedSearchType::class, $params, array(
            'action' => $this->generateUrl('advanced_search'),
            'method' => 'GET',
            'entity_manager' => $this->getDoctrine()->getManager()
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
        	
	    $search = new Search();
            $search->setRequest($request);
            $search->setForm($form);
            $search->setPerPage(10);
            $search->setController($this);
            $search->setFinder($this->container->get('fos_elastica.finder.app.song'));
            $pagination = $search->advancedSearch()->getResults();

	        return $this->render('AppBundle:search:results.html.twig', array(
	        	"pagination" => $pagination,
                "mode" => 'advanced'
	        ));
        }

        return $this->render('AppBundle:search:advanced.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function getPaginator() {
	return $this->get('knp_paginator');
    }

}
