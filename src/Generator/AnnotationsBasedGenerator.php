<?php

namespace Tequila\Bundle\SwaggerBundle\Generator;

class AnnotationsBasedGenerator implements SwaggerGeneratorInterface
{
    public function supports(array $payload): bool
    {
        return array_key_exists('annotations_path', $payload)
            && is_string($payload['path'])
            && is_readable($payload['path']);
    }

    public function generate(array $payload): array
    {
        $swagger = \Swagger\scan($payload['annotations_path']);
    }
}
