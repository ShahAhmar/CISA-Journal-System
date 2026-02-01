<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;

class PluginManager
{
    protected $plugins = [];
    protected $pluginsPath;
    
    public function __construct()
    {
        $this->pluginsPath = storage_path('plugins');
        
        if (!File::exists($this->pluginsPath)) {
            File::makeDirectory($this->pluginsPath, 0755, true);
        }
        
        $this->loadPlugins();
    }
    
    /**
     * Load all installed plugins
     */
    public function loadPlugins()
    {
        $plugins = Cache::remember('plugins_list', 3600, function () {
            $plugins = [];
            $pluginDirs = File::directories($this->pluginsPath);
            
            foreach ($pluginDirs as $dir) {
                $pluginFile = $dir . '/plugin.php';
                if (File::exists($pluginFile)) {
                    $plugin = require $pluginFile;
                    if (isset($plugin['name'], $plugin['version'])) {
                        $plugins[$plugin['name']] = $plugin;
                    }
                }
            }
            
            return $plugins;
        });
        
        $this->plugins = $plugins;
    }
    
    /**
     * Get all plugins
     */
    public function getAll()
    {
        return $this->plugins;
    }
    
    /**
     * Get plugin by name
     */
    public function get(string $name)
    {
        return $this->plugins[$name] ?? null;
    }
    
    /**
     * Check if plugin is installed
     */
    public function isInstalled(string $name): bool
    {
        return isset($this->plugins[$name]);
    }
    
    /**
     * Install plugin
     */
    public function install(string $name, array $config)
    {
        // Plugin installation logic
        $pluginPath = $this->pluginsPath . '/' . $name;
        File::makeDirectory($pluginPath, 0755, true);
        
        // Save plugin config
        File::put($pluginPath . '/plugin.php', "<?php\nreturn " . var_export($config, true) . ";");
        
        Cache::forget('plugins_list');
        $this->loadPlugins();
    }
    
    /**
     * Uninstall plugin
     */
    public function uninstall(string $name)
    {
        $pluginPath = $this->pluginsPath . '/' . $name;
        if (File::exists($pluginPath)) {
            File::deleteDirectory($pluginPath);
        }
        
        Cache::forget('plugins_list');
        $this->loadPlugins();
    }
    
    /**
     * Call plugin hook
     */
    public function callHook(string $hook, ...$args)
    {
        foreach ($this->plugins as $plugin) {
            if (isset($plugin['hooks'][$hook]) && is_callable($plugin['hooks'][$hook])) {
                call_user_func_array($plugin['hooks'][$hook], $args);
            }
        }
    }
}

