require('./bootstrap');

$(document).ready(function(){
    /**
     * Máscara de placas de carro
     */
    $('.veiculo-placa').change(function(){
        $(this).val($(this).val().toUpperCase());
    }).mask('LLL-NNNN', {
        translation: {
            'L': {
                pattern: /[a-zA-Z]/,
                optional: false
            },
            'N': {
                pattern: /\d/,
                optional: false
            }
        }
    });

    /**
     * Máscara de CPF
     */
    $('.cpf').mask('000.000.000-00', {
        reverse: true
    });
});
