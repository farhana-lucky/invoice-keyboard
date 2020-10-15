@if(session('success') or session('failed'))
<div id="alert">
    <div class="container-fluid px-5 pb-5 text-center bg-gray-200">
        <div class="lg:w-1/2 mx-auto {{ session('success')? 'bg-green-100 border border-green-400 text-green-700!' : 'bg-red-100 border border-red-400 text-red-700' }} px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">{{ session('success')? 'Success!' : 'Failed!' }}</strong>
            <span class="block sm:inline">{{ session('success')? session('success') : session('failed') }}</span>
        </div>
    </div>
</div>
@endif