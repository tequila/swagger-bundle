<?php

namespace Tequila\Bundle\SwaggerBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Tequila\Bundle\SwaggerBundle\Event\FilterDataEvent;
use Tequila\Bundle\SwaggerBundle\SwaggerEvents;

class FilterPathsSubscriber implements EventSubscriberInterface
{
    /**
     * @var string[]
     */
    private $pathPatterns = [];

    /**
     * @param array|string[] $pathPatterns
     */
    public function __construct(array $pathPatterns)
    {
        foreach ($pathPatterns as $pattern) {
            $this->pathPatterns[] = sprintf('#%s#ui', $pattern);
        }
    }

    public static function getSubscribedEvents()
    {
        return [SwaggerEvents::API_DOCS_GENERATED => 'onDocsGenerated'];
    }

    /**
     * @param FilterDataEvent $event
     */
    public function onDocsGenerated(FilterDataEvent $event): void
    {
        $data = $event->getData();
        $paths = $data['paths'] ?? [];

        foreach ($paths as $path => $methods) {
            foreach ($this->pathPatterns as $pattern) {
                if (preg_match($pattern, $path)) {
                    continue 2;
                }
            }

            // $path don't match any of the patterns, so we delete it from documentation
            unset($paths[$path]);
        }

        $data['paths'] = $paths;
    }
}
