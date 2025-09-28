<?php

namespace App\Helpers;

class CaptchaHelper
{
    /**
     * Generate simple math CAPTCHA
     * Returns array with question and answer
     */
    public static function generate()
    {
        $operations = ['+', '-', '×'];
        $operation = $operations[array_rand($operations)];
        
        switch ($operation) {
            case '+':
                $num1 = rand(1, 20);
                $num2 = rand(1, 20);
                $answer = $num1 + $num2;
                $question = "{$num1} + {$num2}";
                break;
            case '-':
                $num1 = rand(10, 30);
                $num2 = rand(1, $num1);
                $answer = $num1 - $num2;
                $question = "{$num1} - {$num2}";
                break;
            case '×':
                $num1 = rand(2, 9);
                $num2 = rand(2, 9);
                $answer = $num1 * $num2;
                $question = "{$num1} × {$num2}";
                break;
        }
        
        return [
            'question' => $question,
            'answer' => $answer,
            'hash' => self::hashAnswer($answer)
        ];
    }
    
    /**
     * Create hash for answer validation
     */
    public static function hashAnswer($answer)
    {
        return hash('sha256', $answer . config('app.key'));
    }
    
    /**
     * Validate CAPTCHA answer
     */
    public static function validate($userAnswer, $hashedAnswer)
    {
        if (!is_numeric($userAnswer)) {
            return false;
        }
        
        $expectedHash = self::hashAnswer((int)$userAnswer);
        return hash_equals($hashedAnswer, $expectedHash);
    }
}