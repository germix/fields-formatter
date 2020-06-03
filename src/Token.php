<?php

namespace Germix\FieldsFormatter;

/**
 * Token del analizador léxico para el archivo de configuración de comandos
 *
 * @author Germán Martínez
 *
 */
final class Token
{
    const TOK_EOF = -1;
    const TOK_LEXEME = -2;

    /**
     * @var string|integer Id del token
     */
    private $id;
    /**
     * @var integer Línea donde se encontró el token
     */
    private $line;
    /**
     * @var string Lexema del token
     */
    private $lexeme;

    /**
     * Constructor
     *
     * @param string|integer $id      Id del token
     * @param integer        $line    Línea donde se encontró el token
     * @param string         $lexeme  Lexema del token
     */
    public function __construct($id, $line, $lexeme)
    {
        $this->id = $id;
        $this->line = $line;
        $this->lexeme = $lexeme;
        if($lexeme == null)
        {
            $this->lexeme = $id;
        }
    }

    /**
     * Obtener el id del token
     *
     * @return string|integer Id del token
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * Obtener la línea donde se encontró el token
     *
     * @return integer Línea donde se encontró el token
     */
    public function line()
    {
        return $this->line;
    }

    /**
     * Obtener el lexema del token
     *
     * @return string Lexema del token
     */
    public function lexeme()
    {
        return $this->lexeme;
    }
};
