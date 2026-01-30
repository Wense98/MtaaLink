@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4">Subscribe</h1>

    <form method="POST" action="{{ route('subscriptions.store') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block">Plan</label>
            <select name="plan" class="rounded-md">
                <option value="monthly">Monthly - 5,000 TSH</option>
                <option value="yearly">Yearly - 55,000 TSH</option>
            </select>
        </div>

        <div>
            <button class="px-4 py-2 bg-indigo-600 text-white rounded">Subscribe (dev stub)</button>
        </div>
    </form>
</div>
@endsection