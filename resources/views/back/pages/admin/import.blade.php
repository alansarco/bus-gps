@extends('back.layout.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle: 'Import');
@section('content')
    <div class="container">
        <h1>Import Data</h1>
        @session('success')
        <div class="alert alert-success">
            {{$value}}
        </div>
        @endsession
        <form method="post" action="{{ route('admin.import-data') }}" enctype="multipart/form-data">
            @csrf
            <div class="mt-2">
                <label>Choose File:</label>
                <input type="file" name="file" class="form-control">
            </div>

            <div class="mt-2">
                <button class="btn btn-success">Submit</button>
            </div>
        </form>

    </div>

@endsection