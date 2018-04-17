<?php

namespace AppBundle\Model;

interface ConfiguratorInterface
{

    public function getClassName();
    public function __clone();
    public function __toString();
    public function getState();
    public function setState($state);
    public function __construct();
    public function setName($name);
    public function getName();
    public function setSlug($slug);
    public function getSlug();
    public function setCreated($created);
    public function getCreated();
    public function setUpdated($updated);
    public function getUpdated();
    public function getValues();
    public function getSettings();

}