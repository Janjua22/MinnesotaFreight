@extends('layouts.admin.master')

@section('styles')
<style>
    .select2-container--bootstrap5 .select2-dropdown .select2-results__option.select2-results__option--disabled{
        color: #f1416c !important;
    }
</style>
@endsection

@section('content')
@php
    $titles=[
        'title' => "Driver Settlements",
        'sub-title' => "Add",
        'btn' => "Driver Settlements List",
        'url' => route('admin.driverSettlement')
    ];
@endphp

@include('admin.components.top-bar', $titles)

<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-xxl">
        <!--begin::Alert-->
        @include('admin.components.alerts')
        <!--end::Alert-->

        <div class="d-flex flex-column flex-lg-row">
            <div class="flex-lg-row-fluid mb-10 mb-lg-0 me-lg-7 me-xl-10">
                <div class="card">
                    <div class="card-body p-12">
                        <form action="{{ route('admin.driverSettlement.checkTrips') }}" method="POST" onsubmit="return generateSettlement(this);" id="form1">
                            @csrf
                                <div class="alert alert-info" role="alert">
                                    <h4 class="alert-heading"><i class="fas fa-info-circle text-info"></i> Quick Info:</h4>
                                    <p>Only the <span class="badge badge-success">completed</span> loads of the selected driver will show up in the list.</p>
                                    <hr>
                                    <small class="mb-0 fst-italic">If you have just created a new load it will not be available to settle down till you mark it as completed!</small>
                                </div>

                                     <label>Driver <sup class="text-danger">*</sup></label>
                                        <select name="driver_id" class="form-control form-select driver_id form-select-solid @error('driver_id') is-invalid border-danger @enderror"  data-placeholder="Select Driver" required>
                                            <option value="">Select Driver</option>
                                            @foreach($drivers as $driver)
                                           <option style="color:#000;" value="{{ $driver->id }}">{{ $driver->first_name }} {{ $driver->last_name }}</option>
                                            @endforeach
                                    </select>


                             <div class="text-center pt-8">
                            <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Close</button>

                            <button type="submit" class="btn btn-success" data-kt-modules-modal-action="submit" id="button1">
                                <span class="indicator-label">Submit</span>
                            </button>
                        </div>
                      </form>
                      <form action="{{ route('admin.driverSettlement.add') }}" method="POST" style="display:none;" id="form2">
                        @csrf
                        <input type="hidden" name="driver_id" value="" id="drvrId">

                        <div class="table-responsive">
                            <table class="table align-middle table-row-dashed fs-6 gy-5 table-hover" id="sel-trips">
                                <thead>
                                    <tr class="text-start fw-bolder fs-7 text-uppercase gs-0">
                                      <th class="min-w-125px"><input type="checkbox" id="checkAll">  Check All</th>
                                        <th class="min-w-125px">Load Number</th>
                                        <th class="min-w-125px">Truck Number</th>
                                        <th class="min-w-125px">Pickups</th>
                                        <th class="min-w-125px">Consignees</th>
                                        <th class="min-w-125px">Freight Amount</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600 fw-bold">

                                </tbody>
                            </table>
                        </div>

                        <div class="text-center pt-15">
                            <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Close</button>

                            <button type="submit" class="btn btn-success" data-kt-modules-modal-action="submit" id="button2">
                                <span class="indicator-label">Generate</span>
                            </button>
                        </div>
                    </form>
                   </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Customer/Location Modal -->
    @include('admin.components.customer-add-modal')

</div>
@endsection

@section('scripts')
<script>

    $('.driver_id').selectize();
    $("#checkAll").click(function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });
 let generateSettlement = elem => {
       $("#form2").css("display", "none");
        let btn = $('#button1');
        let _html = btn.html();
        // let btn = $('button[type=submit]');
        // let _html = btn.html();

        btn.html(`<i class="fas fa-spinner fa-pulse"></i> Checking Records...`);
        btn.attr('disabled', true);

        $.ajax({
            url: $(elem).attr('action'),
            type: 'POST',
            data: $(elem).serialize(),
            success: (res)=>{
                if(res.status){
                    $('#generateSettlmentModal').modal('hide');

                    let tbody = $('#sel-trips').find('tbody');

                    tbody.html('');

                    if(res.data.loads.length){
                        res.data.loads.map(function(arr){
                            tbody.append(`<tr>
                                <td>
                                    <input type="checkbox" name="loads[]" value="${arr.load_id}">
                                </td>
                                <td>
                                    <a href="${arr.load_url}" target="_blank">${arr.load_number}</a>
                                </td>
                                <td>
                                    ${arr.truck_number}
                                </td>
                                <td>
                                    ${(arr.pickups.length > 1)? arr.pickups[0]+', <small class=\"text-warning\">+'+ (arr.pickups.length-1) +' more</small>' : arr.pickups[0]}
                                </td>
                                <td>
                                    ${(arr.consignees.length > 1)? arr.consignees[0]+', <small class=\"text-warning\">+'+ (arr.consignees.length-1) +' more</small>' : arr.consignees[0]}
                                </td>
                                <td>
                                    $${arr.freight_amount} <span class="badge badge-light-primary fw-light">${arr.freight_type}</span>
                                </td>
                            </tr>`);
                        });
                    } else{
                        tbody.append(`<tr>
                            <td colspan="6" class="text-center">The reason you're not seeing any data because, loads are available but not invoiced yet!</td>
                        </tr>`);
                    }

                    $('#drvrId').val(res.data.driver_id);
                    $('#drvrNmHead').html(res.data.driver_name);

                    // $('#selectTripsModal').modal('show');
                     $("#form2").css("display", "block");
                } else{
                    toastr["error"]("No un-settled loads found for this driver!");
                }
            },
            error: (err)=>{
                if(err.status == 422){
                    let msgHtml = `<p>${err.responseJSON.message}</p><br><ul>`;

                    let obj =  err.responseJSON.errors;

                    for (var i in obj) {
                        if (obj.hasOwnProperty(i)) {
                            msgHtml += `<li>${obj[i]}</li>`;
                        }
                    }

                    msgHtml += `</ul>`;

                    toastr["error"](msgHtml)
                } else{
                    toastr["error"]("An unknown error occured while submitting your form.");
                }

                console.error(err);
            },
            complete: ()=>{
                btn.html(_html);
                btn.attr('disabled', false);
            }
        });

        return false;
    }


let populateForm = id => {
        $('#completeForm input[name=id]').val(id);
        $('#completeForm').submit();
    }
  $('#generateSettlmentModal').on('hidden.bs.modal', function () {
         $("#form2").css("display", "none");
          $("#driver_id")[0].selectedIndex = 0;
    });
</script>
@endsection
