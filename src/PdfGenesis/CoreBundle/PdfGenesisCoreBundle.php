<?php

namespace PdfGenesis\CoreBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class PdfGenesisCoreBundle extends Bundle
{

    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
