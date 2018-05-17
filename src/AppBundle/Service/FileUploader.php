<?php

namespace AppBundle\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader {
    
    private $targetDir;
    
    public function __construct($targetDir) {
        
        $this->targetDir = $targetDir;
    }
    
    public function upload(UploadedFile $file) {
        
        $fileName = $this->generateUniquePictureName().'.'.$file->guessExtension();
        
        $file->move(
            $this->getTargetDir(),
            $fileName
        );
        
        return $fileName;
    }
    
    public function getTargetDir() {
        
        return $this->targetDir;
    }
    
    /**
     * @return string
     */
    private function generateUniquePictureName() {
        
        return md5(uniqid());
    }
}
