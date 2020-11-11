<?php


namespace App\Service;


class HtmlParser
{

    private $url;
    private $movies;
    private $moviesAsArrays;

    public function __construct(string $url)
    {
        $this->url = $url;
        $this->movies = array();
        $this->moviesAsArrays = array();
    }

    public function getAllMovies(): array
    {
        return $this->movies;
    }

    public function getAllMoviesAsArrays(): array
    {
        return $this->moviesAsArrays;
    }

    public function parseIMDBTop250Movies(): array
    {
        $htmlResponse = $this->curl();
        $mainDivElement = $this->getHtmlElementById($htmlResponse, 'main');
        $tableElement = $this->getFirstTagOccurrence($mainDivElement, 'table');
        $tableRows = $tableElement->getElementsByTagName('tr');

        $allMovies = array();
        $allMoviesAsArrays = array();
        $count = 0;
        foreach ($tableRows as $tableRow) {
            if ($count === 0) // skip the headings row
            {
                $count++;
                continue;
            }
            $rowColumns = $tableRow->getElementsByTagName('td');
            $movie = $this->getMovieDetails($rowColumns);
            $allMovies[] = $movie;
            $allMoviesAsArrays[] = $movie->toMovieArray();


        }


        $this->movies = $allMovies;
        $this->moviesAsArrays = $allMoviesAsArrays;
        return $allMovies;

    }


    public function getMovieDetails(\DOMNodeList $columnList): Movie
    {
        $title = $imageUrl = '';
        $year = 0;
        foreach ($columnList as $column) {
            //$columnElement = $this->cast_e($column);
            $className = $column->getAttribute('class');
            if ($className == 'posterColumn') {
                $imageUrl = $this->getImageUrl($this->getFirstTagOccurrence($column, 'img'));
            }

            if ($className == 'titleColumn') {
                $title = $this->getTitle(($this->getFirstTagOccurrence($column, 'a')));
                $year = $this->getYear(($this->getFirstTagOccurrence($column, 'span')));
            }
        }

        return new Movie($title, $year, $imageUrl);
    }

    private function getImageUrl(\DOMElement $element): string
    {
        return $element->getAttribute('src');
    }

    private function getTitle(\DOMElement $param): string
    {
        return $param->textContent;
    }

    private function getYear(\DOMElement $param): int
    {
        return filter_var($param->textContent, FILTER_SANITIZE_NUMBER_INT);
    }

    public function getHtmlElementById(string $html, string $element): \DOMElement
    {
        $dom = new \DOMDocument();
        $dom->loadHTML($html);

        return $dom->getElementById($element);
    }

    public function getFirstTagOccurrence(\DOMElement $domElement, string $tag): \DOMElement
    {
        $tagsList = $domElement->getElementsByTagName($tag);
        if ($tagsList->count() > 0) {
            return $tagsList->item(0); // first item
        }
        return new \DOMElement('div'); // return a default empty div if tag not found

    }

    public function cast_e(DOMNode $node): DOMElement
    {
        if ($node) {
            if ($node->nodeType === XML_ELEMENT_NODE) {
                return $node;
            }
        }
        return new DOMElement('div');
    }

    public function getChildrenAsElements(\DOMElement $domElement, string $tag): \DOMNodeList
    {
        $tagsList = $domElement->getElementsByTagName($tag);
        if ($tagsList->count() > 0) {
            return $tagsList; // first item
        }
        return new \DOMElement('div'); // return a default empty div if tag not found

    }

    public function curl(string $url = null): string
    {
        $curl = curl_init();
        $url = $url ?: $this->url;
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
        ));

        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);


        curl_close($curl);

        if ($httpcode !== 200) {
            //TODO: Log error and
        }

        return $response;
    }


}
