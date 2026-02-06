<?php
// core/helpers_global.php

/**
 * Função helper global para acessar URL_BASE
 */
function url_base($area = 'admin')
{
    return \Core\Helpers::URL_BASE[$area] ?? \Core\Helpers::URL_BASE['admin'];
}

/**
 * Função helper global para sessões
 */
function session($key = null, $value = null)
{
    return \Core\Helpers::session($key, $value);
}