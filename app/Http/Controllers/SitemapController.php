<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Project;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $now = now()->toIso8601String();

        $static = [
            ['loc' => route('home'), 'changefreq' => 'weekly', 'priority' => '1.0'],
            ['loc' => route('about'), 'changefreq' => 'monthly', 'priority' => '0.7'],
            ['loc' => route('services'), 'changefreq' => 'monthly', 'priority' => '0.7'],
            ['loc' => route('projects.index'), 'changefreq' => 'weekly', 'priority' => '0.9'],
            ['loc' => route('projects.finished'), 'changefreq' => 'weekly', 'priority' => '0.7'],
            ['loc' => route('projects.under_construction'), 'changefreq' => 'weekly', 'priority' => '0.6'],
            ['loc' => route('contact'), 'changefreq' => 'monthly', 'priority' => '0.6'],
            ['loc' => route('blog.index'), 'changefreq' => 'weekly', 'priority' => '0.65'],
        ];

        $projects = Project::query()
            ->select(['slug', 'updated_at'])
            ->orderByDesc('updated_at')
            ->get();

        $blogs = Blog::query()
            ->published()
            ->select(['slug', 'updated_at'])
            ->orderByDesc('updated_at')
            ->get();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

        foreach ($static as $u) {
            $xml .= "  <url>\n";
            $xml .= '    <loc>'.htmlspecialchars($u['loc'], ENT_XML1).'</loc>'."\n";
            $xml .= '    <lastmod>'.$now.'</lastmod>'."\n";
            $xml .= '    <changefreq>'.$u['changefreq'].'</changefreq>'."\n";
            $xml .= '    <priority>'.$u['priority'].'</priority>'."\n";
            $xml .= "  </url>\n";
        }

        foreach ($projects as $p) {
            $xml .= "  <url>\n";
            $xml .= '    <loc>'.htmlspecialchars(route('projects.show', ['slug' => $p->slug]), ENT_XML1).'</loc>'."\n";
            $xml .= '    <lastmod>'.($p->updated_at ? $p->updated_at->toIso8601String() : $now).'</lastmod>'."\n";
            $xml .= "    <changefreq>monthly</changefreq>\n";
            $xml .= "    <priority>0.8</priority>\n";
            $xml .= "  </url>\n";
        }

        foreach ($blogs as $b) {
            $xml .= "  <url>\n";
            $xml .= '    <loc>'.htmlspecialchars(route('blog.show', ['slug' => $b->slug]), ENT_XML1).'</loc>'."\n";
            $xml .= '    <lastmod>'.($b->updated_at ? $b->updated_at->toIso8601String() : $now).'</lastmod>'."\n";
            $xml .= "    <changefreq>monthly</changefreq>\n";
            $xml .= "    <priority>0.55</priority>\n";
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>'."\n";

        return response($xml, 200)
            ->header('Content-Type', 'application/xml; charset=UTF-8')
            ->header('Cache-Control', 'public, max-age=900');
    }
}
