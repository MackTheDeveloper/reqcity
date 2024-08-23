<div class="candidate-submittal-sidebar">
    <div class="job-posdetails-first">
        <p class="tm">{{$companyJob->title}}</p>
        <span class="grey-span-sidebar">{{$companyJob->company->name}}</span>
        <span class="grey-span-sidebar">{{$companyJob->companyAddress->city}}, {{$companyJob->companyAddress->countries->name}}</span>
        {{-- <span class="grey-span-sidebar">{{$companyJob->company->address->city}}, {{$companyJob->company->address->countries->name}}</span> --}}
        <div class="jobpost-budgeted-salary">
            @if($companyJob->to_salary)
                <p class="ll">${{$companyJob->from_salary}} - ${{$companyJob->to_salary}} a year</p>
            @else
                <p class="ll">${{$companyJob->from_salary}} a year</p>    
            @endif
            <span>{{getFormatedDateForWeb($companyJob->created_at)}}</span>
            {{-- <span>3 days ago</span> --}}
        </div>
    </div>
    <div class="job-postdesc-sec">
        {{-- <p class="job-postdesc-p">{!!str_replace(['<p>', '</p>'], '',$companyJob->job_description)!!}</p> --}}
        {!! $companyJob->job_description !!}
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