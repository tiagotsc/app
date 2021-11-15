@extends('layouts.app')

@section('includesCSS')
    @parent
    <link id="theme-style" rel="stylesheet" href="/assets/plugins/datatables/datatables.min.css">
    
@endsection

@section('title', 'Histórico de transações')

@section('content')
<hr class="mb-4">
<div class="row">
    <div class="col-md-6">
        <b>Saldo atual: <span id="balance"></span></b>
    </div>
    <div class="col-md-6 d-flex justify-content-end">
        <input type="hidden" name="base_url" id="base_url" value="{{url('')}}">
        @if(Auth::user()->type == 'common')
        <a href="#" id="link_edit" data-toggle="tooltip" data-placement="top" title="Fazer transferência"><i class="fas fa-plus fa-lg"></i></a>
        @endif
    </div>
</div>
<div class="row g-4 settings-section">
    <div class="col-12 col-md-12">
        <div class="app-card app-card-settings shadow-sm p-4">
            <table id="list" class="table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Tipo</th>
                        <th>Pessoa</th>
                        <th>Saldo antes</th>
                        <th>Dinheiro</th>
                        <th>Saldo depois</th>
                        <th>Data /hora</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>  
    </div>
</div><!--//row-->
@endsection

@section('includesJS')
    @parent
    <script src="/assets/plugins/jquery-3.6.0.min.js"></script>
    <script src="/assets/plugins/datatables/datatables.min.js"></script>
    <script src="/assets/plugins/sweetalert.min.js"></script>
    <script src="/js/wallet/index.min.js"></script>
@endsection