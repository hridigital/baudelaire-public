<?php

namespace AppBundle\Search;

class Search {

	public $perPage;
	public $form;
	public $boolQuery;
	public $controller;
	public $finder;
	public $request;
	public $summary;
	public $sort;

	public function setPerPage($perPage) {
		$this->perPage = $perPage;
	}

	public function setForm($form) {
		$this->form = $form;
	}

	public function setController($controller) {
		$this->controller = $controller;
	}

	public function setFinder($finder) {
		$this->finder = $finder;
	}

	public function setRequest($request) {
		$this->request = $request;
	}

	public function getResults() {
		$page = $this->request->get('page', 1);
		$paginator = $this->controller->getPaginator();

		$query = new \Elastica\Query();
		
		if (!empty($sort = $this->form['sort']->getData())) {
			if ($sort == 'earliestYear') {
				$this->sort = $sort;
				$query->addSort(array('earliestYear' => array('order' => 'asc')));
			}
		}

		$query->setQuery($this->boolQuery);

		$poemsAgg = new \Elastica\Aggregation\Terms('poems');
		$poemsAgg->setField('poems');
	        $poemsAgg->setSize(9999);
	        $query->addAggregation($poemsAgg);
		
		$genreAgg = new \Elastica\Aggregation\Terms('genres');
		$genreAgg->setField('genres');
	        $genreAgg->setSize(9999);
		$query->addAggregation($genreAgg);
		
		$decadesAgg = new \Elastica\Aggregation\Terms('decades');
		$decadesAgg->setField('decades');
	        $decadesAgg->setSize(9999);
		$query->addAggregation($decadesAgg);
		
		$themesAgg = new \Elastica\Aggregation\Terms('themes');
		$themesAgg->setField('themes');
	        $themesAgg->setSize(9999);
		$query->addAggregation($themesAgg);

		$personsAgg = new \Elastica\Aggregation\Terms('people');
		$personsAgg->setField('persons');
	        $personsAgg->setSize(9999);
		$query->addAggregation($personsAgg);
		
		$genderAgg = new \Elastica\Aggregation\Terms('gender');
		$genderAgg->setField('gender');
	        $genderAgg->setSize(9999);
		$query->addAggregation($genderAgg);

		$langsAgg = new \Elastica\Aggregation\Terms('languages');
		$langsAgg->setField('langs');
	        $langsAgg->setSize(9999);
		$query->addAggregation($langsAgg);


		$results = $this->finder->createPaginatorAdapter($query);

		$pagination = $paginator->paginate($results, $page, $this->perPage, array());
	
		return $pagination;
	}

	public function search() {

		$this->summary = [];

		$this->boolQuery = new \Elastica\Query\BoolQuery();

		if (!empty($keyword = $this->form['keyword']->getData())) {
			$sqsQuery = new \Elastica\Query\SimpleQueryString($keyword, ['title', 'poemsTitles', 'poemsTitlesEnglish', 'personsKeyword']);
			$this->boolQuery->addMust($sqsQuery);
			$this->summary["Keyword"] = "'".$keyword."'";
		}
		
		if (!empty($title = $this->form['title']->getData())) {
			$sqsQuery = new \Elastica\Query\SimpleQueryString($title, ['title']);
			$this->boolQuery->addMust($sqsQuery);
			$this->summary["Song title"] = "'".$title."'";
		}
		
		if (!empty($poemsTitles = $this->form['poemsTitles']->getData())) {
			$sqsQuery = new \Elastica\Query\SimpleQueryString($poemsTitles, ['poemsTitles', 'poemsTitlesEnglish']);
			$this->boolQuery->addMust($sqsQuery);
			$this->summary["Poem title"] = "'".$poemsTitles."'";
		}

		if (!empty($poems = $this->form['poems']->getData())) {
			$termQuery = new \Elastica\Query\Term();
			$termQuery->setTerm('poems', $poems);
			$this->boolQuery->addMust($termQuery);
			$this->summary["Poem"] = $poems;
		}
		
		if (!empty($genres = $this->form['genres']->getData())) {
			$termQuery = new \Elastica\Query\Term();
			$termQuery->setTerm('genres', $genres);
			$this->boolQuery->addMust($termQuery);
			$this->summary["Genre"] = $genres;
		}

		if (!empty($languages = $this->form['languages']->getData())) {
			$termQuery = new \Elastica\Query\Term();
			$termQuery->setTerm('langs', $languages);
			$this->boolQuery->addMust($termQuery);
			$this->summary["Language"] = $languages;
		}
		
		if (!empty($decades = $this->form['decades']->getData())) {
			$termQuery = new \Elastica\Query\Term();
			$termQuery->setTerm('decades', $decades);
			$this->boolQuery->addMust($termQuery);
			$this->summary["Decade"] = $decades;
		}
		
		if (!empty($themes = $this->form['themes']->getData())) {
			$termQuery = new \Elastica\Query\Term();
			$termQuery->setTerm('themes', $themes);
			$this->boolQuery->addMust($termQuery);
			$this->summary["Theme"] = $themes;
		}

		if (!empty($people = $this->form['people']->getData())) {
			$termQuery = new \Elastica\Query\Term();
			$termQuery->setTerm('persons', $people);
			$this->boolQuery->addMust($termQuery);
			$this->summary["People"] = $people;
		}

		if (!empty($gender = $this->form['gender']->getData())) {
			$termQuery = new \Elastica\Query\Term();
			$termQuery->setTerm('gender', $gender);
			$this->boolQuery->addMust($termQuery);
			$this->summary["Gender"] = $gender;
		}

		if (!empty($earliestYear = $this->form['earliestYear']->getData())) {
			$rangeQuery = new \Elastica\Query\Range();
			#$rangeQuery->addField('sentDate.datetype', array('gte'=>$date_lower, 'lte'=>$date_upper,'format'=>'yyyy'));
			$rangeQuery->addField('latestYear', array('gte'=>$earliestYear));
			$this->boolQuery->addMust($rangeQuery);
			$this->summary["Earliest year"] = $earliestYear;
		}
		
		if (!empty($latestYear = $this->form['latestYear']->getData())) {
			$rangeQuery = new \Elastica\Query\Range();
			#$rangeQuery->addField('sentDate.datetype', array('gte'=>$date_lower, 'lte'=>$date_upper,'format'=>'yyyy'));
			$rangeQuery->addField('earliestYear', array('lte'=>$latestYear));
			$this->boolQuery->addMust($rangeQuery);
			$this->summary["Latest year"] = $latestYear;
		}

		return $this;

	}

	public function getSummary() {
		return $this->summary;
	}

	public function getSort() {
		return $this->sort;
	}

}
