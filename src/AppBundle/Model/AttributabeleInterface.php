<?php

namespace AppBundle\Model;

interface AttributabeleInterface
{

    public function setSortOrdering($sortOrdering);

    /**
     * Get sortOrdering
     *
     * @return int
     */
    public function getSortOrdering();

    /**
     * @param $isEnable
     * @return $this
     */
    public function setIsEnable($isEnable);

    /**
     * Get isEnable
     *
     * @return bool
     */
    public function getIsEnable();


    /**
     * Add attributesDefinition
     */
    public function setAttributesDefinition(\AppBundle\Entity\AttributesDefinition $attributesDefinition);

    /**
     * Get attributesDefinition
     */
    public function getAttributesDefinition();


    /**
     * Get belongsTo
     */
    public function getBelongsTo();

}