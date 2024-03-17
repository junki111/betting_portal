@extends('layouts.main')


@section('css')
    <!-- plugin css -->
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('breadcrumb')
    <div class="row page-title">
        <div class="col-md-12">
            <h4 class="float-left mt-1">
                Game Type Data for: <i class="font-weight-bold">
                    {{ ucwords($gametype->name) }}
                </i>
            </h4>
            <nav aria-label="breadcrumb" class="float-right mt-1">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('gametypes.index') }}">Game Management</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Game Type</li>
                </ol>
            </nav>
        </div>
    </div>
@endsection

@section('content')
    @include('flash.message')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <h4 class="header-title mt-0 mb-1">View Game Type</h4>
                        </div>
                        <div class="col-lg-6">
                            @can('view_sports')
                                <a href="{{ route('gametypes.index') }}" class="btn btn-sm btn-soft-primary float-right"
                                    rel="tooltip" data-placement="top" title="Back to Users">
                                    <i class="uil uil-arrow-left"> Back to Game Types</i>
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-10">
                        <div class="form-group row mb-3">
                            <label for="name" class="col-3 col-form-label"><span
                                    class="badge badge-dark">Name</span></label>
                            <div class="col-9">
                                <h5 id="name">{{ $gametype->name }}</h5>
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label for="description" class="col-3 col-form-label"><span
                                    class="badge badge-dark">Description</span></label>
                            <div class="col-9">
                                <h5 id="description">{{ $gametype->description }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
