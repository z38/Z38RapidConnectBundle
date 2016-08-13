<?php

namespace Z38\Bundle\RapidConnectBundle\Tests\Jwt;

use Symfony\Bridge\PhpUnit\ClockMock;
use Z38\Bundle\RapidConnectBundle\Jwt\TokenDecoder;
use Z38\Bundle\RapidConnectBundle\Tests\TestCase;

/**
 * @group time-sensitive
 */
class TokenDecoderTest extends TestCase
{
    public function testDecodeValid()
    {
        ClockMock::withClockMock(1471119100);

        $encodedToken = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE0NzExMTkwOTYsIm5iZiI6MTQ3MTExOTAzNiwiZXhwIjoxNDcxMTE5MjE2LCJqdGkiOiJOVWNyTUI4SG5PU1Q0WWFjbU8wVHZxa2JxMGpnWVNLeiIsInR5cCI6ImF1dGhucmVzcG9uc2UiLCJodHRwczovL2FhZi5lZHUuYXUvYXR0cmlidXRlcyI6eyJjbiI6InVzZXJAZXhhbXBsZS5jb20iLCJkaXNwbGF5bmFtZSI6IkJvYiBUZXN0Iiwic3VybmFtZSI6bnVsbCwiZ2l2ZW5uYW1lIjpudWxsLCJtYWlsIjoiYm9iQGV4YW1wbGUuY29tIiwiZWR1cGVyc29uc2NvcGVkYWZmaWxpYXRpb24iOm51bGwsImVkdXBlcnNvbnByaW5jaXBhbG5hbWUiOiJ1c2VybmFtZUBleGFtcGxlLmNvbSIsImVkdXBlcnNvbnRhcmdldGVkaWQiOiJodHRwczovL3JhcGlkLmV4YW1wbGUuY29tIWh0dHBzOi8vdGVzdC5leGFtcGxlLmNvbSFLanBRK1hpUVdvUCs1SmhsajQ5dUtNWERNMG89In0sImlzcyI6Imh0dHBzOi8vcmFwaWQuZXhhbXBsZS5jb20iLCJhdWQiOiJodHRwczovL3Rlc3QuZXhhbXBsZS5jb20iLCJzdWIiOiJodHRwczovL3JhcGlkLmV4YW1wbGUuY29tIWh0dHBzOi8vdGVzdC5leGFtcGxlLmNvbSFLanBRK1hpUVdvUCs1SmhsajQ5dUtNWERNMG89In0.gBYgzlX1qqWjv2UK124BGThov5IcJcsTEh5hn_kk9bo';
        $decoder = new TokenDecoder('https://rapid.example.com', 'https://test.example.com', '123123');

        $token = $decoder->decode($encodedToken);

        $attributes = $token->getClaim('https://aaf.edu.au/attributes');
        $this->assertSame('bob@example.com', $attributes->mail);
        $this->assertSame('https://rapid.example.com!https://test.example.com!KjpQ+XiQWoP+5Jhlj49uKMXDM0o=', $attributes->edupersontargetedid);
    }
}
