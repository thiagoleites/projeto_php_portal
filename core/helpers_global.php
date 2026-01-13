<?php

/**
 * ---------------------------------------------------------------------
 * Project: Sistema personalizado em PHP
 * Author: Thiago Leite - Devt Digital
 * License: Proprietary - Todos os direitos reservados
 *
 * Description: Classe responsável pela construção de queries SQL
 * ---------------------------------------------------------------------
 * Copyright © 2025 Devt Digital
 * Thiago Leite <tls@devt.emp.br>
 * ---------------------------------------------------------------------
 */

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