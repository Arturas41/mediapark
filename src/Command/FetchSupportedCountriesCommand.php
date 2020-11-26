<?php

namespace App\Command;

use App\Entity\HolidayApis;
use App\Service\Holiday\KayaposoftApi;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
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

        $holidayApisRepository = $this->em->getRepository(HolidayApis::class);
        $holidayApisNames = $holidayApisRepository->findAll();

        if (empty($holidayApisNames)) {
            throw new \LogicException('No holiday Apis has been found');
        }

        $helper = $this->getHelper('question');

        $holidayApisNames = array_map(function ($holidayApi) {
            return $holidayApi->getName();
        }, $holidayApisNames);

        $question = new ChoiceQuestion(
            'Select holidays API:',
            $holidayApisNames
        );

        $holidayApi = $helper->ask($input, $output, $question);

        if ($holidayApi === "kayaposoft") {
            $supportedCountries = $this->kayaposoftApi->getSupportedCountries();
        } else {
            $output->writeln("selected API is not supported");
            return Command::FAILURE;
        }

//        $output->writeln($supportedCountries);

        return Command::SUCCESS;

    }
}