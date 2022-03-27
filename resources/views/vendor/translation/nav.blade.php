<nav class="header">

    <h1 class="text-lg px-6">{{ __("Translation Manager") }} | {{ $title }}</h1>

    <ul class="flex-grow justify-end pr-2">
        <li>
            <a href="{{ route('site.lang') }}" class="{{ set_active('') }}{{ set_active('/create') }}">
                <i class="fa fa-arrow-left"></i> &nbsp; {{ __('Back') }}
            </a>
        </li>
        <li>
            <a href="{{ route('languages.translations.index', config('app.locale')) }}" class="{{ set_active('*/translations') }}">
                @include('translation::icons.translate')
                {{ __('translation::translation.translations') }}
            </a>
        </li>
    </ul>

</nav>