<?php

namespace App\Command;

use App\Repository\PlanningRepository;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SendMailCommand extends ContainerAwareCommand
{
    protected static $defaultName = 'app:sendMail';
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
        foreach ($authors as $author) {
            $io->progressAdvance();
            $output->writeln($author->getStepStrategy()->getStrategy()->getCreateBy()->getName().' : '.$author->getStepStrategy()->getStep()->getName());
        }
        $io->progressFinish();
        $io->success('Weekly reports were sent to authors!');

        return 0;
    }

    public function sendMail($name, $sendMail, $receiveMail)
    {

        $message = (new \Swift_Message('Smart Message'))
            ->setFrom($sendMail)
            ->setTo($receiveMail)
            ->setBody(
                $this->renderView(
                // templates/emails/registration.html.twig
                    'emails/message.html.twig',
                    ['name' => $name]
                ),
                'text/html'
            )
        ;
        $this->swift_Mailer->send($message);
    }
}
