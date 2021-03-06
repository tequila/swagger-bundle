<?php

namespace Tequila\Bundle\SwaggerBundle\Generator;

class AnnotationsBasedGenerator implements SwaggerGeneratorInterface
{
    public function supports(array $payload): bool
    {
        return array_key_exists('annotations_path', $payload)
            && is_string($payload['annotations_path'])
            && is_readable($payload['annotations_path']);
    }

    public function generate(array $payload): array
    {
        $options = array_key_exists('annotations_scan_options', $payload)
            ? $payload['annotations_scan_options']
            : [];
        $swagger = \Swagger\scan($payload['annotations_path'], $options);

        return json_decode(json_encode($swagger), true);
    }
}
