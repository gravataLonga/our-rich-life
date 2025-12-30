<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ComponentTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProviderFormInputs')]
    public function form_inputs (string $component, string $expectedTag, string $expectedAttribute)
    {
        $render = $this->withViewErrors([])->blade($component);

        $render->assertSee($expectedTag, false);
        $render->assertSee($expectedAttribute, false);
    }

    public static function dataProviderFormInputs(): array
    {
        return [
            'input' => ['<x-form.input/>', 'input', 'name=""'],
            'input with name' => ['<x-form.input name="hope"/>', 'input', 'name="hope"'],
            'input with id' => ['<x-form.input id="hope"/>', 'input', 'id="hope"'],
            'input with value' => ['<x-form.input value="hello"/>', 'input', 'value="hello"'],
            'input without id' => ['<x-form.input/>', 'input', 'id=""'],
            'input pass attributes' => ['<x-form.input x-model="hello"/>', 'input', 'x-model="hello"'],
        ];
    }

    #[Test]
    public function in_case_the_error_we_show_message ()
    {
        $render = $this->withViewErrors([
            'name' => 'The name field is required.'
        ])->blade('<x-form.input name="name"/>');

        $render->assertSee('The name field is required.');
    }

    #[Test]
    #[DataProvider('dataProviderSmokeTestForComponents')]
    public function smoke_test_for_components (string $bladeComponent, array $expectedToSee)
    {
        $view = $this->blade($bladeComponent);

        foreach ($expectedToSee as $expected) {
            $view->assertSee($expected, true);
        }
    }

    public static function dataProviderSmokeTestForComponents(): array
    {
        return [
            'panel' => ["<x-card>Hello</x-card>", ['Hello']],
            'link button primary' => ["<x-link.button-primary href=\"/link\">button</x-link.button-primary>", ['button', '/link']],
            'link button primary with attributes' => ["<x-link.button-primary wire:navigate href=\"/link\">button</x-link.button-primary>", ['wire:navigate']],
            'link button secondary' => ["<x-link.button-secondary href=\"/link\">button</x-link.button-secondary>", ['button', '/link']],
            'link button secondary with attributes' => ["<x-link.button-secondary wire:navigate href=\"/link\">button</x-link.button-secondary>", ['wire:navigate']],
            'link button tertiary' => ["<x-link.button-tertiary href=\"/link\">button</x-link.button-tertiary>", ['button', '/link']],
            'link button tertiary with attributes' => ["<x-link.button-tertiary wire:navigate href=\"/link\">button</x-link.button-tertiary>", ['wire:navigate']],
        ];
    }
}
