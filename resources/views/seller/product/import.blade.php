@extends("admin.layouts.sellermastersoyuz")
@section('title',__("Import Product"))
@section('body')

@component('seller.components.breadcumb',['thirdactive' => 'active'])
@slot('heading')
   {{ __('Import Products') }}
@endslot
@slot('menu1')
   {{ __('Product') }}
@endslot
@slot('menu2')
   {{ __('Import Products') }}
@endslot
@slot('button')
<div class="col-md-6 col-lg-6">
  <div class="widgetbar">
    <a href="{{ url('/seller/products/') }}"  class="btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>

  </div>
</div>
@endslot



@endcomponent

<div class="contentbar">
	<!-- Start row -->
	<div class="row">
		<!-- Start col -->
		<div class="col-md-12">
			<div class="card m-b-30">
				<div class="card-header">
					<h5 class="card-title">
						{{__('Import Products')}}
					</h5>
				</div>
				<div class="card-body">
					<ul class="nav nav-tabs custom-tab-line mb-3" id="defaultTabLine" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="home-tab-line" data-toggle="tab" href="#home-line" role="tab" aria-controls="home-line" aria-selected="true"><i class="feather icon-download mr-2"></i>{{ __("Import variant products") }}</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="profile-tab-line" data-toggle="tab" href="#profile-line" role="tab" aria-controls="profile-line" aria-selected="false"><i class="feather icon-download mr-2"></i>{{ __("Import simple products") }}</a>
						</li>
						
					</ul>
					<div class="tab-content" id="defaultTabContentLine">
						<div class="tab-pane fade show active" id="home-line" role="tabpanel" aria-labelledby="home-tab-line">
							<a href="{{ url('files/ProductCSV.xlsx') }}" class="btn btn-primary mb-3"> <i class="feather icon-download mr-2"></i>{{ __('Download Example For xls/csv File') }}</a>
							<form action="{{ route('seller.import.store') }}" method="POST" enctype="multipart/form-data">
								{{ csrf_field() }}
						
							<div class="row">
								<div class="form-group col-md-6">
									<label for="file">{{ __('Choose your xls/csv File') }} :</label>

									<div class="input-group mb-3">
										<div class="input-group-prepend">
										  <span class="input-group-text" id="inputGroupFileAddon01">
											  {{__('Upload')}}
										  </span>
										</div>
										<div class="custom-file">
										  <input type="file" name="file" required="" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
										  
										  <label class="custom-file-label" for="inputGroupFile01">
											  {{__('Choose file')}}
										  </label>
										  @if ($errors->has('file'))
										  <span class="invalid-feedback text-danger" role="alert">
											  <strong>{{ $errors->first('file') }}</strong>
										  </span>
						                  @endif
										</div>
									  </div>
									  <button type="submit" class="btn btn-success"><i class="feather icon-download-cloud mr-1"></i> {{ __('Import') }}</button>

									
									
								
								</div>
								
							</div>
			
						    </form>
								<hr>
						<div class="table-responsive">
							<h4 class="card-title">{{ __('Instructions')}}</h4>
							<h6><b>{{ __('Follow the instructions carefully before importing the file.') }}</b></h6>
								<h6>
									{{__('The columns of the file should be in the following order.')}}
								</h6>
					
								<table id="datatable-button" class="table table-striped table-bordered">
									<thead>
										<tr>
											<th>{{ __('Column No') }}</th>
											<th>{{ __('Column Name') }}</th>
											<th>{{ __('Description') }}</th>
										</tr>
									</thead>
					
									<tbody>
										<tr>
											<th>1</th>
											<th><b>Category</b>(Required)</th>
											<th>Name of category</th>
					
											
										</tr>
					
										<tr>
											<th>2</th>
											<th><b>Subcategory</b> (Required)</th>
											<th>Name of subcategory</th>
										</tr>
					
										<tr>
											<th>3</th>
											<th><b>Childcategory</b> (Optional)</th>
											<th>Name of childcategory</th>
										</tr>
					
										<tr>
											<th>4</th>
											<th><b>Store Name</b> (Required)</th>
											<th>Name of your store (Must created before importing).</th>
										</tr>
					
										<tr>
											<th>5</th>
											<th><b>Brand Name</b> (Required)</th>
											<th>Name of your brand</th>
										</tr>
					
										<tr>
											<th>6</th>
											<th><b>Product Name</b> (Required)</th>
											<th>Name of your product</th>
										</tr>
					
										<tr>
											<th>7</th>
											<th><b>Product Description</b> (Optional)</th>
											<th>Detail of your product</th>
										</tr>
					
										<tr>
											<th>8</th>
											<th><b>Model</b> (Optional)</th>
											<th>Model No. of your product</th>
										</tr>
					
										<tr>
											<th>9</th>
											<th><b>SKU</b> (Optional)</th>
											<th>Detail of your product</th>
										</tr>
					
										<tr>
											<th>10</th>
											<th><b>Price In</b> (Required)</th>
											<th>Your Product price in currency (eg. INR,USD)</th>
										</tr>
					
										<tr>
											<th>11</th>
											<th><b>Price</b> (Required)</th>
											<th>Your Product price [<b>Note:</b> Price must entered in this format eg. 50000 (No comma and character).]</th>
										</tr>
					
										<tr>
											<th>12</th>
											<th><b>Offer Price</b> [<b>Note:</b> Leave blank if you dont want offer price.]</th>
											<th>Your Product offer price [<b>Note:</b> Price must entered in this format eg. 50000 (No comma and character).]</th>
										</tr>
					
										<tr>
											<th>13</th>
											<th><b>Featured</b> (Optional)</th>
											<th><p>Enable or disable product is featured or not.</p>
											<p>(Yes = 1, No = 0)</p>
											</th>
										</tr>
					
										<tr>
											<th>14</th>
											<th><b>Status</b> (Required)</th>
											<th><p>Enable or disable product is active or not.</p>
											<p>(Yes = 1, No = 0)</p>
											</th>
										</tr>
					
										<tr>
											<th>15</th>
											<th><b>Tax</b> (Required if your price is exclusive of tax)</th>
											<th><p>Enable tax class name (must created before enter name here) which you created in tax classes section or else enter <b>0</b>.</p>
											</th>
										</tr>
					
										<tr>
											<th>16</th>
											<th><b>Cash on delivery</b> (Required)</th>
											<th><p>Enable cash on delivery on your product.</p>
											   <p>(Yes = 1, No = 0)</p>
											</th>
										</tr>
					
										<tr>
											<th>17</th>
											<th><b>Free Shipping</b> (Required)</th>
											<th><p>Enable free shipping on your product.</p>
											   <p>(Yes = 1, No = 0)</p>
											</th>
										</tr>
					
										<tr>
											<th>18</th>
											<th><b>Return Available</b> (Required)</th>
											<th><p>Enable Return available on your product.</p>
											   <p>(Yes = 1, No = 0)</p>
											</th>
										</tr>
					
										<tr>
											<th>19</th>
											<th><b>Cancel Available</b> (Required)</th>
											<th><p>Enable Cancel available on your product.</p>
											   <p>(Yes = 1, No = 0)</p>
											</th>
										</tr>
					
										<tr>
											<th>20</th>
											<th><b>Selling Start at</b> (Optional)</th>
											<th><p>Enable if you want to start selling your product from specific date.</p>
											   <p><b>(Date Format : 2019-11-12 00:00:00)</b></p>
											</th>
										</tr>
					
										<tr>
											<th>21</th>
											<th><b>Warranty In (Period)</b> (Optional)</th>
											<th><p>Enter if your product have warranty else enter <b>None</b>.</p>
											   <p><b>(eg. 1)</b></p>
											</th>
										</tr>
					
										<tr>
											<th>22</th>
											<th><b>Warranty in (months,year,days)</b> (Optional)</th>
											<th><p>Enable if your product have warranty else enter <b>None</b>.</p>
											   <p><b>(Available format: days,year,months)</b></p>
											</th>
										</tr>
					
										<tr>
											<th>23</th>
											<th><b>Warranty type</b> (Optional)</th>
											<th><p>Enable if your product have warranty else enter <b>None</b>.</p>
											   <p><b>(Available types: Gurrantey, Warrantey)</b></p>
											</th>
										</tr>
					
										
					
										<tr>
											<th>24</th>
											<th><b>Return Policy</b> (Required if)</th>
											<th>If you set return available = 1, than enter return policy od (must created before entering id here).
											You can find return policies ids from here <a target="__blank" href="{{ url("/admin/return-policy") }}">
												Click to view
											</a>
											</th>
										</tr>
					
										<tr>
											<th>25</th>
											<th><b>Tax Rate</b> (Required if)</th>
											<th>If you set tax = 0 and your price is inclusive of tax , than enter Tax rate
												<p><b>eg.(18,25)</b></p></th>
										</tr>
					
										<tr>
											<th>26</th>
											<th><b>Tax name</b> (Required if)</th>
											<th>If you set tax = 0 and your price is inclusive of tax than enter your tax name.</th>
										</tr>
					
										<tr>
											<th>27</th>
											<th><b>Tags</b> (Optional)</th>
											<th>Enter product tags by putting comma to seprate tags.</th>
										</tr>
					
									</tbody>
								</table>
					  </div>
						</div>
						<div class="tab-pane fade" id="profile-line" role="tabpanel" aria-labelledby="profile-tab-line">
							<a href="{{ url('/files/SimpleProductsCSV.xlsx') }}" class="btn btn-primary mb-3">
								<i class="feather icon-download mr-2"></i> {{__("Download example for xls/csv File")}}
							</a>
							<form action="{{ route('seller.import.store') }}" method="POST" enctype="multipart/form-data">
								@csrf
								<input type="hidden" name="type" value="1">
								<div class="row">
									<div class="form-group col-md-6">
										<label for="file">Choose your xls/csv File : <span class="text-danger">*</span> </label>
										<div class="input-group mb-3">
											<div class="input-group-prepend">
											  <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
											</div>
											<div class="custom-file">
											  <input type="file" name="file" required="" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
											  
											  <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
											  @if ($errors->has('file'))
											  <span class="invalid-feedback text-danger" role="alert">
												  <strong>{{ $errors->first('file') }}</strong>
											  </span>
										      @endif
											</div>
										  </div>
										  <button type="submit" class="btn btn-success"><i class="feather icon-download-cloud mr-1"></i> Import</button>
										
										
									
										
									</div>
									
								</div>
				
							</form>

						<hr>
						<div class="table-responsive">
							<h4 class="card-title">{{ __('Instructions')}}</h4>

							<h6><b>Follow the instructions carefully before importing the file.</b></h6>
								<h6>The columns of the file should be in the following order.</h6>
					
								<table id="datatable-button" class="table table-striped table-bordered">
									<thead>
										<tr>
											<th>#</th>
											<th>Column Name</th>
											<th>Required</th>
											<th>Description</th>
										</tr>
									</thead>

									<tbody>
										<tr>
											<th>1.</th>
											<th>product_name</th>
											<th>Yes</th>
											<th>Name of your product.</th>
										</tr>

										<tr>
											<th>2.</th>
											<th>key_features</th>
											<th>No</th>
											<th>Key features of your product ( HTML tags can also be put).</th>
										</tr>

										<tr>
											<th>2.</th>
											<th>product_details</th>
											<th>Yes</th>
											<th>Description of your product ( HTML tags can also be put).</th>
										</tr>

										<tr>
											<th>3.</th>
											<th>category_id</th>
											<th>Yes</th>
											<th>Name of your category</th>
										</tr>

										<tr>
											<th>4.</th>
											<th>subcategory_id</th>
											<th>Yes</th>
											<th>Name of your subcategory</th>
										</tr>

										<tr>
											<th>5.</th>
											<th>child_id</th>
											<th>No</th>
											<th>Name of your childcategory</th>
										</tr>

										<tr>
											<th>6.</th>
											<th>product_tags</th>
											<th>No</th>
											<th>Seperate your product tag by putting comma.</th>
										</tr>

										<tr>
											<th>7.</th>
											<th>tax_rate</th>
											<th>Yes</th>
											<th>Enter your tax rate without % sign.</th>
										</tr>

										<tr>
											<th>8.</th>
											<th>tax_name</th>
											<th>Yes</th>
											<th>Name your tax.</th>
										</tr>

										<tr>
											<th>9.</th>
											<th>thumbnail</th>
											<th>Yes</th>
											<th>Name your thumbnail image eg: thumbnail.jpg <b>(Image must be already put in public/images/simple_products) folder )</b> .</th>
										</tr>

										<tr>
											<th>10.</th>
											<th>hover_thumbnail</th>
											<th>Yes</th>
											<th>Name your hover thumbnail image eg: hover_thumbnail.jpg <b>(Image must be already put in public/images/simple_products) folder )</b> .</th>
										</tr>

										<tr>
											<th>11.</th>
											<th>status</th>
											<th>Yes</th>
											<th>For Active Product put 1 for deactive put 0.</th>
										</tr>

										<tr>
											<th>12.</th>
											<th>store_id</th>
											<th>Yes</th>
											<th>Name of your store.</th>
										</tr>

										<tr>
											<th>13.</th>
											<th>brand_id</th>
											<th>Yes</th>
											<th>Name of your brand.</th>
										</tr>

										<tr>
											<th>14.</th>
											<th>type</th>
											<th>Yes</th>
											<th>Type of your product.

												<ul>
													<li>For Simple Product put type <b>simple_product</b> </li>
													<li>For Digital Product put type <b>d_product</b> </li>
													<li>For External Product put type <b>ex_product</b> </li>
												</ul>

											</th>
										</tr>

										<tr>
											<th>15.</th>
											<th>free_shipping</th>
											<th>Yes</th>
											<th>If product have free_shipping put 1 else put 0.</th>
										</tr>

										<tr>
											<th>16.</th>
											<th>featured</th>
											<th>Yes</th>
											<th>If product is featured put 1 else put 0.</th>
										</tr>

										<tr>
											<th>17.</th>
											<th>cancel_avbl</th>
											<th>Yes</th>
											<th>If product have cancellation enable put 1 else put 0.</th>
										</tr>

										<tr>
											<th>18.</th>
											<th>cod_avbl</th>
											<th>Yes</th>
											<th>If product have COD enable put 1 else put 0.</th>
										</tr>

										<tr>
											<th>19.</th>
											<th>return_avbl</th>
											<th>Yes</th>
											<th>If product have Return enable put 1 else put 0.</th>
										</tr>

										<tr>
											<th>20.</th>
											<th>return_policy</th>
											<th>Required if</th>
											<th>If you set return_avbl = 1, than enter return policy id (must created before entering id here).
											You can find return policies ids from here <a target="__blank" href="{{ url("/admin/return-policy") }}">
												Click to view
											</a>
											</th>
										</tr>

										<tr>
											<th>21.</th>
											<th>model_no</th>
											<th>Model NO.</th>
											<th>Enter your product model no.</th>
										</tr>

										<tr>
											<th>22.</th>
											<th>sku</th>
											<th>SKU</th>
											<th>Enter your product sku.</th>
										</tr>

										<tr>
											<th>23.</th>
											<th>hsin</th>
											<th>Yes</th>
											<th>Enter your product HSIN NO.</th>
										</tr>

										<tr>
											<th>24.</th>
											<th>actual_offer_price</th>
											<th>NO</th>
											<th>Enter your product offer price without tax else put 0.</th>
										</tr>

										<tr>
											<th>25.</th>
											<th>actual_price</th>
											<th>Yes</th>
											<th>Enter your product price without tax.</th>
										</tr>

										<tr>
											<th>26.</th>
											<th>stock</th>
											<th>Yes</th>
											<th>Enter your product stock or put 0.</th>
										</tr>

										<tr>
											<th>27.</th>
											<th>min_order_qty</th>
											<th>Yes</th>
											<th>Enter your product minimum order quantity.</th>
										</tr>

										<tr>
											<th>28.</th>
											<th>max_order_qty</th>
											<th>NO</th>
											<th>Enter your product maximum order quantity.</th>
										</tr>

										<tr>
											<th>29.</th>
											<th>external_product_link</th>
											<th>NO</th>
											<th>
												If Product type is set to <b>ex_product</b>
												then put your external product link in this column else leave it blank.
											</th>
										</tr>

									</tbody>	
					
								</table>
					  </div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


@endsection
           
             