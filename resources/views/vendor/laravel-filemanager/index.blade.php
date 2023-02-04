@extends('layouts.admin.master')

@section('styles')

{{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"> --}}
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.css">
<link rel="stylesheet" href="{{ asset('vendor/laravel-filemanager/css/cropper.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/laravel-filemanager/css/dropzone.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/laravel-filemanager/css/mime-icons.min.css') }}">
{{-- <style>{!! \File::get(base_path('vendor/unisharp/laravel-filemanager/public/css/lfm.css')) !!}</style> --}}
<style>a {
  color: #333844;
  text-decoration: none !important;
  cursor: pointer;
}

#nav a, #fab a {
  color: white;
}

#nav, #nav .dropdown-menu, .bg-main {
  background-color: #333844;
}

#nav .dropdown-menu > a:hover {
  color: #333844;
}

#actions {
  display: flex;
}

#actions > a {
  display: inline-block;
  line-height: 4rem;
  text-align: center;
  width: 100%;
  font-size: 1.25rem;
}

#actions > a > i {
  margin-right: .25rem;
}

#actions > a + a {
  border-left: 1px solid #dee2e6;
}

#multi_selection_toggle > i {
  font-size: 20px;
}

.breadcrumb-item:not(.active) {
  transition: .2s color;
}

.breadcrumb-item:not(.active):hover {
  cursor: pointer;
  color: #75C7C3;
}

#main {
  width: 100%;
}

@media screen and (min-width: 992px) {
  #main {
    width: calc(100% - 300px);
    /*margin-left: 1rem;*/
    padding: 1rem;
  }

  .invisible-lg {
    visibility: hidden;
  }
}

#tree {
  box-shadow: 0 0 28px 0 rgb(82 63 105 / 5%);
  padding: 0;
  background-color: var(--custom-side-bar-color);
  width: 300px;
  color: var(--custom-light-color)
}

@media screen and (max-width: 991px) {
  #tree {
    position: absolute;
    z-index: 999;
    left: 0;
    transform: translateX(-100%);
    transition: 1s transform;
  }

  #tree.in {
    transform: translateX(0);
  }
}

#empty {
  height: 60vh;
  color: #333844;
}

#empty:not(.d-none) {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}

#empty > i {
  font-size: 10rem;
}

.carousel-image {
  height: 50vh;
  background-position: center;
  background-size: contain;
  background-repeat: no-repeat;
  margin: 0 auto;
}

.carousel-indicators {
  bottom: 0;
}

.carousel-label, .carousel-label:hover {
  position: absolute;
  bottom: 0;
  background: linear-gradient(transparent 10px, rgba(0, 0, 0, .4), rgba(0, 0, 0, .5));
  padding: 40px 20px 30px;
  width: 100%;
  color: white;
  word-break: break-word;
  text-align: center;
}

.carousel-control-background {
  border-radius: 50%;
  width: 25px;
  height: 25px;
  box-shadow: 0 0 10px #666;
  background-color: #666;
}

#uploadForm > .dz-default.dz-message {
  border: 2px dashed #ccc;
  border-radius: 5px;
  color: #aaa;
  margin: 0;
  padding: 3rem 0;
}

/* Loader */

#lfm-loader {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: gray;
  opacity: 0.7;
  z-index: 9999;
  text-align: center;
}
#lfm-loader:before {
  content: "";
  display: inline-block;
  vertical-align: middle;
  height: 100%;
}
#lfm-loader img {
  width: 100px;
  margin: 0 auto;
  display: inline-block;
  vertical-align: middle;
}

/* Sidebar */

.nav-pills > .nav-item > .nav-link {
  height: 5rem;
  display: flex;
  align-items: center;
  color: var(--custom-light-color)
}

.nav-pills > .sub-item > .nav-link {
  height: 3rem;
  padding-left: 3rem;
}

/* .nav-pills > li.active > a, .nav-pills > li:hover > a {
  background-color: #ddd;
  border-radius: 0;
  color: #333844;
} */

/* Items */

#pagination > ul.pagination {
  justify-content: center;
}

#pagination.preserve_actions_space {
  padding-bottom: 1em;
  padding-top: 4rem; /* preserve space for main actions */
}

.square {
  cursor: pointer;
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 5px;
}

.grid {
  display: flex;
  flex-wrap: wrap;
  padding: .5rem;
  justify-content: center;
}

