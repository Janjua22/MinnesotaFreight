@extends('layouts.admin.master')

@section('styles')
<style>
    @font-face {
        font-family: Signature;
        src: url({{ asset('site/fonts/Southam.otf') }});
    }
    .driver-app-txt{
        border: 0px;
        border-bottom: 1px solid #363636;
        font-weight: bold;
        resize: none;
    }
    .driver-app-txt:hover, .driver-app-txt:focus, .driver-app-txt:active{
        outline: none;
    }
    .sign-text{
        font-family: Signature;
        font-size: 3rem;
        margin-bottom: 0;
    }
</style>
@endsection

@section('content')
@php 
    $titles=[
        'title' => "Driver Application",
        'sub-title' => "Details",
        'btn' => "List",
        'url' => route('admin.driverApplication')
    ];
@endphp

@include('admin.components.top-bar', $titles)

<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-xxl">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="row g-0">
                        <div class="card-body">
                            <h4 class="form-section mb-8 fs-2">Basic information</h4>

                            <div class="row">
                                <div class="form-group col-md-6 my-3">
                                    <label class="d-flex">Name: <input type="text" class="driver-app-txt ms-2 w-100" value="{{ $application->name }}" readonly></label>
                                </div>
                                <div class="form-group col-md-6 my-3">
                                    <label class="d-flex">Date: <input type="text" class="driver-app-txt ms-2 w-100" value="{{ date_format(new DateTime($application->date), "M d, Y") }}" readonly></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 my-3">
                                    <label class="d-flex">Company applying to: <input type="text" class="driver-app-txt ms-2 w-100" value="{{ $application->company_apply }}" readonly></label>
                                </div>
                                <div class="form-group col-md-6 my-3">
                                    <label class="d-flex">Position(s) applied for: <input type="text" class="driver-app-txt ms-2 w-100" value="{{ $application->position }}" readonly></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12 my-3">
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
                                <div class="form-group col-md-6 my-3">
                                    <label class="d-flex">Referred by: <input type="text" class="driver-app-txt ms-2 w-100" value="{{ $application->referred_by }}" readonly></label>
                                </div>
                                <div class="form-group col-md-6 my-3">
                                    <label class="d-flex">Social Security: <input type="text" class="driver-app-txt ms-2 w-100" value="{{ $application->ssn }}" readonly></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 my-3">
                                    <label class="d-flex">Date of Birth: <input type="text" class="driver-app-txt ms-2 w-100" value="{{ $application->dob }}" readonly></label>
                                </div>
                                <div class="form-group col-md-6 my-3">
                                    <label class="d-flex">Address: <input type="text" class="driver-app-txt ms-2 w-100" value="{{ $application->address }}" readonly></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 my-3">
                                    <label class="d-flex">City: <input type="text" class="driver-app-txt ms-2 w-100" value="{{ $application->city->name }}" readonly></label>
                                </div>
                                <div class="form-group col-md-6 my-3">
                                    <label class="d-flex">State: <input type="text" class="driver-app-txt ms-2 w-100" value="{{ $application->state->name }}" readonly></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 my-3">
                                    <label class="d-flex">CDL: <input type="text" class="driver-app-txt ms-2 w-100" value="{{ $application->cdl }}" readonly></label>
                                </div>
                                <div class="form-group col-md-6 my-3">
                                    <label class="d-flex">CDL Expiration: <input type="text" class="driver-app-txt ms-2 w-100" value="{{ date_format(new DateTime($application->cdl_expiry), 'M d, Y') }}" readonly></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 my-3">
                                    <label class="d-flex">Home Phone: <input type="text" class="driver-app-txt ms-2 w-100" value="{{ $application->home_phone }}" readonly></label>
                                </div>
                                <div class="form-group col-md-6 my-3">
                                    <label class="d-flex">Work Phone: <input type="text" class="driver-app-txt ms-2 w-100" value="{{ $application->work_phone }}" readonly></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 my-3">
                                    <label class="d-flex">Cellphone: <input type="text" class="driver-app-txt ms-2 w-100" value="{{ $application->cell_phone }}" readonly></label>
                                </div>
                                <div class="form-group col-md-6 my-3">
                                    <label class="d-flex">Email: <input type="text" class="driver-app-txt ms-2 w-100" value="{{ $application->email }}" readonly></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 my-3">
                                    <label class="d-flex">Emergency Contact Name: <input type="text" class="driver-app-txt ms-2 w-100" value="{{ $application->emergencyInfo->em_name }}" readonly></label>
                                </div>
                                <div class="form-group col-md-6 my-3">
                                    <label class="d-flex">Emergency Telephone: <input type="text" class="driver-app-txt ms-2 w-100" value="{{ $application->emergencyInfo->em_phone }}" readonly></label>
                                </div>
                            </div>

                            <h4 class="form-section my-8 fs-2">Address For Past 3 Years</h4>

                            @forelse($application->addresses as $i => $address)
                            <div class="row">
                                <div class="form-group col-md-8 my-3">
                                    <label class="d-flex">Address #{{ $i+1 }}: <input type="text" class="driver-app-txt ms-2 w-100" value="{{ $address->address }}" readonly></label>
                                </div>
                                <div class="form-group col-md-4 my-3">
                                    <label class="d-flex">How Long: <input type="text" class="driver-app-txt ms-2 w-100" value="{{ $address->how_long }} month(s)" readonly></label>
                                </div>
                            </div>
                            @empty
                            <div class="row">
                                <div class="form-group col-md-8 my-3">
                                    <label class="d-flex">Address: <input type="text" class="driver-app-txt ms-2 w-100" value="N/A" readonly></label>
                                </div>
                                <div class="form-group col-md-4 my-3">
                                    <label class="d-flex">How Long: <input type="text" class="driver-app-txt ms-2 w-100" value="N/A" readonly></label>
                                </div>
                            </div>
                            @endforelse
                            <div class="row">
                                <div class="form-group col-md-6 my-3">
                                    <label>Do you have the legal right to work in the U.S.: <span class="fw-bold ms-2">{{ $application->details->right_to_work ? 'Yes' : 'No' }}</span></label>
                                </div>
                                <div class="form-group col-md-6 my-3">
                                    <label>Are you presently working: <span class="fw-bold ms-2">{{ $application->details->working ? 'Yes' : 'No' }}</span></label>
                                </div>
                                @if($application->details->working == 0)
                                <div class="form-group col-md-6 my-3">
                                    <label class="d-flex">How long since last job: <input type="text" class="driver-app-txt ms-2 w-100" value="{{ $application->details->since_job ?? 0 }} month(s)" readonly></label>
                                </div>
                                @endif
                            </div>

                            <h4 class="form-section my-8 fs-2">Physical History</h4>

                            <div class="row">
                                <div class="form-group col-md-6 my-3">
                                    <label>Do you have any physical condition which may limit your ability to perform the job applied for: <span class="fw-bold ms-2">{{ $application->physicalHistory->physical_condition ? 'Yes' : 'No' }}</span></label>
                                </div>
                                <div class="form-group col-md-6 my-3">
                                    <label>Have you ever tested positive for drugs or alcohol as a commercial driver: <span class="fw-bold ms-2">{{ $application->physicalHistory->tested_drugs ? 'Yes' : 'No' }}</span></label>
                                </div>
                                @if($application->physicalHistory->tested_drugs)
                                <div class="form-group col-md-12 my-3">
                                    <label class="d-flex">When, mention year: <input type="text" class="driver-app-txt ms-2 w-100" value="{{ $application->physicalHistory->year_tested }}" readonly></label>
                                </div>
                                @endif
                                @if($application->physicalHistory->physical_condition)
                                <div class="form-group col-md-12 my-3">
                                    <label>Please explain your physical condition:</label>
                                    <textarea class="driver-app-txt ms-2 w-100" rows="3" readonly>{{ $application->physicalHistory->condition_explain }}</textarea>
                                </div>
                                @endif
                            </div>

                            <h4 class="form-section my-8 fs-2">Experience And Qualifications</h4>

                            <div class="row">
                                <div class="form-group col-md-12 my-3">
                                    <label>Driver’s Licenses / Licensias (one per line)</label>
                                    <textarea class="driver-app-txt ms-2 w-100" rows="3" readonly>{{ $application->experience->license_lines }}</textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 my-3">
                                    <label>Have you ever been denied a license, permit or privilege to operate a motor vehicle: <span class="fw-bold ms-2">{{ $application->experience->license_denied ? 'Yes' : 'No' }}</span></label>
                                </div>
                                <div class="form-group col-md-6 my-3">
                                    <label>Has any license, permit or privilege ever been suspended or revoked: <span class="fw-bold ms-2">{{ $application->experience->license_revoked ? 'Yes' : 'No' }}</span></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 my-3">
                                    <label class="d-flex">Commercial Motor Vehicle Driver Since: <input type="text" class="driver-app-txt ms-2 w-100" value="{{ $application->experience->driver_since }}" readonly></label>
                                </div>
                                <div class="form-group col-md-6 my-3">
                                    <label class="d-flex">Years of Commercial Motor Vehicle experience: <input type="text" class="driver-app-txt ms-2 w-100" value="{{ $application->experience->years_experience }} year(s)" readonly></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12 my-3">
                                    <label>Below, please list the type of Commercial Motor Vehicle experience you have had:</label>
                                </div>
                                @forelse($application->experienceVehicles as $vehicle)
                                <div class="form-group col-md-3 my-3">
                                    <i class="fas fa-check"></i> {{ $vehicle->vehicle_name }}
                                </div>
                                @empty
                                <div class="form-group col-md-12 my-3 text-danger">No vehicle experience provided!</div>
                                @endforelse
                            </div>

                            <h4 class="form-section my-8 fs-2">Accident Record</h4>

                            <div class="row">
                                <div class="form-group col-md-12 my-3">
                                    <label>Accident record for past 3 years: (one per line)</label>
                                    <textarea class="driver-app-txt ms-2 w-100" rows="3" readonly>{{ $application->accidentRecord->accident_records }}</textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12 my-3">
                                    <label>Traffic convictions and forfeitures for the past 3 years(other than parking violations): (one per line)</label>
                                    <textarea class="driver-app-txt ms-2 w-100" rows="3" readonly>{{ $application->accidentRecord->traffic_convictions }}</textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12 my-3">
                                    <p class="fw-bolder">To Be Read And Signed By Applicant</p>
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
                            <div class="row">
                                <div class="form-group col-md-12 my-3">
                                    <label>Signature:</label>
                                    @if($application->accidentRecord->signed_at)
                                    <p class="fw-bold ms-2 sign-text">Signed By {{ $application->name }}</p>
                                    <p class="fw-bold ms-2">{{ date_format($application->accidentRecord->signed_at, "M d, Y") }}</p>
                                    @else
                                    <p class="fw-bold ms-2 text-danger">NOT SIGNED!</p>
                                    @endif
                                </div>
                            </div>

                            <h4 class="form-section my-8 fs-2">Driver Work History</h4>

                            <div class="row">
                                <div class="form-group col-md-6 my-3">
                                    <label class="d-flex">Name: <input type="text" class="driver-app-txt ms-2 w-100" value="{{ $application->workHistory->his_name }}" readonly></label>
                                </div>
                                <div class="form-group col-md-6 my-3">
                                    <label class="d-flex">Date: <input type="text" class="driver-app-txt ms-2 w-100" value="{{ date_format(new DateTime($application->workHistory->his_date), "M d, Y") }}" readonly></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 my-3">
                                    <label class="d-flex">Company applying to: <input type="text" class="driver-app-txt ms-2 w-100" value="{{ $application->workHistory->his_company_apply }}" readonly></label>
                                </div>
                                <div class="form-group col-md-6 my-3">
                                    <label class="d-flex">Which is the exact date of your first job in the US: <input type="text" class="driver-app-txt ms-2 w-100" value="{{ $application->workHistory->his_first_date }}" readonly></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12 my-3">
                                    <p class="fw-bolder">Work History</p>
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
                                <div class="form-group col-md-12 my-3">
                                    <p class="fw-bolder">Please list your work history beginning with the most recent.</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 my-3">
                                    <label class="d-flex">Date From: <input type="text" class="driver-app-txt ms-2 w-100" value="{{ date_format(new DateTime($application->workHistory->his_date_from), "M d, Y") }}" readonly></label>
                                </div>
                                <div class="form-group col-md-6 my-3">
                                    <label class="d-flex">Date To: <input type="text" class="driver-app-txt ms-2 w-100" value="{{ date_format(new DateTime($application->workHistory->his_date_to), "M d, Y") }}" readonly></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12 my-3">
                                    <label>Were you subject to Federal Motor Carrier Safety Regulations (FMCSRs) while employed by the previous employer: <span class="fw-bolder ms-2">{{ $application->workHistory->subject_fmcsr ? 'Yes' : 'No' }}</span></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12 my-3">
                                    <label>Was the previous job position designated as a safety sensitive function in any DOT regulated mode, subject to alcohol and controlled substance testing requirements as required by 49 CFR part 40: <span class="fw-bolder ms-2">{{ $application->workHistory->safety_sensitive ? 'Yes' : 'No' }}</span></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 my-3">
                                    <label class="d-flex">Company: <input type="text" class="driver-app-txt ms-2 w-100" value="{{ $application->workHistory->his_company_name }}" readonly></label>
                                </div>
                                <div class="form-group col-md-6 my-3">
                                    <label class="d-flex">Position Held: <input type="text" class="driver-app-txt ms-2 w-100" value="{{ $application->workHistory->his_position_held }}" readonly></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12 my-3">
                                    <label class="d-flex">Address: <input type="text" class="driver-app-txt ms-2 w-100" value="{{ $application->workHistory->his_address }}" readonly></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12 my-3">
                                    <label class="d-flex">Reason for Leaving: <input type="text" class="driver-app-txt ms-2 w-100" value="{{ $application->workHistory->his_reason_leaving }}" readonly></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4 my-3">
                                    <label class="d-flex">Contact Person / Supervisor: <input type="text" class="driver-app-txt ms-2 w-100" value="{{ $application->workHistory->his_supervisor }}" readonly></label>
                                </div>
                                <div class="form-group col-md-4 my-3">
                                    <label class="d-flex">Phone: <input type="text" class="driver-app-txt ms-2 w-100" value="{{ $application->workHistory->his_phone }}" readonly></label>
                                </div>
                                <div class="form-group col-md-4 my-3">
                                    <label class="d-flex">Fax: <input type="text" class="driver-app-txt ms-2 w-100" value="{{ $application->workHistory->his_fax }}" readonly></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12 my-3">
                                    <label>Signature:</label>
                                    @if($application->workHistory->signed_at)
                                    <p class="fw-bold ms-2 sign-text">Signed By {{ $application->name }}</p>
                                    <p class="fw-bold ms-2">{{ date_format($application->workHistory->signed_at, "M d, Y") }}</p>
                                    @else
                                    <p class="fw-bold ms-2 text-danger">NOT SIGNED!</p>
                                    @endif
                                </div>
                            </div>

                            <h4 class="form-section my-8 fs-2">Dot Mandated Driver’s Acknowledgment Of Logs Program</h4>

                            <div class="row">
                                <div class="form-group col-md-12 my-3">
                                    <p class="fw-bolder">
                                        This internal rule applies to all Owner
                                        Operators, and Drivers operating under the below mentioned
                                        carrier. This company rule mandates the following:
                                    </p>
                                    <ol>
                                        <li>All logs MUST be turned in to the carrier company; including off duty date logs.</li>
                                        <li>Logs MUST be totally completed as per DOT requirements including compliance with driving and on duty hours.
                                        </li>
                                        <li>Copies of all supportive documentation such as fuel and toll receipts MUST also be turned in to the carrier for false log verification.</li>
                                    </ol>
                                    <p>
                                        As per company rule any violation of this mandated regulation could represent grounds for disciplinary actions 
                                        including the termination of our services within the company.
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 my-3">
                                    <label class="d-flex">Driver’s Name: <input type="text" class="driver-app-txt ms-2 w-100" value="{{ $application->logProgram->lp_driver_name }}" readonly></label>
                                </div>
                                <div class="form-group col-md-6 my-3">
                                    <label class="d-flex">CDL No: <input type="text" class="driver-app-txt ms-2 w-100" value="{{ $application->logProgram->lp_cdl_num }}" readonly></label>
                                </div>
                                <div class="form-group col-md-6 my-3">
                                    <label class="d-flex">Carrier Name: <input type="text" class="driver-app-txt ms-2 w-100" value="{{ $application->logProgram->lp_carrier }}" readonly></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12 my-3">
                                    <label>Signature:</label>
                                    @if($application->logProgram->signed_at)
                                    <p class="fw-bold ms-2 sign-text">Signed By {{ $application->logProgram->lp_driver_name }}</p>
                                    <p class="fw-bold ms-2">{{ date_format($application->logProgram->signed_at, "M d, Y") }}</p>
                                    @else
                                    <p class="fw-bold ms-2 text-danger">NOT SIGNED!</p>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12 my-3">
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
                                        I have received and read the above policy on hand held Communication
                                        devices and agree to comply with it.
                                    </p>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12 my-3">
                                        <label>Signature:</label>
                                        @if($application->logProgram->signed_at)
                                        <p class="fw-bold ms-2 sign-text">Signed By {{ $application->logProgram->lp_driver_name }}</p>
                                        <p class="fw-bold ms-2">{{ date_format($application->logProgram->signed_at, "M d, Y") }}</p>
                                        @else
                                        <p class="fw-bold ms-2 text-danger">NOT SIGNED!</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <h4 class="form-section my-8 fs-2">Certification Of Violations / Annual Review Of Driving Record</h4>

                            <div class="row">
                                <div class="form-group col-md-12 my-3">
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
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 my-3">
                                    <label class="d-flex">Driver’s Name: <input type="text" class="driver-app-txt ms-2 w-100" value="{{ $application->violationCertificate->cv_driver_name }}" readonly></label>
                                </div>
                                <div class="form-group col-md-6 my-3">
                                    <label class="d-flex">Social Security Number: <input type="text" class="driver-app-txt ms-2 w-100" value="{{ $application->violationCertificate->cv_ssn }}" readonly></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4 my-3">
                                    <label class="d-flex">Date of Service: <input type="text" class="driver-app-txt ms-2 w-100" value="{{ date_format(new DateTime($application->violationCertificate->cv_service_date), "M d, Y") }}" readonly></label>
                                </div>
                                <div class="form-group col-md-4 my-3">
                                    <label class="d-flex">License No.: <input type="text" class="driver-app-txt ms-2 w-100" value="{{ $application->violationCertificate->cv_license }}" readonly></label>
                                </div>
                                <div class="form-group col-md-4 my-3">
                                    <label class="d-flex">State: <input type="text" class="driver-app-txt ms-2 w-100" value="{{ $application->violationCertificate->state->name }}" readonly></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 my-3">
                                    <label class="d-flex">Expiration: <input type="text" class="driver-app-txt ms-2 w-100" value="{{ $application->violationCertificate->cv_expiration }}" readonly></label>
                                </div>
                                <div class="form-group col-md-6 my-3">
                                    <label class="d-flex">Home Terminal: <input type="text" class="driver-app-txt ms-2 w-100" value="{{ $application->violationCertificate->cv_home_terminal }}" readonly></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12 my-3">
                                    <p>
                                        I certify that the following is a true and complete list of traffic
                                        violations required to be listed (other than those I have provided
                                        under part 383) for which I have been convicted or forfeited bond or
                                        collateral during the past 12 months.
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12 my-3">
                                    <label>Do you have had any violations: <span class="fw-bold ms-2">{{ $application->violationCertificate->cv_any_violations ? 'Yes' : 'No' }}</span></label>
                                </div>
                            </div>
                            @if($application->violationCertificate->cv_any_violations)
                            <div class="row">
                                <div class="form-group col-md-12 my-3">
                                    <label>State your violation: (one per line)</label>
                                    <textarea class="driver-app-txt ms-2 w-100" rows="3" readonly>{{ $application->violationCertificate->cv_details }}</textarea>
                                </div>
                            </div>
                            @endif
                            <div class="row">
                                <div class="form-group col-md-12 my-3">
                                    <p>
                                        If no violations are listed above, I certify that I have not been
                                        convicted or forfeited bond or collateral on account of any
                                        violation (other than those I have provided under part 383)
                                        required to be listed during the past 12 months.
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12 my-3">
                                    <label>Signature:</label>
                                    @if($application->violationCertificate->signed_at)
                                    <p class="fw-bold ms-2 sign-text">Signed By {{ $application->violationCertificate->cv_driver_name }}</p>
                                    <p class="fw-bold ms-2">{{ date_format($application->violationCertificate->signed_at, "M d, Y") }}</p>
                                    @else
                                    <p class="fw-bold ms-2 text-danger">NOT SIGNED!</p>
                                    @endif
                                </div>
                            </div>

                            <h4 class="form-section my-8 fs-2">Drug & Alcohol Clearinghouse Consent For Limited Queries</h4>

                            <div class="row">
                                <div class="form-group col-md-12 my-3">
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
                                    <p class="fw-bolder my-3">Authorization:</p>
                                    <p>
                                        I, <strong>{{ $application->name }}</strong> hereby authorize 
                                        <strong>{{ strtoupper(siteSetting('title')) }}</strong> to conduct limited 
                                        annual queries of the FMCSA's Drug & Alcohol Clearinghouse, 
                                        to determine if a Clearinghouse record exists for me. 
                                        This consent is valid from the date shown below until my employment 
                                        with the above-named motor carrier ceases or until I am no longer 
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
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12 my-3">
                                    <label class="d-flex">ID Number: <input type="text" class="driver-app-txt ms-2 w-100" value="{{ $application->drugInfo->q_id_number }}" readonly></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12 my-3">
                                    <label>Signature:</label>
                                    @if($application->drugInfo->signed_at)
                                    <p class="fw-bold ms-2 sign-text">Signed By {{ $application->name }}</p>
                                    <p class="fw-bold ms-2">{{ date_format($application->drugInfo->signed_at, "M d, Y") }}</p>
                                    @else
                                    <p class="fw-bold ms-2 text-danger">NOT SIGNED!</p>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <img src="{{ asset('site/images/form-footer.png') }}" alt="form footer" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection