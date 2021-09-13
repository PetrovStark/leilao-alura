<?php

namespace Alura\Leilao\Service;

use Alura\Leilao\Model\Leilao;

class Avaliador
{
    private $maiorValor;
    private $menorValor;
    private $vencedor;
    
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
    }
}