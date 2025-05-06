<?php

#switch verifica o valor dentro de uma variável
#verificando o valor que tem dentro do array $_SERVER
#na posição 'REQUEST_METHOD'

// var_dump($_SERVER['REQUEST_METHOD']);
switch($_SERVER['REQUEST_METHOD']){
    case 'GET' :
        // echo "MÉTODO GET";
        $dados = [
            'nome' => 'MKS',
            'idade' => 0,
            'profissao' => 'developer'
        ];

        // var_dump($dados);
        // var_dump(json_encode($dados));
        
        // __________________________________
        // COM OS var_dump dá erro no console
        // __________________________________

        echo json_encode($dados);
        break;

    case 'POST':
}
