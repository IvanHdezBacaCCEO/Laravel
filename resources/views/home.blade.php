<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi primera vista</title>
</head>
<body>
    <h1>Mundo Laravel - {!!"Hola mundo $nombre $apellido <script>alert('Hola mundo')</script>"!!}</h1>
    <ul>
        {{-- <?php foreach ($posts as $key => $post): ?>
        <li>{{$post}}</li>
        <?php endforeach; ?> --}}

        {{-- @forelse ($posts2 as $post)
        <li>{{$post}}</li>
        @empty
            <li>Vacio</li>
        @endforelse --}}

        @isset($posts2)
            IsSet
        @endisset
        @empty($posts2)
            Empty
        @endempty

        @forelse ($posts as $post)
            {{-- <?php dd($loop)?> --}}
            {{-- <?php var_dump($loop)?> --}}

            <li>
            @if ($loop->first)
                Primero
            @elseif ($loop->last)
                Ultimo
            @else
                Medio
            @endif
            {{$post}}</li>

            @empty
                <li>Vacio</li>
        @endforelse
    </ul>

</body>

</html>