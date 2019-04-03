<?php

interface Encoder
{
    public function encode();
}

abstract class ApptEncode implements Encoder
{
    abstract public function encode();
}

abstract class ContactEncode implements Encoder
{
    abstract public function encode();
}

abstract class TtdEncode implements Encoder
{
    abstract public function encode();
}

abstract class CommsManager
{
    abstract function getHeader();
    abstract function getApptEncode();
    abstract function getContactEncode();
    abstract function getTtdEncode();
    abstract function getFooter();
}

class BloggsApptEncoder extends ApptEncode
{
    public function encode()
    {
        return "Appointment has encoded by BloogsCal\n";        
    }
}

class MegaApptEncoder extends ApptEncode
{
    public function encode()
    {
        return "Appointment has encoded by MegaCal\n";        
    }
}

class BloggsContactEncoder extends ContactEncode
{
    public function encode()
    {
        return "Contacts has encoded by BloogsCal\n";        
    }
}

class MegaContactEncoder extends ContactEncode
{
    public function encode()
    {
        return "Contacts has encoded by MegaCal\n";        
    }
}

class BloggsTtdEncoder extends TtdEncode
{
    public function encode()
    {
        return "To do has encoded by BloogsCal\n";        
    }
}

class MegaTtdEncoder extends TtdEncode
{
    public function encode()
    {
        return "To do has encoded by MegaCal\n";        
    }
}

class BlogsCommsManager extends CommsManager
{
    public function getHeader()
    {
        return "BloggsCal in Header\n";
    }
    
    public function getFooter()
    {
        return "BloggsCall in Footer\n";
    }
    
    public function getApptEncode()
    {
        return new BloggsApptEncoder();
    }
    
    public function getContactEncode()
    {
        return new BloggsContactEncoder();
    }
    
    public function getTtdEncode()
    {
        return new BloggsTtdEncoder();
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
    
    public function getApptEncode()
    {
        return new MegaApptEncoder();
    }
    
    public function getContactEncode()
    {
        return new MegaContactEncoder();
    }
    
    public function getTtdEncode()
    {
        return new MegaTtdEncoder();
    }
}
print "Technology #1\n";
$msgr = new BlogsCommsManager();
print $msgr->getHeader();
print $msgr->getApptEncode()->encode();
print $msgr->getContactEncode()->encode();
print $msgr->getTtdEncode()->encode();
print $msgr->getFooter();
print "\n\nTechnology #2\n";
$msgr2 = new MegaCommsManager();
print $msgr2->getHeader();
print $msgr2->getApptEncode()->encode();
print $msgr2->getContactEncode()->encode();
print $msgr2->getTtdEncode()->encode();
print $msgr2->getFooter();
