@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    Hi {{ $user->name }}, 
                    @session('success')
                        <div class="alert alert-success mt-2">
                            {{ session('success') }}. Your short URL is <span class="">{{ session('short_url') }}</span>
                        </div>
                    @endsession

                    @session('error')
                        <div class="alert alert-danger mt-2">
                            {{ session('error') }}.
                        </div>
                    @endsession
                    
                    <div class="row justify-content-center">
                        
                        <div class="col-md-5">
                            <form action="{{ route('store') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="">URL</label>
                                <input value="{{ old('url') }}" type="url" required name="url" id="" @class([
                                    'form-control',
                                    'is-invalid' => $errors->has('url')
                                ])>
                                @error('url')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <button class="btn btn-info">Short URL</button>
                            </form>
                        </div>

                        <div class="col-md-auto mt-4">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th class="text-wrap">URL</th>
                                            <th>Short URL</th>
                                            <th>Create At</th>
                                            <th>Clicks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($urls as $url)
                                        <tr>
                                            <td>{{ $url->id }}</td>
                                            <td>{{ $url->long_url }}</td>
                                            <td>{!! $url->short_url !!}</td>
                                            <td>{{ $url->created_at }}</td>
                                            <td>{{ $url->clicks }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="float-right">
                                    {{ $urls->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
