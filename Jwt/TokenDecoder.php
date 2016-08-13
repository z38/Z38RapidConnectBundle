<?php

namespace Z38\Bundle\RapidConnectBundle\Jwt;

use InvalidArgumentException;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\ValidationData;

class TokenDecoder implements TokenDecoderInterface
{
    private $issuer;
    private $audience;
    private $secret;
    private $parser;
    private $signer;

    public function __construct($issuer, $audience, $secret)
    {
        $this->issuer = $issuer;
        $this->audience = $audience;
        $this->secret = $secret;
        $this->parser = new Parser();
        $this->signer = new Sha256();
    }

    public function decode($rawToken)
    {
        $token = $this->parser->parse((string) $rawToken);

        if (!$token->verify($this->signer, $this->secret)) {
            throw new InvalidArgumentException('The token signature is not valid.');
        }

        $constraints = new ValidationData(time());
        $constraints->setIssuer($this->issuer);
        $constraints->setAudience($this->audience);

        if (!$token->validate($constraints)) {
            throw new InvalidArgumentException('The token is not valid.');
        }

        return $token;
    }
}
