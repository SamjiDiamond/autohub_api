@extends('layouts.admindashboard')
@section('title', 'Testimonials')

@section('content')

            @php
                $all = \App\Models\Testimonial::count();
            @endphp
            <!-- content @s -->
            <div class="nk-content nk-content-fluid">
                <div class="container-xl wide-xl">
                    <div class="nk-content-inner">
                        <div class="nk-content-body">
                            <div class="nk-block-head nk-block-head-sm">
                                <div class="nk-block-between">
                                    <div class="nk-block-head-content">
                                        <h3 class="nk-block-title page-title">Testimonial List</h3>
                                        <div class="nk-block-des text-soft">
                                            <p>You have total <b>{{$all}}</b> Testimonials.</p>
                                        </div>
                                    </div><!-- .nk-block-head-content -->
                                    <div class="nk-block-head-content">
                                        <div class="toggle-wrap nk-block-tools-toggle">
                                            <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                                            <div class="toggle-expand-content" data-content="pageMenu">
                                                <ul class="nk-block-tools g-3">
                                                    {{-- <li><a href="#" class="btn btn-white btn-outline-light"><em class="icon ni ni-download-cloud"></em><span>Export</span></a></li> --}}
                                                    <li><a href="#addTestimonial" data-toggle="modal" class="btn btn-white btn-outline-primary"><em class="icon ni ni-plus"></em><span>Add Testimonial</span></a></li>
                                                </ul>
                                            </div>
                                        </div><!-- .toggle-wrap -->
                                    </div><!-- .nk-block-head-content -->
                                </div><!-- .nk-block-between -->
                            </div><!-- .nk-block-head -->
                            <div class="nk-block">
                                <div class="row g-gs">
                                    @foreach($testimonials as $key => $data)
                                        <div class="col-sm-6 col-lg-4 col-xxl-3">
                                            <div class="card card-bordered">
                                                <div class="card-inner">
                                                    <div class="team">
                                                        @if($data->status ==1)
                                                            <div class="team-status bg-success text-white"><em class="icon ni ni-check-thick"></em></div>
                                                        @else
                                                            <div class="team-status bg-danger text-white"><em class="icon ni ni-na"></em></div>
                                                        @endif
                                                        <div class="team-options">
                                                            <div class="drodown">
                                                                <a href="#" class="dropdown-toggle btn btn-sm btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <ul class="link-list-opt no-bdr">
                                                                        <li><a href="#editTestimonial-{{$data->id}}" data-toggle="modal"><em class="icon ni ni-edit"></em><span>Edit Testimonial</span></a></li>
                                                                        <li class="divider"></li>
                                                                        @if($data->status ==0)
                                                                            <li><a href="{{ route('activate.testimonial', $data->id) }}"><em class="icon ni ni-check-circle"></em><span>Enable Testimonial</span></a></li>
                                                                        @else
                                                                            <li><a href="{{ route('deactivate.testimonial', $data->id) }}"><em class="icon ni ni-na"></em><span>Disable Testimonial</span></a></li>
                                                                        @endif
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="user-card user-card-s2">
                                                            @if(file_exists($data->image))
                                                                <img style="background-color: #8e8eec; border-radius: 20%;" src="{{url($data->image)}}" width="150px" alt="">
                                                            @else
                                                                <img style="background-color: #8e8eec; border-radius: 20%;" src="{{url('assets/images/testimonial/testimonial.png')}}" width="150px" alt="">
                                                            @endif
                                                            <div class="user-info">
                                                                <h6>{{$data->name}}</h6>
                                                                <span class="sub-text">{{$data->role}}</span>
                                                            </div>
                                                        </div>
                                                        <div class="team-view">
                                                            <a href="#editTestimonial-{{$data->id}}" data-toggle="modal" class="btn btn-round btn-outline-light w-150px"><span>Edit Testimonial</span></a>
                                                        </div>
                                                    </div><!-- .team -->
                                                </div><!-- .card-inner -->
                                            </div><!-- .card -->
                                        </div><!-- .col -->
                                    @endforeach
                                </div>
                            </div><!-- .nk-block -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- content @e -->

            <!-- Modal Form -->
            <div class="modal fade" tabindex="-1" id="addTestimonial">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add New Testimonial</h5>
                            <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                                <em class="icon ni ni-cross"></em>
                            </a>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{route('create-testimonial')}}" enctype="multipart/form-data" class="form-validate is-alter">
                                {{ csrf_field() }}
                                <div class="row g-4">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="form-label-group">
                                                <label class="form-label">Name <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="form-control-group">
                                                <input type="text" class="form-control" name="name" required>
                                            </div>
                                        </div>
                                    </div><!-- .col -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="form-label-group">
                                                <label class="form-label">Role <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="form-control-group">
                                                <input type="text" class="form-control" name="role" required>
                                            </div>
                                        </div>
                                    </div><!-- .col -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="form-label-group">
                                                <label class="form-label">Comment <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="form-control-group">
                                                <input type="text" class="form-control" name="comment" required>
                                            </div>
                                        </div>
                                    </div><!-- .col -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="form-label-group">
                                                <label class="form-label">Testimonial Image <span class="text-danger">* - <code>211x211px prefered</code></span></label>
                                            </div>
                                            <div class="form-control-group custom-file">
                                                <input type="file" multiple class="custom-file-input" name="image" accept="image/*"  id="customFile">
                                                <label class="custom-file-label" for="customFile">Choose file</label>
                                            </div>
                                        </div>
                                    </div><!-- .col -->
                                </div>
                                <div class="form-group  pt-2">
                                    <button type="submit" class="btn btn-lg btn-primary">Add Testimonial</button>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer bg-light">
                            <span class="sub-text">Add New Testimonial</span>
                        </div>
                    </div>
                </div>
            </div>

        @foreach($testimonials as $key => $data)
            <!-- Modal Form -->
            <div class="modal fade" tabindex="-1" id="editTestimonial-{{$data->id}}">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit {{$data->name}} Details</h5>
                            <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                                <em class="icon ni ni-cross"></em>
                            </a>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{route('edit-testimonial')}}" enctype="multipart/form-data" class="form-validate is-alter">
                                {{ csrf_field() }}
                                <input type="hidden" class="form-control form-control-lg" name="id" value="{{$data->id}}" required>
                                <div class="row g-4">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="form-label-group">
                                                <label class="form-label">Fullname</label>
                                            </div>
                                            <div class="form-control-group">
                                                <input type="text" class="form-control form-control-lg" name="name" value="{{$data->name}}" required>
                                            </div>
                                        </div>
                                    </div><!-- .col -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="form-label-group">
                                                <label class="form-label">Role</label>
                                            </div>
                                            <div class="form-control-group">
                                                <input type="text" class="form-control form-control-lg" name="role" value="{{$data->role}}" required>
                                            </div>
                                        </div>
                                    </div><!-- .col -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="form-label-group">
                                                <label class="form-label">Comment</label>
                                            </div>
                                            <div class="form-control-group">
                                                <input type="text" class="form-control form-control-lg" name="comment" value="{{$data->comment}}" required>
                                            </div>
                                        </div>
                                    </div><!-- .col -->
                                    <div class="col-md-12">
                                        <center>
                                            @if(file_exists($data->image))
                                                <img style="background-color: #8e8eec; border-radius: 20%;" src="{{url($data->image)}}" width="150px" alt="">
                                            @else
                                                <img style="background-color: #8e8eec; border-radius: 20%;" src="{{url('assets/images/testimonial/testimonial.png')}}" width="150px" alt="">
                                            @endif
                                        </center>
                                    </div><!-- .col -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="form-label-group">
                                                <label class="form-label">Image <span class="text-danger">(Change Image) - <code>211x211px prefered</code></span></label>
                                            </div>
                                            <div class="form-control-group custom-file">
                                                <input type="file" multiple class="custom-file-input" name="image" accept="image/*"  id="customFile">
                                                <label class="custom-file-label" for="customFile">Choose file</label>
                                            </div>
                                        </div>
                                    </div><!-- .col -->
                                </div>
                                <div class="form-group  pt-2">
                                    <button type="submit" class="btn btn-lg btn-primary">Edit Testimonial</button>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer bg-light">
                            <span class="sub-text">Edit Testimonial</span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

@endsection
