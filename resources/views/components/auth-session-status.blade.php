@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-sm text-green-600']) }}>
        <i class="fas fa-check"></i>&nbsp;
        {!! $status  !!}
    </div>
@endif
