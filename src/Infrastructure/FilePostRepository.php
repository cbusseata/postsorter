<?php

namespace PostSorter\Infrastructure;

use PostSorter\Domain\Post;
use PostSorter\Domain\PostRepositoryInterface;

class FilePostRepository implements PostRepositoryInterface {

    private $handler;
    private $posts = null;

    /**
     * FilePostRepository constructor.
     *
     * @param AbstractFileHandler $handler
     */
    public function __construct( AbstractFileHandler $handler )
    {
        $this->handler = $handler;
    }


    /**
     * @return \PostSorter\Domain\Post []
     */
    public function getAllPosts(): array
    {
        if ( !is_null( $this->posts ) ) return $this->posts;

        $data = $this->handler->loadData();

        $this->posts = [];
        for ( $cv = 0; $cv < count( $data ); $cv++ ) {

            try {
                $this->posts[] = new Post( $data[ $cv ] );
            } catch ( \InvalidArgumentException $e ) {
                echo $e->getMessage() . "\n";
            }

        }

        return $this->posts;
    }


    /**
     * @param \PostSorter\Domain\Post[] $posts
     * @param bool $pkOnly                      optional; whether to save only the primary key
     * @return mixed
     */
    public function savePosts( array $posts, bool $pkOnly = false )
    {
        $data = [];
        foreach( $posts as $post )
        {
            if ( !( $post instanceof Post ) ) {
                throw new \InvalidArgumentException( 'Not a valid Post object!' );
            }

            if ( $pkOnly ) {
                $data[] = [ Post::ID => $post->getID() ];
            } else {
                $data[] = $post->allParams();
            }
        }

        $this->handler->writeData( $data );
    }

}