.grid a {
  margin: .5rem;
  display: flex;
  flex-direction: column;
}

.list a {
  border-top: 1px solid rgb(221, 221, 221);
  padding: 5px;
  margin-top: 0;
  display: flex;
  flex-direction: row;
}

.list a:last-child {
  border-bottom: 1px solid rgb(221, 221, 221);
}

.grid .square {
  border: 1px solid rgb(221, 221, 221);
  width: 135px;
  height: 135px;
}

.list .square {
  margin-right: 1rem;
  width: 70px;
  height: 70px;
}

.square > div {
  width: 100%;
  height: 100%;
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
}

.square > i {
  color: #333844;
}
.grid .square > i {
  padding: 20px;
  font-size: 80px;
}
.list .square > i {
  padding: 10px;
  font-size: 50px;
}

.grid .square.selected {
  border: 5px solid #75C7C3;
}
.list .square.selected {
  border: 4px solid #75C7C3;
}
.square.selected {
  padding: 1px;
}

.grid .item_name {
  border: 1px solid rgb(221, 221, 221);
  border-top: none;
  margin-top: -1px;
  padding: 10px;
  text-align: center;
  max-width: calc(135px);
}

.list .item_name {
  font-size: 1.25rem;
  padding: 5px 0 5px;
}

time {
  font-size: .9rem;
}

.grid time {
  display: none;
}

.info > * {
  max-width: calc(100vw - 70px - 60px);
}

/* Mime icon generator overwrite */

.grid .mime-icon:before {
  top: calc(45% - 1rem);
  font-size: 2rem;
}

.list .mime-icon .ico:before {
  top: calc(45% - .5rem);
  font-size: 1rem;
}

.mime-icon .ico {
  height: 100%;
  display: inline-flex;
  align-items: center;
  width: 100%;
  justify-content: center;
}

/* Floating action buttons */

.fab-wrapper {
  margin: 1.5rem;
  right: 0;
  bottom: 0;
  position: fixed;
}

.fab-wrapper .fab-button {
  position: relative;
  background-color: #333844;
  width: 3.5rem;
  height: 3.5rem;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.25rem;
  box-shadow: 0 0 4px rgba(0, 0, 0, 0.14), 0 4px 8px rgba(0, 0, 0, 0.28);
}

.fab-wrapper .fab-toggle {
  z-index: 1;
}

.fab-wrapper .fab-toggle i {
  -webkit-transform: scale(1) rotate(0deg);
  transform: scale(1) rotate(0deg);
  -webkit-transition: -webkit-transform 350ms;
  transition: transform 350ms;
}

.fab-wrapper.fab-expand .fab-toggle i {
  -webkit-transform: scale(1) rotate(-225deg);
  transform: scale(1) rotate(-225deg);
  -webkit-transition: -webkit-transform 350ms;
  transition: transform 350ms;
}

.fab-wrapper .fab-action {
  z-index: -1;
  margin-bottom: -3.5rem;
  opacity: 0;
  transition: margin-bottom 350ms, opacity 350ms;
}

.fab-wrapper.fab-expand .fab-action {
  margin-bottom: 1rem;
  opacity: 1;
  transition: margin-bottom 350ms, opacity 350ms;
}

.fab-wrapper .fab-action:before {
  position: absolute;
  right: 4rem;
  padding: .15rem .75rem;
  border-radius: .25rem;
  background-color: rgba(0, 0, 0, .4);
  color: rgba(255, 255, 255, .8);
  text-align: right;
  font-size: .9rem;
  white-space: nowrap;
  content: attr(data-label);
}
    #nav, #nav .dropdown-menu, .bg-main {
      background-color: var(--custom-header-color)
    }
    #breadcrumbs .breadcrumb .breadcrumb-item {
        display: flex;
        align-items: center;
        padding-left: 0;
        padding-right: 0.5rem;
        margin-top: 15px;
        margin-left: 15px;
        font-size: 18px;
    }
    #tree .nav-pills .nav-item {
    margin-right: 0;
    }

    #tree .nav-pills .nav-item.active {
        transition: color 0.2s ease, background-color 0.2s ease !important;
        background-color: var(--custom-side-bar-active) !important;
        color: #ffffff !important;
    }
    /* #tree .nav-pills .nav-item.active:after {
        width: 0 !important;
        height: 0 !important;
        border: 10px solid transparent;
        top: 0 !important;
        bottom: 0 !important;
        margin: auto !important;
        right: 0 !important;
        border-right-color: var(--custom-light-color) !important;
        border-top-width: 22px !important;
        border-bottom-width: 22px !important;
        content: " " !important;
        position: absolute !important;
    } */
    #tree .nav-pills .nav-item.active:after {
    /* width: 0 !important; */
    /* height: 0 !important; */
    border: 20px solid transparent;
    /* top: -16px !important; */
    /* bottom: 42% !important; */
    /* margin: auto !important; */
    /* right: 0 !important; */
    border-right-color: var(--custom-light-color);
    border-top-width: 32px !important; 
    border-bottom-width: 32px !important;
    content: " " !important;
    /* position: fixed; */
    /* display: flex !important; */
    /* flex-basis: auto; */
    float: right;
    margin-top: -64px;
    margin-left: 197px;
    /* color: #fff !important; */
}
</style>
@endsection
@section('content')

