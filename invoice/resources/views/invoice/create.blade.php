@extends('layouts.master')

@section('title')
Invoice Create
@endsection

@section('script_vendor')
<script src="{{ asset('js/lightpick.js') }}"></script>
@endsection

@section('script')
<script src="{{ asset('js/custom.js') }}"></script>
<script>
    window.onload = function() {
        setTimeout(function() {
            alertDisappear();
        }, 5000);
    };

    function nameValidation(event) {
        if ((event.keyCode >= 65 && event.keyCode <= 90) || (event.keyCode >= 97 && event.keyCode <= 122) || event.keyCode == 32 || event.keyCode == 13) {
            return true;
        } else {
            return event.preventDefault();
        }
    }

    function dateStringReturn() {
        let date = new Date();
        let Day = date.getDate();
        let Month = date.getMonth() + 1;
        let FullYear = date.getFullYear();
        let Hours = date.getHours();
        let Minutes = date.getMinutes();

        let ampm = Hours >= 12 ? 'pm' : 'am';
        Hours = Hours % 12;
        Hours = Hours ? Hours : 12;
        Minutes = Minutes < 10 ? '0' + Minutes : Minutes;
        return Day + "/" + Month + "/" + FullYear + " - " + Hours + ":" + Minutes + " " + ampm;
    }

    function timeStart() {
        document.getElementById('start_time').value = dateStringReturn();
        let end = document.getElementById('end_time').value;
        document.getElementById('start_button').innerText = "Running";
        if (end) {
            costCalculation();
        }
    }

    function timeEnd() {
        document.getElementById('end_time').value = dateStringReturn();
        let start = document.getElementById('start_time').value;
        document.getElementById('end_button').innerText = "Stopped";
        if (start) {
            document.getElementById('start_button').innerText = "------";
            costCalculation();
        }
    }

    function stringToDate(date) {
        date = date.split('/').join(' ').replace(' - ', ' ').replace(':', ' ');
        date = date.split(' ');
        let year = date[2];
        let month = date[1];
        let day = date[0];
        let hours = parseInt(date[3]);
        if (date[5] == "pm") {
            if (date[3] != 12) {
                hours += 12;
            }
        } else {
            if (date[3] == 12) {
                hours -= 12;
            }
        }
        let minutes = date[4];
        return new Date(year, month, day, hours, minutes, 0);
    }

    function costCalculation() {
        let start_time = document.getElementById('start_time').value;
        let end_time = document.getElementById('end_time').value;
        let work_hours = document.getElementById('work_hours');
        let total_hours = 0;
        if (start_time && end_time) {
            start_time = stringToDate(start_time);
            end_time = stringToDate(end_time);

            let delta = Math.abs(start_time - end_time) / 1000;
            let days = Math.floor(delta / 86400);
            delta -= days * 86400;
            let hours = Math.floor(delta / 3600) % 24;
            delta -= hours * 3600;
            let minutes = Math.floor(delta / 60) % 60;
            total_hours = (parseInt(days) * 24) + parseInt(hours) + parseFloat(minutes / 60);
            total_hours = parseInt(total_hours) < 2 ? 2 : total_hours;
            work_hours.value = isNaN(total_hours.toFixed(2)) ? "Invalid Time" : total_hours.toFixed(2) + " hours";
            work_hours.title = days + (days > 1 ? " days " : " day ") + hours + (hours > 1 ? " hours " : " hour ") + minutes + (minutes > 1 ? " minutes" : " minute");
        } else {
            work_hours.value = "0 hours";
            work_hours.title = "0 hours";
        }

        let tax = document.getElementById('tax').value;
        let rate = document.getElementById('rate').value;
        let labor = document.getElementById('labor');
        let subtotal = 0;
        if (rate) {
            if (total_hours != 0 && !isNaN(total_hours)) {
                labor.value = (rate * total_hours).toFixed(2);
            } else {
                labor.value = 0;
            }
            subtotal = labor.value;
        }
        let stairs = document.getElementById('stairs').value;
        if (stairs) {
            subtotal = parseFloat(subtotal) + parseFloat(stairs);
        }
        let supplies = document.getElementById('supplies').value;
        if (supplies) {
            subtotal = parseFloat(subtotal) + parseFloat(supplies);
        }
        document.getElementById('subtotal').value = parseFloat(subtotal).toFixed(2);
        document.getElementById('total').value = (parseFloat(subtotal) + ((parseFloat(subtotal) * parseFloat(tax)) / 100)).toFixed(2);
    }

    function alertDisappear() {
        document.getElementById('alert').innerHTML = ``;
    }
