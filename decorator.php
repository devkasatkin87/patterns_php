<?php

class RequestHelper{
    public function changeData()
    {
        return 1;
    }
}

abstract class ProcessRequest
{
    abstract public function process(RequestHelper $req);
}

class MainProcess extends ProcessRequest
{
    public function process(RequestHelper $req)
    {
        print $req->changeData().PHP_EOL;
        print __CLASS__ . ": выполнение запроса...\n";
    }
}

abstract class DecorateProcess extends ProcessRequest
{
    protected $processrequest;
    
    public function __construct(ProcessRequest $pr)
    {
        $this->processrequest = $pr;
    }
}

class LogRequest extends DecorateProcess
{
    public function process(RequestHelper $req)
    {
        print ($req->changeData()+1).PHP_EOL;
        print __CLASS__ . ": регистрация запроса...\n";
        $this->processrequest->process($req);
    }
}

class AuthentificateRequest extends DecorateProcess
{
    public function process(RequestHelper $req)
    {
        print ($req->changeData()+2).PHP_EOL;
        print __CLASS__ . ": аутентификация запроса...\n";
        $this->processrequest->process($req);
    }
}

class StructureRequest extends DecorateProcess
{
    public function process(RequestHelper $req)
    {
        print ($req->changeData()+5).PHP_EOL;
        print __CLASS__ . ": упорядочевание данных запроса...\n";
        $this->processrequest->process($req);
    }
}

$process = new AuthentificateRequest(new LogRequest (new MainProcess()));
//var_dump($process);
$process->process(new RequestHelper());