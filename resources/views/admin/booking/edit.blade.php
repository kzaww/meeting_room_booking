@extends('new_layouts.admin.layout')
@section('content')
<div class="px-8 py-5 mt-4">
    <div class="w-1/2 mx-auto">
        <x-button class="bg-transparent text-slate-900 hover:text-white px-5 hover:bg-slate-400 focus:ring-slate-800" id="back_btn">
            <i class="material-symbols-outlined">
                arrow_back
                </i>
        </x-button>
    </div>
    <div class=" w-1/2 p-2 overflow-hidden rounded-lg mt-4 duration-500 whitespace-nowrap mx-auto shadow-lg " id="booking_div" style="background-color: rgb(255,250,223)">
        <input type="hidden" id="succ_msg" value="{{ Session::has('create') ? 1 : (Session::has('update') ? 2 : 0)}}">
        <input type="hidden" id="user_id" value="{{ getAuth()->id }}">
        <div class="text-center py-1">
            <span>Edit Booking</span><hr>
        </div>
        <form action="{{ route('booking_store') }}" method="POST" class="mt-3" id="booking_form">
            @csrf
            <div class="grid grid-cols-2 gap-2 mt-5">
                <div class="flex flex-col">
                    <label for="title">Title <span class="text-r\ed-600">*</span>:</label>
                    <input type="text" class="h-7 mt-2 border-slate-200 rounded-md focus:ring-0 focus:border-b-4 focus:border-slate-400" name="title" id="title" value="{{ old('title',$data->title) }}">
                    @error('title')
                        <small class="ml-2 text-red-600">{{ $message }}</small>
                    @enderror
                </div>
                <div class="flex flex-col">
                    <label for="status">status <span class="text-r\ed-600">*</span>:</label>
                    <select name="status" id="status" class="h-10 mt-2 border-slate-200 rounded-t-md focus:ring-0 focus:border-slate-400">
                        @if ((strtotime($data->date .' '.$data->start_time) > strtotime(Carbon\Carbon::now())) )
                            <option value="0" {{ $data->status == 0 ? 'selected' : '' }}>Pending</option>
                        @endif
                        @if ((strtotime($data->date .' '.$data->start_time) < strtotime(Carbon\Carbon::now())) && strtotime($data->date .' '.$data->end_time) > strtotime(Carbon\Carbon::now()))
                            <option value="1" {{ $data->status == 1 ? 'selected' : '' }}>Started</option>
                        @endif
                        @if (strtotime($data->date .' '.$data->end_time) < strtotime(Carbon\Carbon::now()) )
                            <option value="2" {{ $data->status == 2 ? 'selected' : '' }}>Ended</option>
                            <option value="4" {{ $data->status == 4 ? 'selected' : '' }}>Missed</option>
                            <option value="5" {{ $data->status == 5 ? 'selected' : '' }}>Finished</option>
                        @endif
                        <option value="3" {{ $data->status == 3 ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    @error('status')
                        <small class="ml-2 text-red-600">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-2 mt-5">
                <div class="flex flex-col ">
                    <label for="">Room <span class="text-red-600">*</span>:</label>
                    <select id="room_id" name="room_id" class="h-10 mt-2 border-slate-200 rounded-t-md focus:ring-0 focus:border-slate-400">
                        <option value="">Choose Room</option>
                        <option value="1" {{ $data->room_id == 1 ? 'selected' : '' }}>Room 1</option>
                        <option value="2" {{ $data->room_id == 2 ? 'selected' : '' }}>Room 2</option>
                        <option value="3" {{ $data->room_id == 3 ? 'selected' : '' }}>Room 3</option>
                    </select>
                    @error('date')
                        <small class="ml-2 text-red-600">{{ $message }}</small>
                    @enderror
                </div>
                <div class="flex flex-col">
                    <label for="date">Date <span class="text-red-600">*</span>:</label>
                    <input type="date" class="h-7 mt-2 border-slate-200 rounded-md focus:ring-0 focus:border-b-4 focus:border-slate-400" value="{{ $data->date }}" name="date" id="date">
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
                    </select>
                    <input type="hidden" id="original_start" value="{{ $data->start_time }}">

                    @error('start_time')
                        <small class="ml-2 text-red-600">{{ $message }}</small>
                    @enderror
                </div>
                <div class="flex flex-col">
                    <label for="end_time">End Time <span class="text-red-600">*</span>:</label>
                    <select id="end_time" name="end_time" class="h-10 mt-2 border-slate-200 rounded-t-md focus:ring-0 focus:border-slate-400 time_interval">
                        <option value="">Choose EndTime</option>
                    </select>
                    <input type="hidden" id="original_end" value="{{ $data->end_time }}">
                    @error('end_time')
                        <small class="ml-2 text-red-600">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            {{-- <input type="hidden" name="booking_id" id="booking_id" value="{{ $data->id }}"> --}}
            <div class="text-center mt-3">
                <span>duration ( <b id="total_duration">00:00:00</b> )</span>
                <input type="hidden" name="duration" id="duration" value="{{ old('duration') }}">
                <input type="hidden" id="og_duration" value="{{ $data->duration }}">
            </div>
            <div class="flex flex-col mt-5">
                <label for="reason">Title <span class="text-red-600">*</span>:</label>
                <select name="reason_id" id="reason" class="h-10 mt-2 border-slate-200 rounded-t-md focus:ring-0  focus:border-slate-400">
                    <option value="">Choose Reason</option>
                    <option value="{{ $data->end_time }}" selected>{{ $data->end_time }}</option>
                    @foreach ($reason as $item)
                        <option value="{{ $item->id }}" {{ old('reason_id',$data->reason_id) == $item->id ? 'selected' : '' }}>{{ $item->reason }}</option>
                    @endforeach
                </select>
                @error('reason')
                    <small class="ml-2 text-red-600">{{ $message }}</small>
                @enderror
            </div>
            <div class="flex flex-col mt-5">
                <label for="remark">Remark :</label>
                <textarea name="remark" id="remark" class="mt-2 border-slate-200 rounded-md focus:ring-0 focus:border-b-4 focus:border-slate-400" cols="30" rows="3">{{ old('remark',$data->remark) }}</textarea>
                @error('remark')
                    <small class="ml-2 text-red-600">{{ $message }}</small>
                @enderror
            </div>
            <div class="text-right mt-4" id="btn_div">
                <x-button type="submit" class="bg-emerald-400 w-24 h-10 ps-6 focus:ring-yellow-600 hover:bg-emerald-600">Update</x-button>
            </div>
            <input type="hidden" id="id" name="booking_id" value="{{ $data->id }}">
        </form>
    </div>
</div>

@push('js')
    <script>
        $(document).ready(function(e){
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



            var id = $('#id').val();
            var start =  moment($('#original_start').val(), 'HH:mm:ss').format('h:mm A');;
            var end = moment($('#original_end').val(), 'HH:mm:ss').format('h:mm A');
            $.ajax({
            type : "GET",
            url  :  "/booking/ajax/event_click/"+id,
            beforeSend:function(){
                $('.time_interval').html('');
            },
            success: function(res){
                $all_time = ['08:30:00','09:00:00','09:30:00','10:00:00','10:30:00','11:00:00','11:30:00','12:00:00','12:30:00','13:00:00','13:30:00','14:00:00','14:30:00','15:00:00','15:30:00','16:00:00','16:30:00','17:00:00','17:30:00','18:00:00'];
                // console.log(res);
                $list = '<option value="">Choose StartTime</option>';
                $list1= '<option value="">Choose EndTime</option>';
                $gl_vl = res.time;

                for($j = 0 ; $j <= $all_time.length-1 ; $j++)
                {
                    $list += `
                    <option value="${$all_time[$j]}" ${$all_time[$j] == res.data.start_time ? 'selected':''}>${moment($all_time[$j], 'HH:mm:ss').format('h:mm A')}</option>
                    `;
                }
                for($i = 0 ; $i <= $all_time.length-1 ; $i++)
                {
                    $list1 += `
                    <option value="${$all_time[$i]}" ${$all_time[$i] == res.data.end_time ? 'selected':''}>${moment($all_time[$i], 'HH:mm:ss').format('h:mm A')}</option>
                    `;

                }
                $('#start_time').prepend($list);
                $('#end_time').prepend($list1);
                $('#duration').val(res.data.duration);
                $('#total_duration').text(res.data.duration);

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

        $(document).on('change','.time_interval',function(e){
                    $start_time = $('#start_time').val();
                    $end_time   = $('#end_time').val();
                    $og_start   = $('#original_start').val();
                    $og_end     = $('#original_end').val()
                    $og_dur     = $('#og_duration').val();
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
                                $('#start_time').val($og_start);
                                $('#end_time').val($og_end);
                                $('#total_duration').text($og_dur);
                                $('#duration').val($og_dur);
                            }else{
                                $time = new Date($diff * 1000).toISOString().substring(11, 19)
                                $('#total_duration').text($time);
                                $('#duration').val($time);
                                $('#duration').trigger('textChanged');
                            }
                        }
                    }
                })


        $(document).on('click','#back_btn',function(e){
            window.location.href = "/admin/booking";

        })
        })
    </script>
@endpush
@endsection
