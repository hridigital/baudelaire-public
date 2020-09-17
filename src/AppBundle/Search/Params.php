<?php

namespace AppBundle\Search;

class Params
{
    private $matchingimpressions;
    private $matchingprints;
    private $goodprint;
    private $partialprint;

    public function __construct() {

    }

    public function getMatchingimpressions() {
            return $this->matchingimpressions;
    }

    public function getMatchingprints() {
            return $this->matchingprints;
    }

    public function getGetGoodprint() {
            return $this->goodprint;
    }
    
    public function getGetPartialprint() {
            return $this->partialprint;
    }

    public function setMatchingimpressions($matchingimpressions) {
        $this->matchingimpressions = $matchingimpressions;
        return $this;
    }

    public function setMatchingprints($matchingprints) {
        $this->matchingprints = $matchingprints;
        return $this;
    }

    public function setGetGoodprint($goodprint) {
        $this->goodprint = $goodprint;
        return $this;
    }

    public function setGetPartialprint($partialprint) {
        $this->partialprint = $partialprint;
        return $this;
    }


}

