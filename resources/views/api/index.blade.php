@extends('layouts.app')

@section('content')

foreach($response['response'] as $i => $v)

{{ $v['response'] }}

@endforeach

@endsection