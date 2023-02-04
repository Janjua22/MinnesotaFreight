    <!--begin::Modal - Invite Friends-->
		<div class="modal fade"  id="eventModal"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="featureModal" aria-hidden="true">
			<!--begin::Modal dialog-->
			<div class="modal-dialog mw-500px ">
				<!--begin::Modal content-->
				
					<div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header d-flex flex-row-reverse ribbon ribbon-start ribbon-clip">
                            <!--begin::Modal title-->
                            <div class="ribbon-label fw-bolder">
                                View Event
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
                            <div class="btn btn-icon btn-sm btn-active-icon-primary btn btn-icon btn-sm btn-active-icon-primary w-75 ms-md-18">
                                <h2 class="fw-bolder" id="eventTitle"></h2>
                                <input type="hidden" name="eventId" id="eventId">
                            </div>
                        </div>
                        <!--end::Modal header-->
						<!--begin::Modal body-->
						<div class="modal-body scroll-y mx-2 mx-xl-2 pt-2 pb-5">
                            <div class="row g-10">
                                <div class="col-md-12">
                                    <!--begin::Feature post-->
                                    <div class="card-xl-stretch mx-md-6">
                                        <!--begin::Overlay-->
                                        <a class="d-block overlay" data-fslightbox="lightbox-hot-sales" id="eventImgUrl" href="">
                                            <!--begin::Image-->
                                            <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-250px" id="eventImg" style="background-image:url('')"></div>
                                            <!--end::Image-->
                                            <!--begin::Action-->
                                            <div class="overlay-layer card-rounded bg-dark bg-opacity-25">
                                                <i class="bi bi-eye-fill fs-2x text-white"></i>
                                            </div>
                                            <!--end::Action-->
                                        </a>
                                        <!--end::Overlay-->
                                        <!--begin::Body-->
                                        <div class="mt-5">
                                            <!--begin::Text-->
                                            <div class="fs-6 fw-bolder mt-5 d-flex flex-stack">
                                                <!--begin::Label-->
                                                <span class="badge fs-2 fw-bolder text-dark p-2">
                                                    <span class="fs-6 fw-bold text-gray-400"> <i class="bi bi-calendar-date"></i> <span id="eventDate"></span> </span>
                                                    <span class="fs-6 fw-bold text-gray-400"> <i class="bi bi-clock"></i> <span id="eventFrom"></span> -  <span id="eventTo"></span> </span>
                                                    
                                                </span>
                                                <!--end::Label-->
                                            </div>
                                            <!--end::Text-->
                                            <!--begin::Text-->
                                            <div class="fw-bold fs-5 text-gray-600 text-dark my-3" id="eventDescription"></div>
                                            <!--end::Text-->
                                            <!--begin::Action-->
                                            <div class="row ">
                                                <div class="col-md-6 d-grid">
                                                    <a id="deleteEvent" class="btn btn-danger" >Delete</a>
                                                </div>
                                                <div class="col-md-6 d-grid">
                                                    <a href="#" class="btn btn-primary" target="_blank">View</a>
                                                </div>
                                            </div>
                                            <!--end::Action-->
                                        </div>
                                        <!--end::Body-->
                                    </div>
                                    <!--end::Feature post-->
                                </div>
                            </div>
						</div>
						<!--end::Modal body-->
					</div>
				<!--end::Modal content-->
			</div>
			<!--end::Modal dialog-->
		</div>
		<!--end::Modal - Invite Friend--> 