<?php

// Include the super class file
//include_once( "kernel/classes/ezdatatype.php" );

// Define the name of datatype string
define( "EZ_DATATYPESTRING_WEATHER", "weather" );

class weathertype extends eZDataType
{
   	function __construct()
   	{
       	parent::__construct( EZ_DATATYPESTRING_WEATHER, "Weather", array( 'serialize_supported' => true ) );
   	}

   	function validateObjectAttributeHTTPInput( $http, $base, $contentObjectAttribute )
    {
        if ( $http->hasPostVariable( $base . '_city_' . $contentObjectAttribute->attribute( 'id' ) ) )
        {
            $ezweather =& $http->postVariable( $base . '_city_' . $contentObjectAttribute->attribute( 'id' ) );
            $classAttribute =& $contentObjectAttribute->contentClassAttribute();
            if ( $classAttribute->attribute( "is_required" ) == true )
            {
                if( empty($ezweather))
                {
                    $contentObjectAttribute->setValidationError( "please insert city" );
                    return EZ_INPUT_VALIDATOR_STATE_INVALID;
                }
            }
            return EZ_INPUT_VALIDATOR_STATE_ACCEPTED;
        }
        return EZ_INPUT_VALIDATOR_STATE_INVALID;
    }
    
   	function fetchObjectAttributeHTTPInput( $http, $base, $contentObjectAttribute )
  	{
        if( $http->hasPostVariable( $base . "_city_" . $contentObjectAttribute->attribute( "id" ) ) )
        {$city = $http->postVariable( $base . "_city_" . $contentObjectAttribute->attribute( "id" ) );}
        else
        {$city = null;}
        
        if( $http->hasPostVariable( $base . "_zip_" . $contentObjectAttribute->attribute( "id" ) ) )
        {$zip = $http->postVariable( $base . "_zip_" . $contentObjectAttribute->attribute( "id" ) );}
        else
        {$zip = null;}
        
        if( $http->hasPostVariable( $base . "_country_" . $contentObjectAttribute->attribute( "id" ) ) )
        {$country = $http->postVariable( $base . "_country_" . $contentObjectAttribute->attribute( "id" ) );}
        else
        {$country = null;}
        
        $content = array( "city" => $city, "zip" => $zip, "country" => $country );
        
        $imploded = implode(",", $content);
        
        $contentObjectAttribute->setContent( $imploded );
        $contentObjectAttribute->setAttribute( "data_text", $imploded );
        
        return true;
  	}
  	
  	
   	function storeObjectAttribute( $contentObjectattribute )
   	{
   	    return true;
   	}

   	function objectAttributeContent( $contentObjectAttribute )
    {
        include_once( "extension/weather/classes/meteotrentinoclass.php" );
        $string = $contentObjectAttribute->attribute( "data_text" );
        //eZDebug::writeNotice($string, __METHOD__);
        $weather = new Weather;
		
        $content = @$weather->request($string);
        if ( $content )
        {
            $exploded_adress = explode(",",$string);
            return array_merge($exploded_adress, $content);
        }
        eZDebug::writeWarning( 'No weather result for ' . $string, __METHOD__ );
        return false;
    }

    function metaData( $contentObjectAttribute )
    {
        return $contentObjectAttribute->attribute( "data_text" );
    }

   	function title( $contentObjectAttribute, $name = null )
   	{
       	return $contentObjectAttribute->attribute( "data_text" );
   	}
   	function isIndexable()
    {
        return true;
    }
}

eZDataType::register( EZ_DATATYPESTRING_WEATHER, "weathertype" );

?>
