@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="page-heading">
        <h3>Dashboard</h3>
    </div>

    <section class="row">
        <div class="card">
            <div class="card-body">
                {{-- {{ dd(auth()->user()->getRoleNames()->first()) }} --}}
            </div>
        </div>
    </section>
@endsection
