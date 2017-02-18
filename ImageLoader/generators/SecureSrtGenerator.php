<?php
/**
 * Created by PhpStorm.
 * User: kalim_000
 * Date: 2/17/2017
 * Time: 3:41 PM
 */

namespace dierme\loader\generators;


class SecureSrtGenerator
{
    protected $alphaSmall;
    protected $alphaBig;
    protected $numbers;
    protected $specialChars;

    public function __construct()
    {
        $this->alphaSmall = [
            'a', 'b', 'c', 'd', 'e', 'f', 'g'
        ];

        $this->alphaBig = [
            'A', 'B', 'C', 'D', 'E', 'F', 'G'
        ];

        $this->numbers = [
            '0', '2', '4', '5', '7', '8', '9'
        ];

        $this->specialChars = [
            '!', '@', '#', '?', '(', ')', '-'
        ];
    }

    public function generateFileName($length)
    {
        $fileName = '';
        for ($i = 0; $i < $length; $i++) {
            $symbolSwithcer = $i % 3;

            if ($symbolSwithcer == 0) {
                $fileName .= $this->getAlphaSmallSymbol();
            }

            if ($symbolSwithcer == 1) {
                $fileName .= $this->getAlphaBigSymbol();
            }

            if ($symbolSwithcer == 2) {
                $fileName .= $this->getNumericSymbol();
            }
        }

        return $fileName;
    }

    protected function getAlphaSmallSymbol()
    {
        $index = (int)(rand(1, count($this->alphaSmall)) - 1);

        return $this->alphaSmall[$index];
    }

    protected function getAlphaBigSymbol()
    {
        $index = (int)(rand(1, count($this->alphaBig)) - 1);

        return $this->alphaBig[$index];
    }

    protected function getNumericSymbol()
    {
        $index = (int)(rand(1, count($this->numbers)) - 1);

        return $this->numbers[$index];
    }

    protected function getSpecialSymbol()
    {
        $index = (int)(rand(1, count($this->numbers)) - 1);

        return $this->numbers[$index];
    }

}