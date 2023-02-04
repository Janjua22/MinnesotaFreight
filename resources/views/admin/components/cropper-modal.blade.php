
		<!--begin::Modal - Invite Friends-->
		<div class="modal fade"  id="featureModal"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="featureModal" aria-hidden="true">
			<!--begin::Modal dialog-->
			<div class="modal-dialog mw-500px ">
				<!--begin::Modal content-->
				
					<div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header d-flex flex-row-reverse ribbon ribbon-start ribbon-clip">
                            <!--begin::Modal title-->
                            <div class="ribbon-label fw-bolder">
                                Crop Image
                                <span class="ribbon-inner bg-success"></span>
                            </div>
                            <!--end::Modal title-->
                            <!--begin::Close-->
                            <div class="btn btn-icon btn-sm btn-active-icon-primary w-5 float-end"  class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                <span class="svg-icon svg-icon-1">
                                    {!! getSvg('arr061') !!}
                                </span>
                                <!--end::Svg Icon-->
                            </div>
                            <!--end::Close-->
                            <div class="btn btn-icon btn-sm btn-active-icon-primary w-95 float-end">
                                <h2 class="fw-bolder">{{$modal['title']}}</h2>
                            </div>
                        </div>
                        <!--end::Modal header-->
						<!--begin::Modal body-->
						<div class="modal-body scroll-y mx-5 mx-xl-18 pt-0 pb-5">
							<!--begin::Heading-->
							<div class="text-center  my-3">
								<!--begin::Description-->
								<div class="text-muted fw-bold fs-5">you can upload full image if image has a ratio of {{$modal['ratio']}} otherwise you need to crop it.
								</div>
								<!--end::Description-->
							</div>
							<!--end::Heading-->
							<div class=" mb-8">
                                <img id="imageInModal" src="" alt="your image" class="img-fluid" />
							</div>
						</div>
						<!--end::Modal body-->
					</div>
				<!--end::Modal content-->
			</div>
			<!--end::Modal dialog-->
		</div>
		<!--end::Modal - Invite Friend--> 