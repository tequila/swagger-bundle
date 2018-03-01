<?php

namespace Tequila\Bundle\SwaggerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Tequila\Bundle\SwaggerBundle\Generator\GeneratorsChain;

class DocsUiController extends Controller
{
    /**
     * @var string
     */
    private $kernelRootDir;

    /**
     * @param string $kernelRootDir
     */
    public function __construct(string $kernelRootDir)
    {
        $this->kernelRootDir = $kernelRootDir;
    }

    /**
     * @param GeneratorsChain $generator
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function renderDocs(GeneratorsChain $generator)
    {
        $spec = $generator->generateSwagger([
            'annotations_path' => $this->kernelRootDir,
        ]);

        return $this->render(
            '@TequilaSwagger/DocsUi/index.html.twig',
            [
                'spec' => json_encode($spec),
            ]
        );
    }
}