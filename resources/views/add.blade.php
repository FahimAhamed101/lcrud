{{-- @extends('admin.admin_dashboard')

@section('title', 'Admin')

@section('admin')

@endsection --}}


@extends('admin_dashboard')


@section('admin')
    <!--start page wrapper -->
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Product</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                          
                            <a href=""><i class="bx bx-home-alt"></i></a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="card container">
            <div class="card-body p-4">
                <h5 class="card-title">Add New Product</h5>
                <hr />
                <form id="myForm"  action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data" >
                    @csrf
                    <div class="form-body mt-4">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="border border-3 p-4 rounded">
                                    <div class="form-group mb-3">
                                        <label for="inputProductTitle" class="form-label">Product Name</label>
                                        <input type="text" name="product_name" class="form-control" id="product_name"
                                            placeholder="Enter product Name" />
                                    </div>


                                    <div class="mb-3">
                                        <label for="inputProductDescription" class="form-label">Full Description</label>
                                        <textarea id="mytextarea" name="long_disc">Hello, World!</textarea>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="inputProductDescription" class="form-label">Main Images</label>
                                        <input class="form-control" type="file" name="product_thumbnail" id="formFile" onChange="mainImage(this)"> <br>
                                        <img src="" id="mainImageShow" alt="">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="inputProductDescription" class="form-label">Multiple Images</label>
                                        <input class="form-control" name="multi_img[]" type="file" id="multiImg" multiple=""><br>

                                        <div class="row" id="preview_img"></div>

                                    </div>

                                </div>
                            </div>
                      
                             

                                 
                                        <div class="col-12">
                                            <div class="d-grid">
                                                <input type="submit" class="btn btn-primary px-4" value="Save Change" />
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                           
                            </div>
                        </div>
                        <!--end row-->
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    <!--end page wrapper -->

@endsection

@section('script')

{{-- Form Validate script code --------------------------------------------------- --}}

<script type="text/javascript">
    $(document).ready(function (){
        $('#myForm').validate({
            rules: {
                product_name: {
                    required : true,
                },
                short_disc: {
                    required : true,
                },
                product_thumbnail: {
                    required : true,
                },
                multi_img: {
                    required : true,
                },
            
           
            },
            messages :{
                product_name: {
                    required : 'Please Enter Product Name',
                },
                short_disc: {
                    required : 'Please Enter Product Short Description',
                },
           
                multi_img: {
                    required : 'Please Enter Product Sub Image',
                },
            
            
            },
            errorElement : 'span',
            errorPlacement: function (error,element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight : function(element, errorClass, validClass){
                $(element).addClass('is-invalid');
            },
            unhighlight : function(element, errorClass, validClass){
                $(element).removeClass('is-invalid');
            },
        });
    });

</script>

    {{-- Sub Category Show script code --------------------------------------------------- --}}

  



    {{-- Single Image Show script ----------------------------------- --}}
    <script type="text/javascript">
        function mainImage(input){
            if (input.files && input.files[0]){
                var reader = new FileReader();
                reader.onload = function(e){
                    $('#mainImageShow').attr('src',e.target.result).width(80).height(80);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>


    {{-- Multi Image Show script code --------------------------------------------------- --}}
    <script>

        $(document).ready(function(){
         $('#multiImg').on('change', function(){ //on file input change
            if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
            {
                var data = $(this)[0].files; //this file data

                $.each(data, function(index, file){ //loop though each file
                    if(/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)){ //check supported file type
                        var fRead = new FileReader(); //new filereader
                        fRead.onload = (function(file){ //trigger function on successful read
                        return function(e) {
                            var img = $('<img/>').addClass('thumb').attr('src', e.target.result) .width(100)
                        .height(80); //create image element
                            $('#preview_img').append(img); //append image to output element
                        };
                        })(file);
                        fRead.readAsDataURL(file); //URL representing the file's data.
                    }
                });

            }else{
                alert("Your browser doesn't support File API!"); //if File API is absent
            }
         });
        });

        </script>



@endsection