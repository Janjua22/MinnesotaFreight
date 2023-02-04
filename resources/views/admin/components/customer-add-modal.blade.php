<div class="modal fade" id="addCustomerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header d-flex flex-row-reverse ribbon ribbon-start ribbon-clip">
                <div class="ribbon-label fw-bolder" id="modalRibbonLabel"></div>
                <div class="btn btn-icon btn-sm btn-active-icon-primary w-5 float-end" data-bs-dismiss="modal">
                    <span class="svg-icon svg-icon-1">
                        {!! getSvg('arr061') !!}
                    </span>
                </div>
                <div class="btn btn-icon btn-sm btn-active-icon-primary w-95 float-end">
                    <h2 class="fw-bolder" id="modalHeading"></h2>
                </div>
            </div>
            <div class="modal-body scroll-y">
                <form action="" method="POST" id="modalForm">
                    @csrf
                    <input type="hidden" name="latitude" value="">
                    <input type="hidden" name="longitude" value="">

                    <div class="form-body">
                        <div class="row">
                            <div class="form-group col-md-6 mb-7">
                                <label>Company Name <sup class="text-danger">*</sup></label>
                                <input type="text" name="name" class="form-control form-control-solid @error('name') is-invalid border-danger @enderror" placeholder="Company Name..." required>
                            </div>
                            <div class="form-group col-md-6 mb-7">
                                <label>Street</label>
                                <input type="text" name="street" class="form-control form-control-solid @error('street') is-invalid border-danger @enderror" placeholder="Street...">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6 mb-7">
                                <label>Apt/Suite/Other</label>
                                <input type="text" name="suite" class="form-control form-control-solid @error('suite') is-invalid border-danger @enderror" placeholder="Apt/Suite/Other...">
                            </div>
                            <div class="form-group col-md-6 mb-7">
                                <label>
                                    City 
                                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addCityModal">
                                        <i class="fas fa-plus-circle text-primary"></i>
                                    </a>
                                </label>
                                <input type="text" id="cityLocation" class="form-control form-control-solid" placeholder="Search City..." autocomplete="nope">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6 mb-7">
                                <label>Zip</label>
                                <input type="text" name="zip" class="form-control form-control-solid @error('zip') is-invalid border-danger @enderror" placeholder="Zip/Postal Code...">
                            </div>
                            <div class="form-group col-md-6 mb-7">
                                <label>Phone</label>
                                <input type="text" name="phone" class="form-control form-control-solid @error('phone') is-invalid border-danger @enderror" placeholder="Phone...">
                            </div>
                        </div>
                    </div>

                    <div class="text-center pt-15">
                        <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Close</button>

                        <button type="submit" class="btn btn-success" data-kt-modules-modal-action="submit">
                            <span class="indicator-label">Save</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>