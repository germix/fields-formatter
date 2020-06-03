<?php

namespace Germix\FieldsFormatter;

/**
 *
 * @author Germán Martínez
 *
 */
final class FieldsLexer
{
    private $in;                    // Archivo de análisis
    private $line = 0;              // Línea actual durante el análisis
    private $cache = null;          // Caracter de caché
    private $eof = false;

    /**
     * Constructor
     * Iniciar el análisis léxico
     *
     * @param string $string Cadena
     */
    public function __construct($string)
    {
        $this->in = $string;
    }

    /**
     * Obtener el siguiente token
     *
     * @return Token Token
     */
    public function getToken()
    {
        while(true)
        {
            $c = $this->read();
            if($c == '')
            {
                return new Token(Token::TOK_EOF, $this->line, null);
            }
            if($c == "\n")
            {
                $this->line++;
            }
            else if($c == "\r")
            {
                // NADA
            }
            else if(ctype_space($c))
            {
                // NADA
            }
            else if(ctype_alnum($c))
            {
                // Guardar el primer caracter
                $s = $c;

                // Leer todos los caracteres válidos de un lexema de identificador (alfanumérico y '_')
                while(true)
                {
                    $c = $this->read();
                    if(!(!$this->feof() && (ctype_alnum($c) || $c == '_' || $c == '-')))
                    {
                        break;
                    }
                    $s .= $c;
                }
                // Si no se ha llegado al final, poner en cache el último caracter
                if(!$this->feof())
                {
                    $this->save($c);
                }
                return new Token(Token::TOK_LEXEME, $this->line, $s);
            }
            else
            {
                return new Token($c, $this->line, $c);
            }
        }
        return null;
    }

    /**
     * Comprobar que se ha llegado al fin de la cadena
     *
     * @return boolean true|false
     */
    private function feof()
    {
        return $this->eof == true;
    }

    /**
     * Leer el siguiente caracter en la cadena
     *
     * @return string Caracter
     */
    private function read()
    {
        if($this->cache == null)
        {
            if(empty($this->in))
            {
                $c = '';
                $this->in = null;
                $this->eof = true;
            }
            else
            {
                $c = $this->in[0];
                $this->in = substr($this->in, 1);
            }
            return $c;
        }
        $c = $this->cache;
        $this->cache = null;
        return $c;
    }
    /**
     * Guardar un caracter en la caché
     *
     * @param string $c Caracter
     */
    private function save($c)
    {
        $this->cache = $c;
    }
}
