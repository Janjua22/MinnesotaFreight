@extends('layouts.admin.master')

@section('content')
@php 
    $titles=[
        'title' => "Invoices",
        'sub-title' => "List",
        'btn' => null,
        'url' => null
    ];
@endphp

@include('admin.components.top-bar', $titles)

<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-fluid">
        <!--begin::Alert-->
        @include('admin.components.alerts')
        <!--end::Alert-->

        <div class="card">
            <div class="card-header border-0 pt-6">
                <div class="card-title">
                    <div class="d-flex align-items-center position-relative my-1">
                        <span class="svg-icon svg-icon-1 position-absolute ms-6">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                <path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero" />
                            </g>
                            </svg>
                        </span>
                        <input type="text" data-kt-subscription-table-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Search Invoice" />
                    </div>
                </div>

                <div class="card-toolbar">
                    <div class="d-flex justify-content-end" data-kt-subscription-table-toolbar="base">
                        {{-- 
                            id to replace for enabling the date range mechanism
                            #exportInvoiceRange 
                        --}}
                        <a href="javascript:void(0);" class="btn btn-success me-5" data-bs-toggle="modal" data-bs-target="#selectInvoicesModal">
                            <i class="fas fa-file-export"></i>
                            Export Bulk Invoices
                        </a>
                        <a href="{{ route('admin.invoice.add') }}" class="btn btn-success">
                            <i class="fas fa-plus"></i>
                            Generate Invoice
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body pt-0">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_subscriptions_table">
                    <thead>
                        <tr class="text-start fw-bolder fs-7 text-uppercase gs-0">
                            <th class="min-w-125px">Invoice Number</th>
                            <th class="min-w-125px">Load Number</th>
                            <th class="min-w-125px">Customer Name</th>
                            <th class="min-w-125px">Total Amount</th>
                            <th class="min-w-125px">Total Balance</th>
                            <th class="min-w-125px">Invoice Date</th>
                            <th class="min-w-125px">Due Date</th>
                            <th class="min-w-125px">Paid On</th>
                            <th class="min-w-125px">Status</th>
                            <th class="text-end min-w-70px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($allInvoices as $inv)
                        <tr>
                            <td>
                                {{ $inv->invoice_number }}
                                @if($inv->batch_id)
                                <span class="badge badge-secondary">Batch #{{ $inv->batch->batch_number }}</span>
                                @endif
                            </td>
                            <td>{{ $inv->loadPlanner->load_number }}</td>
                            <td>{{ $inv->customer->name }}</td>
                            <td>
                                ${{ number_format($inv->total_amount, 2) }} 
                                @if($inv->include_factoring)
                                <i class="fas fa-info-circle text-info" data-bs-toggle="tooltip" data-bs-placement="right" title="Factoring Fee: -{{ $inv->factoring_fee }}%" data-bs-original-title="Factoring Fee: -{{ $inv->factoring_fee }}%"></i>
                                @endif
                            </td>
                            <td>${{ number_format($inv->include_factoring ? $inv->total_w_factoring : $inv->total_balance, 2) }}</td>
                            <td>{{ ($inv->date)? date_format(new DateTime($inv->date), "M d, Y") : 'N/A' }}</td>
                            <td class="text-warning">{{ ($inv->due_date)? date_format(new DateTime($inv->due_date), "M d, Y") : 'N/A' }}</td>
                            <td>{{ ($inv->paid_date)? date_format(new DateTime($inv->paid_date), "M d, Y") : 'N/A' }}</td>
                            <td>
                                @if($inv->status == 0)
                                <span class="badge badge-light-danger">Canceled</span>
                                @endif
                                @if($inv->status == 1)
                                <span class="badge badge-light-success">Paid</span>
                                @endif
                                @if($inv->status == 2)
                                <span class="badge badge-light-warning">Open</span>
                                @endif
                                @if($inv->status == 3)
                                <span class="badge badge-light-info">Unpaid</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
                                    Actions
                                    <span class="svg-icon svg-icon-5 m-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24" />
                                                <path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000003, 11.999999) rotate(-180.000000) translate(-12.000003, -11.999999)" />
                                            </g>
                                        </svg>
                                    </span>
                                </a>
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                                    @if($inv->status == 2)
                                        @php
                                            $factoringAmount = ($inv->total_balance * siteSetting('factoring')) / 100;
                                            
                                            $arr = array(
                                                'id' => $inv->id,
                                                'amount' => $inv->total_balance,
                                                'date' => ($inv->date)? date_format(new DateTime($inv->date), "M d, Y") : 'N/A',
                                                'factoring_fee' => siteSetting('factoring'),
                                                'factoring_fee_amount' => round($factoringAmount, 2),
                                                'total_w_factoring' => round($inv->total_balance - $factoringAmount, 2)
                                            );

                                            $arr = json_encode($arr);
                                        @endphp
                                        <div class="menu-item px-3">
                                            <a href="javascript:void(0);" class="menu-link px-3" onclick="showFinalizeModal({{$arr}});">Settle-Down</a>
                                        </div>
                                        <div class="menu-item px-3">
                                            <a href="{{ route('admin.invoice.edit', ['id' => $inv->id]) }}" class="menu-link px-3">Edit</a>
                                        </div>
                                    @elseif($inv->status == 3)
                                        <form action="{{ route('admin.invoice.paid') }}" method="POST" id="formMarkPaid-{{ $inv->id }}">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $inv->id }}">
                                            <div class="menu-item px-3">
                                                <a href="javascript:void(0);" class="menu-link px-3" onclick="confirmPaid('formMarkPaid-{{ $inv->id }}');">Mark as Paid</a>
                                            </div>
                                        </form>
                                    @endif
                                    
                                    <div class="menu-item px-3">
                                        <a href="{{ route('admin.invoice.print', ['id' => $inv->id]) }}" class="menu-link px-3">View</a>
                                    </div>
                                    <div class="menu-item px-3">
                                        <a href="javascript:void(0);" data-id="{{ $inv->id }}" onclick="removeRecord(this);" class="menu-link px-3">Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <form action="{{ route('admin.invoice.delete') }}" method="POST" class="d-none" id="deleteForm">
                    @csrf
                    <input type="hidden" name="delete_trace" value="">
                </form>
            </div>
        </div>
    </div>

    <!-- Finalize Invoice Modal -->
    <div class="modal fade" id="finalizeInvModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header d-flex flex-row-reverse ribbon ribbon-start ribbon-clip">
                    <div class="ribbon-label fw-bolder">
                        Settle Down
                        <span class="ribbon-inner bg-success"></span>
                    </div>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary w-5 float-end" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                            {!! getSvg('arr061') !!}
                        </span>
                    </div>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary w-95 float-end">
                        <h2 class="fw-bolder">Finalize Invoice</h2>
                    </div>
                </div>
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <form action="{{ route('admin.invoice.finalize') }}" method="POST">
                        @csrf
                        <div class="form-body">
                            <div class="row">
                                <div class="form-group col-md-12 mb-7">
                                    <label>Amount</label>
                                    <input type="text" name="f_amount" class="form-control form-control-solid" placeholder="Amount..." disabled>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12 mb-7">
                                    <label>Payment Date</label>
                                    <input type="text" name="f_date" class="form-control form-control-solid" placeholder="Payment Date..." disabled>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12 mb-7">
                                    <div class="collapse" id="totalAfter">
                                        <label>Amount After Deduction:</label>
                                        <input type="number" name="total_w_factoring" class="form-control form-control-solid" min="0" step=".01" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>
                                        <input type="checkbox" name="include_factoring" value="1" data-bs-toggle="collapse" data-bs-target="#totalAfter" aria-expanded="false" aria-controls="totalAfter"> 
                                        Apply $<span class="fw-bold" id="factoringFeeAmount">0.00</span> As Factoring Fee({{ siteSetting('factoring') }}%)
                                    </label>
                                        
                                    <input type="hidden" name="factoring_fee" value="">
                                    <input type="hidden" name="f_id" value="">
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

    <!-- Export Invoice Range Modal -->
    <div class="modal fade" id="exportInvoiceRange" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header d-flex flex-row-reverse ribbon ribbon-start ribbon-clip">
                    <div class="ribbon-label fw-bolder">
                        Date Range
                        <span class="ribbon-inner bg-success"></span>
                    </div>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary w-5 float-end" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                            {!! getSvg('arr061') !!}
                        </span>
                    </div>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary w-95 float-end">
                        <h2 class="fw-bolder">Export Bulk Invoices</h2>
                    </div>
                </div>
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <div class="alert alert-primary" role="alert">
                        <p>
                            <i class="fas fa-info-circle text-primary"></i>
                            <b>Note</b>: This process can take a few seconds to several minutes depending on the time period selected and the number of invoices being processed and exported. Please be patient.
                            <hr>
                            <small class="fst-italic">The file size also depends upon the total number of invoices being exported!</small>
                        </p>
                    </div>
                    <form action="{{ route('admin.invoice.export') }}" method="POST" onsubmit="exportBulk();">
                        @csrf
                        <div class="form-body">
                            <div class="row">
                                <div class="form-group col-md-12 mb-7">
                                    <label>Date From</label>
                                    <input type="date" name="from" class="form-control form-control-solid" onchange="fetchInvoicesCount('{{ route('admin.invoice.count') }}');" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12 mb-7">
                                    <label>Date To</label>
                                    <input type="date" name="to" class="form-control form-control-solid" onchange="fetchInvoicesCount('{{ route('admin.invoice.count') }}');" required>
                                </div>
                            </div>
                        </div>

                        <p id="msgInvoices"></p>
    
                        <div class="text-center pt-5">
                            <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Close</button>
                            
                            <button type="button" class="btn btn-success" data-kt-modules-modal-action="submit" id="continueBtn" onclick="selectInvoices('{{ route('admin.invoice.count') }}');">
                                <span class="indicator-label">Continue</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Select Invoices Modal -->
    <div class="modal fade" id="selectInvoicesModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex flex-row-reverse ribbon ribbon-start ribbon-clip">
                    <div class="ribbon-label fw-bolder">
                        Select
                        <span class="ribbon-inner bg-success"></span>
                    </div>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary w-5 float-end" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                            {!! getSvg('arr061') !!}
                        </span>
                    </div>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary w-95 float-end">
                        <h2 class="fw-bolder">Invoices from <b id="dtFrm"></b> to <b id="dtTo"></b></h2>
                    </div>
                </div>
                <div class="modal-body scroll-y mx-5 my-7">
                    <form action="{{ route('admin.invoice.export') }}" method="POST" onsubmit="exportBulk();">
                        @csrf
                        <div class="table-responsive">
                            <table class="table align-middle table-row-dashed fs-6 gy-5 table-hover" id="sel-inv">
                                <thead>
                                    <tr class="text-start fw-bolder fs-7 text-uppercase gs-0">
                                        <th></th>
                                        <th class="min-w-125px">Invoice Number</th>
                                        <th class="min-w-125px">Load Number</th>
                                        <th class="min-w-125px">Customer Name</th>
                                        <th class="min-w-125px">Date</th>
                                        <th class="min-w-125px">Amount</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600 fw-bold">
                                    @foreach($notBatchedInvoices as $notBatched)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="invoices[]" value="{{ $notBatched->id }}">
                                        </td>
                                        <td>{{ $notBatched->invoice_number }}</td>
                                        <td>{{ $notBatched->loadPlanner->load_number }}</td>
                                        <td>{{ $notBatched->customer->name }}</td>
                                        <td>{{ ($notBatched->date)? date_format(new Carbon\Carbon($notBatched->date), "M d, Y") : 'N/A' }}</td>
                                        <td>${{ number_format($notBatched->total_amount, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
    
                        <div class="text-center pt-15">
                            <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Close</button>
    
                            <button type="submit" class="btn btn-success" data-kt-modules-modal-action="submit">
                                <span class="indicator-label">Generate</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Modal -->
    <div class="modal fade" id="loadingModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center" style="background-color: #fcdfcd; color: #bb794f;">
                    <img src="https://cdn.dribbble.com/users/101577/screenshots/4871767/hello-3-3.gif" alt="loading..." class="img-fluid">
                    <h2 style="color: #bb794f;">Processing...</h2>
                    <p>The system is generating your PDF file, it may take several minutes depending on your selected time period and the total invoices that period contains. Please wait!</p>
                </div>
            </div>
        </div>
    </div>

    <a href="" id="downloadFile" class="d-none" download></a>
</div>
@endsection

@section('scripts')
<script>
    let generateInv = (elem, url)=>{
        let loadId = $(elem).val();

        if(loadId){
            $('#redirectGenerate').attr('href', url+'/'+$(elem).val());
        } else{
            $('#redirectGenerate').attr('href', 'javascript:void(0);');
        }
    }

    let showFinalizeModal = obj => {
        $('input[name=f_amount]').val(obj.amount);
        $('input[name=f_date]').val(obj.date);
        $('#factoringFeeAmount').html(obj.factoring_fee_amount);

        $('input[name=factoring_fee]').val(obj.factoring_fee);
        $('input[name=total_w_factoring]').val(obj.total_w_factoring);
        $('input[name=f_id]').val(obj.id);

        $('#finalizeInvModal').modal('show');
    }

    let confirmPaid = formId => {
        Swal.fire({
            text: "You're about to mark this invoice as paid?",
            icon: "warning",
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: "Yes, it's paid!",
            cancelButtonText: "No, leave it",
            customClass: {
                confirmButton: "btn fw-bold btn-success",
                cancelButton: "btn fw-bold btn-active-light-primary"
            }
        }).then(function (result) {
            if (result.value) {
                $(`#${formId}`).trigger('submit');
            } else if (result.dismiss === 'cancel') {
                Swal.fire({
                    text: "The invoice is not paid!",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn fw-bold btn-success",
                    }
                });
            }
        });
    }

    let fetchInvoicesCount = url => {
        let from = $("input[name=from]").val();
        let to = $("input[name=to]").val();
        let btn = $('#continueBtn');

        $('#msgInvoices').html('');

        if(from && to){
            btn.attr('disabled');
            btn.html(`<i class="fas fa-spinner fa-pulse p-0"></i>`);

            $.ajax({
                url,
                type: 'GET',
                data: {from, to, count: 1},
                success: (res)=>{
                    $('#msgInvoices').html(`Total <b>${res.count}</b> invoices are available to import in your selected period!`);
                },
                error: (err)=>{
                    $('#msgInvoices').html('');
                    console.error(err);
                },
                complete: ()=>{
                    btn.removeAttr('disabled');
                    btn.html('Continue');
                }
            });
        }
    }

    let selectInvoices = url => {
        let from = $("input[name=from]").val();
        let to = $("input[name=to]").val();
        let btn = $('#continueBtn');
        let _html = btn.html();
        
        btn.html(`<i class="fas fa-spinner fa-pulse p-0"></i>`);
        btn.attr('disabled', true);
        
        $.ajax({
            url,
            type: 'GET',
            data: {from, to, count: 0},
            success: (res)=>{
                if(res.status){
                    $('#exportInvoiceRange').modal('hide');

                    let tbody = $('#sel-inv').find('tbody');

                    tbody.html('');

                    if(res.data.length){
                        res.data.map(function(arr){
                            tbody.append(`<tr>
                                <td>
                                    <input type="checkbox" name="invoices[]" value="${arr.id}">
                                </td>
                                <td>
                                    ${arr.invoice_number}
                                </td>
                                <td>
                                    ${arr.load_number}
                                </td>
                                <td>
                                    ${arr.customer_name}
                                </td>
                                <td>
                                    ${arr.date}
                                </td>
                            </tr>`);
                        });
                    } else{
                        tbody.append(`<tr>
                            <td colspan="5" class="text-center">Something is not right. The system doesn't know what happend actually!</td>
                        </tr>`);
                    }

                    $('#dtFrm').html(from);
                    $('#dtTo').html(to);

                    $('#selectInvoicesModal').modal('show');
                } else{
                    alert('Error: something went wrong!');
                }
            },
            error: (err)=>{
                console.error(err);
            },
            complete: ()=>{
                btn.html(_html);
                btn.attr('disabled', false);
            }
        });

        return false;
    }

    let exportBulk = () => {
        $('#selectInvoicesModal').modal('hide');
        $('#loadingModal').modal('show');

        let cookieChecker = window.setInterval(() => {
            let parts = document.cookie.split("download_token=");

            if(parts.length == 2){
                let download = parts.pop().split(";").shift();

                if(download){
                    $('#loadingModal').modal('hide');

                    clearInterval(cookieChecker);
                    return true;
                }
            }
        }, 900);
    }
</script>
@endsection