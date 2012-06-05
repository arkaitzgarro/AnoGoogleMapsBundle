<?php

/**
 * This file is part of the AnoGoogleMapsBundle
 *
 * (c) anonymation <contact@anonymation.com>
 *
 */

namespace Ano\Bundle\GoogleMapsBundle\Service;

use Ano\Bundle\GoogleMapsBundle\Model\DistanceMatrixAPIResult;
use Ano\Bundle\GoogleMapsBundle\Model\DistanceMatrixAddress;
use Ano\Bundle\GoogleMapsBundle\Model\DistanceMatrixRow;


class DistanceMatrixAPIQuery extends APIQueryAbstract
{
    protected $serviceUri = 'https://maps.googleapis.com/maps/api/distancematrix';

    public function __construct(array $parameters = array(), $format = 'json')
    {
        $this->allowedFormats = array('json', 'xml');
        $this->result = new DistanceMatrixAPIResult();
        
        parent::__construct($parameters, $format);
    }

    /**
     * @return Ano\Bundle\GoogleMapsBundle\Model\DistanceMatrixAPIResult
     */
    protected function parseResponse($response)
    {
        switch(mb_strtolower($this->format)) {
            case 'json':
                $this->parseJson($response);
            break;

            case 'xml':
                $this->parseXml($response);
            break;
        }

        return $this->result;
    }

    protected function parseJson($json)
    {
        $response = json_decode($json, true);
        if (!is_array($response)) {
            $this->setResultStatus(DistanceMatrixAPIResult::STATUS_INVALID_RESPONSE, false);
            return;
        }
        
        if (!array_key_exists('rows', $response) || !array_key_exists('status', $response)) {
            $this->setResultStatus(DistanceMatrixAPIResult::STATUS_INVALID_RESPONSE, false);
            return;
        }

        $resultCount = count($response['rows']);
        if ($resultCount <= 0) {
            $this->setResultStatus(DistanceMatrixAPIResult::STATUS_ZERO_RESULTS, false);
            return;
        }

        if ($resultCount > 1) {
            $this->setResultStatus(DistanceMatrixAPIResult::STATUS_NOT_SPECIFIC_ENOUGH, false);
            return;
        }

        $data = $response;
        $status = $response['status'];
        unset($data['status']);

        $arrayData = array(
            'address' => array(),
            'rows' => array()
        );

        // parsing address
        $arrayData['address']['destination_addresses'] = $data['destination_addresses'];
        $arrayData['address']['origin_addresses'] = $data['origin_addresses'];

        // parsing rows
        foreach ($data['rows'][0]['elements'] as $key => $value) {
            $arrayData['rows'][] = $value;
        }

        return $this->buildResult($arrayData, $status);
    }

    private function parseXml($xml)
    {
        // TODO
    }

    private function buildResult(array $arrayData, $status)
    {
        $address = new DistanceMatrixAddress();
        if (array_key_exists('destination_addresses', $arrayData['address'])) {
            $address->setDestinationAddresses($arrayData['address']['destination_addresses']);
        }
        if (array_key_exists('origin_addresses', $arrayData['address'])) {
            $address->setOriginAddresses($arrayData['address']['origin_addresses']);
        }

        $this->result->setAddress($address);

        foreach ($arrayData['rows'] as $key => $value) {
            if($value['status'] == "OK") {
                $row = new DistanceMatrixRow();
                if(array_key_exists('distance', $value)) {
                    $row->setDistance($value['distance']);
                }
                if(array_key_exists('duration', $value)) {
                    $row->setDuration($value['duration']);
                }

                $this->result->addRow($row);
            }
        }
        
        $this->result->setSuccess(true);

        $this->buildStatus($status);

        return $this->result;
    }

    protected function buildStatus($status)
    {
        switch(mb_strtolower($status)) {
            case 'ok':
                $this->setResultStatus(DistanceMatrixAPIResult::STATUS_OK, true);
            break;

            case 'zero_results':
                $this->setResultStatus(DistanceMatrixAPIResult::STATUS_ZERO_RESULTS, false);
            break;

            case 'over_query_limit':
                $this->setResultStatus(DistanceMatrixAPIResult::STATUS_OVER_QUERY_LIMIT, false);
            break;

            case 'request_denied':
                $this->setResultStatus(DistanceMatrixAPIResult::STATUS_REQUEST_DENIED, false);
            break;

            case 'invalid_request':
                $this->setResultStatus(DistanceMatrixAPIResult::STATUS_INVALID_REQUEST, false);
            break;

            default:
                $this->setResultStatus(DistanceMatrixAPIResult::STATUS_INVALID_RESPONSE, false);
        }
    }

    protected function setResultStatus($status, $success)
    {
        $this->result->setStatus($status);
        $this->result->setSuccess($success);
    }
}