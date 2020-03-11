<?php

/*
 * This file is part of the AdminLTE-Bundle demo.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\EventSubscriber;

use App\Repository\CommentRepository;
use KevinPapst\AdminLTEBundle\Event\MessageListEvent;
use KevinPapst\AdminLTEBundle\Model\MessageModel;
use KevinPapst\AdminLTEBundle\Model\UserModel;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Security;

/**
 * Class MessageSubscriber adds user messages to the top bar.
 */
class MessageSubscriber implements EventSubscriberInterface
{
    /**
     * @var Security
     */
    protected $security;
    protected $commentRepository;

    public function __construct(Security $security, CommentRepository $commentRepository)
    {
        $this->security = $security;
        $this->commentRepository = $commentRepository;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            MessageListEvent::class => ['onMessages', 100],
        ];
    }

    public function onMessages(MessageListEvent $event)
    {
        $user = $this->security->getUser();
        $comments = [];
        if ($this->security->isGranted(['ROLE_ADMIN', 'ROLE_SUPER_ADMIN', 'ROLE_COACH'])) {
            $comments = [];
        } elseif ($this->security->isGranted(['ROLE_CUSTOMER'])) {
            $comments = $this->commentRepository->findBy(['sendTo' => $this->security->getUser()->getCustomer(),'status'=>false]);
        } elseif ($this->security->isGranted(['ROLE_USER'])) {
            $comments = $this->commentRepository->findBy(['sendTo' => $this->security->getUser()->getCustomeUser()->getCustomer(),'status'=>false]);
        }
        $userModel = new UserModel();
        $userModel2 = new UserModel();
        foreach ($comments as $comment) {
            $userModel->setName($comment->getEmployee()->getCompte() ? ($comment->getEmployee()->getCompte()->getUsername()) : 'anonymous');
            $userModel2->setName($comment->getSendTo()->getCompte() ? ($comment->getSendTo()->getCompte()->getUsername()) : 'anonymous');
            $message = new MessageModel($userModel, $comment->getLibelle(), $comment->getCreatedAt(), $userModel2);
            $message->setId($comment->getId());
            $event->addMessage($message);
        }

        /* $userModel = new UserModel();
         $userModel->setName($user ? $user->getUsername() : 'anonymous');*/
        // Fake a higher backend amount to test label
        // $event->setTotal(13);

        /* if (!$this->security->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
             $message = new MessageModel($userModel, 'Login to see more', new \DateTime('-2 days'));
             $message->setId(1);
             $event->addMessage($message);

             return;
         }

         $message = new MessageModel($userModel, 'You are awesome 💖', new \DateTime('-2 hours'));
         $message->setId(2);
         $event->addMessage($message);*/

        // Fake a higher backend amount to test label
        $event->setTotal(count($comments));
    }
}
