@foreach ((array) session('flash_notification') as $message)
  @if ($message['overlay'] ?? false)
    @include('flash::modal', [
      'modalClass' => 'flash-modal',
      'title'      => $message['title'],
      'body'       => $message['message']
    ])
  @else

    @if ($message['important'] ?? false)
      <div class="alert alert-{{ $message['level'] ?? '' }} {{ $message['important'] ? 'alert-important' : '' }}">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {!! $message['message'] ?? '' !!}
      </div>
  @endif

@endif
@endforeach

{{ session()->forget('flash_notification') }}
