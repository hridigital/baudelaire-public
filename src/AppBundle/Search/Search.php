<?php

namespace AppBundle\Search;

class Search {

    public $perPage;
    public $form;
    public $boolQuery;
    public $controller;
    public $finder;
    public $request;

    public function setPerPage($perPage) {
	$this->perPage = $perPage;
    }

    public function setForm($form) {
        $this->form = $form;
    }

    public function setController($controller) {
        $this->controller = $controller;
    }

    public function setRequest($request) {
        $this->request = $request;
    }


    public function setFinder($finder) {
        $this->finder = $finder;
    }

    public function getResults() {
	#var_dump($this->controller);
        $page = $this->request->get('page', 1);
	#$paginator = $this->controller->get('knp_paginator');
	$paginator = $this->controller->getPaginator();
        $results = $this->finder->createPaginatorAdapter($this->boolQuery);
        return $pagination = $paginator->paginate($results, $page, $this->perPage, array());
    }

	public function basicSearch() {

		$this->boolQuery = new \Elastica\Query\BoolQuery();

    	if (!empty($keyword = $this->form['keyword']->getData())) {	       
        	$this->boolQuery->addMust(new \Elastica\Query\SimpleQueryString($keyword));
        }

        if (!empty($repository = $this->form['repository']->getData())) {
            $termQuery = new \Elastica\Query\Term();
            $termQuery->setTerm('repository', $repository);
            $this->boolQuery->addMust($termQuery);
        }

        if (!empty($accession_number = $this->form['accession_number']->getData())) {
            $termQuery = new \Elastica\Query\Term();
            $termQuery->setTerm('catrefitem', $accession_number);
            $this->boolQuery->addMust($termQuery);
        }

       	if ($this->form['yearStart']->getData() || $this->form['yearEnd']->getData()) {
            $startYear = !empty($this->form['yearStart']->getData()) ? $this->form['yearStart']->getData() : 1100;
            $endYear = !empty($this->form['yearEnd']->getData()) ? $this->form['yearEnd']->getData() : 1600;
        	$this->boolQuery->addMust(new \Elastica\Query\Range('datestartnumericES', array('gte' => $startYear,'lte' => $endYear)));
        }

        if (!empty($impressionPeopleES = $this->form['impressionPeopleES']->getData())) {
            $termQuery = new \Elastica\Query\Terms();
            $termQuery->setTerms('impressionPeopleES', array($impressionPeopleES));
            $this->boolQuery->addMust($termQuery);
        }

        return $this;
	
    }

