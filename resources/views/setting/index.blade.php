@extends('layouts.layout')
@section('title', 'Add a new product')

@push('css')
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css'>
@endpush


@section('main')
    <form method="POST" action="{{ route('setting.update', 1) }}" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="row">
            <div class="col-8">
                <div class="card">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="card-header">
                        <h5>Edit Setting</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="shop_name">Shop Name</label>
                            <input type="text" class="form-control" id="shop_name" name="shop_name"
                                value="{{ $settings->shop_name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="logo">Logo</label>
                            <input type="file" class="dropify form-control" id="logo" name="logo"
                                data-default-file="{{ asset('storage/logo/' . $settings->logo) }}">
                            <small class="text-muted">Accepted formats: JPG, JPEG, PNG, GIF, BMP (Max 2MB)</small>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Settings</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script src='https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js'></script>
    <script src="./script.js"></script>
    <script>
        $(document).ready(function() {
            $('.dropify').dropify();
        });
    </script>
@endpush
