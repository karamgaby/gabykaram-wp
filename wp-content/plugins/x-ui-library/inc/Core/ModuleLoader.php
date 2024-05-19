<?php
namespace X_UI\Core;
class ModuleLoader {
  private $moduleRegistry = [];
  private $loadedModules = [];

  /**
   * @throws \JsonException
   */
  public function __construct() {
    $this->registerModulesFromDirectory(trailingslashit(X_UI_LIBRARY_PLUGIN_DIR_PATH) . 'modules');  // Assuming plugin's module directory
    $this->registerModulesFromDirectory(get_template_directory() . '/modules');    // Main theme modules

    // Check if there's a child theme and it's not the same as the parent
    if (get_stylesheet_directory() !== get_template_directory()) {
      $this->registerModulesFromDirectory(get_stylesheet_directory() . '/modules');  // Child theme modules
    }
  }

  private function registerModulesFromDirectory($directory) {
    foreach (glob($directory . '/*', GLOB_ONLYDIR) as $dir) {
      if (!str_contains($dir, '/_') && file_exists($dir . '/_.json')) {
        $metadata = json_decode(file_get_contents($dir . '/_.json'), true, 512, JSON_THROW_ON_ERROR);
        $moduleKey = $metadata['moduleKey'];

        // Check for conflicts
        if (isset($this->moduleRegistry[$moduleKey])) {
          throw new \Exception("Module conflict detected for key: {$moduleKey}");
        }

        $this->moduleRegistry[$moduleKey] = [
          'dir' => $dir,
          'dependencies' => $metadata['dependencies'] ?? []
        ];
      }
    }
  }

  public function loadModules() {
    foreach ($this->moduleRegistry as $moduleKey => $info) {
      $this->loadModule($moduleKey);
    }
  }

  private function loadModule($moduleKey, $currentPath = []) {
    if (in_array($moduleKey, $this->loadedModules)) {
      return;
    }

    if (in_array($moduleKey, $currentPath)) {
      throw new \Exception("Circular dependency detected: " . implode(' -> ', $currentPath) . " -> $moduleKey");
    }

    $moduleInfo = $this->moduleRegistry[$moduleKey] ?? null;
    if (!$moduleInfo) {
      throw new \Exception("Dependency not found: {$moduleKey}");
    }

    array_push($currentPath, $moduleKey);
    foreach ($moduleInfo['dependencies'] as $dependencyKey) {
      $this->loadModule($dependencyKey, $currentPath);
    }

    // Assuming _.json specifies files to load
    $this->requireModuleFiles($moduleInfo['dir']);
    $this->loadedModules[] = $moduleKey;
    array_pop($currentPath);
  }

  private function requireModuleFiles($moduleDir) {
    $parts = json_decode(file_get_contents($moduleDir . '/_.json'), true, 512, JSON_THROW_ON_ERROR);
    if (isset($parts['php'], $parts['php']['inc'])) {
      foreach ($parts['php']['inc'] as $file) {
        if (!strstr($file, '..')) {
          require_once $moduleDir . '/' . $file;
        }
      }
    }
  }
}
