<?php

namespace App\Command;

use App\Repository\PlanningRepository;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class TestMailCommand extends Command
{
    protected static $defaultName = 'app:testMail';
    private $planningRepository;
    private $swift_Mailer;

    /**
     * SendMailCommand constructor.
     *
     * @param $planningRepository
     */
    public function __construct(PlanningRepository $planningRepository, \Swift_Mailer $swift_Mailer)
    {
        parent::__construct(null);
        $this->planningRepository = $planningRepository;
        $this->swift_Mailer = $swift_Mailer;
    }

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');
        //$arg2 = $input->getArgument('arg2');

        $this->sendMail('mbah', 'rodrigue@smartworldafriq.com', $arg1);

        $io->success('your is send ');

        return 0;
    }

    public function sendMail($name, $sendMail, $receiveMail)
    {
        $message = (new \Swift_Message('Smart Message'))
            ->setFrom($sendMail)
            ->setTo($receiveMail)
            ->setBody($name.'vous avez recu un mail')
        ;
        $this->swift_Mailer->send($message);
    }
}
