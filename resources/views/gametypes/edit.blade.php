@extends('layouts.main')

@section('breadcrumb')
    <div class="row page-title">
        <div class="col-md-12">
            <nav aria-label="breadcrumb" class="float-right mt-1">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('gametypes.index') }}">Game Management</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Game Types</li>
                </ol>
            </nav>
            <h4 class="mb-1 mt-0">Edit Game Type</h4>
        </div>
    </div>
@endsection

@section('content')
    @include('flash.message')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <h4 class="header-title mt-0 mb-1">Edit Game Type</h4>
                        </div>
                        @can('view_sports')
                            <div class="col-lg-6">
                                <a href="{{ route('gametypes.index') }}" class="btn btn-sm btn-soft-primary float-right"
                                    rel="tooltip" data-placement="top" title="Back to Users">
                                    <i class="uil uil-arrow-left"> Back to Game Types</i>
                                </a>
                            </div>
                        @endcan
                    </div>
                    <br>

                    <div class="row">
                        <div class="col-xl-10">
                            <form action="{{ route('gametypes.edit', $gametype->id) }}" method="post">
                                @csrf
                                <div class="form-group row mb-3">
                                    <label for="Name3" class="col-3 col-form-label">Name</label>
                                    <div class="col-9">
                                        <input type="text" class="form-control" id="Name3"
                                            placeholder="Game Type Name" required value="{{ old('name', $gametype->name) }}"
                                            name="name">
                                    </div>
                                </div>

                                <div class="form-group row mb-3">
                                    <label for="Description3" class="col-3 col-form-label">Description</label>
                                    <div class="col-9">
                                        <input type="text" class="form-control" id="Description3"
                                            placeholder="Description" required
                                            value="{{ old('description', $gametype->description) }}" name="description">
                                    </div>
                                </div>

                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary mb-2"><i
                                            class="uil uil-location-arrow"></i> Submit
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
