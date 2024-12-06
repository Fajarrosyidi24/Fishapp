@extends('layouts.app')
@section('title')
<title>Article - Fishapp</title>
@endsection

@section('content')
<div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <h1 class="display-3 text-white animated slideInDown">Artikel</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a class="text-white" href="#">Dashboard</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">Artikel</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>


@include('components.foot')
@endsection
