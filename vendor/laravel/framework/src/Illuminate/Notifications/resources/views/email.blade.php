<x-mail::message>
{{-- Saludo --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('¡Vaya!')
@else
# @lang('¡Hola!')
@endif
@endif

{{-- Líneas de Introducción --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach

{{-- Botón de Acción --}}
@isset($actionText)
<?php
    $color = match ($level) {
        'success', 'error' => $level,
        default => 'primary',
    };
?>
<x-mail::button :url="$actionUrl" :color="$color">
{{ $actionText }}
</x-mail::button>
@endisset

{{-- Líneas de Despedida --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

{{-- Despedida --}}
@if (! empty($salutation))
{{ $salutation }}
@else
@lang('Saludos'),<br>
{{ config('app.name') }}
@endif

{{-- Subtexto --}}
@isset($actionText)
<x-slot:subcopy>
@lang(
    "Si tienes problemas haciendo clic en el botón \":actionText\", copia y pega la URL de abajo\n".
    'en tu navegador web:',
    [
        'actionText' => $actionText,
    ]
) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
</x-slot:subcopy>
@endisset
</x-mail::message>
