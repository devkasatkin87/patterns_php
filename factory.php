<?php 

abstract class ApptEncoder
{
    abstract public function encode();
}

class BloggsApptEncoder extends ApptEncoder
{
    public function encode()
    {
        return "Data encodes by BloggsCal \n";
    }
}

class MegaApptEncoder extends ApptEncoder
{
    public function encode()
    {
        return "Data encodes by MegaCal\n";
    }
}

abstract class CommsManager
{
    abstract function getHeader();
    abstract function getApptEncoder();
    abstract function getFooter();
}

class BloggsCommsManager extends CommsManager
{
    public function getHeader()
    {
        return "BloggsCal in Header\n";
    }
    
    public function getFooter()
    {
        return "BloggsCall in Footer\n";
    }
    
    public function getApptEncoder()
    {
        return new BloggsApptEncoder();
    }
}

class MegaCommsManager extends CommsManager
{
    public function getHeader()
    {
        return "MegaCal in Header\n";
    }
    
    public function getFooter()
    {
        return "MegaCal in Footer\n";
    }
    
    public function getApptEncoder()
    {
        return new MegaApptEncoder();
    }
}

$msgr = new BloggsCommsManager();
print $msgr->getHeader();
print $msgr->getApptEncoder()->encode();
print $msgr->getFooter();

$msgr2 = new MegaCommsManager();
print $msgr2->getHeader();
print $msgr2->getApptEncoder()->encode();
print $msgr2->getFooter();