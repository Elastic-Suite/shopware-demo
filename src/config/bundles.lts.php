<?php

// Same as bundles.php, minus bundles whose packages aren't part of the 6.6 (LTS) dependency
// tree (see composer.lts.json): TwigComponentBundle and McpBundle were added for 6.7.
return [
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => ['all' => true],
    Shopware\Core\Framework\Framework::class => ['all' => true],
    Shopware\Core\System\System::class => ['all' => true],
    Shopware\Core\Content\Content::class => ['all' => true],
    Shopware\Core\Checkout\Checkout::class => ['all' => true],
    Shopware\Core\Maintenance\Maintenance::class => ['all' => true],
    Shopware\Core\DevOps\DevOps::class => ['e2e' => true],
    Shopware\Core\Profiling\Profiling::class => ['all' => true],
    Shopware\Core\Service\Service::class => ['all' => true],
    Symfony\Bundle\TwigBundle\TwigBundle::class => ['all' => true],
    Symfony\Bundle\MonologBundle\MonologBundle::class => ['all' => true],
    Symfony\Bundle\DebugBundle\DebugBundle::class => ['dev' => true],
    Pentatrion\ViteBundle\PentatrionViteBundle::class => ['all' => true],
    Shopware\Administration\Administration::class => ['all' => true],
    Shopware\Elasticsearch\Elasticsearch::class => ['all' => true],
    Shopware\Storefront\Storefront::class => ['all' => true],
];
