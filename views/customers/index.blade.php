@extends('layouts.admin')
@section('title', 'Manage Customers')
@section('content')
    <div class="container-fluid mt--7">
        <!-- Table -->
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0 display-message">
                        @include('elements.message')
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <div class="input-group mb-4">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"></span>
                                        </div>
                                        <form id="searchForm" method="get" action="javascript:void(0);" role="search">
                                            <div class="input-group pull-right">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                                                <input autocomplete="off" name="search" type="text" class="form-control search-length" placeholder="Search.." aria-describedby="button-addon6">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary bg-info border-info searchButton" type="button"></button>
                                                    <input type="hidden" name="action" value="/customer">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <label style="margin-left:145px">
                                <a id="export_data" href="{{ url('/admin/user/export') }}">
                                    <button type="button" class="btn btn-success"> <i class="fa fa-download colored-changes"></i> Export Customers</button>
                                </a>
                            </label>
                        </div>
                        <div class="table-responsive" id="dynamicContent">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col"> Sr. No </th>
                                    <th scope="col">@sortablelink('first_name', 'First Name',['page'=>Request::get('page'),'_token'=>csrf_token()],['class'=>'sortable'])</th>
                                    <th scope="col">@sortablelink('last_name', 'Last Name',['page'=>Request::get('page'),'_token'=>csrf_token()],['class'=>'sortable'])</th>
                                    <th scope="col">@sortablelink('email', 'Email',['page'=>Request::get('page'),'_token'=>csrf_token()],['class'=>'sortable'])</th>
                                    <th scope="col"> Status </th>
                                    <th scope="col"> Actions </th>
                                </tr>
                                </thead>
                                <tbody>
                                <img style="display: none; margin-left: 25%; margin-right: 30%; width: 50%;" class="loader" src="{{asset('assets/img/theme/small_loader.gif')}}">
                                <?php $counter = 1; ?>
                                @if(count($customers))
                                    @foreach($customers as $key =>$value)
                                        <tr id="tr_{{ $value->id }}">
                                            <td>{{$counter}}</td>
                                            @if($value->first_name)
                                                <td>{{ $value->first_name }}</td>
                                            @else
                                                <td>N/A</td>
                                            @endif
                                            @if($value->last_name)
                                                <td>{{ $value->last_name }}</td>
                                            @else
                                                <td>N/A</td>
                                            @endif
                                            <td>{{ $value->email }}</td>
                                            <td id="status_{{$value->id}}">
                                                <span class="badge badge-dot mr-4">
                                                @if($value->status == 0)
                                                        <i class="bg-warning"></i> Inactive
                                                    @else
                                                        <i class="bg-success"></i> Active
                                                    @endif
                                                </span>
                                            </td>
                                            <td class="text-right">
                                                <?php
                                                $statusText = !empty($value->status) ? 'Deactivate' : 'Activate';
                                                $icon = !empty($value->status) ? 'fa fa-check text-green' : 'fa fa-ban action-block text-red';
                                                $encryptId = Helper::encryptDataId($value->id);
                                                ?>
                                                <div class="dropdown directn">
                                                    <!-- Delete link-->
                                                    <a href="javascript:void(0);" data-attr-id="{{ $value->id }}" class="deleteRecord" title="Delete"><i class="fa fa-times action-color" aria-hidden="true"></i></a>
                                                    <form id="deleteRec_{{ $value->id }}"  method="POST" action="{{ url('/admin/customer/'.$encryptId) }}" accept-charset="UTF-8" style="display:inline">
                                                        {{ method_field('DELETE') }}
                                                        {{ csrf_field() }}
                                                        <button  style="display: none;" type="submit"></button>
                                                    </form>
                                                    <!-- Status link-->
                                                    <a href="javascript:void(0);" data-url="{{ url('/admin/customer/status/'.$encryptId) }}" data-user-id="{{$value->id}}" title="{{ $statusText }}" class="btn btn-sm text-light statusLink tick-icon">
                                                        <i class="{{ $icon }} "></i>
                                                    </a>
                                                    <!-- View link-->
                                                    <a class="link_ico" title="View Customer Details" href="{{ url('/admin/customer/'.$encryptId.'/edit') }}">
                                                        <i class="fas fa-id-card action-edit"></i>
                                                    </a>
                                                    <!-- Edit link-->
                                                    <a class="link_ico" title="View Customer's Food" href="{{ url('/admin/customer/food/'.$encryptId) }}">
                                                        <i class="fas fa-eye action-edit"></i>
                                                    </a>
                                                    <!-- Reset passowrd link-->
                                                    <a class="link_ico" title="Reset Password" href="{{ url('/admin/customer/reset_password/'.$encryptId) }}">
                                                        <i class="fas fa-redo"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php $counter++ ?>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="text-center" colspan="5">No records found.</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                            <?php
                            $direction = 'desc';
                            $sort = 'id';
                            if (Request::get('direction') and ! empty(Request::get('direction'))) {
                                $direction = Request::get('direction');
                                $sort = Request::get('sort');
                            }
                            if (count($customers)) {
                            ?>
                            <div class="pagination-sort">
                                {!! $customers->appends(['search' => Request::get('search'),'sort'=>$sort,'direction'=>$direction,'page'=>Request::get('page'),'_token'=>csrf_token()])->render() !!}
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Dark table -->
    <!-- Confirmation Modal for deletion -->
    @include('admin.include_pages.delete_confirmation')
    <!--end of modal -- >
    @endsection
