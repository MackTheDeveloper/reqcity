@extends('frontend.layouts.master')
@section('title', 'Add Post')
@section('content')

<section class="add-post">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 offset-lg-1 col-lg-11">
				<h2>Upload a Photo</h2>
			</div>
		</div>
		<div class="row">
			<?php
			$actionUrl = url('savePost');
			?>
			{{ Form::open(array('url' => $actionUrl,'class'=>'col-sm-12 col-md-12 col-lg-12','id'=>'addPost','autocomplete'=>'off','enctype'=>"multipart/form-data")) }}
			@csrf
			<input type="hidden" name="post_type" value="{{Auth::user()->is_professional}}" />
			<input type="hidden" class="hiddenPreviewImg" name="hiddenPreviewImg" value="" />
			<div class="row">
				<div class="col-sm-6 col-md-6 offset-lg-1 col-lg-6 uploads-img">
					<div class="form-group">
						<div class="file-loading1">
							<input id="file" type="file" class="image inputfile" name="image" accept="images/*">
							<label for="file">Choose a file<i style="margin-left:10px" class="fa fa-upload" aria-hidden="true"></i></label>
						</div>
					</div>
					<div class="previewImgDiv" style="display: none;">
						<img src="" name="previewImg" class="previewImg" style="width:392px !important;height:392px !important" />
					</div>
				</div>
				<div class="col-sm-6 col-md-6 col-lg-4 select-area">
					<div class="select-group">
						<label>Select Category*</label>
						<?php echo Form::select('category_id', $productCategories, '', ['placeholder' => 'Select ...']); ?>
					</div>
					<textarea class="textarea" name="caption_text" placeholder="Write a caption"></textarea>

					<button class="fill-btn">POST</button>
				</div>
			</div>
			</form>
		</div>
	</div>
</section>
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalLabel">Crop Image</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="img-container">
					<div class="row">
						<div class="col-md-8">
							<img id="image" src="https://avatars0.githubusercontent.com/u/3456749">
						</div>
						<div class="col-md-4">
							<div class="preview"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-primary" id="crop">Crop</button>
			</div>
		</div>
	</div>
</div>
@endsection

<style type="text/css">
	.kv-zoom-cache {
		display: none;
	}

	img {
		display: block;
		max-width: 100%;
	}

	.preview {
		overflow: hidden;
		width: 160px;
		height: 160px;
		margin: 10px;
		border: 1px solid red;
	}

	.modal-lg {
		max-width: 1000px !important;
	}

	.inputfile {
		width: 0.1px;
		height: 0.1px;
		opacity: 0;
		overflow: hidden;
		position: absolute;
		z-index: -1;
	}

	.inputfile+label {
		font-size: 1.25em;
		font-weight: 700;
		color: white;
		background-color: #11B0B7 !important;
		display: inline-block;
		padding: 5px 15px;
		cursor: pointer
	}

	.inputfile:focus+label,
	.inputfile+label:hover {
		background-color: red;
	}
</style>
@section('footscript')
<script src="{{asset('public/assets/js/frontend/discover/add-post.js')}}"></script>
@endsection