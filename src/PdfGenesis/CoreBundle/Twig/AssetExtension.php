<?php

namespace PdfGenesis\CoreBundle\Twig;

use Symfony\Component\HttpFoundation\File\File;
use Twig_Extension;

class AssetExtension extends Twig_Extension
{
        public function getFunctions(){

            return array(
              'image64' => new \Twig_Function_Method($this, 'image64')
            );
        }

        public function image64($path){

            $file = new File($path, false);

            if( !$file->isFile() || 0 !== strpos($file->getMimeType(),'image/')){
                return;
            }

            $binary = file_get_contents($path);

            return sprintf('data:image/%s;base64,%s', $file->getExtension(), base64_encode($binary));
        }

        public function getName(){
            return 'pdfgenesis_asset';
        }

}