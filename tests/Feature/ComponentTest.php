<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ComponentTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProviderFormInputs')]
    public function form_inputs (string $component, string $expectedTag, string $expectedAttribute): void
    {
        $render = $this->withViewErrors([])->blade($component);

        $render->assertSee($expectedTag, false);
        $render->assertSee($expectedAttribute, false);
    }

    public static function dataProviderFormInputs(): array
    {
        return [
            // input
            'input' => ['<x-form.input/>', 'input', 'name=""'],
            'input with name' => ['<x-form.input name="hope"/>', 'input', 'name="hope"'],
            'input with id' => ['<x-form.input id="hope"/>', 'input', 'id="hope"'],
            'input with value' => ['<x-form.input value="hello"/>', 'input', 'value="hello"'],
            'input without id' => ['<x-form.input/>', 'input', 'id=""'],
            'input pass attributes' => ['<x-form.input x-model="hello"/>', 'input', 'x-model="hello"'],
            // textarea
            'textarea' => ['<x-form.textarea/>', 'textarea', 'name=""'],
            'textarea with name' => ['<x-form.textarea name="hope"/>', 'textarea', 'name="hope"'],
            'textarea with id' => ['<x-form.textarea id="hope"/>', 'textarea', 'id="hope"'],
            'textarea with value' => ['<x-form.textarea value="hello"/>', 'textarea', 'value="hello"'],
            'textarea without id' => ['<x-form.textarea/>', 'textarea', 'id=""'],
            'textarea pass attributes' => ['<x-form.textarea x-model="hello"/>', 'textarea', 'x-model="hello"'],
        ];
    }

    #[Test]
    #[DataProvider('dataProviderErrors')]
    public function in_case_the_error_we_show_message (string $name): void
    {
        $render = $this->withViewErrors([
            'name' => 'The name field is required.'
        ])->blade(sprintf('<x-form.%s name="name"/>', $name));

        $render->assertSee('The name field is required.');
    }

    public static function dataProviderErrors()
    {
        return [
            'input' => ['input'],
            'textarea' => ['textarea'],
        ];
    }

    #[Test]
    #[DataProvider('dataProviderSmokeTestForComponents')]
    public function smoke_test_for_components (string $bladeComponent, array $expectedToSee): void
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
            // Links buttons
            'link button primary' => ["<x-link.button-primary href=\"/link\">button</x-link.button-primary>", ['button', '/link']],
            'link button primary with attributes' => ["<x-link.button-primary wire:navigate href=\"/link\">button</x-link.button-primary>", ['wire:navigate']],
            'link button secondary' => ["<x-link.button-secondary href=\"/link\">button</x-link.button-secondary>", ['button', '/link']],
            'link button secondary with attributes' => ["<x-link.button-secondary wire:navigate href=\"/link\">button</x-link.button-secondary>", ['wire:navigate']],
            'link button tertiary' => ["<x-link.button-tertiary href=\"/link\">button</x-link.button-tertiary>", ['button', '/link']],
            'link button tertiary with attributes' => ["<x-link.button-tertiary wire:navigate href=\"/link\">button</x-link.button-tertiary>", ['wire:navigate']],
            // buttons
            'button primary' => ["<x-button.primary>button</x-button.primary>", ['button']],
            'button primary with attributes' => ["<x-button.primary wire:navigate>button</x-button.primary>", ['wire:navigate']],
            'button secondary' => ["<x-button.secondary>button</x-button.secondary>", ['button']],
            'button secondary with attributes' => ["<x-button.secondary wire:navigate>button</x-button.secondary>", ['wire:navigate']],
            'button tertiary' => ["<x-button.tertiary>button</x-button.tertiary>", ['button']],
            'button tertiary with attributes' => ["<x-button.tertiary wire:navigate>button</x-button.tertiary>", ['wire:navigate']],
            // card
            'card' => ['<x-card>card</x-card>', ['card']],
            'card with attributes' => ['<x-card wire:show="show">card</x-card>', ['card', 'wire:show']],
            // modal
            'modal' => ['<x-modal>modal</x-modal>', ['modal']],
            'modal with attributes' => ['<x-modal wire:show="show">card</x-modal>', ['modal', 'wire:show']],
            // Breadcrumbs
            'breadcrumb' => ['<x-breadcrumb>breadcrumb</x-breadcrumb>', ['breadcrumb']],
            'breadcrumb item' => ['<x-breadcrumb><x-breadcrumb.item router="bucket.overview">Item BreadCrumb</x-breadcrumb.item></x-breadcrumb>', ['Item BreadCrumb', '/bucket']],
            'breadcrumb separator' => ['<x-breadcrumb><x-breadcrumb.separator/></x-breadcrumb>', ['svg']],
            // Page Header
            'page header' => ['<x-page-header>page</x-page-header>', ['page']],
            'page header breadcrumb' => ['<x-page-header>page<x-slot:breadcrumb>breadcrumb</x-slot:breadcrumb><x-slot:actions>actions</x-slot:actions></x-page-header>', ['page', 'breadcrumb', 'actions']],
        ];
    }
}
