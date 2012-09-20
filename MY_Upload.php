<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of multiple_upload
 *
 * @author Home
 */
class MY_Upload extends CI_Upload  {
    //put your code here
        /**
         *
         * @var string store the root path of upload folder
         */
        private $path;
        /**
         *  @var string stores the relative path
         */
        private $relativePath;
        /**
         *@var  string url 
         */
        private $baseUrl;
        /**
         * @var string stores the relativeUrl of a respected folder
         */
        private $relativeUrl;
        /**
         *
         * @var array  2D array of configuration of uploads
         */
        private $configuration ;
        
        public function __construct ($relUrl) {
            
            parent::__construct();
            
            $this->relativePath= 'uploads';
            $this->path= realpath(APPPATH . "../" . $this->relativePath );
            $this->configuration = array ();
            //setting the base url for this instance
            $this->baseUrl=  base_url(). "uploads/" . "{$relUrl[0]}" . "/";
            
            
            
            
        } //end of construct 
//-----------------------------------------------------------------------------
/**
 * do the uploads for mulitiple files
 * 
 * @param array $configs 2D array of multiple files upload configuration
 * @return mixed array of added files path on sucess otherwise false
 */
        public function do_uploads() 
    {   
         
        //store the filenames sucessfully uploaded
        $fileurls = array ();
        
        
        foreach ($_FILES as $key=>$file ) { 
            
            //set the upload preference
            $this->initialize($this->configuration[$key]);
            
             //upload successfull
            if ($this->do_upload($key)) {              
                $filename = $this->data();                
                $filenames[$key] =  $this->baseUrl.$filename['file_name'] ;                
            }//end of if
            //upload failed for at least one file
            else return false;
            
        }//end of foreach
       
        //uploading is succesfull for all the files
        return $filenames;
        
    }//end of do_uploads
    
    //--------------------------------------------------------------------------
    /**
     * set the configuration 
     * Merger 
     * 
     * @pram array $configs 2D array of configuration file
     * @param array $commonConfigs 1D array of common configuration file
     */
    public function configure ($configs , $commonConfigs = array ()) {
        
        //merging the common configuration with each configuration
        foreach ($configs as $key=>$config) {
            $this->configuration [$key] = array_merge ($config , $commonConfigs);
        }//end of for each
        
         //var_dump($this->configuration);
        
    }//end of configure
    
    
    
    //--------------------------------------------------------------------------  
     /**
     * Set the upload path
     * 
     * $param string path to destination folder
     *  
     * @return string $this->path return the path
     */
        
    public function update_path ($dir) {
        //check if dir is not empty
        
        if($dir)
            $this->path=realpath($this->path."/".$dir);       
        return $this->path;
    }//end of update_path
    
    //--------------------------------------------------------------------------
    
    
}//end of class path


