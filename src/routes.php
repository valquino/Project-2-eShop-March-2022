<?php

return [
    '' => ['HomeController', 'index',],

    'wishlists' => ['WishlistController', 'index',],
    'wishlists/edit' => ['WishlistController', 'edit', ['id']],
    'wishlists/show' => ['WishlistController', 'show', ['id']],
    'wishlists/add' => ['WishlistController', 'add',],
    'wishlists/delete' => ['WishlistController', 'delete',],

    'invoices' => ['InvoiceController', 'index',],
    'invoices/edit' => ['InvoiceController', 'edit', ['id']],
    'invoices/show' => ['InvoiceController', 'show', ['id']],
    'invoices/add' => ['InvoiceController', 'add',],
    'invoices/delete' => ['InvoiceController', 'delete',],

    'items' => ['ItemController', 'index',],
    'items/edit' => ['ItemController', 'edit', ['id']],
    'items/show' => ['ItemController', 'show', ['id']],
    'items/add' => ['ItemController', 'add',],
    'items/delete' => ['ItemController', 'delete',],

    'comments' => ['CommentController', 'index',],
    'comments/show' => ['CommentController', 'show', ['id']],
    'comments/add' => ['CommentController', 'add',],
    'comments/edit' => ['CommentController', 'edit', ['id']],
    'comments/delete' => ['CommentController', 'delete',],

    'users' => ['UserController', 'index',],
    'users/add' => ['UserController', 'add',],
    'users/show' => ['UserController', 'show', ['id']],
    'users/edit' => ['UserController', 'edit', ['id']],
    'users/delete' => ['UserController', 'delete',],

    'stacks' => ['StackController', 'index',],
    'stacks/edit' => ['StackController', 'edit', ['id']],
    'stacks/show' => ['StackController', 'show', ['id']],
    'stacks/add' => ['StackController', 'add',],
    'stacks/delete' => ['StackController', 'delete',],

    'languages' => ['LanguageController', 'index',],
    'languages/edit' => ['LanguageController', 'edit', ['id']],
    'languages/show' => ['LanguageController', 'show', ['id']],
    'languages/add' => ['LanguageController', 'add',],
    'languages/delete' => ['LanguageController', 'delete',],

    'trainings' => ['TrainingController', 'index',],
    'trainings/edit' => ['TrainingController', 'edit', ['id']],
    'trainings/show' => ['TrainingController', 'show', ['id']],
    'trainings/add' => ['TrainingController', 'add',],
    'trainings/delete' => ['TrainingController', 'delete',],

    'images' => ['ImageController', 'index',],
    'images/edit' => ['ImageController', 'edit', ['id']],
    'images/show' => ['ImageController', 'show', ['id']],
    'images/add' => ['ImageController', 'add',],
    'images/delete' => ['ImageController', 'delete',],
];
