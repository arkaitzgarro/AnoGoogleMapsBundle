<?php

/**
 * This file is part of the AnoGoogleMapsBundle
 *
 * (c) anonymation <contact@anonymation.com>
 *
 */

namespace Ano\Bundle\GoogleMapsBundle\Model;

class DistanceMatrixRow
{
    /* @var array */
    protected $distance;

    /* @var array */
    protected $duration;

    
    public function __construct($distance = array(), $duration = array())
    {
        $this->setDistance($distance);
        $this->setDuration($duration);
    }

    /**
     * @param array $distance
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;
    }

    /**
     * @return array
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * @return string
     */
    public function getDistanceText()
    {
        return $this->distance['text'];
    }

    /**
     * @return integer
     */
    public function getDistanceValue()
    {
        return $this->distance['value'];
    }

    /**
     * @param array $duration
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;
    }

    /**
     * @return array
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @return string
     */
    public function getDurationText()
    {
        return $this->duration['text'];
    }

    /**
     * @return integer
     */
    public function getDurationValue()
    {
        return $this->duration['value'];
    }
}