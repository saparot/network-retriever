<?php

namespace Saparot\NetworkRetriever;

class HttpRetrieveResult {

    /**
     * @var string
     */
    private $data;

    /**
     * @var int
     */
    private $httpStatus;

    /**
     * @var string|null
     */
    private $error;

    /**
     * @var int|null
     */
    private $errorNumber;

    /**
     * @var string|null
     */
    private $contentType;

    /**
     * @var array|null
     */
    private $statusData;

    /**
     * HttpRetrieveResult constructor.
     *
     * @param string $data
     * @param int $httpStatus
     * @param string|null $error
     * @param int|null $errorNumber
     * @param string|null $contentType
     * @param array|null $statusData
     */
    function __construct (string $data, int $httpStatus, ?string $error, ?int $errorNumber, ?string $contentType, ?array $statusData) {
        $this->data = $data;
        $this->httpStatus = $httpStatus;
        $this->error = $error;
        $this->errorNumber = $errorNumber;
        $this->contentType = $contentType;
        $this->statusData = $statusData;
    }

    /**
     * @return string|null
     */
    public function getContentType (): ?string {
        return $this->contentType;
    }

    /**
     * @return string
     */
    public function getData (): string {
        return $this->data;
    }

    /**
     * @return int
     */
    public function getHttpStatus (): int {
        return $this->httpStatus;
    }

    /**
     * @return string|null
     */
    public function getError (): ?string {
        return $this->error;
    }

    /**
     * @return int|null
     */
    public function getErrorNumber (): ?int {
        return $this->errorNumber;
    }

    public function getStatusData (): ?array {
        return $this->statusData;
    }

    /**
     * @return array
     */
    function export (): array {
        return [
            'data' => $this->getData(),
            'httpStatus' => $this->getHttpStatus(),
            'error' => $this->getError(),
            'errorNumber' => $this->getErrorNumber(),
            'contentType' => $this->getContentType(),
            'statusData' => $this->getStatusData(),
        ];
    }
}
