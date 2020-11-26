<?php

namespace App\DataFixtures;

use App\Entity\HolidayType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class HolidayTypeFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {

        $holidayTypes = new HolidayType();

        $holidayTypes->setCodeName('public_holiday');
        $holidayTypes->setShortDescription('Public holidays');
        $holidayTypes->setDescription('public holidays');
        $manager->persist($holidayTypes);

        $holidayTypes = new HolidayType();

        $holidayTypes->setCodeName('observance');
        $holidayTypes->setShortDescription('Observances, not a public holidays');
        $holidayTypes->setDescription('observances, not a public holidays');
        $manager->persist($holidayTypes);

        $holidayTypes = new HolidayType();

        $holidayTypes->setCodeName('school_holiday');
        $holidayTypes->setShortDescription('School holidays');
        $holidayTypes->setDescription('school holidays');
        $manager->persist($holidayTypes);

        $holidayTypes = new HolidayType();

        $holidayTypes->setCodeName('other_day');
        $holidayTypes->setShortDescription('Other important days');
        $holidayTypes->setDescription('other important days e.g. Mother day, Father day etc');
        $manager->persist($holidayTypes);

        $holidayTypes = new HolidayType();

        $holidayTypes->setCodeName('extra_working_day');
        $holidayTypes->setShortDescription('Extra working days');
        $holidayTypes->setDescription('extra working days. This day takes place mostly on Saturday or Sunday and is substituted for extra public holiday');
        $manager->persist($holidayTypes);


        $holidayTypes = new HolidayType();

        $holidayTypes->setCodeName('postal_holiday');
        $holidayTypes->setShortDescription('Postal holiday');
        $holidayTypes->setDescription('In the United States, a postal holiday is a Federal holiday recognized by the United States Postal Service, during which no regular mail is delivered, however Priority Mail Express items will still be delivered as that service functions year round');
        $manager->persist($holidayTypes);

        $manager->flush();
    }
}
