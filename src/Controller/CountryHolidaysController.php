<?php

namespace App\Controller;

use App\Entity\Country;
use App\Entity\HolidayType;
use App\Entity\SupportedCountry;
use App\Form\Type\CountryHolidaysType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Service\Holiday\KayaposoftApi;

class CountryHolidaysController extends AbstractController
{
    protected EntityManager $em;

    public function __construct(EntityManagerInterface $em, KayaposoftApi $kayaposoftApi)
    {
        $this->em = $em;
        $this->kayaposoftApi = $kayaposoftApi;
    }

    /**
     * @Route("/", name="index")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {

        if ($request->isXmlHttpRequest()) {
            $data = json_decode($request->getContent(), true);
            $presetData = $this->em->getRepository(SupportedCountry::class)->findOneBy(['id' => $data['country_holidays_country']]);
        } else {
            $presetData = $this->em->getRepository(SupportedCountry::class)->findOneBy([]);
        }

        $form = $this->createForm(CountryHolidaysType::class, $presetData);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $holidayType = $this->em->getRepository(HolidayType::class)->findOneBy(
                ['codeName' => 'public_holiday']
            );
            return $this->redirect($this->generateUrl('submit',
                [
                    'country' => $form->getData()->getCountry()->getId(),
                    'holidayType' => $holidayType->getId(),
                    'year' => $form->get("year")->getData(),
                ])
            );
        }

        return $this->render('countryHolidays/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/submit/{country}/{holidayType}/{year}", name="submit")
     * @param Request $request
     * @param Country $country
     * @param HolidayType $holidayType
     * @param int $year
     * @return Response
     * @ParamConverter("country", class="App\Entity\Country")
     * @ParamConverter("holidayType", class="App\Entity\HolidayType")
     */
    public function submit(Request $request, Country $country, HolidayType $holidayType, int $year): Response
    {
        $data['holidaysForYearData'] = $this->kayaposoftApi->getHolidaysForYear($country,$holidayType, $year);
        $data['holidaysForYearData'] = array_group_by($data['holidaysForYearData'], function ($row) {
            $monthNum  = $row['date']['month'];
            $dateObj   = \DateTime::createFromFormat('!m', $monthNum);
            return $dateObj->format('F');
        });
        $data['isTodayWorkDay'] = $this->kayaposoftApi->isWorkDay($country, new \DateTime());
        $data['isTodayPublicHoliday'] = $this->kayaposoftApi->isPublicHoliday($country, new \DateTime());

        return $this->render('countryHolidays/submit.html.twig', [
            'holidaysForYearData' => $data['holidaysForYearData'],
            'isTodayWorkDay' => $data['isTodayWorkDay'],
            'isTodayPublicHoliday' => $data['isTodayPublicHoliday'],
        ]);

    }

}