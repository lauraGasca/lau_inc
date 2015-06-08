<?php namespace Incubamas\Managers;

class TagManager extends BaseManager
{
    public function getRules()
    {
        $rules = [
            "tag" => 'required|unique:tags,tag'
        ];
        return $rules;
    }

}