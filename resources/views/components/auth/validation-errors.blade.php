@props(['errors'])

@if ($errors->any())
    <div {{ $attributes }}>
        <ul class="text-sm text-red-600 list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
