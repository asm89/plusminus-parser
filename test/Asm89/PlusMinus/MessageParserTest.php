<?php

namespace Asm89\PlusMinus;

use PHPUnit\Framework\TestCase;

class MessageParserTest extends TestCase
{
    private $messageParser;

    public function setUp(): void
    {
        $matchers = [
            new WordMatcher(0),
            new BracketMatcher(1),
        ];
        $this->messageParser = new MessageParser($matchers);
    }

    /**
     * @test
     */
    public function it_parses_a_simple_plus_message()
    {
        $this->assertPlus('asm89', 'asm89++');
    }

    /**
     * @test
     */
    public function it_parses_a_simple_minus_message()
    {
        $this->assertMinus('foo', 'foo--');
    }

    /**
     * @test
     */
    public function it_parses_a_plus_message_with_spaces1()
    {
        $this->assertPlus('iam asm89', '[iam asm89]++');
    }

    /**
     * @test
     */
    public function it_parses_a_minus_message_with_spaces()
    {
        $this->assertMinus('iam foo', '[iam foo]--');
    }

    /**
     * @test
     */
    public function it_parses_the_plus_from_a_sentence()
    {
        $this->assertPlus('asm89', 'i have to say asm89++ to test a sentence');
    }

    /**
     * @test
     */
    public function it_parses_the_minusus_from_a_sentence()
    {
        $this->assertMinus('foo', 'i have to say foo-- to test a sentence');
    }

    /**
     * @test
     */
    public function it_parses_a_plus_message_with_spaces_from_a_sentence()
    {
        $this->assertPlus('iam asm89', 'i have to say [iam asm89]++ to test a sentence');
    }

    /**
     * @test
     */
    public function it_parses_a_minus_message_with_spaces_from_a_sentence()
    {
        $this->assertMinus('iam foo', 'i have to say [iam foo]-- to test a sentence');
    }

    /**
     * @test
     */
    public function it_returns_a_word_if_there_is_no_starting_bracket()
    {
        $this->assertPlus('start]', 'no start]++');
    }

    /**
     * @test
     */
    public function it_plusses_greedy_with_brackets()
    {
        $this->assertPlus('so i put a [ in your [ so you can [ while you []]]]', 'i heard you like [so i put a [ in your [ so you can [ while you []]]]]++ :)');
    }

    /**
     * @test
     * @dataProvider provideInvalidMessages
     */
    public function it_returns_null_on_invalid_messages($message)
    {
        $this->assertNull($this->messageParser->parse($message));
    }

    public function provideInvalidMessages()
    {
        return [
            ['no plus or minus in here'],
            ["heeft die E1379 weer zitten ++'en zeker"],
            ['++'],
            ['++++'],
            ['++++++'],
            ['--'],
            ['----'],
            ['------'],
        ];
    }

    /**
     * @test
     * @dataProvider providePlusSentencesWithMultiples
     */
    public function it_returns_the_first_plus_message_in_the_sentence($expected, $message)
    {
        $this->assertPlus($expected, $message);;
    }

    public function providePlusSentencesWithMultiples()
    {
        return [
            ['asm89', 'i have to say asm89++ and foo++ to test a sentence'],
            ['iam asm89', 'i have to say [iam asm89]++ and foo++ to test a sentence'],
            ['asm89', 'i have to say asm89++ and [iam foo]++ to test a sentence'],
        ];
    }

    /**
     * @test
     * @dataProvider provideMinusSentencesWithMultiples
     */
    public function it_returns_the_first_minus_message_in_the_sentence($expected, $message)
    {
        $this->assertMinus($expected, $message);;
    }

    public function provideMinusSentencesWithMultiples()
    {
        return [
            ['asm89', 'i have to say asm89-- and foo-- to test a sentence'],
            ['iam asm89', 'i have to say [iam asm89]-- and foo-- to test a sentence'],
            ['asm89', 'i have to say asm89-- and [iam foo]-- to test a sentence'],
        ];
    }

    /**
     * @test
     */
    public function it_should_be_able_to_plus_two_square_brackets()
    {
        $this->assertPlus('[]', 'let me []++ this');
    }

    /**
     * @test
     */
    public function it_should_be_able_to_minus_two_square_brackets()
    {
        $this->assertMinus('[]', 'let me []-- this');
    }

    /**
     * @test
     * @dataProvider provideExoticPlusMessages
     */
    public function it_should_parse_exotic_plus_messages($expected, $message)
    {
        $this->assertPlus($expected, $message);
    }