@php
$titles=[
'title' => "Media",
'sub-title' => "Library",
'btn' => '',
'url' => ''
]
@endphp
@include('admin.components.top-bar', $titles)

<!--begin::Post-->
<div class="post d-flex flex-column-fluid" id="kt_post">
    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">
        <!--begin::Alert-->
        @include('admin.components.alerts')
		
        <!--end::Alert-->
        
										<!--begin::LFM-->
                      <nav class="navbar  navbar-expand-lg navbar-dark " id="nav">
                        <a class="navbar-brand invisible-lg d-none d-lg-inline ms-4" id="to-previous">
                          <i class="fas fa-arrow-left fa-fw"></i>
                          <span class="d-none d-lg-inline">{{ trans('laravel-filemanager::lfm.nav-back') }}</span>
                        </a>
                        <a class="navbar-brand d-block d-lg-none" id="show_tree">
                          <i class="fas fa-bars fa-fw"></i>
                        </a>
                        <a class="navbar-brand d-block d-lg-none" id="current_folder"></a>
                        <a id="loading" class="navbar-brand"><i class="fas fa-spinner fa-spin"></i></a>
                        <div class="ml-auto px-2">
                          <a class="navbar-link d-none" id="multi_selection_toggle">
                            <i class="fa fa-check-double fa-fw"></i>
                            <span class="d-none d-lg-inline">{{ trans('laravel-filemanager::lfm.menu-multiple') }}</span>
                          </a>
                        </div>
                        <a class="navbar-toggler collapsed border-0 px-1 py-2 m-0" data-toggle="collapse" data-target="#nav-buttons">
                          <i class="fas fa-cog fa-fw"></i>
                        </a>
                        <div class="collapse navbar-collapse flex-grow-1 justify-content-end" id="nav-buttons">
                          <ul class="navbar-nav">
                            <li class="nav-item">
                              <a class="nav-link" data-display="grid">
                                <i class="fas fa-th-large fa-fw"></i>
                                <span>{{ trans('laravel-filemanager::lfm.nav-thumbnails') }}</span>
                              </a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" data-display="list">
                                <i class="fas fa-list-ul fa-fw"></i>
                                <span>{{ trans('laravel-filemanager::lfm.nav-list') }}</span>
                              </a>
                            </li>
                            <li class="nav-item dropdown">
                              <a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-sort fa-fw"></i>{{ trans('laravel-filemanager::lfm.nav-sort') }}
                              </a>
                              <div class="dropdown-menu dropdown-menu-right border-0"></div>
                            </li>
                          </ul>
                        </div>
                      </nav>

                      <div class="d-flex flex-row">
                        <div id="tree" class="mt-4"></div>

                        <div id="main" class="p-0 pt-4 ms-4">
                          <div class="card" class="min-height:300px">
                            <div id="alerts"></div>
                            <nav aria-label="breadcrumb" class="d-none d-lg-block card-title" id="breadcrumbs">
                              <ol class="breadcrumb">
                                <li class="breadcrumb-item invisible">Home</li>
                              </ol>
                            </nav>
                            <div class="card-body">

                            <div id="empty" class="d-none">
                              <i class="far fa-folder-open"></i>
                              {{ trans('laravel-filemanager::lfm.message-empty') }}
                            </div>
  
                            <div id="content" class="mb-8"></div>
                            <div id="pagination" ></div>
  
                            <a id="item-template" class="d-none">
                              <div class="square"></div>
  
                              <div class="info">
                                <div class="item_name text-truncate"></div>
                                <time class="text-muted font-weight-light text-truncate"></time>
                              </div>
                            </a>

                            </div>
                          </div>
                        </div>

                        <div id="fab"></div>
                      </div>

                      <nav class=" border-top d-none text-info mt-8" id="actions" style="background-color: var(--custom-header-color);">
                        <a data-action="open" data-multiple="false" class="text-info"><i class="fas fa-folder-open text-info"></i>{{ trans('laravel-filemanager::lfm.btn-open') }}</a>
                        <a data-action="preview" data-multiple="true" class="text-info"><i class="fas fa-images text-info"></i>{{ trans('laravel-filemanager::lfm.menu-view') }}</a>
                        <a data-action="use" data-multiple="true" class="text-info"><i class="fas fa-check text-info"></i>{{ trans('laravel-filemanager::lfm.btn-confirm') }}</a>
                      </nav>


                      
                      <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered mw-650px">
                          <div class="modal-content">
                          <div class="modal-header d-flex flex-row-reverse ribbon ribbon-start ribbon-clip">
                              <div class="ribbon-label fw-bolder">
                                  Upload
                                  <span class="ribbon-inner bg-success"></span>
                              </div>
                              <div class="btn btn-icon btn-sm btn-active-icon-primary w-5 float-end"  data-bs-dismiss="modal">
                                  <span class="svg-icon svg-icon-1">
                                      {!! getSvg('arr061') !!}
                                  </span>
                              </div>
                              <div class="btn btn-icon btn-sm btn-active-icon-primary w-95 float-end">
                                  <h2 class="fw-bolder">{{ trans('laravel-filemanager::lfm.title-upload') }}</h2>
                              </div>
                          </div>
                            <div class="modal-body  m-8">
                              <form action="{{ route('unisharp.lfm.upload') }}" role='form' id='uploadForm' name='uploadForm' method='post' enctype='multipart/form-data' class="dropzone">
                                <div class="form-group" id="attachment">
                                  <div class="controls text-center">
                                    <div class="input-group w-100">
                                      <a class="btn btn-primary w-100 text-white" id="upload-button">{{ trans('laravel-filemanager::lfm.message-choose') }}</a>
                                    </div>
                                  </div>
                                </div>
                                <input type='hidden' name='working_dir' id='working_dir'>
                                <input type='hidden' name='type' id='type' value='{{ request("type") }}'>
                                <input type='hidden' name='_token' value='{{csrf_token()}}'>
                              </form>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary w-100"   data-bs-dismiss="modal">{{ trans('laravel-filemanager::lfm.btn-close') }}</button>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="modal fade" id="notify" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered mw-650px">
                          <div class="modal-content">
                          <div class="modal-header d-flex flex-row-reverse ribbon ribbon-start ribbon-clip">
                              <div class="ribbon-label fw-bolder">
                                  Notify
                                  <span class="ribbon-inner bg-info"></span>
                              </div>
                              <div class="btn btn-icon btn-sm btn-active-icon-primary w-5 float-end"  data-bs-dismiss="modal">
                                  <span class="svg-icon svg-icon-1">
                                      {!! getSvg('arr061') !!}
                                  </span>
                              </div>
                          </div>
                            <div class="modal-body m-8" style="
                            box-shadow: 0 0 28px 0 rgb(82 63 105 / 5%);
                            padding: 0;
                            background-color: var(--custom-side-bar-color);
                            color: var(--custom-light-color);
                            padding:1rem">
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">{{ trans('laravel-filemanager::lfm.btn-close') }}</button>
                              <button type="button" class="btn btn-primary w-100" data-bs-dismiss="modal">{{ trans('laravel-filemanager::lfm.btn-confirm') }}</button>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="modal fade" id="dialog" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered mw-650px">
                          <div class="modal-content">
                          <div class="modal-header d-flex flex-row-reverse ribbon ribbon-start ribbon-clip">
                              <div class="ribbon-label fw-bolder">
                                  Dialog
                                  <span class="ribbon-inner bg-warning"></span>
                              </div>
                              <div class="btn btn-icon btn-sm btn-active-icon-primary w-5 float-end"  data-bs-dismiss="modal">
                                  <span class="svg-icon svg-icon-1">
                                      {!! getSvg('arr061') !!}
                                  </span>
                              </div>
                          </div>
                            <div class="modal-body my-1">
                              <input type="text" class="form-control">
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">{{ trans('laravel-filemanager::lfm.btn-close') }}</button>
                              <button type="button" class="btn btn-primary w-100" data-bs-dismiss="modal">{{ trans('laravel-filemanager::lfm.btn-confirm') }}</button>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div id="carouselTemplate" class="d-none carousel slide bg-light" data-ride="carousel">
                        <ol class="carousel-indicators">
                          <li data-target="#previewCarousel" data-slide-to="0" class="active"></li>
                        </ol>
                        <div class="carousel-inner">
                          <div class="carousel-item active">
                            <a class="carousel-label"></a>
                            <div class="carousel-image"></div>
                          </div>
                        </div>
                        <a class="carousel-control-prev" href="#previewCarousel" role="button" data-slide="prev">
                          <div class="carousel-control-background" aria-hidden="true">
                            <i class="fas fa-chevron-left"></i>
                          </div>
                          <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#previewCarousel" role="button" data-slide="next">
                          <div class="carousel-control-background" aria-hidden="true">
                            <i class="fas fa-chevron-right"></i>
                          </div>
                          <span class="sr-only">Next</span>
                        </a>
                      </div>
                      
										<!--end::LFM-->
    <!--end::Container-->
