@extends('layouts.admin.master')

@section('content')
@php 
    $titles=[
        'title' => "Expense",
        'sub-title' => "Edit",
        'btn' => "Expenses List",
        'url' => route('admin.expenses')
    ];
@endphp

@include('admin.components.top-bar', $titles)

<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-xxl">
        <div class="d-flex flex-column flex-lg-row">
            <div class="flex-lg-row-fluid mb-10 mb-lg-0 me-lg-7 me-xl-10">
               <div class="card">
                    <div class="card-body p-12">
                        <form action="{{ route('admin.expenses.update') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $expense->id }}">

                            <div class="d-flex flex-column align-items-start flex-xxl-row">
                                <div class="d-flex flex-center flex-equal fw-row text-nowrap order-1 order-xxl-2 me-4">
                                    <span class="fs-2x fw-bolder text-gray-800">Edit Expense</span>
                                </div>
                            </div>

                            <div class="separator separator-dashed my-10"></div>

                            <div class="form-body">
                                <div class="row">
                                    <div class="form-group col-md-6 mb-7">
                                        <label>
                                            Expense Category 
                                            <sup class="text-danger">*</sup>
                                            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addExpenseCategory">
                                                <i class="fas fa-plus-circle text-primary"></i>
                                            </a>
                                        </label>
                                        <select name="category_id" class="form-control form-select form-select-solid @error('category_id') is-invalid border-danger @enderror" data-control="select2" data-placeholder="Select Expense Category" required>
                                            <option value="">Select Expense Category</option>
                                            @foreach($categories as $category)
                                            <option value="{{ $category->id }}" @if($expense->category_id == $category->id) selected @endif>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Date <sup class="text-danger">*</sup></label>
                                        <input type="date" name="date" value="{{ $expense->date }}" class="form-control form-control-solid @error('date') is-invalid border-danger @enderror" placeholder="Pickup Date..." required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Amount <sup class="text-danger">*</sup></label>
                                        <input type="number" name="amount" value="{{ $expense->amount }}" class="form-control form-control-solid @error('amount') is-invalid border-danger @enderror" placeholder="Amount..." min="0" step=".01" required>
                                    </div>
                                    <div class="form-group col-md-6 mb-7">
                                        <label>Truck/Unit <sup class="text-danger">*</sup></label>
                                        <select name="truck_id" class="form-control form-select form-select-solid @error('truck_id') is-invalid border-danger @enderror" data-control="select2" data-placeholder="Select Truck/Unit" required>
                                            <option value="">Select Truck/Unit</option>
                                            @foreach($trucks as $truck)
                                            <option value="{{ $truck->id }}" @if($expense->truck_id == $truck->id) selected @endif>{{$truck->truck_number}} ({{ ($truck->type_id == 1)? 'Truck' : 'Trailer' }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4 mb-7">
                                        <label>Load Number <sup class="text-danger">*</sup></label>
                                        <select name="load_id" class="form-control form-select form-select-solid @error('load_id') is-invalid border-danger @enderror" data-control="select2" data-placeholder="Select Load" required>
                                            <option value="">Select Load</option>
                                            @foreach($loads as $load)
                                            <option value="{{ $load->id }}" @if($expense->load_id == $load->id) selected @endif>{{ $load->load_number }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4 mb-7">
                                        <label>Gallons</label>
                                        <input type="number" name="gallons" value="{{ $expense->gallons }}" class="form-control form-control-solid @error('gallons') is-invalid border-danger @enderror" placeholder="Gallons..." min="0">
                                    </div>
                                    <div class="form-group col-md-4 mb-7">
                                        <label>Odometer</label>
                                        <input type="number" name="odometer" value="{{ $expense->odometer }}" class="form-control form-control-solid @error('odometer') is-invalid border-danger @enderror" placeholder="Odometer Reading..." min="0">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12 mb-7">
                                        <label>Note</label>
                                        <textarea name="note" class="form-control form-control-solid @error('note') is-invalid border-danger @enderror" rows="5" placeholder="Any details here..." maxlength="255">{{ $expense->note }}</textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-12 my-2">
                                        <button type="submit" class="btn btn-success" id="kt_invoice_submit_button">
                                            Submit
                                            <span class="svg-icon svg-icon-3">{!! getSvg('gen016') !!}</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Expense Category Modal -->
    <div class="modal fade" id="addExpenseCategory" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header d-flex flex-row-reverse ribbon ribbon-start ribbon-clip">
                    <div class="ribbon-label fw-bolder">
                        Create
                        <span class="ribbon-inner bg-success"></span>
                    </div>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary w-5 float-end" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                            {!! getSvg('arr061') !!}
                        </span>
                    </div>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary w-95 float-end">
                        <h2 class="fw-bolder">Expense Category</h2>
                    </div>
                </div>
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <form action="{{ route('admin.expenseCategory.create') }}" method="POST" onsubmit="return submitExpenseCategory(this);">
                        @csrf

                        <div class="form-body">
                            <div class="row">
                                <div class="form-group col-md-12 mb-7">
                                    <label>Name <sup class="text-danger">*</sup></label>
                                    <input type="text" name="name" class="form-control form-control-solid @error('name') is-invalid border-danger @enderror" placeholder="Category Name..." required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12 mb-7">
                                    <label>Description</label>
                                    <textarea name="description" class="form-control form-control-solid @error('description') is-invalid border-danger @enderror" rows="5" placeholder="Any details here..." maxlength="255"></textarea>
                                </div>
                            </div>
                        </div>
    
                        <div class="text-center pt-15">
                            <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Close</button>
    
                            <button type="submit" class="btn btn-success" data-kt-modules-modal-action="submit">
                                <span class="indicator-label">Submit</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let submitExpenseCategory = form => {
        $(form).find('.indicator-label').html(`<i class="fas fa-spinner fa-pulse"></i>`);

        $.ajax({
            url: $(form).attr('action'),
            type: 'POST',
            data: $(form).serialize(),
            success: (res)=>{
                $(`select[name=category_id]`).append(`<option value="${res.id}" selected>${res.name}</option>`);

                form.reset();
            },
            error: (err)=>{
                console.error(err);
            },
            complete: ()=>{
                $(form).find('.indicator-label').html(`<i class="fas fa-spinner fa-pulse"></i>`);
                $("#addExpenseCategory").modal("hide");
            }
        });

        return false;
    }
</script>
@endsection