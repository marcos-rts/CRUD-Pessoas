$(document).ready(function() {
    // Máscaras para os campos
    $('#cpf').on('input', function() {
        let value = $(this).val().replace(/\D/g, '');
        if (value.length > 3) value = value.substring(0, 3) + '.' + value.substring(3);
        if (value.length > 7) value = value.substring(0, 7) + '.' + value.substring(7);
        if (value.length > 11) value = value.substring(0, 11) + '-' + value.substring(11);
        $(this).val(value.substring(0, 14));
    });

    $('#telefone').on('input', function() {
        let value = $(this).val().replace(/\D/g, '');
        if (value.length > 0) value = '(' + value;
        if (value.length > 3) value = value.substring(0, 3) + ') ' + value.substring(3);
        if (value.length > 10) value = value.substring(0, 10) + '-' + value.substring(10);
        $(this).val(value.substring(0, 15));
    });

    // Visualizar colaborador
    $('.visualizar-btn').click(function() {
        const id = $(this).data('id');
        $.get(`processar.php?acao=visualizar&id=${id}`, function(data) {
            $('#detalhesColaborador').html(data);
            $('#visualizarModal').modal('show');
        });
    });

    // Editar colaborador
    $('.editar-btn').click(function() {
        const id = $(this).data('id');
        $('#editar_id').val(id);
        $.get(`processar.php?acao=editar&id=${id}`, function(data) {
            $('#editarColaborador').html(data);
            
            // Aplicar máscaras nos campos do modal de edição
            $('#editar_cpf').on('input', function() {
                let value = $(this).val().replace(/\D/g, '');
                if (value.length > 3) value = value.substring(0, 3) + '.' + value.substring(3);
                if (value.length > 7) value = value.substring(0, 7) + '.' + value.substring(7);
                if (value.length > 11) value = value.substring(0, 11) + '-' + value.substring(11);
                $(this).val(value.substring(0, 14));
            });

            $('#editar_telefone').on('input', function() {
                let value = $(this).val().replace(/\D/g, '');
                if (value.length > 0) value = '(' + value;
                if (value.length > 3) value = value.substring(0, 3) + ') ' + value.substring(3);
                if (value.length > 10) value = value.substring(0, 10) + '-' + value.substring(10);
                $(this).val(value.substring(0, 15));
            });

            $('#editarModal').modal('show');
        });
    });

    // Excluir colaborador
    $('.excluir-btn').click(function() {
        const id = $(this).data('id');
        $('#excluir_id').val(id);
        $('#excluirModal').modal('show');
    });

    // Feedback de sucesso/erro
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('sucesso')) {
        let mensagem = '';
        switch (urlParams.get('sucesso')) {
            case '1': mensagem = 'Colaborador adicionado com sucesso!'; break;
            case '2': mensagem = 'Colaborador atualizado com sucesso!'; break;
            case '3': mensagem = 'Colaborador excluído com sucesso!'; break;
        }
        if (mensagem) {
            alert(mensagem);
            // Remover parâmetros da URL sem recarregar a página
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    } else if (urlParams.has('erro')) {
        let mensagem = 'Ocorreu um erro. Por favor, tente novamente.';
        alert(mensagem);
        window.history.replaceState({}, document.title, window.location.pathname);
    }

    // Filtro de colaboradores
    $('#filtroForm').submit(function(e) {
        e.preventDefault();
        const nome = $('#filtroNome').val().toLowerCase();
        const cargo = $('#filtroCargo').val().toLowerCase();
        const departamento = $('#filtroDepartamento').val().toLowerCase();

        $('table tbody tr').each(function() {
            const rowNome = $(this).find('td:eq(1)').text().toLowerCase();
            const rowCargo = $(this).find('td:eq(3)').text().toLowerCase();
            const rowDepto = $(this).find('td:eq(4)').text().toLowerCase();

            const nomeMatch = nome === '' || rowNome.includes(nome);
            const cargoMatch = cargo === '' || rowCargo.includes(cargo);
            const deptoMatch = departamento === '' || rowDepto.includes(departamento);

            if (nomeMatch && cargoMatch && deptoMatch) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
});