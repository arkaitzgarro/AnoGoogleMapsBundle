<?php

/**
 * This file is part of the AnoGoogleMapsBundle
 *
 * (c) anonymation <contact@anonymation.com>
 *
 */

namespace Ano\Bundle\GoogleMapsBundle\Model;

class DistanceMatrixAddress
{
    /* @var array */
    protected $destinationAddresses;

    /* @var array */
    protected $originAddresses;

    /**
     * @param array $destinationAddresses
     */
    public function setDestinationAddresses($destinationAddresses)
    {
        $this->destinationAddresses = $destinationAddresses;
    }

    /**
     * @return array
     */
    public function getDestinationAddresses()
    {
        return $this->destinationAddresses;
    }

    /**
     * @param array $originAddresses
     */
    public function setOriginAddresses($originAddresses)
    {
        $this->originAddresses = $originAddresses;
    }

    /**
     * @return array
     */
    public function getOriginAddresses()
    {
        return $this->originAddresses;
    }
}