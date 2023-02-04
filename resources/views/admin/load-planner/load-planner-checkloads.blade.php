@extends('layouts.admin.master')

@section('styles')

<style>
    .select2-container--bootstrap5 .select2-dropdown .select2-results__option.select2-results__option--disabled{
        color: #f1416c !important;
    }
	
	.selectize-control .selectize-input{
		height:auto;
		padding:10px 15px;
	}
</style>
@endsection

@section('content')
@php 
    $titles=[
        'title' => "Drivers Load",
        'sub-title' => "Mark Completed",
        'btn' => "Load Planners List",
        'url' => route('admin.loadPlanner')
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
                        <form action="{{ route('admin.loadPlanner.checkLoad') }}" method="POST" onsubmit="return generateSettlement(this);" id="form1">
                            @csrf
                               
                                    
                                     <label>Driver <sup class="text-danger">*</sup></label>
                                        <select name="driver_id" class="form-control form-select form-select-solid @error('driver_id') is-invalid border-danger @enderror"  required>
                                            <option value="">Select Driver</option>
                                            @foreach($drivers as $driver)
                                           <option value="{{ $driver->id }}">{{ $driver->first_name }} {{ $driver->last_name }}</option>
                                            @endforeach
                                    </select>
                                   

                             <div class="text-center pt-8">
                            <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Close</button>
    
                            <button type="submit" class="btn btn-success" data-kt-modules-modal-action="submit" id="button1">
                                <span class="indicator-label">Search</span>
                            </button>
                        </div>
                      </form>
                      <form action="{{ route('admin.loadPlanner.Allcompleted') }}" method="POST" style="display:none;" id="form2">
                        @csrf
                        <input type="hidden" name="driver_id" value="" id="drvrId">

                        <div class="table-responsive">
                            <table class="table align-middle table-row-dashed fs-6 gy-5 table-hover" id="sel-trips">
                                <thead>
                                    <tr class="text-start fw-bolder fs-7 text-uppercase gs-0">
                                        <th><input type="checkbox" class="check-input" name="checked" value="1" /></th>
                                        <th class="min-w-125px">Load Number</th>
                                        <th class="min-w-125px">Customer Name</th>
                                        <th class="min-w-125px">Truck Number</th>
                                        <th class="min-w-125px">Driver</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600 fw-bold">
                            
                                </tbody>
                            </table>
                        </div>
    
                        <div class="text-center pt-15">
                            <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Close</button>
    
                            <button type="submit" class="btn btn-success" data-kt-modules-modal-action="submit" id="button2">
                                <span class="indicator-label">Mark as Completed</span>
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
	$(document).ready(function() {
        $('select').selectize();
    });
    let generateSettlement = elem => {
          $("#form2").css("display", "none");
        let btn = $('#button1');
        let _html = btn.html();
        
        btn.html(`<i class="fas fa-spinner fa-pulse"></i> Checking Records...`);
        btn.attr('disabled', true);
        
        $.ajax({
            url: $(elem).attr('action'),
            // alert($(elem).attr('action'));
            type: 'POST',
            data: $(elem).serialize(),
            success: (res)=>{
                if(res.status){
                    // $('#generateSettlmentModal').modal('hide');

                    let tbody = $('#sel-trips').find('tbody');

                    tbody.html('');

                    if(res.data.loads.length){
                        res.data.loads.map(function(arr){
                            tbody.append(`<tr>
                                <td>
                                    <input type="checkbox" class="check-input"  id="checkAll"  name="loads[]" value="${arr.id}">
                                </td>
                                <td>
                                  ${arr.load_number}
                                </td>
                                <td>
                                    ${arr.name}
                                </td>
                                <td>
                                     ${arr.truck_number}
                                </td>
                                <td>
                                     ${arr.first_name}  ${arr.last_name} 
                                </td>
                               
                            </tr>`);
                        });
						
	
                    } else{
                        tbody.append(`<tr>
                            <td colspan="6" class="text-center">The reason you're not seeing any data because, loads are available but not invoiced yet!</td>
                        </tr>`);
                    }

                    // $('#drvrId').val(res.data.driver_id);
                    // $('#drvrNmHead').html(res.data.driver_name);
                    $("#form2").css("display", "block");
                    // $('#selectTripsModal').modal('show');
                } else{
                    toastr["error"]("No new loads found for this driver!");
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
	
	
	
	var numberOfChildCheckBoxes = $('.check-input').length;
	
	$('.check-input').change(function() {
	  var checkedChildCheckBox = $('.check-input:checked').length;
	  if (checkedChildCheckBox == numberOfChildCheckBoxes)
		$(".check-input").prop('checked', true);
	  else
		$(".check-input").prop('checked', false);
	});
</script>
@endsection