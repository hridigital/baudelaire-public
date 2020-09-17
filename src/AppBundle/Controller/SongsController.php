<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class SongsController extends Controller
{
    /**
     * @Route("/songs", name="songs")
     */
    public function browse(Request $request)
    {
    	$page = $request->get('page', 1);
    	$finder = $this->container->get('fos_elastica.finder.app.song');
		$paginator = $this->get('knp_paginator');
		$results = $finder->createPaginatorAdapter('');
		$pagination = $paginator->paginate($results, $page, 10, array());
        return $this->render('AppBundle:browse:index.html.twig', array(
        	"pagination" => $pagination
        ));
    }

    /**
     * @Route("/song/{id}", name="show_song")
     */
    public function showSong(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
        $song = $em->getRepository('AppBundle:Song')->find($request->get('id'));
        #$document->images = $em->getRepository('AppBundle:ImageLookup')->findDocumentImages( 
        #    $document->getForeignkeyreference()->getDescribfulltext(), 
        #    $document->getCatrefitem()
        #);
	//var_dump($document);
        return $this->render('AppBundle:browse:show_song.html.twig', array("song" => $song));
    }

    /**
     * @Route("/matrix/{id}", name="show_matrix")
     */
    /*
    public function showMatrix(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
        $matrix = $em->getRepository('AppBundle:DboSeal')->find($request->get('id'));
        return $this->render('AppBundle:browse:show_matrix.html.twig', array("matrix" => $matrix));
    }
    */

    /**
     * @Route("/person/{id}", name="show_person")
     */
    /*
    public function showPerson(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
        $person = $em->getRepository('AppBundle:Person')->find($request->get('id'));
        return $this->render('AppBundle:browse:show_person.html.twig', array("person" => $person));
    }
    */

    /**
     * @Route("/api/lookup/images", name="api_lookup_images", options={"expose"=true})
     */
    /*
    public function loadImages(Request $request) 
    {   
        $em = $this->getDoctrine()->getManager();

        $reference = $request->get('short_reference');
        $accession = $request->get('accession_number');
        $type = $request->get('type');
        $size = $request->get('size');
        $id = $request->get('id');

        if ($type == 'document') {
            $images = $em->getRepository('AppBundle:ImageLookup')->findDocumentImages($reference, $accession);
        } else if ($type == 'impression') {
	    $images = $em->getRepository('AppBundle:ImageLookup')->findImpressionImages($reference, $accession, $id);
	} else if ($type == 'wax') {
            $images = $em->getRepository('AppBundle:ImageLookup')->findWaxImages($reference, $accession, $id);
        } else {
            $images = $em->getRepository('AppBundle:ImageLookup')->findAllImages($reference, $accession);
        }

        $url_prefix = $this->container->getParameter('san_image_directory') . $request->get('size') . '/';
  
        $data = array();
        foreach ($images as $image) {
            $data[] = array("type" => 'image', "url" => $url_prefix.$image->getUrl());
        }

        // construct new response 
        $response = new JsonResponse();

        // store data in response 
        $response->setData($data);
        
        // return response with data 
        return $response;

    }
    */

}
