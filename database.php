<?php
require_once 'config.php';

class SupabaseClient {
    private $baseUrl;
    private $apiKey;
    private $headers;

    public function __construct($projectRef, $apiKey) {
        $this->baseUrl = "https://{$projectRef}.supabase.co/rest/v1";
        $this->apiKey = $apiKey;
        $this->headers = [
            "apikey: {$apiKey}",
            "Authorization: Bearer {$apiKey}",
            "Content-Type: application/json",
            "Prefer: return=representation"
        ];
    }
    // Executa a requisição cURL
    private function executeCurl($url, $method = 'GET', $data = null) {
        $ch = curl_init($url);
        
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        switch ($method) {
            case 'POST':
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                break;
            case 'PATCH':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                break;
            case 'DELETE':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;
        }

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        if (curl_errno($ch)) {
            throw new Exception('Curl error: ' . curl_error($ch));
        }
        
        curl_close($ch);

        return [
            'status' => $httpCode,
            'body' => json_decode($response, true)
        ];
    }

    // SELECT (Leitura) 
    public function select($table, $columns = '*', $filters = []) {
        $url = "{$this->baseUrl}/{$table}?select={$columns}";
        
        // Add filters
        foreach ($filters as $key => $value) {
            $url .= "&{$key}=eq.{$value}";
        }

        return $this->executeCurl($url);
    }

    // INSERT (Create) Operations
    public function insert($table, $data) {
        $url = "{$this->baseUrl}/{$table}";
        return $this->executeCurl($url, 'POST', $data);
    }

    // UPDATE Operations
    public function update($table, $data, $filters = []) {
        $url = "{$this->baseUrl}/{$table}";
        
        // Add filters to URL
        $filterString = '';
        foreach ($filters as $key => $value) {
            $filterString .= "&{$key}=eq.{$value}";
        }
        
        if (!empty($filterString)) {
            $url .= '?' . ltrim($filterString, '&');
        }

        return $this->executeCurl($url, 'PATCH', $data);
    }

    // DELETE Operations
    public function delete($table, $filters = []) {
        $url = "{$this->baseUrl}/{$table}";
        
        // Add filters to URL
        $filterString = '';
        foreach ($filters as $key => $value) {
            $filterString .= "&{$key}=eq.{$value}";
        }
        
        if (!empty($filterString)) {
            $url .= '?' . ltrim($filterString, '&');
        }

        return $this->executeCurl($url, 'DELETE');
    }
}
