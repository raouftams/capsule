<?php

return [
    'gallery' => [
        'title' => 'Gallery',
        'description' => 'Discover artworks from the Art Institute of Chicago',
        'search' => 'Search artworks...',
        'empty' => 'No images found...',
        'download' => 'Download image',
        'loading' => 'Loading artworks...',
        'unfavorite' => 'Remove from favorites',
        'add_favorite' => 'Add to favorites',
        'not_found_title' => 'No artworks found',
        'not_found_description' => 'Try adjusting your search or filter to find what you are looking for.',
    ],

    'favorites' => [
        'title' => 'Favorites',
        'description' => 'Your favorite images in one place.',
        'search' => 'Search favorites...',
        'empty' => 'You have not added any favorites yet.',
        'unfavorite' => 'Remove from favorites',
        'download' => 'Download image',
        'added' => 'Added to favorites',
        'removed' => 'Removed from favorites',
        'error' => 'Error processing favorite',
        'deleted_image' => 'Image deleted',
        'not_found_title' => 'No favorites found',
        'not_found_description' => 'Try adjusting your search or filter to find what you are looking for.',
    ],
    
    'user_images' => [
        'title' => 'My Images',
        'singular' => 'Image',
        'plural' => 'Images',
        'breadcrumb' => 'User Images',

        'table' => [
            'title' => 'Title',
            'image' => 'Image',
            'description' => 'Description',
            'uploaded_at' => 'Uploaded At',
            'actions' => 'Actions',
            'empty' => 'No images uploaded yet.',
        ],

        'form' => [
            'title' => 'Title',
            'description' => 'Description',
        ],

        'upload' => [
            'label' => 'Upload Image',
            'placeholder' => 'Drag & drop or browse files',
            'helper' => 'Supported formats: JPG, PNG, GIF',
        ],

        'create' => [
            'title' => 'Add New Image',
            'button' => 'Create Image',
        ],

        'breadcrumbs' => [
            'index' => 'My Images',
            'create' => 'Add New',
            'edit' => 'Edit Image',
        ],
    ],

    'actions' => [
        'edit' => 'Edit',
        'delete' => 'Delete',
        'save' => 'Save',
        'cancel' => 'Cancel',
    ],

    'pagination' => [
        'per_page' => ':count per page',
        'previous' => 'Previous',
        'next' => 'Next',
    ],
];
