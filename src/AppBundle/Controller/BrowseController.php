<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class BrowseController extends Controller
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
	 * @Route("/poems", name="poems")
	 */
	public function browsePoems(Request $request)
	{
		$page = $request->get('page', 1);
		$em = $this->getDoctrine()->getManager();

		//$poems = $em->getRepository('AppBundle:Poem')->findAll();
		$poems = $em->getRepository('AppBundle:Poem')->findBy([], ['title' => 'ASC']);

		$paginator = $this->get('knp_paginator');
		$pagination = $paginator->paginate($poems, $page, 300, array());
		return $this->render('AppBundle:browse:poems.html.twig', array(
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
		return $this->render('AppBundle:browse:show_song.html.twig', array("song" => $song));
	}

	/**
	 * @Route("/person/{id}", name="show_person")
	 */
	public function showPerson(Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$person = $em->getRepository('AppBundle:Person')->find($request->get('id'));
		return $this->render('AppBundle:browse:show_person.html.twig', array("person" => $person));
	}

	/**
	 * @Route("/poem/{id}", name="show_poem")
	 */
	public function showPoem(Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$poem = $em->getRepository('AppBundle:Poem')->find($request->get('id'));
		return $this->render('AppBundle:browse:show_poem.html.twig', array("poem" => $poem));
	}


}
