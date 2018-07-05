<?php

namespace Sportic\Omniresult\RaceTec\Tests\Parsers;

use PHPUnit\Framework\TestCase;
use Sportic\Omniresult\Common\Content\GenericContent;
use Sportic\Omniresult\Common\Content\ListContent;
use Sportic\Omniresult\Common\Content\RecordContent;
use Sportic\Omniresult\RaceTec\Scrapers\AbstractScraper;
use Sportic\Omniresult\RaceTec\Parsers\AbstractParser;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class AbstractPageTest
 * @package Sportic\Omniresult\RaceTec\Tests\Scrapers
 */
abstract class AbstractPageTest extends TestCase
{
    protected static $parameters;

    /**
     * @var GenericContent|ListContent|RecordContent
     */
    protected static $parametersParsed;


    /**
     * @param AbstractParser $parser
     * @param AbstractScraper $scrapper
     * @param $fixturePath
     * @return mixed
     */
    public static function initParserFromFixtures($parser, $scrapper, $fixturePath)
    {
        $crawler = new Crawler(null, $scrapper->getCrawlerUri());
        $crawler->addContent(
            file_get_contents(
                TEST_FIXTURE_PATH . DS . 'Parsers' . DS . $fixturePath . '.html'
            ),
            'text/html;charset=utf-8'
        );

        $parser->setScraper($scrapper);
        $parser->setCrawler($crawler);

        $parametersParsed = $parser->getContent();

        return $parametersParsed;

//        file_put_contents(
//            TEST_FIXTURE_PATH . DS . 'Parsers' . DS . static::getSerializedFile(),
//            serialize(self::$parser->getContent()->all())
//        );
    }

    /**
     * @param $fixturePath
     * @return mixed
     */
    public static function getParametersFixtures($fixturePath)
    {
        return unserialize(
            file_get_contents(TEST_FIXTURE_PATH . DS . 'Parsers' . DS . $fixturePath . '.serialized')
        );
    }
}
