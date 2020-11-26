<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\HolidayApi;

class HolidayApisFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $holidayApis = new HolidayApi();

        $holidayApis->setName('kayaposoft');
        $holidayApis->setUrl('https://kayaposoft.com/enrico/json/v2.0/');
        $manager->persist($holidayApis);

        $holidayApis = new HolidayApi();

        $holidayApis->setName('unusable');
        $holidayApis->setUrl('https://unusable.test123');
        $manager->persist($holidayApis);

        $manager->flush();
    }
}
