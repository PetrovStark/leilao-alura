<?php

require 'vendor/autoload.php';

use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Model\Lance;

use Alura\Leilao\Service\Avaliador;

// Arrange - Given
$leilao = new Leilao('Celtinha 2 portas 0 KM');

$usuarios = [
    'fred',
    'salsicha',
    'dafne',
    'velma',
    'scoobydoo',
    'scoobyloo'
];

foreach ($usuarios as $u) {
    $$u = new Usuario($u);
}

$quantidade_lances = 0;
$valor_lance = 2000;
$historico_autores = [];
$historico_lances = [];
$maximo_de_lances = 12;

while ($quantidade_lances <= $maximo_de_lances) {
    $indice_autor = rand(0, count($usuarios) - 1);
    $autor = $usuarios[$indice_autor];

    $valor_lance += rand(400, 1000);

    $leilao->recebeLance(new Lance($$autor, $valor_lance));

    echo $autor.' fez um lance de R$'.$valor_lance.PHP_EOL;

    $historico_autores[] = $autor;
    $historico_lances[] = $valor_lance;

    $quantidade_lances++;
}

$maior_lance = (float) $historico_lances[count($historico_lances) - 1];

// Act - When
$leiloeiro = new Avaliador();
$leiloeiro->avalia($leilao);
echo $leilao->getDescricao().' foi vendido para '.$historico_autores[count($historico_autores) - 1].' por R$'.$leiloeiro->getMaiorValor().PHP_EOL;

// Assert - Then
if ($maior_lance === $leiloeiro->getMaiorValor()) {
    echo 'TESTE OK';
} else {
    echo 'TESTE FALHOU';
}

echo PHP_EOL;