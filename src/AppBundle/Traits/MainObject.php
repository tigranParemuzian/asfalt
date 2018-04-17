<?php
/**
 * Created by PhpStorm.
 * User: tigran
 * Date: 9/14/17
 * Time: 10:28 PM
 */

namespace AppBundle\Traits;

use Symfony\Component\Validator\Constraints as Assert;

trait MainObject
{

    private $toSettings;
    private $fromSettings;
    private $values;

    /**
     * Add value
     *
     * @param \AppBundle\Entity\Settings $toSettings
     *
     * @return $this
     */
    public function addToSettings(\AppBundle\Entity\Settings $toSettings)
    {
        $this->toSettings[] = $toSettings;

        return $this;
    }

    /**
     * Remove value
     *
     * @param \AppBundle\Entity\Settings $toSettings
     */
    public function removeToSettings(\AppBundle\Entity\Settings $toSettings)
    {
        $this->toSettings->removeElement($toSettings);
    }

    /**
     * Get values
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getToSettings()
    {
        return $this->toSettings;
    }

    /**
     * Add value
     *
     * @param \AppBundle\Entity\Settings $fromSettings
     *
     * @return $this
     */
    public function addFromSettings(\AppBundle\Entity\Settings $fromSettings)
    {
        $this->fromSettings[] = $fromSettings;

        return $this;
    }

    /**
     * Remove value
     *
     * @param \AppBundle\Entity\Settings $fromSettings
     */
    public function removeFromSettings(\AppBundle\Entity\Settings $fromSettings)
    {
        $this->fromSettings->removeElement($fromSettings);
    }

    /**
     * Get values
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFromSettings()
    {
        return $this->fromSettings;
    }

    public function setValues(array $value){
        $this->values[] = $value;
    }

    public function getValues(){
        return $this->values;
    }
}