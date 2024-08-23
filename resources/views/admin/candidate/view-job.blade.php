<div class="modal-header">
    <h4 class="modal-title">Job Detail</h4>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
</div>

<!-- Modal body -->
<div class="modal-body">
    <div class="job-posdetails-first">
        <h5>{{ $model->title }}</h5>
        <span class="grey-span-sidebar">{{ $model->company->name }}</span>
        <span class="grey-span-sidebar">{{ $model->companyAddress->city }},
            {{ $model->companyAddress->countries->name }}</span>
        <div class="jobpost-budgeted-salary">
            {{-- <p class="ll">$62,339 - $81,338 a year</p> --}}
            @if ($model->to_salary)
                <p class="ll">${{ $model->from_salary }} - ${{ $model->to_salary }} a year</p>
            @else
                <p class="ll">${{ $model->from_salary }} a year</p>
            @endif
            <span>{{ getFormatedDateForWeb($model->created_at) }}</span>
        </div>
    </div>
    <div class="job-postdesc-sec">
        <table class="table-content-data" style="width:100%;font-size:12px;">
            <tr>
                <th>Employment type</th>
                <th>:</th>
                <td>{{ $extra['employmentType']?:'-' }}</td>
            </tr>
            <tr>
                <th>Schedule</th>
                <th>:</th>
                <td>{{ $extra['schedule']?:'-' }}</td>
            </tr>
            <tr>
                <th>Contract type</th>
                <th>:</th>
                <td>{{ $extra['contractType']?:'-' }}</td>
            </tr>
            <tr>
                <th>Contract duration</th>
                <th>:</th>
                <td>{{ $model->contract_duration . ' ' . ($model->contract_duration_type == 1 ? 'months' : 'years') }}
                </td>
            </tr>
            <tr>
                <th>Remote work</th>
                <th>:</th>
                <td>{{ $extra['remoteWork']?:'No' }}</td>
            </tr>
        </table>
        @if (!empty($faq))
            <hr>
            <div class="frequent-question mt-3">
                <h6>Frequently asked questions</h6>
                @foreach ($faq as $key => $value)
                    <div class="que-ans">
                        <p class="ll">{{ $value['question'] }}</p>
                        <span class="grey-span-sidebar">{{ $value['answer'] }}</span>
                    </div>
                @endforeach
            </div>
        @endif
        {{-- <p class="job-postdesc-p">We are looking for a Developers with experience using native
            JavaScript, HTML5, and CSS
            to join its development team. The ideal candidate will have a desire to work for a
            global company working on cutting-edge techniques for an online shopping application
            that is growing rapidly. We are looking for energetic people and willing to provide a
            relocation opportunity and permanent role for those that set themselves apart and
            establish themselves as rising stars.</p>
        <div class="what-welook-side">
            <p class="tm">What We Are Looking For:</p>
            <ul>
                <li>At least 1 year experience in working as a Javascript developer.</li>
                <li>Knowledge of client-side technologies (HTML/CSS/Javascript)</li>
                <li>Experience in working with jQuery library</li>
                <li>Basic understanding of Git version control</li>
                <li>Basic understanding of the usage of REST APIs</li>
                <li>Fast learner (and willing to learn a lot)</li>
                <li>You love web development</li>
                <li>Programming experience (any language)</li>
                <li>You are proactive team player with good</li>
            </ul>
        </div> --}}
    </div>
</div>

<!-- Modal footer -->
<div class="modal-footer">
    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
</div>