</script>
@endsection

@section('content')
<section class="lg:w-2/3 w-full md:mt-5 mt-5 mx-auto">
    <div class="container-fluid px-5 pb-16">
        <div class="flex flex-wrap -mx-4 -mb-10 text-center">
            <div class="w-full mb-10 px-4">
                @include('layouts.alert')
                <form action="{{ route('invoice.store') }}" method="POST" class="md:w-full px-10 pt-10 pb-5 bg-white rounded-lg shadow-xl border">
                    @csrf
                    <span class="text-left block uppercase text-gray-700 text-2xl font-bold mb-4">Invoice Generating</span>
                    <span class="text-left block uppercase text-gray-700 font-bold mb-10">Client Info</span>
                    <div class="flex flex-wrap -mx-3 mb-3">
                        <div class="w-full md:w-1/2 px-3 mb-2">
                            <div class="md:flex md:items-center">
                                <div class="md:w-1/3">
                                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="name">
                                        Name
                                    </label>
                                </div>
                                <div class="md:w-2/3">
                                    <input type="text" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @error('name') border-red-500 @enderror" value="{{ old('name') }}" name="name" id="name" placeholder="Enter Name" maxlength="70" onkeypress="nameValidation(event)" autocomplete="off">
                                    @error('name')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="w-full md:w-1/2 px-3 mb-2">
                            <div class="md:flex md:items-center">
                                <div class="md:w-1/3">
                                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="date">
                                        Date
                                    </label>
                                </div>
                                <div class="md:w-2/3">
                                    <input type="text" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @error('date') border-red-500 @enderror" value="{{ old('date')!= null? old('date'): date('d/m/Y') }}" name="date" id="date" placeholder="Enter Date" autocomplete="off" readonly>
                                    @error('date')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-2">
                            <div class="md:flex md:items-center">
                                <div class="md:w-1/3">
                                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="phone">
                                        Phone
                                    </label>
                                </div>
                                <div class="md:w-2/3">
                                    <input type="number" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @error('phone') border-red-500 @enderror" value="{{ old('phone') }}" name="phone" id="phone" placeholder="Enter Phone" onkeypress="if (!/^[0-9]+$/.test(String.fromCharCode(event.keyCode))) {return false;}return true;" autocomplete="off">
                                    @error('phone')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-2">
                            <div class="md:flex md:items-center">
                                <div class="md:w-1/3">
                                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="email">
                                        Email
                                    </label>
                                </div>
                                <div class="md:w-2/3">
                                    <input type="email" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @error('email') border-red-500 @enderror" value="{{ old('email') }}" name="email" id="email" placeholder="example@email.com" autocomplete="off">
                                    @error('email')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="my-2">
                    <div class="flex flex-wrap -mx-3 mb-3">
                        <div class="w-full md:w-1/2 px-3 mb-2">
                            <span class="text-left block uppercase text-gray-700 font-bold mb-10">From Address Details</span>
                            <div class="md:flex md:items-center">
                                <div class="md:w-1/3">
                                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="from_address">
                                        Address
                                    </label>
                                </div>
                                <div class="md:w-2/3">
                                    <input type="text" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @error('from_address') border-red-500 @enderror" value="{{ old('from_address') }}" name="from_address" id="from_address" placeholder="Enter From Address" maxlength="70" autocomplete="new-password">
                                    @error('from_address')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-2">
                            <span class="text-left block uppercase text-gray-700 font-bold mb-10">To Address Details</span>
                            <div class="md:flex md:items-center">
                                <div class="md:w-1/3">
                                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="to_address">
                                        Address
                                    </label>
                                </div>
                                <div class="md:w-2/3">
                                    <input type="text" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @error('to_address') border-red-500 @enderror" value="{{ old('to_address') }}" name="to_address" id="to_address" placeholder="Enter To Address" maxlength="70" autocomplete="new-password">
                                    @error('to_address')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="my-2">
                    <span class="text-left block uppercase text-gray-700 font-bold mb-10">Cost Details</span>
                    <div class="flex flex-wrap -mx-3 mb-3">
                        <div class="w-full md:w-1/2 px-3 mb-2">
                            <div class="md:flex md:items-center">
                                <div class="md:w-1/3">
                                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="start_time">
                                        Start Time
                                    </label>
                                </div>
                                <div class="md:w-2/3 flex w-full">
                                    <div class="w-2/3">
                                        <input type="text" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @error('start_time') border-red-500 @enderror" value="{{ old('start_time') }}" name="start_time" id="start_time" onfocusout="costCalculation()" placeholder="Enter Time" autocomplete="off">
                                        @error('start_time')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="w-1/3">
                                        <button type="button" class="bg-green-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:border-gray-500" onclick="timeStart()" id="start_button">Start</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-2">
                            <div class="md:flex md:items-center">
                                <div class="md:w-1/3">
                                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="end_time">
                                        End Time
                                    </label>
                                </div>
                                <div class="md:w-2/3 flex w-full">
                                    <div class="w-2/3">
                                        <input type="text" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @error('end_time') border-red-500 @enderror" value="{{ old('end_time') }}" name="end_time" id="end_time" onfocusout="costCalculation()" placeholder="Enter Time" autocomplete="off">
                                        @error('end_time')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="w-1/3">
                                        <button type="button" class="bg-green-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:border-gray-500" onclick="timeEnd()" id="end_button">End</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-2">
                            <div class="md:flex md:items-center">
                                <div class="md:w-1/3 sm:w-full">
                                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="work_hours">
                                        Hrs Worked
                                    </label>
                                </div>
                                <div class="md:w-2/3 flex w-full">
                                    <div class="w-2/3">
                                        <input type="t autocomplete=" off" ext" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @error('work_hours') border-red-500 @enderror" value="{{ old('work_hours') }}" name="work_hours" id="work_hours" placeholder="Enter Time" autocomplete="off" readonly>
                                        @error('work_hours')
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="w-1/3">
                                        <button type="button" class="bg-green-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:border-gray-500" onclick="costCalculation()">Get</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-2">
                            <div class="md:flex md:items-center">
                                <div class="md:w-1/3">
                                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="rate">
                                        Rate
                                    </label>
                                </div>
                                <div class="relative md:w-2/3">
                                    <input type="number" step="0.01" min="0" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @error('rate') border-red-500 @enderror" value="{{ old('rate') }}" name="rate" id="rate" onkeyup="costCalculation();" placeholder="Enter Rate" autocomplete="off">
                                    <div class="text-2xl pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-700">
                                        &#36;
                                    </div>
                                    @error('rate')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-2">
                            <div class="md:flex md:items-center">
                                <div class="md:w-1/3">
                                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="labor">
                                        Labor
                                    </label>
                                </div>
                                <div class="relative md:w-2/3">
                                    <input type="text" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @error('labor') border-red-500 @enderror" value="{{ old('labor') }}" name="labor" id="labor" placeholder="Worked hours * rate" autocomplete="off" readonly>
                                    <div class="text-2xl pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-700">
                                        &#36;
                                    </div>
                                    @error('labor')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-2">
                            <div class="md:flex md:items-center">
                                <div class="md:w-1/3">
                                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="stairs">
                                        Stairs
                                    </label>
                                </div>
                                <div class="relative md:w-2/3">
                                    <input type="number" step="0.01" min="0" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @error('stairs') border-red-500 @enderror" value="{{ old('stairs') }}" name="stairs" id="stairs" onkeyup="costCalculation()" placeholder="Enter Value" autocomplete="off">
                                    <div class="text-2xl pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-700">
                                        &#36;
                                    </div>
                                    @error('stairs')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-2">
                            <div class="md:flex md:items-center">
                                <div class="md:w-1/3">
                                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="supplies">
                                        Supplies
                                    </label>
                                </div>
                                <div class="relative md:w-2/3">
                                    <input type="number" step="0.01" min="0" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @error('supplies') border-red-500 @enderror" value="{{ old('supplies') }}" name="supplies" id="supplies" onkeyup="costCalculation()" placeholder="Enter Value" autocomplete="off">
                                    <div class="text-2xl pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-700">
                                        &#36;
                                    </div>
                                    @error('supplies')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-2">
                            <div class="md:flex md:items-center">
                                <div class="md:w-1/3">
                                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="subtotal">
                                        Subtotal
                                    </label>
                                </div>
                                <div class="relative md:w-2/3">
                                    <input type="text" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @error('subtotal') border-red-500 @enderror" value="{{ old('subtotal') }}" name="subtotal" id="subtotal" placeholder="Subtotal" autocomplete="off" readonly>
                                    <div class="text-2xl pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-700">
                                        &#36;
                                    </div>
                                    @error('subtotal')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-2">
                            <div class="md:flex md:items-center">
                                <div class="md:w-1/3">
                                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="tax">
                                        Tax
                                    </label>
                                </div>
                                <div class="relative md:w-2/3">
                                    <input type="number" step="0.01" min="0" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @error('tax') border-red-500 @enderror" value="{{ old('tax') != null? old('tax') : '4.7' }}" name="tax" id="tax" onkeyup="costCalculation()" placeholder="Enter Tax Value" autocomplete="off">
                                    <div class="text-2xl pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-700">
                                        &#37;
                                    </div>
                                    @error('tax')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-2">
                            <div class="md:flex md:items-center">
                                <div class="md:w-1/3">
                                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="total">
                                        Total
                                    </label>
                                </div>
                                <div class="relative md:w-2/3">
                                    <input type="text" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @error('total') border-red-500 @enderror" value="{{ old('total') }}" name="total" id="total" placeholder="Total" autocomplete="off" readonly>
                                    <div class="text-2xl pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-700">
                                        &#36;
                                    </div>
                                    @error('total')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="my-2">
                    <span class="text-left block uppercase text-gray-700 font-bold mb-10">Crew Details</span>
                    <div class="flex flex-wrap -mx-3">
                        <div class="w-full md:w-1/3 px-3 mb-2">
                            <div class="md:flex md:items-center">
                                <div class="md:w-1/3">
                                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="driver">
                                        Driver
                                    </label>
                                </div>
                                <div class="md:w-2/3">
                                    <input type="text" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @error('driver') border-red-500 @enderror" value="{{ old('driver') }}" name="driver" id="driver" placeholder="Enter Name" maxlength="30" onkeypress="if (!/^[A-Za-z, ]+$/.test(String.fromCharCode(event.keyCode))) {return false;}return true;" autocomplete="off">
                                    @error('driver')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="w-full md:w-1/3 px-3 mb-2">
                            <div class="md:flex md:items-center">
                                <div class="md:w-1/3">
                                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="helper">
                                        Helper
                                    </label>
                                </div>
                                <div class="md:w-2/3">
                                    <input type="text" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @error('helper') border-red-500 @enderror" value="{{ old('helper') }}" name="helper" id="helper" placeholder="Enter Name" maxlength="80" onkeypress="if (!/^[A-Za-z, ]+$/.test(String.fromCharCode(event.keyCode))) {return false;}return true;" autocomplete="off">
                                    @error('helper')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="w-full md:w-1/3 px-3 mb-2">
                            <div class="md:flex md:items-center">
                                <div class="md:w-1/3">
                                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="vehicle">
                                        Vehicle
                                    </label>
                                </div>
                                <div class="md:w-2/3">
                                    <input type="text" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @error('vehicle') border-red-500 @enderror" value="{{ old('vehicle') }}" name="vehicle" id="vehicle" placeholder="Enter Info" maxlength="30" autocomplete="off">
                                    @error('vehicle')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="my-2">
                    <span class="text-left block uppercase text-gray-700 font-bold mb-10">Truck and surrounding area were checked for accidentally items left behind.</span>
                    <div class="flex flex-wrap -mx-3 mb-3">
                        <div class="w-full md:w-1/2 px-3 mb-2">
                            <div class="md:flex md:items-center">
                                <div class="md:w-1/3">
                                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="crew_initial">
                                        Crew Initial
                                    </label>
                                </div>
                                <div class="md:w-2/3">
                                    <input type="text" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @error('crew_initial') border-red-500 @enderror" value="{{ old('crew_initial') }}" name="crew_initial" id="crew_initial" placeholder="Sign here" onkeypress="if (!/^[A-Za-z ]+$/.test(String.fromCharCode(event.keyCode))) {return false;}return true;" autocomplete="off">
                                    @error('crew_initial')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-2">
                            <div class="md:flex md:items-center">
                                <div class="md:w-1/3">
                                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="customer_initial">
                                        Customer Initial
                                    </label>
                                </div>
                                <div class="md:w-2/3">
                                    <input type="text" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @error('customer_initial') border-red-500 @enderror" value="{{ old('customer_initial') }}" name="customer_initial" id="customer_initial" placeholder="Sign here" onkeypress="if (!/^[A-Za-z ]+$/.test(String.fromCharCode(event.keyCode))) {return false;}return true;" autocomplete="off">
                                    @error('customer_initial')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-2">
                            <div class="md:flex md:items-center">
                                <div class="md:w-1/3">
                                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="inspected_by">
                                        Inspected By
                                    </label>
                                </div>
                                <div class="md:w-2/3">
                                    <input type="text" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @error('inspected_by') border-red-500 @enderror" value="{{ old('inspected_by') }}" name="inspected_by" id="inspected_by" placeholder="Sign here" onkeypress="if (!/^[A-Za-z ]+$/.test(String.fromCharCode(event.keyCode))) {return false;}return true;" autocomplete="off">
                                    @error('inspected_by')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="my-2">
                    <span class="text-left block uppercase text-gray-700 font-bold mb-10">Description/Comments</span>
                    <div class="flex flex-wrap -mx-3 mb-3">
                        <div class="w-full px-3 mb-2">
                            <div class="md:flex md:items-center">
                                <div class="md:w-1/3">
                                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="operation_details">
                                        Description of Operations
                                    </label>
                                </div>
                                <div class="md:w-2/3">
                                    <textarea type="text" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @error('operation_details') border-red-500 @enderror" name="operation_details" id="operation_details" rows="3" placeholder="Enter Operation Description Here" maxlength="170" autocomplete="off">{{ old('operation_details') }}</textarea>

                                    <button id="showHide" onclick="isKeyboardShow()" type="button"
                                class="btn btn-success brn-sm btn-block">show</button>

             <div class="row justify-content-center">

                <div style="height: 200px; display: none;" id="keyboard"
                    class="shadow-lg bg-white btn-outline-danger border rounded px-1 pb-1 pt-2">
                    <div class="container ">
                        <div class="row pl-1 pt-2" id="allNum"></div>
                        <div class="row mb-1 pl-1 mr-n3" id="allStr"></div>
                        <div class="row  pl-1 pr-1">
                            <div class="col-3 col-md-2 pl-0 mb-2">
                                <button onclick="previous()" type="button"
                                    class=" btn-secondary btn-sm">Previous</button>
                            </div>
                            <div class="col-6 col-md-8 pl-3 pr-2 mb-2">
                                <button onclick="backSpace()" type="button"
                                    class="btn-light btn-sm btn-block button_custom_br">BackSp</button>
                            </div>
                            <div class="col-3 col-md-2 ml-0 mb-2">
                                <button onclick="next()" type="button"
                                    class="btn-secondary btn-sm px-4 ml-n4">Next</button>
                            </div>
                        </div>
                    </div>
                </div>
             </div>
                
                
                                   
                                    @error('operation_details')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap -mx-3 mb-3">
                        <div class="w-full px-3 mb-2">
                            <div class="md:flex md:items-center">
                                <div class="md:w-1/3">
                                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="comment_instruction">
                                        Comments/Special Instructions
                                    </label>
                                </div>
                                <div class="md:w-2/3">
                                    <textarea type="text" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @error('comment_instruction') border-red-500 @enderror" name="comment_instruction" id="comment_instruction" rows="3" placeholder="Enter Comments/Special Instruction Here" maxlength="440" autocomplete="off">{{ old('comment_instruction') }}
                                   
                                    </textarea>

                                    <button id="showHide2" onclick="isKeyboardShow2()" type="button"
                                class="btn btn-success brn-sm btn-block">show</button>
                                    <!-- Second keyboard -->
             <div class="row justify-content-center">
                <div style="height: 200px; display: none;" id="keyboard2"
                    class="shadow-lg bg-white btn-outline-danger border rounded px-1 pb-1 pt-2">
                    <div class="container ">
                        <div class="row pl-1 pt-2" id="allNum2"></div>
                        <div class="row mb-1 pl-1 mr-n3" id="allStr2"></div>
                        <div class="row  pl-1 pr-1 ">
                            <div class="col-3 col-md-2 pl-0 mb-2">
                                <button onclick="previous2()" type="button"
                                    class=" btn-secondary btn-sm">Previous</button>
                            </div>
                            <div class="col-6 col-md-8 pl-2 pr-2 mb-2">
                                <button onclick="backSpace2()" type="button"
                                    class="btn-light btn-sm btn-block button_custom_br">BackSp</button>
                            </div>
                            <div class="col-3 col-md-2 ml-0 mb-2">
                                <button onclick="next2()" type="button"
                                    class="btn-secondary btn-sm px-4 ml-n4">Next</button>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                                   
                         
                                    

                                    @error('comment_instruction')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                                            
                                     
                                            
                                 
                    <hr class="my-2">
                    <span class="text-left block uppercase text-gray-700 font-bold mb-10">All above work was performed satisfactory and all items were received in good condition.</span>
                    <div class="flex flex-wrap -mx-3 mb-3">
                        <div class="w-full px-3 mb-2">
                            <div class="md:flex md:items-center">
                                <div class="md:w-1/3">
                                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="comment_instruction">
                                        Sign Here
                                    </label>
                                </div>
                                <div class="md:w-2/3">
                                    <input type="text" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @error('sign') border-red-500 @enderror" value="{{ old('sign') }}" name="sign" id="sign" placeholder="Sign here" maxlength="25" onkeypress="if (!/^[A-Za-z ]+$/.test(String.fromCharCode(event.keyCode))) {return false;}return true;" autocomplete="off">
                                    @error('sign')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap -mx-3">
                        <div class="mx-3 ml-auto inline-flex rounded-md shadow">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 block uppercase tracking-wide text-white text-xs font-bold rounded px-8 py-2 focus:outline-none focus:shadow-outline">
                                Add
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection