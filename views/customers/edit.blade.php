@extends('layouts.admin')
@section('title', 'View Customer Details')
@section('content')
        <!-- Page content -->
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0"> Customer Details </h3>
                        </div>
                    </div>
                </div>
                <div class="card-body shadow">
                    <div class="row">
                        <div class="col justify-content-center">
                            @include('elements.message')
                            <form id="" action="" enctype="multipart/form-data">
                                @csrf
                                <div class="pl-lg-4 add-section">
                                    <div class="row">
                                        <div class="col-lg-2">
                                            First Name:
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <input name="first_name" value="{{ old('first_name',@$customer->first_name) }}" type="text" autocomplete="off" class="form-control form-control-alternative" disabled>
                                                @if ($errors->has('first_name'))
                                                    <span class="help-block text-danger">
                                                        <strong>{{ $errors->first('first_name') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-2">
                                            Last Name:
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <input name="last_name" value="{{ old('last_name',@$customer->last_name) }}" type="text" autocomplete="off" class="form-control form-control-alternative" disabled>
                                                @if ($errors->has('last_name'))
                                                    <span class="help-block text-danger">
                                                        <strong>{{ $errors->first('last_name') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-2">
                                            Email:
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <input name="email" value="{{ old('email',@$customer->email) }}" type="text" autocomplete="off" class="form-control form-control-alternative" disabled>
                                                @if ($errors->has('email'))
                                                    <span class="help-block text-danger">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-2">
                                            DOB:
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <input name="dob" value="{{ old('dob',@$customer->date_of_birth) }}" type="text" autocomplete="off" class="form-control form-control-alternative" disabled>
                                                @if ($errors->has('dob'))
                                                    <span class="help-block text-danger">
                                                        <strong>{{ $errors->first('dob') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-2">
                                            Gender:
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <input name="gender" value="{{ old('gender',@$customer->gender) }}" type="text" autocomplete="off" class="form-control form-control-alternative" disabled>
                                                @if ($errors->has('gender'))
                                                    <span class="help-block text-danger">
                                                        <strong>{{ $errors->first('gender') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-2">
                                            Height:
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <input name="height" value="{{ old('height',@$customer->current_height) }}" type="text" autocomplete="off" class="form-control form-control-alternative" disabled>
                                                @if ($errors->has('height'))
                                                    <span class="help-block text-danger">
                                                        <strong>{{ $errors->first('height') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-2">
                                            Weight:
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <input name="weight" value="{{ old('weight',@$customer->current_weight) }}" type="text" autocomplete="off" class="form-control form-control-alternative" disabled>
                                                @if ($errors->has('weight'))
                                                    <span class="help-block text-danger">
                                                        <strong>{{ $errors->first('weight') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-2">
                                            Goal:
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <input name="goal" value="{{ old('goal',@$customer->goal) }}" type="text" autocomplete="off" class="form-control form-control-alternative" disabled>
                                                @if ($errors->has('goal'))
                                                    <span class="help-block text-danger">
                                                        <strong>{{ $errors->first('goal') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Description -->
                                <div class="col-xl-12 go-button">
                                    <a href="{{ url('/admin/customer') }}" class="btn btn-danger">
                                        Go Back
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
