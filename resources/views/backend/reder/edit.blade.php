@extends('backend.dasbroad.index')
@section('main-content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Reder List</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Amezia</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                            <li class="breadcrumb-item active">Form Validation</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-md-12 col-xl-6">
                <div class="card">
                    <div class="card-body">
                     

                        <form class="custom-validation" action="{{route('reder.update',$reders->id)}}" method="POST" enctype="multipart/form-data">
                         @csrf
                            @method('PATCH')
                            <div class="mb-4">
                                <label class="form-label">Name</label> 
                                <input type="text" class="form-control" name="manu_name" required="" value="{{$reders->manu_name}}" placeholder="Enter location name">
                                @error('manu_name')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Description</label>
                                <textarea id="elm1" name="description" >{{$reders->description}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="inputPhoto" class="col-form-label">Photo</label>
                                <div class="input-group">
                                    <input id="thumbnail" class="form-control" type="file" name="upload"  accept="image/*">
                                </div>
                                <img src="{{asset('public/backend/uploads/images/'.$reders->photo)}}" alt="" style="width: 100px;
    height: 100px;
    margin: 10px auto;">
                                <div id="holder" style="margin-top:15px;max-height:100px;"></div>

                                @error('photo')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Feature</label>
                                <input type="number" class="form-control" name="feature" required="" value="{{$reders->feature}}">
                               
                            </div>
                            <div class="mb-0">
                                <div>
                                <button type="reset" class="btn btn-danger waves-effect ms-1">
                                        Cancel
                                    </button>
                                    <button type="submit" class="btn btn-light waves-effect waves-light">
                                        Submit
                                    </button>
                                    
                                </div>
                            </div>
                        </form>
                        <!-- end form -->
                    </div>
                    <!-- end cardbody -->
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- container-fluid -->
</div>
@endsection
@push('scripts') 
<script src="{{asset('public/backend/assets/libs/tinymce/tinymce.min.js')}}"></script>

<script src="{{asset('public/backend/assets/js/pages/form-editor.init.js')}}"></script>

@endpush