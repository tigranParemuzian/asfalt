<?php

namespace AppBundle\Model;

interface AttributeInterface
{
    public function getClassName();
//    public function __clone();
//    public function __toString();
    public function setCreated($created);
    public function getCreated();
    public function setUpdated($updated);
    public function getUpdated();
    public function getTitle();
    public function setTitle($title);
    public function getSlug();
    public function setSlug($slug);
    public function getSortOrdering();
    public function setSortOrdering($sortOrdering);


}