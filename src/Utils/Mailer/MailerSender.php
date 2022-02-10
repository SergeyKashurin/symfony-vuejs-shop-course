<?php

namespace App\Utils\Mailer;

use App\Utils\Mailer\DTO\MailerOptions;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

class MailerSender
{
    /**
     * @var MailerInterface
     */
    private MailerInterface $mailer;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @param MailerInterface $mailer
     * @param LoggerInterface $logger
     */
    public function __construct(MailerInterface $mailer, LoggerInterface $logger)
    {
        $this->mailer = $mailer;
        $this->logger = $logger;
    }

    /**
     * @param MailerOptions $mailerOptions
     */
    public function sendTemplatedEmail(MailerOptions $mailerOptions)
    {
        $email = (new TemplatedEmail())
            ->to($mailerOptions->getRecipent())
            ->subject($mailerOptions->getSubject())
            ->htmlTemplate($mailerOptions->getHtmlTemplate())
            ->context($mailerOptions->getContext());

        if($mailerOptions->getCc()) {
            $email->cc($mailerOptions->getCc());
        }

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $exception) {
            $this->logger->critical($mailerOptions->getSubject(), [
                'errorText' => $exception->getTraceAsString(),
            ]);

            $systemMailerOptions = new MailerOptions();
            $systemMailerOptions->setText($exception->getTraceAsString());

            $this->sendTemplatedEmail($systemMailerOptions);
        }
        return $email;
    }

    /**
     * @param MailerOptions $mailerOptions
     */
    private function sendSystemEmail(MailerOptions $mailerOptions)
    {
        $mailerOptions->setSubject('[Exception] An error occurred while sending the letter.');
        $mailerOptions->setRecipent('admin@ranked-choice.com');

        $email = (new TemplatedEmail())
            ->to($mailerOptions->getRecipent())
            ->subject($mailerOptions->getSubject())
            ->text($mailerOptions->getText());

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $exception) {
            $this->logger->critical($mailerOptions->getSubject(), [
                'errorText' => $exception->getTraceAsString(),
            ]);
        }
    }
}