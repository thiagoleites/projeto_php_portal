<?php
/**
 * ===============================================
 * TEMPORARY COMMIT MARKER
 * Branch: lint_tests
 * Date: 2026-02-18
 * Description: Temporary header for CI validation.
 * ===============================================
 */

declare(strict_types=1);

namespace Core;

use Core\View;
use Core\Auth;

abstract class Controller
{
    /**
     * Dados compartilhados com a view
     * @var array
     */
    protected array $data = [];

    /**
     * Configuração padrão para respostas AJAX
     * @var array|string[]
     */
    protected array $ajaxConfig = [
        'contentType' => 'application/json',
        'charset' => 'UTF-8'
    ];

    /**
     * Redireciona para outra URL
     * @param string $url URL para redirecionamento
     */
    protected function redirect(string $url): void
    {
        header("Location: {$url}");
        exit();
    }

    /**
     * Renderiza uma view
     * @param string $view Nome da view (caminho relativo)
     * @param array $data Dados adicionais para a view
     */
    protected function render(string $view, array $data = []): void
    {
        // Combina dados do controller com dados específicos
        $viewData = array_merge($this->data, $data);

        View::render($view, $viewData);
    }

    /**
     * Verifica se o usuário está autenticado
     * @throws \RuntimeException Se não estiver autenticado
     */
    protected function requireAuth(): void
    {
        if (!Auth::check()) {
            $this->redirect('/base/admin/login');
        }
    }

    /**
     * Verifica se o usuário é admin
     * @throws \RuntimeException Se não for admin
     */
    protected function requireAdmin(): void
    {
        $this->requireAuth();

        if (!Auth::isAdmin()) {
            $this->redirect('/base/acesso-negado');
        }
    }

    /**
     * Retorna o usuário logado
     * @return array|null
     */
    protected function user(): ?array
    {
        return Auth::user();
    }

    /**
     * Adiciona um script para ser carregado no layout
     * @param string $script
     */
    protected function addScript(string $script): void
    {
        View::script($script);
    }

    /**
     * MÉTODOS AJAX
     */

    /**
     * Verifica se a requisição é Ajax
     * @return bool
     */
    protected function isAjaxRequest(): bool
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    /**
     * Define os headers para resposta AJAX
     * @param array $headers Headers adicionais
     * @return void
     */
    protected function setAjaxHeaders(array $headers = []): void
    {
        header('Content-Type: ' . $this->ajaxConfig['contentType']);
        header('Charset: ' . $this->ajaxConfig['charset']);

        foreach ($headers as $header => $value) {
            header("{$header}: {$value}");
        }
    }

    /**
     * Envia uma resposta JSON
     * @param array $data Dados para enviar
     * @param int $statusCode Código HTTP
     * @return void
     */
    protected function jsonResponse(array $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        $this->setAjaxHeaders();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    protected function ajaxSuccess($data = null, string $message = 'Operação realizada com sucesso!', int $statusCode = 200): void
    {
        $response = [
            'success' => true,
            'message' => $message,
            'data' => $data,
            'timestamp' => time()
        ];

        $this->jsonResponse($response, $statusCode);
    }

    /**
     * Resposta de erro padrão
     * @param string $message Mensagem de erro
     * @param array $errors Lista de erros de validação
     * @param int $statusCode Código HTTP
     * @return void
     */
    protected function ajaxError(string $message = 'Erro na operação', array $errors = [], int $statusCode = 400): void
    {
        $response = [
            'success' => false,
            'message' => $message,
            'errors' => $errors,
            'timestamp' => time()
        ];

        $this->jsonResponse($response, $statusCode);
    }

    /**
     * Resposta de não autorizado
     * @param string $message
     * @return void
     */
    protected function ajaxUnauthorized(string $message = 'Acesso não autorizado'): void
    {
        $this->ajaxError($message, [], 401);
    }

    /**
     * Resposta de não encontrado
     */

    protected function ajaxNotFound(string $message = 'Recurso não encontrado'): void
    {
        $this->ajaxError($message, [], 404);
    }

    protected function ajaxValidationError(array $errors, string $message = 'Erro de validação'): void
    {
        $this->ajaxError($message, $errors, 422);
    }

    /**
     * Processa upload de arquivo via AJAX
     * @param string $fieldName Nome do campo do arquivo
     * @param array $allowedTypes Tipos MIME permitidos
     * @param int $maxSize Tamanho máximo em bytes
     * @return array Informações do arquivo ou erro
     */
    protected function handleAjaxUpload(string $fieldName, array $allowedTypes = [], int $maxSize = 2097152): array
    {
        if (!isset($_FILES[$fieldName]) || $_FILES[$fieldName]['error'] !== UPLOAD_ERR_OK) {
            return [
                'success' => false,
                'error' => 'Erro no upload do arquivo'
            ];
        }

        $file = $_FILES[$fieldName];

        // Verifica tamanho
        if ($file['size'] > $maxSize) {
            return [
                'success' => false,
                'error' => 'Arquivo muito grande. Tamanho máximo: ' . round($maxSize / 1048576, 2) . 'MB'
            ];
        }

        // Verifica tipo MIME
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!empty($allowedTypes) && !in_array($mime, $allowedTypes)) {
            return [
                'success' => false,
                'error' => 'Tipo de arquivo não permitido'
            ];
        }

        // Gera nome único
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $extension;
        $uploadPath = UPLOAD_PATH . '/' . $filename;

        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            return [
                'success' => true,
                'filename' => $filename,
                'original_name' => $file['name'],
                'size' => $file['size'],
                'mime_type' => $mime,
                'url' => UPLOAD_URL . '/' . $filename
            ];
        }

