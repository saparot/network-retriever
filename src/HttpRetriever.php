<?php

namespace Saparot\NetworkRetriever;

class HttpRetriever {

    const OPT_HEADER = CURLOPT_HEADER;
    const OPT_HTTPHEADER = CURLOPT_HTTPHEADER;
    const OPT_CONNECTTIMEOUT = CURLOPT_CONNECTTIMEOUT;
    const OPT_CONNECTTIMEOUT_MS = CURLOPT_CONNECTTIMEOUT_MS;
    const OPT_FOLLOWLOCATION = CURLOPT_FOLLOWLOCATION;
    const OPT_MAXREDIRS = CURLOPT_MAXREDIRS;
    const OPT_PROXY = CURLOPT_PROXY;
    const OPT_HTTPPROXYTUNNEL = CURLOPT_HTTPPROXYTUNNEL;
    const OPT_PROXY_PROXYPORT = CURLOPT_PROXYPORT;
    const OPT_PROXYAUTH = CURLOPT_PROXYAUTH;
    const OPT_PROXYUSERPWD = CURLOPT_PROXYUSERPWD;
    const OPT_USERPWD = CURLOPT_USERPWD;
    const OPT_USER_AGENT = CURLOPT_USERAGENT;
    const OPT_URL = CURLOPT_URL;
    const OPT_PORT = CURLOPT_PORT;
    const OPT_POSTFIELDS = CURLOPT_POSTFIELDS;
    const OPT_HTTPAUTH = CURLOPT_HTTPAUTH;
    const OPT_SSL_VERIFYPEER = CURLOPT_SSL_VERIFYPEER;
    const OPT_CAINFO = CURLOPT_CAINFO;
    const OPT_CAPATH = CURLOPT_CAPATH;
    const OPT_FILE = CURLOPT_FILE;
    const OPT_RETURNTRANSFER = CURLOPT_RETURNTRANSFER;
    const OPT_BUFFERSIZE = CURLOPT_BUFFERSIZE;
    const OPT_TIMEOUT = CURLOPT_TIMEOUT;
    const OPT_TIMEOUT_MS = CURLOPT_TIMEOUT_MS;
    const OPT_SSL_VERIFYHOST = CURLOPT_SSL_VERIFYHOST;
    const OPT_SSL_CIPHER_LIST = CURLOPT_SSL_CIPHER_LIST;
    const OPT_SSLCERT = CURLOPT_SSLCERT;
    const OPT_SSLCERTPASSWD = CURLOPT_SSLCERTPASSWD;
    const OPT_SSLKEY = CURLOPT_SSLKEY;
    const OPT_ENCODING = CURLOPT_ENCODING;
    const OPT_PROTOCOLS = CURLOPT_PROTOCOLS;
    const OPT_RESOLVE = CURLOPT_RESOLVE;
    const OPT_PROGRESSFUNCTION = CURLOPT_PROGRESSFUNCTION;
    const OPT_NOPROGRESS = CURLOPT_NOPROGRESS;
    const OPT_HEADERFUNCTION = CURLOPT_HEADERFUNCTION;
    const OPT_COOKIE_SESSION = CURLOPT_COOKIESESSION;
    const OPT_COOKIE_JAR = CURLOPT_COOKIEJAR;
    const OPT_COOKIE_FILE = CURLOPT_COOKIEFILE;

    /**
     * @var null|int
     */
    private $timeOutMsDefault = 5000;

    /**
     * @var array
     */
    private $optionsConfigured = [];

