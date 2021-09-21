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
        $leilao = $this->criaLeilao();

        // Act - When
        $leiloeiro = new Avaliador();
        $leiloeiro->avalia($leilao);
        $maior_lance = $leiloeiro->getMaiorValor();

        // Assert - Then
        self::assertEquals(4500, $maior_lance);
    }

    public function testAvaliadorDeveEncontrarMenorLanceCrescente()
    {
        $leilao = $this->criaLeilao();
        // Act - When
        $leiloeiro = new Avaliador();
        $leiloeiro->avalia($leilao);
        $menor_lance = $leiloeiro->getMenorValor();

        // Assert - Then
        self::assertEquals(300, $menor_lance);
    }

    public function testAvaliadorDeveEncontrarVencedorDeLeilaoCrescente()
    {
        $leilao = $this->criaLeilao();

        // Act - When
        $leiloeiro = new Avaliador();
        $leiloeiro->avalia($leilao);
        $vencedor = $leiloeiro->getVencedor();

        // Assert - Then
        self::assertEquals('scoobydoo', $vencedor->getNome());
    }

    public function testAvaliadorDeveRetornarOsMaioresLancesCrescente()
    {
        $expectativa = [
            4500,
            3200,
            1500
        ];

        $realidade = [];

        $leilao = $this->criaLeilao();
        
        $leiloeiro = new Avaliador();
        $leiloeiro->avalia($leilao);
        $top_lances = $leiloeiro->getTopLances();

        foreach ($top_lances as $lance) {
            $realidade[] = $lance->getValor();
        }
        
        self::assertCount(3, $realidade);
        self::assertEquals($expectativa, $realidade);
    }

    public function testAvaliadorDeveEncontrarMaiorLanceAleatorio()
    {
        $leilao = $this->criaLeilao(3);

        // Act - When
        $leiloeiro = new Avaliador();
        $leiloeiro->avalia($leilao);
        $maior_lance = $leiloeiro->getMaiorValor();

        // Assert - Then
        self::assertEquals(4500, $maior_lance);
    }

    public function testAvaliadorDeveEncontrarMenorLanceAleatorio()
    {
        $leilao = $this->criaLeilao(3);
        // Act - When
        $leiloeiro = new Avaliador();
        $leiloeiro->avalia($leilao);
        $menor_lance = $leiloeiro->getMenorValor();

        // Assert - Then
        self::assertEquals(300, $menor_lance);
    }

    public function testAvaliadorDeveEncontrarVencedorDeLeilaoAleatorio()
    {
        $leilao = $this->criaLeilao(3);

        // Act - When
        $leiloeiro = new Avaliador();
        $leiloeiro->avalia($leilao);
        $vencedor = $leiloeiro->getVencedor();

        // Assert - Then
        self::assertEquals('dafne', $vencedor->getNome());
    }

    public function testAvaliadorDeveRetornarOsMaioresLancesAleatorio()
    {
        $expectativa = [
            4500,
            3200,
            1500
        ];

        $realidade = [];

        $leilao = $this->criaLeilao(3);

        $leiloeiro = new Avaliador();
        $leiloeiro->avalia($leilao);
        $top_lances = $leiloeiro->getTopLances();

        foreach ($top_lances as $lance) {
            $realidade[] = $lance->getValor();
        }
        
        self::assertEquals($expectativa, $realidade);
    }

    public function testAvaliadorDeveEncontrarVencedorDeLeilaoComLancesIguais()
    {
        $leilao = $this->criaLeilao(2);

        // Act - When
        $leiloeiro = new Avaliador();
        $leiloeiro->avalia($leilao);
        $vencedor = $leiloeiro->getVencedor();

        // Assert - Then
        self::assertEquals('fred', $vencedor->getNome());
    }


    public function testAvaliadorDeveAnularVencedorDeLeilaoVazio()
    {
        $leilao = $this->criaLeilao(0);

        // Act - When
        $leiloeiro = new Avaliador();
        $leiloeiro->avalia($leilao);
        $vencedor = $leiloeiro->getVencedor();

        // Assert - Then
        self::assertEmpty($vencedor);
    }

    public function testAvaliadorDeveRetornarZeroDeLeilaoVazio()
    {
        $leilao = $this->criaLeilao(0);

        // Act - When
        $leiloeiro = new Avaliador();
        $leiloeiro->avalia($leilao);
        $menor_lance = $leiloeiro->getMenorValor();
        $maior_lance = $leiloeiro->getMaiorValor();

        // Assert - Then
        self::assertEquals(0, $menor_lance);
        self::assertEquals(0, $maior_lance);
    }

    /**
     * Cria um leilão em ordem crescente.
     * 
     * @return Leilao
     */
    public function criaLeilao($ordem_lances = 1)
    {
        switch ($ordem_lances) {
            case 0 : # Vazio
                $lances = [];
                break;
            case 1 : # Crescente
                $lances = [
                    300,
                    1200,
                    1500,
                    3200,
                    4500
                ];
                break;
            case 2 : # Iguais
                $lances = [
                    300,
                    300,
                    300,
                    300,
                    300
                ];
                break;
            case 3 : # Aleatório
                $lances = [
                    3200,
                    4500,
                    1200,
                    1500,
                    300
                ];
                break;                
        }

        $leilao = new Leilao('Máquina de mistério');

        $fred = new Usuario('fred');
        $dafne = new Usuario('dafne');
        $velma = new Usuario('velma');
        $salsicha = new Usuario('salsicha');
        $scoobydoo = new Usuario('scoobydoo');

        if (count($lances) === 5) {
            $leilao->recebeLance(new Lance($fred, $lances[0]));
            $leilao->recebeLance(new Lance($dafne, $lances[1]));
            $leilao->recebeLance(new Lance($velma, $lances[2]));
            $leilao->recebeLance(new Lance($salsicha, $lances[3]));
            $leilao->recebeLance(new Lance($scoobydoo, $lances[4]));
        }

        return $leilao;
    }
}