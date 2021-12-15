@include('backend.partials.main')
    <head>
        @include('backend.partials.title-meta')
        <!-- DataTables -->
        <link href="backend/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="backend/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />

        <!-- Responsive datatable examples -->
        <link href="backend/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        @include('backend.partials.head-css')

    </head>

    @include('backend.partials.body')
        
        <!-- Begin page -->
        <div id="layout-wrapper">

            @include('backend.partials.menu')

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        @include('backend.partials.page-title')
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">

                                        <h5 class="card-title">Category Lists</h5>
                                        <p class="card-title-desc">
                                            <a href="{{route('category.create')}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Add User"><i class="fas fa-plus"></i> Add Category</a>
                                        </p>
                                        <div class="table-responsive">
                                            <table id="datatable" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Category Name</th>
                                                        <th>Created_at</th>
                                                        <th>Update_at</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($categories as $category)
                                                    <tr>
                                                        <td>{{$category->id}}</td>
                                                        <td>{{$category->cate_name}}</td>
                                                        <td>{{$newDateFormat = date('d M Y', strtotime($category->created_at))}}</td>
                                                        <td>{{$newDateFormat = date('d M Y', strtotime($category->updated_at))}}</td>
                                                        <td>
                                                            <a href="{{route('category.edit',$category->id)}}" class="btn btn-primary btn-sm " style="height:30px; width:30px;border-radius:50%;float:left;margin-right:10px" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                                                            <form method="POST" action="{{route('category.destroy',[$category->id])}}">
                                                                @csrf
                                                                @method('delete')
                                                                <button class="btn btn-danger btn-sm nutXoaDayNe" data-id={{$category->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->
                        </div>
                      
                        <!-- end row -->

                        

                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->


                @include('backend.partials.footer')
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        @include('backend.partials.right-sidebar')

        @include('backend.partials.vendor-scripts')

        @include('backend.partials.table')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
        <script>
            //Script tạo popup hiện lên khi bấm nút xóa
            $(document).ready(function() {
                $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                });
                $('.nutXoaDayNe').click(function(e) {
                var form = $(this).closest('form');
                var dataID = $(this).data('id');
                // alert(dataID);
                e.preventDefault();
                swal({
                    title: "Confirm!",
                    text: "Category that has been deleted cannot be retrieved!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    })
                    .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    } else {
                        swal("Oh good luck, not deleted yet!!!");
                    }
                    });
                })
            })
        </script>
    </body>

</html>