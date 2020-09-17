<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ViewController extends Controller
{

	/**
	 * @Route("/view/{id}", name="view_song")
	 */
	public function viewSong(Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$song = $em->getRepository('AppBundle:Song')->find($request->get('id'));
		return $this->render('AppBundle:view:index.html.twig', array("song" => $song));
	}

}
