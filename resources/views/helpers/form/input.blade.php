<div class="form-group mb-3" style="@if($hidden) display:none @endif">
    <label for="{{ $id }}">
        {{ $title }} {!! $required ? "<span class='text-danger'>* (إجباري)</span>" : "" !!}
    </label>
    <div class="col-sm-{{ $input_width }}">
        <input type="{{ $type }}" name="{{ $name }}" placeholder='{{ $placeholder }}' id="{{ $id }}" class="form-control tooltips {{ $class }}" title="{{ $tooltip }}" {{ $required ? "required" : "" }} value="{{ $value }}" {{ $extra }}>
    </div>
</div>