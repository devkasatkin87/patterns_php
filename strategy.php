<?php

abstract class Response
{
    private $text;
    protected $method;
    
    public function __construct($text, Method $method)
    {
        $this->text = $text;
        $this->method = $method;
    }
    
    public function send()
    {
        print_r($this->text.PHP_EOL);
        print_r("Send message by {$this->method->getDescription()} method\n");
    }
}

class SmsResponse extends Response
{
    public function send()
    {
        parent::send();
        $this->method->engine();
        echo "SMS was sent\n";
        echo "----------------------------------\n";
    }
}

class EmailResponse extends Response
{
    public function send()
    {
       parent::send();
       $this->method->engine();
       echo "EMAIL was sent\n";
       echo "----------------------------------\n";
    }
}

abstract class Method
{
    private $description;
    
    public function __construct($description)
    {
        $this->description = $description;
    }
    
    public function getDescription()
    {
        return $this->description;
    }
    
    abstract public function engine();
}

class Sms extends Method
{
    public function engine()
    {
        print_r("Do some specific action for sms engine\n");
    }
}

class Email extends Method
{
    public function engine()
    {
        print_r("Do some specific action for email engine\n");
    }
}

$sentSms = new SmsResponse("Hello World", new SMS("SMS"));
$sentSms->send();
$sentEmail = new EmailResponse("Hello new WORLD", new Email("Email"));
$sentEmail->send();