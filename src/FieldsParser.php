<?php

namespace Germix\FieldsFormatter;

use Germix\FieldsFormatter\Exceptions\UnexpectedTokenException;

/**
 *
 * @author Germán Martínez
 *
 */
final class FieldsParser
{
    /**
     * @var Token
     */
    private $tok;

    /**
     * @var FieldsLexer
     */
    private $lex;
    
    /**
     * Parsear
     *
     * @param string $fields
     *
     * @return array
     */
    public function parse($fields)
    {
        $this->lex = new FieldsLexer($fields);

        $this->next();
        return $this->parseField();
    }

    /**
     * Parsear campos
     *
     * @return array
     */
    private function parseField()
    {
        $data = array();

        while($this->tok->id() != Token::TOK_EOF)
        {
            if($this->tok->id() == Token::TOK_LEXEME)
            {
                $name = $this->tok->lexeme();
                $this->next();

                if($this->tok->id() == '{')
                {
                    $this->next();
                    $subdata = array();
                    array_push($subdata, $name);
                    array_push($subdata, $this->parseField());
                    array_push($data, $subdata);
                }
                else
                {
                    array_push($data, $name);
                }
            }
            else if($this->tok->id() == '}')
            {
                $this->match('}');
                return $data;
            }
            else
            {
                $this->next();
            }
        }
        return $data;
    }

    /**
     * Obtener el siguiente token
     *
     * @return Token
     */
    private function next()
    {
        $this->tok = $this->lex->getToken();
        return $this->tok;
    }

    /**
     * Comprobar que el token actual es el token esperado, y pasa al siguiente
     *
     * @param string $t
     *
     * @return Token
     */
    private function match($t)
    {
        if($this->tok->id() == $t)
        {
            return $this->next();
        }
        else
        {
            throw new UnexpectedTokenException($t, $this->tok);
        }
    }
}
