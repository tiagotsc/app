$.ajax({
    url: $("#base_url").val()+'/wallet/alldatajson',
    method: "GET",
    contentType: 'application/json'
}).done( function(data) {
    $('#balance').html(data.data.balance);
    $('#link_edit').attr('href',data.link_edit);
    mainDatatable(data.transactions);
})
function mainDatatable(transactions){
    var table = $('#list').DataTable( {
        responsive: true,
        autoWidth: false,
        language: { // Traduz o plugin
            url: "/assets/plugins/datatables/pt_br.json", // Arquivo de tradução
            select: { // Tradução encima das operações de seleção de linha
                rows: { // Tradução para o Footer da tabela
                    _: "Você selecionou %d linhas", // Footer -> Tradução para mais de uma linha selecionada
                    0: "Clique na linha para selecionar", // Footer -> Tradução para nenhuma linha selecionada
                    1: "Apenas 1 linha foi selecionada" // Footer -> Tradução para apenas uma linha selecionada
                }
            },
            buttons: { // Tradução encima da mensagem do botão de cópia
                copyTitle: 'Tabela copiada',
                copySuccess: {
                    _: '%d linhas copiadas',
                    1: '1 linha copiada'
                }
            }
        },
        searching: true,
        data: transactions,
        order: [[0, "asc"]],
        fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            console.log(aData.transaction);
            if (aData.transaction == "send") {
                $('td', nRow).css('background-color', 'AntiqueWhite');
            }else{
                $('td', nRow).css('background-color', 'AliceBlue');
            }
        },
        columns: [
            { data: 'id', width: "10%"},
            { data: 'transaction', width: "10%"},
            { data: 'destiny.name', width: "15%"},
            { data: 'before_value', width: "15%"},
            { data: 'transfer_value', width: "15%"},
            { data: 'current_value', width: "15%"},
            { data: 'created_at', width: "20%",orderable: false}
        ],

    } );

}