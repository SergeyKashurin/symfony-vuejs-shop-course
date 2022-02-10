<?php

namespace App\Utils\Mailer\Sender;

use App\Entity\Order;
use App\Utils\Mailer\DTO\MailerOptions;

class OrderCreatedFromCartEmailSender
{

    public function sendEmailToClient(Order $order)
    {
        $mailerOptions = (new MailerOptions())
            ->setRecipent($order->getOwner()->getEmail())
            ->setCc('manager@ranked-choice.com')
            ->setSubject('Ranked Choice Shop - Thank you for your purchase!')
            ->setHtmlTemplate('main/...')
            ->setContext([

            ]);
        dd('sendEmailToClient', $mailerOptions);
    }

    public function sendEmailToManager(Order $order)
    {

    }
}