<?php

declare(strict_types=1);

namespace OurRichLife\Boost\Tools;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;
use Laravel\Mcp\Server\Tools\Annotations\IsReadOnly;

#[IsReadOnly]
class DeveloperInformation extends Tool
{
    protected string $description = 'Get information about the developer by name';

    public function schema(JsonSchema $schema): array
    {
        return [
            'name' => $schema
                ->string()
                ->description('get information about the developer by name')
                ->required(),
        ];
    }

    public function handle(Request $request): Response
    {
        return Response::json([
            'name' => $request->get('name'),
            'value' => 'Is a developer well capable.',
        ]);
    }
}
