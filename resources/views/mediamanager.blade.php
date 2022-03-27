@extends('admin.layouts.master-soyuz')
@section('title',__('Media Manager'))
@section('body')

@component('admin.component.breadcumb',['secondactive' => 'active'])
  @slot('heading')
    {{ __('Media Manager') }}
  @endslot

  @slot('menu2')
    {{ __("Media Manager") }}
  @endslot

@endcomponent

  

  <div class="contentbar">
    <div class="row">
      
      <div class="col-lg-12">

        

        <div class="card m-b-30">
          <div class="card-body">

            <ul class="tabbable nav nav-pills mb-3" id="pills-tab" role="tablist">

                <li class="nav-item" role="presentation">
                  <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#brand" role="tab" aria-controls="brand" aria-selected="true"><i class="feather icon-folder"></i> {{ __('Brand') }}</a>
                </li>
                <li class="nav-item" role="presentation">
                  <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#logodir" role="tab" aria-controls="logodir" aria-selected="false"><i class="feather icon-folder"></i> {{ __("Logo") }}</a>
                </li>
                <li class="nav-item" role="presentation">
                  <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#simple_products" role="tab" aria-controls="simple_products" aria-selected="false"><i class="feather icon-folder"></i> {{ __("Simple Products") }}</a>
                </li>

                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#product_files" role="tab" aria-controls="simple_products" aria-selected="false"><i class="feather icon-folder"></i> {{ __("Digital Product Files") }}</a>
                </li>

                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#category_files" role="tab" aria-controls="simple_products" aria-selected="false"><i class="feather icon-folder"></i> {{ __("Category Files") }}</a>
                </li>

                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#subcategory_files" role="tab" aria-controls="simple_products" aria-selected="false"><i class="feather icon-folder"></i> {{ __("Subcategory Files") }}</a>
                </li>

                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#blog_files" role="tab" aria-controls="blog_files" aria-selected="false"><i class="feather icon-folder"></i> {{ __("Blog Files") }}</a>
                </li>

                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#manual_payment" role="tab" aria-controls="blog_files" aria-selected="false"><i class="feather icon-folder"></i> {{ __("Manual Payment") }}</a>
                </li>

                <li class="nav-item" role="presentation">
                  <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#simple_pro_gallery" role="tab" aria-controls="simple_pro_gallery" aria-selected="false"><i class="feather icon-folder"></i> {{ __("Simple Products Gallery") }}</a>
              </li>

              </ul>

              <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="brand" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div data-midia-can_choose="false" id="media1"></div>
                </div>
                <div class="tab-pane fade" id="logodir" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <div data-midia-can_choose="false" id="media2"></div>
                </div>
                <div class="tab-pane fade" id="simple_products" role="tabpanel" aria-labelledby="pills-contact-tab">
                    <div data-midia-can_choose="false" id="media3"></div>
                </div>
                <div class="tab-pane fade" id="product_files" role="tabpanel" aria-labelledby="pills-contact-tab">
                    <div data-midia-can_choose="false" id="media4"></div>
                </div>
                <div class="tab-pane fade" id="category_files" role="tabpanel" aria-labelledby="pills-contact-tab">
                    <div data-midia-can_choose="false" id="media5"></div>
                </div>
                <div class="tab-pane fade" id="subcategory_files" role="tabpanel" aria-labelledby="pills-contact-tab">
                    <div data-midia-can_choose="false" id="media6"></div>
                </div>
                <div class="tab-pane fade" id="blog_files" role="tabpanel" aria-labelledby="pills-contact-tab">
                    <div data-midia-can_choose="false" id="media7"></div>
                </div>
                <div class="tab-pane fade" id="manual_payment" role="tabpanel" aria-labelledby="pills-contact-tab">
                    <div data-midia-can_choose="false" id="media8"></div>
                </div>
                <div class="tab-pane fade" id="simple_pro_gallery" role="tabpanel" aria-labelledby="pills-contact-tab">
                  <div data-midia-can_choose="false" id="media9"></div>
                </div>
              </div>

            
          </div>
        </div>
      </div>
    </div>
  </div>

  @endsection
  @section('custom-script')
    <script>
        $("#media1").midia({
            inline: true,
            base_url: '{{url('')}}',
            title : 'Brand Media Manager',
            directory_name : 'brand',
            dropzone : {
              acceptedFiles: '.jpg,.png,.jpeg,.webp,.bmp,.gif,.pdf,.docx,.doc'
            }
        });

        $("#media2").midia({
            inline: true,
            base_url: '{{url('')}}',
            title : 'Logo Media Manager',
            directory_name : 'logo'
        });

        $("#media3").midia({
            inline: true,
            base_url: '{{url('')}}',
            title : 'Simple Products Media Manager',
            directory_name : 'simple_products',
            dropzone : {
              acceptedFiles: '.jpg,.png,.jpeg,.webp,.bmp,.gif,.pdf,.docx,.doc'
            }
        });

        $("#media4").midia({
            inline: true,
            base_url: '{{url('')}}',
            title : 'Digital Product Files Media Manager',
            directory_name : 'product_files',
            dropzone : {
              acceptedFiles: '.jpg,.png,.jpeg,.webp,.bmp,.gif,.pdf,.docx,.doc'
            }
        });

        $("#media5").midia({
            inline: true,
            base_url: '{{url('')}}',
            title : 'Category Files Media Manager',
            directory_name : 'category',
            dropzone : {
              acceptedFiles: '.jpg,.png,.jpeg,.webp,.bmp,.gif,.pdf,.docx,.doc'
            }
        });

        $("#media6").midia({
            inline: true,
            base_url: '{{url('')}}',
            title : 'Subcategory Files Media Manager',
            directory_name : 'subcategory',
            dropzone : {
              acceptedFiles: '.jpg,.png,.jpeg,.webp,.bmp,.gif,.pdf,.docx,.doc'
            }
        });

        $("#media7").midia({
            inline: true,
            base_url: '{{url('')}}',
            title : 'Blog Files Media Manager',
            directory_name : 'blog',
            dropzone : {
              acceptedFiles: '.jpg,.png,.jpeg,.webp,.bmp,.gif,.pdf,.docx,.doc'
            }
        });

        $("#media8").midia({
            inline: true,
            base_url: '{{url('')}}',
            title : 'Manual Payment Files Media Manager',
            directory_name : 'manual_payment',
            dropzone : {
              acceptedFiles: '.jpg,.png,.jpeg,.webp,.bmp,.gif,.pdf,.docx,.doc'
            }
        });

        $("#media9").midia({
            inline: true,
            base_url: '{{url('')}}',
            title : 'Simple Products Gallery Files Media Manager',
            directory_name : 'simple_products_gallery',
            dropzone : {
              acceptedFiles: '.jpg,.png,.jpeg,.webp,.bmp,.gif,.pdf,.docx,.doc'
            }
        });
    </script> 
  @endsection