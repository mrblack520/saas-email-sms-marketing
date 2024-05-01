<?php

namespace App\Actions;
use TCG\Voyager\Actions\AbstractAction;
class ViewAction extends AbstractAction
{
    public function getTitle()
    {
        // return __('voyager::generic.view');
    }

    public function getIcon()
    {
        return 'fa-solid fa-eye';
    }

    public function getPolicy()
    {
        return 'read';
    }

    public function getAttributes()
    {
        return [
            'class' => 'view',
            'style' => "font-size:20px;",

        ];
    }

    public function getDefaultRoute()
    {
        return route('voyager.'.$this->dataType->slug.'.show', $this->data->{$this->data->getKeyName()});
    }
}
