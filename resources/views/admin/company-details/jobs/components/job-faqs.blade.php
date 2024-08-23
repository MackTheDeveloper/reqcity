<div class="frequent-question">
  <p class="tl">Frequently asked questions</p>
  @foreach($companyJobFaq as $faqs)
  <div class="que-ans">
    <p class="tm">{{$faqs['question']}}</p>
    <span class="bm">{{$faqs['answer']}}</span>
  </div>
  @endforeach
</div>
