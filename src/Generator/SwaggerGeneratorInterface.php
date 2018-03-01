<?php

namespace Tequila\Bundle\SwaggerBundle\Generator;

interface SwaggerGeneratorInterface
{
    /**
     * @param array $payload
     *
     * @return bool Whether this generator supports Swagger generation from some resource.
     */
    public function supports(array $payload): bool;

    /**
     * @param array $payload
     *
     * @return array
     */
    public function generate(array $payload): array;
}
