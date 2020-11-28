<?php

namespace App\Service\Holiday;

use App\Entity\Country;
use App\Entity\HolidayType;
use App\Service\HttpClientService;

class KayaposoftApi extends HttpClientService
{
    private string $apiUrl = 'https://kayaposoft.com/enrico/json/v2.0/';

    public function getSupportedCountries(){
        $queryParams = [
            'action' => 'getSupportedCountries',
        ];
        $query = http_build_query($queryParams);
        return $this->getArrayContent(
            'GET',
            $this->apiUrl . '?' . $query
        );
    }

    public function getHolidaysForYear(Country $country, HolidayType $holidayType, string $year){
        $queryParams = [
            'action' => 'getHolidaysForYear',
            'year' => $year,
            'country' => $country->getCode(),
            'holidayType'=> $holidayType->getCodeName(),
        ];
        $query = http_build_query($queryParams);
        return $this->getArrayContent(
            'GET',
            $this->apiUrl . '?' . $query
        );
    }

    public function isPublicHoliday(Country $country, \DateTime $date){
        $queryParams = [
            'action' => 'isPublicHoliday',
            'date' => $date->format('d-m-Y'),
            'country' => $country->getCode(),
        ];
        $query = http_build_query($queryParams);
        return $this->getArrayContent(
            'GET',
            $this->apiUrl . '?' . $query
        );
    }

    public function isWorkDay(Country $country, \DateTime $date){
        $queryParams = [
            'action' => 'isWorkDay',
            'date' => $date->format('d-m-Y'),
            'country' => $country->getCode(),
        ];
        $query = http_build_query($queryParams);
        return $this->getArrayContent(
            'GET',
            $this->apiUrl . '?' . $query
        );
    }
}