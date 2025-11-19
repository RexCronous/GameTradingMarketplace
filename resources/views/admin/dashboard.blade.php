@extends('layouts.admin')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Admin Dashboard</h1>

    <section class="mb-6">
        <h2 class="font-bold">Users</h2>
        <table class="w-full bg-white mt-2">
            <thead><tr><th class="p-2">ID</th><th class="p-2">Name</th><th class="p-2">Email</th></tr></thead>
            <tbody>
                @foreach($users as $u)
                    <tr><td class="p-2">{{ $u->id }}</td><td class="p-2">{{ $u->name }}</td><td class="p-2">{{ $u->email }}</td></tr>
                @endforeach
            </tbody>
        </table>
    </section>

    <section>
        <h2 class="font-bold">Recent Transactions</h2>
        <table class="w-full bg-white mt-2">
            <thead><tr><th class="p-2">ID</th><th class="p-2">Buyer</th><th class="p-2">Seller</th><th class="p-2">Total</th></tr></thead>
            <tbody>
                @foreach($transactions as $t)
                    <tr>
                        <td class="p-2">{{ $t->id }}</td>
                        <td class="p-2">{{ optional($t->buyer)->name }}</td>
                        <td class="p-2">{{ optional($t->seller)->name }}</td>
                        <td class="p-2">{{ $t->total_price }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>
@endsection
