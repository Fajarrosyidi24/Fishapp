@extends('layouts.app_admin')
@section('title')
<title>Data Seafood Page - Fishapp</title>
@endsection

@section('content')
<ol class="breadcrumb mt-4">
    <li class="breadcrumb-item active">Data Seafood</li>
</ol>

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Data Seafood
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>email</th>
                    <th>foto</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Name</th>
                    <th>email</th>
                    <th>foto</th>
                </tr>
            </tfoot>
            <tbody>
                <tr>
                    <td>dfosdnfdf</td>
                    <td>dfsdfsdfdf</td>
                    <td>dfsdfdfdfdff</td>
                </tr>
                <tr>
                    <td>dfosdnfdf</td>
                    <td>dfsdfsdfdf</td>
                    <td>dfsdfdfdfdff</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection