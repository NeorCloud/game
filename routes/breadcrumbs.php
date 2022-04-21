<?php


use Tabuna\Breadcrumbs\Breadcrumbs;
use Tabuna\Breadcrumbs\Trail;

//Settings
Breadcrumbs::for('admin.settings.index', function (Trail $trail) {
    $trail->push(__('Settings Index'), route('admin.settings.index'));
});

Breadcrumbs::for('admin.settings.show', function (Trail $trail, $id) {
    $trail->parent('admin.settings.index')->push(__('Settings Show'), route('admin.settings.show', $id));
});

Breadcrumbs::for('admin.settings.edit', function (Trail $trail, $id) {
    $trail->parent('admin.settings.show', $id)->push(__('Settings Edit'), route('admin.settings.edit', $id));
});

//Files
Breadcrumbs::for('admin.files.index', function (Trail $trail) {
    $trail->push(__('Files Index'), route('admin.files.index'));
});

Breadcrumbs::for('admin.files.show', function (Trail $trail, $id) {
    $trail->parent('admin.files.index')->push(__('Files Show'), route('admin.files.show', $id));
});

Breadcrumbs::for('admin.files.edit', function (Trail $trail, $id) {
    $trail->parent('admin.files.show', $id)->push(__('Files Edit'), route('admin.files.edit', $id));
});

Breadcrumbs::for('admin.files.create', function (Trail $trail) {
    $trail->parent('admin.files.index')->push(__('Files Create'), route('admin.files.create'));
});

//Backups
Breadcrumbs::for('admin.backups.index', function (Trail $trail) {
    $trail->push(__('Databases'), route('admin.backups.index'));
});