    protected $optionsSupported = [
        self::OPT_HEADER => CURLOPT_HEADER,
        self::OPT_HTTPHEADER => CURLOPT_HTTPHEADER,
        self::OPT_CONNECTTIMEOUT => CURLOPT_CONNECTTIMEOUT,
        self::OPT_CONNECTTIMEOUT_MS => CURLOPT_CONNECTTIMEOUT_MS,
        self::OPT_FOLLOWLOCATION => CURLOPT_FOLLOWLOCATION,
        self::OPT_MAXREDIRS => CURLOPT_MAXREDIRS,
        self::OPT_PROXY => CURLOPT_PROXY,
        self::OPT_HTTPPROXYTUNNEL => CURLOPT_HTTPPROXYTUNNEL,
        self::OPT_PROXY_PROXYPORT => CURLOPT_PROXYPORT,
        self::OPT_PROXYAUTH => CURLOPT_PROXYAUTH,
        self::OPT_PROXYUSERPWD => CURLOPT_PROXYUSERPWD,
        self::OPT_USERPWD => CURLOPT_USERPWD,
        self::OPT_USER_AGENT => CURLOPT_USERAGENT,
        self::OPT_URL => CURLOPT_URL,
        self::OPT_PORT => CURLOPT_PORT,
        self::OPT_POSTFIELDS => CURLOPT_POSTFIELDS,
        self::OPT_HTTPAUTH => CURLOPT_HTTPAUTH,
        self::OPT_SSL_VERIFYPEER => CURLOPT_SSL_VERIFYPEER,
        self::OPT_CAINFO => CURLOPT_CAINFO,
        self::OPT_CAPATH => CURLOPT_CAPATH,
        self::OPT_FILE => CURLOPT_FILE,
        self::OPT_RETURNTRANSFER => CURLOPT_RETURNTRANSFER,
        self::OPT_BUFFERSIZE => CURLOPT_BUFFERSIZE,
        self::OPT_TIMEOUT => CURLOPT_TIMEOUT,
        self::OPT_TIMEOUT_MS => CURLOPT_TIMEOUT_MS,
        self::OPT_SSL_VERIFYHOST => CURLOPT_SSL_VERIFYHOST,
        self::OPT_SSL_CIPHER_LIST => CURLOPT_SSL_CIPHER_LIST,
        self::OPT_SSLCERT => CURLOPT_SSLCERT,
        self::OPT_SSLCERTPASSWD => CURLOPT_SSLCERTPASSWD,
        self::OPT_SSLKEY => CURLOPT_SSLKEY,
        self::OPT_ENCODING => CURLOPT_ENCODING,
        self::OPT_PROTOCOLS => CURLOPT_PROTOCOLS,
        self::OPT_RESOLVE => CURLOPT_RESOLVE,
        self::OPT_PROGRESSFUNCTION => CURLOPT_PROGRESSFUNCTION,
        self::OPT_NOPROGRESS => CURLOPT_NOPROGRESS,
        self::OPT_HEADERFUNCTION => CURLOPT_HEADERFUNCTION,
        self::OPT_COOKIE_SESSION => CURLOPT_COOKIESESSION,
        self::OPT_COOKIE_JAR => CURLOPT_COOKIEJAR,
        self::OPT_COOKIE_FILE => CURLOPT_COOKIEFILE,
    ];

