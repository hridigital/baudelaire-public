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

		$revision['content_raw'] = $wiky->doubleBracket($revision['content_raw'], $this->wiki_image_path, $this->controller);
		$revision['content_raw'] = $wiky->singleBracket($revision['content_raw']);

		// add raw content to page
		$this->page['content_raw'] = $revision['content_raw'];

		// parse add content to page
		$this->page['content'] = $wiky->parse(($revision['content_raw']));

	}

	public function getPage() {
		return $this->page;
	}


}
