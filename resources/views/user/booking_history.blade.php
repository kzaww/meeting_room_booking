@extends('new_layouts.user.layout')
@section('content')

    <div class="mt-3 ps-3">
        <span class="text-2xl italic font-medium uppercase">Booking History</span>

        <form action="{{ route('booking_history') }}" method="GET">
            <div class="p-5 grid grid-cols-5 gap-8">
                <div class="flex flex-col">
                    <label for="room">Room :</label>
                    <select name="room" id="room" class="mt-2 border-1 border-slate-400 text-slate-700 rounded-t-lg focus:border-slate-400 focus:ring-0">
                        <option value="">Choose Room</option>
                        @foreach ($rooms as $item)
                        <option value="{{ $item->id }}" {{ $item->id == request('room') ? 'selected' : '' }} >{{ $item->room_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex flex-col">
                    <label for="from_date">From Date :</label>
                    <input type="date" id="from_date" value="{{ request('from_date') ? request('from_date') : (request('to_date') ? '' : date('Y-m-01'))  }}" name="from_date" class="mt-2 border-1 text-slate-700 border-slate-400 rounded-lg focus:ring-0 focus:border-b-4  focus:border-slate-400 placeholder-slate-300">
                </div>
                <div class="flex flex-col">
                    <label for="to_date">To Date :</label>
                    <input type="date" id="to_date" value="{{ request('to_date') ? request('to_date') : (request('from_date') ? '' : date('Y-m-t')) }}" name="to_date" class="mt-2 border-1 text-slate-700 border-slate-400 rounded-lg focus:ring-0 focus:border-b-4  focus:border-slate-400 placeholder-slate-300">
                </div>
                <div class="flex flex-col">
                    <label for="status">Status :</label>
                    <select name="status" id="status" class="mt-2 border-1 border-slate-400 text-slate-700 rounded-t-lg focus:border-slate-400 focus:ring-0">
                        <option value="">Choose Status</option>
                        <option value="6" {{ request('status') == 6 ? 'selected' : ''}} >Pending</option>
                        <option value="1" {{ request('status') == 1 ? 'selected' : '' }} >Started</option>
                        <option value="2" {{ request('status') == 2 ? 'selected' : '' }} >Ended</option>
                        <option value="3" {{ request('status') == 3 ? 'selected' : '' }} >Cancelled</option>
                        <option value="4" {{ request('status') == 4 ? 'selected' : '' }} >Missed</option>
                        <option value="5" {{ request('status') == 5 ? 'selected' : '' }} >Finished</option>
                    </select>
                </div>
                <div class="grid grid-cols-4 gap-6">
                    <x-button class="bg-emerald-600 text-white col-span-2 mt-8 h-10 ms-6 ps-10 hover:bg-emerald-800">Search</x-button>
                    <x-button type="button" title="Export" id="export_btn" class="bg-sky-600 text-white mt-8 h-10 ms-2 hover:bg-sky-800"><i class="material-symbols-outlined">ios_share</i></x-button>
                </div>
            </div>
        </form>
        <form action="{{ route('excel_export') }}" method="POST" id="export_form">
            @csrf
            <input type="hidden" name="{{ request('room') ? 'room' : '' }}" value="{{ request('room') ? request('room') : '' }}">
            <input type="hidden" name="{{ request('status') ? 'status' : '' }}" value="{{ request('status') ? request('status') : '' }}">
            <input type="hidden" name="{{ request('from_date') ? 'from_date' : '' }}" value="{{ request('from_date') ? request('from_date') : '' }}">
            <input type="hidden" name="{{ request('to_date') ? 'to_date' : '' }}" value="{{ request('to_date') ? request('to_date') : '' }}">
        </form>

        <table class="table-responsive mt-4" style="width: 99%">
            <thead class="h-12 bg-slate-300 z-0">
                <tr>
                    <th class="text-left ps-2 rounded-tl-lg w-12">No</th>
                    <th class="text-left w-20">Room</th>
                    <th class="text-left">Date</th>
                    <th class="text-left">Meeeting Title</th>
                    <th class="text-left">Remark</th>
                    <th class="text-left">Start Time</th>
                    <th class="text-left">End Time</th>
                    <th class="text-left">Duration</th>
                    <th class="text-left">Meeting By</th>
                    <th class="text-left">Status</th>
                    <th class="text-left">Reason</th>
                    <th class="text-left rounded-tr-lg">Extended Time</th>
                </tr>
            </thead>
            <tbody class="font-light booking_body">
                @foreach ($bookings as $item)
                    <tr class="h-10 hover:bg-slate-100">
                        <td class="ps-2">{{ $bookings->firstItem()+$loop->index }}</td>
                        <td >{{ $item->room->room_name }}</td>
                        <td class="">{{ $item->date }}</td>
                        <td class="">{{ $item->title }}</td>
                        <td class="">{{ $item->remark }}</td>
                        <td>{{ $item->start_time }}</td>
                        <td>{{ $item->end_time }}</td>
                        <td>{{ $item->duration }}</td>
                        <td>{{ $item->user->name . ($item->reception == 1 ? '(Reception)' : '') }}</td>
                        <td>
                            @switch($item->status)
                            @case(0)
                                <span>Pending</span>
                                @break
                            @case(1)
                                <span>Started</span>
                                @break
                            @case(2)
                                <span>Ended</span>
                                @break
                            @case(3)
                                <span>Cancelled</span>
                                @break
                            @case(4)
                                <span>Missed</span>
                                @break
                            @case(5)
                                <span>Finished</span>
                                @break
                                @default
                            @endswitch
                        </td>
                        <td>{{ $item->reason->reason }}</td>
                        <td>
                            @if ($item->extend_status)
                                {{ $item->extended_duration }}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if (request('room') || request('status') || request('from_date') || request('to_date') )
            <div class="mt-3">
                <a href="{{ route('booking_history') }}" class="me-4"><x-button class="bg-sky-800 hover:bg-sky-900 text-white">Go To Default</x-button></a>
                @if (request('room'))
                    <span class="mx-3">room: {{ request('room') }}</span> |
                @endif

                @if (request('status'))
                    <span class="mx-3">status: {{ get_status(request('status')) }}</span> |
                @endif

                @if (request('from_date') && request('to_date'))
                    <span class="mx-3">{{ request('from_date') .' ~ '.request('to_date') }} </span> |
                @endif

                @if (request('from_date') && !request('to_date'))
                    <span class="mx-3">{{ request('from_date') .' > ' }} </span> |
                @endif
                @if (request('to_date') && !request('from_date'))
                    <span class="mx-3">{{ '< '.request('to_date') }}</span> |
                @endif
            </div>
        @endif
        <div class="flex justify-center text-xs bg-white">
            {{ $bookings->appends(request()->query())->links() }}


    </div>

    @push('js')
        <script>
            $(document).ready(function(e){
                $(document).on('click','#export_btn',function(e){
                    $('#export_form').submit();
                })
            })
        </script>
    @endpush
@endsection
