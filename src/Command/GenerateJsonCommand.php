<?php

namespace Tequila\Bundle\SwaggerBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Tequila\Bundle\SwaggerBundle\Generator\GeneratorsChain;

class GenerateJsonCommand extends Command
{
    /**
     * @var GeneratorsChain
     */
    private $generator;

    /**
     * @var string
     */
    private $kernelRootDir;

    /**
     * @param GeneratorsChain $generator
     * @param string          $kernelRootDir
     * @param string|null     $name
     */
    public function __construct(GeneratorsChain $generator, string $kernelRootDir, string $name = null)
    {
        $this->generator = $generator;
        $this->kernelRootDir = $kernelRootDir;

        parent::__construct($name);
    }

    public function configure()
    {
        $this
            ->setName('tequila_swagger:generate:json')
            ->setDescription(
                'Generates Swagger json, based on Swagger annotations in your project.'
            )
            ->addUsage('bin/console tequila_swagger:generate:json > public/swagger.json')
            ->addOption(
                'path',
                null,
                InputOption::VALUE_REQUIRED,
                'Path to directory or file, from which to read annotations.',
                $this->kernelRootDir
            )
            ->addOption(
                'pretty-print',
                null,
                InputOption::VALUE_NONE,
                'Whether to pretty-print json or not.'
            );
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $path = $input->getOption('path');
        $prettyPrint = $input->getOption('json-pretty-print');

        $data = $this->generator->generateSwagger(['annotations_path' => $path]);

        $response = $prettyPrint
            ? json_encode($data, JSON_PRETTY_PRINT)
            : json_encode($data);

        $output->write($response.PHP_EOL);
    }
}
