@props(['action', 'post' => null, 'put' => null, 'delete' => null])

<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <form action="{{ $action }}" method="post">
        @csrf

        @if ($put)
            @method('PUT')
        @endif
        @if ($delete)
            @method('DELETE')
        @endif

        {{ $slot }}
    </form>
</div>
