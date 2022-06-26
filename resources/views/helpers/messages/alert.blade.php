@if ($messages->isNotEmpty())




<div class="alert  alert-{{ $type }}" role="alert">

    @if ($with_exit)
    <button class="close mr-2" type="button" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    @endif


    @if ($messages->count() == 1)
    {!! $messages->first() !!}
    @else
    <ul class="messages-ul">
        @foreach ($messages as $message)
        <li>{!! $message !!}</li>
        @endforeach
    </ul>
    @endif


</div>

@endif