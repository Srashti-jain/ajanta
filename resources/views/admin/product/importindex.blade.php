@extends('admin.layouts.master-soyuz')
@section('title',__('Import Product |'))
@section('body')
@component('admin.component.breadcumb',['thirdactive' => 'active'])
@slot('heading')
{{ __('Import Product') }}
@endslot
@slot('menu2')
{{ __("Import Product") }}
@endslot

@endcomponent
​
<div class="contentbar">
	<div class="row">
		
		<div class="col-lg-12">
			@if ($errors->any())
			<div class="alert alert-danger" role="alert">
				@foreach($errors->all() as $error)
				<p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span></button></p>
				@endforeach
			</div>
			@endif

			<div class="card m-b-30">
				<div class="card-header">
					<h5 class="box-title">{{ __('Import Product') }}</h5>
				</div>
				<div class="card-body">
					

						<!-- card body started -->
						<!-- <div class="card-body"> -->
						<ul class="nav nav-tabs custom-tab-line mb-3" id="defaultTab" role="tablist">

							<li class="nav-item">
								<a class="nav-link active" data-toggle="tab" href="#importvariant"
									role="tab" aria-controls="profile"
									aria-selected="false">{{ __("Import variant products") }}</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#importsimple" role="tab"
									aria-controls="profile" aria-selected="false">{{ __("Import simple products") }}</a>
							</li>
						</ul>
						<div class="tab-content" id="defaultTabContent">
							<!-- ===  Progessive Web App Requirements start ======== -->
							<div class="tab-pane fade show active" id="importvariant" role="tabpanel"
								aria-labelledby="location-tab">
								<!-- ===  Progessive Web App Requirements form start ======== -->
								<a href="{{ url('files/ProductCSV.xlsx') }}" class="btn btn-md btn-success-rgba"> <i class="feather icon-download"></i> {{ __("Download Example For xls/csv File") }}</a>
								<hr>
								<form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
									{{ csrf_field() }}

									<div class="row">
										<div class="form-group col-md-6">
											<label class="text-dark" for="file">{{ __("Choose your xls/csv File :") }}</label>
											<!-- ---------- -->
											<div class="input-group mb-3">
												<div class="custom-file">
													<input type="file" class="custom-file-input" name="file"
														id="inputGroupFile01" aria-describedby="inputGroupFileAddon01"
														required>
													<label class="custom-file-label" for="inputGroupFile01">{{__("Choose file") }}</label>
												</div>
											</div>
											@if ($errors->has('file'))
											<span class="invalid-feedback text-danger" role="alert">
												<strong>{{ $errors->first('file') }}</strong>
											</span>
											@endif
											<p></p>
											<button type="submit" class="btn btn-primary-rgba mr-2">{{ __('Import') }}</button>
										</div>

									</div>

								</form>

								<div class="box box-danger">
									<div class="box-header with-border">
										<label class="text-dark">{{ __("Instructions") }}</label>

									</div>

									<div class="box-body">
										<p><b>{{ __('Follow the instructions carefully before importing the file.') }}</b></p>
										<p>{{ __('The columns of the file should be in the following order.') }}</p>

										<table class="table table-striped">
											<thead>
												<tr>
													<th>{{ __('Column No') }}</th>
													<th>{{ __('Column Name') }}</th>
													<th>{{ __('Description') }}</th>
												</tr>
											</thead>

											<tbody>
												<tr>
													<td>1</td>
													<td><b>Category</b> (Required)</td>
													<td>Name of category</td>


												</tr>

												<tr>
													<td>2</td>
													<td><b>Subcategory</b> (Required)</td>
													<td>Name of subcategory</td>
												</tr>

												<tr>
													<td>3</td>
													<td><b>Childcategory</b> (Optional)</td>
													<td>Name of childcategory</td>
												</tr>

												<tr>
													<td>4</td>
													<td><b>Store Name</b> (Required)</td>
													<td>Name of your store (Must created before importing).</td>
												</tr>

												<tr>
													<td>5</td>
													<td><b>Brand Name</b> (Required)</td>
													<td>Name of your brand</td>
												</tr>

												<tr>
													<td>6</td>
													<td><b>Product Name</b> (Required)</td>
													<td>Name of your product</td>
												</tr>

												<tr>
													<td>7</td>
													<td><b>Product Description</b> (Optional)</td>
													<td>Detail of your product</td>
												</tr>

												<tr>
													<td>8</td>
													<td><b>Model</b> (Optional)</td>
													<td>Model No. of your product</td>
												</tr>

												<tr>
													<td>9</td>
													<td><b>SKU</b> (Optional)</td>
													<td>Detail of your product</td>
												</tr>

												<tr>
													<td>10</td>
													<td><b>Price In</b> (Required)</td>
													<td>Your Product price in currency (eg. INR,USD)</td>
												</tr>

												<tr>
													<td>11</td>
													<td><b>Price</b> (Required)</td>
													<td>Your Product price [<b>Note:</b> Price must entered in this
														format eg. 50000 (No comma and character).]</td>
												</tr>

												<tr>
													<td>12</td>
													<td><b>Offer Price</b> [<b>Note:</b> Leave blank if you dont want
														offer price.]</td>
													<td>Your Product offer price [<b>Note:</b> Price must entered in
														this format eg. 50000 (No comma and character).]</td>
												</tr>

												<tr>
													<td>13</td>
													<td><b>Featured</b> (Optional)</td>
													<td>
														<p>Enable or disable product is featured or not.</p>
														<p>(Yes = 1, No = 0)</p>
													</td>
												</tr>

												<tr>
													<td>14</td>
													<td><b>Status</b> (Required)</td>
													<td>
														<p>Enable or disable product is active or not.</p>
														<p>(Yes = 1, No = 0)</p>
													</td>
												</tr>

												<tr>
													<td>15</td>
													<td><b>Tax</b> (Required if your price is exclusive of tax)</td>
													<td>
														<p>Enable tax class name (must created before enter name here)
															which you created in tax classes section or else enter
															<b>0</b>.</p>
													</td>
												</tr>

												<tr>
													<td>16</td>
													<td><b>Cash on delivery</b> (Required)</td>
													<td>
														<p>Enable cash on delivery on your product.</p>
														<p>(Yes = 1, No = 0)</p>
													</td>
												</tr>

												<tr>
													<td>17</td>
													<td><b>Free Shipping</b> (Required)</td>
													<td>
														<p>Enable free shipping on your product.</p>
														<p>(Yes = 1, No = 0)</p>
													</td>
												</tr>

												<tr>
													<td>18</td>
													<td><b>Return Available</b> (Required)</td>
													<td>
														<p>Enable Return available on your product.</p>
														<p>(Yes = 1, No = 0)</p>
													</td>
												</tr>

												<tr>
													<td>19</td>
													<td><b>Cancel Available</b> (Required)</td>
													<td>
														<p>Enable Cancel available on your product.</p>
														<p>(Yes = 1, No = 0)</p>
													</td>
												</tr>

												<tr>
													<td>20</td>
													<td><b>Selling Start at</b> (Optional)</td>
													<td>
														<p>Enable if you want to start selling your product from
															specific date.</p>
														<p><b>(Date Format : 2019-11-12 00:00:00)</b></p>
													</td>
												</tr>

												<tr>
													<td>21</td>
													<td><b>Warranty In (Period)</b> (Optional)</td>
													<td>
														<p>Enter if your product have warranty else enter <b>None</b>.
														</p>
														<p><b>(eg. 1)</b></p>
													</td>
												</tr>

												<tr>
													<td>22</td>
													<td><b>Warranty in (months,year,days)</b> (Optional)</td>
													<td>
														<p>Enable if your product have warranty else enter <b>None</b>.
														</p>
														<p><b>(Available format: days,year,months)</b></p>
													</td>
												</tr>

												<tr>
													<td>23</td>
													<td><b>Warranty type</b> (Optional)</td>
													<td>
														<p>Enable if your product have warranty else enter <b>None</b>.
														</p>
														<p><b>(Available types: Gurrantey, Warrantey)</b></p>
													</td>
												</tr>



												<tr>
													<td>24</td>
													<td><b>Return Policy</b> (Required if)</td>
													<td>If you set return available = 1, than enter return policy od
														(must created before entering id here).
														You can find return policies ids from here <a target="__blank"
															href="{{ url("/admin/return-policy") }}">
															Click to view
														</a>
													</td>
												</tr>

												<tr>
													<td>25</td>
													<td><b>Tax Rate</b> (Required if)</td>
													<td>If you set tax = 0 and your price is inclusive of tax , than
														enter Tax rate
														<p><b>eg.(18,25)</b></p>
													</td>
												</tr>

												<tr>
													<td>26</td>
													<td><b>Tax name</b> (Required if)</td>
													<td>If you set tax = 0 and your price is inclusive of tax than enter
														your tax name.</td>
												</tr>

												<tr>
													<td>27</td>
													<td><b>Tags</b> (Optional)</td>
													<td>Enter product tags by putting comma to seprate tags.</td>
												</tr>

											</tbody>
										</table>
									</div>
								</div>
								<!-- === Progessive Web App Requirements form end ===========-->
							</div>
							<!-- === Progessive Web App Requirements end ======== -->

							<!-- === PWA Icons & Splash screens start ======== -->
							<div class="tab-pane fade" id="importsimple" role="tabpanel" aria-labelledby="checkout-tab">
								<!-- === PWA Icons & Splash screens form start ======== -->
								<a href="{{ url('/files/SimpleProductsCSV.xlsx') }}" class="btn btn-success-rgba">
									<i class="feather icon-download"></i> {{__("Download example for xls/csv File")}}
								</a>
								<hr>
								<form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
									@csrf
									<input type="hidden" name="type" value="1">
									<div class="row">
										<div class="form-group col-md-6">
											<label class="text-dark" for="file">Choose your xls/csv File : <span
													class="text-danger">*</span> </label>
											<!-- ---------- -->
											<div class="input-group mb-3">
												<div class="input-group-prepend">
													<span class="input-group-text"
														id="inputGroupFileAddon01">Upload</span>
												</div>
												<div class="custom-file">
													<input type="file" class="custom-file-input" name="file"
														id="inputGroupFile01" aria-describedby="inputGroupFileAddon01"
														required>
													<label class="custom-file-label" for="inputGroupFile01">Choose
														file</label>
												</div>
											</div>
											<!-- --------- -->
											<!-- <input required="" type="file" name="file" class="form-control"> -->
											@if ($errors->has('file'))
											<span class="invalid-feedback text-danger" role="alert">
												<strong>{{ $errors->first('file') }}</strong>
											</span>
											@endif
											<p></p>
											<button type="submit" class="btn btn-primary-rgba">
												{{ __("Import") }}
											</button>
										</div>

									</div>

								</form>

								<!-- Import instructions -->
								<div class="box box-danger">
									<div class="box-header with-border">
										<div class="box-title">{{ __('Instructions') }}</div>
									</div>

									<div class="box-body">
										<p><b>{{ __('Follow the instructions carefully before importing the file.') }}</b></p>
										<p>{{ __('The columns of the file should be in the following order.') }}</p>

										<table class="table table-striped">
											<thead>
												<tr>
													<th>#</th>
													<th>{{ __('Column Name') }}</th>
													<th>{{ __('Required') }}</th>
													<th>{{ __('Description') }}</th>
												</tr>
											</thead>

											<tbody>
												<tr>
													<td>1.</td>
													<td>product_name</td>
													<td>Yes</td>
													<td>Name of your product.</td>
												</tr>

												<tr>
													<td>2.</td>
													<td>key_features</td>
													<td>No</td>
													<td>Key features of your product ( HTML tags can also be put).</td>
												</tr>

												<tr>
													<td>2.</td>
													<td>product_details</td>
													<td>Yes</td>
													<td>Description of your product ( HTML tags can also be put).</td>
												</tr>

												<tr>
													<td>3.</td>
													<td>category_id</td>
													<td>Yes</td>
													<td>Name of your category</td>
												</tr>

												<tr>
													<td>4.</td>
													<td>subcategory_id</td>
													<td>Yes</td>
													<td>Name of your subcategory</td>
												</tr>

												<tr>
													<td>5.</td>
													<td>child_id</td>
													<td>No</td>
													<td>Name of your childcategory</td>
												</tr>

												<tr>
													<td>6.</td>
													<td>product_tags</td>
													<td>No</td>
													<td>Seperate your product tag by putting comma.</td>
												</tr>

												<tr>
													<td>7.</td>
													<td>tax_rate</td>
													<td>Yes</td>
													<td>Enter your tax rate without % sign.</td>
												</tr>

												<tr>
													<td>8.</td>
													<td>tax_name</td>
													<td>Yes</td>
													<td>Name your tax.</td>
												</tr>

												<tr>
													<td>9.</td>
													<td>thumbnail</td>
													<td>Yes</td>
													<td>Name your image eg: thumbnail.jpg <b>(Image can be uploaded using Media Manager / Simple Products Tab. )</b> .</td>
													</td>
												</tr>

												<tr>
													<td>10.</td>
													<td>hover_thumbnail</td>
													<td>Yes</td>
													<td>Name your image eg: hoverthumbnail.jpg <b>(Image can be uploaded using Media Manager / Simple Products Tab. )</b> .</td>
												</tr>

												<tr>
													<td>11.</td>
													<td>status</td>
													<td>Yes</td>
													<td>For Active Product put 1 for deactive put 0.</td>
												</tr>

												<tr>
													<td>12.</td>
													<td>store_id</td>
													<td>Yes</td>
													<td>Name of your store.</td>
												</tr>

												<tr>
													<td>13.</td>
													<td>brand_id</td>
													<td>Yes</td>
													<td>Name of your brand.</td>
												</tr>

												<tr>
													<td>14.</td>
													<td>type</td>
													<td>Yes</td>
													<td>Type of your product.

														<ul>
															<li>For Simple Product put type <b>simple_product</b> </li>
															<li>For Digital Product put type <b>d_product</b> </li>
															<li>For External Product put type <b>ex_product</b> </li>
														</ul>

													</td>
												</tr>

												<tr>
													<td>15.</td>
													<td>free_shipping</td>
													<td>Yes</td>
													<td>If product have free_shipping put 1 else put 0.</td>
												</tr>

												<tr>
													<td>16.</td>
													<td>featured</td>
													<td>Yes</td>
													<td>If product is featured put 1 else put 0.</td>
												</tr>

												<tr>
													<td>17.</td>
													<td>cancel_avbl</td>
													<td>Yes</td>
													<td>If product have cancellation enable put 1 else put 0.</td>
												</tr>

												<tr>
													<td>18.</td>
													<td>cod_avbl</td>
													<td>Yes</td>
													<td>If product have COD enable put 1 else put 0.</td>
												</tr>

												<tr>
													<td>19.</td>
													<td>return_avbl</td>
													<td>Yes</td>
													<td>If product have Return enable put 1 else put 0.</td>
												</tr>

												<tr>
													<td>20.</td>
													<td>return_policy</td>
													<td>Required if</td>
													<td>If you set return_avbl = 1, than enter return policy id (must
														created before entering id here).
														You can find return policies ids from here <a target="__blank"
															href="{{ url("/admin/return-policy") }}">
															Click to view
														</a>
													</td>
												</tr>

												<tr>
													<td>21.</td>
													<td>model_no</td>
													<td>Model NO.</td>
													<td>Enter your product model no.</td>
												</tr>

												<tr>
													<td>22.</td>
													<td>sku</td>
													<td>SKU</td>
													<td>Enter your product sku.</td>
												</tr>

												<tr>
													<td>23.</td>
													<td>hsin</td>
													<td>Yes</td>
													<td>Enter your product HSIN NO.</td>
												</tr>

												<tr>
													<td>24.</td>
													<td>actual_offer_price</td>
													<td>NO</td>
													<td>Enter your product offer price without tax else put 0.</td>
												</tr>

												<tr>
													<td>25.</td>
													<td>actual_price</td>
													<td>Yes</td>
													<td>Enter your product price without tax.</td>
												</tr>

												<tr>
													<td>26.</td>
													<td>stock</td>
													<td>Yes</td>
													<td>Enter your product stock or put 0.</td>
												</tr>

												<tr>
													<td>27.</td>
													<td>min_order_qty</td>
													<td>Yes</td>
													<td>Enter your product minimum order quantity.</td>
												</tr>

												<tr>
													<td>28.</td>
													<td>max_order_qty</td>
													<td>NO</td>
													<td>Enter your product maximum order quantity.</td>
												</tr>

												<tr>
													<td>29.</td>
													<td>external_product_link</td>
													<td>NO</td>
													<td>
														If Product type is set to <b>ex_product</b>
														then put your external product link in this column else leave it
														blank.
													</td>
												</tr>

											</tbody>


										</table>
									</div>
								</div>
								<!-- end -->
								<!-- === PWA Icons & Splash screens form end ===========-->
							</div>
							<!-- === PWA Icons & Splash screens end ======== -->

						</div>
					

				</div><!-- col end -->
			</div>
			<!-- main content end -->
			<!-- </div> -->
		</div>
	</div>
</div>
</div>
@endsection