@extends('dashboard.master')

@section('content')

{{-- {!!"<br>"!!}
{{var_dump($errors->any())}}
{!!"<br>"!!} --}}

@include('dashboard.partials.validation-error')

<form action="{{route("user.store")}}" method="POST">
@include('dashboard.user._form',['pasw'=>'true'])
</form>

@endsection
