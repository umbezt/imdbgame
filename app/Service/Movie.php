<?php


namespace App\Service;


class Movie
{
    private $yearOfRelease;
    private $title;
    private $imageUrl;

    public function __construct(string $title, int $yearOfRelease, string $imageUrl = null)
    {
        $this->imageUrl = $imageUrl;
        $this->yearOfRelease = $yearOfRelease;
        $this->title = $title;
    }
    public function toMovieArray(): array
    {

        return [
            'title' => $this->title,
            'yearOfRelease' =>$this->yearOfRelease,
            'imageUrl' => $this->imageUrl
        ];
    }
}
