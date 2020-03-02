<?php

/*
 * This file is part of the AdminLTE-Bundle demo.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use App\Form\FormDemoModelType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use Knp\Component\Pager\PaginatorInterface;
use Laminas\Json\Expr;
use Ob\HighchartsBundle\Highcharts\Highchart;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Default controller.
 *
 * @IsGranted("ROLE_USER")
 */
class DefaultController extends AbstractController
{
    /**
     * @Route("/", defaults={}, name="homepage")
     */
    public function index(UserRepository $userRepository)
    {
        $users = $userRepository->findAll();
        //$count = count($items);
        $arrayDepartementts_code = [];
        $arrayDepartementts_effectifs = [];
        $series = [
            [
                'name' => 'Employes',
                'type' => 'column',
                'color' => '#4572A7',
                'yAxis' => 1,
              //  'data' => [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4],
                'data' => $arrayDepartementts_effectifs,
            ],
        ];
        $yData = [
            [
                'labels' => [
                   // 'formatter' => new Expr('function () { return this.value + " degrees C" }'),
                    'style' => ['color' => '#AA4643'],
                ],
                'title' => [
                    'text' => 'Effectif',
                    'style' => ['color' => '#AA4643'],
                ],
                'opposite' => true,
            ],
          [
                'labels' => [
                   // 'formatter' => new Expr('function () { return this.value + " mm" }'),
                    'style' => ['color' => '#4572A7'],
                ],
                'gridLineWidth' => 0,
                'title' => [
                    'text' => 'Effectif',
                    'style' => ['color' => '#4572A7'],
                ],
            ],
        ];
        $categories = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        $ob = new Highchart();
        $ob->chart->renderTo('container'); // The #id of the div where to render the chart
        $ob->chart->type('column');
        $ob->title->text('Effectif par Departement');
        $ob->xAxis->categories($arrayDepartementts_code);
        $ob->yAxis($yData);
        $ob->legend->enabled(true);
        /*    $formatter = new Expr('function () {
                     var unit = {
                         "Rainfall": "mm",
                         "Temperature": "degrees C"
                     }[this.series.name];
                     return this.x + ": <b>" + this.y + "</b> " + unit;
                 }');
            $ob->tooltip->formatter($formatter);*/
        $ob->series($series);

        return $this->render('default/index.html.twig', [
          //  'nbemp' => $count,
            'nbusers' => count($users),
            //'nbdepartements' => count($departements),
           // 'precences' => count($presences), 'chart' => $ob,
        ]);
    }

    /**
     * @Route("/config-rh", defaults={}, name="configpage")
     */
    public function config(UserRepository $userRepository,EntityManagerInterface $em, PaginatorInterface $paginator, Request $request)
    {
        $dql = 'SELECT a FROM App\Entity\User a';
        $query = $em->createQuery($dql);
        $pagination = $paginator->paginate($query, $request->query->getInt('page', 1), 100);

        return $this->render('default/config.html.twig', [
            'users' => $pagination,
           /* 'nbholydays' => count($holidayRepository->findByBetweenDate('2020-01-01', '2020-01-31')),
            'entreprises' => count($entrepriseRepository->findAll()),
            'currencies' => count($currencyRepository->findAll()),
            'workdays' => count($workDayRepository->findAll()),*/
        ]);
    }

    /**
     * @Route("/forms", defaults={}, name="forms")
     */
    public function forms(Request $request)
    {
        $form = $this->createForm(FormDemoModelType::class);
        $form = $this->handleForm($request, $form);

        return $this->render('default/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/forms2", defaults={}, name="forms2")
     */
    public function forms2(Request $request)
    {
        $form = $this->createForm(FormDemoModelType::class);
        $form = $this->handleForm($request, $form);

        return $this->render('default/form-horizontal.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/forms3", defaults={}, name="forms3")
     */
    public function forms3(Request $request)
    {
        $form = $this->createForm(FormDemoModelType::class);
        $form = $this->handleForm($request, $form);

        return $this->render('default/form-sidebar.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    protected function handleForm(Request $request, FormInterface $form)
    {
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $this->addFlash('success', 'Fantastic work! You nailed it, form has no errors :-)');
            } else {
                $this->addFlash('error', 'Form has errors ... please fix them!');
            }
        }

        return $form;
    }

    /**
     * @Route("/context", defaults={}, name="context")
     */
    public function context()
    {
        return $this->render('default/context.html.twig', []);
    }

    public function userPreferences()
    {
        return $this->render('control-sidebar/settings.html.twig', []);
    }

    /**
     * @Route("/print-pdf", defaults={}, name="printpdf")
     */
    public function print()
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('default/mypdf.html.twig', [
            'title' => 'Welcome to our PDF Test',
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream('mypdf.pdf', [
            'Attachment' => false,
        ]);
    }
}
