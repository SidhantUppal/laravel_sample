@extends('layouts.admin')
@section('title', 'Reset Password')
@section('content')
        <!-- Page content -->
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0"> Reset Password </h3>
                        </div>
                    </div>
                </div>
                <div class="card-body shadow">
                    @include('elements.message')
                    @php $encryptId = Helper::encryptDataId($customer->id) @endphp
                    <form id="resetPassword" method="post" action="{{ url('/admin/customer/reset_password/'.$encryptId) }}" enctype="multipart/form-data">
                        @method('PATCH')
                        @csrf
                        <div class="pl-lg-4 add-section">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <input name="password" value="" type="password" autocomplete="off" class="form-control form-control-alternative" placeholder="Enter Password">
                                        @if ($errors->has('password'))
                                            <span class="help-block text-danger">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Description -->
                        <div class="col-xl-12 text-center">
                            <button type="submit" class="btn btn-success"> Save </button>
                            <a href="{{ url('/admin/customer') }}" class="btn btn-danger">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('validation-script')
    <script src="{{  asset('assets/js/validations/customer_reset_password/reset_password.js') }}"></script>
@endsection