    private $_curlErrors = [
        1 => 'CURLE_UNSUPPORTED_PROTOCOL',
        2 => 'CURLE_FAILED_INIT',
        3 => 'CURLE_URL_MALFORMAT',
        4 => 'CURLE_URL_MALFORMAT_USER',
        5 => 'CURLE_COULDNT_RESOLVE_PROXY',
        6 => 'CURLE_COULDNT_RESOLVE_HOST',
        7 => 'CURLE_COULDNT_CONNECT',
        8 => 'CURLE_FTP_WEIRD_SERVER_REPLY',
        9 => 'CURLE_REMOTE_ACCESS_DENIED',
        11 => 'CURLE_FTP_WEIRD_PASS_REPLY',
        13 => 'CURLE_FTP_WEIRD_PASV_REPLY',
        14 => 'CURLE_FTP_WEIRD_227_FORMAT',
        15 => 'CURLE_FTP_CANT_GET_HOST',
        17 => 'CURLE_FTP_COULDNT_SET_TYPE',
        18 => 'CURLE_PARTIAL_FILE',
        19 => 'CURLE_FTP_COULDNT_RETR_FILE',
        21 => 'CURLE_QUOTE_ERROR',
        22 => 'CURLE_HTTP_RETURNED_ERROR',
        23 => 'CURLE_WRITE_ERROR',
        25 => 'CURLE_UPLOAD_FAILED',
        26 => 'CURLE_READ_ERROR',
        27 => 'CURLE_OUT_OF_MEMORY',
        28 => 'CURLE_OPERATION_TIMEDOUT',
        30 => 'CURLE_FTP_PORT_FAILED',
        31 => 'CURLE_FTP_COULDNT_USE_REST',
        33 => 'CURLE_RANGE_ERROR',
        34 => 'CURLE_HTTP_POST_ERROR',
        35 => 'CURLE_SSL_CONNECT_ERROR',
        36 => 'CURLE_BAD_DOWNLOAD_RESUME',
        37 => 'CURLE_FILE_COULDNT_READ_FILE',
        38 => 'CURLE_LDAP_CANNOT_BIND',
        39 => 'CURLE_LDAP_SEARCH_FAILED',
        41 => 'CURLE_FUNCTION_NOT_FOUND',
        42 => 'CURLE_ABORTED_BY_CALLBACK',
        43 => 'CURLE_BAD_FUNCTION_ARGUMENT',
        45 => 'CURLE_INTERFACE_FAILED',
        47 => 'CURLE_TOO_MANY_REDIRECTS',
        48 => 'CURLE_UNKNOWN_TELNET_OPTION',
        49 => 'CURLE_TELNET_OPTION_SYNTAX',
        51 => 'CURLE_PEER_FAILED_VERIFICATION',
        52 => 'CURLE_GOT_NOTHING',
        53 => 'CURLE_SSL_ENGINE_NOTFOUND',
        54 => 'CURLE_SSL_ENGINE_SETFAILED',
        55 => 'CURLE_SEND_ERROR',
        56 => 'CURLE_RECV_ERROR',
        58 => 'CURLE_SSL_CERTPROBLEM',
        59 => 'CURLE_SSL_CIPHER',
        60 => 'CURLE_SSL_CACERT',
        61 => 'CURLE_BAD_CONTENT_ENCODING',
        62 => 'CURLE_LDAP_INVALID_URL',
        63 => 'CURLE_FILESIZE_EXCEEDED',
        64 => 'CURLE_USE_SSL_FAILED',
        65 => 'CURLE_SEND_FAIL_REWIND',
        66 => 'CURLE_SSL_ENGINE_INITFAILED',
        67 => 'CURLE_LOGIN_DENIED',
        68 => 'CURLE_TFTP_NOTFOUND',
        69 => 'CURLE_TFTP_PERM',
        70 => 'CURLE_REMOTE_DISK_FULL',
        71 => 'CURLE_TFTP_ILLEGAL',
        72 => 'CURLE_TFTP_UNKNOWNID',
        73 => 'CURLE_REMOTE_FILE_EXISTS',
        74 => 'CURLE_TFTP_NOSUCHUSER',
        75 => 'CURLE_CONV_FAILED',
        76 => 'CURLE_CONV_REQD',
        77 => 'CURLE_SSL_CACERT_BADFILE',
        78 => 'CURLE_REMOTE_FILE_NOT_FOUND',
        79 => 'CURLE_SSH',
        80 => 'CURLE_SSL_SHUTDOWN_FAILED',
        81 => 'CURLE_AGAIN',
        82 => 'CURLE_SSL_CRL_BADFILE',
        83 => 'CURLE_SSL_ISSUER_ERROR',
        84 => 'CURLE_FTP_PRET_FAILED',
        85 => 'CURLE_RTSP_CSEQ_ERROR',
        86 => 'CURLE_RTSP_SESSION_ERROR',
        87 => 'CURLE_FTP_BAD_FILE_LIST',
        88 => 'CURLE_CHUNK_FAILED',
    ];

