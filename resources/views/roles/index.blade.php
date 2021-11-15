@extends('layouts.app')

@section('includesCSS')
    @parent
    <link id="theme-style" rel="stylesheet" href="/assets/plugins/datatables/datatables.min.css">
    
@endsection

@section('title', $title)

@section('content')
<hr class="mb-4">
<div class="row">
    <div class="d-flex justify-content-end">
        <input type="hidden" id="route_edit" value="{{route($entity.'.edit',['*'])}}">
        <input type="hidden" id="route_destroy" value="{{route($entity.'.destroy',['*'])}}">
        <input type="hidden" id="route_list" value="{{$route_list}}">
        <a href="{{route($entity.'.create')}}" data-toggle="tooltip" data-placement="top" title="Cadastrar"><i class="fas fa-plus fa-lg"></i></a>
    </div>
</div>
<div class="row g-4 settings-section">
    <div class="col-12 col-md-12">
        <div class="app-card app-card-settings shadow-sm p-4">
            <table id="list" class="table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Qtd. permissões</th>
                        <th>Qtd. usuários</th>
                        <th class="text-center">Ação</th>
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
    <script src="/js/{{$entity}}/index.min.js"></script>
@endsection