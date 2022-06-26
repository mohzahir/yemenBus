

<div class="form-group mb-3">
    <label for="{{ $id }}">
        {{ $title }} {!! $required ? "<span class='text-danger'>* (إجباري)</span>" : "" !!}
    </label>
    <div class="col-sm-{{ $input_width }}">
        <select class="form-control tooltips {{ $with_search ? "search-select" : "" }} {{$class}}" {{ $multiple ? "multiple" : "" }} title="{{ $tooltip }}" name="{{ $name }}{{ $multiple ? "[]" : "" }}" {{ $required ? "required": "" }} id="{{ $id }}" {{ $extra }} @if (!$required && !$multiple) data-placeholder="null" @endif>

            @if ($with_not_exists && !$required && !$multiple)
            <option selected value="">@lang("labels.not_exists")</option>
            @endif

            @foreach ($dataArray as $data)
            <option value="{{ $valueFunction($data) }}" @if($value !=="" ){{  $multiple ? selected($value->contains($valueFunction($data)),true) : selected($valueFunction($data),$value)  }}@endif>
                {{ $nameFunction($data) }}
            </option>
            @endforeach
        </select>
    </div>

</div>