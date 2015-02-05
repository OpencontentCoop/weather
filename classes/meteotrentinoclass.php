<?php


class Weather
{
    public $ini;
    public $url;
    public $xml;
    public $requestData;
    public $days = array();
    public $available_attributes = array();
    public $cacheFile;
    public $cacheFileName;
    public $cacheFileDir;
    
    function __construct() 
    {
        $this->ini = eZINI::instance( "weather.ini" );                          
        $this->url = $this->ini->variable( "Settings", "RequestURL" );
        
        $this->days = array('Oggi', 'Domani', 'DopoDomani', 'GiorniSuccessivi');
        $this->available_attributes = array('Data', 'CieloDesc', 'iconaS', 'desciconaS', 'iconaS12', 'desciconaS12','TempMaxValle', 'TempMinValle', 'PrecipProb');
        $this->cacheFileDir = rtrim( eZExtension::baseDirectory(), '/' ) . '/weather/data';
        $this->cacheFileName = 'data.xml';
        $this->cacheFile = $this->cacheFileDir . '/' . $this->cacheFileName;        
    }
    
    function cacheData()
    {        
        $cacheFileHandler = eZClusterFileHandler::instance( $this->cacheFile );
        if ( !$cacheFileHandler->exists() )
        {
            eZFile::create( $this->cacheFileName, $this->cacheFileDir );
        }
        $xml = (string) OpenPABase::getDataByURL( $this->url );
        if ( md5( $xml ) != md5( $cacheFileHandler->fetchContents() ) )
        {
            $cacheFileHandler->storeContents( $xml );
            return true;
        }
        return false;
    }
    
    function getData()
    {
        $cacheFileHandler = eZClusterFileHandler::instance( $this->cacheFile );
        return $cacheFileHandler->fetchContents();
    }
    
    function request( $address )
    {        
        if ( $address )
        {
            //@todo parse request data
            $this->requestData = $address;
            //eZDebug::writeDebug( $this->requestData, 'Weather request data');               
        }
        
        $this->xml = $this->getData();                
        
        if( !empty( $this->xml) )
        {
            $xmldom = new DOMDocument( '1.0', 'utf-8' );
            $xmldom->loadXML( $this->xml );
            $data = array();
            foreach ($this->days as $day)
            {
                $xml_days = $xmldom->getElementsByTagName( $day );
                foreach ($xml_days as $xml_day)
                {                                        
                    foreach ( $this->available_attributes as $attribute )
                    {
                        $xml_attribute = $xml_day->getElementsByTagName( $attribute );                        
                        if ( is_object( $xml_attribute ) && is_object( $xml_attribute->item(0) ) )
                        {
                            $data[$day][$attribute] = $xml_attribute->item(0)->nodeValue;
                        }
                    }
                }
            }
            //eZDebug::writeDebug( $data, 'Weather data');
            return $data;
        }
        else
        {
            eZDebug::writeDebug( "No data in {$this->url}", 'Weather error');
            return false;
        }
        
    }
}
?>
