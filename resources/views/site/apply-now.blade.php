@extends('layouts.master-site')

@section('content')
<!-- Breadcrumbs Section Start -->
<div class="rs-breadcrumbs bg-3">
    <div class="container">
        <div class="content-part text-center breadcrumbs-padding">
            <h1 class="breadcrumbs-title white-color mb-0 txt-shadow">Apply Now</h1>
        </div>
    </div>
</div>
<!-- Breadcrumbs Section End -->

<div class="content-body regibg">
    <section id="form-action-layouts">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto box-shadow-2 p-0 align-items-center justify-content-center mt-5 mb-50">
                    <div class="card px-0 pt-4 pb-0 mt-3 mb-0 regi-side">
                        <h2 class="text-center mt-20 mb-30"><strong>Driver Application</strong></h2>
                        <div class="row">
                            <div class="col-md-12">
                                <form action="{{ route('site.apply.create') }}" method="POST" id="msform" class="form register-form" onsubmit="return applicationSubmit(this);">
                                    @csrf

                                    <!-- progressbar -->
                                    <ul id="progressbar">
                                        <li class="active"></li>
                                        <li></li>
                                        <li></li>
                                        <li></li>
                                        <li></li>
                                        <li></li>
                                    </ul>

                                    <!-- fieldsets -->
                                    <fieldset>
                                        <div class="card-body">
                                            <h4 class="form-section">Basic Infromation</h4>
                                            <div class="row">
                                                <div class="form-group col-md-6 mb-2">
                                                    <label>Name</label>
                                                    <input type="text" name="name" class="form-control" placeholder="..." required>
                                                </div>
                                                <div class="form-group col-md-6 mb-2">
                                                    <label>Date</label>
                                                    <input type="date" name="date" class="form-control" placeholder="Emergency Contact Phone..." required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6 mb-2">
                                                    <label>Company applying to</label>
                                                    <input type="text" name="company_apply" class="form-control" placeholder="..." required>
                                                </div>
                                                <div class="form-group col-md-6 mb-2">
                                                    <label>Position(s) applied for <sup class="text-danger">*</sup></label>
                                                    <select name="position"  class="form-control" required>
                                                        <option value="">Select Position</option>
                                                        <option value="Driver">Driver</option>
                                                        <option value="Assistant">Assistant</option>
                                                        <option value="Technician">Technician</option>
                                                        <option value="Support Officer">Support Officer</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-12 mb-2">
                                                    <p>
                                                        Per FMCSA’s 391.23 (investigation and inquiries), subpart
                                                        (J): (Driver) I understand that I have the right to: Review
                                                        information provided by current/previous employers: Have
                                                        errors in the information corrected by previous employers
                                                        and for those previous employers to re-send the corrected
                                                        information to the prospective employer; and have a rebuttal
                                                        statement attached to the alleged erroneous information, if
                                                        the previous employer(s) and cannot agree on the accuracy of
                                                        the information.<br><br>In compliance with Federal and State
                                                        equal employment opportunity laws, qualified applicants are
                                                        considered for all positions without regard to race, color,
                                                        religion, sex, national origin, age, marital status, or the
                                                        presence of a non-job related medical condition or handicap.
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6 mb-2">
                                                    <label>Referred by</label>
                                                    <input type="text" name="referred_by" class="form-control" placeholder="..." required>
                                                </div>
                                                <div class="form-group col-md-6 mb-2">
                                                    <label>Social Security</label>
                                                    <input type="text" name="ssn" class="form-control" placeholder="..." required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6 mb-2">
                                                    <label>Date of Birth</label>
                                                    <input type="date" name="dob" class="form-control" placeholder="..." required>
                                                </div>
                                                <div class="form-group col-md-6 mb-2">
                                                    <label>Address</label>
                                                    <input type="text" name="full_address" class="form-control" placeholder="..." required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6 mb-2">
                                                    <label>State</label>
                                                    <select name="state_id" class="form-control" onchange="fetchCitiesByState(this, 'city_id', '{{ url('/') }}');" required>
                                                        <option value="">Select State</option>
                                                        @foreach($STATES as $state)
                                                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6 mb-2">
                                                    <label>City</label>
                                                    <div></div>
                                                    <select name="city_id" class="form-control" required>
                                                        <option value="">Select City</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6 mb-2">
                                                    <label>CDL</label>
                                                    <input type="text" name="cdl" class="form-control" placeholder="..." required>
                                                </div>
                                                <div class="form-group col-md-6 mb-2">
                                                    <label>CDL Expiration</label>
                                                    <input type="date" name="cdl_expiry" class="form-control" placeholder="..." required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6 mb-2">
                                                    <label>Home Phone</label>
                                                    <input type="text" name="home_phone" class="form-control" placeholder="..." required>
                                                </div>
                                                <div class="form-group col-md-6 mb-2">
                                                    <label>Work Phone</label>
                                                    <input type="text" name="work_phone" class="form-control" placeholder="..." required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6 mb-2">
                                                    <label>Cellphone</label>
                                                    <input type="text" name="cell_phone" class="form-control" placeholder="..." required>
                                                </div>
                                                <div class="form-group col-md-6 mb-2">
                                                    <label>Email</label>
                                                    <input type="email" name="email" class="form-control" placeholder="..." required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6 mb-2">
                                                    <label>Emergency Contact Name</label>
                                                    <input type="text" name="em_name" class="form-control" placeholder="..." required>
                                                </div>
                                                <div class="form-group col-md-6 mb-2">
                                                    <label>Emergency Telephone</label>
                                                    <input type="text" name="em_phone" class="form-control" placeholder="..." required>
                                                </div>
                                            </div>
                                        </div>

                                        <input type="button" name="next" class="next action-button readon" value="Next Step >">
                                    </fieldset>

                                    <fieldset>
                                        <div class="card-body">
                                            <h4 class="form-section">Address For Past 3 Years</h4>
                                            <div class="row">
                                                <div class="form-group col-md-9 mb-2">
                                                    <label>Address # 1</label>
                                                    <input type="text" name="address[]" class="form-control" placeholder="..." required>
                                                </div>
                                                <div class="form-group col-md-3 mb-2">
                                                    <label>How long (in months)</label>
                                                    <input type="number" name="how_long[]" class="form-control" placeholder="..." required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-9 mb-2">
                                                    <label>Address # 2</label>
                                                    <input type="text" name="address[]" class="form-control" placeholder="..." required>
                                                </div>
                                                <div class="form-group col-md-3 mb-2">
                                                    <label>How long (in months)</label>
                                                    <input type="number" name="how_long[]" class="form-control" placeholder="..." required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6 mb-2 mirgradio">
                                                    <label>Do you have the legal right to work in the U.S.?</label>
                                                    <span>
                                                        <input class="radio-btn" type="radio" name="right_to_work" id="right_to_work_y" value="1" required>
                                                        <label class="d-inline ml-1" for="right_to_work_y">Yes</label>
                                                    </span>
                                                    <span>
                                                        <input class="radio-btn" type="radio" name="right_to_work" id="right_to_work_n" value="0" required>
                                                        <label class="d-inline ml-1" for="right_to_work_n">No</label>
                                                    </span>
                                                </div>
                                                <div class="form-group col-md-6 mb-2 mirgradio">
                                                    <label>Are you presently working?</label>
                                                    <span>
                                                        <input class="radio-btn" type="radio" name="working" id="working_y" value="1" onchange="togglefields(this, 'sinceLastJob', 1)" required>
                                                        <label class="d-inline ml-1" for="working_y">Yes</label>
                                                    </span>
                                                    <span>
                                                        <input class="radio-btn" type="radio" name="working" id="working_n" value="0" required onchange="togglefields(this, 'sinceLastJob', 1)">
                                                        <label class="d-inline ml-1" for="working_n">No</label>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="row" id="sinceLastJob" style="display: none;">
                                                <div class="form-group col-md-12 mb-2">
                                                    <label>How long since last job? (in months)</label>
                                                    <input type="number" name="since_job" class="form-control" placeholder="...">
                                                </div>
                                            </div>

                                            <h4 class="form-section">Physical History</h4>
                                            <div class="row">
                                                <div class="form-group col-md-6 mb-2 mirgradio">
                                                    <label>Do you have any physical condition which may limit your ability to perform the job applied for?</label>
                                                    <span>
                                                        <input class="radio-btn" type="radio" name="physical_condition" id="physical_condition_y" value="1" onchange="togglefields(this, 'medicalCondition', 0)" required>
                                                        <label class="d-inline ml-0" for="physical_condition_y">Yes</label>
                                                    </span>
                                                    <span>
                                                        <input class="radio-btn" type="radio" name="physical_condition" id="physical_condition_n" value="0" onchange="togglefields(this, 'medicalCondition', 0)" required>
                                                        <label class="d-inline ml-0" for="physical_condition_n">No</label>
                                                    </span>
                                                </div>
                                                <div class="form-group col-md-6 mb-2 mirgradio">
                                                    <label>Have you ever tested positive for drugs or alcohol as a commercial driver?</label>
                                                    <span>
                                                        <input class="radio-btn" type="radio" name="tested_drugs" id="tested_drugs_y" value="1" onchange="togglefields(this, 'testedPositive', 0)" required>
                                                        <label class="d-inline ml-1" for="tested_drugs_y">Yes</label>
                                                    </span>
                                                    <span>
                                                        <input class="radio-btn" type="radio" name="tested_drugs" id="tested_drugs_n" value="0" onchange="togglefields(this, 'testedPositive', 0)" required>
                                                        <label class="d-inline ml-1" for="tested_drugs_n">No</label>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="row" id="medicalCondition" style="display: none;">
                                                <div class="form-group col-md-12 mb-2">
                                                    <label>Please explain your physical condition</label>
                                                    <textarea class="custom-placeholder miselect" name="condition_explain" rows="2"></textarea>
                                                </div>
                                            </div>
                                            <div class="row" id="testedPositive" style="display: none;">
                                                <div class="form-group col-md-12 mb-2">
                                                    <label>When, mention year</label>
                                                    <input type="text" name="year_tested" class="form-control" placeholder="...">
                                                </div>
                                            </div>

                                            <h4 class="form-section">Experience And Qualifications - Driver</h4>
                                            <div class="row">
                                                <div class="form-group col-md-12 mb-2">
                                                    <label>Driver’s Licenses / Licensias (one per line)</label>
                                                    <textarea class="custom-placeholder miselect" name="license_lines" rows="2" placeholder="License Number, State, Type, Expiry Date"></textarea>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6 mb-2 mirgradio">
                                                    <label>Have you ever been denied a license, permit or privilege to operate a motor vehicle?</label>
                                                    <span>
                                                        <input class="radio-btn" type="radio" name="license_denied" id="license_denied_y" value="1" required>
                                                        <label class="d-inline ml-1" for="license_denied_y">Yes</label>
                                                    </span>
                                                    <span>
                                                        <input class="radio-btn" type="radio" name="license_denied" id="license_denied_n" value="0" required>
                                                        <label class="d-inline ml-1" for="license_denied_n">No</label>
                                                    </span>
                                                </div>
                                                <div class="form-group col-md-6 mb-2 mirgradio">
                                                    <label>Has any license, permit or privilege ever been suspended or revoked?</label>
                                                    <span>
                                                        <input class="radio-btn" type="radio" name="license_revoked" id="license_revoked_y" value="1" required>
                                                        <label class="d-inline ml-1" for="license_revoked_y">Yes</label>
                                                    </span>
                                                    <span>
                                                        <input class="radio-btn" type="radio" name="license_revoked" id="license_revoked_n" value="0" required>
                                                        <label class="d-inline ml-1" for="license_revoked_n">No</label>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6 mb-2">
                                                    <label>Commercial Motor Vehicle Driver Since</label>
                                                    <input type="text" name="driver_since" class="form-control" placeholder="..." required>
                                                </div>
                                                <div class="form-group col-md-6 mb-2">
                                                    <label>Years of Commercial Motor Vehicle experience</label>
                                                    <input type="number" name="years_experience" class="form-control" placeholder="..." required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-12 mb-2">
                                                    <label>Below, please list the type of Commercial Motor Vehicle experience you have had:</label>
                                                    <select name="vehicle_name[]" class="form-control js-example-basic-single" required multiple="multiple">
                                                        <option>Dry Van Truck</option>
                                                        <option>Car Carrier Truck</option>
                                                        <option>Off-Highway</option>
                                                        <option>Tractor-Semi Trailer</option>
                                                        <option>Crane Truck</option>
                                                        <option>Passenger Bus</option>
                                                        <option>Reefer</option>
                                                        <option>Transfer Truck</option>
                                                        <option>Plow Truck</option>
                                                        <option>Flatbed Truck</option>
                                                        <option>Expeditor/Hot Shot</option>
                                                        <option>Refuse Hauler</option>
                                                        <option>Dump Truck</option>
                                                        <option>Farm/Grain Truck</option>
                                                        <option>Roll-back Tow Truck</option>
                                                        <option>Tank Truck</option>
                                                        <option>Fire Truck</option>
                                                        <option>Salvage Truck</option>
                                                        <option>Beverage Truck</option>
                                                        <option>Fuel/Lube Truck</option>
                                                        <option>Service: Utility/Mechanic Truck</option>
                                                        <option>Bucket/Boom Truck</option>
                                                        <option>Logging Truck</option>
                                                        <option>Toter Truck</option>
                                                        <option>Cab & Chassis Truck</option>
                                                        <option>Low Boy</option>
                                                        <option>Tractor</option>
                                                        <option>Cabover Truck</option>
                                                        <option>Mixer: Asphalt/Concrete</option>
                                                        <option>Wrecker Tow Truck</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <input type="button" name="previous" class="previous action-button-previous readon" value="< Previous Step">
                                        <input type="button" name="next" class="next action-button readon" value="Next Step >">
                                    </fieldset>

                                    <fieldset>
                                        <div class="card-body">
                                            <h4 class="form-section">Accident Record</h4>
                                            <div class="row">
                                                <div class="form-group col-md-12 mb-2">
                                                    <label>Accident record for past 3 years: (one per line)</label>
                                                    <textarea name="accident_records" class="custom-placeholder miselect" rows="2" placeholder="Accident, Date, Type Of Accident, Fatalities, Injuries"></textarea>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-12 mb-2">
                                                    <label>Traffic convictions and forfeitures for the past 3 years(other than parking violations): (one per line)</label>
                                                    <textarea name="traffic_convictions" class="custom-placeholder miselect" rows="2" placeholder="Location, Date, Charge, Penalty"></textarea>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-12 mb-2">
                                                    <label>To Be Read And Signed By Applicant</label>
                                                    <p>
                                                        This certifies that this application was completed by me, and
                                                        that all entries on it and information in it are true and
                                                        complete to the best of my knowledge. I authorize you to
                                                        make such investigations and inquiries of my personal,
                                                        employment, financial or medical history and other related
                                                        matters as may be necessary in arriving at an employment
                                                        decision. As a commercial CDL driver I hereby release
                                                        employers, schools or persons from all liability in
                                                        responding to inquiries in connection with my application.
                                                        In the event of employment, I understand that false or
                                                        misleading information given in my application or
                                                        interview(s) may result in discharge. I understand, also,
                                                        that I am required to abide by all rules and regulations of
                                                        the Company, as permitted by Law.
                                                    </p>
                                                </div>
                                            </div>
                                            <h4 class="form-section">Driver Work History</h4>
                                            <div class="row">
                                                <div class="form-group col-md-6 mb-2">
                                                    <label>Name</label>
                                                    <input type="text" name="his_name" class="form-control" placeholder="..." required>
                                                </div>
                                                <div class="form-group col-md-6 mb-2">
                                                    <label>Date</label>
                                                    <input type="date" name="his_date" class="form-control" placeholder="Emergency Contact Phone..." required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6 mb-2">
                                                    <label>Company applying to</label>
                                                    <input type="text" name="his_company_apply" class="form-control" placeholder="..." required>
                                                </div>
                                                <div class="form-group col-md-6 mb-2">
                                                    <label>Which is the exact date of your first job in the US?</label>
                                                    <input type="date" name="his_first_date" class="form-control" placeholder="..." required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-12 mb-2">
                                                    <label>Work History</label>
                                                    <p>
                                                        All drivers’ applicants to drive in intra or interstate
                                                        commerce must provide the following information on all work
                                                        during the preceding 10 years. Please complete the
                                                        following, by date order including those date periods in
                                                        which you were not working, or worked as a sole proprietor.
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <h6 class="ml-15">Please list your work history beginning with the most recent.</h6>
                                                <div class="form-group col-md-6 mb-2">
                                                    <label>Date From</label>
                                                    <input type="date" name="his_date_from" class="form-control" placeholder="..." required>
                                                </div>
                                                <div class="form-group col-md-6 mb-2">
                                                    <label>Date To</label>
                                                    <input type="date" name="his_date_to" class="form-control" placeholder="..." required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-12 mb-2 mirgradio">
                                                    <label>Were you subject to Federal Motor Carrier Safety Regulations (FMCSRs) while employed by the previous employer?</label>
                                                    <span>
                                                        <input class="radio-btn" type="radio" name="subject_fmcsr" id="subject_fmcsr_y" value="1" required>
                                                        <label class="d-inline ml-1" for="subject_fmcsr_y">Yes</label>
                                                    </span>
                                                    <span>
                                                        <input class="radio-btn" type="radio" name="subject_fmcsr" id="subject_fmcsr_n" value="0" required>
                                                        <label class="d-inline ml-1" for="subject_fmcsr_n">No</label>
                                                    </span>
                                                </div>
                                                <div class="form-group col-md-12 mb-2 mirgradio">
                                                    <label>
                                                        Was the previous job position designated as a safety
                                                        sensitive function in any DOT regulated mode, subject to
                                                        alcohol and controlled substance testing requirements as
                                                        required by 49 CFR part 40?
                                                    </label>
                                                    <span>
                                                        <input class="radio-btn" type="radio" name="safety_sensitive" id="safety_sensitive_y" value="1" required>
                                                        <label class="d-inline ml-1" for="safety_sensitive_y">Yes</label>
                                                    </span>
                                                    <span>
                                                        <input class="radio-btn" type="radio" name="safety_sensitive" id="safety_sensitive_n" value="0" required>
                                                        <label class="d-inline ml-1" for="safety_sensitive_n">No</label>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6 mb-2">
                                                    <label>Company</label>
                                                    <input type="text" name="his_company_name" class="form-control" placeholder="..." required>
                                                </div>
                                                <div class="form-group col-md-6 mb-2">
                                                    <label>Position Held</label>
                                                    <input type="text" name="his_position_held" class="form-control" placeholder="..." required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-12 mb-2">
                                                    <label>Address</label>
                                                    <input type="text" name="his_address" class="form-control" placeholder="..." required>
                                                </div>
                                                <div class="form-group col-md-12 mb-2">
                                                    <label>Reason for Leaving</label>
                                                    <input type="text" name="his_reason_leaving" class="form-control" placeholder="..." required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-4 mb-2">
                                                    <label>Contact Person / Supervisor </label>
                                                    <input type="text" name="his_supervisor" class="form-control" placeholder="..." required>
                                                </div>
                                                <div class="form-group col-md-4 mb-2">
                                                    <label>Phone</label>
                                                    <input type="text" name="his_phone" class="form-control" placeholder="..." required>
                                                </div>
                                                <div class="form-group col-md-4 mb-2">
                                                    <label>Fax</label>
                                                    <input type="text" name="his_fax" class="form-control" placeholder="..." required>
                                                </div>
                                            </div>
                                            {{-- <div class="row">
                                                <div class="form-group col-md-6 mb-2">
                                                    <label>Signature</label>
                                                    <input type="text" name="txt1" class="form-control" placeholder="..." required>
                                                </div>
                                                <div class="form-group col-md-6 mb-2">
                                                    <label>Date</label>
                                                    <input type="date" name="txt1" class="form-control" placeholder="..." required>
                                                </div>
                                            </div> --}}
                                        </div>

                                        <input type="button" name="previous" class="previous action-button-previous readon" value="< Previous Step">
                                        <input type="button" name="next" class="next action-button readon" value="Next Step >">
                                    </fieldset>

                                    <fieldset>
                                        <div class="card-body">
                                            <h4 class="form-section">Dot Mandated Driver’s Acknowledgment Of Logs Program</h4>
                                            <div class="row">
                                                <div class="form-group col-md-12 mb-2">
                                                    <h6 class="mt-20">
                                                        This internal rule applies to all Owner
                                                        Operators, and Drivers operating under the below mentioned
                                                        carrier. This company rule mandates the following:
                                                    </h6>
                                                    <ol>
                                                        <li>All logs MUST be turned in to the carrier company; including off duty date logs.</li>
                                                        <li>Logs MUST be totally completed as per DOT requirements including compliance with driving and on duty hours.
                                                        </li>
                                                        <li>Copies of all supportive documentation such as fuel and toll receipts MUST also be turned in to the carrier for false log verification.</li>
                                                    </ol>
                                                    <p>As per company rule any violation of this mandated regulation could represent grounds for disciplinary actions including the termination of our services within the company.</p>
                                                </div>
                                                <div class="form-group col-md-6 mb-2">
                                                    <label>Driver’s Name</label>
                                                    <input type="text" name="lp_driver_name" class="form-control" placeholder="..." required>
                                                </div>
                                                <div class="form-group col-md-6 mb-2">
                                                    <label>CDL No</label>
                                                    <input type="text" name="lp_cdl_num" class="form-control" placeholder="..." required>
                                                </div>
                                                <div class="form-group col-md-6 mb-2">
                                                    <label>Carrier Name</label>
                                                    <input type="text" name="lp_carrier" class="form-control" placeholder="..." required>
                                                </div>
                                            </div>
                                            {{-- <div class="row">
                                                <div class="form-group col-md-6 mb-2">
                                                    <label>Signature</label>
                                                    <input type="text" name="txt1" class="form-control" placeholder="..." required>
                                                </div>
                                                <div class="form-group col-md-6 mb-2">
                                                    <label>Date</label>
                                                    <input type="text" name="txt1" class="form-control" placeholder="..." required>
                                                </div>
                                            </div> --}}

                                            <h4 class="form-section">Dot Mandated Driver’s Acknowledgment Of Logs Program</h4>
                                            <p>
                                                The Federal Motor Carrier Safety Administration has implemented a
                                                strict policy that prohibits the use if hand held communications
                                                devices. In responce to this regulation, the compnay is implementing
                                                the following policies:
                                            </p>
                                            <ol>
                                                <li>Cell phone use while operating a company vehicle is expressly prohibited. This prohibition includes the use of the following:
                                                    <ul style=" margin-left: 20px; list-style: disc; ">
                                                        <li>Cell Phones</li>
                                                        <li>PDA's</li>
                                                        <li>Texting</li>
                                                        <li>Qualcomm or similar devices</li>
                                                    </ul>
                                                </li>
                                                <li>If you are required to mae or receive call, find a safe location
                                                    (not the shoulder of the highway) and park your vehicle before
                                                    using a communication device.</li>
                                                <li>If you receive an incoming call while driving, allow it go to
                                                    voice mail and,if necessary, respond after finding a safe place
                                                    to stop your vehicle.</li>
                                                <li>Altough not prohibited by federal regulation, the company
                                                    believes that bluetooth devices cerate a distraction for the
                                                    driver and is therefore prohibiting the use of such devices
                                                    while driving.</li>
                                                <li>If making an emergency call, find a safe location to park your
                                                    vehicle prior to using the phone.</li>
                                            </ol>
                                            <p>
                                                Company is dedicated to both compliance with state and federal laws
                                                and is committed to operating safely. Distracted driving represents
                                                an unacceptable risk to the public. Driver who violate the rules
                                                governing hand-held communication devices shall be subject to
                                                disciplinary action upto and including termination.<br><br>
                                            </p>
                                            <div class="row">
                                                <div class="form-group col-md-12 mb-2 mirgradio">
                                                    <span>
                                                        <input class="radio-btn" type="checkbox" name="lp_signature" id="lp_signature_n" value="1" required>
                                                        <label class="d-inline ml-1" for="lp_signature_n">
                                                            I have received and read the above policy on hand held Communication
                                                            devices and agree to comply with it.
                                                        </label>
                                                    </span>
                                                </div>
                                                {{-- <div class="form-group col-md-6 mb-2">
                                                    <label>Date</label>
                                                    <input type="text" name="txt1" class="form-control" placeholder="..." required>
                                                </div> --}}
                                            </div>

                                            <h4 class="form-section">Certification Of Violations / Annual Review Of Driving Record</h4>
                                            <p>
                                                Motor Carrier Instructions: Each motor carrier shall at least once
                                                every 12 months, require each driver to prepare and furnish it with
                                                a list of all violations of motor vehicle traffic laws and
                                                ordinances (other than violations involving only of which the driver
                                                has been convicted, or on account of which he/she has forfeited bond
                                                or collateral during the preceding parking) 12 months (section
                                                391.27). Drivers who have provided information required by section
                                                383.31 need not repeat that information on this form.<br><br>
                                                Driver Requirements: Each driver shall furnish the list as required
                                                by the motor carrier above. If the driver has not been convicted of,
                                                or forfeited bond or collateral on account of any violation which
                                                must be listed, he/she shall so certify (section 391.27).
                                            </p>
                                            <div class="row">
                                                <div class="form-group col-md-6 mb-2">
                                                    <label>Driver’s Name</label>
                                                    <input type="text" name="cv_driver_name" class="form-control" placeholder="..." required>
                                                </div>
                                                <div class="form-group col-md-6 mb-2">
                                                    <label>Social Security No</label>
                                                    <input type="text" name="cv_ssn" class="form-control" placeholder="..." required>
                                                </div>
                                                <div class="form-group col-md-4 mb-2">
                                                    <label>Date of Service</label>
                                                    <input type="date" name="cv_service_date" class="form-control" placeholder="..." required>
                                                </div>
                                                <div class="form-group col-md-4 mb-2">
                                                    <label>License No.</label>
                                                    <input type="text" name="cv_license" class="form-control" placeholder="..." required>
                                                </div>
                                                <div class="form-group col-md-4 mb-2">
                                                    <label>State</label>
                                                    <select name="cv_state_id" class="form-control" required>
                                                        <option value="">Select State</option>
                                                        @foreach($STATES as $state)
                                                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6 mb-2">
                                                    <label>Expiration</label>
                                                    <input type="date" name="cv_expiration" class="form-control" placeholder="..." required>
                                                </div>
                                                <div class="form-group col-md-6 mb-2">
                                                    <label>Home Terminal</label>
                                                    <input type="text" name="cv_home_terminal" class="form-control" placeholder="..." required>
                                                </div>
                                            </div>
                                            <p>
                                                I certify that the following is a true and complete list of traffic
                                                violations required to be listed (other than those I have provided
                                                under part 383) for which I have been convicted or forfeited bond or
                                                collateral during the past 12 months.
                                            </p>
                                            <div class="row">
                                                <div class="form-group col-md-12 mb-2 mirgradio">
                                                    <label>Do you have had any violations </label>
                                                    <span>
                                                        <input class="radio-btn" type="radio" name="cv_any_violations" id="cv_any_violations_y" value="1" onchange="togglefields(this, 'haveViolation', 0)" required>
                                                        <label class="d-inline ml-1" for="cv_any_violations_y">Yes</label>
                                                    </span>
                                                    <span>
                                                        <input class="radio-btn" type="radio" name="cv_any_violations" id="cv_any_violations_n" value="0" onchange="togglefields(this, 'haveViolation', 0)" required>
                                                        <label class="d-inline ml-1" for="cv_any_violations_n">No</label>
                                                    </span>
                                                </div>
                                                <div class="form-group col-md-12 mb-2" id="haveViolation" style="display: none;">
                                                    <label>State your violation: (one per line)</label>
                                                    <textarea class="custom-placeholder miselect" name="cv_details" rows="2" placeholder="Date, Offense, Location, Type Of Vehicle Operated"></textarea>
                                                </div>
                                                <p>
                                                    If no violations are listed above, I certify that I have not been
                                                    convicted or forfeited bond or collateral on account of any
                                                    violation (other than those I have provided under part 383)
                                                    required to be listed during the past 12 months.
                                                </p>
                                            </div>
                                            {{-- <div class="row">
                                                <div class="form-group col-md-6 mb-2">
                                                    <label>Signature</label>
                                                    <input type="text" name="txt1" class="form-control" placeholder="..." required>
                                                </div>
                                                <div class="form-group col-md-6 mb-2">
                                                    <label>Date</label>
                                                    <input type="text" name="txt1" class="form-control" placeholder="..." required>
                                                </div>
                                            </div> --}}
                                        </div>

                                        <input type="button" name="previous" class="previous action-button-previous readon" value="< Previous Step" />
                                        <input type="button" name="next" class="next action-button readon" value="Next Step >" />
                                    </fieldset>

                                    <fieldset>
                                        <div class="card-body">
                                            <h4 class="form-section">Drug &amp; Alcohol Clearinghouse Consent For Limited Queries</h4>
                                            <div class="row">
                                                <div class="form-group col-md-12 mb-2">
                                                    <p>
                                                        <strong>Notice To Driver: </strong>The Commercial Driver's
                                                        License (CDL) Drug & Alcohol Clearinghouse is a federal
                                                        database containing information about CDL drivers who have
                                                        violated the Federal Motor Carrier Safety Administration's
                                                        (FMCSA's) drug or alcohol regulations in 49 CFR Part 382.
                                                        Whether you have committed such a violation or not, each
                                                        motor carrier for whom you drive is required to check
                                                        whether the Clearinghouse has any information about you,
                                                        both at the time of hire and annually. When conducting an
                                                        annual inquiry, the motor carrier has the option to request
                                                        a "limited" report that only indicates whether the
                                                        Clearinghouse has any information about you; it does not
                                                        release any violation or testing information. Before a motor
                                                        carrier may request a limited report, they must have your
                                                        written authorization, per $382.701(b). This authorization
                                                        may be valid for more than one year. If a limited query ever
                                                        reveals that the Clearinghouse has information about you,
                                                        you will be required to log in to the Clearinghouse website
                                                        within 24 hours to grant electronic consent for the motor
                                                        carrier to obtain your full Clearinghouse record.
                                                    </p>
                                                    <p>
                                                        <strong>Notice To Motor Carrier: </strong>This consent form
                                                        authorizes you to run a "limited query" to check whether the
                                                        Clearinghouse has information about the driver identified
                                                        below. If it does, then you must obtain a full Clearinghouse
                                                        record within 24 hours, per $382.701(b). This consent form
                                                        must be retained until 3 years after the date of the last
                                                        limited query you perform for this driver, based on the
                                                        authorization below.
                                                    </p>
                                                    <h6 class="mt-20">Authorization:</h6>
                                                    <p>
                                                        I, <strong>Alex Jhon </strong>hereby authorize <strong>
                                                        {{ siteSetting('title') }} INC. </strong>to conduct limited annual queries of
                                                        the FMCSA's Drug & Alcohol Clearinghouse, to determine if a
                                                        Clearinghouse record exists for me. This consent is valid
                                                        from the date shown below until my employment with the
                                                        above-named motor carrier ceases or until I am no longer
                                                        subject to the drug and alcohol testing rules in 49 CFR Part
                                                        382 for the above-named motor carrier. I understand that if
                                                        any limited query reveals that the Clearinghouse contains
                                                        information about me, I must grant electronic consent within
                                                        24 hours, via the Clearinghouse website, for the motor
                                                        carrier to obtain my full Clearinghouse record. Refusal to
                                                        provide such consent will result in my removal from
                                                        safety-sensitive duties.
                                                    </p>
                                                </div>
                                                <div class="form-group col-md-12 mb-2">
                                                    <label>ID Number</label>
                                                    <input type="text" name="q_id_number" class="form-control" placeholder="..." required>
                                                </div>
                                                {{-- <div class="form-group col-md-6 mb-2">
                                                    <label>Driver's Signature</label>
                                                    <input type="text" name="txt1" class="form-control" placeholder="..." required>
                                                </div>
                                                <div class="form-group col-md-6 mb-2">
                                                    <label>Date</label>
                                                    <input type="text" name="txt1" class="form-control" placeholder="..." required>
                                                </div> --}}
                                            </div>
                                        </div>
                                        <input type="button" name="previous" class="previous action-button-previous readon" value="< Previous Step" />
                                        <input type="submit" name="next" class="next action-button readon" value="Submit" />
                                    </fieldset>

                                    <fieldset>
                                        <div class="card-body d-none" id="loadingPanel">
                                            <div class="row justify-content-center">
                                                <div class="col-3">
                                                    <img src="https://miro.medium.com/max/1400/1*CsJ05WEGfunYMLGfsT2sXA.gif" class="fit-image mx-auto d-table">
                                                </div>
                                            </div>
                                            <div class="row justify-content-center">
                                                <div class="col-7 text-center">
                                                    <h4>Submitting Your Form</h4>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card-body" id="msgPanel">
                                            <h2 class="fs-title text-center" id="msgHead"></h2>
                                            <br><br>
                                            <div class="row justify-content-center">
                                                <div class="col-3">
                                                    <img src="" id="msgImg" class="fit-image mx-auto d-table">
                                                </div>
                                            </div>
                                            <br><br>
                                            <div class="row justify-content-center">
                                                <div class="col-7 text-center">
                                                    <h5 id="msgTxt"></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('scripts')
<script>
    let fetchCitiesByState = (elem, name, url)=>{
        $(`select[name=${name}]`).css({display: 'none'});

        $(`select[name=${name}]`).prev().html(`<i class="la la-spinner la-spin"></i> Loading...`);

        $.ajax({
            url: `${url}/resource-provider/cities?id=${elem.value}`,
            type: 'GET',
            success: res => {
                let options = '<option value="">Select City...</option>';

                res.data.forEach(obj => {
                    options += `<option value="${obj.id}">${obj.name}</option>`;
                });

                $(`select[name=${name}]`).html(options);
                $(`select[name=${name}]`).prev().html("");
                $(`select[name=${name}]`).css({display: 'block'});
            },
            error: err => {
                $(`select[name=${name}]`).prev().html(`<b style="color:red">* something went wrong!</b>`);
                console.error(err);
            }
        });
    }

    let togglefields = (elem, id, value)=>{
        if(elem.value == value){
            if($(`#${id}`).attr("style") != "display: none;"){
                $(`#${id}`).toggle('fast');
            }
        } else{
            $(`#${id}`).toggle('fast');
        }
    }

    let applicationSubmit = form => {
        $('#loadingPanel').removeClass('d-none');
        $('#msgPanel').addClass('d-none');

        $.ajax({
            url: $(form).attr('action'),
            type: 'POST',
            data: $(form).serialize(),
            success: (res)=>{
                if(res.status){
                    $("#msgHead").html("Success!");
                    $("#msgImg").attr("src", "https://img.icons8.com/color/96/000000/ok--v2.png");
                    $("#msgTxt").html("You Have Successfully Submitted Your Form");
                } else{
                    $("#msgHead").html("Error!");
                    $("#msgImg").attr("src", "https://cdn-icons-png.flaticon.com/512/179/179386.png");
                    $("#msgTxt").html("Something Went Wrong While Submitting Your Form");
                }
            },
            error: (err)=>{
                $("#msgHead").html("Error!");
                $("#msgImg").attr("src", "https://cdn-icons-png.flaticon.com/512/179/179386.png");
                $("#msgTxt").html("Something Went Wrong While Submitting Your Form");

                console.error(err);
            },
            complete: ()=>{
                $('#msgPanel').removeClass('d-none');
                $('#loadingPanel').addClass('d-none');
            }
        });

        return false;
    }

    $(document).ready(function () {
        $('.js-example-basic-single').select2();

        var current_fs, next_fs, previous_fs; //fieldsets
        var opacity;

        $(".next").click(function () {
            current_fs = $(this).parent();
            next_fs = $(this).parent().next();

            //Add Class Active
            $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

            //show the next fieldset
            next_fs.show();
            //hide the current fieldset with style
            current_fs.animate({ opacity: 0 }, {
                step: function (now) {
                    // for making fielset appear animation
                    opacity = 1 - now;

                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    next_fs.css({ 'opacity': opacity });
                },
                duration: 600
            });
        });

        $(".previous").click(function () {
            current_fs = $(this).parent();
            previous_fs = $(this).parent().prev();

            //Remove class active
            $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

            //show the previous fieldset
            previous_fs.show();

            //hide the current fieldset with style
            current_fs.animate({ opacity: 0 }, {
                step: function (now) {
                    // for making fielset appear animation
                    opacity = 1 - now;

                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    previous_fs.css({ 'opacity': opacity });
                },
                duration: 600
            });
        });

        $('.radio-group .radio').click(function () {
            $(this).parent().find('.radio').removeClass('selected');
            $(this).addClass('selected');
        });

        $(".submit").click(function () {
            return false;
        });
    });
</script>
@endsection
