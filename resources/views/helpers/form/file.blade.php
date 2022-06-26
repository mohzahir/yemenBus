@if ($multiple)
<div class="form-group mb-3">
    <label for="{{ $id }}">
        {{ $title }}
        @if ($required && $value->isEmpty())
        {!! $required ? "<span class='text-danger'>* (إجباري)</span>" : "" !!}
        @endif
    </label>
    <div class="col-sm-{{ $input_width }}">
        <input multiple type="file" name="{{ $name }}[]" id="{{ $id }}" class="form-control tooltips" title="{{ $tooltip }}" @if ($required && $value->isEmpty()) {{ "required" }} @endif {{ $extra }} accept="{{ $accept }}" >
    </div>
</div>

@if ($value->isNotEmpty())
<div class="form-group">
    <label>{{ __("labels.previewX",["X" => $title]) }}</label>
    <div class="row">
        @foreach ($value as $file)
        <div class="col-sm-2">
            <div class="card bg-dark text-white o-hidden mb-4">
                <img class="card-img" src="{{ $type == "image" ? $multiple_file_url($file) : "/assets/admin/images/file.jpg" }}" width="100%" height="100">
                <div class="card-img-overlay d-flex align-items-center justify-content-center">
                    @if (!($required && $value->count() == 1))
                    <a href="{{ $multiple_delete_url($file) }}">
                        <button class="btn btn-danger m-1" type="button"><i class="i-Remove"></i></button>
                    </a>
                    @endif
                    @if ($type == "file")
                    <a href="{{_Storage::uploads($file)}}" class="btn btn-dark m-1" target="_blank">
                        <i class="i-Eye"></i>
                    </a>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif



@else
@php
$is_exists = _Storage::is_exists($value);
@endphp
<div class="form-group {{$is_exists ? "d-none" : "" }} file-input-{{$id}}">
    <label for="{{ $id }}">
        {{ $title }}
        @if ($required && !$is_exists)
        {!! $required ? "<span class='text-danger'>*</span>" : "" !!}
        @endif
    </label>
    <div class="col-sm-{{ $input_width }}">
        <input type="file" name="{{ $name }}" id="{{ $id }}" class="form-control tooltips" title="{{ $tooltip }}" @if ($required && !$is_exists) {{ "required" }} @endif {{ $extra }} accept="{{ $accept }}">
    </div>
</div>

@if ($is_exists)
<div class="form-group file-preview-{{ $id }}">
    <label>{{ __("labels.previewX",["X" => $title]) }}</label>
    <input hidden name="old_{{ $name }}" checked type="checkbox">


    <div class="col-sm-{{ $type == "image" ? ceil($input_width / 3) : 2 }}">
        <div class="card bg-dark text-white o-hidden mb-4">

            <img class="card-img" src="{{ $type == "image" ? _Storage::uploads($value) : "/assets/admin/images/file.jpg" }}">
            <div class="card-img-overlay d-flex align-items-center justify-content-center">
                @if (!$required)
                <button class="btn btn-danger m-1 remove-file-btn " data-id="{{ $id }}" type="button"><i class="i-Remove"></i></button>
                @endif
                <button class="btn btn-primary m-1 edit-file-btn " data-id="{{ $id }}" type="button"><i class="i-Pen-2"></i></button>
                @if ($type == "file")
                <a href="{{_Storage::uploads($value)}}" class="btn btn-dark m-1" target="_blank">
                    <i class="i-Eye"></i>
                </a>

                @endif
            </div>
        </div>
    </div>
</div>
@endif

@endif