<?php

namespace App\Command;

use App\Entity\Country;
use App\Entity\HolidayApi;
use App\Entity\HolidayType;
use App\Entity\SupportedCountry;
use App\Service\Holiday\KayaposoftApi;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

class FetchSupportedCountriesCommand extends Command
{

    protected static $defaultName = 'app:fetch-supported-countries';

    protected EntityManager $em;

    private KayaposoftApi $kayaposoftApi;

    public function __construct(EntityManagerInterface $em, KayaposoftApi $kayaposoftApi)
    {
        $this->em = $em;
        $this->kayaposoftApi = $kayaposoftApi;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Fetch supported countries from holidays API and fill it to database')
            ->setHelp('Fetch supported countries from holidays API and fill it to database');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $holidayApiRepository = $this->em->getRepository(HolidayApi::class);
        $holidayApis = $holidayApiRepository->findAll();

        if (empty($holidayApis)) {
            throw new \LogicException('No holiday Apis has been found');
        }

        $helper = $this->getHelper('question');

        $holidayApisNames = array_map(function ($holidayApi) {
            return $holidayApi->getName();
        }, $holidayApis);

        $question = new ChoiceQuestion(
            'Select holidays API:',
            $holidayApisNames
        );

        $holidayApiInput = $helper->ask($input, $output, $question);

        //todo modify data for each API
        if ($holidayApiInput === "kayaposoft") {
            $holidayApiEntity = $holidayApiRepository->findOneBy(['name' => 'kayaposoft']);
            $supportedCountryArr = $this->kayaposoftApi->getSupportedCountries();
        } else {
            $output->writeln("selected API is not supported");
            return Command::FAILURE;
        }

        //todo too many DB requests
        foreach ($supportedCountryArr as $key => $value) {

            $countryEntity = $this->saveOrUpdateCountry($value);
            $supportedCountryEntity = $this->saveOrUpdateSupportedCountry($value, $countryEntity, $holidayApiEntity);
            $this->saveOrUpdateHolidayTypes($value, $supportedCountryEntity);

        }

        try {
            $this->em->flush();
        } catch (OptimisticLockException $e) {
            throw new Exception($e);
            return Command::FAILURE;
        } catch (ORMException $e) {
            throw new Exception($e);
            return Command::FAILURE;
        }

        return Command::SUCCESS;

    }


    private function saveOrUpdateCountry(array $data): Country
    {
        $country = $this->em->getRepository(Country::class)->findOneBy(
            ['name' => $data['fullName']]
        );

        if (empty($country)) {
            $country = new Country();
            $country->setName($data['fullName']);
            $country->setCode($data['countryCode']);
        }

        try {
            $this->em->persist($country);
        } catch (ORMException $e) {
            throw new Exception($e);
            //todo return smth else or die;?
            return Command::FAILURE;
        }

        return $country;
    }

    private function saveOrUpdateSupportedCountry(array $data, Country $country, HolidayApi $holidayApi): SupportedCountry
    {
        $supportedCountryRepository = $this->em->getRepository(SupportedCountry::class);

        $supportedCountry = $supportedCountryRepository->findOneBy(
            [
                'country' => $country->getId(),
                'holidayApi' => $holidayApi->getId()
            ]
        );

        if (empty($supportedCountry)) {
            $supportedCountry = new SupportedCountry();
            $supportedCountry->setCountry($country);
            $supportedCountry->setHolidayApi($holidayApi);
        }

        //date start
        $fromDate = new \DateTime();
        $fromDate->setDate(
            $data['fromDate']['year'],
            $data['fromDate']['month'],
            $data['fromDate']['day']
        );
        $fromDate->setTime(0, 0, 0);

        $supportedCountry->setFromDate($fromDate);

        //todo change it in data modifier or do validation
        $toDate = new \DateTime();
        if ($data['toDate']['year'] >= 9999) {
            $data['toDate']['year'] = 9999;
        }
        $toDate->setDate(
            $data['toDate']['year'],
            $data['toDate']['month'],
            $data['toDate']['day']
        );
        $toDate->setTime(0, 0, 0);
        $supportedCountry->setToDate($toDate);

        try {
            $this->em->persist($supportedCountry);
        } catch (ORMException $e) {
            throw new Exception($e);
            return Command::FAILURE;
        }

        return $supportedCountry;
    }

    //todo remove all types before adding
    private function saveOrUpdateHolidayTypes(array $data, SupportedCountry $supportedCountry): void
    {
        $holidayTypeRepository = $this->em->getRepository(HolidayType::class);
        foreach ($data['holidayTypes'] as $key => $value) {

            $holidayType = $holidayTypeRepository->findOneBy(
                [
                    'codeName' => $value
                ]
            );

            if (!empty($holidayType)) {
                $supportedCountry->addHolidayType($holidayType);
            }

        }
    }

}