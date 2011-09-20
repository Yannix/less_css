<?php

/*!
  \class   SimpleLessCssOperator simplelesscssoperator.php
  \ingroup eZTemplateOperators
  \brief   Implementation of LESS (a dynamic stylesheet language, http://lesscss.org/)  for eZ Publish based on lessphp lib
  \version 0.1 beta
  \author  Yannick Komotir <ykomotir@gmail.com>

  

  Example:
\code
{lesscss("mycss.css")}
\endcode
*/



class SimpleLessCssOperator
{

    function SimpleLessCssOperator()
    {
    }

    /*!
     \return an array with the template operator name.
    */
    function operatorList()
    {
        return array( 'lesscss' );
    }

    /*!
     \return true to tell the template engine that the parameter list exists per operator type,
             this is needed for operator classes that have multiple operators.
    */
    function namedParameterPerOperator()
    {
        return true;
    }

    /*!
     See eZTemplateOperator::namedParameterList
    */
    function namedParameterList()
    {
        return array( 'lesscss' => array( 'cssFileName' => array( 'type' => 'string',
                                                                  'required' => true ) ) );
    }


    function modify( $tpl, $operatorName, $operatorParameters, $rootNamespace, $currentNamespace, &$operatorValue, $namedParameters, $placement )
    {
        switch ( $operatorName )
        {
            case 'lesscss':
            {
                $operatorValue = self::lessify( $namedParameters['cssFileName'] );
            } break;
        }
    }
    
    
    static function lessify( $cssFile )
    {
       
        $cssFile = "stylesheets/" . $cssFile;
        
        $triedArray = array();
        
        $match = eZTemplateDesignResource::fileMatch( eZTemplateDesignResource::allDesignBases(), '', $cssFile, $triedArray );
        
        if( !$match )
        {
            return;
        }
        
        $cssFile = $match['path'];

        if( !file_exists( $cssFile ) )
        {
            eZDebug::writeWarning( "The file $cssFile doesn't exist" );
            return;
        }
        
        $cacheFileInfos = pathinfo( $cssFile );
        $cacheFileName = $cacheFileInfos['filename'] . self::$suffixeCacheFileName . '.' . $cacheFileInfos['extension'];
        
        if( self::eZJSCoreExist() === true )
        {
            $cachePathFile =  ezjscPacker::getCacheDir() . 'stylesheet/' . $cacheFileName;
        }
        else
        {
           $cachePathFile =  eZSys::instance()->cacheDirectory() . '/public/stylesheet/' . $cacheFileName; 
        }
        
        $clusterFileHandlerInstance = eZClusterFileHandler::instance(  $cachePathFile );
        
        if( file_exists( $cachePathFile ) )
        {
           $filemodifiedTime = filemtime( $cssFile ); 
           $cacheFilemodifiedTime = filemtime( $cachePathFile ); 
           
           if( $filemodifiedTime < $cacheFilemodifiedTime )
           {
                return self::generateCSSTag( $cachePathFile );
           }
        }
        
        //call the less compiler
        try
        {
            //lessc::ccompile( $cssFile, $cachePathFile );
            $lessc = new lessc( $cssFile );
            
            //disable @import statement not supported yet
            $lessc->importDisabled = true;
            $content = $lessc->parse();

            $clusterFileHandlerInstance->fileStoreContents( $cachePathFile, $content );
        } 
        catch( exception $exception )
        {
                eZDebug::writeWarning( "LessCompiler fatal error: $file", $exception->getMessage() );
                return;
        }
        
        return self::generateCSSTag( $cachePathFile );
    }
        
    /**
     * static method use to build the link tag in current html
     *
     * @param string $pathToFile the path of compiled css
     * @return string
     * 
     */
     
    static function generateCSSTag( $pathToFile )
    {
        if( self::eZJSCoreExist() === true )
        {
            return ezjscPacker::buildStylesheetTag( $pathToFile );
        }
        else
        {
            $completePath  = eZSys::instance()->wwwDir() . '/' .$pathToFile;
            return "<link rel=\"stylesheet\" type=\"text/css\" href=\"$linkToFile\" media=\"all\" />\r\n";
        } 
    }
    
    /**
     * Static Method to check if eZJSCore extension is present
     *
     * @param void
     * @return bool
     * 
     */
     
    static function eZJSCoreExist()
    {
        if( in_array( 'ezjscore', eZExtension::activeExtensions()  ) )
        {
            return true;
        }
        
        return false;
    }
    
    /**
     * property use to store a suffic for file to cache
     */
    static $suffixeCacheFileName = '__lesscss__';
    
}

?>
