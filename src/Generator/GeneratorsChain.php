<?php

namespace Tequila\Bundle\SwaggerBundle\Generator;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Tequila\Bundle\SwaggerBundle\Event\FilterDataEvent;
use Tequila\Bundle\SwaggerBundle\SwaggerEvents;

class GeneratorsChain
{
    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * @var iterable|SwaggerGeneratorInterface[]
     */
    private $generators;

    /**
     * @param EventDispatcherInterface             $dispatcher
     * @param iterable|SwaggerGeneratorInterface[] $generators
     */
    public function __construct(EventDispatcherInterface $dispatcher, iterable $generators)
    {
        $this->dispatcher = $dispatcher;
        $this->generators = $generators;
    }

    /**
     * @param array $payload
     *
     * @return array The generated Swagger config
     */
    public function generateSwagger(array $payload): array
    {
        foreach ($this->generators as $generator) {
            if (!$generator instanceof SwaggerGeneratorInterface) {
                throw new \InvalidArgumentException(
                    sprintf(
                        'Each generator must be an instance of "%s", "%s" given.',
                        SwaggerGeneratorInterface::class,
                        is_object($generator) ? get_class($generator) : gettype($generator)
                    )
                );
            }

            if ($generator->supports($payload)) {
                $data = $generator->generate($payload);
                $event = new FilterDataEvent($data);
                $this->dispatcher->dispatch(SwaggerEvents::API_DOCS_GENERATED, $event);

                return $event->getData();
            }
        }

        throw new \RuntimeException(
            'There is no generators, supporting Swagger generation for this payload.'
        );
    }
}