</div>
<!--end::Post-->

@endsection
@push('js')
@endpush
@section('scripts')
<!-- Custom Functions -->
  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
  <script src="{{ asset('vendor/laravel-filemanager/js/cropper.min.js') }}"></script>
  <script src="{{ asset('vendor/laravel-filemanager/js/dropzone.min.js') }}"></script>
  <script>
    var lang = {!! json_encode(trans('laravel-filemanager::lfm')) !!};
    var actions = [
      // {
      //   name: 'use',
      //   icon: 'check',
      //   label: 'Confirm',
      //   multiple: true
      // },
      {
        name: 'rename',
        icon: 'edit',
        label: lang['menu-rename'],
        multiple: false
      },
      {
        name: 'download',
        icon: 'download',
        label: lang['menu-download'],
        multiple: true
      },
      // {
      //   name: 'preview',
      //   icon: 'image',
      //   label: lang['menu-view'],
      //   multiple: true
      // },
      {
        name: 'move',
        icon: 'paste',
        label: lang['menu-move'],
        multiple: true
      },
      {
        name: 'resize',
        icon: 'arrows-alt',
        label: lang['menu-resize'],
        multiple: false
      },
      {
        name: 'crop',
        icon: 'crop',
        label: lang['menu-crop'],
        multiple: false
      },
      {
        name: 'trash',
        icon: 'trash',
        label: lang['menu-delete'],
        multiple: true
      },
    ];

    var sortings = [
      {
        by: 'alphabetic',
        icon: 'sort-alpha-down',
        label: lang['nav-sort-alphabetic']
      },
      {
        by: 'time',
        icon: 'sort-numeric-down',
        label: lang['nav-sort-time']
      }
    ];
  </script>
  <script>{!! \File::get(base_path('vendor/unisharp/laravel-filemanager/public/js/script.js')) !!}</script>
  {{-- Use the line below instead of the above if you need to cache the script. --}}
  {{-- <script src="{{ asset('vendor/laravel-filemanager/js/script.js') }}"></script> --}}
  <script>
    Dropzone.options.uploadForm = {
      paramName: "upload[]", // The name that will be used to transfer the file
      uploadMultiple: false,
      parallelUploads: 5,
      timeout:0,
      clickable: '#upload-button',
      dictDefaultMessage: lang['message-drop'],
      init: function() {
        var _this = this; // For the closure
        this.on('success', function(file, response) {
          if (response == 'OK') {
            loadFolders();
          } else {
            this.defaultOptions.error(file, response.join('\n'));
          }
        });
      },
      headers: {
        'Authorization': 'Bearer ' + getUrlParam('token')
      },
      acceptedFiles: "{{ implode(',', $helper->availableMimeTypes()) }}",
      maxFilesize: ({{ $helper->maxUploadSize() }} / 1000)
    }
  </script>
<!-- Toaster Alerts -->
@include('admin.components.toaster')
@endsection
