<?php
return [
    'pluginVersion' => 'v4.0.0',
    'pluginName' => 'Bootstrap 4: A Zen Cart encapsulated template package.',
    'pluginDescription' => 'A responsive Zen Cart template built for <em>Zen Cart <b>v3.0.0</b></em> and PHP versions 8.0 through 8.5. The template uses Bootstrap 4.6.2 and Font Awesome 6.5.2.  Additional documentation is available on the template\'s <a href="https://github.com/lat9/ZCA-Bootstrap-Template" target="_blank" rel="noreferrer noopener">GitHub repository</a>.',
    'pluginAuthor' => 'Vinos de Frutas Tropicales (lat9)',
    'pluginId' => 0,
    'zcVersions' => [],
    'changelog' => '',
    'github_repo' => '',
    'pluginGroups' => [],
    'template' => [
        'key' => 'bootstrap4',
        'baseTemplate' => 'template_default',
        'isBootstrap' => true,
    ],
    'removesUnencapsulatedVersion' => true, // !empty presence indicates that non-encapsulated files are removed during install
];
