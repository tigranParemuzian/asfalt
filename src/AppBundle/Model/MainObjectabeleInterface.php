<?php

namespace AppBundle\Model;

interface MainObjectabeleInterface
{

    /**
     * Add value
     *
     * @param \AppBundle\Entity\Settings $toSettings
     *
     * @return $this
     */
    public function addToSettings(\AppBundle\Entity\Settings $toSettings);

    /**
     * Remove value
     *
     * @param \AppBundle\Entity\Settings $toSettings
     */
    public function removeToSettings(\AppBundle\Entity\Settings $toSettings);

    /**
     * Get values
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getToSettings();

    /**
     * Add value
     *
     * @param \AppBundle\Entity\Settings $fromSettings
     *
     * @return $this
     */
    public function addFromSettings(\AppBundle\Entity\Settings $fromSettings);

    /**
     * Remove value
     *
     * @param \AppBundle\Entity\Settings $fromSettings
     */
    public function removeFromSettings(\AppBundle\Entity\Settings $fromSettings);

    /**
     * Get values
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFromSettings();

}