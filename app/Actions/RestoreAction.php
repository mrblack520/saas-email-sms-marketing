<?php

namespace App\Actions;

class RestoreAction extends AbstractAction
{
    public function getTitle()
    {
        // return __('voyager::generic.restore');
    }

    public function getIcon()
    {
        return 'fa-solid fa-trash-undo';
    }

    public function getPolicy()
    {
        return 'restore';
    }

    public function getAttributes()
    {
        return [
            'class'   => '  restore',
            'style' => "font-size:20px;",
            'data-id' => $this->data->{$this->data->getKeyName()},
            'id'      => 'restore-'.$this->data->{$this->data->getKeyName()},
        ];
    }

    public function getDefaultRoute()
    {
        return route('voyager.'.$this->dataType->slug.'.restore', $this->data->{$this->data->getKeyName()});
    }
}
