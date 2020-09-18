@extends('layouts.admin')
@section('title', "View Customer's Food")
@section('content')
    <div class="container-fluid mt--7">
        <!-- Table -->
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0 display-message">
                        @include('elements.message')
                        <div class="table-responsive" id="dynamicContent">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col"> Sr. No </th>
                                    <th scope="col"> User Name </th>
                                    <th scope="col"> Food Name</th>
                                    <th scope="col"> Serving </th>
                                    <th scope="col"> Brand Name </th>
                                    <th scope="col"> Status </th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $counter = 1; ?>
                                @if(count($customers))
                                    @foreach($customers as $key =>$value)
                                        <tr id="tr_{{ $value->id }}">
                                            <td>{{$counter}}</td>
                                            <td>{{ $value->users->first_name }} {{ $value->users->last_name }}</td>
                                            <td>{{ $value->name }}</td>
                                            <td>{{ $value->serving }}</td>
                                            <td>{{ $value->brand_name }}</td>
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
                                                {{--<div class="dropdown directn">--}}
                                                    {{--<!-- Delete link-->--}}
                                                    {{--<a href="javascript:void(0);" data-attr-id="{{ $value->id }}" class="deleteRecord" title="Delete"><i class="fa fa-times action-color" aria-hidden="true"></i></a>--}}
                                                    {{--<form id="deleteRec_{{ $value->id }}"  method="POST" action="{{ url('/admin/customer/'.$encryptId) }}" accept-charset="UTF-8" style="display:inline">--}}
                                                        {{--{{ method_field('DELETE') }}--}}
                                                        {{--{{ csrf_field() }}--}}
                                                        {{--<button  style="display: none;" type="submit"></button>--}}
                                                    {{--</form>--}}
                                                    {{--<!-- Status link-->--}}
                                                    {{--<a href="javascript:void(0);" data-url="{{ url('/admin/customer/status/'.$encryptId) }}" data-user-id="{{$value->id}}" title="{{ $statusText }}" class="btn btn-sm text-light statusLink tick-icon">--}}
                                                        {{--<i class="{{ $icon }} "></i>--}}
                                                    {{--</a>--}}
                                                    {{--<!-- Edit link-->--}}
                                                    {{--<a title="View Customer Details" href="{{ url('/admin/customer/'.$encryptId.'/edit') }}">--}}
                                                        {{--<i class="fas fa-id-card action-edit"></i>--}}
                                                    {{--</a>--}}
                                                    {{--<!-- Edit link-->--}}
                                                    {{--<a title="View Customer's Food" href="{{ url('/admin/customer/food/'.$encryptId) }}">--}}
                                                        {{--<i class="fas fa-eye action-edit"></i>--}}
                                                    {{--</a>--}}
                                                    {{--<!-- Reset passowrd link-->--}}
                                                    {{--<a title="Reset Password" href="{{ url('/admin/customer/reset_password/'.$encryptId) }}">--}}
                                                        {{--<i class="fas fa-redo"></i>--}}
                                                    {{--</a>--}}
                                                {{--</div>--}}
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
                            {{--<div class="pagination-sort">--}}
                                {{--{!! $customers->appends(['search' => Request::get('search'),'sort'=>$sort,'direction'=>$direction,'page'=>Request::get('page'),'_token'=>csrf_token()])->render() !!}--}}
                            {{--</div>--}}
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Dark table -->
    <!-- Confirmation Modal for deletion -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirmation Box</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete the record?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" id="delete" class="btn btn-primary">Ok</button>
                </div>
            </div>
        </div>
    </div>
    <!--end of modal -- >
    @endsection
