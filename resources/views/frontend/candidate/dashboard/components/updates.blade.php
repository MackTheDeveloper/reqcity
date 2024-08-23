<div class="updates-notification-dash">
    <h6>Updates</h6>
    <div class="noti-updates-main">
      @if(!empty($notificationData) && count($notificationData)>0)
        @foreach($notificationData as $notidata)
          <div class="notiupdates-iteams">
              <p class="ll updte-title">{{$notidata->message_type }}</p>
              <span class="updte-desc">{{$notidata->message }}</span>
          </div>
        @endforeach
          <div class="updte-viewall">
              <a href="{{route('notifications')}}">View All</a>
          </div>
      @else
      <div class="notiupdates-iteams">
          <span class="updte-desc">{{ config('message.frontendMessages.notification.noupdates') }}</span>
      </div>
      @endif
    </div>
</div>
