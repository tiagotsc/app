@extends('layouts.app')

@section('includesScripsAlpineJS')
    @parent
    <script src="/js/wallet/alpinejs.frm.min.js"></script>
@endsection

@section('title', 'Realizar transação')

@section('content')
<hr class="mb-4">
<div class="row">
    <input type="hidden" name="base_url" id="base_url" value="{{url('')}}">
    <div class="col-md-6">
        <b>Saldo atual: <span id="balance"></span></b>
    </div>
    <div class="col-md-6 d-flex justify-content-end">
        <a href="#" id="link_wallet" data-toggle="tooltip" data-placement="top" title="Voltar para histórico"><i class="fas fa-chevron-left fa-lg"></i></a>
    </div>
</div>
<div x-data="managerFrm()" x-init="loadData()" class="container app-card app-card-settings shadow-sm p-4">
    
    {!! Form::open(['id' => 'frm', 'method' => 'put', 'url' => ['#']]) !!}
    <div class="row">
        <div class="form-group col-md-2">
        {!! Form::label('transfer', 'Valor', ['class' => 'form-label']) !!}<span class="mandatory">*</span>
        {!! Form::text('transfer', '', ['class' => 'money form-control', 'maxlength' => '10', 'placeholder' => 'Preencha...']) !!}
        </div>
        <div class="form-group col-md-5">
            {!! Form::label('destiny', 'Destinatário', ['class' => 'form-label']) !!}
            <select name="destiny" id="destiny" x-model="data.destiny" class="form-select">
                <option value="">Selecione...</option>
                <template x-for="(res, id) in allDestinations">
                    <option x-bind:value="id" x-text="res"></option>
                </template>
            </select>
        </div>
    </div>
    
    <div class="row">
        <div class="d-flex justify-content-end pt-3">
            <button @click="submitData()" id="save" class="btn app-btn-primary" type="button" x-text="buttonLabel" :disabled="loading"></button>
        </div>
    </div>
    {!! Form::close() !!}
</div>
@endsection

@section('includesJS')
    @parent
    <script src="/assets/plugins/jquery.maskMoney.min.js"></script>
    <script src="/assets/plugins/jquery.validate.min.js"></script>
    <script src="/assets/plugins/sweetalert.min.js"></script>
    <script src="/js/wallet/frm.min.js"></script>
@endsection