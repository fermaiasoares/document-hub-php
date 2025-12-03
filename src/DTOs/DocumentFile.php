<?php
namespace Versatecnologia\DocumentHub\DTOs;

use JsonSerializable;

class DocumentFile implements JsonSerializable
{
    public function __construct(
        protected string $content,
        protected string $contentType,
        protected ?string $filename = null
    ) {}

    /**
     * Retorna o conteúdo binário do arquivo
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * Helper prático para salvar o arquivo no disco
     */
    public function saveTo(string $path): bool
    {
        // Adiciona extensão automaticamente se não tiver
        if (!pathinfo($path, PATHINFO_EXTENSION)) {
            $extension = $this->getExtensionFromMimeType($this->contentType);
            $path .= '.' . $extension;
        }
        
        return file_put_contents($path, $this->content) !== false;
    }

    public function getContentType(): string
    {
        return $this->contentType;
    }

    private function getExtensionFromMimeType($mime): string
    {
        return match ($mime) {
            'application/pdf' => 'pdf',
            'application/vnd.ms-excel' => 'xls',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx',
            'application/msword' => 'doc',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
            default => 'bin',
        };
    }

    public function jsonSerialize(): array
    {
        // Não serializamos o binário para não estourar memória em logs
        return [
            'filename' => $this->filename,
            'mime_type' => $this->contentType,
            'size_in_bytes' => strlen($this->content),
            'extension' => $this->getExtensionFromMimeType($this->contentType)
        ];
    }
}