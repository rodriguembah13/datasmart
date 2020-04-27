<?php

namespace App\Command;

use App\Repository\CustomerRepository;
use App\Repository\PlanningRepository;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Twig\Environment;

class SendMailCommand extends ContainerAwareCommand
{
    protected static $defaultName = 'app:sendMail';
    private $planningRepository;
    private $swift_Mailer;
    private $customerRepository;
    private $twig;

    /**
     * SendMailCommand constructor.
     *
     * @param $planningRepository
     */
    public function __construct(Environment $twig, CustomerRepository $customerRepository, PlanningRepository $planningRepository, \Swift_Mailer $swift_Mailer)
    {
        parent::__construct(null);
        $this->planningRepository = $planningRepository;
        $this->swift_Mailer = $swift_Mailer;
        $this->customerRepository = $customerRepository;
        $this->twig = $twig;
    }

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
        /*    ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        */;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        // $arg1 = $input->getArgument('arg1');

        $authors = $this->planningRepository->findWhereDelaiPass();
        $io->progressStart(count($authors));
        foreach ($this->customerRepository->findAll() as $customer) {
            $arrayStep = [];
            $stepSuspects = $this->planningRepository->findWhereDelaiPassAndCustomers($customer);
            if (null != $stepSuspects) {
                foreach ($stepSuspects as $stepSuspect) {
                    if (!in_array($stepSuspect->getStepStrategy(), $arrayStep)) {
                        $arrayStep[] = $stepSuspect->getStepStrategy();
                    }
                }
                $this->sendMail($customer->getName(), $arrayStep, 'rodriguembah13@gmail.com', $customer->getCompte()->getEmail());
            }
        }
        foreach ($authors as $author) {
            $io->progressAdvance();
            $output->writeln($author->getStepStrategy()->getStrategy()->getCreateBy()->getName().' : '.$author->getStepStrategy()->getStep()->getName());
        }
        $io->progressFinish();
        $io->success('Weekly reports were sent to authors!');

        return 0;
    }

    public function sendMail($name, $steps, $sendMail, $receiveMail)
    {
        $message = (new \Swift_Message('Smart Message'))
            ->setFrom($sendMail)
            ->setTo($receiveMail)
            ->setBody(
                $this->twig->render(
                    'emails/message.html.twig',
                    [
                        'steps' => $steps,
                        'name' => $name,
                    ]
                ),
                'text/html'
            )
        ;
        $this->swift_Mailer->send($message);
    }
}
