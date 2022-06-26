

<div class="form-group mb-3">
    <label for="{{ $id }}">
        {{ $title }} {!! $required ? "<span class='text-danger'>* (إجباري)</span>" : "" !!}
    </label>
    <div class="col-sm-{{ $input_width }}">
        <textarea id="{{ $id }}" name="{{ $name }}" title="{{ $tooltip }}" placeholder='{{ $placeholder }}' class="form-control {{ $ckeditor  ? "ckeditor" : "" }} tooltips" @if (!$ckeditor && $required) required @endif {{ $extra }}>{{$value}}</textarea>
    </div>
</div>