<?php

namespace PdfGenesis\CoreBundle\Util;


use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\HttpFoundation\File\File;

class FileUpdater{

    use ContainerAwareTrait;


    public function updateFile($file, $file_object, $extension_name = null){

        $fileName = $file;

        if($file instanceof File){
            $fileNameExtension = $file->guessExtension();
            $fileName = md5(uniqid()).'.'. $fileNameExtension;

        }

        $base = $this->container->getParameter('files_directory'). $extension_name;
        $path = $base . $fileName;

        if($file instanceof File){
            $file->move( $base, $fileName );
        }

        $file_object->setFile($fileName);
        $file_object->setPath($path);

        return $file_object;
    }

    public function deleteFile($fichiers){

        foreach($fichiers as $fichier){
            if( file_exists ( $fichier))
                unlink( $fichier ) ;
        }

    }
}