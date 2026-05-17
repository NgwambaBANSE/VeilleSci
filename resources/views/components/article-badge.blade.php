@props(['label', 'type' => 'domain'])

@if($type === 'domain')
    <span class="art-badge art-badge-domain">{{ $label }}</span>
@else
    <span class="art-badge art-badge-kw">{{ $label }}</span>
@endif
