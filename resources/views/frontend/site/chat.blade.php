@section('title','FAQ')
@extends('frontend.layouts.master')
@section('content')
<!-- My Reviews Songs Page starts here -->
<div class="chat-page">
    <div class="chat-wrapper">
        <div class="chat-sidebar">
            <div class="search-bar">
                <div class="search-box">
                    <button>
                        <img alt="" src="{{asset('public/assets/frontend/img/search.svg')}}"/>
                    </button>
                    <input placeholder="Search" type="text"/>
                </div>
                <button>
                    <img alt="" src="{{asset('public/assets/frontend/img/up-down.svg')}}"/>
                </button>
            </div>
            <div class="chat-person-list">
                <div class="chat-person active">
                    <img alt="" src="{{asset('public/assets/frontend/img/artist5.png')}}"/>
                    <div class="chat-person-detail">
                        <div class="name-date">
                            <p class="s2">
                                Hanna Garcia
                            </p>
                            <span class="caption blur-color">
                                9:00 pm
                            </span>
                        </div>
                        <span>
                            Hi there, How are you?
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="chat-board">
            <div class="chat-board-header">
                <img alt="" class="back-chat" src="{{asset('public/assets/frontend/img/down-dark-arrow.svg')}}"/>
                <img alt="" src="{{asset('public/assets/frontend/img/artist5.png')}}"/>
                <h6>
                    Mitchel Hadid
                </h6>
            </div>
            <div class="chat-board-data" id="chat-board-data">
                <div class="day-status">
                    <p class="caption">
                        Today
                    </p>
                </div>
                <div class="send-msg-box" key="{index}">
                    <div class="send-msg">
                        <div class="send-msg-content">
                            <span>
                                Hello
                            </span>
                        </div>
                        <p class="caption">
                            9:30 pm
                        </p>
                    </div>
                </div>
                <div class="receive-msg-box">
                    <div class="receive-msg">
                        <div class="receive-msg-content">
                            <span>
                                Hi there, How are you?
                            </span>
                        </div>
                        <p class="caption">
                            9:00 pm
                        </p>
                    </div>
                    <div class="receiver-img">
                        <img alt="" src="{{asset('public/assets/frontend/img/artist5.png')}}"/>
                    </div>
                </div>
                <div class="send-msg-box" key="{index}">
                    <div class="send-msg">
                        <div class="send-msg-content">
                            <span>
                                I am fine thank you for asking.
                            </span>
                        </div>
                        <p class="caption">
                            9:25 pm
                        </p>
                    </div>
                </div>
                <div class="day-status">
                    <p class="caption">
                        Yesterday
                    </p>
                </div>
                <div class="receive-msg-box">
                    <div class="receive-msg">
                        <div class="receive-msg-content">
                            <span>
                                I am fine too.
                            </span>
                        </div>
                        <div class="receive-msg-content">
                            <span>
                                You are an amazing artist and I listen to all the songs you have uploaded.
                            </span>
                        </div>
                        <div class="receive-msg-content">
                            <span>
                                Your songs really make my mood
                            </span>
                        </div>
                        <p class="caption">
                            9:27 pm
                        </p>
                    </div>
                    <div class="receiver-img">
                        <img alt="" src="{{asset('public/assets/frontend/img/artist5.png')}}"/>
                    </div>
                </div>
                <div class="receive-msg-box">
                    <div class="receive-msg">
                        <div class="receive-msg-content">
                            <span>
                                I am fine too.
                            </span>
                        </div>
                        <div class="receive-msg-content">
                            <span>
                                You are an amazing artist and I listen to all the songs you have uploaded.
                            </span>
                        </div>
                        <div class="receive-msg-content">
                            <span>
                                Your songs really make my mood
                            </span>
                        </div>
                        <p class="caption">
                            9:27 pm
                        </p>
                    </div>
                    <div class="receiver-img">
                        <img alt="" src="{{asset('public/assets/frontend/img/artist5.png')}}"/>
                    </div>
                </div>
                <div class="send-msg-box" key="{index}">
                    <div class="send-msg">
                        <div class="send-msg-content">
                            <span>
                                Thank you so much!
                            </span>
                        </div>
                        <p class="caption">
                            9:30 pm
                        </p>
                    </div>
                </div>
            </div>
            <form class="chat-board-input">
                <div class="emoji-input">
                    <button>
                        <img alt="" src="{{asset('public/assets/frontend/img/emoji.png')}}"/>
                    </button>
                    <input placeholder="Type a message..."/>
                </div>
                <button class="fill-btn send-btn">
                    <img alt="" src="{{asset('public/assets/frontend/img/Subtract.svg')}}"/>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
@section('footscript')
<script type="text/javascript">
    // $(document).on('click','ul.faq-sec-pill li.faqsec-btn a',function(){
    //     $(this).addClass('active').parent().siblings().find('a').removeClass('active');
    //     var value = $(this).data('tag');
    //     // alert(value);
    //     if(value){
    //         $('.accordian-item').each(function(){
    //             var tags = $(this).attr('tags')
    //             var tags = tags.split(',');
    //             if(tags.indexOf(value.toString()) !== -1){
    //                 $(this).show()
    //             }else{
    //                 $(this).hide();
    //             }
    //         }) 
    //     }else{
    //        $('.accordian-item').show();
    //     }
    // });
</script>
@endsection
