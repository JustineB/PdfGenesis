<?php

namespace PdfGenesis\CoreBundle\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use PdfGenesis\CoreBundle\Event\UserBundleEvents;
use PdfGenesis\CoreBundle\Event\UserEvent;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


class UserSubscriber implements EventSubscriberInterface
{

    use ContainerAwareTrait;

    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public static function getSubscribedEvents()
    {
        return array(
            UserBundleEvents::SAVE_USER => 'save',
            UserBundleEvents::UPDATE_USER => array(
                array('sendEmail',10),
                array('save',0)
            ),
            UserBundleEvents::CLEAR_PICTURE => array(
                array('save',10),
                array('clear',0)
            ),
            UserBundleEvents::CONFIRMATION_EMAIL => array(
                array('confirmationEmail',10),
                array('save',0)
            ),
        );
    }


    /**
     * @param UserEvent $event
     */
    public function sendEmail(UserEvent $event){
        $user = $event->getData();

        $token = uniqid('tk_');

        $user->setEmailAvailable(0);
        $user->setEmailToken($token);

        $url =  $this->container->get('router')->generate('user_index') .'?token='. $token;

        $message = \Swift_Message::newInstance()
            ->setSubject('Modification d\'email')
            ->setFrom(array(  $this->container->getParameter('mailer_user') =>$this->container->getParameter('email_name_default')))
            ->setTo($user->getEmail())
            ->setBody(
                $this->container->get('twig')->render(
                    'PdfGenesisCoreBundle:Email:email_update.txt.twig',
                    array(
                        'confirmationUrl' => $url,
                        'user' => $user)
                )
            );

        $this->container->get('mailer')->send($message);

    }


    /**
     * @param UserEvent $event
     */
    public function save(UserEvent $event){
        $user = $event->getData();

        $this->em->persist($user);
        $this->em->flush();
    }

    /**
     * @param UserEvent $event
     */
    public function confirmationEmail(UserEvent $event){
        $user = $event->getData();

        $user->setEmailAvailable(1);
        $user->setEmailToken(null);
    }

    /**
     * @param UserEvent $event
     */
    public function clear(UserEvent $event){
            $user = $event->getData();

            if($user->getPath() != null && $user->getFile() != null) {
                $fichier = array('path_picture' => $user->getPath());

                $this->container->get('pdf_genesis.file_updater')->deleteFile($fichier);

                $user->setPath(null);
                $user->setFile(null);
            }
    }

}