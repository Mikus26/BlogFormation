<?php

namespace App\Search;

class SearchArticle
{
    public function __construct(
        private ?string $title = null ,
        private ?array $tags = [],
        private ?array $authors = [],
        private int $page = 1,

    )
    {

    }

        /**
         * Get the value of authors
         */ 
        public function getAuthors()
        {
                return $this->authors;
        }

        /**
         * Set the value of authors
         *
         * @return  self
         */ 
        public function setAuthors($authors)
        {
                $this->authors = $authors;

                return $this;
        }

        /**
         * Get the value of tags
         */ 
        public function getTags()
        {
                return $this->tags;
        }

        /**
         * Set the value of tags
         *
         * @return  self
         */ 
        public function setTags($tags)
        {
                $this->tags = $tags;

                return $this;
        }

        /**
         * Get the value of title
         */ 
        public function getTitle()
        {
                return $this->title;
        }

        /**
         * Set the value of title
         *
         * @return  self
         */ 
        public function setTitle($title)
        {
                $this->title = $title;

                return $this;
        }

        /**
         * Get the value of page
         */ 
        public function getPage()
        {
                return $this->page;
        }

        /**
         * Set the value of page
         *
         * @return  self
         */ 
        public function setPage($page)
        {
                $this->page = $page;

                return $this;
        }
}