    public function provideExoticPlusMessages()
    {
        return [
            ['(╯°□°）╯︵ ┻━┻', '[(╯°□°）╯︵ ┻━┻]++'],
            ['╯', '╯++'],
            ["grep -o -E '@.+' tblsoll.csv | tr '[A-Z]' '[a-z]' | sort | uniq -c | sort", "[grep -o -E '@.+' tblsoll.csv | tr '[A-Z]' '[a-z]' | sort | uniq -c | sort]++"],
            ['<field name="data" type="json_array" />', '[<field name="data" type="json_array" />]++'],
            ['git commit --amend --reset-author', '[git commit --amend --reset-author]++'],
            ['redis-cli KEYS "prefix:*" | xargs redis-cli DEL', '[redis-cli KEYS "prefix:*" | xargs redis-cli DEL]++'],
            [' ', '[ ]++'],
            [']', '[]]++'],
            ['[', '[[]++'],
            ['[]', '[[]]++'],
            ['++', '[++]++'],
            ['blaat++', '[blaat++]++'],
            ['blaat', 'blaat++++'],
            ['[[asdf]]++[asdf]', '[[[asdf]]++[asdf]]++'],
            ['asdf]++ en [yolo', '[asdf]++ en [yolo]++'],
            ['[[aasdfasdf]++', '[[[aasdfasdf]++]++ asdf++'],
            ['asdf', 'asdf++ [[[aasdfasdf]++]++'],
            ['[aasdfasdf]]]]]]++]]++]]++]', '[[aasdfasdf]]]]]]++]]++]]++]]++'],
            ['asdf', 'asdf++ en [yolo trolo]++'],
            ['foo', 'foo++ '], // utf8 nbsp
            ['asdfasd++ ', '[asdfasd++ ]++'],
            ['asdfasd-- ', '[asdfasd-- ]++'],
            ['asdfasd ', '[asdfasd ]++'],
        ];
    }

    /**
     * @test
     * @dataProvider provideExoticMinusMessages
     */
    public function it_should_parse_exotic_minus_messages($expected, $message)
    {
        $this->assertMinus($expected, $message);
    }


    public function provideExoticMinusMessages()
    {
        return [
            ['(╯°□°）╯︵ ┻━┻', '[(╯°□°）╯︵ ┻━┻]--'],
            ['╯', '╯--'],
            ["grep -o -E '@.+' tblsoll.csv | tr '[A-Z]' '[a-z]' | sort | uniq -c | sort", "[grep -o -E '@.+' tblsoll.csv | tr '[A-Z]' '[a-z]' | sort | uniq -c | sort]--"],
            ['<field name="data" type="json_array" />', '[<field name="data" type="json_array" />]--'],
            ['git commit --amend --reset-author', '[git commit --amend --reset-author]--'],
            ['redis-cli KEYS "prefix:*" | xargs redis-cli DEL', '[redis-cli KEYS "prefix:*" | xargs redis-cli DEL]--'],
            [' ', '[ ]--'],
            [']', '[]]--'],
            ['[', '[[]--'],
            ['[]', '[[]]--'],
            ['blaat--', '[blaat--]--'],
            ['blaat', '[blaat]--'],
            ['[blaat]', '[[blaat]]--'],
            ['blaat', 'blaat----'],
            ['[[asdf]]++[asdf]', '[[[asdf]]++[asdf]]--'],
            ['asdf]-- en [yolo', '[asdf]-- en [yolo]--'],
            ['[[aasdfasdf]++', '[[[aasdfasdf]++]-- asdf--'],
            ['asdf', 'asdf-- [[[aasdfasdf]++]--'],
            ['[aasdfasdf]]]]]]++]]++]]++]', '[[aasdfasdf]]]]]]++]]++]]++]]--'],
            ['asdf', 'asdf-- en [yolo trolo]--'],
            ['foo', 'foo-- '], // utf8 nbsp
            ['asdfasd++ ', '[asdfasd++ ]--'],
            ['asdfasd-- ', '[asdfasd-- ]--'],
            ['asdfasd ', '[asdfasd ]--'],
        ];
    }

    private function assertMinus($expected, $message)
    {
        $item = $this->messageParser->parse($message);

        $this->assertEquals(
            $expected,
            $item->getValue()
        );

        $this->assertTrue($item->isMinus(), 'is a minus');
    }

    private function assertPlus($expected, $message)
    {
        $item = $this->messageParser->parse($message);

        $this->assertEquals(
            $expected,
            $item->getValue()
        );

        $this->assertTrue($item->isPlus(), 'is a plus');
    }
}
