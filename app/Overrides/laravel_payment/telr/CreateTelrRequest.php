<?php

namespace App\Overrides\laravel_payment\telr;


class CreateTelrRequest
{
    public function toArray()
    {
        return [
            'ivp_method' => $this->getMethod(),
            'ivp_framed' => 2,
            'ivp_store' => $this->getStoreId(),
            'ivp_authkey' => $this->getAuthkey(),
            'ivp_cart' => $this->getCartId(),
            'ivp_test' => $this->isTestMode(),
            'ivp_amount' => $this->getAmount(),
            'ivp_currency' => $this->getCurrency(),
            'ivp_desc' => $this->getDesc(),
            'ivp_lang' => $this->getLangCode(),
            'return_auth' => $this->getSuccessURL(),
            'return_can' => $this->getCancelURL(),
            'return_decl' => $this->getDeclinedURL(),
            'bill_fname' => $this->getBillingFirstName(),
            'bill_sname' => $this->getBillingSurName(),
            'bill_addr1' => $this->getBillingAddress1(),
            'bill_addr2' => $this->getBillingAddress2(),
            'bill_city' => $this->getBillingCity(),
            'bill_region' => $this->getBillingRegion(),
            'bill_zip' => $this->getBillingZip(),
            'bill_country' => $this->getBillingCountry(),
            'bill_email' => $this->getBillingEmail(),
        ];
    }
}
