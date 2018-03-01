<?php

namespace Tequila\Bundle\SwaggerBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Tequila\Bundle\SwaggerBundle\DependencyInjection\TequilaSwaggerExtension;

class TequilaSwaggerBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new TequilaSwaggerExtension();
    }
}
