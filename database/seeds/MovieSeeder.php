<?php

use Illuminate\Database\Seeder;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        libxml_use_internal_errors(true);

        $htmlParser = new \App\Service\HtmlParser("http://www.imdb.com/chart/top?ref_=nb_mv_3_chttp");
        $htmlParser->parseIMDBTop250Movies();
        $movies = $htmlParser->getAllMovies();

        foreach ($movies as $movie)
        {

            \App\Movie::create($movie->toMovieArray());
        }

    }
}
