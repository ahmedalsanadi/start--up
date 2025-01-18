@props(['error' => false])

@if ($error)
    <p class=" form-error ">{{ $error }}</p>
@endif
