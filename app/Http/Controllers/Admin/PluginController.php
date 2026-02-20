<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\PluginManager;
use Illuminate\Http\Request;

class PluginController extends Controller
{
    protected $pluginManager;

    public function __construct(PluginManager $pluginManager)
    {
        $this->pluginManager = $pluginManager;
    }

    public function index()
    {
        $plugins = $this->pluginManager->getAll();
        
        return view('admin.plugins.index', [
            'plugins' => $plugins,
        ]);
    }

    public function install(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'version' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $config = [
            'name' => $request->name,
            'version' => $request->version,
            'description' => $request->description ?? '',
            'hooks' => [],
        ];

        $this->pluginManager->install($request->name, $config);

        return redirect()->route('admin.plugins.index')
            ->with('success', 'Plugin installed successfully!');
    }

    public function uninstall(string $name)
    {
        $this->pluginManager->uninstall($name);

        return redirect()->route('admin.plugins.index')
            ->with('success', 'Plugin uninstalled successfully!');
    }

    public function activate(string $name)
    {
        // Plugin activation logic
        return redirect()->route('admin.plugins.index')
            ->with('success', 'Plugin activated successfully!');
    }

    public function deactivate(string $name)
    {
        // Plugin deactivation logic
        return redirect()->route('admin.plugins.index')
            ->with('success', 'Plugin deactivated successfully!');
    }
}
