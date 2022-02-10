<?php

namespace App\Utils\Mailer\DTO;

class MailerOptions
{

    /**
     * @var string
     */
    private $recipent;

    /**
     * @var string
     */
    private $cc;

    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
     */
    private $htmlTemplate;

    /**
     * @var array
     */
    private $context;

    /**
     * @var string
     */
    private $text;

    /**
     * @return string
     */
    public function getRecipent(): string
    {
        return $this->recipent;
    }

    /**
     * @param string $recipent
     */
    public function setRecipent(string $recipent): MailerOptions
    {
        $this->recipent = $recipent;
        return $this;
    }

    /**
     * @return string
     */
    public function getCc(): string
    {
        return $this->cc;
    }

    /**
     * @param string $cc
     */
    public function setCc(string $cc): MailerOptions
    {
        $this->cc = $cc;
        return $this;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject(string $subject): MailerOptions
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * @return string
     */
    public function getHtmlTemplate(): string
    {
        return $this->htmlTemplate;
    }

    /**
     * @param string $htmlTemplate
     */
    public function setHtmlTemplate(string $htmlTemplate): MailerOptions
    {
        $this->htmlTemplate = $htmlTemplate;
        return $this;
    }

    /**
     * @return array
     */
    public function getContext(): array
    {
        return $this->context;
    }

    /**
     * @param array $context
     */
    public function setContext(array $context): MailerOptions
    {
        $this->context = $context;
        return $this;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): MailerOptions
    {
        $this->text = $text;
        return $this;
    }



}