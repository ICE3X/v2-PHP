<?php

namespace ice3x\ice3x_v2_php;

class iceApi
{
    private $_publicKey;
    private $_privateKey;

    public function __construct($public, $private)
    {
        $this->_publicKey = trim($public);
        $this->_privateKey = trim($private);
    }

    public function getPublicTradeInfo(array $params = [])
    {
        return $this->get('trade/info', $params);
    }

    public function getPublicTradeList(array $params = [])
    {
        return $this->get('trade/list', $params);
    }

    public function getMarketDepth(array $params = [])
    {
        return $this->get('stats/marketdepth', $params);
    }

    public function getPairInfo(array $params = [])
    {
        return $this->get('pair/info', $params);
    }

    public function getPairList(array $params = [])
    {
        return $this->get('pair/list', $params);
    }

    public function getCurrencyInfo(array $params = [])
    {
        return $this->get('currency/info', $params);
    }

    public function getCurrencyList(array $params = [])
    {
        return $this->get('currency/list', $params);
    }

    public function getOrderbookInfo(array $params = [])
    {
        return $this->get('orderbook/info', $params);
    }

    public function getMarketDepthFull(array $params = [])
    {
        return $this->get('stats/marketdepthfull', $params);
    }

    public function getMarketDepthBtcav(array $params = [])
    {
        return $this->get('stats/marketdepthbtcav', $params);
    }

    public function getInvoiceList(array $params = [])
    {
        return $this->post('invoice/list', $params);
    }

    public function getInvoiceInfo(array $params = [])
    {
        return $this->post('invoice/info', $params);
    }

    public function getInvoicePdf(array $params = [])
    {
        return $this->post('invoice/pdf', $params);
    }

    public function cancelOrder(array $params = [])
    {
        return $this->post('order/cancel', $params);
    }

    public function createNewOrder(array $params = [])
    {
        return $this->post('order/new', $params);
    }

    public function getOrderInfo(array $params = [])
    {
        return $this->post('order/info', $params);
    }

    public function getOrderList(array $params = [])
    {
        return $this->post('order/list', $params);
    }

    public function getTransactionInfo(array $params = [])
    {
        return $this->post('transaction/info', $params);
    }

    public function getTransactionList(array $params = [])
    {
        return $this->post('transaction/list', $params);
    }

    public function getTradeInfo(array $params = [])
    {
        return $this->post('trade/info', $params);
    }

    public function getTradeList(array $params = [])
    {
        return $this->post('trade/list', $params);
    }

    public function getBalanceList(array $params = [])
    {
        return $this->post('balance/list', $params);
    }

    public function getBalanceInfo(array $params = [])
    {
        return $this->post('balance/info', $params);
    }

    private function get($url, array $data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; ICE3X PHP client; '.php_uname('s').'; PHP/'.phpversion().')');
        curl_setopt($ch, CURLOPT_URL, 'https://ice3x.com/api/v1/'.$url.'?'.http_build_query($data));
        $result = curl_exec($ch);

        if ($result === false) {
            throw new Exception('Could not get reply: '.curl_error($ch));
        }
        
        curl_close($ch);

        if (!($result = json_decode($result, true))) {
            switch (json_last_error()) {
            case JSON_ERROR_DEPTH:
                $error = 'Reached the maximum stack depth';
                break;
            case JSON_ERROR_STATE_MISMATCH:
                $error = 'Incorrect discharges or mismatch mode';
                break;
            case JSON_ERROR_CTRL_CHAR:
                $error = 'Incorrect control character';
                break;
            case JSON_ERROR_SYNTAX:
                $error = 'Syntax error or JSON invalid';
                break;
            case JSON_ERROR_UTF8:
                $error = 'Invalid UTF-8 characters, possibly invalid encoding';
                break;
            default:
                $error = 'Unknown error';
            }
            throw new Exception($error);
        }

        return $result;
    }

    private function post($url, array $data)
    {
        $post_data = http_build_query($data);

        $sign = hash_hmac('sha512', $post_data, $this->_privateKey);
        $headers = array("Key: $this->_publicKey", "Sign: $sign");

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; ICE3X PHP client; '.php_uname('s').'; PHP/'.phpversion().')');
        curl_setopt($ch, CURLOPT_URL, 'https://ice3x.com/api/v1/'.$url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);

        curl_close($ch);

        if ($result === false) {
            throw new Exception('Could not get reply: '.curl_error($ch));
        }

        if (!($result = json_decode($result, true))) {
            switch (json_last_error()) {
            case JSON_ERROR_DEPTH:
                $error = 'Reached the maximum stack depth';
                break;
            case JSON_ERROR_STATE_MISMATCH:
                $error = 'Incorrect discharges or mismatch mode';
                break;
            case JSON_ERROR_CTRL_CHAR:
                $error = 'Incorrect control character';
                break;
            case JSON_ERROR_SYNTAX:
                $error = 'Syntax error or JSON invalid';
                break;
            case JSON_ERROR_UTF8:
                $error = 'Invalid UTF-8 characters, possibly invalid encoding';
                break;
            default:
                $error = 'Unknown error';
            }
            throw new Exception($error);
        }

        return $result;
    }
}
