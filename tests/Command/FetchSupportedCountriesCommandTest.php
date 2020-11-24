<?php

namespace App\Tests\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class FetchSupportedCountriesCommandTest extends KernelTestCase
{

    public function testCheckIfKayaposoftApiExists()
    {
        $kernel = static::createKernel();
        $application = new Application($kernel);

        $command = $application->find('app:fetch-supported-countries');

        $commandTester = new CommandTester($command);

        $commandTester->setInputs(['kayaposoft']);

        $commandTester->execute(['command' => $command->getName()]);

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('kayaposoft', $output);

    }
}