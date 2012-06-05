<?php

/**
 * This file is part of the AnoGoogleMapsBundle
 *
 * (c) anonymation <contact@anonymation.com>
 *
 */

namespace Ano\Bundle\GoogleMapsBundle\Model;


class DistanceMatrixAPIResult extends APIResultAbstract
{
    const STATUS_OK = 'OK';
    const STATUS_ZERO_RESULTS = 'ZERO_RESULTS';
    const STATUS_OVER_QUERY_LIMIT = 'OVER_QUERY_LIMIT';
    const STATUS_REQUEST_DENIED = 'REQUEST_DENIED';
    const STATUS_INVALID_REQUEST = 'INVALID_REQUEST';
    const STATUS_INVALID_RESPONSE = 'INVALID_RESPONSE';
    const STATUS_NOT_SPECIFIC_ENOUGH = 'NOT_SPECIFIC_ENOUGH';

    /* @var DistanceMatrixAddress */
    protected $address;

    /* @var array DistanceMatrixRow */
    protected $rows;
    

    public function __construct(DistanceMatrixAddress $address = null, DistanceMatrixRow $rows = null)
    {
        $this->address = $address;
        $this->rows = $rows;
    }

    /**
     * @param DistanceMatrixAddress $address
     */
    public function setAddress(DistanceMatrixAddress $address)
    {
        $this->address = $address;
    }

    /**
     * @return DistanceMatrixAddress
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Add horarioCocina
     *
     * @param DistanceMatrixRow $row
     */
    public function addRow(DistanceMatrixRow $row)
    {
        $this->rows[] = $row;
    }

    /**
     * @param DistanceMatrixRows $rows
     */
    public function setRows(DistanceMatrixRow $rows)
    {
        $this->rows = $rows;
    }

    /**
     * @return DistanceMatrixRows
     */
    public function getRows()
    {
        return $this->rows;
    }

}