    public function advancedSearch() {

        $this->boolQuery = new \Elastica\Query\BoolQuery();

        if (!empty($keyword = $this->form['keyword']->getData())) {          
            $this->boolQuery->addMust(new \Elastica\Query\SimpleQueryString($keyword));
        }

        //if (!empty($repository = $this->form['repository']->getData())) {
        //    $termQuery = new \Elastica\Query\Match();
        //    $termQuery->setFieldQuery('repository', $repository);
        //    $termQuery->setFieldParam('repository', 'analyzer', 'default');
        //    $this->boolQuery->addMust($termQuery);
        //}

        if (!empty($repository = $this->form['repository']->getData())) {
            $termQuery = new \Elastica\Query\Term();
            $termQuery->setTerm('repository', $repository);
            $this->boolQuery->addMust($termQuery);
        }

        if (!empty($accession_number = $this->form['accession_number']->getData())) {
            $termQuery = new \Elastica\Query\Term();
            $termQuery->setTerm('catrefitem', $accession_number);
            $this->boolQuery->addMust($termQuery);
        }

        if ($this->form['yearStart']->getData() || $this->form['yearEnd']->getData()) {
            $startYear = !empty($this->form['yearStart']->getData()) ? $this->form['yearStart']->getData() : 1100;
            $endYear = !empty($this->form['yearEnd']->getData()) ? $this->form['yearEnd']->getData() : 1600;
            $this->boolQuery->addMust(new \Elastica\Query\Range('datestartnumericES', array('gte' => $startYear,'lte' => $endYear)));
        }

        if (!empty($documentType = $this->form['documentType']->getData())) {
            $this->boolQuery->addMust(
                (new \Elastica\Query\QueryString($documentType, array('documentType')))
                ->setAnalyzer('default')
            );
        }
       
        if ($this->form['waxCountStart']->getData() !== null || $this->form['waxCountEnd']->getData() !== null) {
            $termQuery = new \Elastica\Query\Range('waxCount', array(
                'gte' => $this->form['waxCountStart']->getData(),
                'lte' => $this->form['waxCountEnd']->getData()
            ));
            $this->boolQuery->addMust($termQuery);
        }

       if ($this->form['impressionCountStart']->getData() !== null || $this->form['impressionCountEnd']->getData() !== null) {
            $termQuery = new \Elastica\Query\Range('impressionCount', array(
                'gte' => $this->form['impressionCountStart']->getData(),
                'lte' => $this->form['impressionCountEnd']->getData()
            ));
            $this->boolQuery->addMust($termQuery);
        }

        if ($this->form['printCountStart']->getData() !== null || $this->form['printCountEnd']->getData() !== null) {
            $termQuery = new \Elastica\Query\Range('printCount', array(
                'gte' => $this->form['printCountStart']->getData(),
                'lte' => $this->form['printCountEnd']->getData()
            ));
            $this->boolQuery->addMust($termQuery);
        }

        if (!empty($waxAttachmentSideES = $this->form['waxAttachmentSideES']->getData())) {
            //$this->boolQuery->addMust(
            //    (new \Elastica\Query\QueryString($waxAttachmentSideES, array('waxAttachmentSideES')))
            //    ->setAnalyzer('default')
            //);
	    $termQuery = new \Elastica\Query\Term();
            $termQuery->setTerm('waxs.waxAttachmentSideES', $waxAttachmentSideES);
            $this->boolQuery->addMust($termQuery);
        }

        if (!empty($waxAttachmentTypeES = $this->form['waxAttachmentTypeES']->getData())) {
            //$this->boolQuery->addMust(
            //    (new \Elastica\Query\QueryString($waxAttachmentTypeES, array('waxAttachmentTypeES')))
            //    ->setAnalyzer('default')
            //);
            $termQuery = new \Elastica\Query\Term();
            $termQuery->setTerm('waxs.waxAttachmentTypeES', $waxAttachmentTypeES);
            $this->boolQuery->addMust($termQuery);
        }

        if (!empty($waxColourES = $this->form['waxColourES']->getData())) {
            //$this->boolQuery->addMust(
            //    (new \Elastica\Query\QueryString($waxColourES, array('waxColourES')))
            //    ->setAnalyzer('default')
            //);
            $termQuery = new \Elastica\Query\Term();
            $termQuery->setTerm('waxs.waxColourES', $waxColourES);
            $this->boolQuery->addMust($termQuery);
        }

        if (!empty($waxConditionES = $this->form['waxConditionES']->getData())) {
            //$this->boolQuery->addMust(
            //    (new \Elastica\Query\QueryString($waxConditionES, array('waxConditionES')))
            //    ->setAnalyzer('default')
            //);
            $termQuery = new \Elastica\Query\Term();
            $termQuery->setTerm('waxs.waxConditionES', $waxConditionES);
            $this->boolQuery->addMust($termQuery);
        }

        if (!empty($wasHasImprintsES = $this->form['wasHasImprintsES']->getData())) {
            $this->boolQuery->addMust(
                (new \Elastica\Query\QueryString(''.$wasHasImprintsES, array('wasHasImprintsES')))
                ->setAnalyzer('default')
            );
        }

        if ($this->form['widthStart']->getData() !== null || $this->form['widthEnd']->getData() !== null) {
            $termQuery = new \Elastica\Query\Range('impressionWidthsES', array(
                'gte' => $this->form['widthStart']->getData(),
                'lte' => $this->form['widthEnd']->getData()
            ));
            $this->boolQuery->addMust($termQuery);
        }

        if ($this->form['heightStart']->getData() !== null || $this->form['heightEnd']->getData() !== null) {
            $termQuery = new \Elastica\Query\Range('impressionHeightsES', array(
                'gte' => $this->form['heightStart']->getData(),
                'lte' => $this->form['heightEnd']->getData()
            ));
            $this->boolQuery->addMust($termQuery);
        }

        if (!empty($impressionShapeES = $this->form['impressionShapeES']->getData())) {
            $this->boolQuery->addMust(
                (new \Elastica\Query\QueryString($impressionShapeES, array('impressionShapeES')))
                ->setAnalyzer('default')
            );
        }

        if (!empty($impressionConditionES = $this->form['impressionConditionES']->getData())) {
            $this->boolQuery->addMust(
                (new \Elastica\Query\QueryString($impressionConditionES, array('impressionConditionES')))
                ->setAnalyzer('default')
            );
        }

        if (!empty($impressionPeopleES = $this->form['impressionPeopleES']->getData())) {
            $this->boolQuery->addMust(
                (new \Elastica\Query\QueryString($impressionPeopleES, array('impressionPeopleES')))
                ->setAnalyzer('default')
            );
        }

        if (!empty($impressionPersonTypeES = $this->form['impressionPersonTypeES']->getData())) {
            $this->boolQuery->addMust(
                (new \Elastica\Query\QueryString($impressionPersonTypeES, array('impressionPersonTypeES')))
                ->setAnalyzer('default')
            );
	}

	if (!empty($matchingimpressions = $this->form['matchingimpressions']->getData())) {
            $termQuery = new \Elastica\Query\Term();
            $termQuery->setTerm('matchingimpressions', true);
            $this->boolQuery->addMust($termQuery);
        }

	if (!empty($matchingprints = $this->form['matchingprints']->getData())) {
            $termQuery = new \Elastica\Query\Term();
            $termQuery->setTerm('matchingprints', true);
            $this->boolQuery->addMust($termQuery);
        }
	
	if (!empty($getGoodprint = $this->form['getGoodprint']->getData())) {
            $termQuery = new \Elastica\Query\Term();
            $termQuery->setTerm('getGoodprint', true);
            $this->boolQuery->addMust($termQuery);
        }
	
	if (!empty($getPartialprint = $this->form['getPartialprint']->getData())) {
            $termQuery = new \Elastica\Query\Term();
            $termQuery->setTerm('getPartialprint', true);
            $this->boolQuery->addMust($termQuery);
        }

        return $this;

    }


}
