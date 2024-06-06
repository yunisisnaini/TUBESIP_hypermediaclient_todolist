<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\URL;

class AddHypermediaLinks
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $content = json_decode($response->getContent(), true);

        if ($response->isSuccessful() && is_array($content)) {
            if (isset($content[0]) && is_array($content[0])) {
                foreach ($content as &$item) {
                    $this->addLinks($item, $request->path());
                }
            } else {
                $this->addLinks($content, $request->path());
            }

            $response->setContent(json_encode($content));
        }

        return $response;
    }

    private function addLinks(array &$item, $path)
    {
        if (isset($item['id'])) {
            $resource = str_contains($path, 'users') ? 'users' : 'todos';
            $item['_links'] = [
                'self' => app('url')->route("$resource.show", ['id' => $item['id']]),
                'update' => app('url')->route("$resource.update", ['id' => $item['id']]),
                'delete' => app('url')->route("$resource.destroy", ['id' => $item['id']]),
            ];
        }
    }


}
