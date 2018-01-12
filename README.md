PHP API library for ICE3X
==========================

Use this library to interface with ICE3X bitcoin exchange with PHP

Visit your ice3x account to generate your public & private keys.

Usage example
--------

`composer require ice3x/ice3x_v2_php`

```
use ice3x\ice3x_v2_php\iceApi as iceApi;
$iceApi = new iceApi("publickey", "privatekey");

API Examples

//Create new order (type can be either buy or sell)
$iceApi->createNewOrder(['type' => 'sell', 'pair_id' => '3', 'amount' => '0.01', 'price' => '210001']);

//Cancel order
$iceApi->cancelOrder('trade_id' => 1409120]);

//Trades information
$iceApi->getPrivateTradeList()
$iceApi->getPrivateTradeInfo(['trade_id' => 1409120]);

//Account balances information
$iceApi->getBalanceList();
$iceApi->getBalanceInfo(['currency_id' => 1]);

//Transaction information
$iceApi->getTransactionList('currency_id' => 1]);
$iceApi->getTransactionInfo('transaction_id' => 1256241]);

//Order information
$iceApi->getOrderList();
$iceApi->getOrderInfo(['order_id' => 701405]);

//Market information
$iceApi->getMarketDepthFull();
$iceApi->getMarketDepthBtcav();
$iceApi->getOrderbookInfo(['pair_id' => 3]);
$iceApi->getCurrencyList();
$iceApi->getPairList();
$iceApi->getPairInfo(['pair_id' => 3]);
$iceApi->getPublicTradeList();
$iceApi->getPublicTradeInfo(['trade_id' => 1408345]);
```