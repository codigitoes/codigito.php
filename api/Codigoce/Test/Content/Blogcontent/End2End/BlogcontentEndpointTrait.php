<?php

declare(strict_types=1);

namespace Codigoce\Test\Content\Blogcontent\End2End;

trait BlogcontentEndpointTrait
{
    private string $ENDPOINT = '/api/admin/content/blogposts/{blogpost_id}/blogcontents';

    private function endpoint(
        string $blogpost_id,
        ?string $id = null,
        ?string $extraQuery = null
    ): string {
        $endpoint = str_replace('{blogpost_id}', $blogpost_id, $this->ENDPOINT);
        if (is_string($id)) {
            $endpoint = $endpoint.'/'.$id;
        }
        if (is_string($extraQuery)) {
            $endpoint = $endpoint.$extraQuery;
        }

        return $endpoint;
    }
}
