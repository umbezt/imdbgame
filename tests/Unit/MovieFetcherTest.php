<?php

namespace Tests\Unit;
use PHPUnit\Framework\TestCase;

class MovieFetcherTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCanFetchMovies()
    {


        libxml_use_internal_errors(true);

        $htmlParser = new \App\Service\HtmlParser("http://www.imdb.com/chart/top?ref_=nb_mv_3_chttp");
        $htmlParser->parseIMDBTop250Movies();
        $movies = $htmlParser->getAllMovies();


        $firstMovieAsArray = $movies[0]->toMovieArray();
        $this->assertEquals(1994, $firstMovieAsArray['yearOfRelease']);
    }

}
