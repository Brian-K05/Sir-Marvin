<?php

if (!function_exists('sanitize_input')) {
    /**
     * Sanitize user input to prevent XSS attacks
     *
     * @param string $input
     * @return string
     */
    function sanitize_input($input)
    {
        if (is_array($input)) {
            return array_map('sanitize_input', $input);
        }
        
        // Remove null bytes
        $input = str_replace("\0", '', $input);
        
        // Strip HTML tags and encode special characters
        $input = strip_tags($input);
        
        // Convert special characters to HTML entities
        $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8', false);
        
        return trim($input);
    }
}

if (!function_exists('sanitize_filename')) {
    /**
     * Sanitize filename to prevent directory traversal and other attacks
     *
     * @param string $filename
     * @return string
     */
    function sanitize_filename($filename)
    {
        // Remove path components
        $filename = basename($filename);
        
        // Remove null bytes
        $filename = str_replace("\0", '', $filename);
        
        // Remove dangerous characters
        $filename = preg_replace('/[^a-zA-Z0-9._-]/', '_', $filename);
        
        // Limit length
        $filename = substr($filename, 0, 255);
        
        return $filename;
    }
}

if (!function_exists('validate_file_upload')) {
    /**
     * Validate file upload for security
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param array $allowedMimes
     * @param int $maxSize
     * @return array ['valid' => bool, 'error' => string|null]
     */
    function validate_file_upload($file, $allowedMimes = [], $maxSize = 5120)
    {
        if (!$file || !$file->isValid()) {
            return ['valid' => false, 'error' => 'Invalid file upload.'];
        }
        
        // Check file size (in KB)
        if ($file->getSize() > $maxSize * 1024) {
            return ['valid' => false, 'error' => "File size exceeds maximum allowed size of {$maxSize}KB."];
        }
        
        // Check MIME type
        $mimeType = $file->getMimeType();
        if (!empty($allowedMimes) && !in_array($mimeType, $allowedMimes)) {
            return ['valid' => false, 'error' => 'File type not allowed.'];
        }
        
        // Check file extension matches MIME type
        $extension = strtolower($file->getClientOriginalExtension());
        $allowedExtensions = [
            'pdf' => ['application/pdf'],
            'doc' => ['application/msword'],
            'docx' => ['application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
            'jpg' => ['image/jpeg'],
            'jpeg' => ['image/jpeg'],
            'png' => ['image/png'],
        ];
        
        if (isset($allowedExtensions[$extension])) {
            if (!in_array($mimeType, $allowedExtensions[$extension])) {
                return ['valid' => false, 'error' => 'File extension does not match file type.'];
            }
        }
        
        // Check for malicious content in filename
        $filename = $file->getClientOriginalName();
        if (preg_match('/[<>:"|?*\x00-\x1f]/', $filename)) {
            return ['valid' => false, 'error' => 'Invalid characters in filename.'];
        }
        
        return ['valid' => true, 'error' => null];
    }
}

if (!function_exists('log_security_event')) {
    /**
     * Log security-related events
     *
     * @param string $event
     * @param array $context
     * @return void
     */
    function log_security_event($event, $context = [])
    {
        \Log::warning('Security Event: ' . $event, array_merge([
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'url' => request()->fullUrl(),
            'timestamp' => now()->toDateTimeString(),
        ], $context));
    }
}

