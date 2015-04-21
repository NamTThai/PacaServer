<?php

class Picture {

    private $address;
    private $next;

    function __construct($address) {
        $this->address = $address;
        $this->next = null;
    }

    function getAddress() {
        return $this->address;
    }

    function getNext() {
        return $this->next;
    }

    function hasNext() {
        return $this->next != null;
    }

    function setNext($next) {
        $this->next = $next;
    }

}

?>
