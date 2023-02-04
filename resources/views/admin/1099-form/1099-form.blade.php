@extends('layouts.admin.master')

@section('styles')
<style>
    .table tfoot tr:last-child th, .table tfoot tr:last-child td, .table tbody tr:last-child th, .table tbody tr:last-child td{
        border-bottom: 1px solid #f1416c !important;
    }
    .table tr:first-child, .table th:first-child, .table td:first-child{
        padding-left: 0.75rem;
        padding-right: 0.75rem;
    }
    .table td{
        border: 1px solid #f1416c !important;
    }
</style>
@endsection

@section('content')
@php 
    $titles=[
        'title' => "1099 FORM",
        'sub-title' => "",
        'btn' => null,
        'url' => null
    ];
@endphp

@include('admin.components.top-bar', $titles)

<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-xxl">
        <div class="row g-5 g-xl-8">
            <div class="col-xl-12">
                <div class="card card-xl-stretch mb-5 mb-xl-8">
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bolder fs-3 mb-1">1099 FORM</span>
                            <span class="text-muted fw-bold fs-7">Detail of the 1099 Form of a driver</span>
                        </h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.taxForm') }}" method="GET">
                            <div class="row">
                                <div class="form-group col-md-5 mb-7">
                                    <label>Driver <sup class="text-danger">*</sup></label>
                                    <select name="driver" class="form-control form-select form-select-solid @error('driver') is-invalid border-danger @enderror" data-control="select2" data-placeholder="Select Driver" required>
                                        <option value="">Select Driver</option>
                                        @foreach ($drivers as $driver)
                                        <option value="{{ $driver->id }}" @if(request()->driver == $driver->id) selected @endif>{{ $driver->first_name." ".$driver->last_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-5 mb-7">
                                    <label>Year <sup class="text-danger">*</sup></label>
                                    <input type="number" name="year" value="{{ request()->year }}" class="form-control form-control-solid @error('year') is-invalid border-danger @enderror" placeholder="year (20xx)..." required>
                                </div>
                                <div class="form-group form-group col-md-2 mt-6 mb-2">
                                    <button type="submit" class="btn btn-success w-100">
                                        <i class="fas fa-search"></i> Search
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        @if($taxData && request()->driver)
        <div class="row g-5 g-xl-8">
            <div class="col-xl-12">
                <div class="card card-xl-stretch mb-5 mb-xl-8">
                    <div class="card-body">
                        <table class="table border-danger text-danger">
                            <tr>
                                <td colspan="4" rowspan="3">
                                    <p>PAYER's name, street address, city or town, state or province, country, ZIP or foreign postal code and telephone no.</p>
                                    <h2 class="text-danger">
                                        {{ siteSetting('title') }}
                                    </h2>
                                    <p><b>{{ siteSetting('address') }}</b></p>
                                </td>
                                <td colspan="3">
                                    <p><b>1. Rents</b></p>
                                    <h2 class="text-danger">$</h2>
                                </td>
                                <td colspan="2" rowspan="2">
                                    <p><b>OMB No. 1545-0115</b></p>
                                    <h1 class="display-3 text-danger">{{ request()->year }}</h1>
                                    <p>Form <b>1099-MISC</b></p>
                                </td>
                                <td colspan="3" rowspan="2">
                                    <h2 class="text-danger">Miscellaneous Income</h2>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <p><b>2. Royalties</b></p>
                                    <h2 class="text-danger">$</h2>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <p><b>3. Other income</b></p>
                                    <h2 class="text-danger">$</h2>
                                </td>
                                <td colspan="3">
                                    <p><b>4. Federal income tax withheld</b></p>
                                    <h2 class="text-danger">$</h2>
                                </td>
                                <td colspan="2" rowspan="2">
                                    <h2 class="text-danger">Copy A For Internal Revenue Service Center File with form 1096.</h2>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2" class="px-0">
                                    <p>PAYER's TIN</p>
                                    <h2 class="p-2 bg-light-danger text-danger">12-1234567</h2>
                                </td>
                                <td colspan="2" class="px-0">
                                    <p>RECIPIENT's TIN</p>
                                    <h2 class="p-2 bg-light-danger text-danger">SSN or EIN</h2>
                                </td>
                                <td colspan="3" class="px-0">
                                    <p><b>5. Fishing boat proceeds</b></p>
                                    <h2 class="p-2 bg-light-danger text-danger">$</h2>
                                </td>
                                <td colspan="3" class="px-0">
                                    <p><b>6. Medical and healthcare payments</b></p>
                                    <h2 class="p-2 bg-light-danger text-danger">$</h2>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="4">
                                    <p>RECIPIENT's name</p>
                                    <h2 class="text-danger">{{ $taxData['name'] }}</h2>
                                </td>
                                <td colspan="3">
                                    <p><b>7. Nonemployee compensation</b></p>
                                    <h2 class="text-danger">${{ $taxData['settlement'] }}</h2>
                                </td>
                                <td colspan="3">
                                    <p><b>8. Substitute payment in lieu of dividends or interest</b></p>
                                    <h2 class="text-danger">$</h2>
                                </td>
                                <td colspan="2" rowspan="4">
                                    <h3 class="text-danger">For privacy act and paperwork reduction act notice, see the 2019 general instructions for certain information returns.</h3>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <p>Street address (including apt no.)</p>
                                    <h2 class="text-danger">{{ $taxData['street'] }}</h2>
                                </td>
                                <td colspan="3">
                                    <p>
                                        <b>9. Payer made direct sales of $5000 or more of consumer products to a buyer (recipient) for resale</b> 
                                        <i class="fas fa-caret-right text-danger"></i>
                                        <i class="far fa-square text-danger fs-3"></i>
                                    </p>
                                </td>
                                <td colspan="3">
                                    <b>10. Crop insurance proceeds</b>
                                    <h2 class="text-danger">$</h2>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <p>City or Town, State or Province, Country and ZIP or foreign postal code</p>
                                    <h2 class="text-danger">{{ $taxData['address'] }}</h2>
                                </td>
                                <td colspan="3">
                                    <b>11. </b>
                                </td>
                                <td colspan="3">
                                    <b>12. </b>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <p>Account Number (see instructions)</p>
                                    <h2 class="text-danger"></h2>
                                </td>
                                <td>
                                    <p>FATCA filing requirement</p>
                                    <i class="far fa-square text-danger fs-3"></i>
                                </td>
                                <td>
                                    <p>2nd TIN not.</p>
                                    <i class="far fa-square text-danger fs-3"></i>
                                </td>
                                <td colspan="3">
                                    <b>13. Excess golden parachute paymenta</b>
                                    <h2 class="text-danger">$</h2>
                                </td>
                                <td colspan="3">
                                    <b>14. Gross proceeds paid to an attorney</b>
                                    <h2 class="text-danger">$</h2>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <p><b>15a. Section 409A deferrals</b></p>
                                    <h2 class="text-danger">$</h2>
                                </td>
                                <td colspan="2">
                                    <p><b>15b. Section 409A income</b></p>
                                    <h2 class="text-danger">$</h2>
                                </td>
                                <td colspan="3">
                                    <p><b>16. State tax withheld</b></p>
                                    <h2 class="text-danger border-bottom-dashed">$</h2>
                                    <h2 class="text-danger">$</h2>
                                </td>
                                <td colspan="3">
                                    <p><b>17. State/payer's state no.</b></p>
                                    <h2 class="text-danger border-bottom-dashed">$</h2>
                                    <h2 class="text-danger">$</h2>
                                </td>
                                <td colspan="2">
                                    <p><b>18. State income</b></p>
                                    <h2 class="text-danger border-bottom-dashed">$</h2>
                                    <h2 class="text-danger">$</h2>
                                </td>
                            </tr>
                        </table>

                        <p class="text-danger">Form <span class="h2 text-danger">1099-MISC</span></p>
                    </div>
                </div>
            </div>
        </div>
        @elseif($taxData == null && request()->driver)
        <div class="text-center pt-10">
            <i class="far fa-address-card fa-5x text-muted mb-2"></i>
            <h2 class="text-muted">Insufficient Data</h2>
            <p class="text-muted">System does not have enough data to calculate for 1099-MISC Form.</p>
        </div>
        @endif
    </div>
</div>
@endsection