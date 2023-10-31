@extends('new_layouts.user.layout')
@section('content')
    {{-- <div class="mt-1 bg-red-400">
        <img src="{{ asset('storage/uploads/room_image/'.$data->image->file_name) }}" class="object-fill w-full" style="height: 600px" alt="">
    </div> --}}
    <div class="px-8 py-5 mt-4 flex relative">
        <div id='calendar' class="w-2/3 duration-500"></div>
        <i class="material-symbols-outlined fixed right-1 top-1/3 cursor-pointer duration-500 bg-slate-500 rounded-xl text-white select-none booking_icon">arrow_right</i>
        <div class="w-1/3 p-2 overflow-hidden rounded-lg mt-4 duration-500 whitespace-nowrap ml-3" id="booking_div" style="background-color: rgb(255,250,223)">
            <input type="hidden" id="succ_msg" value="{{ Session::has('create') ? 1 : (Session::has('update') ? 2 : 0)}}">
            <input type="hidden" id="user_id" value="{{ getAuth()->id }}">
            <div class="text-center py-1">
                <span>Let Choose Date & Time !!</span><hr>
            </div>
            <form action="{{ route('booking_store') }}" method="POST" class="mt-3" id="booking_form">
                @csrf
                <div class="flex flex-col">
                    <label for="title">Title <span class="text-red-600">*</span>:</label>
                    <input type="text" class="h-7 mt-2 border-slate-200 rounded-md focus:ring-0 focus:border-b-4 focus:border-slate-400" name="title" id="title" value="{{ old('title') }}">
                    @error('title')
                        <small class="ml-2 text-red-600">{{ $message }}</small>
                    @enderror
                </div>
                <div class="grid grid-cols-2 gap-2 mt-5">
                    <div class="flex flex-col ">
                        <label for="">Room <span class="text-red-600">*</span>:</label>
                        <span class="h-7 w-full bg-white mt-2 border border-slate-300 rounded-md text-center select-none">{{ $data->room_name }}</span>
                        <input type="hidden" name="room_id" id="room_id" value="{{ $data->id }}">
                    </div>
                    <div class="flex flex-col">
                        <label for="date">Date <span class="text-red-600">*</span>:</label>
                        <input type="date" min="<?php echo date("Y-m-d"); ?>" max="<?php echo date("Y-m-d", strtotime(date("Y-m-d") . " +6 days"))?>" class="h-7 mt-2 border-slate-200 rounded-md focus:ring-0 focus:border-b-4 focus:border-slate-400" name="date" id="date">
                        @error('date')
                            <small class="ml-2 text-red-600">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-2 mt-5">
                    <div class="flex flex-col">
                        <label for="start_time">Start Time <span class="text-red-600">*</span>:</label>
                        <select id="start_time" name="start_time" class="h-10 mt-2 border-slate-200 rounded-t-md focus:ring-0 focus:border-slate-400 time_interval">
                            <option value="">Choose StartTime</option>
                            {{-- <option value="09:00:00" {{ old('start_time') == "09:00:00" ? 'selected' : '' }}>9:00 am</option>
                            <option value="09:30:00" {{ old('start_time') == "09:30:00" ? 'selected' : '' }}>9:30 am</option>
                            <option value="10:00:00" {{ old('start_time') == "10:00:00" ? 'selected' : '' }}>10:00 am</option>
                            <option value="10:30:00" {{ old('start_time') == "10:30:00" ? 'selected' : '' }}>10:30 am</option>
                            <option value="11:00:00" {{ old('start_time') == "11:00:00" ? 'selected' : '' }}>11:00 am</option>
                            <option value="11:30:00" {{ old('start_time') == "11:30:00" ? 'selected' : '' }}>11:30 am</option>
                            <option value="12:00:00" {{ old('start_time') == "12:00:00" ? 'selected' : '' }}>12:00 pm</option>
                            <option value="12:30:00" {{ old('start_time') == "12:30:00" ? 'selected' : '' }}>12:30 pm</option>
                            <option value="13:00:00" {{ old('start_time') == "13:00:00" ? 'selected' : '' }}>1:00 pm</option>
                            <option value="13:30:00" {{ old('start_time') == "13:30:00" ? 'selected' : '' }}>1:30 pm</option>
                            <option value="14:00:00" {{ old('start_time') == "14:00:00" ? 'selected' : '' }}>2:00 pm</option>
                            <option value="14:30:00" {{ old('start_time') == "14:30:00" ? 'selected' : '' }}>2:30 pm</option>
                            <option value="15:00:00" {{ old('start_time') == "15:00:00" ? 'selected' : '' }}>3:00 pm</option>
                            <option value="15:30:00" {{ old('start_time') == "15:30:00" ? 'selected' : '' }}>3:30 pm</option>
                            <option value="16:00:00" {{ old('start_time') == "16:00:00" ? 'selected' : '' }}>4:00 pm</option>
                            <option value="16:30:00" {{ old('start_time') == "16:30:00" ? 'selected' : '' }}>4:30 pm</option>
                            <option value="17:00:00" {{ old('start_time') == "17:00:00" ? 'selected' : '' }}>5:00 pm</option> --}}
                        </select>
                        @error('start_time')
                            <small class="ml-2 text-red-600">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="flex flex-col">
                        <label for="end_time">End Time <span class="text-red-600">*</span>:</label>
                        <select id="end_time" name="end_time" class="h-10 mt-2 border-slate-200 rounded-t-md focus:ring-0 focus:border-slate-400 time_interval">
                            <option value="">Choose EndTime</option>

                        </select>
                        @error('end_time')
                            <small class="ml-2 text-red-600">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <input type="hidden" name="booking_id" id="booking_id">
                <div class="text-center mt-3">
                    <span>duration ( <b id="total_duration">00:00:00</b> )</span>
                    <input type="hidden" name="duration" id="duration" value="{{ old('duration') }}">
                </div>
                <div class="flex flex-col mt-5">
                    <label for="reason">Title <span class="text-red-600">*</span>:</label>
                    <select name="reason_id" id="reason" class="h-10 mt-2 border-slate-200 rounded-t-md focus:ring-0  focus:border-slate-400">
                        <option value="">Choose Reason</option>
                        @foreach ($reason as $item)
                            <option value="{{ $item->id }}" {{ old('reason_id') == $item->id ? 'selected' : '' }}>{{ $item->reason }}</option>
                        @endforeach
                    </select>
                    @error('reason')
                        <small class="ml-2 text-red-600">{{ $message }}</small>
                    @enderror
                </div>
                <div class="flex flex-col mt-5">
                    <label for="remark">Remark :</label>
                    <textarea name="remark" id="remark" class="mt-2 border-slate-200 rounded-md focus:ring-0 focus:border-b-4 focus:border-slate-400" cols="30" rows="3">{{ old('remark') }}</textarea>
                    @error('remark')
                        <small class="ml-2 text-red-600">{{ $message }}</small>
                    @enderror
                </div>
                <div class="text-center mt-4" id="btn_div">
                    <x-button type="submit" class="bg-yellow-400 w-24 h-10 ps-7 focus:ring-yellow-600 hover:bg-yellow-600">{{ __('Book') }}</x-button>
                </div>
            </form>
        </div>
    </div>

    @push('js')
        <script>
            var booking_id;
            document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('calendar');

                var calendar = new FullCalendar.Calendar(calendarEl, {
                    contentHeight: "auto",
                    slotMinTime : "09:00:00",
                    slotMaxTime : "17:30:00",
                    weekNumbers  : true,
                    eventOverlap:false,
                    editable: true,
                    dayMaxEvents: true,
                    droppable: true,
                    selectable: true,
                    initialView: 'timeGridWeek',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'timeGridWeek,timeGridDay,dayGridMonth'
                    },
                    events:[
                        @foreach ($book as $item)
                        {
                            title: '{{ $item->title . '(' . $item->user->name . ')' }}',
                            start: "{{ $item->date.'T'.$item->start_time }}",
                            end: "{{ $item->date.'T'.$item->end_time }}",
                            color: '{{ $item->user->bg_color }}',
                            textColor: '{{ $item->user->text_color }}',
                            id: '{{ $item->id }}',
                            user_id: '{{ $item->user_id }}'
                        },

                        @endforeach
                    ],
                    eventConstraint: {
                        start: moment().format('YYYY-MM-DD'),
                        end: moment().add(6,'days').format('YYYY-MM-DD'),
                    },
                    // eventAllow: function(info){
                    //     return info.start >= '09:00' && info.end <= '17:00';
                    // },
                    // eventOverlap : function(stillEvent,movingEvent){
                    //     $still_start = moment(stillEvent.start).subtract(30, 'minutes').format('YYY-MM-DD HH:mm:ss');
                    //     $moving_end  = moment(movingEvent.end).format('YYY-MM-DD HH:mm:ss');

                    //     if($moving_end >= $still_start){
                    //         console.log('yes');
                    //         return false;
                    //     }

                    //     return true;
                    // },
                    eventDataTransform: function(event) {
                        let start_date = moment(event.start).format('YYYY-MM-DD HH:mm:ss');
                        let today      = moment().format('YYYY-MM-DD HH:mm:ss');
                        let user_id = $('#user_id').val();
                        // console.log(start_date);

                        let b_user_id = event.user_id;

                        if ((start_date < today) || (user_id != b_user_id)) {
                            event.editable = false;
                        }
                        return event;
                    },
                    eventClick:function(info){
                        let event = info.event;
                        let id = event.id;
                        let user_id = $('#user_id').val();
                        let b_user_id = event.extendedProps.user_id;
                        let token = $("meta[name='__token']").attr('content');
                        let start_date = moment(event.start).format('YYYY-MM-DD HH:mm:ss');
                        let today      = moment().format('YYYY-MM-DD HH:mm:ss');

                        // $('#reason option').each((i,e)=>{
                        //     console.log($(e).val());
                        // })
                        // return;
                        let past = false;
                        if(start_date < today){
                            past = true;
                            return false;
                        }

                        if(user_id == b_user_id && !past){
                            Swal.fire({
                                icon : 'question',
                                text : "{{ __('message.confirm') }}",
                                showCancelButton: true,
                                confirmButtonText: 'Yes',
                                cancelButtonText: 'No'
                            }).then((result)=>{
                                if(result.isConfirmed){
                                    $.ajax({
                                        type : "GET",
                                        url  :  "/booking/ajax/event_click/"+id,
                                        beforeSend:function(){
                                            $('.time_interval').html('');
                                            $('#btn_div').html('')
                                        },
                                        success: function(res){
                                            $list = '<option value="">Choose StartTime</option>';
                                            $list1= '<option value="">Choose EndTime</option>';
                                            $gl_vl = res.time;
                                            for($j = 0 ; $j <= res.time.length-1 ; $j++)
                                            {
                                                $list += `
                                                <option value="${res.time[$j]}" ${res.time[$j] == res.data.start_time ? 'selected':''}>${res.format_time[$j]}</option>
                                                `;
                                            }
                                            for($i = 0 ; $i <= res.time.length-1 ; $i++)
                                            {
                                                $list1 += `
                                                <option value="${res.time[$i]}" ${res.time[$i] == res.data.end_time ? 'selected':''}>${res.format_time[$i]}</option>
                                                `;

                                            }
                                            $('#reason option').each((i,e)=>{
                                                for($i = 0 ; $i < $('#reason option').length;$i++){
                                                    if($(e).val() == res.data.reason_id){
                                                        $(e).attr('selected',true);
                                                    }
                                                }
                                            })
                                            $('#start_time').prepend($list);
                                            $('#end_time').prepend($list1);
                                            $('#title').val(res.data.title);
                                            $('#date').val(res.data.date);
                                            $('#duration').val(res.data.duration);
                                            $('#total_duration').text(res.data.duration);
                                            $('#remark').text(res.data.remark);
                                            booking_id = res.data.id;
                                            $('#booking_id').val(booking_id);
                                            $('#btn_div').append(`
                                                <x-button type="button" class="bg-rose-400 w-24 h-10 ps-6 hover:bg-rose-600 text-center" id="cancel_btn">{{ __('Cancel') }}</x-button>
                                                <x-button type="submit" class="bg-emerald-400 w-24 h-10 ps-6 hover:bg-emerald-600">{{ __('Update') }}</x-button>
                                            `);
                                        },
                                        error: function(xhr,status,error){
                                            console.error('Event Click Error :' + error)
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Fail',
                                                text : 'Fail To Check Event!!'
                                            })
                                        }
                                    })
                                }
                            })
                        }

                    },
                    eventResize: function(info) {
                            let event = info.event;
                            let id = event.id;
                            let end = event.end;
                            let start = event.start;
                            let formattedEndDate = moment(end).format('YYYY-MM-DD HH:mm:ss');
                            let formattedStartDate = moment(start).format('YYYY-MM-DD HH:mm:ss');
                            let from_date           = formattedStartDate.split(" ")[0];
                            let to_date           = formattedEndDate.split(" ")[0];
                            let room_id = $('#room_id').val();


                            if(from_date != to_date){
                                info.revert();
                                return;
                            }
                            // var start_date = moment(end).format('YYYY-MM-DD');
                            // var today = moment().format('YYYY-MM-DD'),
                            $.ajaxSetup({
                                headers : {  'X-CSRF-TOKEN': $("meta[name='__token']").attr('content') }
                            })

                            $.ajax({
                                type: "POST",
                                url: "{{ route('resize_check') }}",
                                data: {'start' : formattedStartDate , 'end' : formattedEndDate ,'id' : id,'room_id':room_id},
                                success: function (res) {
                                    console.log('Event resized successfully.');
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success',
                                        text : 'Booking Update Success'
                                    })
                                },
                                error: function(xhr, status, error) {
                                console.error('Event resize error: ' + error);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Fail',
                                    text : 'Booking Update Fail'
                                })
                                info.revert();
                                }

                            });
                            // if()


                            // console.log(formattedEndDate);
                            },
                    eventDrop:function(info){
                        let event   = info.event;
                        let newStart= moment(event.start).format('YYYY-MM-DD HH:mm:ss');
                        let newEnd  = moment(event.end).format('YYYY-MM-DD HH:mm:ss');
                        let id      = event.id;
                        let room_id = $('#room_id').val();
                        let data = {
                            'start'     : newStart,
                            'end'       : newEnd,
                            'id'        : id,
                            'room_id'   : room_id
                        }

                        $.ajaxSetup({
                            headers : { 'X-CSRF-Token' : $("meta[name='__token']").attr('content') }
                        })

                        $.ajax({
                            type    : "POST",
                            url     : "{{ route('drop_check') }}",
                            data    : data,
                            success : function(res){
                                console.log('Event drop success.');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text : 'Booking Update Success'
                                })
                            },
                            error : function(xhr,status,error){
                                $error_msg = xhr.responseJSON.error;
                                console.error('Event drop error: ' +$error_msg );
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Fail',
                                    text : $error_msg+'(သို့) စာတင်ချိန်မှာ ကျော်လွန်သွားပါပြီ'
                                })
                                info.revert();
                            }
                        })
                    },

                })
                $(document).on('click','.booking_icon',function(e){
                        if($('#calendar').hasClass('w-full')){
                            $('#calendar').removeClass('w-full');
                            $('#calendar').addClass('w-2/3');
                            $(this).css('transform','rotate(0deg)')
                            $('#booking_div').removeClass('w-0 opacity-0 pointer-events-none');
                            $('#booking_div').addClass('w-1/3');
                            $('#booking_form').removeClass('hidden');
                            // setTimeout(() => {
                            // }, 100);
                        }else if($('#calendar').hasClass('w-2/3')){
                            $('#calendar').removeClass('w-2/3');
                            $('#calendar').addClass('w-full');
                            $(this).css('transform','rotate(180deg)');
                            $('#booking_div').removeClass('w-1/3');
                            $('#booking_div').addClass('w-0 opacity-0 pointer-events-none');

                            $('#booking_form').addClass('hidden');
                        }
                        setTimeout(() => {
                            $('.fc-button-active').click();
                        }, 500);
                    })
                    calendar.render();
            })

            $(document).ready(function(e){
                $gl_vl = [];

                $success = $('#succ_msg').val();
                if($success == 1){
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text : 'Booking Create Success'
                    })
                }else if($success == 2){
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text : 'Booking Update Success'
                    })
                }

                $(document).on('change','#date',function(e){
                    $val = $(this).val();
                    $room_id = $('#room_id').val();
                    $.ajaxSetup({
                            headers : {  'X-CSRF-TOKEN': "{{ csrf_token() }}" }
                        })

                    $.ajax({
                        type: "POST",
                        url: "{{ route('time_search') }}",
                        data: {'date':$val,'room_id' : $room_id},
                        beforeSend:function(){
                            $('.time_interval').html('');
                        },
                        success: function (res) {   
                            $start = '<option value="">Choose StartTime</option>';
                            $end   = '<option value="">Choose EndTime</option>';
                            $gl_vl = res.time;
                            for($j = 0 ; $j <= res.time.length-1 ; $j++)
                            {
                                $start += `
                                <option value="${res.time[$j]}" >${res.format_time[$j]}</option>
                                `;
                                $end += `
                                <option value="${res.time[$j]}" >${res.format_time[$j]}</option>
                                `;
                            }
                            $('#start_time').prepend($start);
                            $('#end_time').prepend($end);
                        }
                    });
                })

                //duration ယူ
                $(document).on('change','.time_interval',function(e){
                    $start_time = $('#start_time').val();
                    $end_time   = $('#end_time').val();
                    $s = $start_time.split(":");
                    $e = $end_time.split(":");
                    $s_total    = parseInt($s[0]*3600) + parseInt($s[1]*60) + parseInt($s[2]);
                    $e_total    = parseInt($e[0]*3600) + parseInt($e[1]*60) + parseInt($e[2]);
                    if($start_time == "" || $end_time == ""){
                        $('#total_duration').text('00:00:00');
                    }else{
                        if($s_total && $e_total){
                            $diff       = $e_total - $s_total;
                            if($diff <= 0){
                                Swal.fire({
                                    icon : "error",
                                    text : "end time က start time ထက်  စောနေပါ သည်"
                                })
                                $('#start_time').val('');
                                $('#end_time').val('');
                                $('#total_duration').text('00:00:00');
                            }else{
                                $time = new Date($diff * 1000).toISOString().substring(11, 19)
                                $('#total_duration').text($time);
                                $('#duration').val($time);
                                $('#duration').trigger('textChanged');
                            }
                        }
                    }
                })

                //အချိန် အားမအား စစ်
                $(document).on('textChanged','#duration',function(e){
                    $start_time = $('#start_time').val();
                    $end_time = $('#end_time').val();
                    $start = new Date(`1970-01-01 ${$start_time}`);
                    $end = new Date(`1970-01-01 ${$end_time}`);

                    const step = 30 * 60 * 1000;
                    const times = [];
                    $dublicate = true;

                    while ($start <= $end) {
                        const timeString = $start.toString().slice(16,24);
                        times.push(timeString);
                        $start.setTime($start.getTime() + step);
                    }
                    times.map((v)=>{
                        if(!$gl_vl.includes(v)){
                            $dublicate = false;
                            return false;
                        }
                    })
                    if($dublicate == false){
                        Swal.fire({
                                    icon : "error",
                                    text : "အချိန် မအားပါ"
                                })
                                $('#start_time').val('');
                                $('#end_time').val('');
                                $('#total_duration').text('00:00:00');
                    }
                })


                $(document).on('click','#cancel_btn',function(){
                    $('#booking_form')[0].reset();
                    $('#start_time').html('<option value="">Choose StartTime</option>')
                    $('#end_time').html('<option value="">Choose EndTime</option>')
                    $('#duration').val('');
                    $('#booking_id').val('')
                    $('#total_duration').html('00:00:00');
                    $('#reason option').each((i,e)=>{
                        $(e).attr('selected',false);
                    })
                    $('#remark').html('')
                    $('#btn_div').html(`
                    <x-button type="submit" class="bg-yellow-400 w-24 h-10 ps-7 hover:bg-yellow-600">{{ __('Book') }}</x-button>`);
                })
            })
        </script>
    @endpush
@endsection
