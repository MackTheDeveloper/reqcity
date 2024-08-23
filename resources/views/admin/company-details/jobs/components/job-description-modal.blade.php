<div class="modal fade description-popup" id="jobDescriptionChange" tabindex="-1" role="dialog"
    aria-labelledby="jobDescriptionChangeLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="jobDescriptionChangeLabel">{{$jobDetails->title}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{route('companyJobDetailUpdate',$jobDetails->id)}}">
                @csrf
                <div class="modal-body">
                    <textarea class="ckeditor" name="job_description" id="job_descr_editor">{{ $jobDetails->job_description }}</textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>