    /**
     * @param string $url
     *
     * @return false|resource
     * @throws NetworkRetrieverException
     */
    private function createCurl (string $url) {
        if (!$curl = curl_init()) {
            throw new NetworkRetrieverException("failed to init curl");
        }
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT_MS, $this->timeOutMsDefault);
        curl_setopt($curl, CURLOPT_PROTOCOLS, CURLPROTO_HTTP | CURLPROTO_HTTPS);
        curl_setopt($curl, CURLOPT_NOSIGNAL, true);

        return $curl;
    }

    /**
     * @param $curl
     *
     * @return HttpRetrieveResult
     */
    private function retrieve ($curl): HttpRetrieveResult {
        foreach ($this->optionsConfigured as $option => $value) {
            $this->curlSetOpt($curl, $this->optionsSupported[$option], $value);
        }

        $data = curl_exec($curl);

        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $errorNumber = curl_errno($curl);
        $error = ($errorNumber && isset ($this->_curlErrors[$errorNumber])) ? $this->_curlErrors[$errorNumber] : $errorNumber ? 'UNKOWN_ERROR_FROM_CURL' : null;
        $statusData = curl_getinfo($curl);
        $contentType = isset($statusData['content_type']) ? $this->parseContentType($statusData['content_type']) : null;
        curl_close($curl);

        return new HttpRetrieveResult($data, $httpCode, $error, $errorNumber, $contentType, $statusData);
    }

    /**
     * @param $curl
     * @param string $opt
     * @param $val
     *
     * @return $this
     */
    private function curlSetOpt ($curl, string $opt, $val): self {
        curl_setopt($curl, $opt, $val);

        return $this;
    }

    /**
     * @param int $ms
     *
     * @return $this
     * @throws NetworkRetrieverException
     */
    function setTimeOutMsDefault (int $ms): self {
        $this->setOption(self::OPT_TIMEOUT_MS, $ms);

        return $this;
    }

    /**
     * @param string $url
     *
     * @return HttpRetrieveResult
     * @throws NetworkRetrieverException
     */
    function retrieveByGet (string $url): HttpRetrieveResult {
        $curl = $this->createCurl($url);
        $this->curlSetOpt($curl, CURLOPT_HTTPGET, true);

        return $this->retrieve($curl);
    }

    /**
     * @param string $url
     * @param array|null $args
     *
     * @return HttpRetrieveResult
     * @throws NetworkRetrieverException
     */
    function retrieveByPost (string $url, ?array $args): HttpRetrieveResult {
        $curl = $this->createCurl($url);
        $this->curlSetOpt($curl, CURLOPT_POST, true);
        if ($args) {
            $this->setOption(self::OPT_POSTFIELDS, http_build_query($args));
        }

        return $this->retrieve($curl);
    }

    /**
     * @return array
     */
    function getOptions (): array {
        return $this->optionsConfigured;
    }

    /**
     * @param array $options
     *
     * @return $this
     * @throws NetworkRetrieverException
     */
    function setOptions (array $options): self {
        foreach ($options as $opt => $val) {
            $this->setOption($opt, $val);
        }

        return $this;
    }

    /**
     * @param string $option
     * @param $value
     *
     * @return $this
     * @throws NetworkRetrieverException
     */
    function setOption (string $option, $value): self {
        if (!isset($this->optionsSupported[$option])) {
            throw new NetworkRetrieverException("option '{$option} is not supported");
        }
        $this->optionsConfigured[$option] = $value;

        return $this;
    }

    /**
     * @param string $userAgent
     *
     * @return $this
     * @throws NetworkRetrieverException
     */
    function setUserAgent (string $userAgent): self {
        $this->setOption(self::OPT_USER_AGENT, $userAgent);

        return $this;
    }

    /**
     * @param string $contentType
     *
     * @return string
     */
    private function parseContentType (string $contentType): string {
        if ($contentType && preg_match("#;#", $contentType)) {
            $tmp = explode(";", $contentType);
            //we expect that first key is the real contentType
            $contentType = $tmp[0];
        }

        return $contentType;
    }
}
