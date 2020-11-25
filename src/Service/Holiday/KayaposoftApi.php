<?php

namespace App\Service\Holiday;

use App\Service\HttpClientService;

class KayaposoftApi extends HttpClientService
{

    public function getSupportedCountries(){
        return $this->getArrayContent(
            'GET',
            'https://kayaposoft.com/enrico/json/v2.0/?action=getSupportedCountries'
        );
    }

}