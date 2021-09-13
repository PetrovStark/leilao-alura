<?php

namespace Alura\Leilao\Tests\Service;

use PHPUnit\Framework\TestCase;

use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Model\Lance;

use Alura\Leilao\Service\Avaliador;

class AvaliadorTest extends TestCase
{
    public function testAvaliadorDeveEncontrarMaiorLanceCrescente()
    {
        $leilao = new Leilao('Celtinha 2 portas 0 KM');

        $joao = new Usuario('joao');
        $maria = new Usuario('maria');

        # Ordem crescente
        $leilao->recebeLance(new Lance($joao, 300));
        $leilao->recebeLance(new Lance($maria, 1200));
        $leilao->recebeLance(new Lance($joao, 1500));
        $leilao->recebeLance(new Lance($maria, 3200));

        // Act - When
        $leiloeiro = new Avaliador();
        $leiloeiro->avalia($leilao);
        $maior_lance = $leiloeiro->getMaiorValor();

        // Assert - Then
        self::assertEquals(3200, $maior_lance);
    }

    public function testAvaliadorDeveEncontrarMenorLanceCrescente()
    {
        $leilao = new Leilao('Celtinha 2 portas 0 KM');

        $joao = new Usuario('joao');
        $maria = new Usuario('maria');

        # Ordem crescente
        $leilao->recebeLance(new Lance($joao, 300));
        $leilao->recebeLance(new Lance($maria, 1200));
        $leilao->recebeLance(new Lance($joao, 1500));
        $leilao->recebeLance(new Lance($maria, 3200));

        // Act - When
        $leiloeiro = new Avaliador();
        $leiloeiro->avalia($leilao);
        $menor_lance = $leiloeiro->getMenorValor();

        // Assert - Then
        self::assertEquals(300, $menor_lance);
    }

    public function testAvaliadorDeveEncontrarMaiorLanceAleatorio()
    {
        $leilao = new Leilao('Celtinha 2 portas 0 KM');

        $joao = new Usuario('joao');
        $maria = new Usuario('maria');

        # Ordem aleatória
        $leilao->recebeLance(new Lance($joao, 300));
        $leilao->recebeLance(new Lance($maria, 3200));
        $leilao->recebeLance(new Lance($joao, 1500));
        $leilao->recebeLance(new Lance($maria, 1200));

        // Act - When
        $leiloeiro = new Avaliador();
        $leiloeiro->avalia($leilao);
        $maior_lance = $leiloeiro->getMaiorValor();

        // Assert - Then
        self::assertEquals(3200, $maior_lance);
    }

    public function testAvaliadorDeveEncontrarMenorLanceAleatorio()
    {
        $leilao = new Leilao('Celtinha 2 portas 0 KM');

        $joao = new Usuario('joao');
        $maria = new Usuario('maria');

        # Ordem aleatória
        $leilao->recebeLance(new Lance($joao, 300));
        $leilao->recebeLance(new Lance($maria, 3200));
        $leilao->recebeLance(new Lance($joao, 1500));
        $leilao->recebeLance(new Lance($maria, 1200));

        // Act - When
        $leiloeiro = new Avaliador();
        $leiloeiro->avalia($leilao);
        $menor_lance = $leiloeiro->getMenorValor();

        // Assert - Then
        self::assertEquals(300, $menor_lance);
    }

    public function testAvaliadorDeveRetornarZeroDeLeilaoVazio()
    {
        $leilao = new Leilao('Celtinha 2 portas 0 KM');

        // Act - When
        $leiloeiro = new Avaliador();
        $leiloeiro->avalia($leilao);
        $menor_lance = $leiloeiro->getMenorValor();
        $maior_lance = $leiloeiro->getMaiorValor();

        // Assert - Then
        self::assertEquals(0, $menor_lance);
        self::assertEquals(0, $maior_lance);
    }

    public function testAvaliadorDeveEncontrarVencedorDeLeilaoCrescente()
    {
        $leilao = new Leilao('Celtinha 2 portas 0 KM');

        $joao = new Usuario('joao');
        $maria = new Usuario('maria');

        # Ordem crescente
        $leilao->recebeLance(new Lance($joao, 300));
        $leilao->recebeLance(new Lance($maria, 1200));
        $leilao->recebeLance(new Lance($joao, 1500));
        $leilao->recebeLance(new Lance($maria, 3200));

        // Act - When
        $leiloeiro = new Avaliador();
        $leiloeiro->avalia($leilao);
        $vencedor = $leiloeiro->getVencedor();

        // Assert - Then
        self::assertEquals($maria, $vencedor);
    }

    public function testAvaliadorDeveEncontrarVencedorDeLeilaoAleatorio()
    {
        $leilao = new Leilao('Celtinha 2 portas 0 KM');

        $joao = new Usuario('joao');
        $maria = new Usuario('maria');

        # Ordem aleatória
        $leilao->recebeLance(new Lance($joao, 300));
        $leilao->recebeLance(new Lance($maria, 3200));
        $leilao->recebeLance(new Lance($joao, 1500));
        $leilao->recebeLance(new Lance($maria, 1200));

        // Act - When
        $leiloeiro = new Avaliador();
        $leiloeiro->avalia($leilao);
        $vencedor = $leiloeiro->getVencedor();

        // Assert - Then
        self::assertEquals($maria, $vencedor);
    }

    public function testAvaliadorDeveEncontrarVencedorDeLeilaoComLancesIguais()
    {
        $leilao = new Leilao('Celtinha 2 portas 0 KM');

        $joao = new Usuario('joao');
        $maria = new Usuario('maria');

        # Ordem aleatória
        $leilao->recebeLance(new Lance($joao, 300));
        $leilao->recebeLance(new Lance($maria, 300));
        $leilao->recebeLance(new Lance($joao, 300));
        $leilao->recebeLance(new Lance($maria, 300));

        // Act - When
        $leiloeiro = new Avaliador();
        $leiloeiro->avalia($leilao);
        $vencedor = $leiloeiro->getVencedor();

        // Assert - Then
        self::assertEquals($joao, $vencedor);
    }

    public function testAvaliadorDeveAnularVencedorDeLeilaoVazio()
    {
        $leilao = new Leilao('Celtinha 2 portas 0 KM');

        // Act - When
        $leiloeiro = new Avaliador();
        $leiloeiro->avalia($leilao);
        $vencedor = $leiloeiro->getVencedor();

        // Assert - Then
        self::assertEmpty($vencedor);
    }
}