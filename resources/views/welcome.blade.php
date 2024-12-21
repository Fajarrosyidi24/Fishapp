@extends('layouts.app')
@section('title')
<title>Home Page - Fishapp</title>
@endsection

@section('content')
@include('components.carousel')
@include('components.service')
@include('components.about')
@include('components.categories')
{{-- @include('components.team') --}}
@include('components.foot')
@endsection