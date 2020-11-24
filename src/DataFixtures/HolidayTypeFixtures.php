<?php

namespace App\DataFixtures;

use App\Entity\HolidayTypes;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class HolidayTypeFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
//        $holidayTypes = new HolidayTypes();

//        $holidayTypes->setCodeName('all');
//        $holidayTypes->getDescription('all holiday types');
//        $manager->persist($holidayTypes);

        $holidayTypes = new HolidayTypes();

        $holidayTypes->setCodeName('public_holiday');
        $holidayTypes->setShortDescription('Public holidays');
        $holidayTypes->setDescription('public holidays');
        $manager->persist($holidayTypes);

        $holidayTypes = new HolidayTypes();

        $holidayTypes->setCodeName('observance');
        $holidayTypes->setShortDescription('Observances, not a public holidays');
        $holidayTypes->setDescription('observances, not a public holidays');
        $manager->persist($holidayTypes);

        $holidayTypes = new HolidayTypes();

        $holidayTypes->setCodeName('school_holiday');
        $holidayTypes->setShortDescription('School holidays');
        $holidayTypes->setDescription('school holidays');
        $manager->persist($holidayTypes);

        $holidayTypes = new HolidayTypes();

        $holidayTypes->setCodeName('other_day');
        $holidayTypes->setShortDescription('Other important days');
        $holidayTypes->setDescription('other important days e.g. Mother day, Father day etc');
        $manager->persist($holidayTypes);

        $holidayTypes = new HolidayTypes();

        $holidayTypes->setCodeName('extra_working_day');
        $holidayTypes->setShortDescription('Extra working days');
        $holidayTypes->setDescription('extra working days. This day takes place mostly on Saturday or Sunday and is substituted for extra public holiday');
        $manager->persist($holidayTypes);

        $manager->flush();
    }
}
