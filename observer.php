<?php

class Login implements SplSubject
{
    private $storage;
    private $status;
    
    const LOGIN_USER_UNKNOWN = 1 ;
    const LOGIN_WRONG_PASS = 2 ;
    const LOGIN_ACCESS = 3 ;
    
    public function __construct()
    {
        $this->storage = new SplObjectStorage();
    }
    
    public function attach(SplObserver $observer)
    {
        $this->storage->attach($observer);
    }
    
    public function detach(SplObserver $observer)
    {
        $this->storage->detach($observer);
    }
    
    public function notify()
    {
        foreach($this->storage as $obs){
            $obs->update($this);
        }
    }
    
    public function setStatus($status, $user, $ip)
    {
        $this->status = $status;
        
        if ($this->status == self::LOGIN_ACCESS){
            print "Access granted for {$user} from {$ip}\n";
        }
        if ($this->status == self:: LOGIN_WRONG_PASS){
            print "Access denied for {$user} from {$ip}. Wrong password!\n";
        }
        if ($this->status == self:: LOGIN_USER_UNKNOWN){
            print "Access denied for {$user} from {$ip}. Unknown user!\n";
        }
        
    }
    
    public function getStatus()
    {
        return $this->status;
    }
    
    public function handleLogin($user, $pass, $ip)
    {
        $isvalid = false;
        switch(rand(1,3)){
            case 1:
                $this->setStatus(self::LOGIN_ACCESS, $user, $ip);
                $isvalid = true;
                break;
            case 2:
                $this->setStatus(self::LOGIN_WRONG_PASS, $user, $ip);
                $isvalid = false;
                break;
            case 3:
                $this->setStatus(self::LOGIN_USER_UNKNOWN, $user, $ip);
                $isvalid = false;
                break;
        }
        $this->notify();
        return $isvalid;
    }
}

abstract class LoginObserver implements SplObserver
{
    private $login;
    
    public function __construct(Login $login)
    {
        $this->login = $login;
        $login->attach($this);
    }
    
    public function update(SplSubject $subject)
    {
        if ($subject == $this->login){
            $this->doUpdate($subject);
        }
    }
    
    abstract public function doUpdate(Login $login);
}

class SecurityMonitor extends LoginObserver
{
    public function doUpdate(Login $login)
    {
        $status = $login->getStatus();
        if ($status == Login::LOGIN_WRONG_PASS){
            print __CLASS__.":\tSend message to sysadmin\n";
        }
    }
}

class GeneralLogger extends LoginObserver
{
    public function doUpdate(Login $login)
    {
        $status = $login->getStatus();
        print __CLASS__.":\tRegistering in log's - {$status}\n";
    }
}

class PartnershipTools extends LoginObserver
{
    public function doUpdate(Login $login)
    {
        $status = $login->getStatus();
        print __CLASS__.":\tSending COOKIES...\n";
    }
}

$login = new Login();
new SecurityMonitor($login);
new GeneralLogger($login);
new PartnershipTools($login);
$login->handleLogin("user", "123", "192.168.10.10");

