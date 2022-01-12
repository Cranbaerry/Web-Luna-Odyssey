@props(['errors'])

@if ($errors->any())
    <div role="alert" {{ $attributes }}>
        <i class="fas fa-exclamation-triangle"></i>&nbsp;
        <strong>{{ __('Whoops! Something went wrong.') }}</strong> You should check in on some of those fields below.
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
