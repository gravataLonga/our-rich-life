@php
    /** @var \Laravel\Boost\Install\GuidelineAssist $assist */
@endphp
## Test Enforcement

- Every change must be programmatically tested by running all the suite and make sure they pass.
- Use `{{ $assist->artisanCommand('test --compact') }}`, in case the erro you can run with a specific filename or filter.
