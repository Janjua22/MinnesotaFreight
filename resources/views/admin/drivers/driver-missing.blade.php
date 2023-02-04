@extends('layouts.admin.master')

@section('styles')
<style>
    .table-error > :not(:last-child) > :last-child > *, 
    .table-error.table-row-dashed tr{
        border-bottom-color: #f1416c;
    }
    .missing-files-panel .table-error td{
        color: #f1416c;
    }
    .missing-files-panel .table-error th, 
    .missing-files-panel h1,
    .missing-files-panel h1 > i{
        color: #b7002d;
    }
    .missing-files-panel .subtxt{
        font-size: 11px;
    }
</style>
@endsection

@section('content')
@php 
    $titles=[
        'title' => "Drivers",
        'sub-title' => "Files Missing",
        'btn' => null,
        'url' => null
    ];
@endphp

@include('admin.components.top-bar', $titles)

<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-xxl">
        <div class="row gy-5 g-xl-8 mb-8 missing-files-panel">
            <div class="col">
                <div class="border border-dashed border-danger bg-light-danger p-5">
                    <h1><i class="bi bi-exclamation-triangle-fill fs-1"></i> DOCUMENTS MISSING!</h1>
                    <p class="text-danger mb-0">The <b>Driving License</b> or <b>Medical Card</b> documents are missing from the below mentioned driver accounts. Please upload them as soon as possible!</p>
                    <i class="subtxt text-danger">Many of the system functions are dependant on those documents, the system may miscalculate or malfunction in case of missing documents.</i>
    
                    <table class="table table-error align-middle table-row-dashed border-danger fs-6 gy-5">
                        <thead>
                            <tr class="text-start fw-bolder fs-7 text-uppercase gs-0">
                                <th class="min-w-125px">Full Name</th>
                                <th class="min-w-125px">Email</th>
                                <th class="min-w-125px">Phone</th>
                                <th class="min-w-125px">License Number</th>
                                <th class="min-w-125px">Added On</th>
                                <th class="min-w-125px">Status</th>
                                <th class="min-w-70px">Update</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($missingFiles as $missingFile)
                            <tr>
                                <td>
                                    <a href="{{ $missingFile['url'] }}" class="text-gray-800 text-hover-primary mb-1">
                                        <img src="{{ $missingFile['image'] }}" class="mw-50px rounded-circle" alt="driver avatar">
                                        {{ $missingFile['name'] }}
                                    </a>
                                </td>
                                <td>{{ $missingFile['email'] }}</td>
                                <td>{{ $missingFile['phone'] }}</td>
                                <td>
                                    <div class="badge badge-light">{{ $missingFile['license_number'] }}</div>
                                </td>
                                <td>{{ $missingFile['created_at'] }}</td>
                                <td>
                                    @if($missingFile['status'] == 1)
                                        <div class="badge badge-light-success">Active</div>
                                    @else
                                        <div class="badge badge-light-danger">Disabled</div>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ $missingFile['url'] }}" class="btn btn-danger btn-sm"><i class="bi bi-box-arrow-up-right"></i> Edit</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection