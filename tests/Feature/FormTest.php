<?php

namespace Tests\Feature;

use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;
use Illuminate\Support\ViewErrorBag;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FormTest extends TestCase
{
    #[Test]
    #[DataProvider('dataProviderGenerateBasicForm')]
    public function generate_basic_form (string $component, string $expectedTag, string $expectedAttribute)
    {
        $render = $this->withViewErrors([])->blade($component);

        $render->assertSee($expectedTag, false);
        $render->assertSee($expectedAttribute, false);
    }

    public static function dataProviderGenerateBasicForm(): array
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
}
