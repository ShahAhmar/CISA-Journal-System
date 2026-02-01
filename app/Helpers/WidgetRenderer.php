<?php

namespace App\Helpers;

use App\Models\Widget;
use App\Models\Submission;

class WidgetRenderer
{
    public static function render($widget)
    {
        if (is_array($widget)) {
            $type = $widget['type'] ?? 'text';
            $content = $widget['content'] ?? [];
        } else {
            $type = $widget->type;
            $content = $widget->content;
        }

        $method = 'render' . str_replace('_', '', ucwords($type, '_'));
        
        if (method_exists(self::class, $method)) {
            return self::$method($content);
        }

        return self::renderText($content);
    }

    protected static function renderHero($content)
    {
        $title = $content['title'] ?? 'Welcome';
        $subtitle = $content['subtitle'] ?? '';
        $buttonText = $content['buttonText'] ?? 'Get Started';
        $buttonLink = $content['buttonLink'] ?? '#';

        return view('widgets.hero', compact('title', 'subtitle', 'buttonText', 'buttonLink'))->render();
    }

    protected static function renderText($content)
    {
        $text = $content['content'] ?? $content ?? '';
        return view('widgets.text', compact('text'))->render();
    }

    protected static function renderLatestArticles($content)
    {
        $count = $content['count'] ?? 6;
        $showExcerpt = $content['showExcerpt'] ?? true;
        
        $articles = Submission::where('status', 'published')
            ->with(['journal', 'authors'])
            ->latest('published_at')
            ->take($count)
            ->get();

        return view('widgets.latest-articles', compact('articles', 'showExcerpt'))->render();
    }

    protected static function renderCallToAction($content)
    {
        $title = $content['title'] ?? 'Call to Action';
        $text = $content['text'] ?? '';
        $buttonText = $content['buttonText'] ?? 'Click Here';
        $buttonLink = $content['buttonLink'] ?? '#';

        return view('widgets.call-to-action', compact('title', 'text', 'buttonText', 'buttonLink'))->render();
    }

    protected static function renderStats($content)
    {
        $items = $content['items'] ?? [];
        return view('widgets.stats', compact('items'))->render();
    }
}

