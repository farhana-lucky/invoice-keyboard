@extends('layouts.master')

@section('title')
{{ $invoice->name }}'s Invoice Edit
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
                <form action="{{ route('customer_store',[$invoice->number]) }}" method="POST" class="md:w-full px-10 pt-10 pb-5 bg-white rounded-lg shadow-xl border">
                    @csrf
                    <span class="text-left block uppercase text-gray-700 text-2xl font-bold mb-4">Invoice Generating</span>
                    <span class="text-left block uppercase text-gray-700 font-bold mb-10">Client Info</span>
                    <div class="flex flex-wrap -mx-3 mb-3">
                        <div class="w-full md:w-1/2 px-3 mb-2">
                            <div class="md:flex md:items-center">
                                <div class="md:w-1/3">
                                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="name">
                                        Name :
                                    </label>
                                </div>
                                <div class="md:w-2/3">
                                    <label class="block text-gray-500 font-bold text-left mb-1 md:mb-0 pr-4" for="name">
                                        {{ $invoice->name }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-2">
                            <div class="md:flex md:items-center">
                                <div class="md:w-1/3">
                                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="date">
                                        Date :
                                    </label>
                                </div>
                                <div class="md:w-2/3">
                                    <label class="block text-gray-500 font-bold text-left mb-1 md:mb-0 pr-4" for="date">
                                        {{ date('jS F, Y', strtotime($invoice->date)) }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-2">
                            <div class="md:flex md:items-center">
                                <div class="md:w-1/3">
                                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="phone">
                                        Phone :
                                    </label>
                                </div>
                                <div class="md:w-2/3">
                                    <label class="block text-gray-500 font-bold text-left mb-1 md:mb-0 pr-4" for="phone">
                                        {{ $invoice->phone }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-2">
                            <div class="md:flex md:items-center">
                                <div class="md:w-1/3">
                                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="email">
                                        Email :
                                    </label>
                                </div>
                                <div class="md:w-2/3">
                                    <label class="block text-gray-500 font-bold text-left mb-1 md:mb-0 pr-4" for="email">
                                        {{ $invoice->email }}
                                    </label>
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
                                        Address :
                                    </label>
                                </div>
                                <div class="md:w-2/3">
                                    <label class="block text-gray-500 font-bold text-left mb-1 md:mb-0 pr-4" for="from_address">
                                        {{ $invoice->from_address }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-2">
                            <span class="text-left block uppercase text-gray-700 font-bold mb-10">To Address Details</span>
                            <div class="md:flex md:items-center">
                                <div class="md:w-1/3">
                                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="to_address">
                                        Address :
                                    </label>
                                </div>
                                <div class="md:w-2/3">
                                    <label class="block text-gray-500 font-bold text-left mb-1 md:mb-0 pr-4" for="to_address">
                                        {{ $invoice->to_address }}
                                    </label>
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
                                        Start Time :
                                    </label>
                                </div>
                                <div class="md:w-2/3">
                                    <label class="block text-gray-500 font-bold text-left mb-1 md:mb-0 pr-4" for="start_time">
                                        {{ $invoice->start_time }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-2">
                            <div class="md:flex md:items-center">
                                <div class="md:w-1/3">
                                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="end_time">
                                        End Time :
                                    </label>
                                </div>
                                <div class="md:w-2/3">
                                    <label class="block text-gray-500 font-bold text-left mb-1 md:mb-0 pr-4" for="end_time">
                                        {{ $invoice->end_time }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-2">
                            <div class="md:flex md:items-center">
                                <div class="md:w-1/3">
                                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="work_hours">
                                        Hrs Worked :
                                    </label>
                                </div>
                                <div class="md:w-2/3">
                                    <label class="block text-gray-500 font-bold text-left mb-1 md:mb-0 pr-4" for="work_hours">
                                        {{ $invoice->work_hours }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-2">
                            <div class="md:flex md:items-center">
                                <div class="md:w-1/3">
                                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="rate">
                                        Rate :
                                    </label>
                                </div>
                                <div class="md:w-2/3">
                                    <label class="block text-gray-500 font-bold text-left mb-1 md:mb-0 pr-4" for="rate">
                                        &#36; {{ $invoice->rate }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-2">
                            <div class="md:flex md:items-center">
                                <div class="md:w-1/3">
                                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="labor">
                                        Labor :
                                    </label>
                                </div>
                                <div class="md:w-2/3">
                                    <label class="block text-gray-500 font-bold text-left mb-1 md:mb-0 pr-4" for="labor">
                                        &#36; {{ $invoice->labor }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-2">
                            <div class="md:flex md:items-center">
                                <div class="md:w-1/3">
                                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="stairs">
                                        Stairs :
                                    </label>
                                </div>
                                <div class="md:w-2/3">
                                    <label class="block text-gray-500 font-bold text-left mb-1 md:mb-0 pr-4" for="stairs">
                                        &#36; {{ $invoice->stairs }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-2">
                            <div class="md:flex md:items-center">
                                <div class="md:w-1/3">
                                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="supplies">
                                        Supplies :
                                    </label>
                                </div>
                                <div class="md:w-2/3">
                                    <label class="block text-gray-500 font-bold text-left mb-1 md:mb-0 pr-4" for="supplies">
                                        &#36; {{ $invoice->supplies }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-2">
                            <div class="md:flex md:items-center">
                                <div class="md:w-1/3">
                                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="subtotal">
                                        Subtotal :
                                    </label>
                                </div>
                                <div class="md:w-2/3">
                                    <label class="block text-gray-500 font-bold text-left mb-1 md:mb-0 pr-4" for="subtotal">
                                        &#36; {{ $invoice->subtotal }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-2">
                            <div class="md:flex md:items-center">
                                <div class="md:w-1/3">
                                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="tax">
                                        Tax :
                                    </label>
                                </div>
                                <div class="md:w-2/3">
                                    <label class="block text-gray-500 font-bold text-left mb-1 md:mb-0 pr-4" for="tax">
                                        {{ $invoice->tax }} &#37;
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-2">
                            <div class="md:flex md:items-center">
                                <div class="md:w-1/3">
                                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="total">
                                        Total :
                                    </label>
                                </div>
                                <div class="md:w-2/3">
                                    <label class="block text-gray-500 font-bold text-left mb-1 md:mb-0 pr-4" for="total">
                                        &#36; {{ $invoice->total }}
                                    </label>
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
                                        Driver :
                                    </label>
                                </div>
                                <div class="md:w-2/3">
                                    <label class="block text-gray-500 font-bold text-left mb-1 md:mb-0 pr-4" for="driver">
                                        {{ $invoice->driver }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="w-full md:w-1/3 px-3 mb-2">
                            <div class="md:flex md:items-center">
                                <div class="md:w-1/3">
                                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="helper">
                                        Helper :
                                    </label>
                                </div>
                                <div class="md:w-2/3">
                                    <label class="block text-gray-500 font-bold text-left mb-1 md:mb-0 pr-4" for="helper">
                                        {{ $invoice->helper }}
                                    </label>
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
                                    <label class="block text-gray-500 font-bold text-left mb-1 md:mb-0 pr-4" for="vehicle">
                                        {{ $invoice->vehicle }}
                                    </label>
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
                                        Crew Initial :
                                    </label>
                                </div>
                                <div class="md:w-2/3">
                                    <input type="text" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @error('crew_initial') border-red-500 @enderror" value="{{ $invoice->crew_initial }}" name="crew_initial" id="crew_initial" placeholder="Sign here" maxlength="25" onkeypress="if (!/^[A-Za-z ]+$/.test(String.fromCharCode(event.keyCode))) {return false;}return true;" autocomplete="off">
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
                                        Customer Initial :
                                    </label>
                                </div>
                                <div class="md:w-2/3">
                                    <input type="text" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @error('customer_initial') border-red-500 @enderror" value="{{ $invoice->customer_initial }}" name="customer_initial" id="customer_initial" placeholder="Sign here" maxlength="25" onkeypress="if (!/^[A-Za-z ]+$/.test(String.fromCharCode(event.keyCode))) {return false;}return true;" autocomplete="off">
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
                                        Inspected By :
                                    </label>
                                </div>
                                <div class="md:w-2/3">
                                    <input type="text" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @error('inspected_by') border-red-500 @enderror" value="{{ $invoice->inspected_by }}" name="inspected_by" id="inspected_by" placeholder="Sign here" maxlength="25" onkeypress="if (!/^[A-Za-z ]+$/.test(String.fromCharCode(event.keyCode))) {return false;}return true;" autocomplete="off">
                                    @error('inspected_by')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="w-full md:w-1/2 px-3 mb-2">
                            <div class="md:flex md:items-center">
                                <div class="md:w-full">
                                    <label class="block text-blue-500 font-bold md:text-center pr-4 underline" for="inspected_by">
                                        <a href="https://kamaainamovers.com/disclaimer.php" target="_blank">
                                            " Read and Agreed disclaimer on Back "
                                        </a>
                                    </label>
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
                                        Description of Operations :
                                    </label>
                                </div>
                                <div class="md:w-2/3">
                                    <textarea type="text" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @error('operation_details') border-red-500 @enderror" name="operation_details" id="operation_details" rows="3" maxlength="170" placeholder="Enter Operation Description Here" readonly>{{ $invoice->operation_details }}</textarea>
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
                                        Comments/Special Instructions :
                                    </label>
                                </div>
                                <div class="md:w-2/3">
                                    <textarea type="text" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @error('comment_instruction') border-red-500 @enderror" name="comment_instruction" id="comment_instruction" rows="3" maxlength="440" placeholder="Enter Comments/Special Instruction Here" readonly>{{ $invoice->comment_instruction }}</textarea>
                                    @error('comment_instruction')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="my-2">
                    <span class="text-left block uppercase text-gray-700 font-bold mb-10">All above work was performed satisfactory and all items were received in good condition.</span>
                    <div class="flex flex-wrap -mx-3 mb-3">
                        <div class="w-full px-3 mb-2">
                            <div class="md:flex md:items-center">
                                <div class="md:w-1/3">
                                    <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="comment_instruction">
                                        Sign Here :
                                    </label>
                                </div>
                                <div class="md:w-2/3">
                                    <input type="text" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 @error('sign') border-red-500 @enderror" value="{{ $invoice->sign }}" name="sign" id="sign" placeholder="Sign here" maxlength="25" onkeypress="if (!/^[A-Za-z ]+$/.test(String.fromCharCode(event.keyCode))) {return false;}return true;" autocomplete="off">
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
                                Save
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection