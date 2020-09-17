<?php

namespace AppBundle\Wiki;

use AppBundle\Wiki\Wiky;
use Doctrine\ORM\Query\ResultSetMapping;

class WikiManager {

	private $em;
	private $controller;
	private $sidebar_page;
	private $page;
	private $wiki_image_path;

	public function __construct($em, $controller, $wiki_image_path) {
		$this->em = $em;
		$this->controller = $controller;
		$this->wiki_image_path = $wiki_image_path;
	}

	/*
	public function setSidebarPage($slug) {
	
		// construct new wiky object
		$wiky=new wiky;

		// define page result set mapping
		$rsm_page = new ResultSetMapping;
    	        $rsm_page->addScalarResult('page_id', 'page_id');
		$rsm_page->addScalarResult('page_title', 'title_raw');

		// define revision result mapping
		$rsm_revision = new ResultSetMapping;
		$rsm_revision->addScalarResult('old_text', 'content_raw');

		// create query to return all pages
		$query_page = $this->em->createNativeQuery('SELECT page_id, page_title from page where page_title = :slug', $rsm_page);
		//$query_page->setParameter('slug:', 'Sidebar');
		$query_page->setParameter('slug:', $slug);
		
		// fetch array pf query result
		$this->sidebar_page = $query_page->getSingleResult(\Doctrine\ORM\AbstractQuery::HYDRATE_ARRAY);

		// create query to get latest page revision 
		$query_revision = $this->em->createNativeQuery('SELECT old_text FROM text LEFT JOIN revision on old_id =  rev_text_id 
			WHERE rev_page = :id order by rev_timestamp desc limit 1', $rsm_revision);
		$query_revision->setParameter(':id', $this->sidebar_page['page_id']);
		
		// fetch array pf query result
		$revision = $query_revision->getSingleResult(\Doctrine\ORM\AbstractQuery::HYDRATE_ARRAY);

		// clean up title
		$this->sidebar_page['title'] = str_replace('_', ' ', $this->sidebar_page['title_raw']);

		// find links
		preg_match_all("/\\[\\[([a-zA-Z ]+)\\]\\]/", $revision['content_raw'], $linkMatches);
		
		// replace links with actual links
		$link_replaces = array();
		if (!empty($linkMatches[1])) {
			foreach ($linkMatches[1] as $link_title) {
				$isActive = $slug== str_replace(' ', '_', $link_title) ? 'active' : '';
				$replaceWith = '<a href="'.$this->controller->generateUrl('wiki', array('slug' => str_replace(' ', '_', $link_title))).'" class="list-group-item '.$isActive.'">'.$link_title.'</a>';
				$revision['content_raw'] = preg_replace("/\\[\\[(".$link_title.")\\]\\]/", $replaceWith, $revision['content_raw']);
			}
		}

		// add raw content to page
		$this->sidebar_page['content_raw'] = $revision['content_raw'];

		// parse add content to page
		$this->sidebar_page['content'] = $wiky->parse(htmlspecialchars($revision['content_raw']));
	}

	public function getSidebarPage() {
		return $this->sidebar_page;
	}
	*/

	public function setPage($slug) {

		// construct new wiky object
		$wiky=new wiky;

		// define page result set mapping
		$rsm_page = new ResultSetMapping;
    	        $rsm_page->addScalarResult('page_id', 'page_id');
		$rsm_page->addScalarResult('page_title', 'title_raw');

		// define revision result mapping
		$rsm_revision = new ResultSetMapping;
		$rsm_revision->addScalarResult('old_text', 'content_raw');

		// create query to return all pages
		$query_page = $this->em->createNativeQuery('SELECT page_id, page_title from page where page_title = :slug', $rsm_page);
		$query_page->setParameter('slug:', $slug);
		
		// fetch array pf query result
		$this->page = $query_page->getSingleResult(\Doctrine\ORM\AbstractQuery::HYDRATE_ARRAY);

		// create query to get latest page revision 
		$query_revision = $this->em->createNativeQuery('SELECT old_text FROM text LEFT JOIN revision on old_id =  rev_text_id 
			WHERE rev_page = :id order by rev_timestamp desc limit 1', $rsm_revision);
		$query_revision->setParameter(':id', $this->page['page_id']);
		
		// fetch array pf query result
		$revision = $query_revision->getSingleResult(\Doctrine\ORM\AbstractQuery::HYDRATE_ARRAY);

		// clean up title
		$this->page['title'] = str_replace('_', ' ', $this->page['title_raw']);

		/*
		// double bracket items (images and internal links)
		$revision['content_raw']=preg_replace_callback('/\[\[(.+?)\]\]/s', 
		function ($matches) {

			var_dump($matches[1]);

			$components = explode("|", $matches[1]);

			//var_dump($components);

			if (substr($components[0], 0, 5) === "File:") {

				var_dump("IMAGE");

			}

			
			if (substr($matches[1], 0, 4) === "http") {

				$components = explode(" ", $matches[1], 2);

				if (count($components) > 1) {

					// An external link expressed in the format [http://www.forensic-focus.co.uk Forensic Focus]

					$url = $components[0];
					$title = substr($matches[1], strlen($url));

					$ytpos = strpos($url, "://www.youtube.com/watch?v=");

					if ($ytpos != false) {

						// convert youtube links into embedded videos

						$ytslug = substr($url, $ytpos + 27);

						return '<iframe width="560" height="315" src="https://www.youtube.com/embed/'.$ytslug.'" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>';

					} else {
					
						return "<a href=\"".$url."\">".$title."</a>";

					}

				} else {

					# multiple components

				}

			}
				

		}, $revision['content_raw']);
		*/

		/*
		preg_match_all("/\\[\\[([a-zA-Z ]+)\\|?([a-zA-Z ]+)?\\]\\]/", $revision['content_raw'], $internalLinkMatches);

		for ($i = 0; $i < count($internalLinkMatches[1]); $i++) {
			$linkpage = $internalLinkMatches[1][$i];
			$linktext = $internalLinkMatches[2][$i];
			$linkurl = $this->controller->generateUrl('wiki', array('slug' => str_replace(' ', '_', $linkpage)));

			if (strlen($linktext) > 0) {
				$html = '<a href="'.$linkurl.'">'.$linktext.'</a>';
				$revision['content_raw'] = preg_replace("/\\[\\[(".$linkpage.")\\|".$linktext."\\]\\]/", $html, $revision['content_raw']);
			} else {
				$html = '<a href="'.$linkurl.'">'.$linkpage.'</a>';
				$revision['content_raw'] = preg_replace("/\\[\\[(".$linkpage.")\\]\\]/", $html, $revision['content_raw']);

			}

		}
		*/

		$revision['content_raw'] = $wiky->doubleBracket($revision['content_raw'], $this->wiki_image_path, $this->controller);
		$revision['content_raw'] = $wiky->singleBracket($revision['content_raw']);

		// single bracket items (external links)
		/*
		$revision['content_raw']=preg_replace_callback('/\[(http.+?)\]/s', 
		function ($matches) {

			if (substr($matches[1], 0, 4) === "http") {

				$components = explode(" ", $matches[1], 2);

				if (count($components) > 1) {

					// An external link expressed in the format [http://www.forensic-focus.co.uk Forensic Focus]

					$url = $components[0];
					$title = substr($matches[1], strlen($url));

					$ytpos = strpos($url, "://www.youtube.com/watch?v=");

					if ($ytpos != false) {

						// convert youtube links into embedded videos

						$ytslug = substr($url, $ytpos + 27);

						return '<iframe width="560" height="315" src="https://www.youtube.com/embed/'.$ytslug.'" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>';

					} else {
					
						return "<a href=\"".$url."\">".$title."</a>";

					}

				} else {

					# multiple components

				}

			}	

		}, $revision['content_raw']);
		*/

		// find inline images
		//preg_match_all("/[\\[]{2}File\\:([a-zA-Z1-9_\\- ]+[\\.][a-zA-Z]+)[\\]]{2}/", $revision['content_raw'], $imgMatches);

		//foreach ($imgMatches[1] as $img) {
		//	$img = str_replace(" ", "_", $img);
		//	$md5ByteCode = md5(utf8_encode($img));
		//	$src = $this->wiki_image_path.$md5ByteCode[0].'/'.$md5ByteCode[0].$md5ByteCode[1].'/'.$img;
		//	$imageHtml = '<br><img src="'.$src.'" alt="'.$img.'" class="img-responsive" /><br>';
		//	$revision['content_raw'] = preg_replace("/[\\[]{2}File\\:(".$img.")[\\]]{2}/", $imageHtml, $revision['content_raw']);
		//}

		// thumbnail images
		/*
		preg_match_all("/[\\[]{2}File\\:([a-zA-Z1-9_\\- ]+[\\.][a-zA-Z]+)\\|([a-z]+)\\|([a-z]+)\\|([a-zA-Z ]+)[\\]]{2}/", $revision['content_raw'], $imgMatches);

		for ($i = 0; $i < count($imgMatches[1]); $i++) {
			$img = $imgMatches[1][$i];
			$disp = $imgMatches[2][$i];
			$side = $imgMatches[3][$i];
			$caption = $imgMatches[4][$i];
			//var_dump($img);
			//var_dump($disp);
			//var_dump($side);
			//var_dump($caption);
			$img = str_replace(" ", "_", $img);
			$md5ByteCode = md5(utf8_encode($img));
			$src = $this->wiki_image_path.$md5ByteCode[0].'/'.$md5ByteCode[0].$md5ByteCode[1].'/'.$img;
			//$imageHtml = '<br><img src="'.$src.'" alt="'.$img.'" class="img-responsive" /><br>';
			$html = '<div class="thumbnail ml-1 mr-1 pull-'.$side.'"><img class="img-responsive" src="'.$src.'"><div class="caption">'.$caption.'</div></div>';
			$revision['content_raw'] = preg_replace("/[\\[]{2}File\\:(".$img.")\\|".$disp."\\|".$side."\\|".$caption."[\\]]{2}/", $html, $revision['content_raw']);
		}
		*/
		
		// add raw content to page
		$this->page['content_raw'] = $revision['content_raw'];

		// parse add content to page
		$this->page['content'] = $wiky->parse(($revision['content_raw']));

		// clean up title
		// $this->page['title'] = str_replace('_', ' ', $this->page['title_raw']);
		//$this->page['title'] = $this->page['title_raw'];

		// find links
		// preg_match_all("/\\[\\[([a-zA-Z ]+)\\]\\]/", $revision['content_raw'], $linkMatches);
		
		// replace links with actual links
		// $link_replaces = array();
		// if (!empty($linkMatches[1])) {
		//	foreach ($linkMatches[1] as $link_title) {
		//			$replaceWith = '<a href="'.$this->controller->generateUrl('wiki_page', array('slug' => str_replace(' ', '_', $link_title))).'" class="btn btn-default btn-sm">'.$link_title.'</a>';
		//			$revision['content_raw'] = preg_replace("/\\[\\[(".$link_title.")\\]\\]/", $replaceWith, $revision['content_raw']);
		//	}
		// }

		// add raw content to page
		//$this->page['content_raw'] = $revision['content_raw'];

		// parse add content to page
		#$this->page['content'] = $wiky->parse(htmlspecialchars($revision['content_raw']));
		//$this->page['content'] = $wiky->parse($wiky->parseLinks(htmlspecialchars($revision['content_raw'])));

	}

	public function getPage() {
		return $this->page;
	}


}
