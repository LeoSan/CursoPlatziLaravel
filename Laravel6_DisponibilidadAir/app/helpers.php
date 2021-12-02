<?php 
if (! function_exists('getClient')) {
    function getClient($request)
    {
        $bearerToken = $request->bearerToken();
        $tokenId = (new \Lcobucci\JWT\Token\Parser(new \Lcobucci\JWT\Encoding\JoseEncoder()))->parse($bearerToken)->claims()->all()['jti'];
        $token = \Laravel\Passport\Token::find($tokenId);
    
        return $token->client->id ?? '';
    }
}