<?php

namespace App\Actions;

class EditAction extends AbstractAction
{
    public function getTitle()
    {
        // return __('voyager::generic.edit');
    }

    public function getIcon()
    {
        return 'fa-solid fa-pen';
    }

    public function getPolicy()
    {
        return 'edit';
    }

    public function getAttributes()
    {
        return [
            'style' => "font-size:20px;color:blue;",
            'class' => '  edit',
        ];
    }

    public function getDefaultRoute()
    {
        return route('voyager.'.$this->dataType->slug.'.edit', $this->data->{$this->data->getKeyName()});
    }
}
