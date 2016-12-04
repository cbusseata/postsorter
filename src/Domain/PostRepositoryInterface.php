<?php

namespace PostSorter\Domain;

interface PostRepositoryInterface {

    /**
     * @return \PostSorter\Domain\Post []
     */
    public function getAllPosts(): array;


    /**
     * @param \PostSorter\Domain\Post[] $posts
     * @param bool $pkOnly                      optional; whether to save only the primary key
     * @return mixed
     */
    public function savePosts( array $posts, bool $pkOnly = false );

}
