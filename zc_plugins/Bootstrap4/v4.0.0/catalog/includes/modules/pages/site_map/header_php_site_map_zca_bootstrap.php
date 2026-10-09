<?php
// -----
// site_map: Update the site-map array, adding classes to the parent/child entries.
//
// Last updated: BOOTSTRAP v4.0.0
//
use Zencart\DbRepositories\PluginControlRepository;
use Zencart\DbRepositories\PluginControlVersionRepository;
use Zencart\PluginManager\PluginManager;

if (function_exists('is_bootstrap_template') && is_bootstrap_template()) {
    $plugin_manager = new PluginManager(new PluginControlRepository($db), new PluginControlVersionRepository($db));
    $bootstrapPluginDir = $plugin_manager->getPluginVersionDirectory('Bootstrap4', $plugin_manager->getInstalledPlugins()) . 'catalog/';
    require $bootstrapPluginDir . DIR_WS_CLASSES . 'zca/zca_site_map.php';
    $zen_SiteMapTree = new zca_SiteMapTree;
    $zen_SiteMapTree->setParentStartEndStrings('<ul class="list-group">');
    $zen_SiteMapTree->setChildStartString('<li class="list-group-item">');
}
