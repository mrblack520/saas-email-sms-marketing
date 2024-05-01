<?php

namespace App\Actions;

class DeleteAction extends AbstractAction
{
    public function getTitle()
    {
        // return __('voyager::generic.delete');
    }

    public function getIcon()
    {
        return 'fa-solid fa-trash' ;
    }

    public function getPolicy()
    {
        return 'delete';
    }

    public function getAttributes()
    {
        return [
            'class'   => 'delete',
            'style' => "font-size:20px;color:red;",
            'data-id' => $this->data->{$this->data->getKeyName()},
            'id'      => 'delete-'.$this->data->{$this->data->getKeyName()},
        ];
    }

    public function getDefaultRoute()
    {
        return 'javascript:;';
    }
}