        return [
            'success' => false,
            'error' => 'Erro ao salvar arquivo'
        ];
    }

    /**
     * Valida dados recebidos via AJAX
     * @param array $data Dados a validar
     * @param array $rules Regras de validação
     * @return array Erros de validação
     */
    protected function validateAjaxData(array $data, array $rules): array
    {
        $errors = [];

        foreach ($rules as $field => $rule) {
            $value = $data[$field] ?? null;
            $rulesArray = explode('|', $rule);

            foreach ($rulesArray as $singleRule) {
                $ruleParts = explode(':', $singleRule);
                $ruleName = $ruleParts[0];
                $ruleValue = $ruleParts[1] ?? null;

                switch ($ruleName) {
                    case 'required':
                        if (empty($value)) {
                            $errors[$field][] = "O campo {$field} é obrigatório";
                        }
                        break;

                    case 'email':
                        if (!empty($value) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                            $errors[$field][] = "O campo {$field} deve ser um email válido";
                        }
                        break;

                    case 'min':
                        if (!empty($value) && strlen($value) < $ruleValue) {
                            $errors[$field][] = "O campo {$field} deve ter no mínimo {$ruleValue} caracteres";
                        }
                        break;

                    case 'max':
                        if (!empty($value) && strlen($value) > $ruleValue) {
                            $errors[$field][] = "O campo {$field} deve ter no máximo {$ruleValue} caracteres";
                        }
                        break;

                    case 'numeric':
                        if (!empty($value) && !is_numeric($value)) {
                            $errors[$field][] = "O campo {$field} deve ser numérico";
                        }
                        break;

                    case 'url':
                        if (!empty($value) && !filter_var($value, FILTER_VALIDATE_URL)) {
                            $errors[$field][] = "O campo {$field} deve ser uma URL válida";
                        }
                        break;
                }
            }
        }

        return $errors;
    }

    /**
     * Obtém dados JSON do corpo da requisição
     * @return array
     */
    protected function getJsonInput(): array
    {
        $input = file_get_contents('php://input');
        $data = json_decode($input, true) ?? [];

        return is_array($data) ? $data : [];
    }

    /**
     * Obtém dados do formulário (POST ou JSON)
     * @return array
     */
    protected function getRequestData(): array
    {
        if ($this->isAjaxRequest() && empty($_POST)) {
            return $this->getJsonInput();
        }

        return $_POST;
    }

    /**
     * Verifica se é uma requisição de pré-voo (OPTIONS)
     * @return bool
     */
    protected function isPreflightRequest(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'OPTIONS' && $this->isAjaxRequest();
    }

    /**
     * Configura CORS para requisições AJAX
     * @param array $allowedOrigins Origens permitidas
     */
    protected function setCorsHeaders(array $allowedOrigins = ['*']): void
    {
        $origin = $_SERVER['HTTP_ORIGIN'] ?? '';

        if (in_array('*', $allowedOrigins) || in_array($origin, $allowedOrigins)) {
            header("Access-Control-Allow-Origin: {$origin}");
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
            header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
            header('Access-Control-Max-Age: 3600');
        }

        if ($this->isPreflightRequest()) {
            exit;
        }
    }
}