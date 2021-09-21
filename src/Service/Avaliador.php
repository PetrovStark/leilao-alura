<?php

namespace Alura\Leilao\Service;

use Alura\Leilao\Model\Leilao;

class Avaliador
{
    private $maiorValor;
    private $menorValor;
    private $vencedor;
    private $topLances = [];
    
    public function getMaiorValor()
    {
        return $this->maiorValor;
    }

    public function getMenorValor()
    {
        return $this->menorValor;
    }

    public function getVencedor()
    {
        return $this->vencedor;
    }

    public function getTopLances()
    {
        return $this->topLances;
    }

    /**
     * Avalia os dados de um leilão.
     */
    public function avalia(Leilao $leilao): void
    {
        $lances = $leilao->getLances();

        # Identifica se é um leilão sem lances.
        if (count($lances) === 0) {
            $this->menorValor = 0;
            $this->maiorValor = 0;

            return;
        }

        # Organizando os lances na ordem crescente.
        usort($lances, function ($a, $b) {
            $lanceA = $a->getValor();
            $lanceB = $b->getValor();

            if ($lanceA == $lanceB) {
                return 0;
            }

            return ($lanceA < $lanceB) ? -1 : 1;
        });

        # Definindo maior e menor lance, associando valores a instância da classe.
        $menorLance = $lances[0];
        $maiorLance = $lances[count($lances) - 1];

        $this->menorValor = $menorLance->getValor();
        $this->maiorValor = $maiorLance->getValor();

        $this->vencedor = $maiorLance->getUsuario();

        if ($this->menorValor === $this->maiorValor) {
            $this->vencedor = $menorLance->getUsuario();
        }

        if ($this->maiorValor === 0) {
            $this->vencedor = null;
        }

        # Buscando os 3 maiores lances do leilão.
        $count = 0;
        foreach ($lances as $lance) {
            if ($count >= count($lances) - 3) {
                $this->topLances[] = $lance;
            }

            $count++;
        }

        $this->topLances = array_reverse($this->topLances);
    }
}